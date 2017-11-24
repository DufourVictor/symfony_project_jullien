<?php

namespace AppBundle\Form;

use AppBundle\Entity\ProfesionnalReferent;
use AppBundle\Repository\CompanyRepository;
use Doctrine\ORM\EntityRepository;
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
        $company = $options['company'];
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('type', EntityType::class, [
                'class'        => \AppBundle\Entity\CompanyType::class,
                'choice_label' => 'name',
            ])
            ->add('turnover', MoneyType::class, [
                'label' => 'Chiffre d\'affaire',
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'numéro de téléphone',
            ])
            ->add('profesionnalReferent', EntityType::class, [
                'class'         => ProfesionnalReferent::class,
                'label'         => 'Référent professionnel',
                'choice_label'  => 'fullName',
                'multiple'      => true,
                'by_reference'  => false,
                'query_builder' => function (EntityRepository $er) use ($company) {
                    return $er->createQueryBuilder('p')
                        ->where('p.company is NULL')
                        ->orWhere('p.company = :company')
                        ->setParameter('company', $company);
                },
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
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Company',
            'company'    => null,
        ]);
    }
}
