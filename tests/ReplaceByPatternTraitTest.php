<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use PHPUnit\Framework\TestCase;
use Mediact\DataContainer\ReplaceByPatternTrait;

/**
 * @coversDefaultClass \Mediact\DataContainer\ReplaceByPatternTrait
 */
class ReplaceByPatternTraitTest extends TestCase
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
     * @covers ::replaceByPattern
     * @covers ::replaceByRegex
     * @covers ::getPatternRegex
     *
     * @dataProvider dataProvider
     */
    public function testReplaceByPattern(
        string $pattern,
        string $match,
        string $replacement,
        string $separator,
        string $expected
    ) {
        $subject = new class {
            use ReplaceByPatternTrait;

            /**
             * @param string $pattern
             * @param string $match
             * @param string $replacement
             * @param string $separator
             *
             * @return string
             */
            public function peekReplaceByPattern(
                string $pattern,
                string $match,
                string $replacement,
                string $separator
            ): string {
                return $this->replaceByPattern(
                    $pattern,
                    $match,
                    $replacement,
                    $separator
                );
            }
        };

        $this->assertSame(
            $expected,
            $subject->peekReplaceByPattern(
                $pattern,
                $match,
                $replacement,
                $separator
            )
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
