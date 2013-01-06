<?php
namespace Cards;
use InvalidArgumentException;

class Card
{
    protected $suite;
    protected $value;
    
    public function __construct($value, $suite = null)
    {
        if(is_null($suite) AND strlen($value) != 2){
            throw new InvalidArgumentException('invalid value or missing suite');
        }
        
        $values = array_merge(str_split('JQKA'),range(2,9));
        $suites = str_split('CDHS');
        
        if(!in_array($value, $values)){
            throw new InvalidArgumentException('invalid value: ' . $value);
        }
        
        if(!in_array($suite, $suites)){
            throw new InvalidArgumentException('invalid suite: ' . $suite);
        }
        
        $this->suite = $suite;
        $this->value = $value;
    }
    
    public function getSuite()
    {
        return $this->suite;        
    }
    
    public function getValue()
    {
        return $this->getValue();
    }
    
    public function __toString()
    {
        return $this->getValue() . $this->getSuite();
    }
}