<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

trait ReplaceByPatternTrait
{
    /**
     * Get a replacement path for a matched path.
     *
     * @param string $pattern
     * @param string $match
     * @param string $replacement
     * @param string $separator
     *
     * @return string
     */
    protected function replaceByPattern(
        string $pattern,
        string $match,
        string $replacement,
        string $separator = DataContainerInterface::SEPARATOR
    ): string {
        return $replacement === '$0'
            ? $match
            : $this->replaceByRegex(
                $this->getPatternRegex($pattern, $separator),
                $match,
                $replacement
            );
    }

    /**
     * Get a replacement path for a matched path by regex.
     *
     * @param string $regex
     * @param string $match
     * @param string $replacement
     *
     * @return string
     */
    private function replaceByRegex(
        string $regex,
        string $match,
        string $replacement
    ): string {
        if (preg_match($regex, $match, $matches)) {
            $replacement = preg_replace_callback(
                '/\$([\d]+)/',
                function (array $match) use ($matches) {
                    return array_key_exists($match[1], $matches)
                        ? $matches[$match[1]]
                        : $match[0];
                },
                $replacement
            );
        }

        return $replacement;
    }

    /**
     * Translate a fnmatch pattern to a regex.
     *
     * @param string $pattern
     * @param string $separator
     *
     * @return string
     */
    private function getPatternRegex(
        string $pattern,
        string $separator = DataContainerInterface::SEPARATOR
    ): string {
        $transforms = [
            '\*'  => sprintf('([^%s]*)', preg_quote($separator, '#')),
            '\?'  => '(.)',
            '\[\!' => '([^',
            '\['  => '([',
            '\]'  => '])'
        ];

        $result = sprintf(
            '#^%s$#',
            strtr(preg_quote($pattern, '#'), $transforms)
        );

        return $result;
    }
}
