<?php

namespace Differ\Formatters\Json;

/**
 * @param $tree
 * @return false|string
 */
function format($tree)
{
    return json_encode($tree);
}
