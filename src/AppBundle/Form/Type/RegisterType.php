<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Classroom;
use AppBundle\Entity\Promote;
use AppBundle\Entity\Register;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classroom', EntityType::class, [
                'label'        => 'form.register.classroom',
                'class'        => Classroom::class,
                'choice_label' => 'name',
            ])
            ->add('promote', EntityType::class, [
                'label'        => 'form.register.promotion',
                'class'        => Promote::class,
                'choice_label' => 'name',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Register::class,
            'translation_domain' => 'messages',
        ]);
    }
}
