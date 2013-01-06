<?php

class PokerTest extends PHPUnit_Framework_TestCase 
{
    /**
     * Test the hand comparison.
     * @param string $first
     * @param string $second
     * @param int $win
     * @dataProvider hands
     */
    public function testWins($first, $second, $win)
    {
        $poker = new Poker();
        $this->assertEquals($win, $poker->compareHands($first, $second));
    }
    
    public function hands()
    {
        return array(
            array('2C 3H 4S 8C AH', '2H 3D 5S 9C KD', 1),
            array('2H 4S 4C 2D 4H', '2S 8S AS QS 3S', 1),
            array('2H 3D 5S 9C KD', '2C 3H 4S 8C KH', 1),
            array('2H 3D 5S 9C KD', '2D 3H 5C 9S KH', 0),
            array('TH JH QH KH AH', '2D 3D 4D 5D 6D', 1),
            array('TH JH QH KH AH', 'TD JD QD KD AD', 0),
            array('3D 3H 3S 2D 2S', '4D 4S 4C 2C 2H', -1),
            array('AD AH 4D 2H 8D', 'AC AS 8C 4H 3D', -1),
            
        );
    }
}

