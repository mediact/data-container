<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use Mediact\DataContainer\Tests\TestDouble\GlobReplacementDouble;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Mediact\DataContainer\GlobReplacementTrait
 */
class GlobReplacementTraitTest extends TestCase
{
    /**
     * @param string $pattern
     * @param string $matched
     * @param string $replacement
     * @param string $separator
     * @param string $expected
     *
     * @return void
     * @dataProvider dataProvider
     *
     * @covers ::getGlobReplacement
     * @covers ::getGlobRegex
     */
    public function testGetGlobReplacement(
        string $pattern,
        string $matched,
        string $replacement,
        string $separator,
        string $expected
    ) {
        $double = new GlobReplacementDouble();
        $this->assertEquals(
            $expected,
            $double->peekGlobReplacement(
                $pattern,
                $matched,
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
            ['foo.bar', 'foo.bar', 'bar', '.', 'bar'],
            ['foo.b*', 'foo.bar', 'baz.b$1', '.', 'baz.bar'],
            ['foo.ba?', 'foo.bar', 'baz.ba$1', '.', 'baz.bar'],
            ['foo.ba[rz]', 'foo.bar', 'baz.ba$1', '.', 'baz.bar'],
            ['foo.[bf][ao][orz]', 'foo.bar', 'baz.$1$2$3', '.', 'baz.bar'],
            ['foo.*', 'foo.bar', '$0.qux', '.', 'foo.bar.qux'],
            ['foo/ba?', 'foo/bar', 'baz/ba$1', '/', 'baz/bar'],
            ['foo#ba?', 'foo#bar', 'baz#ba$1', '#', 'baz#bar'],
            ['foo^ba?', 'foo^bar', 'baz^ba$1', '^', 'baz^bar'],
        ];
    }
}
