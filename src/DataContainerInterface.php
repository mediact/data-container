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
     * Check whether a path exists.
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
     * Get the contained array.
     *
     * @return array
     */
    public function all(): array;

    /**
     * Return a container with a value set on a path.
     *
     * @param string $path
     * @param mixed  $value
     *
     * @return DataContainerInterface
     */
    public function with(string $path, $value = null): DataContainerInterface;

    /**
     * Return a container with a path removed.
     *
     * @param string $path
     *
     * @return DataContainerInterface
     */
    public function without(string $path): DataContainerInterface;
}
