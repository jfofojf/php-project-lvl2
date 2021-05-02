<?php

namespace Differ\Differ;

use function Funct\Collection\union;
use function Differ\Parsers\parse;
use function Differ\Formatters\render;

/**
 * @throws \Exception
 */
function getFormattedData($path): array
{
    $extension = pathinfo($path, PATHINFO_EXTENSION);

    if (!file_exists($path)) {
        throw new \Exception('No such file or directory');
    }

    $data = file_get_contents($path);
    return [$data, $extension];
}

/**
 * @param string $file1
 * @param string $file2
 * @return string
 */
function genDiff(string $file1, string $file2): string
{
    [$firstFileData, $firstFileFormat] = getFormattedData($file1);
    [$secondFileData, $secondFileFormat] = getFormattedData($file2);

    $parseFile1 = parse($firstFileData, $firstFileFormat);
    $parseFile2 = parse($secondFileData, $secondFileFormat);

    $diffTree = buildTree($parseFile1, $parseFile2);
    $result = render($diffTree);
    return "{\n$result\n}";
}

/**
 * @param object $file1
 * @param object $file2
 * @return array
 */
function buildTree(object $file1, object $file2): array
{
    $sortKeys = union(array_keys(get_object_vars($file1)), array_keys(get_object_vars($file2)));

    return array_map(function ($node) use ($file1, $file2): array {
        if (!property_exists($file2, $node)) {
            return ['key' => $node, 'type' => 'removed', 'valueBefore' => $file1->$node];
        }
        if (!property_exists($file1, $node)) {
            return ['key' => $node, 'type' => 'added', 'valueAfter' => $file2->$node];
        }
        if (is_object($file1->$node) && is_object($file2->$node)) {
            return ['key' => $node, 'type' => 'nested', 'children' => buildTree($file1->$node, $file2->$node)];
        }
        if ($file1->$node !== $file2->$node) {
            return ['key' => $node, 'type' => 'changed', 'valueBefore' => $file2->$node, 'valueAfter' => $file1->$node];
        }
        return ['key' => $node, 'type' => 'unchanged', 'valueBefore' => $file1->$node];
    }, $sortKeys);
}
