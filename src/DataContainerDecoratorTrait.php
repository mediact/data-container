<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

/**
 * Implements DataContainerInterface
 */
trait DataContainerDecoratorTrait
{
    /** @var DataContainerInterface */
    private $storage;

    /**
     * Set data on a new storage.
     *
     * @param array $data
     *
     * @return void
     */
    protected function setData(array $data)
    {
        $this->storage = new DataContainer($data);
    }

    /**
     * Set the storage.
     *
     * @param DataContainerInterface $storage
     *
     * @return void
     */
    protected function setStorage(DataContainerInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Get the storage.
     *
     * @return DataContainerInterface
     */
    protected function getStorage(): DataContainerInterface
    {
        return $this->storage;
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
        return $this->getStorage()
            ->has($path);
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
        return $this->getStorage()
            ->get($path, $default);
    }

    /**
     * Get the contained array.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->getStorage()
            ->all();
    }

    /**
     * Set a value on a path.
     *
     * @param string $path
     * @param mixed  $value
     *
     * @return void
     */
    public function set(string $path, $value = null)
    {
        $this->getStorage()
            ->set($path, $value);
    }

    /**
     * Remove a path if it exists.
     *
     * @param string $pattern
     *
     * @return void
     */
    public function remove(string $pattern)
    {
        $this->getStorage()
            ->remove($pattern);
    }

    /**
     * Find paths that match a pattern.
     *
     * @param string $pattern
     *
     * @return string[]
     */
    public function glob(string $pattern): array
    {
        return $this->getStorage()
            ->glob($pattern);
    }

    /**
     * Find paths that match a pattern an their replacements.
     *
     * @param string $pattern
     * @param string $replacement
     *
     * @return string[]
     */
    public function expand(string $pattern, string $replacement): array
    {
        return $this->getStorage()
            ->expand($pattern, $replacement);
    }

    /**
     * Branch into a list of data containers.
     *
     * @param string $pattern
     *
     * @return DataContainerInterface[]
     */
    public function branch(string $pattern): array
    {
        return $this->getStorage()
            ->branch($pattern);
    }

    /**
     * Copy paths matching a pattern to another path.
     *
     * @param string $pattern
     * @param string $replacement
     *
     * @return void
     */
    public function copy(string $pattern, string $replacement)
    {
        $this->getStorage()
            ->copy($pattern, $replacement);
    }

    /**
     * Move paths matching a pattern to another path.
     *
     * @param string $pattern
     * @param string $replacement
     *
     * @return void
     */
    public function move(string $pattern, string $replacement)
    {
        $this->getStorage()
            ->move($pattern, $replacement);
    }
}
