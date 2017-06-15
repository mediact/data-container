<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

interface FileDataContainerFactoryInterface extends DataContainerFactoryInterface
{
    /**
     * Create a data container based on the contents of the given file.
     *
     * @param string $file
     *
     * @return DataContainerInterface
     */
    public function createFromFile(string $file): DataContainerInterface;
}
