<?php

/*
 * This is part of the webuni/commonmark-twig-renderer package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 * (c) Webuni s.r.o. <info@webuni.cz>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webuni\CommonMark\TwigRenderer\Tests;

use League\CommonMark\Converter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use Twig\Environment as Twig;
use Webuni\CommonMark\TwigRenderer\CommonMarkTwigExtension;
use Webuni\CommonMark\TwigRenderer\TwigRenderer;

class CommonMarkConverter extends Converter
{
    public function __construct(array $config = [])
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->mergeConfig(['renderer' => ['twig_template' => 'commonmark.html.twig']]);
        $environment->mergeConfig($config);
        $environment->addExtension(new AttributesExtension());

        $loader = CommonMarkTwigExtension::createTwigLoader();
        $loader->addPath(__DIR__.'/Resources');

        $twig = new Twig($loader, [
            'strict_variables' => true,
        ]);
        $twig->addExtension(new CommonMarkTwigExtension());

        parent::__construct(new DocParser($environment), new TwigRenderer($environment, $twig));
    }

    public function convertToHtml($commonMark)
    {
        return str_replace('&#039;', "'", parent::convertToHtml($commonMark));
    }
}
