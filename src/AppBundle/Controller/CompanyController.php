<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\CompanyType;
use AppBundle\Entity\Internship;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Company controller.
 *
 * @Route("entreprise")
 */
class CompanyController extends Controller
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/", name="entreprise_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $companies = $em->getRepository(Company::class)->findAll();
        $company   = new Company();
        $form      = $this->createForm('AppBundle\Form\Type\CompanyType', $company);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $companyType = $request->request->get('company')['type'];
            if (!is_numeric($companyType)) {
                $companyType = $this->getDoctrine()->getRepository(CompanyType::class)->findOneBy([
                    'name' => $companyType,
                ]);
            } else {
                $companyType = $this->getDoctrine()->getRepository(CompanyType::class)->find((int)$companyType);
            }

            try {
                $company->setType($companyType);
                $em->persist($company);
                $em->flush();
                $this->addFlash('success', 'Entreprise ajouté avec succès');

                return $this->redirectToRoute('entreprise_index');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur durant l\'ajout d\'une entreprise');
            }
        }

        return $this->render('company/index.html.twig', [
            'companies' => $companies,
            'form'      => $form->createView(),
        ]);
    }

    /**
     * @Route("/add_company_type", name="add_company_type")
     * @Method("POST")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function addCompanyTypeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $companyType = new CompanyType();
        $companyType->setName($request->request->get('data'));

        $em->persist($companyType);
        $em->flush();

        return new JsonResponse();
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return Response
     *
     * @Route("/{id}", name="entreprise_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, $id)
    {
        $em          = $this->getDoctrine()->getManager();
        $company     = $em->getRepository(Company::class)->find($id);
        $internships = $em->getRepository(Internship::class)->findInternshipForCompany($company);
        $form        = $this->createForm('AppBundle\Form\Type\CompanyType', $company, ['company' => $company]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($company);
                $em->flush();
                $this->addFlash('success', 'Entreprise modifié avec succès');

                return $this->redirectToRoute('entreprise_index');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur durant la modification de l\'entreprise');
            }
        }
        return $this->render('company/show.html.twig', [
            'company'    => $company,
            'interships' => $internships,
            'form'       => $form->createView(),
        ]);
    }
}
