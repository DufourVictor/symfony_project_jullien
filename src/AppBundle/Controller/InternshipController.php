<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Internship;
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
     *
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
                if (null === $student) {
                    throw new \Exception('Utilisateur non trouvé');
                }

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
     * @param $id
     *
     * @return Response
     * @throws \Exception
     *
     * @Route("/liste-stages/{id}", name="stage_list")
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
     */
    public function newAction(Request $request, $id)
    {
        $internship  = new Internship();
        $em          = $this->getDoctrine()->getManager();
        $student     = $em->getRepository(Student::class)->find($id);
        $years       = $this->getDoctrine()->getRepository(Internship::class)->findYearPromotionForUser($student);
        $concernYear = [];
        foreach ($years as $key => $value) {
            array_push($concernYear, $value['name']);
        }
        $form = $this->createForm(InternshipType::class, $internship, ['years' => $concernYear]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $internship->setStudent($student);
            $em->persist($internship);
            $em->flush();

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
     * @Route("/{id}", name="stage_show")
     */
    public function showAction(Internship $internship)
    {
        return $this->render('internship/show.html.twig', [
            'internship' => $internship,
        ]);
    }
}
