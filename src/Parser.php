<?php

namespace Differ\Parsers;

use Exception;
use Symfony\Component\Yaml\Yaml;

/**
 * @throws Exception
 */
function parse($data, string $format)
{
    switch (mb_strtolower($format)) {
        case 'json':
            return json_decode($data);
        case 'yaml':
        case 'yml':
            return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
        default:
            throw new Exception("format $format not supported");
    }
}
