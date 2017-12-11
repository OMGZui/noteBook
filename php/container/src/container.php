<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/12/9
 * Time: 12:25
 */

namespace Shengj\Container;

use Illuminate\Container\Container;

require __DIR__.'/../vendor/autoload.php';

//实例化容器
$container = new Container();

//全局绑定事件
//$container->resolving(function ($object, $app) {
//    dump($object->echo());
//});

//绑定
$container->bind('hello',Hello::class);

//解析
$hello = $container->make('hello');
dump($hello->echo());
dump($container->has('hello'));
dump($container);


