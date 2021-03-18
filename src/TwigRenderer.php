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
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Environment;
use League\CommonMark\Inline\Element\AbstractInline;
use Twig\Environment as Twig;

final class TwigRenderer implements ElementRendererInterface
{
    private $environment;
    private $twig;
    private $templateName;
    private $defaultTemplate;

    public function __construct(Environment $environment, Twig $twig, $template = 'commonmark.html.twig')
    {
        $this->environment = $environment;
        $this->twig = $twig;
        $this->defaultTemplate = $template;
    }

    /**
     * {@inheritdoc}
     */
    public function getOption(string $option, $default = null)
    {
        return $this->environment->getConfig('renderer/' . $option, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function renderInline(AbstractInline $inline): string
    {
        $options = $this->environment->getConfig('renderer', []);

        return $this->render([
            'node' => $inline,
            'in_tight_list' => false,
            'options' => $options,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function renderInlines(iterable $inlines): string
    {
        $result = [];
        foreach ($inlines as $inline) {
            $result[] = $this->renderInline($inline);
        }

        return \implode('', $result);
    }

    /**
     * {@inheritdoc}
     */
    public function renderBlock(AbstractBlock $block, $inTightList = false): string
    {
        $options = $this->environment->getConfig('renderer', []);

        return $this->render([
            'node' => $block,
            'in_tight_list' => $inTightList,
            'options' => $options,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function renderBlocks(iterable $blocks, bool $inTightList = false): string
    {
        $result = [];
        foreach ($blocks as $block) {
            $result[] = $this->renderBlock($block, $inTightList);
        }

        $separator = $this->getOption('block_separator', "\n");

        return \implode($separator, $result);
    }

    private function render(array $context): string
    {
        if (null === $this->templateName) {
            $this->templateName = $this->getOption('twig_template', $this->defaultTemplate);
        }

        return $this->twig->render($this->templateName, $context);
    }
}
