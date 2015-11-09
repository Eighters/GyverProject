<?php

namespace GyverBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class DataLoader implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Custom data provider for alice. Converts a string to a \DateTime.
     *
     * @param   string      $dateTimeString (ex: "20131023 19:55:00")
     * @return  \DateTime
     */
    public function dateTime($dateTimeString)
    {
        return new \DateTime($dateTimeString);
    }

    public function load(ObjectManager $manager)
    {
        if ($this->container->getParameter('kernel.environment') == 'dev') {
            $files = array(
                __DIR__.'/User.yml',
            );
            Fixtures::load($files, $manager, array('providers' => array($this)));
        }
    }
}
