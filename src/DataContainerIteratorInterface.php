<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

use Iterator;

interface DataContainerIteratorInterface extends Iterator
{
    /**
     * Get the current item.
     *
     * @return DataContainerInterface
     */
    public function current(): DataContainerInterface;
}
