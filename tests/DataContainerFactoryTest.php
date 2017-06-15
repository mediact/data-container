<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use Mediact\DataContainer\DataContainerFactory;
use Mediact\DataContainer\DataContainerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Mediact\DataContainer\DataContainerFactory
 */
class DataContainerFactoryTest extends TestCase
{
    /**
     * Test creating a container.
     *
     * @return void
     *
     * @covers ::createContainer
     */
    public function testCreateContainer()
    {
        $factory = new DataContainerFactory();

        $this->assertInstanceOf(
            DataContainerInterface::class,
            $factory->createContainer()
        );
    }
}
