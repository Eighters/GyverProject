<?php

namespace GP\UserBundle\Tests\Controller;

use GP\CoreBundle\Tests\BaseTestCase;
use GP\CoreBundle\Entity\Company;

/**
 * Unit testing for the Admin company Controller
 *
 * @package GP\UserBundle\Tests\Controller\Admin
 */
class AdminCompanyControllerTest extends BaseTestCase
{
    /**
     * Test only admin can access to company dashboard
     *
     * @dataProvider userProvider
     *
     * @param $userName
     * @param $password
     * @param $expectedStatusCode
     * @param $message
     */
    public function testAccessShowCompaniesAction($userName, $password, $expectedStatusCode, $message)
    {
        $client = $this->connectUser($userName, $password);
        $url = $this->generateRoute('admin_show_all_company');
        $client->request('GET', $url);

        $this->assertEquals($expectedStatusCode, $client->getResponse()->getStatusCode(), $message);
    }

    /**
     * Test only admin can access to company details page
     *
     * @dataProvider userProvider
     *
     * @param $userName
     * @param $password
     * @param $expectedStatusCode
     * @param $message
     */
    public function testAccessShowCompanyAction($userName, $password, $expectedStatusCode, $message)
    {
        $client = $this->connectUser($userName, $password);
        $company = $this->getCompanyByName(BaseTestCase::COMPANY_NAME);

        $url = $this->generateRoute('admin_show_company', array('id' => $company->getId()));
        $client->request('GET', $url);

        $this->assertEquals($expectedStatusCode, $client->getResponse()->getStatusCode(), $message);
    }

    public function userProvider()
    {
        return array (
            array(
                'userName' => 'admin',
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '200',
                'message' => 'An admin User should see the manage company page',
            ),
            array(
                'userName' => 'thibaut',
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '403',
                'message' => 'An NON admin User should NOT see the manage company page',
            ),
        );
    }

    /**
     * Test Error on create company form
     *
     * @dataProvider invalidCreateCompanyProvider
     *
     * @param $data
     * @param $errors
     */
    public function testFailCreateCompany($data, $errors)
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $url = $this->generateRoute('admin_create_company');
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('_submit')->form($data);
        $crawler = $client->submit($form);

        $this->assertHtmlContains($crawler, $errors['name']);
        $this->assertHtmlContains($crawler, $errors['description']);
    }

    public function invalidCreateCompanyProvider()
    {
        return array (
            array(
                'data' => array(
                    'new_company[name]'  => 'b',
                    'new_company[description]'  => 'b'
                ),
                'errors' => array(
                    'name' => "Le nom de l'entreprise doit faire un minimum de 3 caractères",
                    'description' => "La description de l'entreprise doit faire un minimum de 3 caractères"
                )
            ),
            array(
                'data' => array(
                    'new_company[name]'  => str_repeat("a", 256),
                    'new_company[description]'  => str_repeat("a", 5001)
                ),
                'errors' => array(
                    'name' => "Le nom de l'entreprise ne peut excéder 255 caractères",
                    'description' => "La description de l'entreprise ne peut excéder 5000 caractères"
                )
            ),
        );
    }

    /**
     * Test that admin can create a new company
     */
    public function testSuccessCreateCompany()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $originalCompanyNb = $this->getTotalCompany();

        $url = $this->generateRoute('admin_create_company');
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $data = array(
            'new_company[name]'  => BaseTestCase::COMPANY_TEST_NAME,
            'new_company[description]'  => BaseTestCase::COMPANY_TEST_NAME . ' description blablabla'
        );

        $form = $crawler->selectButton('_submit')->form($data);
        $client->submit($form);

        $newCompanyNb = $this->getTotalCompany();
        $this->assertEquals($originalCompanyNb + 1, $newCompanyNb, 'It should create a new Company in db when admin submit valid form');

        $this->assertRedirectTo($client, 'admin_show_all_company');
        $crawler = $client->followRedirect();

        $this->assertFlashMessageContains($crawler, "L'entreprise ".BaseTestCase::COMPANY_TEST_NAME." a été correctement crée");
    }

    /**
     * Test admin can update a given company
     *
     * @depends testSuccessCreateCompany
     */
    public function testUpdateCompany()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $originalCompanyNb = $this->getTotalCompany();

        $initialCompany = $this->getCompanyByName(BaseTestCase::COMPANY_TEST_NAME);

        $url = $this->generateRoute('admin_update_company', array('id' => $initialCompany->getId()));
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $newCompanyName = BaseTestCase::COMPANY_TEST_NAME . ' update';
        $data = array(
            'new_company[name]'  => $newCompanyName,
            'new_company[description]'  => BaseTestCase::COMPANY_TEST_NAME . ' description update'
        );

        $form = $crawler->selectButton('_submit')->form($data);
        $client->submit($form);

        $newCompanyNb = $this->getTotalCompany();
        $this->assertEquals($originalCompanyNb, $newCompanyNb, 'It should not create a new Company in db when admin update company');

        $resultCompany = $this->getCompanyByName($newCompanyName);
        $this->assertNotEquals($initialCompany->getName(), $resultCompany->getName());

        $this->assertRedirectTo($client, 'admin_show_all_company');
        $crawler = $client->followRedirect();

        $this->assertFlashMessageContains($crawler, "L'entreprise ".$newCompanyName." a été correctement mise à jour");

        return $resultCompany;
    }

    /**
     * Test that admin can delete a given company
     *
     * @depends testUpdateCompany
     *
     * @param Company $company
     */
    public function testFailDeleteCompany(Company $company)
    {
        $client = $this->connectUser(self::USER_CHEF_PROJET, self::USER_PASSWORD);

        $url = $this->generateRoute('admin_delete_company', array('id' => $company->getId()));
        $client->request('DELETE', $url);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
     * Test that admin can delete a given company
     *
     * @depends testUpdateCompany
     *
     * @param Company $company
     */
    public function testSuccessDeleteCompany(Company $company)
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $originalCompanyNb = $this->getTotalCompany();

        $url = $this->generateRoute('admin_delete_company', array('id' => $company->getId()));
        $client->request('DELETE', $url);

        $this->assertRedirectTo($client, 'admin_show_all_company', array(), 'admin should be redirect to company dashboard when successfully delete a company');
        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $newCompanyNb = $this->getTotalCompany();
        $this->assertEquals($originalCompanyNb - 1, $newCompanyNb, 'It should delete the given Company in db when admin delete company');

        $this->assertFlashMessageContains($crawler, "L'entreprise ".$company->getName()." a été correctement supprimée");
    }
}
