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
     * @param int $value
     * @param string $string
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
            array(101, 'one hundred and one'),
            //from https://github.com/jeremykendall/12-tdds-of-christmas
            array(0, 'zero'),
            array(5, 'five'),
            array(12, 'twelve'),
            array(67, 'sixty seven'),         
            array(804, 'eight hundred and four'),
            array(220, 'two hundred and twenty'),
            array(645, 'six hundred and forty five'),
            array(118, 'one hundred and eighteen'),
            array(1000, 'one thousand'),
            //from https://github.com/mfrost503/TwelveTDD
            array(12,'twelve'),
            array(19,'nineteen'),
            array(100,'one hundred'),
            array(165,'one hundred and sixty five'),
            array(1000, 'one thousand'),
            array(1100, 'one thousand, one hundred'),
            array(1100100,'one million, one hundred thousand, one hundred'),
            array(1013,'one thousand, thirteen'),
            array(100000000000, 'one hundred billion'),
            array(100145,'one hundred thousand, one hundred and forty five'),
            array('1,045','one thousand, forty five'),
            array(1000001,'one million, one'),
            array('143,865,030,112,068','one hundred and forty three trillion, eight hundred and sixty five billion, thirty million, one hundred and twelve thousand, sixty eight'),
            array('143,000,000,000,000,000,000,000,000,000,000,012','one hundred and forty three decillion, twelve'),                  
        );
    }
}

