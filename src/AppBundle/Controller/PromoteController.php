<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Promote;
use AppBundle\Form\PromoteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Promote controller.
 *
 * @Route("promo")
 */
class PromoteController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/", name="promo_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $promotes = $em->getRepository(Promote::class)->findBy([], ['id' => 'DESC']);
        $promote = new Promote();
        $form = $this->createForm(PromoteType::class, $promote);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($promote);
                $em->flush();
                $this->addFlash('success', 'Année scolaire ajouté avec succès');
                return $this->redirectToRoute('promo_index');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'erreur durant l\'ajout de d\'une année scolaire');
            }
        }
        return $this->render('promote/index.html.twig', [
            'promotes' => $promotes,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/new", name="promo_new")
     */
    public function newAction(Request $request)
    {
        $promote = new Promote();
        $form = $this->createForm(PromoteType::class, $promote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($promote);
                $em->flush();
                $this->addFlash('success', 'Promotion ajouté');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur durant l\'ajout d\une promotion');
            }

            return $this->redirectToRoute('promo_show', ['id' => $promote->getId()]);
        }

        return $this->render('promote/new.html.twig', [
            'promote' => $promote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Promote $promote
     * @return RedirectResponse
     * @throws \Exception
     *
     * @Route("/{id}", name="promo_delete")
     */
    public function deleteAction(Promote $promote)
    {
        if (null === $promote) {
            throw new \Exception('Cette année n\'existe pas');
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($promote);
            $em->flush();
            $this->addFlash('success', 'Année supprimé avec succes');
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Une erreur est survenu lors de la suppresion de l\année scolaire');
        }

        return $this->redirectToRoute('promo_index');
    }
}
