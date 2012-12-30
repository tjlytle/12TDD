<?php
/**
 * Suppose you’re on a game show and you’re given the choice of three doors. 
 * Behind one door is a car; behind the others, goats. The car and the goats 
 * were placed randomly behind the doors before the show.
 * 
 * The rules of the game show are as follows:
 * 
 * After you have chosen a door, the door remains closed for the time being. 
 * The game show host, Monty Hall, who knows what is behind the doors, now has 
 * to open one of the two remaining doors, and the door he opens must have a 
 * goat behind it. If both remaining doors have goats behind them, he chooses 
 * one randomly. After Monty Hall opens a door with a goat, he will ask you to 
 * decide whether you want to stay with your first choice or to switch to the
 * last remaining door.
 * 
 * For example:
 * Imagine that you chose Door 1 and the host opens Door 3, which has a goat. 
 * He then asks you “Do you want to switch to Door Number 2?” Is it to your 
 * advantage to change your choice?
 * 
 * Note that the player may initially choose any of the three doors (not just 
 * Door 1), that the host opens a different door revealing a goat (not 
 * necessarily Door 3), and that he gives the player a second choice between 
 * the two remaining unopened doors.
 * 
 * Simulate at least a thousand games using three doors for each strategy and 
 * show the results in such a way as to make it easy to compare the effects of 
 * each strategy.
 */
class MontyTest extends PHPUnit_Framework_TestCase 
{
    //valid data
    protected $doors = array(Monty::DOOR_ONE, Monty::DOOR_TWO, Monty::DOOR_THREE);
    protected $prizes = array(Monty::PRIZE_CAR, Monty::PRIZE_GOAT);
    
    //track the simulator
    protected $game;
    protected $pick;
    protected $alternate;
    protected $strategy;
    protected $results;
    
    /**
     * Test the interaction with the game model - note that like a real game
     * there's no way to determine if it's fixed or not.
     * 
     * @dataProvider contestants
     * @param string $pick
     * @param string $switch
     */
    public function testMonty($pick, $switch)
    {
        $monty = new Monty();

        //verify that all doors are cosed
        $doors = $monty->getDoors();
        $this->assertTrue(3 == count(array_intersect($doors, $this->doors)), 'all doors not open');
        
        //pick a door
        $monty->pickDoor($pick);
        
        //can't see the pick yet
        try{
            $prize = $monty->getPrize();
            $this->fail('got prize without second pick');
        } catch (Exception $e) {}

        //the open door can't be the picked door
        $open = $monty->getOpenDoor();
        $this->assertNotEquals($open, $pick, 'the picked door was open');
        
        //the open door can't be picked
        $doors = $monty->getDoors();
        $this->assertFalse(in_array($open, $doors), 'the open door should not be availible');
        
        //the picked door can still be picked
        $this->assertTrue(in_array($pick, $doors), 'the picked door must still be availible');

        //the alternate door (not picked, not opened) can be opened
        $alternate = array_diff($this->doors, array($pick, $open));
        $this->assertTrue(1 == count($alternate), 'could not determine alternate door'); //just checking
        $alternate = reset($alternate);
        
        //the open door can not be picked
        //can't see the pick yet
        try{
            $monty->pickDoor($open);
            $this->fail('could pick open door');
        } catch (Exception $e) {}
        
        
        //decide what to do
        if($switch){
            $monty->pickDoor($alternate);
        } else {
            $monty->pickDoor($pick);
        }
        
        //check for valid prize
        $this->assertTrue(in_array($monty->getPrize(), $this->prizes), 'did not get valid prize');
    }
    
    public function contestants()
    {
        return array(
            array(Monty::DOOR_ONE, true),
            array(Monty::DOOR_ONE, false),
            array(Monty::DOOR_TWO, true),
            array(Monty::DOOR_TWO, false),
            array(Monty::DOOR_THREE, true),
            array(Monty::DOOR_THREE, false),
        );
    }
    
    /**
     * Check that the simulator interacts as expected with the game model.
     * 
     * @dataProvider simulator
     * @param int $runs
     * @param string $strategy
     * @param array $results
     * @param float $success
     */
    public function testSimulator($runs, $strategy, $results, $success)
    {
        $this->results = $results;
        $this->strategy = $strategy;
        
        //mock the game
        $this->game = $this->getMockBuilder('Monty')
                           ->disableOriginalConstructor()
                           ->getMock();
        $game = $this->game;
        
        //observe and mock the picks
        $game->expects($this->any())
             ->method('pickDoor')
             ->will($this->returnCallback(array($this, 'observePick')));

        //observe and mock the prize
        $game->expects($this->exactly($runs))
             ->method('getPrize')
             ->will($this->returnCallback(array($this, 'observePrize')));
             
        //observe and mock getting the doors
        $game->expects($this->any())
             ->method('getDoors')
             ->will($this->returnCallback(array($this, 'observeDoors')));
        
        //set simulator strategy
        $simulator = new MontySimulator($strategy, $runs);

        //give the simulator access to a mocked game
        $test = $this;
        $simulator->setGameFactory(function() use($test){
            return $test->getGame();
        });
        
        //simulation should run 
        $simulator->run();
        
        //verify the results
        $this->assertEquals($success, $simulator->getSuccess(), 'results do not match');
    }
    
    public function simulator()
    {
        return array(
            //stay with 100% success
            array(10, MontySimulator::STAY, array_fill(0, 10, Monty::PRIZE_CAR), 1),
            //stay with 0% success
            array(10, MontySimulator::STAY, array_fill(0, 10, Monty::PRIZE_GOAT), 0),
            //change with 100% success
            array(10, MontySimulator::CHANGE, array_fill(0, 10, Monty::PRIZE_CAR), 1),
            //change with 0% success
            array(10, MontySimulator::CHANGE, array_fill(0, 10, Monty::PRIZE_GOAT), 0),
            //stay with 50% success
            array(10, MontySimulator::STAY,  array_merge(array_fill(0, 5, Monty::PRIZE_CAR), array_fill(0, 5, Monty::PRIZE_GOAT)), .5),
            //change with 50% success
            array(10, MontySimulator::CHANGE, array_merge(array_fill(0, 5, Monty::PRIZE_CAR), array_fill(0, 5, Monty::PRIZE_GOAT)), .5),
        );
    }
    
    public function getGame()
    {
        //reset data
        $this->pick = null;
        $this->alternate = null;
        return $this->game;
    }
    
    public function observePick($pick)
    {
        if(empty($this->pick)){
            $this->pick = $pick;
            return;
        }
        
        //assert the pick matches the strategy
        if(MontySimulator::STAY == $this->strategy){
            $this->assertEquals($this->pick, $pick);
        } else {
            $this->assertNotEquals($this->pick, $pick);
        }
    }
    
    public function observePrize()
    {
        return array_pop($this->results);
    }
    
    public function observeDoors()
    {
        //no pick yet
        if(empty($this->pick)){
            return $this->doors;
        }
        
        //there was a pick, find an alternate
        $possible = array_diff(array($this->pick), $this->doors);
        shuffle($possible);
        $this->alternate = reset($possible);
        
        return array($this->alternate, $this->pick);
    }
    
}

