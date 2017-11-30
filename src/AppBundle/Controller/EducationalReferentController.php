<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EducationalReferent;
use AppBundle\Form\Type\EducationalReferentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Educationalreferent controller.
 *
 * @Route("referent-pedagogique")
 */
class EducationalReferentController extends Controller
{
    /**
     * @Route("/", name="referent_pedagogique_index")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function indexAction(Request $request)
    {
        $em                   = $this->getDoctrine()->getManager();
        $educationalReferents = $em->getRepository('AppBundle:EducationalReferent')->findAll();

        $educationalReferent = new Educationalreferent();
        $form                = $this->createForm(EducationalReferentType::class, $educationalReferent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($educationalReferent);
                $em->flush();
                $this->addFlash('success', 'Référent pédagogique ajouté');
            } catch (\Exception $e) {
                dump($e->getMessage());die;
                $this->addFlash('danger', 'Erreur lors de l\'ajout du référent pédagogique');
            }

            return $this->redirectToRoute('referent_pedagogique_index');
        }

        return $this->render('educationalreferent/index.html.twig', [
            'educationalReferents' => $educationalReferents,
            'form'                 => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="referent_pedagogique_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request             $request
     * @param EducationalReferent $educationalReferent
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, EducationalReferent $educationalReferent)
    {
        $form = $this->createForm(EducationalReferentType::class, $educationalReferent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('referent_pedagogique_index');
        }

        return $this->render('educationalreferent/edit.html.twig', [
            'educationalReferent' => $educationalReferent,
            'form'                => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="referent-pedagogique_delete")
     * @Method({"GET", "POST"})
     *
     * @param EducationalReferent $educationalReferent
     *
     * @return RedirectResponse
     * @throws \Exception
     *
     */
    public function deleteAction(EducationalReferent $educationalReferent)
    {

        if (null === $educationalReferent) {
            throw new \Exception('Référent non trouvé');
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($educationalReferent);
            $em->flush();
            $this->addFlash('success', 'Référent pédagogique supprimé');
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Erreur lors de la suppression du référent pédagogique');
        }

        return $this->redirectToRoute('referent_pedagogique_index');
    }
}
