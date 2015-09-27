<?php

/*
 * This is part of the webuni/commonmark-twig-renderer package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webuni\CommonMark\TwigRenderer\tests\functional;

use League\CommonMark\Tests\Functional\LocalDataTest as BaseLocalDataTest;
use Webuni\CommonMark\TwigRenderer\Tests\CommonMarkConverter;

class LocalDataTest extends BaseLocalDataTest
{
    protected $converter;

    protected function setUp()
    {
        $this->converter = new CommonMarkConverter();
    }
}
