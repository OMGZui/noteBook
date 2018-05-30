<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/12/9
 * Time: 12:25
 */

namespace Shengj\Container;

use Illuminate\Container\Container;

require __DIR__ . '/../vendor/autoload.php';

//实例化容器
$container = new Container();

//全局绑定事件，当解析时触发
$container->resolving(function ($object, $app) {
    dump($object);
//    dump($app);
});

// 简单绑定
// alias绑定
$container->bind('hello1', Hello::class);
$container->bind('hello2', function () {
    return new Hello();
});
// 接口绑定
$container->bind(
    HelloInterface::class,
    Hello::class,
    true
);
// 单例绑定
$container->singleton(
    HelloInterface::class,
    Hello::class
);
// 实例绑定
$container->instance('hello4', new Hello());
dump($container);
// 解析
$hello1 = $container->make('hello1');
$hello2 = $container->make('hello2');
$hello3 = $container->make(Hello::class);
$hello4 = $container->make('hello4');
//dump($hello1);
//dump($hello2);
//dump($hello3);
//dump($hello4);
dump($container);


