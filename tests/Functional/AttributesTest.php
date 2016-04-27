<?php

/*
 * This is part of the webuni/commonmark-twig-renderer package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webuni\CommonMark\TwigRenderer\tests\Functional;

use Webuni\CommonMark\AttributesExtension\tests\functional\LocalDataTest as BaseAttributesTest;
use Webuni\CommonMark\TwigRenderer\Tests\CommonMarkConverter;

class AttributesTest extends BaseAttributesTest
{
    protected $converter;

    protected function setUp()
    {
        $this->converter = new CommonMarkConverter();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testExample($markdown, $html, $testName)
    {
        if ('table_attributes' === $testName) {
            $this->markTestSkipped($testName);
        }

        parent::testExample($markdown, $html, $testName);
    }
}
