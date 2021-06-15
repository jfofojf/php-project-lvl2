<?php

namespace Differ\Formatters\Json;

use phpDocumentor\Reflection\File;

/**
 * @param array $tree
 * @return mixed
 */
function format(array $tree): mixed
{
    return json_encode($tree);
}
