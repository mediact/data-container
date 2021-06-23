<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

/**
 * Creates data containers.
 */
interface DataContainerFactoryInterface
{
    /**
     * Create a data container.
     *
     * @param array $data
     *
     * @return DataContainerInterface
     */
    public function create(array $data = []): DataContainerInterface;
}
