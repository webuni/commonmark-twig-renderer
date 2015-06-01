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
use League\CommonMark\Block\Element\AbstractInlineContainer as AbstractBlockInlineContainer;
use League\CommonMark\Inline\Element\AbstractInlineContainer;

class CommonMarkTwigExtension extends \Twig_Extension
{
    private $renderer;

    static public function createTwigLoader()
    {
        return new \Twig_Loader_Filesystem([__DIR__.'/Resources']);
    }

    public function setRenderer(TwigRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('commonmark_image_alt', [$this, 'getImageAlt']),
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('commonmark_render_children', [$this, 'renderChildren'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('commonmark_option', [$this, 'getOption'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('commonmark_render_attributes', [$this, 'renderAttributes'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function renderChildren($node, $tight = false)
    {
        if ($node instanceof AbstractBlockInlineContainer) {
            return $this->renderer->renderInlines($node->getInlines());
        }

        if ($node instanceof AbstractBlock) {
            return $this->renderer->renderBlocks($node->getChildren(), $tight);
        }

        if ($node instanceof AbstractInlineContainer) {
            return $this->renderer->renderInlines($node->getChildren());
        }
    }

    public function renderAttributes(\Twig_Environment $env, $node, array $attributes = [])
    {
        if (isset($node->data) && isset($node->data['attributes'])) {
            $attributes = array_merge((array) $node->data['attributes'], $attributes);
        }

        $html = '';
        foreach ($attributes as $name => $value) {
            if (null === $value || false === $value) {
                continue;
            }

            $html .= sprintf(' %s="%s"', $name, twig_escape_filter($env, true === $value ? $name : $value));
        }

        return $html;
    }

    public function getOption($name, $default = null)
    {
        return $this->renderer->getOption($name, $default);
    }

    public function getImageAlt($html)
    {
        $alt = preg_replace('/\<[^>]*alt="([^"]*)"[^>]*\>/', '$1', $html);

        return preg_replace('/\<[^>]*\>/', '', $alt);
    }

    public function getName()
    {
        return 'commonmark';
    }
}
