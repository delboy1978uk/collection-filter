<?php

namespace Del\Filter\Collection;

use ArrayIterator;
use Del\Filter\Filter\FilterInterface;

class FilterCollection extends ArrayIterator
{
    /**
     * @return FilterInterface
     */
    public function current()
    {
        return parent::current();
    }
}