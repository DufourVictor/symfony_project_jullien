<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'form.student.first_name',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'form.student.last_name',
            ])
            ->add('address', TextType::class, [
                'label' => 'form.student.address',
            ])
            ->add('email', EmailType::class, [
                'label' => 'form.student.mail',
            ])
            ->add('phone', TextType::class, [
                'label' => 'form.student.phone_number',
            ])
            ->add('certificate', CollectionType::class, [
                'entry_type'   => CertificateObtentionType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference' => false,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Student::class,
            'translation_domain' => 'messages',
        ]);
    }
}
