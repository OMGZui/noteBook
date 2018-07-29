<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/7/29
 * Time: 16:22
 */

namespace PHP\Modern;

require __DIR__ . '/../vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$log = new Logger('app');
$log->pushHandler(new StreamHandler('../logs/dev.log', Logger::DEBUG));
$log->pushHandler(new StreamHandler('../logs/pro.log', Logger::WARNING));

$log->debug('这是个bug');
$log->warning('这是个警告');
