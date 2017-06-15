<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests;

use League\Flysystem\FilesystemInterface;
use Mediact\DataContainer\DataContainerInterface;
use PHPUnit\Framework\TestCase;
use Mediact\DataContainer\FileDataContainerFactory;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * @coversDefaultClass \Mediact\DataContainer\FileDataContainerFactory
 */
class FileDataContainerFactoryTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(
            FileDataContainerFactory::class,
            new FileDataContainerFactory(
                $this->createMock(FilesystemInterface::class),
                $this->createMock(DecoderInterface::class),
                JsonEncoder::FORMAT
            )
        );
    }

    /**
     * @dataProvider fileProvider
     *
     * @param string $file
     * @param string $encoded
     * @param array  $decoded
     *
     * @return void
     * @covers ::createFromFile
     */
    public function testCreateFromFile(
        string $file,
        string $encoded,
        array $decoded
    ) {
        $fileSystem = $this->createMock(FilesystemInterface::class);
        $fileSystem
            ->expects($this->once())
            ->method('read')
            ->with($this->isType('string'))
            ->willReturn($encoded);

        $decoder = $this->createMock(DecoderInterface::class);
        $decoder
            ->expects($this->once())
            ->method('decode')
            ->with(
                $encoded,
                $this->isType('string')
            )
            ->willReturn($decoded);

        $factory = new FileDataContainerFactory(
            $fileSystem,
            $decoder,
            'foo-format'
        );

        $this->assertInstanceOf(
            DataContainerInterface::class,
            $factory->createFromFile($file)
        );
    }

    /**
     * @return mixed[][]
     */
    public function fileProvider(): array
    {
        return [
            [
                'storage://file.xml',
                '<foo>Bar</foo>',
                ['foo' => 'bar']
            ],
            [
                'storage://file.json',
                '{"foo":"bar"}',
                ['foo' => 'bar']
            ]
        ];
    }
}
