<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

interface PatternReplacerInterface
{
    /**
     * Get a replacement path for a matched path.
     *
     * @param string $match
     * @param string $pattern
     * @param string $replacement
     *
     * @return string
     */
    public function replace(
        string $match,
        string $pattern,
        string $replacement
    ): string;
}
