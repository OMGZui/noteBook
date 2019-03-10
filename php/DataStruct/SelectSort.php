<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/3/10
 * Time: 15:49
 */

namespace PHP\DataStruct;

class SelectSort implements SortInterface
{
    public function sort($arr)
    {
        $len = count($arr);

        for ($i = 0; $i < $len - 1; $i++) {
            // 初始化最小值
            $min = $i;
            for ($j = $i + 1; $j < $len; $j++) {
                // 实际最小值
                if ($arr[$min] > $arr[$j]) {
                    $min = $j;
                }
            }

            // 交换位置，把实际上最小的值塞入arr[i]
            if ($min != $i) {
                [$arr[$min], $arr[$i]] = [$arr[$i], $arr[$min]];
            }
        }

        return $arr;
    }
}