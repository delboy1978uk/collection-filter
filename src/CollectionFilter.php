<?php

namespace Del\Filter;

use ArrayIterator;
use Del\Filter\Collection\FilterCollection;
use Del\Filter\Filter\PaginationFilter;

class CollectionFilter
{
    /** @var FilterCollection $filterCollection */
    private $filterCollection;

    /** @var PaginationFilter $paginationFilter */
    private $paginationFilter;

    public function __construct()
    {
        $this->filterCollection = new FilterCollection();
        $this->paginationFilter = new PaginationFilter();
    }

    /**
     * @return FilterCollection
     */
    public function getFilterCollection(): FilterCollection
    {
        return $this->filterCollection;
    }

    /**
     * @param FilterCollection $filterCollection
     * @return CollectionFilter
     */
    public function setFilterCollection(FilterCollection $filterCollection): CollectionFilter
    {
        $this->filterCollection = $filterCollection;
        return $this;
    }

    public function filterArrayResults(array $results) : array
    {
        return $this->filterResults(new ArrayIterator($results))->getArrayCopy();
    }

    /**
     * @param ArrayIterator $results
     * @return ArrayIterator
     */
    public function filterResults(ArrayIterator $results) : ArrayIterator
    {
        // Set the filters back to the first one
        $this->filterCollection->rewind();

        // loop through each filter
        while ($this->filterCollection->valid()) {

            // filter the results
            $results = $this->filterCollection->current()->filter($results);

            // move to the next filter
            $this->filterCollection->next();
        }

        // finally, if pagination is used, this will return the appropriate results
        $results = $this->paginationFilter->filter($results);

        return $results;
    }

    /**
     * @return PaginationFilter
     */
    public function getPaginationFilter(): PaginationFilter
    {
        return $this->paginationFilter;
    }
}