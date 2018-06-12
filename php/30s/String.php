<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/12
 * Time: 15:01
 */

echo "----------------------------------------- palindrome回文数判断 -----------------------------------------\n";
function palindrome($string)
{
    return strrev($string) === $string;
}
dump(palindrome('racecar')); // true
dump(palindrome('racecaq')); // false