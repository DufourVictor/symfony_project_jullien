<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Visit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateVisit', DateType::class, [
                'label'  => 'form.visit.date_visit',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'form.visit.comment',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Visit::class,
            'translation_domain' => 'messages',
        ]);
    }
}
