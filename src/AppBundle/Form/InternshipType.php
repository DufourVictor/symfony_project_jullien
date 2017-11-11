<?php

namespace AppBundle\Form;

use AppBundle\Entity\Company;
use AppBundle\Entity\EducationalReferent;
use AppBundle\Entity\ProfesionnalReferent;
use AppBundle\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'choice_label' => 'firstName'
            ])
            ->add('profesionnalReferent', EntityType::class, [
                'class' => ProfesionnalReferent::class,
                'choice_label' => 'firstName',
            ])
            ->add('educationalReferent', EntityType::class, [
                'class' => EducationalReferent::class,
                'choice_label' => 'firstName'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Internship'
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
