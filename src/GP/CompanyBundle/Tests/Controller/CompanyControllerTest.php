<?php

namespace GP\UserBundle\Tests\Controller;

use GP\CoreBundle\Tests\BaseTestCase;

/**
 * Unit testing for the Company Controller
 *
 * @package GP\UserBundle\Tests\Controller\Admin
 */
class CompanyControllerTest extends BaseTestCase
{
    /**
     * Test access to company list dashboard
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
        $url = $this->generateRoute('show_all_companies');
        $client->request('GET', $url);

        $this->assertStatusCode($expectedStatusCode, $client, $message);
    }

    /**
     * Test access to company details page
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

        $url = $this->generateRoute('show_company', array('id' => $company->getId()));
        $client->request('GET', $url);

        $this->assertStatusCode($expectedStatusCode, $client, $message);
    }

    public function userProvider()
    {
        return array (
            array(
                'userName' => self::USER_ADMIN,
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '200',
                'message' => 'An admin User should see every companies pages',
            ),
            array(
                'userName' => self::USER_CLIENT,
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '200',
                'message' => 'A regular user should see companies pages only if he have granted access to',
            ),
        );
    }

    /**
     * Test access to non authorized company details page
     */
    public function testAccessForbiddenShowCompanyAction()
    {
        $client = $this->connectUser(self::USER_DEVELOPPEUR, self::USER_PASSWORD);
        $company = $this->getCompanyByName(BaseTestCase::COMPANY_NAME);

        $url = $this->generateRoute('show_company', array('id' => $company->getId()));
        $client->request('GET', $url);

        $this->assertStatusCode(403, $client, 'A regular user should NOT have access to companies pages when is not a member of him');
    }

    /**
     * Test access to not found company
     */
    public function testAccessNotFoundCompanyAction()
    {
        $client = $this->connectUser(self::USER_DEVELOPPEUR, self::USER_PASSWORD);
        $url = $this->generateRoute('show_company', array('id' => 'kkk'));
        $client->request('GET', $url);

        $this->assertRedirectTo($client, 'show_all_companies', array(), 'A regular user should be redirect to companies list view when request a not found company');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);

        $this->assertFlashMessageContains(
            $crawler,
            "Entreprise introuvable",
            'A regular user should should see an error flashMessage when request a not found company'
        );
    }
}
