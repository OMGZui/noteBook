<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/12
 * Time: 15:01
 */

$arr = [1, 2, 3, 4, 5];

echo "----------------------------------------- chunk将数组分块成指定大小的较小数组。 -----------------------------------------\n";
dump(array_chunk($arr, 1));
dump(array_chunk($arr, 2));
dump(array_chunk($arr, 3)); // [[1, 2, 3], [4, 5]]

echo "----------------------------------------- deepFlatten深度压扁阵列 -----------------------------------------\n";
function deepFlatten(array $arr)
{
    $r = [];
    foreach ($arr as $item) {
        if (!is_array($item)) {
            $r[] = $item;
        } else {
            $r = array_merge($r, deepFlatten($item));
        }
    }
    return $r;
}

dump(deepFlatten([1, [2], [[3], 4], 5])); // [1, 2, 3, 4, 5]

