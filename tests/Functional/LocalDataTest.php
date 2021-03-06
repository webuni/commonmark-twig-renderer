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

use League\CommonMark\Tests\Functional\LocalDataTest as BaseLocalDataTest;
use Webuni\CommonMark\TwigRenderer\CommonMarkTwig;

final class LocalDataTest extends BaseLocalDataTest
{
    protected function setUp(): void
    {
        parent::setUp();
        CommonMarkTwig::setTwigRenderer($this->converter);
    }
}
