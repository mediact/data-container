<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace Mediact\DataContainer;

/**
 * Finds paths in arrays.
 */
class ArrayGlobber implements ArrayGlobberInterface
{
    /**
     * @var string
     */
    private $separator;

    /**
     * Constructor.
     *
     * @param string $separator
     */
    public function __construct(string $separator = '.')
    {
        $this->separator = $separator;
    }

    /**
     * Find paths in an array that match a pattern.
     *
     * @param array  $data
     * @param string $pattern
     *
     * @return array
     */
    public function glob(
        array $data,
        string $pattern
    ): array {
        return $this->findArrayPathsByPatterns(
            $data,
            explode($this->separator, $pattern)
        );
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
        string $prefix = ''
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

            if (count($patterns) == 0) {
                $paths[] = $path;
            } elseif (is_array($data[$key])) {
                $paths = array_merge(
                    $paths,
                    $this->findArrayPathsByPatterns(
                        $data[$key],
                        $patterns,
                        $path . $this->separator
                    )
                );
            }
        }
        return $paths;
    }
}
