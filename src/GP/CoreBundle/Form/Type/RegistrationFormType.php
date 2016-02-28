<?php

namespace GP\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('civility', 'choice', array (
                'choices'   => array (
                    'male' => 'Masculin',
                    'female' => 'Feminin',
                ),
                'multiple' => false,
                'expanded' => true,
            ))
            ->add('invitation', 'GP\CoreBundle\Form\Type\InvitationFormType');
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
