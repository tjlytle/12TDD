<?php
class Recent implements Countable, ArrayAccess
{
    protected $list = array();
    protected $bound = false;
    
    public function __construct($bound = false)
    {
        if($bound AND !is_numeric($bound)){
            throw new Exception('bound must be a number');
        }
        
        $this->bound = $bound;
    }
    
    public function add($item)
    {
        if(!is_string($item) OR empty($item)){
            throw new InvalidArgumentException('item must be non-empty string');
        }
        
        if(in_array($item, $this->list)){
            unset($this->list[array_search($item, $this->list)]);
        }

        array_unshift($this->list, $item);
        
        while($this->bound AND $this->count() > $this->bound){
            array_pop($this->list);
        }
    }
    
    public function getNext()
    {
        return array_shift($this->list);
    }
    
    public function peek($index)
    {
        if(!$this->offsetExists($index)){
            return null;
        }
        
        return $this->offsetGet($index);
    }
    
	/* (non-PHPdoc)
     * @see Countable::count()
     */
    public function count() 
    {
        return count($this->list);
    }
    
	/* (non-PHPdoc)
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset) 
    {
        if(!is_numeric($offset)){
            throw new Exception('only numeric indexes can be used');
        }
        
        return isset($this->list[--$offset]);
    }

	/* (non-PHPdoc)
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset) 
    {
        if(!is_numeric($offset)){
            throw new Exception('only numeric indexes can be used');
        }
        
        return $this->list[--$offset];
    }

	/* (non-PHPdoc)
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value) 
    {
        throw new Exception('can not manually set an item');
    }

	/* (non-PHPdoc)
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset) 
    {
        throw new Exception('can not manually unset an item');
    }
}