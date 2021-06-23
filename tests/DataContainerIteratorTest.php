<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use Mediact\DataContainer\DataContainerInterface;
use PHPUnit\Framework\TestCase;
use Mediact\DataContainer\DataContainerIterator;

/**
 * @coversDefaultClass \Mediact\DataContainer\DataContainerIterator
 */
class DataContainerIteratorTest extends TestCase
{
    /**
     * @param array $containers
     *
     * @return void
     *
     * @covers ::__construct
     * @covers ::current
     *
     * @dataProvider dataProvider
     */
    public function testCurrent(array $containers): void
    {
        $subject = new DataContainerIterator(...$containers);
        $this->assertSame(
            $containers,
            iterator_to_array($subject)
        );
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [
                [
                    $this->createMock(DataContainerInterface::class),
                    $this->createMock(DataContainerInterface::class),
                ]
            ],
            [
                []
            ]
        ];
    }
}
