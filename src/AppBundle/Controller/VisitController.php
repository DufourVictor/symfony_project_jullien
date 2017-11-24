<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Internship;
use AppBundle\Entity\Visit;
use AppBundle\Form\VisitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class VisitController
 */
class VisitController extends Controller
{
    /**
     * @param Request $request
     * @param         $id
     *
     * @return RedirectResponse|Response
     *
     * @Route("{id}/visit/new", name="visite_new")
     */
    public function newAction(Request $request, $id)
    {
        $visit = new Visit();
        $em    = $this->getDoctrine()->getManager();
        $form  = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);
        $internship = $em->getRepository(Internship::class)->find($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $visit->setInternship($internship);
            $em->persist($visit);
            $em->flush();

            return $this->redirectToRoute('stage_show', ['id' => $id]);
        }

        return $this->render('visit/new.html.twig', [
            'visit' => $visit,
            'form'  => $form->createView(),
        ]);
    }
}
