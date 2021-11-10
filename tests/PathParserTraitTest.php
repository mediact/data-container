<?php

/**
 * Copyright Alumio. All rights reserved.
 * https://www.alumio.com
 */

declare(strict_types=1);

namespace Mediact\DataContainer\Tests;

use PHPUnit\Framework\TestCase;
use Mediact\DataContainer\PathParserTrait;

/**
 * @coversDefaultClass \Mediact\DataContainer\PathParserTrait
 */
class PathParserTraitTest extends TestCase
{
    /**
     * @param string $path
     * @param array  $expected
     *
     * @return void
     *
     * @covers ::parsePath
     *
     * @dataProvider dataProvider
     */
    public function testParsePath(string $path, array $expected)
    {
        $subject = new class () {
            use PathParserTrait;

            /**
             * @param string $path
             *
             * @return array
             */
            public function peekParsePath(string $path): array
            {
                return $this->parsePath($path);
            }
        };

        self::assertSame($expected, $subject->peekParsePath($path));
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [
                '$path'     => '',
                '$expected' => []
            ],
            [
                '$path'     => 'foo.bar.baz',
                '$expected' => ['foo', 'bar', 'baz']
            ],
            [
                '$path'     => 'foo.0.baz',
                '$expected' => ['foo', 0, 'baz']
            ],
            [
                '$path'     => '"fo""o".0."baz.a"',
                '$expected' => ['fo"o', 0, 'baz.a']
            ],
            [
                '$path'     => '"fo""o".*."baz.a"',
                '$expected' => ['fo"o', '*', 'baz.a']
            ],
            [
                '$path'     => '"fo""o".."baz.a"..',
                '$expected' => ['fo"o', 'baz.a']
            ],
            [
                '$path'     => 'foo.000',
                '$expected' => ['foo', '000'],
            ],
            [
                '$path'     => 'foo.0001',
                '$expected' => ['foo', '0001'],
            ],
            [
                '$path'     => 'foo.0001.bar',
                '$expected' => ['foo', '0001', 'bar'],
            ],
            [
                '$path'     => 'foo.0',
                '$expected' => ['foo', 0],
            ],
            [
                '$path'     => 'foo.0.bar',
                '$expected' => ['foo', 0, 'bar'],
            ],
            [
                '$path'     => 'foo.1000',
                '$expected' => ['foo', 1000],
            ],
            [
                '$path'     => 'foo.1001',
                '$expected' => ['foo', 1001],
            ],
        ];
    }
}
