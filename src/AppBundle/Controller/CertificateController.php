<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Certificate;
use AppBundle\Form\Type\CertificateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Certificate controller.
 *
 * @Route("diplome")
 */
class CertificateController extends Controller
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/", name="diplome_index")
     *
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $certificates = $em->getRepository(Certificate::class)->findAll();
        $certificate  = new Certificate();
        $form         = $this->createForm(CertificateType::class, $certificate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($certificate);
                $em->flush();
                $this->addFlash('success', 'Diplôme ajouté');

                return $this->redirectToRoute('diplome_index');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur durant l\'ajout du diplôme');
            }
        }

        return $this->render('certificate/index.html.twig', [
            'certificates' => $certificates,
            'form'         => $form->createView(),
        ]);
    }

    /**
     * @param Certificate $certificate
     *
     * @return RedirectResponse
     * @throws \Exception
     *
     * @Route("/{id}", name="diplome_delete")
     *
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Certificate $certificate)
    {
        if (null === $certificate) {
            throw new \Exception('Diplome non trouvé');
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($certificate);
            $em->flush();
            $this->addFlash('success', 'Diplôme supprimé');
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Erreur durant la suppression du diplôme');
        }

        return $this->redirectToRoute('diplome_index');
    }
}
