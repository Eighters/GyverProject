<?php

namespace GP\UserBundle\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class NewCompanyType
 *
 * @package GP\UserBundle\Form\Type\Admin
 */
class NewCompanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'text')
        ;
    }
}


