<?php
class MontySimulator
{
    const STAY   = 'stay';
    const CHANGE = 'change';
    
    protected $factory;
    protected $strategy;
    protected $runs;
    
    protected $wins = 0;
    
    public function __construct($strategy, $runs)
    {
        if(!in_array($strategy, array(self::STAY, self::CHANGE))){
            throw new InvalidArgumentException('invalid strategy: ' . $strategy);
        }
        
        $this->strategy = $strategy;
        $this->runs = (int) $runs;
    }
    
    public function setGameFactory(Closure $closure)
    {
        $this->factory = $closure;
    }
    
    /**
     * @return Monty
     */
    protected function getGame()
    {
        if(isset($this->factory) AND $this->factory instanceof Closure){
            $closure = $this->factory;
            return $closure();
        }
        
        return new Monty();
    }
    
    public function run()
    {
        $run = 0;
        $this->results = array();
        while ($run++ < $this->runs){
            //get a new game
            $game = $this->getGame();

            //pick a random door
            $doors = $game->getDoors();
            shuffle($doors);
            $pick = reset($doors);
            $game->pickDoor($pick);

            //pick the same door
            if(self::STAY == $this->strategy){
                $game->pickDoor($pick);
            //pick the other door                
            } else {
                $alternate = array_diff($game->getDoors(), array($game->getOpenDoor(), $pick));
                $alternate = reset($alternate);
                $game->pickDoor($alternate);
            }

            if(Monty::PRIZE_CAR == $game->getPrize()){
                $this->wins++;
            }
        }
    }
    
    public function getSuccess()
    {
        return $this->wins/$this->runs;
    }
}