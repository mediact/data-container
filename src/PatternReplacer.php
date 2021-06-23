<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

class PatternReplacer implements PatternReplacerInterface
{
    use ReplaceByPatternTrait;

    /** @var string */
    private $separator;

    /**
     * Constructor.
     *
     * @param string $separator
     */
    public function __construct(
        string $separator = DataContainerInterface::SEPARATOR
    ) {
        $this->separator = $separator;
    }

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
    ): string {
        return $this->replaceByPattern(
            $pattern,
            $match,
            $replacement,
            $this->separator
        );
    }
}
