<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classroom;
use AppBundle\Form\Type\ClassroomType;
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
     * @return Response
     *
     * @Route("/", name="classe_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $classrooms = $this->getDoctrine()->getRepository(Classroom::class)->findAll();

        return $this->render('classroom/index.html.twig', [
            'classrooms' => $classrooms,
        ]);
    }

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
        $form      = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($classroom);
                $em->flush();
                $this->addFlash('success', 'Classe ajoutée');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur lors de l\ajout de la classe');
            }

            return $this->redirectToRoute('classe_index', ['id' => $classroom->getId()]);
        }

        return $this->render('classroom/new.html.twig', [
            'classroom' => $classroom,
            'form'      => $form->createView(),
        ]);
    }

    /**
     * @param Classroom $classroom
     *
     * @return RedirectResponse
     * @throws \Exception
     *
     * @Route("/{id}", name="classe_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Classroom $classroom)
    {
        if (null === $classroom) {
            throw new \Exception("Classe non trouvé");
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($classroom);
            $em->flush();
            $this->addFlash('success', 'Classe supprimée');
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Erreur lors de la suppression de la classe');
        }

        return $this->redirectToRoute('classe_index');
    }
}
