<?php
/**
 * A field of N x M squares is represented by N lines of
 * exactly M characters each. The character ‘*’ represents
 * a mine and the character ‘.’ represents no-mine.
 * 
 * Example input (a 3 x 4 mine-field of 12 squares, 2 of
 * which are mines)
 * 
 *     *...
 *     ..*.
 *     ....
 *     
 * Your task is to write a program to accept this input and
 * produce as output a hint-field of identical dimensions
 * where each square is a * for a mine or the number of
 * adjacent mine-squares if the square does not contain a mine.
 * 
 * Example output (for the above input)
 * 
 *     *211
 *     12*1
 *     0111
 */
class MineTest extends PHPUnit_Framework_TestCase 
{
    protected $testGrid = array(array('*', '.', '.', '.'),
                      array('.', '.', '*', '.'),
                      array('.', '.', '.', '.'));
    /**
     * Test of input to output.
     * @param string $input
     * @param string $output
     * @dataProvider dataset
     */
    public function testMines($input, $output)
    {
        $mines = new Mines($input);
        $this->assertEquals($output, $mines->getHintString());
    }
    
    public function dataset()
    {
        return array(
            array("*...\n..*.\n....", "*211\n12*1\n0111"),
            array(".....\n.***.\n.*.*.\n.***.\n.....", "12321\n2***2\n3*8*3\n2***2\n12321"),
            array(".....\n.....\n..*..\n.....\n.....", "00000\n01110\n01*10\n01110\n00000"),
            array("...\n...\n.*.\n...\n...", "000\n111\n1*1\n111\n000"),
            array("..........\n....*.....\n..........", "0001110000\n0001*10000\n0001110000"),
            array("..**....\n.......*\n..*..*.*\n..****..\n........\n*.......", "01**1011\n0233213*\n02*44*4*\n02****31\n12233210\n*1000000"),
        );
    }
    
    public function testInputArray()
    {
        $mines = new Mines($this->testGrid);
        $this->assertEquals($this->testGrid, $mines->getGrid());
    }
    
    public function testInputLines()
    {
        $mines = new Mines(array_map(function($value){return implode('', $value);}, $this->testGrid));
        $this->assertEquals($this->testGrid, $mines->getGrid());
    }
    
    public function testInputString()
    {
        $grid = $this->testGrid;
        foreach($grid as $index => $row){
            $grid[$index] = implode('', $row);
        }
        $mines = new Mines(implode("\n", $grid));
        $this->assertEquals($this->testGrid, $mines->getGrid());
    }
    
    public function testInvalidGrids()
    {
        try{
            $mines = new Mines(array());
            $this->fail('was able to use empty array as grid');
        } catch (UnexpectedValueException $e){}
        
        try{
            $mines = new Mines(array(array()));
            $this->fail('was able to use empty row in grid');
        } catch (UnexpectedValueException $e){}
        
        try{
            $mines = new Mines("...\n....\n...");
            $this->fail('was able use grid with invalid width');
        } catch (UnexpectedValueException $e){}
        
        try{
            $mines = new Mines("...\n.8.\n...");
            $this->fail('was able use grid with invalid character');
        } catch (UnexpectedValueException $e){}
    }
}

