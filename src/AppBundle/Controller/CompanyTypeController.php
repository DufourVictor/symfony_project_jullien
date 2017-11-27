<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\CompanyType;
use AppBundle\Entity\Internship;
use AppBundle\Form\Type\CompanyTypeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Company controller.
 *
 * @Route("type-entreprise")
 */
class CompanyTypeController extends Controller
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/new", name="company_type_new")
     *
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em          = $this->getDoctrine()->getManager();
        $companyType = new CompanyType();
        $form        = $this->createForm(CompanyTypeType::class, $companyType);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($companyType);
                $em->flush();
                $this->addFlash('success', 'Type d\'entreprise ajouté avec succès');

                return $this->redirectToRoute('entreprise_index');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur durant l\'ajout du type d\'entreprise');
            }
        }

        return $this->render('company_type/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
