<?php
class Discount
{
    protected $books = array();
    protected $discounts = array();
    protected $price;
    
    public function __construct($discounts, $books, $price)
    {
        $this->discounts = $discounts;
        $this->books = $books;
        $this->price = $price;
    }
    
    public function calculate($cart)
    {
        //simple assembly of unique sets (can't have more than books)
        $sets = array_fill(0, count($cart), array());
        foreach($cart as $book)
        {
            foreach($sets as $index => $set){
                if(in_array($book, $set)){
                    continue;
                }
                $sets[$index][] = $book;
                break;
            }
        }
        
        $price = 0;
        foreach($sets as $set){
            $setPrice = $this->price * count($set);
            if(isset($this->discounts[count($set)])){
                $setPrice = (1-$this->discounts[count($set)])*$setPrice;
            }
            
            $price += $setPrice;
        }
        
        return $price;
    }
}