<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classroom;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Classroom controller.
 *
 * @Route("classe")
 */
class ClassroomController extends Controller
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/new", name="classe_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $classroom = new Classroom();
        $form      = $this->createForm('AppBundle\Form\Type\ClassroomType', $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();

            return $this->redirectToRoute('classe_show', ['id' => $classroom->getId()]);
        }

        return $this->render('classroom/new.html.twig', [
            'classroom' => $classroom,
            'form'      => $form->createView(),
        ]);
    }

    /**
     * @param Classroom $classroom
     *
     * @return Response
     *
     * @Route("/{id}", name="classe_show")
     * @Method("GET")
     */
    public function showAction(Classroom $classroom)
    {
        $deleteForm = $this->createDeleteForm($classroom);

        return $this->render('classroom/show.html.twig', [
            'classroom'   => $classroom,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * @param Request   $request
     * @param Classroom $classroom
     *
     * @return RedirectResponse|Response
     *
     * @Route("/{id}/edit", name="classe_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Classroom $classroom)
    {
        $deleteForm = $this->createDeleteForm($classroom);
        $editForm   = $this->createForm('AppBundle\Form\Type\ClassroomType', $classroom);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('classe_edit', ['id' => $classroom->getId()]);
        }

        return $this->render('classroom/edit.html.twig', [
            'classroom'   => $classroom,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * @param Classroom $classroom
     *
     * @return RedirectResponse
     * @throws \Exception
     *
     * @Route("/{id}", name="classe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Classroom $classroom)
    {
        if (null === $classroom) {
            throw new \Exception("Classe non trouvé");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($classroom);
        $em->flush();

        return $this->redirectToRoute('classe_index');
    }
}
