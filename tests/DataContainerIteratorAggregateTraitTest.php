<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use IteratorAggregate;
use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\DataContainerIteratorAggregateTrait;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Mediact\DataContainer\DataContainerIteratorAggregateTrait
 */
class DataContainerIteratorAggregateTraitTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::getIterator
     */
    public function testGetIterator()
    {
        $data = ['some_data'];

        $storage = $this->createMock(DataContainerInterface::class);
        $storage
            ->expects(self::once())
            ->method('all')
            ->willReturn($data);

        $double = new class ($storage) implements IteratorAggregate
        {
            use DataContainerIteratorAggregateTrait;

            /** @var DataContainerInterface */
            private $storage;

            /**
             * Constructor.
             *
             * @param DataContainerInterface $storage
             */
            public function __construct(DataContainerInterface $storage)
            {
                $this->storage = $storage;
            }

            /**
             * Get the storage.
             *
             * @return DataContainerInterface
             */
            protected function getStorage(): DataContainerInterface
            {
                return $this->storage;
            }
        };

        $this->assertEquals($data, iterator_to_array($double));
    }
}
