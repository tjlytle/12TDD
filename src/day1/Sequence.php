<?php
class Sequence
{
    protected $values = array();
    
    public function __construct($values)
    {
        $this->values = $values;
    }
    
    /**
     * Essentially min(), but that's not testing much.
     */
    public function min()
    {
        $min = null;
        foreach($this->values as $value){
            if($value < $min OR is_null($min)){
                $min = $value;
            }
        }

        return $min;
    }
    
    /**
     * Essentially max(), but what fun would that be?
     */
    public function max()
    {
        $max = null;
        foreach($this->values as $value){
            if($value > $max OR is_null($max)){
                $max = $value;
            }
        }
        
        return $max;
    }

    /**
     * Seems like there should be a built-in function to do this.
     */
    public function count()
    {
        $count = 0;
        reset($this->values);
        while(!is_null(key($this->values))){
            $count++;
            next($this->values);
        }
        
        return $count;
    }
    
    /**
     * Not using array_sum(), just to make it interesting.
     */
    public function average()
    {
        $sum = 0;
        foreach($this->values as $value){
            $sum += $value;
        }
        
        return $sum/$this->count();
    }
}