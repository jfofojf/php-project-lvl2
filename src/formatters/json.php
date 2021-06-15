<?php

namespace Differ\Formatters\Json;

use phpDocumentor\Reflection\File;

/**
 * @param array $tree
 * @return string|false
 */
function format(array $tree): string|false
{
    return json_encode($tree);
}
