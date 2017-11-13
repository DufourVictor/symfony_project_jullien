<?php

namespace AppBundle\Form;

use AppBundle\Entity\Company;
use AppBundle\Entity\EducationalReferent;
use AppBundle\Entity\Internship;
use AppBundle\Entity\ProfesionnalReferent;
use AppBundle\Entity\Promote;
use AppBundle\Entity\Student;
use AppBundle\Entity\Technology;
use AppBundle\Repository\InternshipRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InternshipType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateTimeType::class, [
                'label' => 'Date de début',
                'required' => false,
            ])
            ->add('endDate', DateTimeType::class, [
                'label' => 'Date de début',
                'required' => false,
            ])
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => 'name',
            ])
            ->add('profesionnalReferent', EntityType::class, [
                'class' => ProfesionnalReferent::class,
                'choice_label' => 'firstName',
            ])
            ->add('educationalReferent', EntityType::class, [
                'class' => EducationalReferent::class,
                'choice_label' => 'firstName'
            ])
            ->add('technologies', EntityType::class, [
                'class' => Technology::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ]);
            /*->add('concernYear', ChoiceType::class, [
                'label' => 'Année concercé',
                'multiple' => false,
                'choices' => $options['years'],
            ]);*/
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Internship',
            'years' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_internship';
    }


}
