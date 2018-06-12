<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/12
 * Time: 15:01
 */

echo "----------------------------------------- fibonacci生成一个包含斐波那契数列的数组，直到第n项。 -----------------------------------------\n";
function fibonacci($n)
{
    $sequence = [0, 1];

    for ($i = 0; $i < $n - 2; $i++) {
        array_push($sequence, array_sum(array_slice($sequence, -2, 2, true)));
    }

    return $sequence;
}
dump(fibonacci(7));