<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/7/29
 * Time: 15:26
 */

namespace PHP\Modern;

$closure = function ($name) {
    return sprintf("hello %s\n", $name);
};

echo $closure('world');

$n = 1;
$number = array_map(function ($num) use ($n) {
    if ($num > 1)
        return $num + $n;
    else
        return $num;
}, [1, 2, 3]);

print_r($number);