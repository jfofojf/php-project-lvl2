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
     */
    public function testGenDiff($file1, $file2, $expected): void
    {
        $expect = path($expected);
        $this->assertSame($expect, genDiff(path($file1), path($file2)));
    }

    public function dataProvider(): array
    {
        return [
            ['file1.json', 'file2.json', 'expected.txt'],
            ['file1.yml', 'file2.yml', 'expected.txt']
        ];
    }
}
