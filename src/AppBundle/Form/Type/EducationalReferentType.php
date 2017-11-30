<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\EducationalReferent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EducationalReferentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label'    => 'form.educational_referent.first_name',
                'required' => true,
            ])
            ->add('lastName', TextType::class, [
                'label'    => 'form.educational_referent.last_name',
                'required' => true,
            ])
            ->add('phone', TextType::class, [
                'label'    => 'form.educational_referent.phone_number',
                'required' => true,
            ])
            ->add('username', TextType::class, [
                'label'    => 'form.educational_referent.username',
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label'    => 'form.educational_referent.email',
                'required' => true,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type'           => PasswordType::class,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Vérification'],
                'required'       => false,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => EducationalReferent::class,
            'translation_domain' => 'messages',
        ]);
    }
}
