<?php

/*
 * This is part of the webuni/commonmark-twig-renderer package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webuni\CommonMark\TwigRenderer\Tests;

class CustomTemplateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getTemplates
     */
    public function testTemplateWithUse($template)
    {
        $converter = new CommonMarkConverter(['renderer' => ['twig_template' => $template]]);

        $commonmark = <<<EOT
Header
======
Paragraph

Subheader
---------
Test [external link](http://example.org).
EOT;

        $html = <<<EOT
<h1><a name="header"></a>Header</h1>
<p>Paragraph</p>
<h2><a name="subheader"></a>Subheader</h2>
<p>Test <a href="http://example.org" class="external">external link</a>.</p>

EOT;

        $this->assertEquals($html, $converter->convertToHtml($commonmark));
    }

    public function getTemplates()
    {
        return [
            ['custom_use.html.twig'],
            ['custom_extends.html.twig'],
        ];
    }
}
