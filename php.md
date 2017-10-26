# PHP -- The best language

## PHP 基础

## PHP 进阶

## PHP 实践

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

## PHP 面试

[PHP面试](php/php7.php)