<?php
class Poker
{
    protected $values;
    protected $suits;
    
    const SFLUSH   = 8;
    const FOUR     = 7;
    const FULL     = 6;
    const FLUSH    = 5;
    const STRAIGHT = 4;
    const THREE    = 3;
    const TWO      = 2;
    const PAIR     = 1;
    const HIGH     = 0;
    
    public function __construct()
    {
        $this->values = str_split('23456789TJQKA');
        $this->suits = str_split('CDHS');        
    }
    
    public function compareHands($a, $b)
    {
        $a = array('hand' => $this->getHand($a));
        $b = array('hand'=> $this->getHand($b));
        
        $a['score'] = $this->identifyHand($a['hand']);
        $b['score'] = $this->identifyHand($b['hand']);

        if($a['score'][0] == $b['score'][0]){ //same hand, have to check values
            switch($a['score'][0]){
                case self::PAIR:
                    $compare = $this->compareValues($a['score'][1], $b['score'][1]); //compare the value of the set
                    if($compare != 0){
                        return $compare;
                    }
                    //if not, compare the rest fo the values
                case self::HIGH: //work through the cards, and is already sorted
                    for($card = 4; $card >=0; $card--){
                        $compare = $this->compareValues($a['hand'][$card][0], $b['hand'][$card][0]);
                        if($compare != 0){
                            return $compare;
                        }
                    }
                    break;
                default: //all others just use the high card of the set
                    return $this->compareValues($a['score'][1], $b['score'][1]);
                    break;
            }
            
            return 0;
        }
        
        if($a['score'] > $b['score']){
            return 1;
        } 
        
        return -1;
    }
    
    protected function sortByValue($hand)
    {
        $poker = $this;
        usort($hand, function($a, $b) use ($poker){
            return $poker->compareValues($a[0], $b[0]);
        });
        
        return $hand;
    }
    
    public function compareValues($a, $b)
    {
        if($a == $b){
            return 0;
        }
        
        if($a > $b){
            return 1;
        }
        
        return -1;
    }
    
    protected function identifyHand($hand)
    {
        if($value = $this->isStraightFlush($hand)){
            return array(self::SFLUSH, $value);
        }
        
        if($value = $this->isFour($hand)){
            return array(self::FOUR, $value);
        }
        
        if($value = $this->isFull($hand)){
            return array(self::FULL, $value);
        }
        
        if($value = $this->isFlush($hand)){
            return array(self::FLUSH, $value);
        }
        
        if($value = $this->isStraight($hand)){
            return array(self::STRAIGHT, $value);
        }
        
        if($value = $this->isThree($hand)){
            return array(self::THREE, $value);
        }
        
        if($pair = $this->isPair($hand)){
            if(count($pair) == 2){
                return array(self::TWO, $pair);
            } else {
                return array(self::PAIR, reset($pair));
            }
        }
        
        return array(self::HIGH, $this->getHighCard($hand));
    }
    
    protected function getHighCard($hand)
    {
        $high = 0;
        foreach($hand as $card){
            if($card[0] > $high){
                $high = $card[0];
            }
        }
        
        return $high;
    }
    
    protected function isPair($hand)
    {
        $values = $this->getValues($hand);
        $pairs = array();
        foreach(array_count_values($values) as $value => $count){
            if(2 == $count){
                $pairs[] = $value;
            }
        }
        
        if(empty($pairs)){
            return false;
        }
        
        return $pairs;
    }
    
    protected function isThree($hand)
    {
        $values = $this->getValues($hand);
        foreach(array_count_values($values) as $value => $count){
            if(3 == $count){
                return $value;
            }
        }
        
        return false;
    }
    
    protected function isStraight($hand)
    {
        $first = reset($hand);
        $next = $first[0]; //first card value
        foreach($hand as $card){
            if($card[0] != $next){
                return false;
            }
            $next++;
        }
        
        return $this->getHighCard($hand);
    }
    
    protected function isFlush($hand)
    {
        $first = reset($hand);
        $suit = $first[1]; //first card suit  
        foreach($hand as $card){
            if($card[1] != $suit){
                return false;
            }
        }
        
        return $this->getHighCard($hand);
    }
    
    protected function isFull($hand)
    {
        if($this->isThree($hand) AND $this->isPair($hand)){
            return $this->isThree($hand);
        }
        
        return false;
    }

    protected function isFour($hand)
    {
        $values = $this->getValues($hand);
        foreach(array_count_values($values) as $value => $count){
            if(4 == $count){
                return $value;
            }
        }
        
        return false;
    }
    
    protected function isStraightFlush($hand)
    {
        if($this->isFlush($hand) AND $this->isStraight($hand)){
            return $this->getHighCard($hand);
        }
        
        return false;
    }
    
    protected function getValues($hand)
    {
        $values = array();
        foreach($hand as $card){
            $values[] = $card[0];
        }
        
        return $values;
    }
    
    protected function getHand($hand)
    {
        $cards = explode(' ', $hand);
        $hand = array();

        foreach($cards as $card){
            $hand[] = str_split($card);
        }
        
        //validate cards
        if(count($hand) != 5){
            throw new UnexpectedValueException('hand needs to have 5 cards');
        }
        
        foreach($hand as $index => $card){
            if(!in_array($card[0], $this->values)){
                throw new UnexpectedValueException('invalid card value: ' . $card[0]);
            }
            
            $hand[$index][0] = reset(array_keys($this->values, $card[0]));

            if(!in_array($card[1], $this->suits)){
                throw new UnexpectedValueException('invalid card suit: ' . $card[1]);
            }
        }
        
        $hand = $this->sortByValue($hand);
        
        return $hand;
    }
    
}