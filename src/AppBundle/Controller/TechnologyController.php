<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Technology;
use AppBundle\Form\Type\TechnologyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Technology controller.
 *
 * @Route("technologie")
 */
class TechnologyController extends Controller
{
    /**
     * @Route("/", name="technologie_index")
     * @Method({"GET","POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function indexAction(Request $request)
    {
        $em           = $this->getDoctrine()->getManager();
        $technologies = $em->getRepository(Technology::class)->findAll();
        $technology   = new Technology();
        $form         = $this->createForm(TechnologyType::class, $technology);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($technology);
                $em->flush();
                $this->addFlash('success', 'Technologie ajoutée');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur lors de l\'ajout');
            }

            return $this->redirectToRoute('technologie_index');
        }

        return $this->render('technology/index.html.twig', [
            'technologies' => $technologies,
            'form'         => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="technologie_delete")
     * @Method({"GET","POST"})
     *
     * @param Technology $technology
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function deleteAction(Technology $technology)
    {
        if (null === $technology) {
            throw new \Exception('technologie non trouvé');
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($technology);
            $em->flush();
            $this->addFlash('success', 'technologie supprimée');
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Erreur lors de la suppression');
        }

        return $this->redirectToRoute('technologie_index');
    }
}
