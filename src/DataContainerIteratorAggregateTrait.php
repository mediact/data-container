<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

use ArrayIterator;
use Traversable;

/**
 * Implements IteratorAggregate
 */
trait DataContainerIteratorAggregateTrait
{
    /**
     * Retrieve an external iterator
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator(
            $this->getStorage()->all()
        );
    }

    /**
     * Get the storage.
     *
     * @return DataContainerInterface
     */
    abstract protected function getStorage(): DataContainerInterface;
}
