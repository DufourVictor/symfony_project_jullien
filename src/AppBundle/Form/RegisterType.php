<?php

namespace AppBundle\Form;

use AppBundle\Entity\Classroom;
use AppBundle\Entity\Promote;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classroom', EntityType::class, [
                'label' => 'Classe',
                'class' => Classroom::class,
                'choice_label' => 'name',
            ])
            ->add('promote', EntityType::class, [
                'label' => 'Promotion',
                'class' => Promote::class,
                'choice_label' => 'name'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Register'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_register';
    }


}
