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

class DataContainerImplementationDouble implements DataContainerInterface
{
    use DataContainerDecoratorTrait;

    /**
     * Constructor.
     *
     * @param DataContainerInterface|null $storage
     */
    public function __construct(DataContainerInterface $storage = null)
    {
        $this->setStorage($storage ?: new DataContainer());
    }

    /**
     * @param iterable $data
     *
     * @return void
     */
    public function pokeData(iterable $data)
    {
        $this->setData($data);
    }

    /**
     * @return DataContainerInterface
     */
    public function peekStorage(): DataContainerInterface
    {
        return $this->getStorage();
    }
}
