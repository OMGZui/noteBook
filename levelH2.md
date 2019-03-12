# 3 年经验 PHP 准备面试

<!-- TOC -->

- [3 年经验 PHP 准备面试](#3-%E5%B9%B4%E7%BB%8F%E9%AA%8C-php-%E5%87%86%E5%A4%87%E9%9D%A2%E8%AF%95)
  - [1、引用变量](#1%E5%BC%95%E7%94%A8%E5%8F%98%E9%87%8F)
  - [2、unset](#2unset)
  - [3、对象赋值采用引用方式，不会写时复制，需要使用 clone 进行复制](#3%E5%AF%B9%E8%B1%A1%E8%B5%8B%E5%80%BC%E9%87%87%E7%94%A8%E5%BC%95%E7%94%A8%E6%96%B9%E5%BC%8F%E4%B8%8D%E4%BC%9A%E5%86%99%E6%97%B6%E5%A4%8D%E5%88%B6%E9%9C%80%E8%A6%81%E4%BD%BF%E7%94%A8-clone-%E8%BF%9B%E8%A1%8C%E5%A4%8D%E5%88%B6)
  - [4、栗子1](#4%E6%A0%97%E5%AD%901)
  - [5、单引号和双引号](#5%E5%8D%95%E5%BC%95%E5%8F%B7%E5%92%8C%E5%8F%8C%E5%BC%95%E5%8F%B7)
  - [6、数据类型](#6%E6%95%B0%E6%8D%AE%E7%B1%BB%E5%9E%8B)
  - [7、超全局数组](#7%E8%B6%85%E5%85%A8%E5%B1%80%E6%95%B0%E7%BB%84)
  - [8、预定义变量](#8%E9%A2%84%E5%AE%9A%E4%B9%89%E5%8F%98%E9%87%8F)
  - [9、@错误控制符，==和===，++$a和$a++](#9%E9%94%99%E8%AF%AF%E6%8E%A7%E5%88%B6%E7%AC%A6%E5%92%8Ca%E5%92%8Ca)
  - [10、栗子2](#10%E6%A0%97%E5%AD%902)
  - [11、foreach 会 reset 重置指针，switch...case 有一个跳转表的概念](#11foreach-%E4%BC%9A-reset-%E9%87%8D%E7%BD%AE%E6%8C%87%E9%92%88switchcase-%E6%9C%89%E4%B8%80%E4%B8%AA%E8%B7%B3%E8%BD%AC%E8%A1%A8%E7%9A%84%E6%A6%82%E5%BF%B5)
  - [12、栗子3](#12%E6%A0%97%E5%AD%903)
  - [13、include 加载警告、require 加载致命错误](#13include-%E5%8A%A0%E8%BD%BD%E8%AD%A6%E5%91%8Arequire-%E5%8A%A0%E8%BD%BD%E8%87%B4%E5%91%BD%E9%94%99%E8%AF%AF)
  - [14、正则表达式](#14%E6%AD%A3%E5%88%99%E8%A1%A8%E8%BE%BE%E5%BC%8F)
  - [15、文件](#15%E6%96%87%E4%BB%B6)
  - [16、http状态码](#16http%E7%8A%B6%E6%80%81%E7%A0%81)
  - [17、OSI 7层](#17osi-7%E5%B1%82)
  - [17、get与post区别](#17get%E4%B8%8Epost%E5%8C%BA%E5%88%AB)
  - [18、nginx、fastcgi、php-fpm](#18nginxfastcgiphp-fpm)
  - [19、linux命令](#19linux%E5%91%BD%E4%BB%A4)
  - [20、mysql慢查询](#20mysql%E6%85%A2%E6%9F%A5%E8%AF%A2)

<!-- /TOC -->

## 1、引用变量

&，指向一个变量的指针

## 2、unset

unset 只会取消引用，不会销毁值

## 3、对象赋值采用引用方式，不会写时复制，需要使用 clone 进行复制

## 4、栗子1

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

## 10、栗子2

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

## 13、include 加载警告、require 加载致命错误

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
# 对文本开头进行写内容
function writeContent($file)
{
    $handle = fopen(file, 'r');
    $content = fread(handle, filesize(file));
    $content = 'xxx'.$content;
    fclose($handle);

    $handle = fopen(file, 'w');
    fwrite($handle, $content);
    fclose($handle);
}

# 对目录进行遍历
function loopDir($dir)
{
    $handle = opendir($dir);
    while(false !== ($file = readdir($handle)))
    {
        if($file != '.' && $file != '..')
        {
            if(filetype($dir.'/'.file) == 'dir')
            {
                loopDir($dir.'/'.file);
            }
        }
    }
}

```

## 16、http状态码

- 499 客户端关闭了连接，nginx错误
- 502 bad Gateway 请求过多，比如php-fpm处理不过来，导致无法正常响应
- 504 Gateway time-out nginx超时

## 17、OSI 7层

1. 物理层
2. 数据链路层
3. 网络层
4. 传输层 tcp、udp
5. 会话层
6. 表示层
7. 应用层 http、ftp、dns

## 17、get与post区别

- get可以存浏览器书签
- get可以被缓存
- get有数据长度限制，2048字符
- get用于数据读取，幂等的
- post用于修改数据，是非幂等的
- post更安全
- get只允许ASCII字符，post无限制

## 18、nginx、fastcgi、php-fpm

nginx通过fastcgi协议与php-fpm通信

## 19、linux命令

ps/top/kill/pstree

分 时 日 月 周
*  *  *  *  *

## 20、mysql慢查询

```sql
set profile=1;
show profiles;
show profile for query 1;

explain
```