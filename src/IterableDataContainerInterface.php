<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

use Traversable;

/**
 * @deprecated DataContainerInterface is iterable.
 */
interface IterableDataContainerInterface extends
    DataContainerInterface
{
    /**
     * Retrieve an external iterator.
     *
     * @return Traversable
     */
    public function getIterator(): Traversable;
}
