<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/25
 * Time: 15:53
 */

require __DIR__ . '/../../bootstrap.php';

// 栗子1 用作于回调
$rs1 = preg_replace_callback('/-([a-z])/', function ($match){
    return strtoupper($match[1]);
}, 'hello-world');

dump($rs1); // "helloWorld"

// 栗子2 用作于变量赋值
$greet = function ($name) {
    dump($name);
};

dump($greet instanceof Closure); // true
$greet('PHP'); // "PHP"

// 栗子3 从父作用域继承变量
$message = 'hello';
$example = function () use ($message) {
    dump($message);
};
$example(); // "hello"

