<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use Mediact\DataContainer\DataContainerFactory;
use Mediact\DataContainer\DataContainerInterface;
use PHPUnit_Framework_TestCase;

class DataContainerFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test creating a container.
     *
     * @return DataContainerInterface
     *
     * @covers Mediact\DataContainer\DataContainerFactory::createContainer
     */
    public function testCreateContainer(): DataContainerInterface
    {
        $factory = new DataContainerFactory();
        return $factory->createContainer();
    }
}
