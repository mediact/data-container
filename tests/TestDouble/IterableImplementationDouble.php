<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests\TestDouble;

use IteratorAggregate;
use Mediact\DataContainer\DataContainer;
use Mediact\DataContainer\DataContainerDecoratorTrait;
use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\DataContainerIteratorAggregateTrait;

class IterableImplementationDouble implements IteratorAggregate
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
}
