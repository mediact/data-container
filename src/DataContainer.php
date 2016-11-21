<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

use xmarcos\Dot\Container as DotContainer;

/**
 * Contains any data which can be accessed using dot-notation.
 */
class DataContainer implements DataContainerInterface
{
    /**
     * The wrapped container used for storage.
     *
     * @var DotContainer
     */
    private $storage;

    /**
     * Constructor.
     *
     * @param DotContainer $storage
     */
    public function __construct(DotContainer $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Check whether a path exists.
     *
     * @param string $path
     *
     * @return bool
     */
    public function has(string $path): bool
    {
        return $this->storage->has($path);
    }

    /**
     * Get a value of a path.
     *
     * @param string $path
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get(string $path, $default = null)
    {
        return $this->storage->get($path, $default);
    }

    /**
     * Return a container with a value set on a path.
     *
     * @param string $path
     * @param mixed  $value
     *
     * @return DataContainerInterface
     */
    public function with(string $path, $value = null): DataContainerInterface
    {
        $container = clone $this;
        $container->storage->set($path, $value);
        return $container;
    }

    /**
     * Return a container with a path removed.
     *
     * @param string $path
     *
     * @return DataContainerInterface
     */
    public function without(string $path): DataContainerInterface
    {
        $container = clone $this;
        $container->storage->delete($path);
        return $container;
    }

    /**
     * Prepare the object for cloning.
     *
     * @return void
     */
    public function __clone()
    {
        $this->storage = clone $this->storage;
    }
}
