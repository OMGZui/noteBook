# 3 年经验 PHP 准备面试

<!-- TOC -->

- [3 年经验 PHP 准备面试](#3-%e5%b9%b4%e7%bb%8f%e9%aa%8c-php-%e5%87%86%e5%a4%87%e9%9d%a2%e8%af%95)
  - [1、引用变量](#1%e5%bc%95%e7%94%a8%e5%8f%98%e9%87%8f)
  - [2、unset](#2unset)
  - [3、对象赋值采用引用方式，不会写时复制，需要使用 clone 进行复制](#3%e5%af%b9%e8%b1%a1%e8%b5%8b%e5%80%bc%e9%87%87%e7%94%a8%e5%bc%95%e7%94%a8%e6%96%b9%e5%bc%8f%e4%b8%8d%e4%bc%9a%e5%86%99%e6%97%b6%e5%a4%8d%e5%88%b6%e9%9c%80%e8%a6%81%e4%bd%bf%e7%94%a8-clone-%e8%bf%9b%e8%a1%8c%e5%a4%8d%e5%88%b6)
  - [4、栗子1](#4%e6%a0%97%e5%ad%901)
  - [5、单引号和双引号](#5%e5%8d%95%e5%bc%95%e5%8f%b7%e5%92%8c%e5%8f%8c%e5%bc%95%e5%8f%b7)
  - [6、数据类型](#6%e6%95%b0%e6%8d%ae%e7%b1%bb%e5%9e%8b)
  - [7、超全局数组](#7%e8%b6%85%e5%85%a8%e5%b1%80%e6%95%b0%e7%bb%84)
  - [8、预定义变量](#8%e9%a2%84%e5%ae%9a%e4%b9%89%e5%8f%98%e9%87%8f)
  - [9、@错误控制符，==和===，++$a和$a++](#9%e9%94%99%e8%af%af%e6%8e%a7%e5%88%b6%e7%ac%a6%e5%92%8ca%e5%92%8ca)
  - [10、栗子2](#10%e6%a0%97%e5%ad%902)
  - [11、foreach 会 reset 重置指针，switch...case 有一个跳转表的概念](#11foreach-%e4%bc%9a-reset-%e9%87%8d%e7%bd%ae%e6%8c%87%e9%92%88switchcase-%e6%9c%89%e4%b8%80%e4%b8%aa%e8%b7%b3%e8%bd%ac%e8%a1%a8%e7%9a%84%e6%a6%82%e5%bf%b5)
  - [12、栗子3](#12%e6%a0%97%e5%ad%903)
  - [13、include 加载警告、require 加载致命错误](#13include-%e5%8a%a0%e8%bd%bd%e8%ad%a6%e5%91%8arequire-%e5%8a%a0%e8%bd%bd%e8%87%b4%e5%91%bd%e9%94%99%e8%af%af)
  - [14、正则表达式](#14%e6%ad%a3%e5%88%99%e8%a1%a8%e8%be%be%e5%bc%8f)
  - [15、文件](#15%e6%96%87%e4%bb%b6)
  - [16、http状态码](#16http%e7%8a%b6%e6%80%81%e7%a0%81)
  - [17、OSI 7层](#17osi-7%e5%b1%82)
  - [17、get与post区别](#17get%e4%b8%8epost%e5%8c%ba%e5%88%ab)
  - [18、nginx、fastcgi、php-fpm](#18nginxfastcgiphp-fpm)
  - [19、linux命令](#19linux%e5%91%bd%e4%bb%a4)
  - [20、mysql慢查询](#20mysql%e6%85%a2%e6%9f%a5%e8%af%a2)

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
