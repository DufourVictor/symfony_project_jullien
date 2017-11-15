<?php

namespace AppBundle\Form;

use AppBundle\Entity\Company;
use AppBundle\Entity\EducationalReferent;
use AppBundle\Entity\Internship;
use AppBundle\Entity\ProfesionnalReferent;
use AppBundle\Entity\Promote;
use AppBundle\Entity\Technology;
use AppBundle\Repository\InternshipRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InternshipType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Internship $internship */
        $internship = $options['data'];
        $builder
            ->add('startDate', DateTimeType::class, [
                'label'    => 'Date de début',
                'required' => false,
            ])
            ->add('endDate', DateTimeType::class, [
                'label'    => 'Date de début',
                'required' => false,
            ])
            ->add('company', EntityType::class, [
                'class'        => Company::class,
                'label'        => 'Entreprise',
                'choice_label' => 'name',
            ])
            ->add('profesionnalReferent', EntityType::class, [
                'class'        => ProfesionnalReferent::class,
                'choice_label' => 'firstName',
            ])
            ->add('educationalReferent', EntityType::class, [
                'class'        => EducationalReferent::class,
                'choice_label' => 'firstName',
            ])
            ->add('technologies', EntityType::class, [
                'class'        => Technology::class,
                'choice_label' => 'name',
                'multiple'     => true,
                'expanded'     => false,
                'required'     => false,
            ])
            ->add('comment', TextareaType::class, [
                'label'    => 'Observations',
                'required' => false,
            ])
            ->add('concernYear', EntityType::class, [
                'class'         => Internship::class,
                'label'         => 'Année concernée',
                'multiple'      => false,
                'query_builder' => function (EntityRepository $ir) use ($internship) {
                    return $ir->createQueryBuilder('i')
                        ->select('p.name')
                        ->leftJoin('i.student', 's')
                        ->leftJoin('s.register', 'r')
                        ->leftJoin('r.promote', 'p')
                        ->where('i.student = :student')
                        ->setParameter('student', $internship->getStudent());
                },
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Internship',
        ]);
    }
}
