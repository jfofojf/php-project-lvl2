<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\format as stylishFormat;
use function Differ\Formatters\Plain\format as plainFormat;
use function Differ\Formatters\Json\format as jsonFormat;

/**
 * @param array $tree
 * @param string $format
 * @return mixed
 * @throws \Exception
 */
function render(array $tree, string $format): mixed
{
    switch (mb_strtolower($format)) {
        case 'stylish':
            return stylishFormat($tree);
        case 'plain':
            return plainFormat($tree);
        case 'json':
            return jsonFormat($tree);
        default:
            throw new \Exception('Unknown output format');
    }
}
