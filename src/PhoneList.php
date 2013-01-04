<?php
class PhoneList
{
    protected $numbers = array();
    
    public function __construct($numbers)
    {
        if(!is_array($numbers)){
            throw new Exception('numbers must be array');
        }
        
        foreach($numbers as $number){
            $number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
            $this->numbers[] = $number;
        }
    }
    
    public function isConsistent()
    {
        foreach($this->numbers as $number){
            foreach($this->numbers as $test){
                if($number == $test){
                    continue;
                }
                
                if(strpos($test, $number) === 0){
                    return false;
                }
            }
        }
        
        return true;
    }
}