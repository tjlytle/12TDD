12 TDDS OF CHRISTMAS
====================
PHP solutions to [this post][1]. As much as possible (or as time allows), I'll 
avoid using internal functions when they represent the total work. For example
finding the max value of an array from Day 1.

Day 1
-----
Your task is to process a sequence of integer numbers
to determine the following statistics:

- minimum value
- maximum value
- number of elements in the sequence
- average value

For example: [6, 9, 15, -2, 92, 11]

- minimum value = -2
- maximum value = 92
- number of elements in the sequence = 6
- average value = 21.833333

Day 2
-----
Spell out a number. For example

- 99 –> ninety nine
- 300 –> three hundred
- 310 –> three hundred and ten
- 1501 –> one thousand, five hundred and one
- 12609 –> twelve thousand, six hundred and nine
- 512607 –> five hundred and twelve thousand, six hundred and seven
- 43112603 –> forty three million, one hundred and twelve thousand, six hundred 
and three

Day 3
-----

A field of N x M squares is represented by N lines of
exactly M characters each. The character ‘*’ represents
a mine and the character ‘.’ represents no-mine.

Example input (a 3 x 4 mine-field of 12 squares, 2 of
which are mines)

    *...
    ..*.
    ....

Your task is to write a program to accept this input and
produce as output a hint-field of identical dimensions
where each square is a * for a mine or the number of
adjacent mine-squares if the square does not contain a mine.

Example output (for the above input)

    *211
    12*1
    0111

Day 4
-----

Suppose you’re on a game show and you’re given the choice of three doors. 
Behind one door is a car; behind the others, goats. The car and the goats 
were placed randomly behind the doors before the show.

The rules of the game show are as follows:

After you have chosen a door, the door remains closed for the time being. The 
game show host, Monty Hall, who knows what is behind the doors, now has to 
open one of the two remaining doors, and the door he opens must have a goat 
behind it. If both remaining doors have goats behind them, he chooses one 
randomly. After Monty Hall opens a door with a goat, he will ask you to decide 
whether you want to stay with your first choice or to switch to the last 
remaining door.

**For example:**
Imagine that you chose Door 1 and the host opens Door 3, which has a goat. He 
then asks you “Do you want to switch to Door Number 2?” Is it to your advantage 
to change your choice?

Note that the player may initially choose any of the three doors (not just Door 
1), that the host opens a different door revealing a goat (not necessarily Door 
3), and that he gives the player a second choice between the two remaining 
unopened doors.

Simulate at least a thousand games using three doors for each strategy and show 
the results in such a way as to make it easy to compare the effects of each 
strategy.

Day 5
-----

Write a program that prints the numbers from 1 to 100. But for multiples of 
three print “Fizz” instead of the number and for the multiples of five print 
"Buzz". For numbers which are multiples of both three and five print 
"FizzBuzz".

Sample output:

    1
    2
    Fizz
    4
    Buzz
    Fizz
    7
    8
    Fizz
    Buzz
    11
    Fizz
    13
    14
    FizzBuzz
    

Day 6
-----

Develop a recently-used-list class to hold strings uniquely in Last-In-First-Out
order.

- A recently-used-list is initially empty.
- The most recently added item is first, the leastrecently added item is last.
- Items can be looked up by index, which counts from zero.
- Items in the list are unique, so duplicate insertions are moved rather than 
added.

Optional extras:

- Null insertions (empty strings) are not allowed.
- A bounded capacity can be specified, so there is an upper limit to the number 
of items contained, with the least recently added items dropped on overflow.

Day 7
-----

Write a "template engine" meaning a way to transform template strings, "Hello 
{$name}" into "instanced" strings. To do that a variable->value mapping must 
be provided. For example, if name="Cenk" and the template string is "Hello 
{$name}" the result would be "Hello Cenk".

**Should evaluate template single variable expression**:
- mapOfVariables.put("name","Cenk");
- templateEngine.evaluate("Hello {$name}", mapOfVariables)
- should evaluate to "Hello Cenk"

**Should evaluate template with multiple expressions**:
- mapOfVariables.put("firstName","Cenk");
- mapOfVariables.put("lastName","Civici");
- templateEngine.evaluate("Hello {$firstName} ${lastName}", mapOfVariables);
- should evaluate to "Hello Cenk Civici"

**Should give error if template variable does not exist in the map**:
- map empty
- templateEngine.evaluate("Hello {$firstName} ", mapOfVariables);
- should throw missingvalueexception

**Should evaluate complex cases**:
- mapOfVariables.put("name","Cenk");
- templateEngine.evaluate("Hello ${$name}}", mapOfVariables);
- should evaluate to "Hello ${Cenk}"

Day 8
-----

In mathematics we denote a range using open-closed bracket notation: [0,10) 
means all real numbers equal to or greater than zero, but less than ten. So 0 
lies in this range, while 10 does not.

**Develop an integer range class, that has the following operations:**
- Construction: r = new Range(0,10)
- Checking whether an integer lies in the range. 
- Intersection of two ranges.

**Develop another class to represent floating point ranges, with the same 
operations:**

While developing the floating point range class, think about how it differs 
from the integer range.

Is it possible to modify the behaviour of one of them to become more consistent 
with the behaviour of the other? The more uniform their behaviour, the easier 
the classes will be to use.

If you modify one of the classes – do you feel confident you do not break 
anything? If you don’t feel confident, what can you do about that?

Day 9
-----

Write a program, to score a game of Ten-Pin Bowling.

The scoring rules:

Each game, or 'line' of bowling, includes ten turns, or 'frames' for the bowler.

In each frame, the bowler gets up to two tries to knock down all ten pins.

If the first ball in a frame knocks down all ten pins, this is called a 
'strike'. The frame is over. The score for the frame is ten plus the total 
of the pins knocked down in the next two balls.

If the second ball in a frame knocks down all ten pins, this is called a 
'spare'. The frame is over. The score for the frame is ten plus the number 
of pins knocked down in the next ball.

If, after both balls, there is still at least one of the ten pins standing 
the score for that frame is simply the total number of pins knocked down 
in those two balls.

If you get a spare in the last (10th) frame you get one more bonus ball. 
If you get a strike in the last (10th) frame you get two more bonus balls.

These bonus throws are taken as part of the same turn. If a bonus ball 
knocks down all the pins, the process does not repeat. The bonus balls 
are only used to calculate the score of the final frame.

The game score is the total of all frame scores.

Day 10
------
Given a list of phone numbers, determine if it is consistent. In a consistent 
phone list no number is a prefix of another. For example:

- Bob `91 12 54 26`
- Alice `97 625 992`
- Emergency `911`

In this case, it is not possible to call Bob because the phone exchange would 
direct your call to the emergency line as soon as you dialled the first three 
digits of Bob’s phone number. So this list would not be consistent.

[1]: http://www.wiredtothemoon.com/2012/12/12-tdds-of-christmas/
