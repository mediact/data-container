<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use Mediact\DataContainer\DataContainer;
use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\Tests\TestDouble\DataContainerImplementationDouble;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Mediact\DataContainer\DataContainerDecoratorTrait
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DataContainerDecoratorTraitTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::setData
     * @covers ::getStorage
     */
    public function testSetData()
    {
        $data = ['some_data'];

        $double = new DataContainerImplementationDouble();
        $double->pokeData($data);
        $this->assertEquals($data, $double->peekStorage()->all());
    }

    /**
     * @return void
     *
     * @covers ::setStorage
     * @covers ::getStorage
     */
    public function testSetStorage()
    {
        $storage = $this->createMock(DataContainerInterface::class);

        $double = new DataContainerImplementationDouble($storage);
        $this->assertSame($storage, $double->peekStorage());
    }

    /**
     * @return void
     *
     * @covers ::has
     */
    public function testHas()
    {
        $path    = 'foo.bar';
        $result  = true;
        $storage = $this->createMock(DataContainerInterface::class);
        $storage
            ->expects(self::once())
            ->method('has')
            ->with($path)
            ->willReturn($result);

        $double = new DataContainerImplementationDouble($storage);
        $this->assertEquals($result, $double->has($path));
    }

    /**
     * @return void
     *
     * @covers ::get
     */
    public function testGet()
    {
        $path    = 'foo.bar';
        $result  = 'foo_bar_value';
        $storage = $this->createMock(DataContainerInterface::class);
        $storage
            ->expects(self::once())
            ->method('get')
            ->with($path)
            ->willReturn($result);

        $double = new DataContainerImplementationDouble($storage);
        $this->assertEquals($result, $double->get($path));
    }

    /**
     * @return void
     *
     * @covers ::all
     */
    public function testAll()
    {
        $result  = ['some_data'];
        $storage = $this->createMock(DataContainerInterface::class);
        $storage
            ->expects(self::once())
            ->method('all')
            ->willReturn($result);

        $double = new DataContainerImplementationDouble($storage);
        $this->assertEquals($result, $double->all());
    }

    /**
     * @return void
     *
     * @covers ::set
     */
    public function testSet()
    {
        $path    = 'foo.bar';
        $value   = 'foo_bar_value';
        $storage = $this->createMock(DataContainerInterface::class);
        $storage
            ->expects(self::once())
            ->method('set')
            ->with($path, $value);

        $double = new DataContainerImplementationDouble($storage);
        $double->set($path, $value);
    }

    /**
     * @return void
     *
     * @covers ::remove
     */
    public function testRemove()
    {
        $pattern = 'foo.bar.*';
        $storage = $this->createMock(DataContainerInterface::class);
        $storage
            ->expects(self::once())
            ->method('remove')
            ->with($pattern);

        $double = new DataContainerImplementationDouble($storage);
        $double->remove($pattern);
    }

    /**
     * @return void
     *
     * @covers ::glob
     */
    public function testGlob()
    {
        $pattern = 'foo.bar.*';
        $result  = ['foo.bar.baz'];
        $storage = $this->createMock(DataContainerInterface::class);
        $storage
            ->expects(self::once())
            ->method('glob')
            ->with($pattern)
            ->willReturn($result);

        $double = new DataContainerImplementationDouble($storage);
        $this->assertEquals($result, $double->glob($pattern));
    }

    /**
     * @return void
     *
     * @covers ::expand
     */
    public function testExpand()
    {
        $pattern     = 'foo.bar.*';
        $replacement = 'foo.baz.$1';
        $result      = ['foo.bar.baz' => 'foo.baz.baz'];

        $storage = $this->createMock(DataContainerInterface::class);
        $storage
            ->expects(self::once())
            ->method('expand')
            ->with($pattern, $replacement)
            ->willReturn($result);

        $double = new DataContainerImplementationDouble($storage);
        $this->assertEquals($result, $double->expand($pattern, $replacement));
    }

    /**
     * @return void
     *
     * @covers ::branch
     */
    public function testBranch()
    {
        $pattern = 'foo.bar.*';
        $result  = [new DataContainer()];
        $storage = $this->createMock(DataContainerInterface::class);
        $storage
            ->expects(self::once())
            ->method('branch')
            ->with($pattern)
            ->willReturn($result);

        $double = new DataContainerImplementationDouble($storage);
        $this->assertEquals($result, $double->branch($pattern));
    }

    /**
     * @return void
     *
     * @covers ::node
     */
    public function testNode()
    {
        $path    = 'foo.bar';
        $result  = $this->createMock(DataContainerInterface::class);
        $storage = $this->createMock(DataContainerInterface::class);
        $storage
            ->expects(self::once())
            ->method('node')
            ->with($path)
            ->willReturn($result);

        $double = new DataContainerImplementationDouble($storage);
        $this->assertSame($result, $double->node($path));
    }

    /**
     * @return void
     *
     * @covers ::copy
     */
    public function testCopy()
    {
        $pattern     = 'foo.bar.*';
        $destination = 'foo.baz.$1';
        $storage     = $this->createMock(DataContainerInterface::class);
        $storage
            ->expects(self::once())
            ->method('copy')
            ->with($pattern, $destination);

        $double = new DataContainerImplementationDouble($storage);
        $double->copy($pattern, $destination);
    }

    /**
     * @return void
     *
     * @covers ::move
     */
    public function testMove()
    {
        $pattern     = 'foo.bar.*';
        $destination = 'foo.baz.$1';
        $storage     = $this->createMock(DataContainerInterface::class);
        $storage
            ->expects(self::once())
            ->method('move')
            ->with($pattern, $destination);

        $double = new DataContainerImplementationDouble($storage);
        $double->move($pattern, $destination);
    }

    /**
     * @return void
     *
     * @covers ::__clone
     */
    public function testClone()
    {
        $set     = ['foo' => 'bar'];
        $merged  = array_merge($set, ['baz' => 'qux']);
        $storage = new DataContainer($set);
        $double  = new DataContainerImplementationDouble($storage);
        $clone   = clone $double;

        // Assert that the original consecutively returns sets.
        $this->assertEquals($set, $double->all());
        $double->set('baz', 'qux');
        $this->assertEquals($merged, $double->all());

        // Then assert that the clone still consecutively returns the same sets.
        $this->assertEquals($set, $clone->all());
        $clone->set('baz', 'qux');
        $this->assertEquals($merged, $clone->all());
    }
}
