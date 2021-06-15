<?php

namespace Differ\Parsers;

use Exception;
use phpDocumentor\Reflection\Types\Mixed_;
use Symfony\Component\Yaml\Yaml;

/**
 * @param file $data
 * @param string $format
 * @return mixed
 * @throws Exception
 */
function parse(file $data, string $format): mixed
{
    switch ($format) {
        case 'json':
            return json_decode($data);
        case 'yaml':
        case 'yml':
            return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
        default:
            throw new Exception("format $format not supported");
    }
}
