<?php
/**
 * Write a program, to score a game of Ten-Pin Bowling.
 * 
 * The scoring rules:
 * 
 * Each game, or 'line' of bowling, includes ten turns, or 'frames' for the 
 * bowler.
 * 
 * In each frame, the bowler gets up to two tries to knock down all ten pins.
 * 
 * If the first ball in a frame knocks down all ten pins, this is called a 
 * 'strike'. The frame is over. The score for the frame is ten plus the total 
 * of the pins knocked down in the next two balls.
 * 
 * If the second ball in a frame knocks down all ten pins, this is called a 
 * 'spare'. The frame is over. The score for the frame is ten plus the number 
 * of pins knocked down in the next ball.
 * 
 * If, after both balls, there is still at least one of the ten pins standing 
 * the score for that frame is simply the total number of pins knocked down 
 * in those two balls.
 * 
 * If you get a spare in the last (10th) frame you get one more bonus ball. 
 * If you get a strike in the last (10th) frame you get two more bonus balls.
 * 
 * These bonus throws are taken as part of the same turn. If a bonus ball 
 * knocks down all the pins, the process does not repeat. The bonus balls 
 * are only used to calculate the score of the final frame.
 * 
 * The game score is the total of all frame scores.
 */
class StrikeTest extends PHPUnit_Framework_TestCase 
{
    /**
     * @var Strike
     */
    protected $strike;
    
    public function setUp()
    {
        $this->strike = new Strike();
    }
    
    /**
     * Test that frames advance as expected.
     * @param array $pins
     * @param array $position
     * @dataProvider advance
     */
    public function testFrameAdvance($pins, $position)
    {
        foreach($pins as $index => $count){
            $this->assertFalse($this->strike->isComplete(), 'Game over too soon.');
            $this->assertEquals($position[$index], $this->strike->getFrame(), 'Frame mismatch.');
            $this->strike->bowl($count);
        }
        
        $this->assertTrue($this->strike->isComplete(), 'Game should be over.');
    }
    
    public function advance()
    {
        return array(
            array(
                array_fill(0, 12, 10),
                range(1,12)
            ),
            array(
                array_fill(0, 21, 5),
                array(1,1,2,2,3,3,4,4,5,5,6,6,7,7,8,8,9,9,10,10,11)
            ),
            array(
                array(0,9,10,7,1,10,10,10,1,9,7,2,7,2, 8, 1),
                array(1,1, 2,3,3, 4, 5, 6,7,7,8,8,9,9,10,10)
            )
        );
    }
    
    /**
     * Test that a frame can't have too many pins.
     * @param int $first
     * @param int $second
     * @dataProvider invalidFrames
     */
    public function testInvalidFrame($first, $second)
    {
        $this->setExpectedException('UnexpectedValueException');
        $this->strike->bowl($first);
        $this->strike->bowl($second); //not possible
    }
    
    public function invalidFrames()
    {
        return array(
            array(0,11),
            array(1,10),
            array(2,9),
            array(3,8),
            array(4,7),
            array(5,6),
            array(12,0),
        );
    }
    
    /**
     * Test that bowler can't bowl more frames then possible.
     * @param array $valid
     * @param array $invalid
     * @dataProvider manyFrames
     */
    public function testTooManyFrames($valid, $invalid)
    {
        foreach($valid as $pins){
            $this->strike->bowl($pins);
        }
        
        $this->setExpectedException('UnexpectedValueException');
        
        foreach($invalid as $pins)
        {
            $this->strike->bowl($pins);
        }
    }
    
    public function manyFrames()
    {
        return array(
            array(array_fill(1, 20, 4), array(1)), //can't bowl more than 10
            array(array_fill(1, 21, 5), array(1)), //can't bowl more than 11
            array(array_fill(1, 12, 10), array(1)), //can't bowl more than 12
        );
    }
    
    /**
     * Test the final score.
     * @param array $pins
     * @param int $score
     * @dataProvider score
     */
    public function testScore($pins, $score)
    {
        foreach($pins as $count){
            $this->strike->bowl($count);
        }
        
        $this->assertTrue($this->strike->isComplete());
        $this->assertEquals($score, $this->strike->getScore());
    }
    
    public function score()
    {
        return array(
            array(array_fill(1, 12, 10), 300),
            array(array_fill(1, 21, 5), 150),
            array(array_fill(1, 20, 1), 20),
            array(array(9,0,9,0,9,0,9,0,9,0,9,0,9,0,9,0,9,0,9,0), 90)
            
        );
    }
    
    
}

