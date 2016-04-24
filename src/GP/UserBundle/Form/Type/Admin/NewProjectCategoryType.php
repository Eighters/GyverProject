<?php

namespace GP\UserBundle\Form\Type\Admin;

use GP\CoreBundle\Repository\CompanyRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class NewProjectCategoryType
 *
 * @package GP\UserBundle\Form\Type\Admin
 */
class NewProjectCategoryType extends AbstractType
{
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('global', 'choice', array (
                'choices'   => array (
                    true => 'Oui',
                    false => 'Non',
                ),
                'multiple' => false,
                'expanded' => true,
            ))
            ->add('company', EntityType::class, array(
                'class' => 'GP\CoreBundle\Entity\Company',
                'choices_as_values' => true,
                'choice_label' => function ($company) {
                    return $company->getName();
                }
            ))
        ;
    }
}


