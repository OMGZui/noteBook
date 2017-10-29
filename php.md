# PHP -- The best language

<!-- TOC -->

- [PHP -- The best language](#php----the-best-language)
    - [一、PHP是什么](#一php是什么)
    - [二、PHP安装](#二php安装)
    - [三、PHP 基础](#三php-基础)
    - [四、PHP 进阶](#四php-进阶)
    - [五、PHP 实践](#五php-实践)
        - [1、多维数组变一维数组](#1多维数组变一维数组)
    - [六、PHP 面试](#六php-面试)
    - [七、PHP优化](#七php优化)
    - [八、参考资料](#八参考资料)

<!-- /TOC -->

## 一、PHP是什么

## 二、PHP安装

## 三、PHP 基础

## 四、PHP 进阶

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

[PHP面试](php/php7.php)

## 七、PHP优化

## 八、参考资料
