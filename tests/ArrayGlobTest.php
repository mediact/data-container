<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace Mediact\DataContainer\Tests;

use PHPUnit_Framework_TestCase;
use Mediact\DataContainer\ArrayGlobber;

/**
 * @coversDefaultClass \Mediact\DataContainer\ArrayGlobber
 */
class ArrayGlobTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return ArrayGlobber
     *
     * @covers ::__construct
     */
    public function testConstructor(): ArrayGlobber
    {
        return new ArrayGlobber('.');
    }

    /**
     * @depends testConstructor
     *
     * @param array        $input
     * @param array        $expected
     * @param ArrayGlobber $glob
     *
     * @return void
     *
     * @dataProvider dataProvider
     *
     * @covers ::glob
     * @covers ::findArrayPathsByPatterns
     */
    public function testGlob(
        array $input,
        array $expected,
        ArrayGlobber $glob
    ) {
        foreach ($expected as $pattern => $result) {
            $this->assertEquals(
                $result,
                $glob->glob($input, $pattern)
            );
        }
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [
                // Data
                [
                    'foo' => [
                        'bar' => [
                            'baz' => ''
                        ],
                        'qux' => [
                            'baz' => ''
                        ]
                    ],
                    'quux' => [
                        'bar' => [
                            'baz' => ''
                        ]
                    ],
                    'quuux' => [
                        'bar' => [
                            'baz' => ''
                        ]
                    ],
                ],
                // Patterns and their results
                [
                    'foo.bar.baz' => [
                        'foo.bar.baz'
                    ],
                    'foo.qux' => [
                        'foo.qux'
                    ],
                    'foo.bar.baz.qux' => [],
                    '*.bar.baz' => [
                        'foo.bar.baz',
                        'quux.bar.baz',
                        'quuux.bar.baz',
                    ],
                    '*.*.baz' => [
                        'foo.bar.baz',
                        'foo.qux.baz',
                        'quux.bar.baz',
                        'quuux.bar.baz',
                    ],
                    'qu*.*.baz' => [
                        'quux.bar.baz',
                        'quuux.bar.baz',
                    ]
                ]
            ]
        ];
    }
}
