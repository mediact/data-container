<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

use xmarcos\Dot\Container as DotContainer;

/**
 * Creates data containers.
 */
class DataContainerFactory implements DataContainerFactoryInterface
{
    /**
     * Create a data container.
     *
     * @param array $data
     *
     * @return DataContainerInterface
     */
    public function createContainer(array $data = []): DataContainerInterface
    {
        return new DataContainer(
            new DotContainer($data)
        );
    }
}
