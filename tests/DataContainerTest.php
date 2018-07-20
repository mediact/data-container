<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use Mediact\DataContainer\DataContainer;
use Mediact\DataContainer\DataContainerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Mediact\DataContainer\DataContainer
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DataContainerTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(
            DataContainer::class,
            new DataContainer()
        );
    }

    /**
     * @param array  $data
     * @param string $path
     * @param bool   $expected
     *
     * @return void
     *
     * @dataProvider hasDataProvider
     *
     * @covers ::has
     * @covers ::parsePath
     */
    public function testHas(array $data, string $path, bool $expected)
    {
        $container = new DataContainer($data);
        $this->assertEquals($expected, $container->has($path));
    }

    /**
     * @return array
     */
    public function hasDataProvider(): array
    {
        return [
            [
                $this->valuesProvider(),
                'foo',
                true
            ],
            [
                $this->valuesProvider(),
                'foo.baz.qux',
                true
            ],
            [
                $this->valuesProvider(),
                'foo.baz.quux.1',
                true
            ],
            [
                $this->valuesProvider(),
                'foo.baz.quux.4',
                false
            ],
            [
                [],
                'foo',
                false
            ],
            [
                [],
                'foo.bar',
                false
            ]
        ];
    }

    /**
     * @param array  $data
     * @param string $path
     * @param mixed  $default
     * @param mixed  $expected
     *
     * @return void
     *
     * @dataProvider getDataProvider
     *
     * @covers ::get
     * @covers ::parsePath
     */
    public function testGet(array $data, string $path, $default, $expected)
    {
        $container = new DataContainer($data);
        $this->assertEquals($expected, $container->get($path, $default));
    }

    /**
     * @return array
     */
    public function getDataProvider(): array
    {
        return [
            [
                $this->valuesProvider(),
                'foo',
                'some_default',
                $this->valuesProvider()['foo']
            ],
            [
                $this->valuesProvider(),
                'foo.baz.qux',
                'some_default',
                $this->valuesProvider()['foo']['baz']['qux']
            ],
            [
                $this->valuesProvider(),
                'foo.baz.quux.1',
                'some_default',
                $this->valuesProvider()['foo']['baz']['quux'][1]
            ],
            [
                $this->valuesProvider(),
                'foo.baz.quuux',
                'some_default',
                'some_default'
            ],
            [
                [],
                'foo',
                ['some_default'],
                ['some_default']
            ],
            [
                [],
                'foo.bar',
                ['some_default'],
                ['some_default']
            ]
        ];
    }

    /**
     * @param array $data
     *
     * @return void
     *
     * @dataProvider allDataProvider
     *
     * @covers ::all
     */
    public function testAll(array $data)
    {
        $container = new DataContainer($data);
        $this->assertEquals($data, $container->all());
    }

    /**
     * @return array
     */
    public function allDataProvider(): array
    {
        return [
            [
                $this->valuesProvider()
            ]
        ];
    }

    /**
     * @param array  $data
     * @param string $path
     * @param mixed  $value
     * @param array  $expected
     *
     * @return void
     *
     * @dataProvider setDataProvider
     *
     * @covers ::set
     * @covers ::getNodeReference
     */
    public function testSet(array $data, string $path, $value, array $expected)
    {
        $container = new DataContainer($data);
        $container->set($path, $value);
        $this->assertEquals($expected, $container->all());
    }

    /**
     * @return array
     */
    public function setDataProvider(): array
    {
        $valuesA = $valuesB = $valuesC = $valuesD = $this->valuesProvider();

        $valuesA['foo']                   = 'new_value';
        $valuesB['foo']['baz']['qux']     = 'new_value';
        $valuesC['foo']['baz']['quux'][1] = 'new_value';
        $valuesD['quux']['quuux']['foo']  = 'new_value';

        return [
            [
                $this->valuesProvider(),
                'foo',
                'new_value',
                $valuesA
            ],
            [
                $this->valuesProvider(),
                'foo.baz.qux',
                'new_value',
                $valuesB
            ],
            [
                $this->valuesProvider(),
                'foo.baz.quux.1',
                'new_value',
                $valuesC
            ],
            [
                $this->valuesProvider(),
                'quux.quuux.foo',
                'new_value',
                $valuesD
            ]
        ];
    }

    /**
     * @param array  $data
     * @param string $pattern
     * @param array  $expected
     *
     * @return void
     *
     * @dataProvider removeDataProvider
     *
     * @covers ::remove
     * @covers ::getNodeReference
     */
    public function testRemove(array $data, string $pattern, array $expected)
    {
        $container = new DataContainer($data);
        $container->remove($pattern);
        $this->assertEquals($expected, $container->all());
    }

    /**
     * @return array
     */
    public function removeDataProvider(): array
    {
        $valuesA = $valuesB = $valuesC = $valuesD = $this->valuesProvider();

        unset($valuesA['foo']);
        unset($valuesB['foo']['baz']['qux']);
        unset($valuesB['foo']['baz']['quux']);
        unset($valuesC['foo']['baz']['quux'][1]);

        return [
            [
                $this->valuesProvider(),
                'foo',
                $valuesA
            ],
            [
                $this->valuesProvider(),
                'foo.baz.*',
                $valuesB
            ],
            [
                $this->valuesProvider(),
                'foo.baz.quux.1',
                $valuesC
            ],
            [
                $this->valuesProvider(),
                'quux.quuux.foo',
                $valuesD
            ]
        ];
    }

    /**
     * @param array  $data
     * @param string $pattern
     * @param array  $expected
     *
     * @return void
     *
     * @dataProvider globDataProvider
     *
     * @covers ::glob
     * @covers ::findArrayPathsByPatterns
     */
    public function testGlob(array $data, string $pattern, array $expected)
    {
        $container = new DataContainer($data);

        $this->assertEquals(
            $expected,
            $container->glob($pattern)
        );
    }

    /**
     * @return array
     */
    public function globDataProvider(): array
    {
        return [
            [
                $this->valuesProvider(),
                'foo',
                ['foo']
            ],
            [
                $this->valuesProvider(),
                '*',
                ['foo', 'bar', 'baz', 'qux', 'quux']
            ],
            [
                $this->valuesProvider(),
                'foo.ba*.*',
                ['foo.baz.qux', 'foo.baz.quux']
            ],
            [
                $this->valuesProvider(),
                'foo.ba?.*x',
                ['foo.baz.qux', 'foo.baz.quux']
            ],
            [
                $this->valuesProvider(),
                '*o.baz',
                ['foo.baz']
            ],
            [
                $this->valuesProvider(),
                'quux.*',
                ['quux.0', 'quux.1', 'quux.2']
            ],
            // Assert glob does not escape paths.
            [
                [
                    'models' => [
                        'Foo\Bar\Baz' => [
                            'qux' => 'quux'
                        ]
                    ]
                ],
                '*.Foo\Bar\*',
                ['models.Foo\Bar\Baz']
            ]
        ];
    }

    /**
     * @param array  $data
     * @param string $pattern
     * @param string $replacement
     * @param array  $expected
     *
     * @return void
     *
     * @dataProvider expandDataProvider
     *
     * @covers ::expand
     */
    public function testExpand(
        array $data,
        string $pattern,
        string $replacement,
        array $expected
    ) {
        $container = new DataContainer($data);
        $this->assertEquals(
            $expected,
            $container->expand($pattern, $replacement)
        );
    }

    /**
     * @return array
     */
    public function expandDataProvider(): array
    {
        return [
            [
                $this->valuesProvider(),
                'foo',
                'bar',
                ['foo' => 'bar']
            ],
            [
                $this->valuesProvider(),
                'foo.*',
                'bar.$1',
                ['foo.bar' => 'bar.bar', 'foo.baz' => 'bar.baz']
            ],
            [
                $this->valuesProvider(),
                'foo.ba?',
                'bar.ba$1',
                ['foo.bar' => 'bar.bar', 'foo.baz' => 'bar.baz']
            ],
            [
                $this->valuesProvider(),
                'foo.ba[rz]',
                'bar.ba$1',
                ['foo.bar' => 'bar.bar', 'foo.baz' => 'bar.baz']
            ],
            [
                $this->valuesProvider(),
                'foo.*',
                'qux.$0',
                ['foo.bar' => 'qux.foo.bar', 'foo.baz' => 'qux.foo.baz']
            ]
        ];
    }

    /**
     * @param array  $data
     * @param string $pattern
     * @param array  $expected
     *
     * @return void
     *
     * @dataProvider branchDataProvider
     *
     * @covers ::branch
     */
    public function testBranch(array $data, string $pattern, array $expected)
    {
        $container = new DataContainer($data);
        $result    = $container->branch($pattern);

        $this->assertContainsOnlyInstancesOf(DataContainer::class, $result);
        $this->assertEquals(
            $expected,
            array_map(
                function (DataContainerInterface $branch) : array {
                    return $branch->all();
                },
                $result
            )
        );
    }

    /**
     * @return array
     */
    public function branchDataProvider(): array
    {
        return [
            [
                $this->valuesProvider(),
                'foo',
                [$this->valuesProvider()['foo']]
            ],
            [
                $this->valuesProvider(),
                'foo.baz',
                [$this->valuesProvider()['foo']['baz']]
            ],
            [
                $this->valuesProvider(),
                'foo.*',
                [
                    [$this->valuesProvider()['foo']['bar']],
                    $this->valuesProvider()['foo']['baz']
                ]
            ],
            [
                $this->valuesProvider(),
                'quux',
                [$this->valuesProvider()['quux']]
            ]
        ];
    }

    /**
     * @param array  $data
     * @param string $path
     * @param array  $expected
     *
     * @return void
     *
     * @dataProvider nodeDataProvider
     *
     * @covers ::node
     */
    public function testNode(array $data, string $path, array $expected)
    {
        $container = new DataContainer($data);
        $result    = $container->node($path);

        $this->assertInstanceOf(DataContainer::class, $result);
        $this->assertEquals($expected, $result->all());
    }

    /**
     * @return array
     */
    public function nodeDataProvider(): array
    {
        return [
            [
                $this->valuesProvider(),
                'foo',
                $this->valuesProvider()['foo']
            ],
            [
                $this->valuesProvider(),
                'foo.baz',
                $this->valuesProvider()['foo']['baz']
            ],
            [
                $this->valuesProvider(),
                'foo.bar',
                []
            ],
            [
                $this->valuesProvider(),
                'invalid',
                []
            ]
        ];
    }

    /**
     * @param array  $data
     * @param string $pattern
     * @param string $replacement
     * @param array  $expected
     *
     * @return void
     *
     * @dataProvider copyDataProvider
     *
     * @covers ::copy
     */
    public function testCopy(
        array $data,
        string $pattern,
        string $replacement,
        array $expected
    ) {
        $container = new DataContainer($data);
        $container->copy($pattern, $replacement);
        $this->assertEquals($expected, $container->all());
    }

    /**
     * @return array
     */
    public function copyDataProvider(): array
    {
        $valuesA = $valuesB = $valuesC = $valuesD = $this->valuesProvider();

        $valuesA['quuux']        = $valuesA['foo'];
        $valuesB['quuux']['baz'] = $valuesB['foo']['baz']['qux'];
        $valuesC['foo']          = $valuesC['foo']['baz']['quux'];
        $valuesD['foo']          = $valuesD['quux'][2];

        return [
            [
                $this->valuesProvider(),
                'foo',
                'quuux',
                $valuesA
            ],
            [
                $this->valuesProvider(),
                'foo.*.qux',
                'quuux.$1',
                $valuesB
            ],
            [
                $this->valuesProvider(),
                'foo.baz.quux',
                'foo',
                $valuesC
            ],
            [
                $this->valuesProvider(),
                'quux.*',
                'foo',
                $valuesD
            ]
        ];
    }

    /**
     * @param array  $data
     * @param string $pattern
     * @param string $replacement
     * @param array  $expected
     *
     * @return void
     *
     * @dataProvider moveDataProvider
     *
     * @covers ::move
     */
    public function testMove(
        array $data,
        string $pattern,
        string $replacement,
        array $expected
    ) {
        $container = new DataContainer($data);
        $container->move($pattern, $replacement);
        $this->assertEquals($expected, $container->all());
    }

    /**
     * @return array
     */
    public function moveDataProvider(): array
    {
        $valuesA = $valuesB = $valuesC = $valuesD = $this->valuesProvider();

        $valuesA['quuux'] = $valuesA['foo'];
        unset($valuesA['foo']);

        $valuesB['quuux']['baz'] = $valuesB['foo']['baz']['qux'];
        unset($valuesB['foo']['baz']['qux']);

        $valuesC['foo'] = $valuesC['foo']['baz']['quux'];
        unset($valuesC['foo']['baz']['quux']);

        $valuesD['foo']['qux'] = $valuesD['foo'];

        return [
            [
                $this->valuesProvider(),
                'foo',
                'quuux',
                $valuesA
            ],
            [
                $this->valuesProvider(),
                'foo.*.qux',
                'quuux.$1',
                $valuesB
            ],
            [
                $this->valuesProvider(),
                'foo.baz.quux',
                'foo',
                $valuesC
            ],
            [
                $this->valuesProvider(),
                'foo',
                'foo.qux',
                $valuesD
            ]
        ];
    }

    /**
     * @param array $values
     *
     * @return void
     *
     * @covers ::getIterator
     *
     * @dataProvider getIteratorDataProvider
     */
    public function testGetIterator(array $values): void
    {
        $subject = new DataContainer($values);
        $this->assertSame($values, iterator_to_array($subject->getIterator()));
        $this->assertSame($values, iterator_to_array($subject));
    }

    /**
     * @return array
     */
    public function getIteratorDataProvider(): array
    {
        return [
            [$this->valuesProvider()]
        ];
    }

    /**
     * @return array
     */
    private function valuesProvider(): array
    {
        return [
            'foo' => [
                'bar' => 'foo_bar_value',
                'baz' => [
                    'qux' => null,
                    'quux' => [
                        'foo',
                        'bar',
                        'baz'
                    ]
                ]
            ],
            'bar' => [
                'baz' => 'bar_baz_value',
                'qux' => 'bar_qux_value'
            ],
            'baz' => 'baz_value',
            'qux' => null,
            'quux' => [
                'foo',
                'bar',
                'baz'
            ]
        ];
    }
}
