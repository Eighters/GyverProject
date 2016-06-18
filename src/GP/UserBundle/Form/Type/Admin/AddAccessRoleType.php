<?php

namespace GP\UserBundle\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class AddAccessRoleType
 *
 * Add new access role to the given Company or Project
 *
 * @package GP\UserBundle\Form\Type\Admin
 */
class AddAccessRoleType extends AbstractType
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
        ;
    }
}
