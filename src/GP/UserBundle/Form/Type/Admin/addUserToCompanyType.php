<?php

namespace GP\UserBundle\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

use GP\CoreBundle\Entity\User;
use GP\CoreBundle\Entity\Company;

/**
 * Class addUserToCompanyType
 *
 * @package GP\UserBundle\Form\Type\Admin
 */
class addUserToCompanyType extends AbstractType
{
    /**
     * @var Company
     */
    private $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

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
//                        ->join('u.companies', 'companies')
                        ->innerJoin('u.companies', 'companies')
//                        ->leftJoin('u.companies', 'companies')
                        ->where('companies <> :company')
                        ->andWhere('u.enabled = 1')
                        ->orderBy('u.lastLogin', 'DESC')
                        ->setParameter('company', $this->company->getId())
                    ;
                },
                'choice_label' => function (User $user) {
                    return $user->getFirstName() . ' ' . $user->getLastName();
                }
            ))
        ;
    }
}


