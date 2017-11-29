<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\ProfesionnalReferent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfesionnalReferentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'form.profesional_referent.mail',
            ])
            ->add('firstName', TextType::class, [
                'label' => 'form.profesional_referent.first_name',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'form.profesional_referent.last_name',
            ])
            ->add('phone', TextType::class, [
                'label' => 'form.profesional_referent.phone_number',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => ProfesionnalReferent::class,
            'translation_domain' => 'messages',
        ]);
    }
}
