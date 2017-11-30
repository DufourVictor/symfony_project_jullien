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
     * @Route("/liste", name="company_type_index")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $types = $this->getDoctrine()->getRepository(CompanyType::class)->findAll();

        $companyType = new CompanyType();
        $form        = $this->createForm(CompanyTypeType::class, $companyType);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($companyType);
                $em->flush();
                $this->addFlash('success', 'Type d\'entreprise ajouté avec succès');

                return $this->redirectToRoute('company_type_index');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur durant l\'ajout du type d\'entreprise');
            }
        }

        return $this->render('company_type/index.html.twig', [
            'types' => $types,
            'form'  => $form->createView(),
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
        if (null === $companyType) {
            throw new \Exception('Type de company non trouvé');
        }
        $em   = $this->getDoctrine()->getManager();
        $form = $this->createForm(CompanyTypeType::class, $companyType);
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

    /**
     * @Route("/suppression/{id}", name="company_type_delete")
     * @Method({"GET", "POST"})
     *
     * @param CompanyType $companyType
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function deleteAction(CompanyType $companyType)
    {
        if (null === $companyType) {
            throw new \Exception('Type non trouvé');
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($companyType);
            $em->flush();
            $this->addFlash('success', 'Type d\'entreprise supprimé');
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Erreur lors de la suppression du type d\'entreprise');
        }

        return $this->redirectToRoute('company_type_index');
    }
}
