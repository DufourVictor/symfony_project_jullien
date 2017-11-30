<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Company;
use AppBundle\Entity\ProfesionnalReferent;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $company = $options['company'];
        $builder
            ->add('name', TextType::class, [
                'label' => 'form.company.name',
            ])
            ->add('type', EntityType::class, [
                'class'        => \AppBundle\Entity\CompanyType::class,
                'choice_label' => 'name',
            ])
            ->add('turnover', NumberType::class, [
                'label' => 'form.company.turnover',
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'form.company.phone_number',
            ])
            ->add('profesionnalReferent', EntityType::class, [
                'class'         => ProfesionnalReferent::class,
                'label'         => 'form.company.profesional_referent',
                'choice_label'  => 'fullName',
                'multiple'      => true,
                'by_reference'  => false,
                'required'      => false,
                'query_builder' => function (EntityRepository $er) use ($company) {
                    return $er->createQueryBuilder('p')
                        ->where('p.company is NULL')
                        ->orWhere('p.company = :company')
                        ->setParameter('company', $company);
                },
            ])
            ->add('address', TextareaType::class, [
                'label' => 'form.company.address',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Company::class,
            'company'            => null,
            'translation_domain' => 'messages',
        ]);
    }
}
