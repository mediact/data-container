<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace Mediact\DataContainer\Tests;

use PHPUnit_Framework_TestCase;
use Mediact\DataContainer\ArrayGlob;

/**
 * @coversDefaultClass \Mediact\DataContainer\ArrayGlob
 */
class ArrayGlobTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return ArrayGlob
     *
     * @covers ::__construct
     */
    public function testConstructor(): ArrayGlob
    {
        return new ArrayGlob('.');
    }

    /**
     * @depends testConstructor
     *
     * @param array     $input
     * @param array     $expected
     * @param ArrayGlob $glob
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
        ArrayGlob $glob
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
