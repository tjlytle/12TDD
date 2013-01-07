<?php
/**
 * To try and encourage more sales of the 5 different Harry Potter books they 
 * sell, a bookshop has decided to offer discounts of multiple-book purchases.
 * 
 * One copy of any of the five books costs 8 EUR.
 * 
 * If, however, you buy two different books, you get a 5% discount on those 
 * two books.
 * 
 * If you buy 3 different books, you get a 10% discount.
 * 
 * If you buy 4 different books, you get a 20% discount.
 * 
 * If you go the whole hog, and buy all 5, you get a huge 25% discount.
 * 
 * Note that if you buy, say, four books, of which 3 are different titles, you 
 * get a 10% discount on the 3 that form part of a set, but the fourth book 
 * still costs 8 EUR.
 * 
 * Your mission is to write a piece of code to calculate the price of any 
 * conceivable shopping basket (containing only Harry Potter books), giving as 
 * big a discount as possible.
 */
class DiscountTest extends PHPUnit_Framework_TestCase 
{
    protected $discount;
    protected $books = array('book1', 'book2', 'book3', 'book4', 'book5');
    protected $discounts = array(2 => .05, 3 => .1, 4 => .2, 5 => .25);
    protected $price = 8;
    
    public function setUp()
    {
        $this->discount = new Discount($this->discounts, $this->books, $this->price);
    }
    
    public function testSingleBook()
    {
        foreach($this->books as $book){
            $this->assertEquals($this->price, $this->discount->calculate(array($book)));
        }
    }
    
    public function testUniqueTwo()
    {
        $books = $this->books;
        shuffle($books);
        $this->assertEquals(8*2*(1-$this->discounts[2]), $this->discount->calculate(array_slice($books, 0,2)));
    }

    public function testUniqueThree()
    {
        $books = $this->books;
        shuffle($books);
        $this->assertEquals(8*3*(1-$this->discounts[3]), $this->discount->calculate(array_slice($books, 0,3)));
    }
    
    public function testUniqueFour()
    {
        $books = $this->books;
        shuffle($books);
        $this->assertEquals(8*4*(1-$this->discounts[4]), $this->discount->calculate(array_slice($books, 0,4)));
    }

    public function testUniqueFive()
    {
        $books = $this->books;
        shuffle($books);
        $this->assertEquals(8*5*(1-$this->discounts[5]), $this->discount->calculate(array_slice($books, 0,5)));
    }
    
    public function testDuplicates()
    {
        $this->assertEquals(8*2, $this->discount->calculate(array_fill(1, 2, $this->books[1])));
        $this->assertEquals(8*3, $this->discount->calculate(array_fill(1, 3, $this->books[1])));
        $this->assertEquals(8*4, $this->discount->calculate(array_fill(1, 4, $this->books[1])));
        $this->assertEquals(8*5, $this->discount->calculate(array_fill(1, 5, $this->books[1])));
    }
    
    public function testSimpleCombo()
    {
        $cart = array_merge($this->books, array($this->books[1]));
        $this->assertEquals( (8*5*(1-$this->discounts[5])) + 8, $this->discount->calculate($cart));
    }
}

