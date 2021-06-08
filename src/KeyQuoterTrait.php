<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

trait KeyQuoterTrait
{
    /**
     * Quote a key.
     *
     * @param string $key
     *
     * @return string
     */
    private function quoteKey(string $key): string
    {
        return strpos($key, DataContainerInterface::SEPARATOR) !== false
            ? sprintf(
                '%s%s%s',
                DataContainerInterface::ENCLOSURE,
                str_replace(
                    DataContainerInterface::ENCLOSURE,
                    DataContainerInterface::ENCLOSURE . DataContainerInterface::ENCLOSURE,
                    $key
                ),
                DataContainerInterface::ENCLOSURE
            )
            : $key;
    }
}
