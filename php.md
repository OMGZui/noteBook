# PHP -- The best language

<!-- TOC -->

- [PHP -- The best language](#php----the-best-language)
    - [一、PHP是什么](#一php是什么)
    - [二、PHP安装](#二php安装)
        - [1、yum安装](#1yum安装)
        - [2、源码安装](#2源码安装)
    - [三、PHP 基础](#三php-基础)
        - [1、类型](#1类型)
        - [2、变量](#2变量)
        - [3、常量](#3常量)
        - [4、表达式](#4表达式)
        - [5、运算符](#5运算符)
        - [6、流程控制](#6流程控制)
        - [7、函数](#7函数)
    - [四、PHP 进阶](#四php-进阶)
        - [1、类与对象](#1类与对象)
        - [2、命名空间](#2命名空间)
        - [3、异常处理](#3异常处理)
        - [4、生成器](#4生成器)
        - [5、预定义变量/异常/接口/](#5预定义变量异常接口)
        - [6、上下文（Context）选项和参数](#6上下文context选项和参数)
    - [五、PHP 实践](#五php-实践)
        - [1、多维数组变一维数组](#1多维数组变一维数组)
    - [六、PHP 面试](#六php-面试)
    - [七、PHP扩展](#七php扩展)
    - [八、PHP优化](#八php优化)
    - [九、参考资料](#九参考资料)

<!-- /TOC -->

## 一、PHP是什么

PHP（全称：PHP：Hypertext Preprocessor，即“PHP：超文本预处理器”）是一种开源的通用计算机脚本语言，尤其适用于网络开发并可嵌入HTML中使用。PHP的语法借鉴吸收C语言、Java和Perl等流行计算机语言的特点，易于一般程序员学习。PHP的主要目标是允许网络开发人员快速编写动态页面，但PHP也被用于其他很多领域。

## 二、PHP安装

### 1、yum安装

```sh
# php7.1
rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-6.noarch.rpm
rpm -Uvh https://mirror.webtatic.com/yum/el6/latest.rpm

yum -y install php71w-fpm php71w-opcache php71w-cli php71w-common php71w-dba php71w-devel php71w-embedded php71w-enchant php71w-gd php71w-imap php71w-interbase php71w-intl php71w-ldap php71w-mbstring php71w-mcrypt php71w-mysqlnd php71w-odbc php71w-pdo php71w-pdo_dblib php71w-pear  php71w-pecl-imagick php71w-pecl-memcached php71w-pecl-mongodb php71w-pecl-redis php71w-pecl-xdebug php71w-pgsql php71w-phpdbg php71w-process php71w-pspell php71w-recode php71w-snmp php71w-soap php71w-tidy php71w-xml php71w-xmlrpc
```

### 2、源码安装

## 三、PHP 基础

### 1、类型

Boolean 布尔类型
Integer 整型
Float 浮点型
String 字符串
Array 数组
Object 对象
Resource 资源类型
NULL
Callback / Callable 类型

### 2、变量

### 3、常量

### 4、表达式

### 5、运算符

### 6、流程控制

### 7、函数

## 四、PHP 进阶

### 1、类与对象

### 2、命名空间

### 3、异常处理

### 4、生成器

### 5、预定义变量/异常/接口/

### 6、上下文（Context）选项和参数

## 五、PHP 实践

### 1、多维数组变一维数组

```php

$result = [];
//无键值对
array_walk_recursive($arr, function($value) use (&$result) {
    array_push($result, $value);
});
//有键值对
array_walk_recursive($arr, function($value) use (&$result) {
    array_push($result, array_values($value));
});

```

## 六、PHP 面试

[PHP面试](php)

## 七、PHP扩展

按phpinfo()上的扩展解读

- date 时间库
- dom/xml/SimpleXML/libxml xml操作库
- exif 相机库
- fileinfo 文件相关库
- filter 参数过滤库
- ftp ftp库
- gd 图像库
- hash hash算法库
- iconv 字符串转换库
- imagick 图像库
- json json操作库
- mbstring 多字节字符串操作库
- memcached 缓存库
- mongodb 数据库
- mysqli 数据库
- mysqlnd 数据库
- openssl 加密库
- pcre 正则库
- PDO 数据库
- Phar 包
- posix 多进程库
- readline 交互库
- redis 缓存库
- Reflection 反射库
- session 会话库
- SPL 标准库
- swoole 异步库
- tokenizer 标记库
- xdebug debug库
- Zend OPcache 缓存库
- zlib 压缩库

## 八、PHP优化

## 九、参考资料

[php手册](http://php.net/)
