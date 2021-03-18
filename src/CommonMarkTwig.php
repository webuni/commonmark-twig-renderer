<?php

namespace Webuni\CommonMark\TwigRenderer;

use League\CommonMark\Converter;
use League\CommonMark\MarkdownConverter;
use Twig\Environment as Twig;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

final class CommonMarkTwig
{
    private function __construct()
    {
    }

    public static function createTwigLoader(): LoaderInterface
    {
        return new FilesystemLoader([dirname(__DIR__) . '/templates']);
    }

    public static function configureTwig(Twig $twig): void
    {
        $loader = $twig->getLoader();
        if (!$loader instanceof ChainLoader) {
            $loader = new ChainLoader([$loader]);
            $twig->setLoader($loader);
        }
        $loader->addLoader(self::createTwigLoader());

        if (!$twig->hasExtension(CommonMarkExtension::class)) {
            $twig->addExtension(new CommonMarkExtension());
        }
    }

    public static function setTwigRenderer(MarkdownConverter $converter, Twig $twig = null): void
    {
        $twig = $twig ?? new Twig(new ChainLoader());
        self::configureTwig($twig);

        $renderer = new TwigRenderer($converter->getEnvironment(), $twig);
        ConvertorModifier::setRenderer($converter, $renderer);
    }

}
