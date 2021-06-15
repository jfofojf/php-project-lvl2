<?php

namespace Differ\Formatters\Json;

use phpDocumentor\Reflection\File;

/**
 * @param array $tree
 * @return string|bool
 */
function format(array $tree): string|bool
{
    return json_encode($tree);
}
