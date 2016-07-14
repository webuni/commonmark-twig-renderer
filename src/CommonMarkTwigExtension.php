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

use League\CommonMark\Node\Node;

class CommonMarkTwigExtension extends \Twig_Extension
{
    private static $cache = [];

    public static function createTwigLoader()
    {
        return new \Twig_Loader_Filesystem([__DIR__.'/Resources']);
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('commonmark_block_name', [$this, 'getBlockName']),
            new \Twig_SimpleFilter('preg_replace', [$this, 'pregReplace']),
        ];
    }

    public function getBlockName(Node $node)
    {
        $class = get_class($node);
        if (!isset(self::$cache[$class])) {
            $ref = new \ReflectionClass($class);
            self::$cache[$class] = strtolower(preg_replace('/((?<=[a-z]|\d)[A-Z]|(?<!^)[A-Z](?=[a-z]))/', '_\\1', $ref->getShortName()));
        }

        return self::$cache[$class];
    }

    public function pregReplace($subject, $pattern, $replacement = '', $limit = -1)
    {
        return preg_replace($pattern, $replacement, $subject, $limit);
    }

    public function getName()
    {
        return 'commonmark';
    }
}
