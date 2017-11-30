<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\CompanyType;
use AppBundle\Entity\ProfesionnalReferent;
use AppBundle\Form\Type\ProfesionnalReferentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Company controller.
 *
 * @Route("referent-professionnel")
 */
class ProfesionnalReferentController extends Controller
{
    /**
     * @Route("/", name="referent_professional_index")
     * @Method("GET")
     *
     * @return Response
     */
    public function indexAction()
    {
        $professionalReferents = $this->getDoctrine()->getRepository(ProfesionnalReferent::class)->findAll();

        return $this->render(':profesionnalReferent:index.html.twig', [
            'professionalReferent' => $professionalReferents,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/new", name="profesionnalReferent_new")
     *
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em                   = $this->getDoctrine()->getManager();
        $profesionnalReferent = new ProfesionnalReferent();
        $form                 = $this->createForm(ProfesionnalReferentType::class, $profesionnalReferent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($profesionnalReferent);
                $em->flush();
                $this->addFlash('success', 'Référent ajouté avec succès');

                return $this->redirectToRoute('referent_professional_index');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur durant l\'ajout du référent');
            }
        }

        return $this->render('profesionnalReferent/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="referent_professional_delete")
     * @Method({"GET", "POST"})
     *
     * @param ProfesionnalReferent $profesionnalReferent
     *
     * @return RedirectResponse
     * @throws \Exception
     *
     */
    public function deleteAction(ProfesionnalReferent $profesionnalReferent)
    {

        if (null === $profesionnalReferent) {
            throw new \Exception('Référent non trouvé');
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($profesionnalReferent);
            $em->flush();
            $this->addFlash('success', 'Référent professionnel supprimé');
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Erreur lors de la suppression du référent professionnel');
        }

        return $this->redirectToRoute('referent_professional_index');
    }
}
