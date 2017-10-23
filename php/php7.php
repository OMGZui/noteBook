<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/10/23
 * Time: 09:40
 */

namespace PHP;

require '../vendor/autoload.php';

echo "----------------------------------------- 1 -----------------------------------------\n";
// strlen() 与 mb_strlen
$str1 = '我是你的5ge小苹果';

dump(strlen($str1)); // 24
dump(mb_strlen($str1, 'utf-8')); // 10

// 输出  5ge小苹果
dump(mb_substr($str1, 4, mb_strlen($str1, 'utf-8') - 4, 'utf-8'));

// 等值 mb_substr
function substr_utf8($str, $start, $length = null)
{
    $arr = array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY),
        $start,
        $length
    );
    return implode('', $arr);
}

// 等值 mb_strlen
function strlen_utf8($str)
{
    return count(preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY));
}

// 输出  5ge小苹果
dump(substr_utf8($str1, 4, strlen_utf8($str1) - 4));

echo "----------------------------------------- 2 -----------------------------------------\n";
//超全局数组
//dump($_SERVER);
dump($_SERVER['SERVER_NAME']);

echo "----------------------------------------- 3 -----------------------------------------\n";
// 3个数的最大值
function max_num($a, $b, $c)
{
    return $a > $b ? ($a > $c ? $a : $c) : ($b > $c ? $b : $c);
}

dump(max_num(1, 2, 3));

echo "----------------------------------------- 4 -----------------------------------------\n";
// 打印前一天的时间格式 2017-10-23 10:33:20
date_default_timezone_set('PRC');

dump(date('Y-m-d H:i:s', time() - 60 * 60 * 24));
dump(date('Y-m-d H:i:s', strtotime("-1 day")));

echo "----------------------------------------- 5 -----------------------------------------\n";
// 不使用第三个变量交换两个变量的值
function prop_exchange($a, $b, $default = false)
{
    if ($default) {
        list($a, $b) = [$b, $a];
        return $a . '-->' . $b;
    } else {
        $a = $a . '-' . $b;
        $b = explode('-', $a);
        return $b[1] . '-->' . $b[0];
    }
}

dump(prop_exchange(1, 2));

echo "----------------------------------------- 6 -----------------------------------------\n";
// 将 1234567890 转换成 1,234,567,890 每3个数字用逗号隔开的形式。（百度）
$number = 1234567890;
dump(number_format($number));
function number_thousands($number)
{
    $number = strrev($number);
    $number = chunk_split($number, 3, ',');
    $number = strrev($number);
    return ltrim($number, ',');
}

dump(number_thousands($number));

echo "----------------------------------------- 7 -----------------------------------------\n";
// 如何实现中文字符串翻转
function strrev_utf8($str)
{
    return implode('', array_reverse(preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY)));
}

dump(strrev_utf8($str1));

dump(strrev(substr('www.baidu.com', 4, 9)));
dump(strrev(str_replace('www.', '', 'www.baidu.com')));

echo "----------------------------------------- 8 -----------------------------------------\n";
// sort asort ksort
$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
sort($fruits);
dump($fruits);

echo "----------------------------------------- 9 -----------------------------------------\n";
// error_reporting(2047) 什么作用？（新浪）
error_reporting(2047); // 2047 = 1 + 2 + 4 + 8 + 16 + 32 + 64 + 128 + 256 + 512 + 1024 全部错误显示
dump(2047);

echo "----------------------------------------- 10 -----------------------------------------\n";
// 写个函数用来对二维数组排序（新浪）
function array_sort($arr, $row, $type = SORT_ASC)
{
    //取得要排序的列
    foreach ($arr as $key => $item) {
        $volume[$key] = $item[$row];
    }

    array_multisort($volume, $type, $arr);
    return $arr;
}

$person = array(
    array('id' => 2, 'name' => 'zhangsan', 'age' => 23),
    array('id' => 5, 'name' => 'lisi', 'age' => 28),
    array('id' => 3, 'name' => 'apple', 'age' => 17)
);

dump(array_sort($person, 'id', SORT_DESC));

echo "----------------------------------------- 11 -----------------------------------------\n";
// 写 5 个不同的自己的函数，来获取一个全路径的文件的扩展名，允许封装 php 库中已有的函数。（新浪）
$path = $_SERVER['SCRIPT_FILENAME'];
function ext_name($path, $type = 1)
{
    switch ($type) {
        case 1:
            $path = strrchr($path, '.');
            return ltrim($path, '.');
            break;
        case 2:
            $path = substr($path, strrpos($path, '.'));
            return ltrim($path, '.');
            break;
        case 3:
            $path = pathinfo($path);
            return $path['extension'];
        case 4:
            $path = explode('.', $path);
            return $path[count($path) - 1];
        case 5:
            $pattern = '/^[^\.]+\.([\w]+)$/';
            return preg_replace($pattern, '${1}', basename($path));
    }
}

dump(ext_name($path, 1));
dump(ext_name($path, 2));
dump(ext_name($path, 3));
dump(ext_name($path, 4));
dump(ext_name($path, 5));

echo "----------------------------------------- 12 -----------------------------------------\n";
// == 与 ===
dump(strpos('abc', 'a') === false);
dump(strpos('abc', 'a') == false);

echo "----------------------------------------- 13 -----------------------------------------\n";
// 请 写 一 个 函 数 ， 实 现 以 下 功 能 ： 字 符 串 "open_door" 转 换 成 "OpenDoor" 、"make_by_id" 转换成 "MakeById"。
function change_str($str)
{
    //先切割，转为首字母大写后，再聚合
    $str = explode('_',$str);
    foreach ($str as $k => $item) {
        $str[$k] = ucfirst($item);
    }
    return implode('',$str);
}
dump(change_str('make_by_id'));

echo "----------------------------------------- 14 -----------------------------------------\n";
function myrev($str){
    $arr = explode(' ',$str);
    $num = count($arr);
    for($i = 0; $i < $num/2; $i++){
        $temp = $arr[$i];
        $arr[$i] = $arr[$num-$i-1];
        $arr[$num-$i-1] = $temp;
    }
    return implode(' ',$arr);
}

dump(myrev('This is PHP'));

echo "----------------------------------------- 15 -----------------------------------------\n";
