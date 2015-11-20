<?php

namespace GyverBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class Form builder for user profile edition
 *
 * @package GyverBundle\Form\Type
 */
class EditUserFormType extends AbstractType
{
    /**
     * Build form creator
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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

    /**
     * Return the builder parent name
     *
     * @return string
     */
    public function getParent()
    {
        return 'fos_user_profile';
    }

    /**
     * Return the parent name
     *
     * @return string
     */
    public function getName()
    {
        return 'app_user_profile_edit';
    }
}
