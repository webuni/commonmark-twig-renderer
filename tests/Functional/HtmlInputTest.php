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

namespace Webuni\CommonMark\TwigRenderer\Tests\Functional;

use League\CommonMark\Tests\Functional\HtmlInputTest as BaseHtmlInputTest;
use Webuni\CommonMark\TwigRenderer\Tests\CommonMarkConverter;

class HtmlInputTest extends BaseHtmlInputTest
{
    protected $converter;

    protected function setUp(): void
    {
        $this->converter = new CommonMarkConverter();
    }
}
