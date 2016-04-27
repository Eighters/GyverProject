<?php

namespace GP\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

/**
 * Class DataLoader
 *
 * Entity data fixtures loader.
 *
 * @package GyverBundle\DataFixtures\ORM
 */
class DataLoader implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var string
     *
     * The container interface
     */
    private $container;

    /**
     * Container property setter
     * The container interface to set is optional, set to null by default.
     *
     * @param ContainerInterface|null $container
     */
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

    /**
     * Manager loader.
     * Load the correct fixtures file.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        if ($this->container->getParameter('kernel.environment') == 'test' || $this->container->getParameter('kernel.environment') == 'dev') {
            $files = array(
                __DIR__.'/Company.yml',
                __DIR__.'/ProjectCategory.yml',
                __DIR__.'/Project.yml',
                __DIR__.'/AccessRole.yml',
                __DIR__.'/User.yml',
                __DIR__.'/Email.yml',
                __DIR__.'/PhoneNumber.yml',
            );
            Fixtures::load($files, $manager, array('providers' => array($this)));
        }
    }
}
