<?php
class Mines
{
    protected $grid = array();
    
    /**
     * Allow grid to be string (\n dividing rows), an array of strings, or a 
     * multidimensional array.
     * 
     * @param array|string $grid
     */
    public function __construct($grid)
    {
        if(is_string($grid)){
            $grid = explode("\n", $grid);
        }
        
        foreach($grid as $index => $row){
            if(is_string($row)){
                $grid[$index] = str_split($row);
            }
        }
        $this->grid = $grid;
    }
    
    /**
     * Generate a hints map for the grid.
     */
    public function getHint()
    {
        //create empty grid
        $hints = array_fill(0, count($this->grid), array_fill(0, count($this->grid[0]), 0));
        foreach($this->grid as $x => $row){
            foreach($row as $y => $cell){
                if('*' == $cell){
                    $hints[$x][$y] = '*';
                    //increment the surrounding cells
                    foreach(array($x-1, $x, $x+1) as $xSearch){
                        if($xSearch < 0 OR $xSearch > count($this->grid)){
                            continue;
                        }
                        foreach(array($y-1, $y, $y+1) as $ySearch){
                            if($ySearch < 0 OR $ySearch > count($row)){
                                continue;
                            }
                            if('*' === $hints[$xSearch][$ySearch]){
                                continue;
                            }

                            $hints[$xSearch][$ySearch]++;
                        }
                    }
                }
            }
        }
        return $hints;
    }
    
    public function getHintString()
    {
        return implode("\n", array_map(function($value){return implode('', $value);}, $this->getHint()));
    }
    
    public function getGrid()
    {
        return $this->grid;
    }
}