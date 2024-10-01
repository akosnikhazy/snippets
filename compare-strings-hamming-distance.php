<?php
/*
 * This small function compares two strings bit by bit and returns an int value representing the difference between the two.
 * 0 means it is the same string
 * Anything greater than zero represents different levels of difference. For example, 'monkey' and 'monkay' gives 1 because 
 * there is 1 bit of difference between them, while 'monkey' vs. 'duck' gives 22 because they are very different words.
 *                                                  ˇ
 * monkey: 01101101 01101111 01101110 01101011 01100101 01111001 00001010
 * monkay: 01101101 01101111 01101110 01101011 01100001 01111001 00001010
 *                                                  ^
 * at different length every missing letter counts as +1 for every bit in the longer string
 * 
 * Normalize mode:
 * if normalize is true it will return a number between 0 and 1 where 0 is still means no difference and 1 would mean
 * infinite difference (the closer it is to 1 the bigger the difference)
 *
 * What is this good for? I do not know. I just wanted to make it.
*/
function compareString(string $str1,string $str2, bool $normalize = false)
{
    // they are the same, why work more?
    if($str1 === $str2) return 0;

    function textToBin($str)
    {
        $bin = '';
        for($i=0; $i < strlen($str); $i++)
        {
            $bin .= decbin(ord($str[$i]));
        }
        return $bin;
    }

    $bins = [ 
                textToBin($str1),
                textToBin($str2)
            ];
    
    // this way $bins[1] is always the shorter string
    usort($bins,function ($a,$b){
        return strlen($b)-strlen($a);
    });

   
    $hammingDistance = 0;

    for($a = 0; $a < strlen($bins[1]); $a++)
    { // compare bits until the end of the shorter string
        
        if($bins[0][$a] != $bins[1][$a])
        {
            $hammingDistance++;
        }
        
    }
    
    if($normalize) return (1-0)/(strlen($bins[0]) - 0) * ($hammingDistance + (strlen($bins[0])-strlen($bins[1])) - strlen($bins[0])) + 1;

    // add the length difference between the two string, as ever non existent
    // bit is different than any existing one. 
    return $hammingDistance + (strlen($bins[0])-strlen($bins[1]));
}

echo compareString('a','b');
