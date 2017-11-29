<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Internship;
use AppBundle\Entity\Visit;
use AppBundle\Form\Type\VisitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class VisitController
 */
class VisitController extends Controller
{
    /**
     * @Route("{id}/visit/new", name="visite_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param         $id
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, $id)
    {
        $visit = new Visit();
        $em    = $this->getDoctrine()->getManager();
        $form  = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);
        $internship = $em->getRepository(Internship::class)->find($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $visit->setInternship($internship);
            $em->persist($visit);
            $em->flush();

            return $this->redirectToRoute('stage_show', ['id' => $id]);
        }

        return $this->render('visit/new.html.twig', [
            'visit' => $visit,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @Route("{internship}/visit/edit/{visit}", name="visite_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request    $request
     * @param Visit      $visit
     * @param Internship $internship
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Visit $visit, Internship $internship)
    {
        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($visit);
                $em->flush();
                $this->addFlash('success', 'Visite modifiée');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur lors de la modification');
            }

            return $this->redirectToRoute('stage_show', ['id' => $internship->getId()]);
        }

        return $this->render('visit/edit.html.twig', [
            'form'       => $form->createView(),
            'internship' => $internship,
        ]);
    }

    /**
     * @Route("{internship}/visit/supprimer/{visit}", name="visite_delete")
     * @Method({"GET","POST"})
     *
     * @param Visit      $visit
     * @param Internship $internship
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function deleteAction(Visit $visit, Internship $internship)
    {
        if (null === $visit) {
            throw new \Exception('Visite non trouvée');
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($visit);
            $em->flush();
            $this->addFlash('success', 'Visite modifiée');
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Erreur lors de la modification');
        }

        return $this->redirectToRoute('stage_show', ['id' => $internship->getId()]);
    }
}
