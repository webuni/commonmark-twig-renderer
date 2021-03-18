<?php

namespace Webuni\CommonMark\TwigRenderer;

use League\CommonMark\DocParserInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\MarkdownConverter;

final class ConvertorModifier extends MarkdownConverter
{
    private function __construct()
    {
    }

    public static function setRenderer(MarkdownConverter $converter, ElementRendererInterface $renderer): void
    {
        $converter->htmlRenderer = $renderer;
    }

    public static function setParser(MarkdownConverter $converter, DocParserInterface $parser): void
    {
        $converter->docParser = $parser;
    }
}
