<?php

namespace GP\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array('disabled' => true))
            ->add('username', 'text', array('disabled' => true))
            ->add('firstName', 'text', array('disabled' => true))
            ->add('lastName', 'text', array('disabled' => true))
            ->add('civility', 'choice', array (
                'choices'   => array (
                    'male' => 'Masculin',
                    'female' => 'Feminin',
                ),
                'multiple' => false,
                'expanded' => true,
                'disabled' => true,
            ))
            ->add('invitation', 'GP\CoreBundle\Form\Type\InvitationFormType', array('disabled' => true));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return 'app_user_registration';
    }
}
