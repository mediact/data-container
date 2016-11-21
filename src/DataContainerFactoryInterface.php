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
     * @return DataContainerInterface
     */
    public function createContainer(): DataContainerInterface;
}
