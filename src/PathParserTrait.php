<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

trait PathParserTrait
{
    /**
     * Parse a path.
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
            array_values(
                array_filter(
                    str_getcsv(
                        $path,
                        DataContainerInterface::SEPARATOR,
                        DataContainerInterface::ENCLOSURE,
                        DataContainerInterface::ESCAPE
                    ),
                    'strlen'
                )
            )
        );
    }
}
