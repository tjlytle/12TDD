<?php
class Monty
{
    const DOOR_ONE   = 1;
    const DOOR_TWO   = 2;
    const DOOR_THREE = 3;
    
    const PRIZE_CAR  = 'car';
    const PRIZE_GOAT = 'goat';
    
    protected $prize;
    protected $pick;
    protected $final;
    protected $open;
    
    protected $doors = array(self::DOOR_ONE, self::DOOR_TWO, self::DOOR_THREE);
    
    public function __construct()
    {
        //pick the prize door
        $doors = $this->getDoors();
        shuffle($doors);
        $this->prize = reset($doors);
    }
    
    public function getDoors()
    {
        //no pick has been made, no door are open, all can be picked
        if(empty($this->pick)){
            return $this->doors;
        }
        
        //return all but the open door
        $open = $this->getOpenDoor();
        return array_diff($this->doors, array($open));
    }
    
    public function pickDoor($door)
    {
        if(!in_array($door, $this->getDoors())){
            throw new InvalidArgumentException('invalid door: ' . $door);
        }
        
        if(empty($this->pick)){
            $this->pick = $door;
            return;
        }
        
        $this->final = $door;
    }
    
    public function getOpenDoor()
    {
        //only open after first pick
        if(empty($this->pick)){
            throw new RuntimeException('can not get open door before first pick');
        }
        
        //already opened a door, return the same result
        if(!empty($this->open)){
            return $this->open;
        }
        
        //they picked the prize, randomly open a door
        if($this->pick == $this->prize){
            $doors = array_diff($this->doors, array($this->pick));
            shuffle($doors);
        //they pickd the goat, open the other goat
        } else {
            $doors = array_diff($this->doors, array($this->pick, $this->prize));
        }

        $this->open = reset($doors);
        return $this->open;
    }
    
    public function getPrize()
    {
        if(empty($this->final)){
            throw new RuntimeException('must make second pick before getting prize');
        }

        if($this->final == $this->prize){
            return self::PRIZE_CAR;
        }
        
        return self::PRIZE_GOAT;
    }
}