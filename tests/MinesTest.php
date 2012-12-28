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
    /**
     * @param array $values
     * @param int $min
     * @param int $max
     * @param int $count
     * @param float $average
     * @dataProvider dataset
     */
    public function testMines($input, $output)
    {
        $mines = new Mines($input);
        $this->assertEquals($output, $mines->getHints());
    }
    
    public function dataset()
    {
        return array(
            array("*...\n..*.\n....", " *211\n12*1\n0111"),
        );
    }
}

