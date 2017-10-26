<?php

namespace Del\Filter\Filter;

use ArrayIterator;

interface FilterInterface
{
    /**
     * @return ArrayIterator
     */
    public function filter(ArrayIterator $collection) : ArrayIterator;
}