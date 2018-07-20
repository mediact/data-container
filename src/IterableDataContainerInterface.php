<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

use IteratorAggregate;
use Traversable;

interface IterableDataContainerInterface extends
    DataContainerInterface,
    IteratorAggregate
{
    /**
     * Retrieve an external iterator.
     *
     * @return Traversable
     */
    public function getIterator(): Traversable;
}
