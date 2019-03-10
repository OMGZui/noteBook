<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/3/10
 * Time: 15:49
 */

namespace PHP\DataStruct;

class BubbleSort implements SortInterface
{
    public function sort($arr)
    {
        $len = count($arr);

        // 外层控制轮次，把最大的数冒泡到最上层
        for ($i = $len - 1; $i > 0; $i--) {
            // 内层控制比较次数
            for ($j = 0; $j < $i; $j++) {
                if ($arr[$i] < $arr[$j]) {
                    [$arr[$i], $arr[$j]] = [$arr[$j], $arr[$i]];
                }
            }
        }
        return $arr;
    }
}