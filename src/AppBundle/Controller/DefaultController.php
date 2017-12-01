<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Certificate;
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

        $nbVisits = count($this->getDoctrine()->getRepository(Visit::class)->findAll());
        $nbStudents = count($this->getDoctrine()->getRepository(Student::class)->findAll());
        $nbCompany = count($this->getDoctrine()->getRepository(Company::class)->findAll());
        $nbTechnologies = count($this->getDoctrine()->getRepository(Technology::class)->findAll());
        $nbInternships = count($this->getDoctrine()->getRepository(Internship::class)->findAll());

        if ($user instanceof EducationalReferent) {
            return $this->render('default/index.html.twig', [
                'nbVisits' => $nbVisits,
                'nbStudents' => $nbStudents,
                'nbCompany' => $nbCompany,
                'nbTechnologies' => $nbTechnologies,
                'nbInternships' => $nbInternships,
            ]);
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
}
