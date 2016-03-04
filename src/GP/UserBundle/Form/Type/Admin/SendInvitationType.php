<?php

namespace GP\UserBundle\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class SendInvitationType
 *
 * @package GP\UserBundle\Form\Type\Admin
 */
class SendInvitationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email')
            ->add('welcomeMessage', TextareaType::class, array(
                'data' => 'Bonjour, je vous invite à vous inscrire sur notre application de gestion de projet',
            ))
        ;
    }
}
