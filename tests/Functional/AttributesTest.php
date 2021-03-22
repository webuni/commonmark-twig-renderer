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

use League\CommonMark\Tests\Functional\AbstractLocalDataTest;
use League\CommonMark\Tests\Functional\Extension\Attributes\LocalDataTest as BaseAttributesTest;
use Webuni\CommonMark\TwigRenderer\CommonMarkTwig;

class AttributesTest extends AbstractLocalDataTest
{
    private $localDataTest;
    protected $converter;

    public function __construct()
    {
        $this->localDataTest = new BaseAttributesTest();
    }

    protected function setUp(): void
    {
        $this->localDataTest->setUp();
        $this->converter = $this->localDataTest->converter;
        CommonMarkTwig::setTwigRenderer($this->converter);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testRenderer(string $markdown, string $html, string $testName): void
    {
        $this->assertMarkdownRendersAs($markdown, $html, $testName);
    }

    /**
     * @return iterable<string, string, string>
     */
    public function dataProvider(): iterable
    {
        return $this->localDataTest->dataProvider();
    }
}
