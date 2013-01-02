<?php
class Template implements ArrayAccess
{
    protected $map = array();
    
	/* (non-PHPdoc)
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset) 
    {
        return isset($this->map[$offset]);
    }

	/* (non-PHPdoc)
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset) 
    {
        return $this->map[$offset];
    }

	/* (non-PHPdoc)
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value) 
    {
        $this->map[$offset] = $value;
    }

	/* (non-PHPdoc)
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset) 
    {
        unset($this->map[$offset]);
    }
    
    public function renderString($template)
    {
        $this->validateMap($template);
        
        //translate variable names into template format
        $map = array();
        foreach($this->map as $name => $value){
            $map['{$'.$name.'}'] = $value;
        }

        //simple replace
        return str_replace(array_keys($map), array_values($map), $template);
    }

    protected function validateMap($template)
    {
        if(!preg_match_all('#\{\$(\w+)\}#', $template, $variables)){
            return;
        }
        
        foreach($variables[1] as $variable){
            if(!isset($this->map[$variable])){
                throw new MissingValueException('missing template variable: ' . $variable);
            }
        }
    }
    
}

class MissingValueException extends Exception {}