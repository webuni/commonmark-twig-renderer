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

use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\MarkdownConverter;
use Twig\Environment as Twig;
use Webuni\CommonMark\TwigRenderer\CommonMarkExtension;
use Webuni\CommonMark\TwigRenderer\TwigRenderer;

class CommonMarkConverter extends MarkdownConverter
{
    public function __construct(array $config = [])
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->mergeConfig(['renderer' => ['twig_template' => 'commonmark.html.twig']]);
        $environment->mergeConfig($config);
        $environment->addExtension(new AttributesExtension());

        $loader = CommonMarkExtension::createTwigLoader();
        $loader->addPath(__DIR__.'/Resources');

        $twig = new Twig($loader, [
            'strict_variables' => true,
        ]);
        $twig->addExtension(new CommonMarkExtension());

        parent::__construct(new DocParser($environment), new TwigRenderer($environment, $twig));
    }

    public function convertToHtml(string $commonMark): string
    {
        return str_replace('&#039;', "'", parent::convertToHtml($commonMark));
    }
}
