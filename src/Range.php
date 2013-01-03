<?php
class Range
{
    protected $start;
    protected $end;
    
    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end   = $end;
    }
    
    public function getStart()
    {
        return $this->start;
    }
    
    public function getEnd()
    {
        return $this->end;
    }
    
    public function contains($number)
    {
        return $number >= $this->start AND $number < $this->end;
    }
    
    public function intersect(Range $range)
    {
        $this->start = ($this->start > $range->getStart()) ? $this->start : $range->getStart();
        $this->end = ($this->end < $range->getEnd()) ? $this->end : $range->getEnd();
    }
}