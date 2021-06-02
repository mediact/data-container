<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

use ArrayIterator;
use IteratorIterator;

class DataContainerIterator extends IteratorIterator implements
    DataContainerIteratorInterface
{
    /**
     * Constructor
     *
     * @param DataContainerInterface ...$items
     */
    public function __construct(
        DataContainerInterface ...$items
    ) {
        parent::__construct(new ArrayIterator($items));
    }

    /**
     * Get the current item.
     *
     * @return DataContainerInterface
     */
    public function current(): DataContainerInterface
    {
        return parent::current();
    }
}
