<?php
/**
 * In mathematics we denote a range using open-closed bracket notation: [0,10) 
 * means all real numbers equal to or greater than zero, but less than ten. So 0 
 * lies in this range, while 10 does not.
 * 
 * **Develop an integer range class, that has the following operations:**
 * 
 * - Construction: r = new Range(0,10)
 * - Checking whether an integer lies in the range. 
 * - Intersection of two ranges.
 * 
 * **Develop another class to represent floating point ranges, with the same 
 * operations:**
 * 
 * While developing the floating point range class, think about how it differs 
 * from the integer range.
 * 
 * Is it possible to modify the behaviour of one of them to become more 
 * consistent with the behaviour of the other? The more uniform their behaviour, 
 * the easier the classes will be to use.
 * 
 * If you modify one of the classes – do you feel confident you do not break
 * anything? If you don’t feel confident, what can you do about that?
 */
class RangeTest extends PHPUnit_Framework_TestCase 
{
    /**
     * Test construction and range.
     * @param float $start
     * @param float $end
     * @dataProvider ranges
     */
    public function testConstruction($start, $end)
    {
        $range = new Range($start, $end);
        $this->assertEquals($start, $range->getStart());
        $this->assertEquals($end, $range->getEnd());
    }
    
    /**
     * Test that Range validates number.
     * @param float $start
     * @param int $end
     * @param array $valid
     * @param array $invalid
     * @dataProvider ranges
     */
    public function testInRange($start, $end, $valid, $invalid)
    {
        $range = new Range($start, $end);
        $this->assertRangeContains($range, $valid);
        $this->assertRangeNotContains($range, $invalid);
    }
    
    public function ranges()
    {
        return array(
            array(0,10,range(0,9), array_merge(range(-10,-1), range(10,100))),
            array(5,15,range(5,14), array_merge(range(0,4), range(15,100))),
            array(.1,.5,range(.1,.49,.01), array_merge(range(0,.09,.01), range(.5,100, .01)))
        );
    }
    
    /**
     * Test that Range can create valid Intersection.
     * @param array $ranges
     * @param array $values
     * @dataProvider intersection
     */
    public function testIntersection($ranges, $start, $end, $valid, $invalid)
    {
        $intersection = null;
        foreach($ranges as $range){
            if(is_null($intersection)){
                $intersection = $range;
                continue;
            }
            
            $intersection->intersect($range);
        }

        $this->assertEquals($start, $intersection->getStart());
        $this->assertEquals($end, $intersection->getEnd());
        
        $this->assertRangeContains($intersection, $valid);
        $this->assertRangeNotContains($intersection, $invalid);
    }
    
    public function intersection()
    {
        return array(
            array(array(new Range(0,10), new Range(5,15)),5,10,range(5,9), array_merge(range(0,4), range(10,15))),
            array(array(new Range(0,15), new Range(5,20), new Range(10,25)),10,15,range(10,14), array_merge(range(0,9), range(15,25))),
            array(array(new Range(10.5,11.6), new Range(10.8,12.7)),10.8,11.6,range(10.8,11.5,.1), array_merge(range(10,10.7,.1), range(11.6,12.7,.1))),
        );
    }
    
    /**
     * Assert that the Range contains the values.
     * @param Range $range
     * @param array $values
     */
    public function assertRangeContains($range, $values)
    {
        foreach($values as $number){
            $this->assertTrue($range->contains($number));
        }
    }
    
    /**
     * Assert that the Range does not contain the values.
     * @param Range $range
     * @param array $values
     */
    public function assertRangeNotContains($range, $values)
    {
        foreach($values as $number){
            $this->assertFalse($range->contains($number));
        }
    }
}

