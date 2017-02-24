<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace Mediact\DataContainer;

/**
 * Finds paths in arrays.
 */
interface ArrayGlobInterface
{
    /**
     * Find the paths in an array that match a pattern.
     *
     * @param array  $data
     * @param string $pattern
     *
     * @return array
     */
    public function glob(
        array $data,
        string $pattern
    ): array;
}
