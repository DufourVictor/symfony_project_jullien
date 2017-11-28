<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Classroom;
use AppBundle\Entity\Register;
use AppBundle\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterSelectorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classroom', EntityType::class, [
                'label'        => 'form.registration_selector.classroom',
                'class'        => Classroom::class,
                'choice_label' => 'name',
                'placeholder'  => 'form.registration_selector.classroom',
            ])
            ->add('student', EntityType::class, [
                'label'        => 'form.registration_selector.student',
                'class'        => Student::class,
                'choice_label' => 'firstName',
                'placeholder'  => 'form.registration_selector.student',
                'required' => false,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Register::class,
            'translation_domain' => 'messages',
        ]);
    }
}
