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
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CommonMarkExtension extends AbstractExtension
{
    private static $cache = [];

    public function getFilters(): array
    {
        return [
            new TwigFilter('commonmark_block_name', [$this, 'getBlockName']),
            new TwigFilter('preg_replace', [$this, 'pregReplace']),
        ];
    }

    public function getBlockName(Node $node): string
    {
        $class = get_class($node);
        if (!isset(self::$cache[$class])) {
            $ref = new \ReflectionClass($class);
            self::$cache[$class] = strtolower(preg_replace('/((?<=[a-z]|\d)[A-Z]|(?<!^)[A-Z](?=[a-z]))/', '_\\1', $ref->getShortName()));
        }

        return self::$cache[$class];
    }

    public function pregReplace($subject, $pattern, $replacement = '', $limit = -1): string
    {
        return preg_replace($pattern, $replacement, $subject, $limit);
    }
}
