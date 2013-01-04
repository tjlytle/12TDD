<?php
/**
 * Given a list of phone numbers, determine if it is consistent. In a consistent 
 * phone list no number is a prefix of another. For example:
 * 
 * - Bob `91 12 54 26`
 * - Alice `97 625 992`
 * - Emergency `911`
 * 
 * In this case, it is not possible to call Bob because the phone exchange would 
 * direct your call to the emergency line as soon as you dialled the first three 
 * digits of Bob’s phone number. So this list would not be consistent.
 */
class PhoneListTest extends PHPUnit_Framework_TestCase 
{
    /**
     * @param array $numbers
     * @param bool $result
     * @dataProvider consistent
     */
    public function testConsistent($numbers, $result)
    {
        $list = new PhoneList($numbers);
        $this->assertEquals($result, $list->isConsistent());
    }
    
    public function consistent()
    {
        return array(
            array(
                array('91 12 54 26', '97 625 992', '911'),
                false
            ),
            array(
                array('4845551212', '7175552343', '911'),
                true
            ),
            array(
                array('4845551212', '7175552343', '4845551213'),
                true
            ),
        );
    }
    
    
}

