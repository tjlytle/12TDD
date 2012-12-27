<?php
class Number
{
    protected $ones = array(
        0 => '',
        1 => 'one', 
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine'
    );
        
    protected $teens = array(
        0 => 'ten',
        1 => 'eleven',
        2 => 'twelve',
        3 => 'thirteen',
        5 => 'fifteen',
        8 => 'eighteen'
    );

    protected $tens = array(
        0 => '',
        2 => 'twenty',
        3 => 'thirty',
        4 => 'forty',
        5 => 'fifty',
        6 => 'sixty',
        7 => 'seventy',
        8 => 'eighty',
        9 => 'ninety'
    );
    
    protected $thousands = array(
        0 => '',
        1 => 'thousand',
        2 => 'million',
        3 => 'billion',
        4 => 'trillion',
        5 => 'quadrillion',
        6 => 'quintillion',
        7 => 'sextillion',
        8 => 'septillion',
        9 => 'octillion',
        10 => 'nonillion',
        11 => 'decillion'        
    );
            
    protected $value;
    
    
    public function __construct($value)
    {
        $this->value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }
    
    /**
     * Convert the value to a string.
     */
    public function __toString()
    {
        //going to group things by thousands
        $words = array();
        //reverse the number, then split into 'thousands' (groups of three)
        foreach(str_split(strrev($this->value), 3) as $position => $number){
            //reverse the number again, so it's ordered correctly
            $number = strrev($number);
            //get the words for that group, passing the thousands place
            $word = trim($this->getThousands($number, $position));
            
            //skip if there's not anything to add 
            if(empty($word)){
                continue;
            }
            
            $words[] = $word;
        }
        //reverse again to get the groups ordered, and add ','
        $string = implode(', ', array_reverse($words));
        
        //if there's nothing, then the number is zero
        if(empty($string)){
            $string = 'zero';
        }
        
        return $string;
    }
    
    /**
     * Get the word for ones place of the given number.
     * @param string|int $number
     */
    protected function getOnes($number)
    {
        return $this->ones[$this->getPlace($number, 1)];
    }

    /**
     * Get the word for the tens place, it's expected to include all lower
     * places.
     * @param string|int $number
     */
    protected function getTens($number)
    {
        //need the values for both tens and ones
        $ones = $this->getPlace($number, 1);
        $tens = $this->getPlace($number, 2);
        
        //special case for teens (they're special after all)
        if(1 == $tens){
            //is there a special format for the number?
            if(isset($this->teens[$ones])){
                return $this->teens[$ones];
            }
            
            //all others just append 'teen' to the word for the ones place
            return $this->getOnes($ones) . 'teen';
        }
        
        //non-teens - get the tens place and add the ones (trim for '0')
        return trim($this->tens[$tens] . ' ' . $this->getOnes($number));
    }

    /**
     * Get the word for the hundreds places, expect it includes the lower 
     * places.
     * @param string|int $number
     */
    protected function getHundreds($number)
    {
        //hundreds is the same as the ones place
        $hundreds = $this->getOnes($this->getPlace($number, 3));
        $tens = $this->getTens($number);

        //this could probably be more elegant, just assemble the words checking
        //to see if there is a word for the given place
        $words = '';
        if($hundreds){
            $words .= $hundreds . ' hundred';
        }
        
        //only use and when connecting hundreds and tens
        if($hundreds AND $tens){
            $words .= ' and ';
        }
        
        if($tens){
            $words .= $tens;
        }
        
        return trim($words);
    }
    
    /**
     * Get the word for the thousands, adding the lower places - offest refers 
     * to the place.
     * @param string|int $number
     * @param int $offset
     */
    protected function getThousands($number, $offset = 0)
    {
        //add the thousands word (if it's set), trimming for the '0' case - but
        //only if there's a word for this group
        $hundreds = $this->getHundreds($number);
        if(empty($hundreds)){
            return;
        }
        
        return trim($hundreds . ' ' . $this->thousands[$offset]);
    }
    
    /**
     * Utility function to get a int value for a specific place.
     * @param strin|int $number
     * @param int $position
     */
    protected function getPlace($number, $position)
    {
        if($position > strlen($number)){
            return 0;
        }

        return substr($number, $position*-1, 1);
    }
}