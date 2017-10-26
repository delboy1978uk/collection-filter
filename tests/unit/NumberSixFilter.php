<?php

namespace DelTesting\Filter;

use ArrayIterator;
use Del\Filter\Filter\FilterInterface;

class NumberSixFilter implements FilterInterface
{
    /**
     * @param ArrayIterator $collection
     * @return ArrayIterator
     */
    public function filter(ArrayIterator $collection): ArrayIterator
    {
        $results = new ArrayIterator();

        while ($collection->valid()) {
            $current = $collection->current();

            if (is_integer($current) && $current != 6) {
                $results->append($current);
            } elseif (!is_integer($current)) {
                $results->append($current);
            }
            $collection->next();
        }

        return $results;
    }

}