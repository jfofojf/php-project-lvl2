<?php

namespace Differ\Formatters\Stylish;

const BASE_IDENT = "  ";

/**
 * @param mixed $value
 * @param int $depth
 * @return string
 */
function prepareValue(mixed $value, int $depth): string
{
    $ident = setIdent($depth);

    if (is_object($value)) {
        $keys = array_keys(get_object_vars($value));
        $values = array_map(
            fn($val) => "{$ident}{$val}: " . prepareValue($value->$val, $depth + 1),
            $keys
        );
        $value = implode("\n", $values);
        $tmp = setIdent($depth - 1);
        return "{\n{$value}\n{$tmp}}";
    }
    if (is_array($value)) {
        $items = array_map(fn ($item) => prepareValue($item, $depth), $value);
        $result = implode(", ", $items);
        return "[{$result}]";
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }
    return (string) $value;
}

/**
 * @param int $depth
 * @param false $hasSign
 * @return string
 */
function setIdent(int $depth, bool $hasSign = false): string
{
    if ($hasSign) {
        $indentSize = $depth * 2 - 1;
    } else {
        $indentSize = $depth * 2;
    }

    return  str_repeat(BASE_IDENT, $indentSize);
}

/**
 * @param array $data
 * @param int $depth
 * @return string
 */
function format(array $data, int $depth = 1): string
{
    $result = array_map(function ($node) use ($data, $depth) {
        $name = $node['key'];
        $type = $node['type'];
        $ident = setIdent($depth, true);

        switch ($type) {
            case 'nested':
                $child = format($node['children'], $depth + 1);
                return "$ident  $name: {\n$child\n$ident  }";

            case 'added':
                $value = prepareValue($node['valueAfter'], $depth + 1);
                return "$ident+ $name: $value";

            case 'removed':
                $value = prepareValue($node['valueBefore'], $depth + 1);
                return "$ident- $name: $value";

            case 'changed':
                $value1 = prepareValue($node['valueAfter'], $depth + 1);
                $value2 = prepareValue($node['valueBefore'], $depth + 1);
                return "$ident- $name: $value1\n$ident+ $name: $value2";

            case 'unchanged':
                $value = prepareValue($node['valueBefore'], $depth + 1);
                return "$ident  $name: $value";
        }
        return $data;
    }, $data);
    return implode("\n", $result);
}
