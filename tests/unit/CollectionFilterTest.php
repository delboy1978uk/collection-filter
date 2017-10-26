<?php

namespace DelTesting\Filter;

use Codeception\TestCase\Test;
use Del\Filter\CollectionFilter;

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
    public function testBlah()
    {
	    $this->assertEquals('Ready to start building tests',$this->filter->blah());
    }
}
