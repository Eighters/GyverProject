<?php

namespace GP\CoreBundle\Tests;

use Doctrine\ORM\EntityManager;
use GP\CoreBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Response;

class BaseTestCase extends WebTestCase
{

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
     * @param Client $client
     * @param $routeName
     * @param array $routeParameter
     * @return string
     */
    protected function generateRoute(Client $client, $routeName, Array $routeParameter = array())
    {
        return $client->getContainer()->get('router')->generate($routeName, $routeParameter, false);
    }

    /**
     * Assert that client response is a redirection to given Route Name
     *
     * @param Client $client
     * @param $routeName
     * @param array $routeParameter
     * @param $message
     */
    protected function assertRedirectTo(Client $client, $routeName, Array $routeParameter = array(), $message = '')
    {
        $redirectUrl = $this->generateRoute($client, $routeName, $routeParameter);
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
        if (!$this->em) {
            $this->em = $this->getEntityManager();
        }

        return $this->em->getRepository('GPCoreBundle:User')->findOneByEmail($email);
    }

    /**
     * Count Total of user in db
     *
     * @param Client $client
     * @return string
     */
    protected function getTotalUser(Client $client)
    {
        $em = $client->getContainer()->get('doctrine')->getManager();

        $qb = $em->createQueryBuilder();
        $qb->select('count(user.id)');
        $qb->from('GPCoreBundle:User','user');

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
            $crawler->filter("html:contains('$content')")->count(),
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
            $crawler->filter("html:contains('$content')")->count(),
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
            $crawler->filter('.flashMessage:contains('.$content.')')->count() > 0,
            $message
        );
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
        $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
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
