<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Promote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Promote controller.
 *
 * @Route("promo")
 */
class PromoteController extends Controller
{
    /**
     * Lists all promote entities.
     *
     * @Route("/", name="promo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $promotes = $em->getRepository('AppBundle:Promote')->findAll();

        return $this->render('promote/index.html.twig', array(
            'promotes' => $promotes,
        ));
    }

    /**
     * Creates a new promote entity.
     *
     * @Route("/new", name="promo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $promote = new Promote();
        $form = $this->createForm('AppBundle\Form\PromoteType', $promote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promote);
            $em->flush();

            return $this->redirectToRoute('promo_show', array('id' => $promote->getId()));
        }

        return $this->render('promote/new.html.twig', array(
            'promote' => $promote,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a promote entity.
     *
     * @Route("/{id}", name="promo_show")
     * @Method("GET")
     */
    public function showAction(Promote $promote)
    {
        $deleteForm = $this->createDeleteForm($promote);

        return $this->render('promote/show.html.twig', array(
            'promote' => $promote,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing promote entity.
     *
     * @Route("/{id}/edit", name="promo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Promote $promote)
    {
        $deleteForm = $this->createDeleteForm($promote);
        $editForm = $this->createForm('AppBundle\Form\PromoteType', $promote);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('promo_edit', array('id' => $promote->getId()));
        }

        return $this->render('promote/edit.html.twig', array(
            'promote' => $promote,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a promote entity.
     *
     * @Route("/{id}", name="promo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Promote $promote)
    {
        $form = $this->createDeleteForm($promote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($promote);
            $em->flush();
        }

        return $this->redirectToRoute('promo_index');
    }

    /**
     * Creates a form to delete a promote entity.
     *
     * @param Promote $promote The promote entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Promote $promote)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('promo_delete', array('id' => $promote->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
