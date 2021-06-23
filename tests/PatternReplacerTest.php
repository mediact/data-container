<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use PHPUnit\Framework\TestCase;
use Mediact\DataContainer\PatternReplacer;

/**
 * @coversDefaultClass \Mediact\DataContainer\PatternReplacer
 */
class PatternReplacerTest extends TestCase
{
    /**
     * @param string $pattern
     * @param string $match
     * @param string $replacement
     * @param string $separator
     * @param string $expected
     *
     * @return void
     *
     * @covers ::__construct
     * @covers ::replace
     *
     * @dataProvider dataProvider
     */
    public function testReplace(
        string $pattern,
        string $match,
        string $replacement,
        string $separator,
        string $expected
    ) {
        $subject = new PatternReplacer($separator);

        $this->assertSame(
            $expected,
            $subject->replace($match, $pattern, $replacement)
        );
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            ['foo.*', 'foo.bar', '$0', '.', 'foo.bar'],
            ['foo.*', 'foo.bar', 'qux.$1', '.', 'qux.bar'],
            ['foo.ba*', 'foo.bar', 'qux.ba$1', '.', 'qux.bar'],
            ['foo.ba*', 'foo.bar', 'qux.$1', '.', 'qux.r'],
            ['foo.ba?', 'foo.bar', 'qux.$1', '.', 'qux.r'],
            ['foo.ba[rz]', 'foo.bar', 'qux.$1', '.', 'qux.r'],
            ['foo.ba[!ad]', 'foo.bar', 'qux.$1', '.', 'qux.r'],
            ['fo*.*', 'foo.bar', '$2.$1.baz', '.', 'bar.o.baz'],
            ['fo*#*', 'foo#bar', '$2#$1#baz', '#', 'bar#o#baz'],
            ['fo*/*', 'foo/bar', '$2/$1/baz', '/', 'bar/o/baz'],
        ];
    }
}
