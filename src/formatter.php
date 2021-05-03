<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\format as stylishFormat;
use function Differ\Formatters\Plain\format as plainFormat;

/**
 * @param $tree
 * @param string $format
 * @return mixed
 * @throws \Exception
 */
function render($tree, string $format)
{
    switch (mb_strtolower($format)) {
        case 'stylish':
            return stylishFormat($tree);
        case 'plain':
            return plainFormat($tree);
        default:
            throw new \Exception('Unknown output format');
    }
}
