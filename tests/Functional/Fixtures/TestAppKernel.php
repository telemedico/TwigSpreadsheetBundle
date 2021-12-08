<?php

declare(strict_types=1);

namespace MewesK\TwigSpreadsheetBundle\Tests\Functional\Fixtures;

use Exception;
use MewesK\TwigSpreadsheetBundle\MewesKTwigSpreadsheetBundle;
use MewesK\TwigSpreadsheetBundle\Tests\Functional\Fixtures\TestBundle\TestBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Class TestAppKernel.
 */
class TestAppKernel extends Kernel
{
    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var string
     */
    private $logDir;

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
            new SensioFrameworkExtraBundle(),
            new MewesKTwigSpreadsheetBundle(),
            new TestBundle(),
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(sprintf('%s/config/config_%s.yml', $this->getProjectDir(), $this->getEnvironment()));
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir(): string
    {
        return $this->cacheDir;
    }

    /**
     * @param string $cacheDir
     */
    public function setCacheDir(string $cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir(): string
    {
        return $this->logDir;
    }

    /**
     * @param string $logDir
     */
    public function setLogDir(string $logDir)
    {
        $this->logDir = $logDir;
    }
}
