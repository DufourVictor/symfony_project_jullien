<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Company;
use AppBundle\Entity\EducationalReferent;
use AppBundle\Entity\Internship;
use AppBundle\Entity\ProfesionnalReferent;
use AppBundle\Entity\Technology;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InternshipType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * InternshipType constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

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
                'format'   => 'dd/MM/yyyy',
            ])
            ->add('endDate', DateType::class, [
                'label'    => 'form.internship.end_date',
                'required' => false,
                'widget'   => "single_text",
                'format' => 'dd/MM/yyyy',
            ])
            ->add('company', EntityType::class, [
                'class'        => Company::class,
                'label'        => 'form.internship.company',
                'choice_label' => 'name',
            ])
            ->add('profesionnalReferent', EntityType::class, [
                'label' => 'form.internship.profesionnal_referent',
                'class'        => ProfesionnalReferent::class,
                'choice_label' => 'firstName',
            ])
            ->add('educationalReferent', EntityType::class, [
                'label'        => 'form.internship.educational_referent',
                'class'        => EducationalReferent::class,
                'choice_label' => 'firstName',
            ])
            ->add('technologies', EntityType::class, [
                'label'                     => 'form.internship.technologies',
                'choice_label'              => 'name',
                'class'                     => Technology::class,
                'multiple'                  => true,
                'required'                  => false,
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
            'data_class'         => Internship::class,
            'translation_domain' => 'messages',
        ]);
    }
}
