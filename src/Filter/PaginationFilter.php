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

    /**
     * PaginationFilter constructor.
     */
    public function __construct()
    {
        // set some defaults
        $this->page = 1;
        $this->numPerPage = 20;
    }

    /**
     * @param ArrayIterator $collection
     * @return ArrayIterator
     */
    public function filter(ArrayIterator $collection): ArrayIterator
    {
        $results = new ArrayIterator();
        $collection->rewind();

        $totalRecords = $collection->count();
        $resultsOffset = ($this->page * $this->numPerPage) - $this->numPerPage;
        $resultsEndOffset = $resultsOffset + $this->numPerPage;

        if ($resultsOffset > $totalRecords) {
            throw new LogicException('There aren\'t that many pages for this result set.');
        }

        for ($x = 0; $x < $totalRecords; $x ++) {
            if ($collection->valid()) {
                $row = $collection->current();
                if ($x >= $resultsOffset && $x <= $resultsEndOffset) {
                    $results->append($row);
                }
                $collection->next();
            }
        }

        return $results;
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
}