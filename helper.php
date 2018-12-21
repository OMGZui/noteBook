<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/13
 * Time: 10:23
 */

if (!function_exists('convertSize')) {
    /**
     * 转换byte
     *
     * @param $size
     * @return string
     */
    function convertSize($size)
    {
        $arr = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
        $i = floor(log($size, 1024));
        return round($size / pow(1024, ($i)), 2) . $arr[(int)$i];
    }
}

if (!function_exists('timeUsage')) {
    /**
     * 计算耗时
     *
     * @param $t1
     * @param $t2
     * @return string
     */
    function timeUsage($t1, $t2)
    {
        $t = $t2 - $t1;

        if ($t < 60) {
            return "您花了{$t}秒";
        } elseif ($t < 60 * 60) {
            $t = $t / 60;
            return "您花了{$t}分钟";
        } elseif ($t < 60 * 60 * 24) {
            $t = $t / 60 * 60;
            return "您花了{$t}小时";
        }else {
            return "还未支持。。。";
        }
    }
}
