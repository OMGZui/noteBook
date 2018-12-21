#!/usr/local/opt/php/bin/php
<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/21
 * Time: 15:04
 */

require __DIR__ . '/../../bootstrap.php';

set_time_limit(0);

const M = 1000000;

// 生成一个大文件
$t1 = microtime(true);
$fp = fopen("./text.txt", "w");

for ($i = 1; $i <= M; $i++) {
    if ($i % 10 == 0) {
        fwrite($fp, "\n");
    }
    fwrite($fp, $i);
}
fclose($fp);

$t2 = microtime(true);

dump(timeUsage($t1, $t2));