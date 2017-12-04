<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/10/23
 * Time: 09:40
 */

namespace PHP\Level;

require __DIR__.'/../bootstrap.php';

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
        preg_split("//u", $str, -1, 1),
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
dump($_SERVER['DOCUMENT_ROOT']);
dump(__DIR__);
dump($_SERVER['REMOTE_ADDR']);
dump($_SERVER['REMOTE_PORT']);
dump($_SERVER['SERVER_NAME']);
dump($_SERVER['SERVER_PORT']);


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
    $number = (string)strrev($number); //倒置
    $number = chunk_split($number, 3, ','); //按","分块
    $number = strrev($number); //再次倒置
    return ltrim($number, ','); //剔除左边的","
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
// sort（正常排序，键值重新组装） asort（按值排序，键值保留） ksort（按键值排序）rsort（倒序，键值重新组装） arsort（按值排序后倒置，键值保留）krsort（按键值排序后倒置）
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
    $str = explode('_', $str);
    foreach ($str as $k => $item) {
        $str[$k] = ucfirst($item);
    }
    return implode('', $str);
}

dump(change_str('make_by_id'));

echo "----------------------------------------- 14 -----------------------------------------\n";
// This is a PHP -> PHP a is This
function my_rev($str)
{
    $arr = explode(' ', $str);
    $num = count($arr);
    for ($i = 0; $i < $num / 2; $i++) {
        $temp = $arr[$i];
        $arr[$i] = $arr[$num - $i - 1];
        $arr[$num - $i - 1] = $temp;
    }
    return implode(' ', $arr);
}

dump(my_rev('This is a PHP'));

echo "----------------------------------------- 15 -----------------------------------------\n";

dump('mysql');
// 用一个 sql 语句查询出发表留言数量大于 10 条的用户名及其留言数量，查询结果按文章数量降序排列

// select u.name count(*) as total
// from user as u
// inner join message as m
// on u.user_id = m.user_id
// group by u.name
// having total > 10
// order by total desc;


// 查询两门及两门以上不及格同学的平均分

// select name,avg(score),sum(score < 60) as gk
// from grade
// group by name
// having gk >= 2;


//简述在 MySQL 数据库中 MyISAM 和 InnoDB 的区别 （亿邮）

//区别主要有以下几个：
//1. 构成上，MyISAM 的表在磁盘中有三个文件组成，分别是表定义文件（ .frm）、数据文件（.MYD）、索引文件（.MYI）,而 InnoDB 的表由表定义文件(.frm)、表空间数据和日志文件组成。
//2. 安全方面，MyISAM 强调的是性能，其查询效率较高，但不支持事务和外键等安全性方面的功能，而 InnoDB 支持事务和外键等高级功能，查询效率稍低。
//3. 对锁的支持，MyISAM 支持表锁，而 InnoDB 支持行锁。

echo "----------------------------------------- 16 -----------------------------------------\n";
// 写出一个能创建多级目录的PHP函数（新浪网技术部）
function create_dir($path, $mode = 0777)
{
    if (is_dir($path)) {
        return '该目录已经存在';
    }

    if (mkdir($path, $mode, true)) {
        return '创建目录成功';
    } else {
        return '创建目录失败';
    }

}

dump('mkdir($path,$mode,true)');

echo "----------------------------------------- 17 -----------------------------------------\n";
//请写一段PHP代码，确保多个进程同时写入同一个文件成功（腾讯）
function file_lock($path)
{
    $fp = fopen($path, 'w+');

    if (flock($fp, LOCK_EX)) {
        //获得写锁，写数据
        fwrite($fp, "todo");

        //解除锁定
        flock($fp, LOCK_UN);
    } else {
        return 'file is locking......';
    }
}

dump('核心思路：加锁');

echo "----------------------------------------- 18 -----------------------------------------\n";
// 写一个函数，能够遍历一个文件夹下的所有文件和子文件夹。（新浪）

function my_scandir($dir)
{
    $files = array();
    if (is_dir($dir)) {
        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                if ($file != "." && $file != "..") {
                    if (is_dir($dir . "/" . $file)) {
                        $files[$file] = my_scandir($dir . "/" . $file);
                    } else {
                        $files[] = $dir . "/" . $file;
                    }
                }
            }
            closedir($handle);
            return $files;
        }
    }
}

//dump(my_scandir('/Users/shengj/mac/php/noteBook'));


echo "----------------------------------------- 19 -----------------------------------------\n";
//写一个函数，算出两个文件的相对路径，如a=′/a/b/c/d/e.php′;b='/a/b/12/34/c.php';计算出b相对于a的相对路径应该是../../c/d（新浪）
function relative_path($path1, $path2)
{
    $arr1 = explode("/", dirname($path1));
    $arr2 = explode("/", dirname($path2));

    for ($i = 0, $len = count($arr2); $i < $len; $i++) {
        if ($arr1[$i] != $arr2[$i]) {
            break;
        }
    }

    $return_path = [];
    // 不在同一个根目录下
    if ($i == 1) {
        $return_path = array();
    }

    // 在同一个根目录下
    if ($i != 1 && $i < $len) {
        $return_path = array_fill(0, $len - $i, "..");
    }

    // 在同一个目录下
    if ($i == $len) {
        $return_path = array('./');
    }

    $return_path = array_merge($return_path, array_slice($arr1, $i));

    return implode('/', $return_path);
}

$a = '/a/b/c/d/e.php';
$b = '/a/b/12/34/c.php';
$c = '/e/b/c/d/f.php';
$d = '/a/b/c/d/g.php';

dump(relative_path($a, $b));//结果是../../c/d
dump(relative_path($a, $c));//结果是a/b/c/d
dump(relative_path($a, $d));//结果是./

echo "----------------------------------------- 20 -----------------------------------------\n";
// 请写一个函数验证电子邮件的格式是否正确（要求使用正则）（新浪）

$email = "862275679@qq.com";
$int = preg_match('/^[\w\-\.]+@[\w\-]+(\.\w+)+$/', $email);

dump($int);
dump($email);

echo "----------------------------------------- 21 -----------------------------------------\n";

//使对象可以像数组一样进行foreach循环，要求属性必须是私有。(Iterator模式的PHP5实现，写一类实现Iterator接口)（腾讯）

class ObjToArray implements \Iterator
{
    private $arr = [
        'id' => 1,
        'name' => 'php'
    ];

    public function current()
    {
        return current($this->arr);
    }

    public function key()
    {
        return key($this->arr);
    }

    public function next()
    {
        return next($this->arr);
    }

    public function rewind()
    {
        reset($this->arr);
    }

    public function valid()
    {
        return ($this->current() !== false);
    }

}

$t = new ObjToArray();
foreach ($t as $k => $v) {
    dump($k . '->' . $v);
}

echo "----------------------------------------- 22 -----------------------------------------\n";

// 用PHP实现一个双向队列（腾讯）

class DoubleQueue
{
    private $queue = ["php", "java", "perl"];

    public function init()
    {
        return $this->queue;
    }

    public function addFirst($item)
    {
        return array_unshift($this->queue, $item);
    }

    public function addLast($item)
    {
        return array_push($this->queue, $item);
    }

    public function removeFirst()
    {
        return array_shift($this->queue);
    }

    public function removeLast()
    {
        return array_pop($this->queue);
    }
}

$queue = new DoubleQueue();

$queue->addFirst('js');
$queue->addLast('python');
dump($queue->init());

$queue->removeFirst();
$queue->removeLast();
dump($queue->init());


echo "----------------------------------------- 23 -----------------------------------------\n";
// 一群猴子排成一圈，按1，2，...，n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，
//从它后面再开始数，再数到第m只，在把它踢出去...，
//如此不停的进行下去，直到最后只剩下一只猴子为止，那只猴子就叫做大王。
//要求编程模拟此过程，输入m、n,输出最后那个大王的编号。（新浪）（小米）

// 方案一，使用php来模拟这个过程
function king($n, $m)
{
    //猴子的初始数量不能小于2
    if ($n < 2) {
        return false;
    }

    $arr = range(1, $n);
    //将猴子分到一个数组里, 数组的值对应猴子的初始编号
    $unsetNum = 0;
    //定义一个变量,记录猴子的报数

    for ($i = 2; $i <= $n * $m; $i++) //总的循环次数不知道怎么计算,
    {
        //不过因为循环中设置了return,所以$m*$len效率还可以
        foreach ($arr as $k => $v) {
            $unsetNum++; //每到一个猴子, 猴子报数+1

            //当猴子的报数等于淘汰的数字时:淘汰猴子(删除数组元素)
            //报数归0(下一个猴子从1开始数)
            if ($unsetNum == $m) {
//              print_r($arr);
                unset($arr[$k]);
                //淘汰猴子
                $unsetNum = 0;
                //报数归零
                if (count($arr) == 1) //判断数组的长度, 如果只剩一个猴子, 返回它的值
                {
                    return reset($arr);
                }
            }
        }
    }
}

// 测试
dump(king(10, 3));

// 方案二，使用数学方法解决
function josephus($n, $m)
{
    $r = 0;
    //	$i=2指猴子的初始数量$n至少是两只
    for ($i = 2; $i <= $n; $i++) {
        $r = ($r + $m) % $i;
    }
    return $r + 1;
}

dump(josephus(10, 3));


//dump("1+5=". 5+1); // 2
//dump("1+5=". 1+5); // 6
//dump("5+1=". 5+1); // 6
//dump("5+1=". 1+5); // 10

echo "----------------------------------------- 24 -----------------------------------------\n";

// 将一个二维数组的值首字母大写
$array = [
    ['name' => 'shengj', 'sex' => 'male'],
    ['name' => 'wangm', 'sex' => 'male'],
];
function arrayToU(array $array): array
{
    $arr = [];
    foreach ($array as $k => $item) {
        $keys = array_keys($item);
        $values = array_values($item);
        foreach ($keys as $kk => $key) {
            $arr[$k][$key] = ucfirst($values[$kk]);
        }
    }
    return $arr;
}

dump(arrayToU($array));

echo "----------------------------------------- 25 -----------------------------------------\n";

// 使用正则获取html里的href属性的值和a标签内的值，并以href值为key，a标签内的值为value存入二维数组中
$str = '
    <ul class="attr">
        <li>
            <a href="www.baidu.com">百度baidu</a>
            <a href=\'www.tecent.com\'>腾讯tengxun</a>
            <a href="www.alibaba.com">阿里巴巴alibaba</a>
        </li>
    </ul>
';

function pregToArr(string $str): array
{
    $preg_href = '/href=[\'\"](.*)[\'\"]/i';
    preg_match_all($preg_href, $str, $match_href);
//    dump($match_href);
    $preg_a = '/\>(.*)\<\/a\>/';
    preg_match_all($preg_a, $str, $match_a);
//    dump($match_a);

    $match_href = $match_href[1];
    $match_a = $match_a[1];


    $arr = [];
    foreach ($match_href as $k => $item) {
        $arr[$k][$item] = $match_a[$k];
    }
    return $arr;
}

dump(pregToArr($str));


echo "----------------------------------------- 26 -----------------------------------------\n";

//找出N个数中的第M大的数
function findNInM(array $array, int $n): int
{
    $len = count($array);
    if ($n > $len) {
        return '越界了，老妹';
    }
    sort($array);
    return $array[$len - $n];
}

$arrM = [1, 4, 7, 5];

dump(findNInM($arrM, 3));