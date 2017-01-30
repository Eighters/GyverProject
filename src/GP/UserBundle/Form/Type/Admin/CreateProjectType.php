<?php

namespace GP\UserBundle\Form\Type\Admin;

use GP\CoreBundle\Entity\Company;
use GP\CoreBundle\Entity\ProjectCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

/**
 * Class CreateProjectType
 *
 * Create new Project
 *
 * @package GP\UserBundle\Form\Type\Admin
 */
class CreateProjectType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('origine', 'text')
            ->add('besoin', 'textarea')
            ->add('description', 'textarea')
            ->add('benefices', 'textarea')
            ->add('beginDate', 'date', array(
                'widget' => 'single_text'
            ))
            ->add('plannedEndDate', 'date', array(
                'widget' => 'single_text'
            ))
            ->add('companies', EntityType::class, array(
                'class' => 'GP\CoreBundle\Entity\Company',
                'choices_as_values' => true,
                'empty_value' => 'Selectionner une entreprise',
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')->orderBy('p.creationDate', 'DESC');
                },
                'choice_label' => function (Company $company) {
                    return $company->getName();
                }
            ))
            ->add('projectCategory', EntityType::class, array(
                'class' => 'GP\CoreBundle\Entity\ProjectCategory',
                'choices_as_values' => true,
                'empty_value' => 'Selectionner un type de projet',
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('pc')
                        ->where('pc.global = :global')
                        ->setParameter('global', true)
                    ;
                },
                'choice_label' => function (ProjectCategory $projectCategory) {
                    return $projectCategory->getName();
                }
            ))
        ;
    }
}
