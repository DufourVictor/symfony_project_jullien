<?php

namespace AppBundle\Form;

use AppBundle\Entity\ProfesionnalReferent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('type', EntityType::class, [
                'class' => \AppBundle\Entity\CompanyType::class,
                'choice_label' => 'name',
            ])
            ->add('turnover', MoneyType::class, [
                'label' => 'Chiffre d\'affaire',
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'numéro de téléphone',
            ])
            ->add('profesionnalReferent', EntityType::class, [
                'label' => 'Référent professionnel',
                'class' => ProfesionnalReferent::class,
                'choice_label' => 'fullName',
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Adresse',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Company'
        ));
    }
}
