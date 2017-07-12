<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

/**
 * Contains any data which can be accessed using dot-notation.
 */
class DataContainer implements DataContainerInterface
{
    use GlobReplacementTrait;

    /** @var array */
    private $data;

    /**
     * Constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
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
        $random = md5(uniqid());
        return $this->get($path, $random) !== $random;
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
        return array_reduce(
            $this->parsePath($path),
            function ($data, $key) use ($default) {
                return is_array($data) && array_key_exists($key, $data)
                    ? $data[$key]
                    : $default;
            },
            $this->data
        );
    }

    /**
     * Get the contained array.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->data;
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
        $keys        = $this->parsePath($path);
        $last        = array_pop($keys);
        $node        =& $this->getNodeReference($keys);
        $node[$last] = $value;
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
        foreach ($this->glob($pattern) as $path) {
            $keys = $this->parsePath($path);
            $last = array_pop($keys);
            $node =& $this->getNodeReference($keys);
            unset($node[$last]);
        }
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
        return $this->findArrayPathsByPatterns(
            $this->data,
            explode(static::SEPARATOR, $pattern),
            ''
        );
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
        return array_map(
            function (array $data) : DataContainerInterface {
                return new static($data);
            },
            array_map(
                function (string $path) : array {
                    return (array) $this->get($path, []);
                },
                $this->glob($pattern)
            )
        );
    }

    /**
     * Copy paths matching a pattern to another path.
     *
     * @param string $pattern
     * @param string $destination
     *
     * @return void
     */
    public function copy(string $pattern, string $destination)
    {
        foreach ($this->glob($pattern) as $source) {
            $this->set(
                $this->getGlobReplacement(
                    $pattern,
                    $source,
                    $destination,
                    static::SEPARATOR
                ),
                $this->get($source)
            );
        }
    }

    /**
     * Move paths matching a pattern to another path.
     *
     * @param string $pattern
     * @param string $destination
     *
     * @return void
     */
    public function move(string $pattern, string $destination)
    {
        foreach ($this->glob($pattern) as $source) {
            $destination = $this->getGlobReplacement(
                $pattern,
                $source,
                $destination,
                static::SEPARATOR
            );

            if ($destination !== $source) {
                $this->set($destination, $this->get($source));
                if (strpos($destination, $source . static::SEPARATOR) !== 0) {
                    $this->remove($source);
                }
            }
        }
    }

    /**
     * Parse a path into an array.
     *
     * @param string $path
     *
     * @return array
     */
    private function parsePath(string $path): array
    {
        return array_map(
            function (string $key) {
                return ctype_digit($key)
                    ? intval($key)
                    : $key;
            },
            array_filter(explode(static::SEPARATOR, $path), 'strlen')
        );
    }

    /**
     * Get reference to a data node, create it if it does not exist.
     *
     * @param array $keys
     *
     * @return array
     */
    private function &getNodeReference(array $keys): array
    {
        $current =& $this->data;

        while (count($keys)) {
            $key = array_shift($keys);
            if (!array_key_exists($key, $current)
                || !is_array($current[$key])
            ) {
                $current[$key] = [];
            }

            $current =& $current[$key];
        }

        return $current;
    }

    /**
     * Find paths in an array by an array of patterns.
     *
     * @param array    $data
     * @param string[] $patterns
     * @param string   $prefix
     *
     * @return array
     */
    private function findArrayPathsByPatterns(
        array $data,
        array $patterns,
        string $prefix
    ): array {
        $pattern      = array_shift($patterns);
        $matchingKeys = array_filter(
            array_keys($data),
            function ($key) use ($pattern) {
                return fnmatch($pattern, $key);
            }
        );

        $paths = [];
        foreach ($matchingKeys as $key) {
            $path = $prefix . $key;

            if (count($patterns) === 0) {
                $paths[] = $path;
                continue;
            }

            if (is_array($data[$key])) {
                $paths = array_merge(
                    $paths,
                    $this->findArrayPathsByPatterns(
                        $data[$key],
                        $patterns,
                        $path . static::SEPARATOR
                    )
                );
            }
        }

        return $paths;
    }
}
