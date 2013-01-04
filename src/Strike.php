<?php
class Strike
{
    protected $frames = array();
    protected $frame = 1;
    
    public function __construct()
    {
        $this->frames = array_fill(1, 12, array());
    }
    
    public function bowl($pins)
    {
        if($this->isComplete()){
            throw new UnexpectedValueException('game is complete, stop bowling');
        }
        
        if(array_sum($this->frames[$this->frame]) + $pins > 10){
            throw new UnexpectedValueException('too many pins for one frame');
        }
        
        $this->frames[$this->frame][] = $pins;
        
        //increment the frame if needed
        
        //11th and 12th frame
        if($this->frame > 10){
            $this->frame++;
            return;
        }
        
        //strike
        if(10 == $pins){
            $this->frame++;
            return;
        }
        
        //second frame
        if(count($this->frames[$this->frame]) == 2){
            $this->frame++;
            return;
        }
    }
    
    /**
     * Is the game over?
     */
    public function isComplete()
    {
        //less than ten frames
        if($this->frame < 11){
            return false;
        }
        
        //at least a spare in the 10th frame
        if($this->frame == 11 AND array_sum($this->frames[10]) == 10){
            return false;
        }
        
        //a strike in the 10th frame
        if($this->frame == 12 AND $this->frames[10][0] == 10){
            return false;
        }
        
        return true;
    }
    
    /**
     * What's the current frame?
     */
    public function getFrame()
    {
        return $this->frame;
    }
    
    /**
     * Get the socre.
     */
    public function getScore()
    {
        if(!$this->isComplete()){
            throw new Exception('can not score incomplete game');
        }
        
        $score = 0;
        
        foreach($this->frames as $frame => $pins){
            if($frame > 10){
                break;
            }
            $score += array_sum($pins);

            //strike (in normal pins)
            if(10 == $pins[0]){
                $next = $this->frames[$frame + 1][0];
                $score += $next;
                if(10 == $next){
                    $score += $this->frames[$frame + 2][0];
                } else {
                    $score += $this->frames[$frame + 1][1];
                }
                continue;
            }

            if(10 == array_sum($pins)){
                $score += $this->frames[$frame + 1][0];
                continue;
            }
            
            
            //spare (in normal pins
        }
        
        return $score;
    }
}