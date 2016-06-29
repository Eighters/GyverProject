<?php

namespace GP\CoreBundle\Tests;

use Doctrine\ORM\EntityManager;
use GP\CoreBundle\Entity\Project;
use GP\CoreBundle\Entity\User;
use GP\CoreBundle\Entity\Company;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Response;

class BaseTestCase extends WebTestCase
{
    const COMPANY_NAME = 'SFR';
    const COMPANY_TEST_NAME = 'Php Unit Company';

    const PROJECT_NAME = 'Projet Gyver';
    const PROJECT_TEST_NAME = 'Php Unit project';

    const ROLE_COMPANY_NAME = 'role SFR test 1';
    const ROLE_PROJECT_NAME = 'role projet test';
    const ROLE_TEST_NAME = 'role test';

    const USER_ADMIN = 'gyver.project+admin@gmail.com';
    const USER_CHEF_PROJET = 'gyver.project+chef-projet@gmail.com';
    const USER_CONSULTANT = 'gyver.project+consultant@gmail.com';
    const USER_DEVELOPPEUR = 'gyver.project+developpeur@gmail.com';
    const USER_COLLABORATEUR = 'gyver.project+collaborateur@gmail.com';
    const USER_CLIENT = 'gyver.project+client@gmail.com';

    const USER_PASSWORD = 'password';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Use this function to connect to user in the application using HTTP
     *
     * @param $username
     * @param $password
     * @return Client
     */
    protected function connectUser($username, $password)
    {
        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => $username,
            'PHP_AUTH_PW'   => $password,
        ));

        return $this->client;
    }

    /**
     * Use this function to connect to user in the application using login form
     * MORE SLOW, Use connectUser function above instead
     *
     * @param $username
     * @param $password
     * @return Client
     */
    protected function loginUsingFormUser($username, $password)
    {
        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET', '/login');

        $credentials = array(
            '_username'  => $username,
            '_password'  => $password,
        );

        $form = $this->crawler->selectButton('_submit')->form($credentials);

        $this->client->submit($form);

        $this->client->followRedirects();

        return $this->client;
    }

    /**
     * Use this function to quickly dump the http client response html
     *
     * @param Client $client
     */
    protected function debugClientResponse(Client $client)
    {
        return var_dump($client->getResponse()->getContent());
    }

    /**
     * Generate a route
     *
     * @param $routeName
     * @param array $routeParameter
     * @return string
     */
    protected function generateRoute($routeName, Array $routeParameter = array())
    {
        $this->router = $this->getContainer()->get('router');
        return $this->router->generate($routeName, $routeParameter, false);
    }

    /**
     * Assert that client response is a redirection to given Route Name
     *
     * @param Client $client
     * @param $routeName
     * @param array $routeParameter
     * @param $message
     */
    protected function assertRedirectTo(Client $client, $routeName, Array $routeParameter = array(), $message = 'Assert "redirect to route" failed.. :(')
    {
        $redirectUrl = $this->generateRoute($routeName, $routeParameter);
        $this->assertTrue($client->getResponse()->isRedirect($redirectUrl), $message);
    }

    /**
     * Use this function to retrieve a user by this email
     *
     * @param $email
     * @return User
     */
    protected function getUserByEmail($email)
    {
        $this->em = $this->getEntityManager();

        return $this->em->getRepository('GPCoreBundle:User')->findOneByEmail($email);
    }

    /**
     * Use this function to retrieve a company by this name
     *
     * @param $name
     * @return Company
     */
    protected function getCompanyByName($name)
    {
        $this->em = $this->getEntityManager();

        return $this->em->getRepository('GPCoreBundle:Company')->findOneByName($name);
    }

    /**
     * Use this function to retrieve a project by this name
     *
     * @param $name
     * @return Project
     */
    protected function getProjectByName($name)
    {
        $this->em = $this->getEntityManager();

        return $this->em->getRepository('GPCoreBundle:Project')->findOneByName($name);
    }

    /**
     * Use this function to retrieve a role by this name
     *
     * @param $name
     * @return Project
     */
    protected function getRoleByName($name)
    {
        $this->em = $this->getEntityManager();

        return $this->em->getRepository('GPCoreBundle:AccessRole')->findOneByName($name);
    }

    /**
     * Count total of User in db
     */
    protected function getTotalUser()
    {
        $this->em = $this->getEntityManager();

        $qb = $this->em->createQueryBuilder();
        $qb->select('count(user.id)');
        $qb->from('GPCoreBundle:User','user');

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * Count total of Company in db
     */
    protected function getTotalCompany()
    {
        $this->em = $this->getEntityManager();

        $qb = $this->em->createQueryBuilder();
        $qb->select('count(company.id)');
        $qb->from('GPCoreBundle:Company','company');

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * Assert that the given content is present in the html page
     *
     * @param Crawler $crawler
     * @param $content
     * @param string $message
     */
    protected function assertHtmlContains(Crawler $crawler, $content, $message = '')
    {
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("'.$content.'")')->count(),
            $message
        );
    }

    /**
     * Assert that the given content is NOT present in the html page
     *
     * @param Crawler $crawler
     * @param $content
     * @param string $message
     */
    protected function assertHtmlNotContains(Crawler $crawler, $content, $message = '')
    {
        $this->assertEquals(
            0,
            $crawler->filter('html:contains("'.$content.'")')->count(),
            $message
        );
    }

    /**
     * Assert that given content is visible in flash message
     *
     * @param Crawler $crawler
     * @param $content
     * @param string $message
     */
    protected function assertFlashMessageContains(Crawler $crawler, $content, $message = '')
    {
        $this->assertTrue(
            $crawler->filter('.flashMessage:contains("'.$content.'")')->count() > 0,
            $message
        );
    }

    /**
     * Assert that client response is equal to status code
     *
     * @param $expectedStatusCode
     * @param $client
     * @param $message
     */
    protected function assertStatusCode($expectedStatusCode, Client $client, $message = 'The client response don\'t match expected status code.')
    {
        $this->assertEquals($client->getResponse()->getStatusCode(), $expectedStatusCode, $message);
    }

    /**
     * @return mixed
     */
    protected function getContainer()
    {
        return static::$kernel->getContainer();
    }

    /**
     * Get Entity Manager
     *
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        if (!$this->em)
        {
            $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
        }

        return $this->em;
    }

    /**
     * Get Application Name set in parameter.yml
     *
     * @return string
     */
    protected function getApplicationName()
    {
        return ucfirst($this->getContainer()->getParameter('application_name'));
    }
}
