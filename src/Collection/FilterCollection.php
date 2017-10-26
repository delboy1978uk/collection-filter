<?php

namespace Del\Filter\Collection;

use ArrayIterator;
use Del\Filter\Filter\FilterInterface;
use InvalidArgumentException;

class FilterCollection extends ArrayIterator
{
    /**
     * @return FilterInterface
     */
    public function current()
    {
        return parent::current();
    }

    /**
     * @param FilterInterface $filter
     */
    public function append($filter)
    {
        if (!$filter instanceof FilterInterface) {
            throw new InvalidArgumentException('You must append a Del\Filter\Filter\FilterInterface');
        }
        parent::append($filter);
    }
}