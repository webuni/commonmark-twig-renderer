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

namespace Webuni\CommonMark\TwigRenderer;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use League\CommonMark\Inline\Element\AbstractInline;

class TwigRenderer extends HtmlRenderer
{
    private $twig;
    private $template;
    private $defaultTemplate;

    public function __construct(Environment $environment, \Twig_Environment $twig, $template = 'commonmark.html.twig')
    {
        parent::__construct($environment);
        $this->twig = $twig;
        $this->defaultTemplate = $template;
    }

    protected function renderInline(AbstractInline $inline)
    {
        $options = $this->environment->getConfig('renderer', []);

        return $this->getTemplate()->render([
            'node' => $inline,
            'in_tight_list' => false,
            'options' => $options,
        ]);
    }

    public function renderBlock(AbstractBlock $block, $inTightList = false)
    {
        $options = $this->environment->getConfig('renderer', []);

        return $this->getTemplate()->render([
            'node' => $block,
            'in_tight_list' => $inTightList,
            'options' => $options,
        ]);
    }

    private function getTemplate()
    {
        if (null === $this->template) {
            $name = $this->getOption('twig_template', $this->defaultTemplate);
            $this->template = $this->twig->loadTemplate($name);
        }

        return $this->template;
    }
}
