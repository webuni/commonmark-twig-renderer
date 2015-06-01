<?php

/*
 * This is part of the webuni/commonmark-twig-renderer package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webuni\CommonMark\TwigRenderer;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use League\CommonMark\Inline\Element\AbstractInline;

/**
 * Class CommonMarkExtension
 *
 * @author Martin Hasoň <hason@webuni.cz>
 */
class TwigRenderer extends HtmlRenderer
{
    private $twig;
    private $template;
    private $cache = [];

    public function __construct(Environment $environment, \Twig_Environment $twig)
    {
        parent::__construct($environment);
        $this->twig = $twig;

        if (!$twig->hasExtension('commonmark')) {
            throw new \RuntimeException('You must register "commonmark" extension for Twig before instantiate TwigRenderer.');
        }

        $twig->getExtension('commonmark')->setRenderer($this);
    }

    protected function renderInline(AbstractInline $inline)
    {
        return $this->renderElement($inline);
    }

    public function renderBlock(AbstractBlock $block, $inTightList = false)
    {
        return $this->renderElement($block, $inTightList);
    }

    private function getBlockName($node)
    {
        $ref = new \ReflectionClass($node);

        return strtolower(preg_replace('/((?<=[a-z]|\d)[A-Z]|(?<!^)[A-Z](?=[a-z]))/', '_\\1', $ref->getShortName()));
    }

    private function renderElement($element, $inTightList = false)
    {
        $class = get_class($element);
        if (!isset($this->cache[$class])) {
            $this->cache[$class] = $this->getBlockName($element);
        }

        return $this->getTemplate()->renderBlock($this->cache[$class], ['node' => $element, 'in_tight_list' => $inTightList]);
    }

    private function getTemplate()
    {
        if (null === $this->template) {
            $name = $this->getOption('twig_template', 'commonmark.html.twig');
            $this->template = $this->twig->loadTemplate($name);
        }

        return $this->template;
    }
}
