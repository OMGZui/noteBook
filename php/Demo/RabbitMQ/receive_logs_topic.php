<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/1/23
 * Time: 14:08
 */
require __DIR__ . '/../../bootstrap.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

// php receive_logs_topic.php "kern.*" "*.critical"
// 使用#等效于fanout 所有都监听
// 使用*等效于direct 符合模式的才监听
$channel->exchange_declare('topic_logs', 'topic', false, false, false);

[$queue_name, ,] = $channel->queue_declare("", false, false, true, false);

$binding_keys = array_slice($argv, 1);
if (empty($binding_keys)) {
    file_put_contents('php://stderr', "Usage: $argv[0] [binding_key]\n");
    exit(1);
}

foreach ($binding_keys as $binding_key) {
    $channel->queue_bind($queue_name, 'topic_logs', $binding_key);
}

echo " [*] Waiting for logs. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();