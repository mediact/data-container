<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use Mediact\DataContainer\DataContainerFilterInterface;
use Mediact\DataContainer\DataContainerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Mediact\DataContainer\DataContainerFilterChain;

/**
 * @coversDefaultClass \Mediact\DataContainer\DataContainerFilterChain
 */
class DataContainerFilterChainTest extends TestCase
{
    /**
     * @dataProvider filterProvider
     *
     * @param bool                           $expected
     * @param DataContainerFilterInterface[] ...$filters
     *
     * @return void
     *
     * @covers ::__construct
     * @covers ::__invoke
     */
    public function testFilter(bool $expected, DataContainerFilterInterface ...$filters): void
    {
        $chain = new DataContainerFilterChain(...$filters);

        $this->assertInstanceOf(DataContainerFilterChain::class, $chain);

        $this->assertEquals(
            $expected,
            $chain(
                $this->createMock(DataContainerInterface::class)
            )
        );
    }

    /**
     * @return bool[][]|DataContainerFilterInterface[][]
     */
    public function filterProvider(): array
    {
        return [
            [true],
            [
                true,
                $this->createFilter(true)
            ],
            [
                true,
                $this->createFilter(true),
                $this->createFilter(true),
                $this->createFilter(true)
            ],
            [
                false,
                $this->createFilter(false)
            ],
            [
                false,
                $this->createFilter(true),
                $this->createFilter(true),
                $this->createFilter(false)
            ],
            [
                false,
                $this->createFilter(true),
                $this->createFilter(false),
                $this->createFilter(true)
            ],
            [
                false,
                $this->createFilter(false),
                $this->createFilter(true),
                $this->createFilter(true)
            ],
            [
                false,
                $this->createFilter(false),
                $this->createFilter(false),
                $this->createFilter(true)
            ],
            [
                false,
                $this->createFilter(false),
                $this->createFilter(false),
                $this->createFilter(false)
            ]
        ];
    }

    /**
     * @param bool $accept
     *
     * @return DataContainerFilterInterface
     */
    private function createFilter(bool $accept): DataContainerFilterInterface
    {
        /** @var DataContainerFilterInterface|MockObject $filter */
        $filter = $this->createMock(DataContainerFilterInterface::class);

        $filter
            ->expects(self::any())
            ->method('__invoke')
            ->with(
                self::isInstanceOf(DataContainerInterface::class)
            )
            ->willReturn($accept);

        return $filter;
    }
}
