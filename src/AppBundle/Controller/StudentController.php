<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CertificateObtention;
use AppBundle\Entity\Register;
use AppBundle\Entity\Student;
use AppBundle\Form\Type\RegisterSelectorType;
use AppBundle\Form\Type\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Student controller.
 *
 * @Route("student")
 */
class StudentController extends Controller
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/", name="student_index")
     *
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(RegisterSelectorType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                /** @var Student $student */
                $student = $form->getData()->getStudent();
                if (null === $student) {
                    throw new \Exception('Utilisateur non trouvé');
                }

                return $this->redirectToRoute('student_show', ['id' => $student->getId()]);
            } catch (\Exception $e) {
                $this->addFlash('danger', 'L\'élève n\'a pas été trouvé');
            }
        }

        return $this->render('student/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/new", name="student_add")
     *
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $student = new Student();
        $em      = $this->getDoctrine()->getManager();
        $form    = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($student);
                $em->flush();
                $this->addFlash('success', 'Élève ajouté');

                return $this->redirectToRoute('student_show', ['id' => $student->getId()]);
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur durant l\'ajout d\'un élève');
            }
        }

        return $this->render('student/new.html.twig', [
            'student' => $student,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @param Student $student
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     *
     * @Route("/{id}", name="student_show")
     *
     * @Method({"GET", "POST"})
     */
    public function showAction(Student $student, Request $request)
    {
        $em    = $this->getDoctrine()->getManager();
        $class = $em->getRepository(Register::class)->findBy(['student' => $student]);
        if (null === $student) {
            throw new \Exception('Élève non trouvé');
        }
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($student);
                $em->flush();
                $this->addFlash('success', 'Élève modifié');

                return $this->redirectToRoute('student_show', ['id' => $student->getId()]);
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur lors de la modification');
            }
        }

        return $this->render('student/show.html.twig', [
            'student' => $student,
            'class'   => $class,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/suppression", name="student_delete")
     * @Method({"GET","POST"})
     *
     * @param Student $student
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function deleteAction(Student $student)
    {
        if (null === $student) {
            throw new \Exception('Utilisateur non trouvé');
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($student);
            $em->flush();
            $this->addFlash('success', 'Elève supprimé');
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Erreur lors de la suppression');
        }

        return $this->redirectToRoute('student_index');
    }
}
