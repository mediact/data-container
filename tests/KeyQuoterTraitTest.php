<?php

/**
 * Copyright Alumio. All rights reserved.
 * https://www.alumio.com
 */

declare(strict_types=1);

namespace Mediact\DataContainer\Tests;

use Mediact\DataContainer\KeyQuoterTrait;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Mediact\DataContainer\KeyQuoterTrait
 */
class KeyQuoterTraitTest extends TestCase
{
    /**
     * @param string $key
     * @param string $expected
     *
     * @return void
     *
     * @covers ::quoteKey
     *
     * @dataProvider dataProvider
     */
    public function testParsePath(string $key, string $expected)
    {
        $subject = new class () {
            use KeyQuoterTrait;

            /**
             * @param string $key
             *
             * @return string
             */
            public function peekQuoteKey(string $key): string
            {
                return $this->quoteKey($key);
            }
        };

        self::assertSame($expected, $subject->peekQuoteKey($key));
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [
                '$key'      => 'foo',
                '$expected' => 'foo'
            ],
            [
                '$key'      => 'foo.bar.baz',
                '$expected' => '"foo.bar.baz"'
            ],
            [
                '$key'      => 'fo"o',
                '$expected' => 'fo"o'
            ],
            [
                '$key'      => 'fo"o.bar.baz',
                '$expected' => '"fo""o.bar.baz"'
            ]
        ];
    }
}
