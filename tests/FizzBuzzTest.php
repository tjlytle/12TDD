<?php
/**
 * Write a program that prints the numbers from 1 to 100. But for multiples of 
 * three print “Fizz” instead of the number and for the multiples of five print 
 * "Buzz". For numbers which are multiples of both three and five print 
 * "FizzBuzz".
 * 
 * Sample output:
 * 
 *     1
 *     2
 *     Fizz
 *     4
 *     Buzz
 *     Fizz
 *     7
 *     8
 *     Fizz
 *     Buzz
 *     11
 *     Fizz
 *     13
 *     14
 *     FizzBuzz
 */
class FizzBuzzTest extends PHPUnit_Framework_TestCase 
{
    protected $fizzbuzz = "1\n2\nFizz\n4\nBuzz\nFizz\n7\n8\nFizz\nBuzz\n11\nFizz\n13\n14\nFizzBuzz\n16\n17\nFizz\n19\nBuzz\nFizz\n22\n23\nFizz\nBuzz\n26\nFizz\n28\n29\nFizzBuzz\n31\n32\nFizz\n34\nBuzz\nFizz\n37\n38\nFizz\nBuzz\n41\nFizz\n43\n44\nFizzBuzz\n46\n47\nFizz\n49\nBuzz\nFizz\n52\n53\nFizz\nBuzz\n56\nFizz\n58\n59\nFizzBuzz\n61\n62\nFizz\n64\nBuzz\nFizz\n67\n68\nFizz\nBuzz\n71\nFizz\n73\n74\nFizzBuzz\n76\n77\nFizz\n79\nBuzz\nFizz\n82\n83\nFizz\nBuzz\n86\nFizz\n88\n89\nFizzBuzz\n91\n92\nFizz\n94\nBuzz\nFizz\n97\n98\nFizz\nBuzz";
    
    public function testFizzBuzz()
    {
        $fb = new FizzBuzz();
        $this->assertEquals($this->fizzbuzz, $fb->getSequence(100));
    }
}

