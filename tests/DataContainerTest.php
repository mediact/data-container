<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use Mediact\DataContainer\DataContainer;
use PHPUnit_Framework_TestCase;

class DataContainerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test the constructor.
     *
     * @return DataContainer
     *
     * @covers Mediact\DataContainer\DataContainer::__construct
     */
    public function testConstructor() : DataContainer
    {
        return $this->createContainer();
    }

    /**
     * Test has-method.
     *
     * @param string $path
     * @param mixed  $value
     *
     * @return void
     *
     * @dataProvider valuesProvider
     *
     * @covers Mediact\DataContainer\DataContainer::has
     */
    public function testHas(string $path, $value)
    {
        $container = $this->createContainer()
            ->with($path, $value);

        $this->assertEquals(true, $container->has($path));
        $this->assertEquals(false, $container->has('other.path'));
    }

    /**
     * Test get-method.
     *
     * @param string $path
     * @param mixed  $value
     *
     * @return void
     *
     * @dataProvider valuesProvider
     *
     * @covers Mediact\DataContainer\DataContainer::get
     */
    public function testGet(string $path, $value)
    {
        $container = $this->createContainer()
            ->with($path, $value);

        $this->assertEquals($value, $container->get($path));
        $this->assertEquals('other value', $container->get('other.path', 'other value'));
    }

    /**
     * Test with-method.
     *
     * @param string $path
     * @param mixed  $value
     *
     * @return void
     *
     * @dataProvider valuesProvider
     *
     * @covers Mediact\DataContainer\DataContainer::with
     */
    public function testWith(string $path, $value)
    {
        $container = $this->createContainer();

        $this->assertEquals(false, $container->has($path));
        $containerWith = $container->with($path, $value);

        $this->assertNotSame($container, $containerWith);
        $this->assertEquals(false, $container->has($path));
        $this->assertEquals(true, $containerWith->has($path));
        $this->assertEquals($value, $containerWith->get($path));
    }

    /**
     * Test without-method.
     *
     * @param string $path
     * @param mixed  $value
     *
     * @return void
     *
     * @dataProvider valuesProvider
     *
     * @covers Mediact\DataContainer\DataContainer::without
     */
    public function testWithout(string $path, $value)
    {
        $container = $this->createContainer()
            ->with($path, $value);

        $this->assertEquals(true, $container->has($path));
        $containerWithout = $container->without($path);

        $this->assertNotSame($container, $containerWithout);
        $this->assertEquals(true, $container->has($path));
        $this->assertEquals(false, $containerWithout->has($path));
    }

    /**
     * Values for the tests.
     *
     * @return array
     */
    public function valuesProvider()
    {
        return [
            [
                'some.path',
                'some value'
            ],
            [
                'some.other.path',
                [
                    'some',
                    'values'
                ]
            ]
        ];
    }

    /**
     * Create a data container.
     *
     * @return DataContainer
     */
    protected function createContainer() : DataContainer
    {
        return new DataContainer();
    }
}
