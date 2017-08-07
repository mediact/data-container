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
     * The separator used in paths.
     */
    const SEPARATOR = '.';

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
     * Set a value on a path.
     *
     * @param string $path
     * @param mixed  $value
     *
     * @return void
     */
    public function set(string $path, $value = null);

    /**
     * Remove a path if it exists.
     *
     * @param string $pattern
     *
     * @return void
     */
    public function remove(string $pattern);

    /**
     * Find paths that match a pattern.
     *
     * @param string $pattern
     *
     * @return string[]
     */
    public function glob(string $pattern): array;

    /**
     * Find paths that match a pattern an their replacements.
     *
     * @param string $pattern
     * @param string $replacement
     *
     * @return string[]
     */
    public function expand(string $pattern, string $replacement): array;

    /**
     * Branch into a list of data containers.
     *
     * @param string $pattern
     *
     * @return DataContainerInterface[]
     */
    public function branch(string $pattern): array;

    /**
     * Get a node from the container.
     *
     * @param string $path
     *
     * @return DataContainerInterface
     */
    public function node(string $path): DataContainerInterface;

    /**
     * Copy paths matching a pattern to another path.
     *
     * @param string $pattern
     * @param string $replacement
     *
     * @return void
     */
    public function copy(string $pattern, string $replacement);

    /**
     * Move paths matching a pattern to another path.
     *
     * @param string $pattern
     * @param string $replacement
     *
     * @return void
     */
    public function move(string $pattern, string $replacement);
}
