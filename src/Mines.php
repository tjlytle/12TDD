<?php
class Mines
{
    protected $grid = array();
    protected $hints = array();
    protected $width;
    protected $height;
    protected $cells;
    
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

        //validate the grid
        if(!is_array($grid)){
            throw new UnexpectedValueException('grid must be array, or a parsable string');
        }
        
        if(count($grid) < 1){
            throw new UnexpectedValueException('grid must have at least one row');
        }
        
        if(!is_array(reset($grid))){
            throw new UnexpectedValueException('grid rows must be array, or parsable string');
        }

        if(count(reset($grid)) < 1){
            throw new UnexpectedValueException('rows must have at least one column');
        }
        
        $width = count(reset($grid));
        
        foreach($grid as $row){
           if(count($row) != $width){
               throw new UnexpectedValueException('rows must have the same number of columns');
           }
        }
        
        array_walk_recursive($grid, function($value){
            if(!in_array($value, str_split('.*'))){
                throw new UnexpectedValueException('invalid character: ' . $value);
            }
        });
        
        //store grid
        $this->grid = $grid;
        $this->width = $width;
        $this->height = count($grid);
        $this->cells = $this->width*$this->height;
    }
    
    /**
     * Generate a hints map for the grid.
     */
    public function getHint()
    {
        if(!empty($this->hints)){
            return $this->hints;
        }
        
        //create empty grid
        $this->hints = array_fill(0, $this->height, array_fill(0, $this->width, 0));
        
        //not sure if this is really better than nested foreach
        for($cell = 0; $cell < $this->cells; $cell++){
            if($this->isMine($cell)){
                $this->addMine($cell);
            }
        }

        return $this->hints;
    }
    
    /**
     * Get an array of x/y from a cell number.
     * @param int $cell
     */
    protected function getCoords($cell)
    {
        if($cell > $this->cells){
            throw new InvalidArgumentException('cell can not be greater than the grids cell count');
        }
        
        $y = $cell%$this->width;
        $x = ($cell-$y)/$this->width;
        return array($x, $y);
    }
    
    /**
     * Is this cell a mine?
     * @param int $cell
     */
    protected function isMine($cell)
    {
        list($x, $y) = $this->getCoords($cell);
        return '*' == $this->grid[$x][$y];
    }
    
    /**
     * Add a mine to the hints map.
     * @param int $cell
     */
    protected function addMine($cell)
    {
        list($x, $y) = $this->getCoords($cell);
        $this->hints[$x][$y] = '*';
        $this->incrementSurrounding($cell);
    }
    
    /**
     * Increment the mine count for cells surrounding the given cell.
     * @param int $x
     * @param int $y
     */
    protected function incrementSurrounding($cell)
    {
        list($x, $y) = $this->getCoords($cell);
        
        $cells = array();
        
        //identify surrounding cells
        if($y != 0){
            $cells[] = $cell-1;
            $cells[] = $cell-1-$this->width;
            $cells[] = $cell-1+$this->width;
        }
        
        foreach(array($x-1, $x, $x+1) as $xSearch){
            if($xSearch < 0 OR $xSearch >= $this->height){
                continue;
            }
            foreach(array($y-1, $y, $y+1) as $ySearch){
                if($ySearch < 0 OR $ySearch >= $this->width){
                    continue;
                }
                
                $this->incrementCell(($ySearch + ($xSearch*$this->width)));
            }
        }
    }

    /**
     * Increment a Cell (if it's not a mine)
     * @param int $x
     * @param int $y
     */
    protected function incrementCell($cell)
    {
        list($x, $y) = $this->getCoords($cell);
        if('*' === $this->hints[$x][$y]){
            return;
        }

        $this->hints[$x][$y]++;
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