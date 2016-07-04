<?php

namespace GP\CoreBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ProjectValidator extends ConstraintValidator
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function validate($project, Constraint $constraint)
    {
        $existingProject = $this->em->getRepository('GPCoreBundle:Project')->findOneByName($project->getName());
        if ($existingProject) {
            $this->context->addViolationAt(
                'name',
                'Le nom de projet est déja pris',
                array(),
                null
            );
        }

        if (!$project->getCompanies()->first()) {
            $this->context->addViolationAt(
                'companies',
                'Veuillez selectionner une entreprise participante pour le projet',
                array(),
                null
            );
        }

        if (!$project->getProjectCategory()->first()) {
            $this->context->addViolationAt(
                'projectCategory',
                'Veuillez selectionner une catégorie pour le projet',
                array(),
                null
            );
        }

        if ($project->getBeginDate() && $project->getPlannedEndDate()) {
            $beginDate = $project->getBeginDate()->format('Y:m:d h:m:s');
            $plannedEndDate = $project->getPlannedEndDate()->format('Y:m:d h:m:s');

            if ($beginDate === $plannedEndDate) {
                $this->context->addViolationAt(
                    'plannedEndDate',
                    'La date de début et la date de fin du projet ne peuvent être semblables',
                    array(),
                    null
                );
            } else if ($beginDate > $plannedEndDate) {
                $this->context->addViolationAt(
                    'plannedEndDate',
                    'La date de fin du projet doit être antérieure à celle du début',
                    array(),
                    null
                );
            }
        }
    }
}
