<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\Tests\TestDouble\DataContainerImplementationDouble;
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

        $double = new DataContainerImplementationDouble($storage);
        $this->assertEquals($data, iterator_to_array($double));
    }
}
