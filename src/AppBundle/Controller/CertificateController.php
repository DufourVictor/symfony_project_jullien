<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Certificate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Certificate controller.
 *
 * @Route("diplome")
 */
class CertificateController extends Controller
{
    /**
     * Lists all certificate entities.
     *
     * @Route("/", name="diplome_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $certificates = $em->getRepository('AppBundle:Certificate')->findAll();

        return $this->render('certificate/index.html.twig', array(
            'certificates' => $certificates,
        ));
    }

    /**
     * Creates a new certificate entity.
     *
     * @Route("/new", name="diplome_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $certificate = new Certificate();
        $form = $this->createForm('AppBundle\Form\CertificateType', $certificate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($certificate);
            $em->flush();

            return $this->redirectToRoute('diplome_show', array('id' => $certificate->getId()));
        }

        return $this->render('certificate/new.html.twig', array(
            'certificate' => $certificate,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a certificate entity.
     *
     * @Route("/{id}", name="diplome_show")
     * @Method("GET")
     */
    public function showAction(Certificate $certificate)
    {
        $deleteForm = $this->createDeleteForm($certificate);

        return $this->render('certificate/show.html.twig', array(
            'certificate' => $certificate,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing certificate entity.
     *
     * @Route("/{id}/edit", name="diplome_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Certificate $certificate)
    {
        $deleteForm = $this->createDeleteForm($certificate);
        $editForm = $this->createForm('AppBundle\Form\CertificateType', $certificate);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('diplome_edit', array('id' => $certificate->getId()));
        }

        return $this->render('certificate/edit.html.twig', array(
            'certificate' => $certificate,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a certificate entity.
     *
     * @Route("/{id}", name="diplome_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Certificate $certificate)
    {
        $form = $this->createDeleteForm($certificate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($certificate);
            $em->flush();
        }

        return $this->redirectToRoute('diplome_index');
    }

    /**
     * Creates a form to delete a certificate entity.
     *
     * @param Certificate $certificate The certificate entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Certificate $certificate)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('diplome_delete', array('id' => $certificate->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
