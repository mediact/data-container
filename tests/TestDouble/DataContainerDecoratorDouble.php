<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests\TestDouble;

use Mediact\DataContainer\DataContainer;
use Mediact\DataContainer\DataContainerDecoratorTrait;
use Mediact\DataContainer\DataContainerInterface;

class DataContainerDecoratorDouble implements DataContainerInterface
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
     * @param array $data
     *
     * @return void
     */
    public function pokeData(array $data)
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
