<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

/**
 * @param string $name
 * @return string
 */
function path(string $name): string
{
    return implode('/', [ __DIR__, "fixtures", $name]);
}

class GenDiffTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     * @param $file1
     * @param $file2
     * @param $format
     * @param $expected
     */
    public function testGenDiff($file1, $file2, $format, $expected): void
    {
        $expect = path($expected);
        $res = file_get_contents($expect);
        $this->assertEquals($res, genDiff(path($file1), path($file2), $format));
    }

    public function dataProvider(): array
    {
        return [
            ['file1.json', 'file2.json', 'stylish', 'stylish.txt'],
            ['file1.yml', 'file2.yml', 'stylish', 'stylish.txt'],
            ['file1.json', 'file2.json', 'plain', 'plain.txt'],
            ['file1.yml', 'file2.yml', 'plain', 'plain.txt'],
            ['file1.json', 'file2.json', 'json', 'json.txt'],
            ['file1.yml', 'file2.yml', 'json', 'json.txt']
        ];
    }
}
