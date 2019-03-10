<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/3/10
 * Time: 15:49
 */

namespace PHP\DataStruct;

class QuickSort implements SortInterface
{
    public function sort($arr)
    {
        $len = count($arr);
        // 边界控制
        if ($len <= 1) {
            return $arr;
        }

        // 以第一个为基准数
        $base = $arr[0];
        $left = $right = [];

        for ($i = 0; $i < $len; $i++) {
            if ($arr[$i] < $base) {
                // 小的放左边
                $left[] = $arr[$i];
            } else {
                // 大的放右边
                $right[] = $arr[$i];
            }
        }

        $left = $this->sort($left);
        $right = $this->sort($right);

        return array_merge($left, [$base], $right);
    }
}