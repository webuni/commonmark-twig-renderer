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

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Tests\Functional\HtmlInputTest as BaseHtmlInputTest;
use Webuni\CommonMark\TwigRenderer\CommonMarkTwig;

class HtmlInputTest extends BaseHtmlInputTest
{
    private static $DIR;
    private static $input;

    public static function setUpBeforeClass(): void
    {
        $ref = new \ReflectionClass(BaseHtmlInputTest::class);
        self::$DIR = dirname($ref->getFileName()).'/data/html_input';
        self::$input = file_get_contents(self::$DIR . '/input.md');
    }

    public function testDefaultConfig()
    {
        $expectedOutput = trim(file_get_contents(self::$DIR . '/unsafe_output.html'));
        $actualOutput = $this->convert();

        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testAllowHtmlInputConfig()
    {
        $expectedOutput = trim(file_get_contents(self::$DIR . '/unsafe_output.html'));
        $actualOutput = $this->convert(['html_input' => Environment::HTML_INPUT_ALLOW]);

        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testEscapeHtmlInputConfig()
    {
        $expectedOutput = trim(file_get_contents(self::$DIR . '/escaped_output.html'));
        $actualOutput = $this->convert(['html_input' => Environment::HTML_INPUT_ESCAPE]);

        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testStripHtmlInputConfig()
    {
        $expectedOutput = trim(file_get_contents(self::$DIR . '/safe_output.html'));
        $actualOutput = $this->convert(['html_input' => Environment::HTML_INPUT_STRIP]);

        $this->assertEquals($expectedOutput, $actualOutput);
    }

    private function convert(array $config = []): string
    {
        $converter = new CommonMarkConverter($config);
        CommonMarkTwig::setTwigRenderer($converter);

        return trim($converter->convertToHtml(self::$input));
    }
}
