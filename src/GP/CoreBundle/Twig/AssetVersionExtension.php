<?php

namespace GP\CoreBundle\Twig;

/**
 * This twig filter is used for reading "rev-manifest.json" files & looking for given assets.
 *
 * - If assets is found in manifest, filter return the revisionned version name of this assets
 * - If not, fallback to the original given assets name (non revisionned version).
 *
 * Search for "Cache Busting" in Google
 *
 * Class AssetVersionExtension
 * @package GP\CoreBundle\Twig
 */
class AssetVersionExtension extends \Twig_Extension
{
    /**
     * The path to the rev-manifest.json file
     * @var string
     */
    private $manifestPath;

    /**
     * The current kernel environment
     * @var string
     */
    private $environment;

    /**
     * The avoid multiple calls to readfile() function, stock the values of the rev-manifest file inside class var
     * @var
     */
    private $manifest;

    public function __construct($manifestPath, $environment)
    {
        $this->manifestPath = $manifestPath;
        $this->environment = $environment;
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
        # Assets revision is only enabled in prod
        if ($this->environment == 'dev') {
            return $path;
        }

        if (count($this->manifest) === 0) {
            if (!file_exists($this->manifestPath)) {
                return $path;
            }

            $this->manifest = json_decode(file_get_contents($this->manifestPath), true);
        }

        if (!isset($this->manifest[$path])) {
            return $path;
        }

        return $this->manifest[$path];
    }
}
