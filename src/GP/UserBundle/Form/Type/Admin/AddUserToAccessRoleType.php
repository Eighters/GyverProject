<?php

namespace GP\UserBundle\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

use GP\CoreBundle\Entity\User;

/**
 * Class AddUserToAccessRoleType
 *
 * Add new user to given access role
 *
 * @package GP\UserBundle\Form\Type\Admin
 */
class AddUserToAccessRoleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('users', EntityType::class, array(
                'class' => 'GP\CoreBundle\Entity\User',
                'choices_as_values' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.lastLogin', 'DESC');
                },
                'choice_label' => function (User $user) {
                    return $user->getFirstName() . ' ' . $user->getLastName();
                },
                'empty_value' => 'Choissez un utilisateur'
            ))
        ;
    }
}
