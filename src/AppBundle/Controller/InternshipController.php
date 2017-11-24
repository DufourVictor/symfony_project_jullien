<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classroom;
use AppBundle\Entity\Internship;
use AppBundle\Entity\Student;
use AppBundle\Form\Type\InternshipType;
use AppBundle\Form\Type\RegisterSelectorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
     *
     * @return Response
     *
     * @Route("/", name="stage_index")
     *
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(RegisterSelectorType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $student = $form->getData()->getStudent();
                if (null === $student) {
                    throw new \Exception('Utilisateur non trouvé');
                }

                return $this->redirectToRoute('stage_list', ['id' => $student->getId()]);
            } catch (\Exception $e) {
                $this->addFlash('danger', 'flashes.internship.student_not_found');
            }
        }

        return $this->render('internship/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param $id
     *
     * @return Response
     * @throws \Exception
     *
     * @Route("/liste-stages/{id}", name="stage_list")
     *
     * @Method("GET")
     */
    public function listAction($id)
    {
        if (null === $id) {
            throw new \Exception('Utilisateur non trouvé');
        }
        $em          = $this->getDoctrine()->getManager();
        $student     = $em->getRepository(Student::class)->find($id);
        $internships = $em->getRepository(Internship::class)->findStagesForUser($student);

        return $this->render('internship/list.html.twig', [
            'internships' => $internships,
            'student'     => $student,
        ]);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return RedirectResponse|Response
     *
     * @Route("/{id}/new", name="stage_new")
     *
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id)
    {
        $internship = new Internship();
        $em         = $this->getDoctrine()->getManager();
        $student    = $em->getRepository(Student::class)->find($id);
        $internship->setStudent($student);
        $form = $this->createForm(InternshipType::class, $internship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $internship->setStudent($student);
                $em->persist($internship);
                $em->flush();
                $this->addFlash('success', 'stage ajouté avec succès');
            }catch (\Exception $e){
                $this->addFlash('danger', 'Erreur durant l\'ajout du stage');
            }

            return $this->redirectToRoute('stage_show', ['id' => $internship->getId()]);
        }

        return $this->render('internship/new.html.twig', [
            'internship' => $internship,
            'form'       => $form->createView(),
        ]);
    }

    /**
     * @param Internship $internship
     *
     * @return Response
     *
     * @Route("/{id}", name="stage_show", requirements={"id": "\d+"})
     *
     * @Method("GET")
     */
    public function showAction(Internship $internship)
    {
        return $this->render('internship/show.html.twig', [
            'internship' => $internship,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/students", name="students")
     */
    public function studentsAction(Request $request)
    {
        $em = $this->getDoctrine();
        $class = $request->request->get('class');
        $classroom = $em->getRepository(Classroom::class)->findOneBy([
            'name' => $class,
        ]);

        $students = $em->getRepository(Student::class)->getStudentsByClass($classroom->getId());

        return new JsonResponse(['students' => $students]);
    }
}
