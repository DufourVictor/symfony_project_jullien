<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Certificate;
use AppBundle\Entity\CertificateObtention;
use AppBundle\Entity\Company;
use AppBundle\Entity\EducationalReferent;
use AppBundle\Entity\Internship;
use AppBundle\Entity\Student;
use AppBundle\Entity\Technology;
use AppBundle\Entity\Visit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @return RedirectResponse|Response
     *
     * @Method("GET")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if ($user instanceof EducationalReferent) {
            $em             = $this->getDoctrine();
            $nbVisits       = count($em->getRepository(Visit::class)->findAll());
            $nbStudents     = count($em->getRepository(Student::class)->findAll());
            $nbCompany      = count($em->getRepository(Company::class)->findAll());
            $nbTechnologies = count($em->getRepository(Technology::class)->findAll());
            $nbInternships  = count($em->getRepository(Internship::class)->findAll());
            $nbCertificates = count($em->getRepository(CertificateObtention::class)->findAll());

            return $this->render('default/index.html.twig', [
                'nbVisits'       => $nbVisits,
                'nbStudents'     => $nbStudents,
                'nbCompany'      => $nbCompany,
                'nbTechnologies' => $nbTechnologies,
                'nbInternships'  => $nbInternships,
                'nbCertificates' => $nbCertificates,
            ]);
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
}
