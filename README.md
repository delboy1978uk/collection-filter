# collection-filter
[![Build Status](https://travis-ci.org/delboy1978uk/collection-filter.png?branch=master)](https://travis-ci.org/delboy1978uk/collection-filter) [![Code Coverage](https://scrutinizer-ci.com/g/delboy1978uk/collection-filter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/delboy1978uk/collection-filter/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/delboy1978uk/collection-filter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/delboy1978uk/collection-filter/?branch=master) <br />
An easy and extendable way of filtering down full result sets. Good for paging, amongst other filters.
## installation
```
composer require delboy1978uk/collection-filter
```
## usage
The CollectionFilter class comes with a paginator to filter results. See below for creating your own filters
```php
<?php

use Del\Filter\CollectionFilter;

$data = [1,2,3,4,5,6,7,8,9];

$filter = new CollectionFilter();
$filter->getPaginationFilter()
       ->setPage(2)
       ->setNumPerPage(3);

$results = $filter->filterArrayResults($data);

// returns array[4,5,6] 
```
You can also use any class implementing ArrayIterator:
```php
<?php
$results = $filter->filterResults($arrayIteratorClass);
```
## create your own filters
Creating your own filters is easy. Just implement `Del\Filter\Filter\FilterInterface`. There are two test filters in 
`tests/unit`. Here's how you build one:
```php
<?php

// firstly, use these
use ArrayIterator;
use Del\Filter\Filter\FilterInterface;

// next, make your class implement FilterInterface
class NumberSixFilter implements FilterInterface
{
   /**
    * Then create this method
    * 
    * @param ArrayIterator $collection
    * @return ArrayIterator
    */
    public function filter(ArrayIterator $collection) : ArrayIterator 
    {
        // We need to pass back results
        $results = new ArrayIterator();
        
        // loop through the collection passed in
        while ($collection->valid()) {
            
            // Get the current row
            $current = $collection->current();

            // This is my actual example filter.
            // If the current row is an integer that ISN'T 6, add it!
            // And if it isn't an integer add it regardless
            if (is_integer($current) && $current != 6) {
                $results->append($current);
            } elseif (!is_integer($current)) {
                $results->append($current);
            }
            
            // Move on to the next item
            $collection->next();
        }

        // Finally, return the results
        return $results;
    }
    
}

``` 
## contributing
Feel free to add issues in Github, or pick up an issue and send a pull request! All contributions welcome!
