<?php

namespace GyverBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EditUserFormType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add("civility", "choice", array(
                "choices" => array(true => "Monsieur", false => "Madame"),
                "expanded" => true,
                "multiple" => false
            ))
            ->add("firstName", "text", array(
                "label" => "Prénom",
                "label_attr" => array("for" => "firstName"),
                "attr" => array("class" => "validate", "id" => "firstName" )
            ))
            ->add("lastName", "text", array(
                "label" => "Nom de famille",
                "label_attr" => array("for" => "lastName"),
                "attr" => array("class" => "validate", "id" => "lastName" )
            ))
            ->add("email", "email", array(
                "label" => "Email",
                "label_attr" => array("for" => "email"),
                "attr" => array("class" => "validate", "id" => "email" )
            ))

        ;
    }

    public function getParent()
    {
        return 'fos_user_profile';
    }

    public function getName()
    {
        return 'app_user_profile_edit';
    }
}