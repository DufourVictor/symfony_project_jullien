<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Internship;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Internship controller.
 *
 * @Route("stage")
 */
class InternshipController extends Controller
{
    /**
     * Lists all internship entities.
     *
     * @Route("/", name="stage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $internships = $em->getRepository('AppBundle:Internship')->findAll();

        return $this->render('internship/index.html.twig', array(
            'internships' => $internships,
        ));
    }

    /**
     * Creates a new internship entity.
     *
     * @Route("/new", name="stage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $internship = new Internship();
        $form = $this->createForm('AppBundle\Form\InternshipType', $internship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($internship);
            $em->flush();

            return $this->redirectToRoute('stage_show', array('id' => $internship->getId()));
        }

        return $this->render('internship/new.html.twig', array(
            'internship' => $internship,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a internship entity.
     *
     * @Route("/{id}", name="stage_show")
     * @Method("GET")
     */
    public function showAction(Internship $internship)
    {
        $deleteForm = $this->createDeleteForm($internship);

        return $this->render('internship/show.html.twig', array(
            'internship' => $internship,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing internship entity.
     *
     * @Route("/{id}/edit", name="stage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Internship $internship)
    {
        $deleteForm = $this->createDeleteForm($internship);
        $editForm = $this->createForm('AppBundle\Form\InternshipType', $internship);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stage_edit', array('id' => $internship->getId()));
        }

        return $this->render('internship/edit.html.twig', array(
            'internship' => $internship,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a internship entity.
     *
     * @Route("/{id}", name="stage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Internship $internship)
    {
        $form = $this->createDeleteForm($internship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($internship);
            $em->flush();
        }

        return $this->redirectToRoute('stage_index');
    }

    /**
     * Creates a form to delete a internship entity.
     *
     * @param Internship $internship The internship entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Internship $internship)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stage_delete', array('id' => $internship->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
