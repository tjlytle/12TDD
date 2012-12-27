<?php
require_once __DIR__ . '/../../src/day1/Sequence.php';

/**
 * Your task is to process a sequence of integer numbers
 * to determine the following statistics:
 * 
 * o) minimum value
 * o) maximum value
 * o) number of elements in the sequence
 * o) average value
 * 
 * For example: [6, 9, 15, -2, 92, 11]
 * 
 * o) minimum value = -2
 * o) maximum value = 92
 * o) number of elements in the sequence = 6
 * o) average value = 21.833333
 */
class Test extends PHPUnit_Framework_TestCase 
{
    /**
     * @param array $values
     * @param int $min
     * @param int $max
     * @param int $count
     * @param float $average
     * @dataProvider dataset
     */
    public function testSequence($values, $min, $max, $count, $average)
    {
        $sequence = new Sequence($values);
        $this->assertEquals($min, $sequence->min());
        $this->assertEquals($max, $sequence->max());
        $this->assertEquals($count, $sequence->count());
        $this->assertEquals($average, $sequence->average());
    }
    
    public function dataset()
    {
        return array(
            array(array(6, 9, 15, -2, 92, 11), -2, 92,  6, 21.833333),
            array(array(0,1,2,3,4,5,6,7,8,9),   0,  9, 10, 4.5),
            array(array(-12345, 0, 12345), -12345, 12345, 3, 0),
            array(range(-100000, 100000), -100000, 100000, 200001, 0)
        );
    }
}

