12 TDDS OF CHRISTMAS
====================
PHP solutions to [this post][1]. As much as possible (or as time allows), I'll 
avoid using internal functions when they represent the total work. For example
finding the max value of an array from Day 1.

*I believe the source of most (if not all) problems is [rosettacode][2].*

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

[1]: http://www.wiredtothemoon.com/2012/12/12-tdds-of-christmas/
[2]: http://rosettacode.org