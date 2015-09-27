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
 * Twig Renderer.
 *
 * @author Martin Hasoň <martin.hason@gmail.com>
 */
class TwigRenderer extends HtmlRenderer
{
    private $twig;
    private $template;

    public function __construct(Environment $environment, \Twig_Environment $twig)
    {
        parent::__construct($environment);
        $this->twig = $twig;
    }

    protected function renderInline(AbstractInline $inline)
    {
        $options = $this->environment->getConfig('renderer', []);

        return $this->getTemplate()->render([
            'node'          => $inline,
            'in_tight_list' => false,
            'options'       => $options,
        ]);
    }

    public function renderBlock(AbstractBlock $block, $inTightList = false)
    {
        $options = $this->environment->getConfig('renderer', []);

        return $this->getTemplate()->render([
            'node'          => $block,
            'in_tight_list' => $inTightList,
            'options'       => $options,
        ]);
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
