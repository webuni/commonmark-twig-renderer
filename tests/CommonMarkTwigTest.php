<?php

namespace Webuni\CommonMark\TwigRenderer\Tests;

use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;
use Webuni\CommonMark\TwigRenderer\CommonMarkExtension;
use Webuni\CommonMark\TwigRenderer\CommonMarkTwig;

class CommonMarkTwigTest extends TestCase
{
    public function testConfigureLoaderForNotConfiguredTwig(): void
    {
        $twig = new Environment($originalLoader = new ArrayLoader([]));
        CommonMarkTwig::configureTwig($twig);

        /** @var $loader ChainLoader */
        $loader = $twig->getLoader();
        $this->assertInstanceOf(ChainLoader::class, $loader);

        $loaders = $loader->getLoaders();
        $this->assertCount(2, $loaders);
        $this->assertEquals($originalLoader, $loaders[0]);
        $this->assertInstanceOf(FilesystemLoader::class, $loaders[1]);
    }

    public function testConfigureExtensionForNotConfiguredTwig(): void
    {
        $twig = new Environment(new ArrayLoader([]));
        $this->assertFalse($twig->hasExtension(CommonMarkExtension::class));

        CommonMarkTwig::configureTwig($twig);
        $this->assertTrue($twig->hasExtension(CommonMarkExtension::class));
    }
}
