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

use Webuni\CommonMark\TwigRenderer\Tests\CommonMarkConverter;

class SpecTest extends \PHPUnit_Framework_TestCase
{
    protected $converter;

    protected function setUp()
    {
        $this->converter = new CommonMarkConverter();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testExample($markdown, $html, $section, $number)
    {
        // Replace visible tabs in spec
        $markdown = str_replace('→', "\t", $markdown);
        $html = str_replace('→', "\t", $html);

        $actualResult = str_replace('&#039;', "'", $this->converter->convertToHtml($markdown));

        $failureMessage = sprintf('Unexpected result ("%s" section, example #%d)', $section, $number);
        $failureMessage .= "\n=== markdown ===============\n".$markdown;
        $failureMessage .= "\n=== expected ===============\n".$html;
        $failureMessage .= "\n=== got ====================\n".$actualResult;

        $this->assertEquals($html, $actualResult, $failureMessage);
    }

    public function dataProvider()
    {
        $filename = __DIR__.'/../../vendor/jgm/CommonMark/spec.txt';
        if (($data = file_get_contents($filename)) === false) {
            $this->fail(sprintf('Failed to load spec from %s', $filename));
        }

        $matches = [];
        // Normalize newlines for platform independence
        $data = preg_replace('/\r\n?/', "\n", $data);
        $data = preg_replace('/<!-- END TESTS -->.*$/', '', $data);
        preg_match_all('/^\.\n([\s\S]*?)^\.\n([\s\S]*?)^\.$|^#{1,6} *(.*)$/m', $data, $matches, PREG_SET_ORDER);

        $examples = [];
        $currentSection = '';
        $exampleNumber = 0;

        foreach ($matches as $match) {
            if (isset($match[3])) {
                $currentSection = $match[3];
            } else {
                ++$exampleNumber;

                $markdown = $match[1];
                $markdown = str_replace('→', "\t", $markdown);

                $examples[] = [
                    'markdown' => $markdown,
                    'html'     => $match[2],
                    'section'  => $currentSection,
                    'number'   => $exampleNumber,
                ];
            }
        }

        return $examples;
    }
}
