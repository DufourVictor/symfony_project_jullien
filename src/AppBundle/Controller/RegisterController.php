<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classroom;
use AppBundle\Entity\Register;
use AppBundle\Entity\Student;
use AppBundle\Form\Type\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Register controller.
 *
 * @Route("inscription")
 */
class RegisterController extends Controller
{
    /**
     * @param         $id
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/student/{id}/new", name="register_new")
     *
     * @Method({"GET", "POST"})
     */
    public function newAction($id, Request $request)
    {
        $register = new Register();
        $em       = $this->getDoctrine()->getManager();
        $student  = $em->getRepository(Student::class)->find($id);
        $form     = $this->createForm(RegisterType::class, $register);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $register->setStudent($student);
            $em->persist($register);
            $em->flush();

            return $this->redirectToRoute('student_show', ['id' => $student->getId()]);
        }

        return $this->render('register/new.html.twig', [
            'register' => $register,
            'student'  => $student,
            'form'     => $form->createView(),
        ]);
    }
}
