<?php

namespace Differ\Formatters\Plain;

use function Funct\Collection\without;

function format($tree, $key = ""): string
{
    $result = array_map(function ($var) use ($key) {
        $name = $var['key'];
        $name = $key === "" ? $name : "$key.$name";
        $type = $var['type'];
        $t = "Property";

        switch ($type) {
            case 'nested':
                return format($var['children'], $name);
            case 'added':
                $res = prepareValue($var['valueAfter']);
                return ("$t '$name' was added with value: $res");
            case 'removed':
                return ("$t '$name' was removed");
            case 'changed':
                $valB = prepareValue($var['valueBefore']);
                $valA = prepareValue($var['valueAfter']);
                return ("$t '$name' was updated. From $valA to $valB");
            case 'unchanged':
                return 'del';
        }
    }, $tree);
    return implode("\n", without($result, 'del'));
}

function prepareValue($val)
{
    if (is_object($val)) {
        return '[complex value]';
    }
    if (is_bool($val)) {
        return $val ? 'true' : 'false';
    }
    if (is_null($val)) {
        return 'null';
    }
    return "'$val'";
}
