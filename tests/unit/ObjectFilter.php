<?php

namespace DelTesting\Filter;

use ArrayIterator;
use Del\Filter\Filter\FilterInterface;
use stdClass;

class ObjectFilter implements FilterInterface
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
            if ($current instanceof stdClass && $current->name == 'delboy1978uk') {
                $results->append($current);
            } elseif (!is_object($current)) {
                $results->append($current);
            }
            $collection->next();
        }
        
        return $results;
    }

}