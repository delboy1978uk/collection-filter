<?php

namespace Del\Filter\Filter;

use ArrayIterator;
use LogicException;

class PaginationFilter implements FilterInterface
{
    /** @var int $page */
    private $page;

    /** @var int $numPerPage */
    private $numPerPage;

    /** @var int $totalRecords */
    private $totalRecords;

    /** @var ArrayIterator $collection */
    private $collection;

    /** @var int $resultsOffset */
    private $resultsOffset;

    private $resultsEndOffset;

    /**
     * @param ArrayIterator $collection
     * @return ArrayIterator
     */
    public function filter(ArrayIterator $collection): ArrayIterator
    {
        // If pagination wasnt set, dont use it!
        if (!$this->page || !$this->numPerPage) {
            return $collection;
        }

        $this->collection = $collection;
        $this->totalRecords = $collection->count();

        $this->resultsOffset = ($this->page * $this->numPerPage) - $this->numPerPage;
        $this->resultsEndOffset = $this->resultsOffset + $this->numPerPage;

        if ($this->resultsOffset > $this->totalRecords) {
            throw new LogicException('There aren\'t that many pages for this result set.');
        }

        $results = $this->getResults();

        return $results;
    }

    private function getResults()
    {
        $results = new ArrayIterator();

        $this->collection->rewind();

        for ($x = 0; $x < $this->totalRecords; $x ++) {
            $this->handleRow($x, $results);
        }
        return $results;
    }

    private function handleRow(int $x, ArrayIterator $results)
    {
        if ($this->collection->valid()) {
            $row = $this->collection->current();
            if ($x >= $this->resultsOffset && $x < $this->resultsEndOffset) {
                $results->append($row);
            }
            $this->collection->next();
        }
    }


    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     * @return PaginationFilter
     */
    public function setPage(int $page): PaginationFilter
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumPerPage(): int
    {
        return $this->numPerPage;
    }

    /**
     * @param int $numPerPage
     * @return PaginationFilter
     */
    public function setNumPerPage(int $numPerPage): PaginationFilter
    {
        $this->numPerPage = $numPerPage;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPages() : int
    {
        if (!$this->collection instanceof ArrayIterator) {
            throw new LogicException('You must first pass your collection in to filter');
        }
        return ceil(($this->totalRecords / $this->numPerPage));
    }
}