<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer\Tests\TestDouble;

use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\GlobReplacementTrait;

class GlobReplacementDouble
{
    use GlobReplacementTrait;

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
    public function peekGlobReplacement(
        string $pattern,
        string $matched,
        string $replacement,
        string $separator = DataContainerInterface::SEPARATOR
    ): string {
        return $this->getGlobReplacement(
            $pattern,
            $matched,
            $replacement,
            $separator
        );
    }
}
