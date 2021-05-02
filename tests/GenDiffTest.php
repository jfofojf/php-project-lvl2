<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GenDiffTest extends TestCase
{
    public function getFixtures(string $name): string
    {
        return implode('/', [ __DIR__, "fixtures", $name]);
    }

    public function testGenDiff(): void
    {
        $f1 = implode('/', [ __DIR__, "fixtures", 'file1.json']);
        $f2 = implode('/', [ __DIR__, "fixtures", 'file2.json']);
        $expected = implode('/', [ __DIR__, "fixtures", 'expected.txt']);
        $res = file_get_contents($expected);

        $genDiffResult = genDiff($f1, $f2);
        $this->assertEquals($res, $genDiffResult);
    }
}
