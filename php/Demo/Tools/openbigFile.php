<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/21
 * Time: 15:02
 */

require __DIR__ . '/../../bootstrap.php';

ini_set('memory_limit', '512M');

// 1000w数据
$fileName = './text.txt';
// 直接读取
function readLocalFile($fileName)
{
    $fp = fopen($fileName, "rb");
    $lines = [];
    while (!feof($fp)) {
        $lines[] = fgets($fp);
    }
    fclose($fp);
    return $lines;
}

// 生成器读取
function readFieldFile($fileName)
{
    $fp = fopen($fileName, "rb");
    while (!feof($fp)) {
        yield fgets($fp);
    }
    fclose($fp);
}

// 测试
$t1 = memory_get_usage();
$linesLocal = readLocalFile($fileName);
$t2 = memory_get_usage();
dump(convertSize($t2 - $t1)); // 123.4mb

$t1 = memory_get_usage();
$linesYield = readFieldFile($fileName);
$t2 = memory_get_usage();
dump(convertSize($t2 - $t1)); // 608b

foreach ($linesYield as $k => $value) {
    if ($k == 1000) dump($value);
}
