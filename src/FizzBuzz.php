<?php
class FizzBuzz
{
    public function getSequence($max)
    {
        $output = '';
        for($i = 1; $i <= $max; $i++){
            $line = '';
            
            if(0 == $i%3){
                $line .= 'Fizz';
            }
            
            if(0 == $i%5){
                $line .= 'Buzz';
            }
            
            if(empty($line)){
                $line = $i;
            }
            
            $output .= $line . PHP_EOL;
        }
        
        return trim($output);
    }
}