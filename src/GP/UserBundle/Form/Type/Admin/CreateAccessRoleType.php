<?php

namespace GP\UserBundle\Form\Type\Admin;

use GP\CoreBundle\Entity\AccessRole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

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
            ->add('name', 'text')
            ->add('description', 'textarea')
        ;
    }
}
