<?php

namespace DelTesting\Filter;

use Codeception\TestCase\Test;
use Del\Filter\Collection\FilterCollection;
use Del\Filter\CollectionFilter;
use InvalidArgumentException;
use LogicException;
use stdClass;

class CollectionFilterTest extends Test
{
   /**
    * @var \UnitTester
    */
    protected $tester;

    /**
     * @var CollectionFilter
     */
    protected $filter;

    protected function _before()
    {
        // create a fresh collection-filter class before each test
        $this->filter = new CollectionFilter();
    }

    protected function _after()
    {
        // unset the collection-filter class after each test
        unset($this->filter);
    }

    /**
     * Check tests are working
     */
    public function testPaginationFilter()
    {
        $pager = $this->filter->getPaginationFilter();
        $pager->setPage(2)
            ->setNumPerPage(3);

	    $this->assertEquals(2,$pager->getPage());
	    $this->assertEquals(3,$pager->getNumPerPage());

	    $data = [
            1, 3, 5, 7, 3, 5, 2, 6, 4, 5, 8, 1, 2, 9,
        ];

	    $results = $this->filter->filterArrayResults($data);

	    $this->assertEquals(3, count($results));
	    $this->assertEquals(7, $results[0]);
	    $this->assertEquals(3, $results[1]);
	    $this->assertEquals(5, $results[2]);

	    // now set it to page too high for the number of results in the array
	    $this->expectException(LogicException::class);
	    $pager->setPage(100);

        $this->filter->filterArrayResults($data);
    }

    public function testFilters()
    {
        $obj = new stdClass();
        $obj->name = 'delboy1978uk';
        $obj2= new stdClass();
        $obj2->name = 'ignoreme!';


        $data = [
            6, 6, $obj, $obj, $obj2, 5, $obj2, 6, 4, 5, 8, 1, 2, 9, 6,
        ];

        // set up some fake filters
        $sixFilter = new NumberSixFilter(); // removes number sixes from results
        $objFilter = new ObjectFilter(); // filters stdClasses with name != 'delboy1978uk'

        $filters = new FilterCollection();
        $filters->append($sixFilter);
        $filters->append($objFilter);

        $this->filter->setFilterCollection($filters);
        $this->assertCount(2, $this->filter->getFilterCollection());

        $results = $this->filter->filterArrayResults($data);

        $this->assertEquals(9, count($results));
        $this->assertEquals('delboy1978uk', $results[0]->name);
        $this->assertEquals('delboy1978uk', $results[1]->name);
        $this->assertEquals(5, $results[2]);
        $this->assertEquals(4, $results[3]);
        $this->assertEquals(5, $results[4]);
        $this->assertEquals(8, $results[5]);
        $this->assertEquals(1, $results[6]);
        $this->assertEquals(2, $results[7]);
        $this->assertEquals(9, $results[8]);
    }

    public function testAppendFilterThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $bang = 'oops this isnt a filter';
        $this->filter->getFilterCollection()->append($bang);
    }
}
