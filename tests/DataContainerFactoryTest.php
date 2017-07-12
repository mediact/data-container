<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use Mediact\DataContainer\DataContainer;
use PHPUnit\Framework\TestCase;
use Mediact\DataContainer\DataContainerFactory;

/**
 * @coversDefaultClass \Mediact\DataContainer\DataContainerFactory
 */
class DataContainerFactoryTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::create
     */
    public function testCreate()
    {
        $data      = ['some_data'];
        $factory   = new DataContainerFactory();
        $container = $factory->create($data);

        $this->assertInstanceOf(DataContainer::class, $container);
        $this->assertEquals($data, $container->all());
    }
}
