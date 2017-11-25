<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\ClientFailure;
use AppBundle\Repository\ClientFyailureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\AuthenticationEvents;

class BruteForceListener implements EventSubscriberInterface
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * BruteForce constructor.
     * @param RequestStack $requestStack
     * @param EntityManagerInterface $entityManager
     * @param ContainerInterface $container
     */
    public function __construct(
        RequestStack $requestStack,
        EntityManagerInterface $entityManager,
        ContainerInterface $container
    ) {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->container = $container;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            AuthenticationEvents::AUTHENTICATION_FAILURE => 'onAuthentificationFailure',
            KernelEvents::REQUEST => ['beforeFirewall', 9],
        ];
    }

    /**
     * On authentification failure
     */
    public function onAuthentificationFailure()
    {
        $ip = $this->requestStack->getCurrentRequest()->getClientIp();
        $client = $this->entityManager->getRepository(ClientFailure::class)->findOneBy([
            'ip' => $ip,
        ]);
        if (null === $client) {
            $client = new ClientFailure();
        }

        $client->setIp($ip);
        $client->addNumberOfTentative();
        $client->setDateTentative(new \DateTime());

        if ($client->getNumberOfTentative() > $this->container->getParameter('max_log_fail')) {
            $date = new \DateTime();
            $client->setDateBan($date->add(\DateInterval::createFromDateString($this->container->getParameter('hours_ban'). 'hours')));
        }

        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }

    /**
     * @param GetResponseEvent $event
     */
    public function beforeFirewall(GetResponseEvent $event)
    {
        /** @var ClientFailure $client */
        $client = $this->entityManager->getRepository(ClientFailure::class)->findOneBy([
            'ip' => $event->getRequest()->getClientIp(),
        ]);

        if (null === $client) {
            return;
        }

        $dateDiff = $client->getDateTentative()->diff(new \DateTime());
        if (null !== $dateDiff && $dateDiff->h >= 1) {
            $client->setDateTentative(null);
            $client->setNumberOfTentative(0);
            $this->entityManager->persist($client);
            $this->entityManager->flush();
        }

        if (null !== $client->getDateBan()) {
            if ($client->getDateBan() > new \DateTime()) {
                throw new AccessDeniedException();
            } else {
                $client->setDateBan(null);
                $client->setNumberOfTentative(0);
                $this->entityManager->persist($client);
                $this->entityManager->flush();
            }
        }
    }
}
