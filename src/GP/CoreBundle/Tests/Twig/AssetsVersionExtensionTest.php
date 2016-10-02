<?php

namespace GP\CoreBundle\Tests\Twig;

use GP\CoreBundle\Twig\AssetVersionExtension;

class AssetsVersionExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test asset version filters
     *
     * @dataProvider ManifestProvider
     *
     * @param $env
     * @param $manifestPath
     * @param $testPath
     * @param $expected
     */
    public function testAssetVersionFilter($env, $manifestPath, $testPath, $expected)
    {
        $assetVersionExtension = new AssetVersionExtension(__DIR__ . $manifestPath, $env);
        $this->assertEquals($assetVersionExtension->getAssetVersion($testPath), $expected);
    }

    public function ManifestProvider()
    {
        return array(
            array(
                'env' => 'prod',
                'manifestPath' => '/fixtures/manifest_test1.json',
                'testPath' => 'assets/css/gyver_main.css',
                'expected' => 'assets/css/gyver_main-9ff69b052f.css'
            ),
            array(
                'env' => 'prod',
                'manifestPath' => '/fixtures/manifest_test1.json',
                'testPath' => 'assets/js/Admin/add_access_role.js',
                'expected' => 'assets/js/Admin/add_access_role-81de2d02b3.js'
            ),
            array(
                'env' => 'dev',
                'manifestPath' => '/fixtures/manifest_test1.json',
                'testPath' => 'assets/css/gyver_main.css',
                'expected' => 'assets/css/gyver_main.css'
            ),
            array(
                'env' => 'dev',
                'manifestPath' => '/fixtures/manifest_test1.json',
                'testPath' => 'assets/js/Admin/add_access_role.js',
                'expected' => 'assets/js/Admin/add_access_role.js'
            ),
            array(
                'env' => 'prod',
                'manifestPath' => '/fixtures/manifest_test2.json',
                'testPath' => 'assets/foo/bar/css/main.css',
                'expected' => 'assets/foo/bar/css/main-b30412d01c.css'
            ),
            array(
                'env' => 'dev',
                'manifestPath' => '/fixtures/manifest_test2.json',
                'testPath' => 'assets/foo/bar/css/main.css',
                'expected' => 'assets/foo/bar/css/main.css'
            ),
            array(
                'env' => 'prod',
                'manifestPath' => '/fixtures/notFoundManifest.json',
                'testPath' => 'assets/foo/bar/css/main.css',
                'expected' => 'assets/foo/bar/css/main.css'
            ),
        );
    }
}
