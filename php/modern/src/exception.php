<?php

/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/8/3
 * Time: 22:53
 */

namespace PHP\Modern;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;


require __DIR__ . '/../vendor/autoload.php';

// 注册whoops
$whoops = new Run();
$whoops->pushHandler(new PrettyPageHandler());
$whoops->register();

$e = new \Exception('omgzui', 400);

$code = $e->getCode();
$message = $e->getMessage();

var_dump($code);
var_dump($message);


var_dump(1 / 0);