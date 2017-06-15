<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

use League\Flysystem\FilesystemInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class FileDataContainerFactory extends DataContainerFactory implements
    FileDataContainerFactoryInterface
{
    /** @var FilesystemInterface */
    private $fileSystem;

    /** @var DecoderInterface */
    private $decoder;

    /** @var string */
    private $format;

    /**
     * Constructor.
     *
     * @param FilesystemInterface $fileSystem
     * @param DecoderInterface    $decoder
     * @param string              $format
     */
    public function __construct(
        FilesystemInterface $fileSystem,
        DecoderInterface $decoder,
        string $format
    ) {
        $this->fileSystem = $fileSystem;
        $this->decoder    = $decoder;
        $this->format     = $format;
    }

    /**
     * Create a data container based on the contents of the given file.
     *
     * @param string $file
     *
     * @return DataContainerInterface
     */
    public function createFromFile(string $file): DataContainerInterface
    {
        $contents = $this->fileSystem->read($file);

        return parent::createContainer(
            $this->decoder->decode($contents, $this->format)
        );
    }
}
