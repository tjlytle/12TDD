<?php
class Number
{
    protected $value;
    
    public function __construct($value)
    {
        $this->value = $value;
    }
    
    public function __toString()
    {
        return (string) $this->value;
    }
}