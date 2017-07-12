<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

trait GlobReplacementTrait
{
    /**
     * Find paths in an array that match a glob pattern.
     *
     * @param string $pattern
     * @param string $matched
     * @param string $replacement
     * @param string $separator
     *
     * @return string
     */
    protected function getGlobReplacement(
        string $pattern,
        string $matched,
        string $replacement,
        string $separator = DataContainerInterface::SEPARATOR
    ): string {
        if ($pattern === $matched) {
            return $replacement;
        }

        if (preg_match(
            $this->getGlobRegex($pattern, $separator),
            $matched,
            $matches
        )) {
            $replacement = preg_replace_callback(
                '/\$([\d]*)/',
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
     * Get regex pattern for a glob pattern.
     *
     * @param string $pattern
     * @param string $separator
     *
     * @return string
     */
    private function getGlobRegex(
        string $pattern,
        string $separator
    ): string {
        $transforms = [
            '\*'   => '([^' . preg_quote($separator, '#') . ']*)',
            '\?'   => '(.)',
            '\[\!' => '([^',
            '\['   => '([',
            '\]'   => '])'
        ];

        return sprintf(
            '#^%s$#',
            strtr(preg_quote($pattern, '#'), $transforms)
        );
    }
}
