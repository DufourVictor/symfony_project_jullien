<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EducationalReferent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @return RedirectResponse|Response
     *
     * @Method("GET")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        if ($user instanceof EducationalReferent) {
            return $this->render('default/index.html.twig');
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
}
