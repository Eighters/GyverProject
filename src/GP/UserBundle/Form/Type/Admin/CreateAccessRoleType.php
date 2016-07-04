<?php

namespace GP\UserBundle\Form\Type\Admin;

use GP\CoreBundle\Entity\AccessRole;
use GP\CoreBundle\Entity\Company;
use GP\CoreBundle\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

/**
 * Class CreateAccessRoleType
 *
 * Create new access role
 *
 * @package GP\UserBundle\Form\Type\Admin
 */
class CreateAccessRoleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('type', 'choice', array (
                'choices'   => array (
                    AccessRole::TYPE_COMPANY => 'Entreprise',
                    AccessRole::TYPE_PROJECT => 'Projet',
                ),
                'data' => AccessRole::TYPE_COMPANY,
                'multiple' => false,
                'expanded' => true,
                'required' => true
            ))
            ->add('company', EntityType::class, array(
                'class' => 'GP\CoreBundle\Entity\Company',
                'choices_as_values' => true,
                'empty_value' => AccessRole::COMPANY_PLACEHOLDER,
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')->orderBy('c.creationDate', 'DESC');
                },
                'choice_label' => function (Company $user) {
                    return $user->getName();
                }
            ))
            ->add('project', EntityType::class, array(
                'class' => 'GP\CoreBundle\Entity\Project',
                'choices_as_values' => true,
                'empty_value' => AccessRole::PROJECT_PLACEHOLDER,
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')->orderBy('p.beginDate', 'DESC');
                },
                'choice_label' => function (Project $project) {
                    return $project->getName();
                }
            ))
        ;
    }
}
