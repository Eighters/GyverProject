<?php

namespace GP\CoreBundle\Twig;

class AssetVersionExtension extends \Twig_Extension
{
    private $rootDir;

    private $manifest;

    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    public function getName()
    {
        return 'asset_version';
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('asset_version', array($this, 'getAssetVersion')),
        );
    }

    public function getAssetVersion($path)
    {
        if (count($this->manifest) === 0) {
            $manifestPath = $this->rootDir . '/../web/rev-manifest.json';

            if (!file_exists($manifestPath)) {
                return $path;
            }

            $this->manifest = json_decode(file_get_contents($manifestPath), true);
        }

        if (!isset($this->manifest[$path])) {
            return $path;
        }

        return $this->manifest[$path];
    }
}

