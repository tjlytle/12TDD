<?php
/**
 * Develop a recently-used-list class to hold strings uniquely in 
 * Last-In-First-Out order.
 * 
 * - A recently-used-list is initially empty.
 * - The most recently added item is first, the leastrecently added item is last.
 * - Items can be looked up by index, which counts from zero.
 * - Items in the list are unique, so duplicate insertions are moved rather than 
 * added.
 * 
 * Optional extras:
 * 
 * - Null insertions (empty strings) are not allowed.
 * - A bounded capacity can be specified, so there is an upper limit to the 
 * number of items contained, with the least recently added items dropped on 
 * overflow.
 */
class RecentTest extends PHPUnit_Framework_TestCase 
{
    /**
     * List should be initially empty. 
     */
    public function testInitialEmpty()
    {
        $list = new Recent();
        $this->assertEquals(0, count($list));
        $this->assertEquals(null, $list->getNext());
    }

    /**
     * List should operate as LIFO.
     */
    public function testOrder()
    {
        $last  = 'last';
        $first = 'first';
        
        $list = new Recent();
        
        $list->add($first);
        $list->add($last);
        
        $this->assertEquals($last, $list->getNext());
        $this->assertEquals($last, $list->getNext());
    }

    /**
     * List should move duplicate inputs (not allow duplicates in the list).
     */
    public function testMove()
    {
        $last = 'last';
        $middle = 'middle';
        $first = 'first';
        
        $list = new Recent();
        
        $list->add($first);
        $list->add($middle);
        $list->add($last);
        $list->add($middle);
        
        $this->assertEquals($middle, $list->getNext());
        $this->assertEquals($last, $list->getNext());
        $this->assertEquals($first, $list->getNext());
    }

    /**
     * List should allow access to items by index.
     */
    public function testLookup()
    {
        $one   = 'one';
        $two   = 'two';
        $three = 'three';
        $four  = 'four';

        $list = new Recent();
        
        $list->add($four);
        $list->add($three);
        $list->add($two);
        $list->add($one);
        
        $this->assertEquals($one, $list->peek(1));
        $this->assertEquals($two, $list[2]);
        $this->assertEquals($three, $list->peek(3));
        $this->assertEquals($four, $list[4]);
    }

    /**
     * List should allow list count to be bounded
     */
    public function testBounds()
    {
        $list = new Recent(2);
        
        $one   = 'one';
        $two   = 'two';
        $three = 'three';
        $four  = 'four';
        
        $list->add($four);
        $list->add($three);
        $list->add($two);
        $list->add($one);
        
        $this->assertEquals(2, count($list));
        $this->assertEquals($one, $list->getNext());
        $this->assertEquals($two, $list->getNext());
        $this->assertEquals(null, $list->getNext());
    }
    
    /**
     * Invalid input should result in an exceptiokn.
     * @param mixed $input
     * @dataProvider invalidInput
     */
    public function testInvalidInput($input)
    {
        $list = new Recent();
        
        try{
            $list->add($input);
            $this->fail('allowed invalid input');
        } catch (Exception $e) {}
    }
    
    public function invalidInput()
    {
        return array(
            array(''),
            array(null),
            array(array()),
            array(new stdClass())
        );
    }
}