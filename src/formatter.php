<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\format;

function render($tree, string $format)
{
    if ($format === 'stylish') {
        return format($tree);
    }
}
