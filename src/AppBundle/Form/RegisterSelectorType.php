<?php

namespace AppBundle\Form;

use AppBundle\Entity\Classroom;
use AppBundle\Entity\Register;
use AppBundle\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('student', EntityType::class, [
                'label' => 'élèves',
                'class' => Student::class,
                'choice_label' => 'firstName',
            ])
            ->add('classroom', EntityType::class, [
                'label' => 'Classes',
                'class' => Classroom::class,
                'choice_label' => 'name',
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Register::class,
        ));
    }
}
