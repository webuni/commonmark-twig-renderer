<?php

namespace Webuni\CommonMark\TwigRenderer\Tests;


use League\CommonMark\MarkdownConverterInterface;

class ConverterTestDecorator implements MarkdownConverterInterface
{
    private $wrapped;

    public function __construct(MarkdownConverterInterface $wrapped)
    {
        $this->wrapped = $wrapped;
    }

    public function convertToHtml(string $markdown): string
    {
        return str_replace('&#039;', "'", $this->wrapped->convertToHtml($markdown));
    }
}
