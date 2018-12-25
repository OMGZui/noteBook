<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/24
 * Time: 16:06
 */

require __DIR__ . '/../../bootstrap.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);
$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello');
echo " [x] Sent 'Hello World!'\n";
$channel->close();
$connection->close();