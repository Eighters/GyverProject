<?php

namespace GP\CoreBundle\Twig;

use GP\CoreBundle\Entity\Project;

class GyverProjectExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('format_project_status', array($this, 'formatProjectStatus')),
        );
    }

    /**
     * Format the project status
     *
     * @param $projectStatus
     * @return string
     */
    public function formatProjectStatus($projectStatus)
    {
        switch ($projectStatus) {
            case $projectStatus == Project::STATUS_PROJECT_REJECTED:
                echo 'Rejeté';
                break;
            case $projectStatus == Project::STATUS_PROJECT_WAITING_VALIDATION:
                echo 'En cours de validation';
                break;
            case $projectStatus == Project::STATUS_PROJECT_ACCEPTED:
                echo 'Accepté';
                break;
            case $projectStatus == Project::STATUS_PROJECT_STARTED:
                echo 'Démarré';
                break;
            case $projectStatus == Project::STATUS_PROJECT_IN_PROGRESS:
                echo 'En cours de réalisation';
                break;
            case $projectStatus == Project::STATUS_PROJECT_FINISHED:
                echo 'Cloturé';
                break;
            case $projectStatus == Project::STATUS_PROJECT_ARCHIVED:
                echo 'Archivé';
                break;
            default:
                echo 'Unknown';
                break;
        }
    }

    public function getName()
    {
        return 'gyver_project_extension';
    }
}
