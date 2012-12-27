<?php
/**
 * Spell out a number. For example
 * 
 * 99 –> ninety nine
 * 300 –> three hundred
 * 310 –> three hundred and ten
 * 1501 –> one thousand, five hundred and one
 * 12609 –> twelve thousand, six hundred and nine
 * 512607 –> five hundred and twelve thousand,
 * six hundred and seven
 * 43112603 –> forty three million, one hundred and
 * twelve thousand,
 * six hundred and three
 */
class NumberTest extends PHPUnit_Framework_TestCase 
{
    /**
     * @param array $values
     * @param int $min
     * @param int $max
     * @param int $count
     * @param float $average
     * @dataProvider dataset
     */
    public function testNumber($value, $string)
    {
        $number = new Number($value);
        $this->assertEquals($string, (string) $number);
    }
    
    public function dataset()
    {
        return array(
            //given test cases
            array(99, 'ninety nine'),
            array(300, 'three hundred'),
            array(310, 'three hundred and ten'),
            array(1501, 'one thousand, five hundred and one'),
            array(12609, 'twelve thousand, six hundred and nine'),
            array(512607, 'five hundred and twelve thousand, six hundred and seven'),
            array(43112603, 'forty three million, one hundred and twelve thousand, six hundred and three'),
            //testing some extra cases
            array(111, 'one hundred and eleven'),
            array(12, 'twelve'),
            array(17, 'seventeen'),
            array(1001, 'one thousand, one'), //not sure - should this be 'and one'?
            array(101, 'one hundred and one')
        );
    }
}

