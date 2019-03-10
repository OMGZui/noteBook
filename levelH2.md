# 3 年经验 PHP 准备面试

<!-- TOC -->

- [3 年经验 PHP 准备面试](#3-年经验-php-准备面试)
    - [1、引用变量](#1引用变量)
    - [2、unset](#2unset)
    - [3、对象赋值采用引用方式，不会写时复制，需要使用 clone 进行复制](#3对象赋值采用引用方式不会写时复制需要使用-clone-进行复制)
    - [4、栗子 1](#4栗子-1)
    - [5、单引号和双引号](#5单引号和双引号)
    - [6、数据类型](#6数据类型)
    - [7、超全局数组](#7超全局数组)
    - [8、预定义变量](#8预定义变量)
    - [9、@错误控制符，==和===，++$a和$a++](#9错误控制符和a和a)
    - [10、栗子 2](#10栗子-2)
    - [11、foreach 会 reset 重置指针，switch...case 有一个跳转表的概念](#11foreach-会-reset-重置指针switchcase-有一个跳转表的概念)
    - [12、栗子3](#12栗子3)
    - [13、include加载警告、require加载致命错误](#13include加载警告require加载致命错误)
    - [14、正则表达式](#14正则表达式)
    - [15、文件](#15文件)

<!-- /TOC -->

## 1、引用变量

&，指向一个变量的指针

## 2、unset

unset 只会取消引用，不会销毁值

## 3、对象赋值采用引用方式，不会写时复制，需要使用 clone 进行复制

## 4、栗子 1

```php
$data = ['a', 'b', 'c'];
foreach ($data as $key=>$val)
{
    $val = &$data[$key];
    var_dump($data);
}

var_dump($data); // [b,c,c]
```

## 5、单引号和双引号

- 双引号会解析变量 Heredoc
- 单引号效率更高，Nowdoc

## 6、数据类型

- 整数 integer
- 浮点数 float、double 计算使用 bcmath 库，mysql 使用 decimal 字段
- 字符串 string
- 布尔 boolean

- 数组 array
- 对象 object
- 回调 callback

- 资源 resource
- 空 null 赋值 null、未定义的变量、unset 销毁的变量

## 7、超全局数组

- $SERVER['SERVER_ADDR']
- $SERVER['REMOTE_ADDR']

## 8、预定义变量

- **FILE**

## 9、@错误控制符，==和===，++$a和$a++

## 10、栗子 2

```php
# 运算符优先级问题，++、>、||、=
$a = 0;
$b = 0;

if ($a = 3 > 0 || $b = 3 > 0)
{
    $a++;
    $b++;
    echo $a. "\n"; // 1
    echo $b. "\n"; // 1
}
```

## 11、foreach 会 reset 重置指针，switch...case 有一个跳转表的概念

## 12、栗子3

```php
# static只会初始化一次，是局部的，会记录值
$count = 5;
function get_count()
{
    static $count;
    return $count++;
}

echo $count; // 5
++$count;

echo get_count(); // null
echo get_count(); // 1

```

## 13、include加载警告、require加载致命错误

## 14、正则表达式

```php
# 后向引用 \\1
$str = '<b>abc</b>';
$pattern = '/<b>(.*)<\/b>/';
preg_replace(pattern, '\\1', $str);

# 贪婪模式 ?是取消贪婪
$str = '<b>abc</b><b>efg</b>';
$pattern = '/<b>.*?<\/b>/';
preg_match_all(pattern, '\\1', $str);

# 实例：139开头的手机号码
$pattern = '/^139\d{8}$/';
# 实例：取出html中img标签的所有src值
$pattern = '/<img.*?src="(.*?)".*?\/?>/i'
```

## 15、文件

```php


```