<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/3/10
 * Time: 15:49
 */

namespace PHP\DataStruct;

class InsertSort implements SortInterface
{
    public function sort($arr)
    {
        $len = count($arr);

        for ($i = 0; $i < $len; $i++) {
            // 临时元素
            $temp = $arr[$i];
            for ($j = $i - 1; $j >= 0; $j--) {
                // 临时元素比当前元素小的话，进行移位，直到有序
                if ($temp < $arr[$j]) {
                    $arr[$j + 1] = $arr[$j];
                    $arr[$j] = $temp;
                }
            }
        }
        return $arr;
    }
}