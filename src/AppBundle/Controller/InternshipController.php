<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classroom;
use AppBundle\Entity\Internship;
use AppBundle\Entity\Register;
use AppBundle\Entity\Student;
use AppBundle\Entity\Visit;
use AppBundle\Form\InternshipType;
use AppBundle\Form\RegisterSelectorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Internship controller.
 *
 * @Route("stage")
 */
class InternshipController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/", name="stage_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(RegisterSelectorType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $student = $form->getData()->getStudent();
                return $this->redirectToRoute('stage_list', ['id' => $student->getId()]);
            } catch (\Exception $e) {
                $this->addFlash('danger', 'L\'élève n\'a pas été trouvé');
            }
        }
        return $this->render('internship/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param int $id
     * @return Response
     *
     * @Route("/liste-stages/{id}", name="stage_list")
     */
    public function listAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository(Student::class)->find($id);
        $internships = $em->getRepository(Internship::class)->findStagesForUser($student);

        return $this->render('internship/list.html.twig', [
            'internships' => $internships,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/new", name="stage_new")
     */
    public function newAction(Request $request)
    {
        $internship = new Internship();
        $form = $this->createForm(InternshipType::class, $internship);
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
     * @param Internship $internship
     * @return Response
     *
     * @Route("/{id}", name="stage_show")
     */
    public function showAction(Internship $internship)
    {
        $em = $this->getDoctrine()->getManager();
        $visits = $em->getRepository(Visit::class)->findAll();
        return $this->render('internship/show.html.twig', [
            'internship' => $internship,
        ]);
    }

    /**
     * Displays a form to edit an existing internship entity.
     *
     * @Route("/{id}/edit", name="stage_edit")
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
            ->getForm();
    }
}
