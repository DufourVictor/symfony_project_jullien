<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Company;
use AppBundle\Entity\EducationalReferent;
use AppBundle\Entity\Internship;
use AppBundle\Entity\ProfesionnalReferent;
use AppBundle\Entity\Technology;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        $builder
            ->add('startDate', DateType::class, [
                'label'    => 'form.internship.start_date',
                'required' => false,
                'widget'   => "single_text",
            ])
            ->add('endDate', DateType::class, [
                'label'    => 'form.internship.end_date',
                'required' => false,
                'widget'   => "single_text",
            ])
            ->add('company', EntityType::class, [
                'class'        => Company::class,
                'label'        => 'form.internship.company',
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
                'label'    => 'form.internship.observations',
                'required' => false,
            ])
            ->add('concernYear', TextType::class, [
                'label' => 'form.internship.year_concern',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'AppBundle\Entity\Internship',
            'translation_domain' => 'messages',
        ]);
    }
}
