<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Visit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Visit controller.
 *
 * @Route("visite")
 */
class VisitController extends Controller
{
    /**
     * Lists all visit entities.
     *
     * @Route("/", name="visite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $visits = $em->getRepository('AppBundle:Visit')->findAll();

        return $this->render('visit/index.html.twig', array(
            'visits' => $visits,
        ));
    }

    /**
     * Creates a new visit entity.
     *
     * @Route("/new", name="visite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $visit = new Visit();
        $form = $this->createForm('AppBundle\Form\VisitType', $visit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visit);
            $em->flush();

            return $this->redirectToRoute('visite_show', array('id' => $visit->getId()));
        }

        return $this->render('visit/new.html.twig', array(
            'visit' => $visit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a visit entity.
     *
     * @Route("/{id}", name="visite_show")
     * @Method("GET")
     */
    public function showAction(Visit $visit)
    {
        $deleteForm = $this->createDeleteForm($visit);

        return $this->render('visit/show.html.twig', array(
            'visit' => $visit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing visit entity.
     *
     * @Route("/{id}/edit", name="visite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Visit $visit)
    {
        $deleteForm = $this->createDeleteForm($visit);
        $editForm = $this->createForm('AppBundle\Form\VisitType', $visit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('visite_edit', array('id' => $visit->getId()));
        }

        return $this->render('visit/edit.html.twig', array(
            'visit' => $visit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a visit entity.
     *
     * @Route("/{id}", name="visite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Visit $visit)
    {
        $form = $this->createDeleteForm($visit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($visit);
            $em->flush();
        }

        return $this->redirectToRoute('visite_index');
    }

    /**
     * Creates a form to delete a visit entity.
     *
     * @param Visit $visit The visit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Visit $visit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('visite_delete', array('id' => $visit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
