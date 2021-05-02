<?php

namespace Differ\Differ;

use function Funct\Collection\sortBy;

function prepareValue($value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }
    return $value;
}

function genDiff(string $file1, string $file2): string
{
    $file1Array = json_decode(file_get_contents($file1), true);
    $file2Array = json_decode(file_get_contents($file2), true);

    $keys = array_keys(array_merge($file1Array, $file2Array));
    $sortKeys = array_values(sortBy($keys, fn($key) => $key));

    $res = array_reduce(
        $sortKeys,
        function ($acc, $key) use ($file1Array, $file2Array) {
            if (!array_key_exists($key, $file1Array)) {
                $valueFrom2 = prepareValue($file2Array[$key]);
                $acc[] = "    + $key : $valueFrom2";
            } elseif (!array_key_exists($key, $file2Array)) {
                $valueFrom1 = prepareValue($file1Array[$key]);
                $acc[] = "    - $key : $valueFrom1";
            } elseif ($file1Array[$key] !== $file2Array[$key]) {
                $valueFrom1 = prepareValue($file1Array[$key]);
                $valueFrom2 = prepareValue($file2Array[$key]);
                $acc[] = "    - $key : $valueFrom1";
                $acc[] = "    + $key : $valueFrom2";
            } else {
                $valueFrom1 = prepareValue($file1Array[$key]);
                $acc[] = "      $key : $valueFrom1";
            }
            return $acc;
        },
        []
    );

    $result = implode("\n", $res);
    return "{\n$result\n}";
}
