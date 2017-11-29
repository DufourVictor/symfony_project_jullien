<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CompanyType;
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
     * @Route("/new", name="company_type_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
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

    /**
     * @Route("/modification/{id}", name="company_type_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request     $request
     * @param CompanyType $companyType
     *
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function editAction(Request $request, CompanyType $companyType)
    {
        if (null === $companyType){
            throw new \Exception('Type de company non trouvé');
        }
        $em          = $this->getDoctrine()->getManager();
        $form        = $this->createForm(CompanyTypeType::class, $companyType);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($companyType);
                $em->flush();
                $this->addFlash('success', 'Type d\'entreprise modifié avec succès');

                return $this->redirectToRoute('entreprise_index');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur durant l\'édition du type d\'entreprise');
            }
        }

        return $this->render('company_type/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
