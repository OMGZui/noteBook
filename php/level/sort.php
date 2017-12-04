<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/11/3
 * Time: 09:54
 */

namespace PHP\Level;

require __DIR__.'/../bootstrap.php';

set_time_limit(0);

$arr = [];
for ($k = 0; $k < 10000; $k++) {
    $arr[] = $k;
}

shuffle($arr);

//dump($arr);

// 冒泡排序
$t1 = microtime(true);
/**
 * 冒泡排序
 *
 * 它是一种较简单的排序算法。
 * 它会遍历若干次要排序的数列，每次遍历时，它都会从前往后依次的比较相邻两个数的大小；
 * 如果前者比后者大，则交换它们的位置。
 * 这样，一次遍历之后，最大的元素就在数列的末尾！
 * 采用相同的方法再次遍历时，第二大的元素就被排列在最大元素之前。
 * 重复此操作，直到整个数列都有序为止！
 *
 * @param $arr
 * @return mixed
 */
function bubble_sort($arr)
{
    $len = count($arr); //长度
    for ($i = 0; $i < $len; $i++) { //外层循环控制轮次
        for ($j = $i + 1; $j < $len; $j++) { //内层循环进行比较
            if ($arr[$i] > $arr[$j]) { //比较，大的一直是$arr[$j]，也就是后者
                $temp = $arr[$j];
                $arr[$j] = $arr[$i];
                $arr[$i] = $temp;
            }
        } //一轮下来最大值在末尾
    }//n轮下来排序完成，时间复杂度O(n^2)
    return $arr; //优化思路：添加一个标记，如果一趟遍历中发生了交换，则标记为true，否则为false。如果某一趟没有发生交换，说明排序已经完成！
}

bubble_sort($arr);
$t2 = microtime(true);
dump(($t2 - $t1) * 1000 . 'ms');

// 快速排序
$t1 = microtime(true);
/**
 * 快速排序
 *
 * 选择一个基准数
 * 通过一趟排序将要排序的数据分割成独立的两部分
 * 其中一部分的所有数据都比另外一部分的所有数据都要小
 * 然后，再按此方法对这两部分数据分别进行快速排序
 * 整个排序过程可以递归进行，以此达到整个数据变成有序序列。
 *
 * @param $arr
 * @return array
 */
function quick_sort($arr)
{
    $len = count($arr); //长度
    if ($len <= 1) { //只剩一个元素，直接返回
        return $arr;
    }

    $base = $arr[0]; //基准数
    $left = []; //初始化左边
    $right = []; //初始化右边

    for ($i = 1; $i < $len; $i++) { //轮次
        if ($arr[$i] < $base) { //小于基准数的放入左边
            $left[] = $arr[$i];
        } else { //大于基准数的放入右边
            $right[] = $arr[$i];
        }
    }

    $left = quick_sort($left); //递归左边
    $right = quick_sort($right); //递归右边

    return array_merge($left, [$base], $right); //合并左边、基准数、右边，完成排序
}

quick_sort($arr);
$t2 = microtime(true);
dump(($t2 - $t1) * 1000 . 'ms');

// 插入排序
$t1 = microtime(true);
/**
 * 插入排序
 *
 * 把n个待排序的元素看成为一个有序表和一个无序表
 * 开始时有序表中只包含1个元素，无序表中包含有n-1个元素
 * 排序过程中每次从无序表中取出第一个元素，将它插入到有序表中的适当位置，使之成为新的有序表，重复n-1次可完成排序过程
 *
 * @param $arr
 * @return array
 */
function insert_sort($arr)
{
    $len = count($arr); //长度
    for ($i = 1; $i < $len; $i++) { //无序轮次
        $temp = $arr[$i]; //拿出一个临时元素
        for ($j = $i - 1; $j >= 0; $j--) { //有序轮次
            if ($temp < $arr[$j]) { // 将临时元素放入有序位置
                $arr[$j + 1] = $arr[$j];
                $arr[$j] = $temp;
            }
        }
    }
    return $arr;
}

insert_sort($arr);
$t2 = microtime(true);
dump(($t2 - $t1) * 1000 . 'ms');

// 选择排序
$t1 = microtime(true);
/**
 * 选择排序
 *
 * 首先在未排序的数列中找到最小(or最大)元素，
 * 然后将其存放到数列的起始位置；
 * 接着，再从剩余未排序的元素中继续寻找最小(or最大)元素，
 * 然后放到已排序序列的末尾。
 * 以此类推，直到所有元素均排序完毕。
 * @param $arr
 * @return mixed
 */
function select_sort($arr)
{
    $len = count($arr); //长度
    for ($i = 0; $i < $len - 1; $i++) { //轮次
        $min = $i; //假定的最小值
        for ($j = $i + 1; $j < $len; $j++) { //比较轮次
            if ($arr[$min] > $arr[$j]) {
                $min = $j;
            }
        }
        if ($min != $i) { //选出最小值
            $temp = $arr[$min];
            $arr[$min] = $arr[$i];
            $arr[$i] = $temp;
        }
    }
    return $arr; //相当于每次把最小值放入$arr[$i]的位置
}

select_sort($arr);
$t2 = microtime(true);
dump(($t2 - $t1) * 1000 . 'ms');


// "2930.732011795ms"
// "13.242959976196ms"
// "2146.6610431671ms"
// "1665.9348011017ms"


// 冒泡排序、插入排序、选择排序时间复杂度都是O(n^2)
// 快速排序最坏情况下是O(n^2)，平均的时间复杂度是O(n*lgn)
// 可以看出快速排序是速度最快的，选择排序其次，冒泡排序和插入排序差不多


# 参考动图  https://visualgo.net/en/sorting
