<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

interface DataContainerFilterInterface
{
    /**
     * Filter the given container.
     *
     * @param DataContainerInterface $container
     *
     * @return bool
     */
    public function __invoke(DataContainerInterface $container): bool;
}
