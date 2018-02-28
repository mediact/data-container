<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Mediact\DataContainer;

class DataContainerFilterChain implements DataContainerFilterInterface
{
    /** @var DataContainerFilterInterface[] */
    private $filters;

    /**
     * Constructor.
     *
     * @param DataContainerFilterInterface[] ...$filters
     */
    public function __construct(DataContainerFilterInterface ...$filters)
    {
        $this->filters = $filters;
    }

    /**
     * Filter the given container.
     *
     * @param DataContainerInterface $container
     *
     * @return bool
     */
    public function __invoke(DataContainerInterface $container): bool
    {
        return array_reduce(
            $this->filters,
            function (
                bool $carry,
                DataContainerFilterInterface $filter
            ) use (
                $container
            ) : bool {
                return $carry && $filter($container);
            },
            true
        );
    }
}
