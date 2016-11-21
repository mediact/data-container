<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace Mediact\DataContainer;

/**
 * Contains any data which can be accessed using dot-notation.
 */
interface DataContainerInterface
{
    /**
     * Check if a path exists.
     *
     * @param string $path
     *
     * @return bool
     */
    public function has(string $path): bool;

    /**
     * Get a value of a path.
     *
     * @param string $path
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get(string $path, $default = null);

    /**
     * Set the value of a path.
     *
     * @param string $path
     * @param mixed  $value
     *
     * @return DataContainerInterface
     */
    public function with(string $path, $value = null): DataContainerInterface;

    /**
     * Delete the value of a path.
     *
     * @param string $path
     *
     * @return DataContainerInterface
     */
    public function without(string $path): DataContainerInterface;
}
