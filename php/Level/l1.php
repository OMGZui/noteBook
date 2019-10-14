<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/1/24
 * Time: 15:19
 */
require __DIR__ . '/../bootstrap.php';

// 有两个文本文件，大小都超过了1G，一行一条数据，每行数据不超过500字节，两文件中有一部分内容是完全相同的，请写代码找到相同的行，并写到新文件中。PHP最大允许内内为256M。
// 思路：使用协程yield
function readFieldFile($fileName)
{
    $fp = fopen($fileName, "rb");
    while (!feof($fp)) {
        yield fgets($fp);
    }
    fclose($fp);
}

$file1 = readFieldFile('./l/big1.txt');
$file2 = readFieldFile('./l/big2.txt');

$file1->rewind();
$file2->rewind();
while ($file1->valid() && $file2->valid()) {
    if ($file1->current() == $file2->current()) {
        file_put_contents('./l/big.txt', $file1->current(), FILE_APPEND);
    }
    $file1->next();
    $file2->next();
}

// 自己实现一个支持回调的PHP函数
// 思路：主要是回调函数callback
function myCallBack(Closure $closure, $a, $b)
{
    return $closure($a, $b);
}

dump(myCallBack(function ($a, $b) {
    return $a + $b;
}, 1, 2));

// 请写出至少两个获取指定文件夹下所有文件的方法（代码或思路）。
// 思路：递归获取，排除.和..，除了文件夹就是文件
function myScanDir($dir)
{
    $files = array();
    if (is_dir($dir)) {
        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                if ($file != "." && $file != "..") {
                    if (is_dir($dir . "/" . $file)) {
                        $files[$file] = myScanDir($dir . "/" . $file);
                    } else {
                        $files[] = $dir . "/" . $file;
                    }
                }
            }
            closedir($handle);
            return $files;
        }
    }
}
dump(myScanDir('.'));

// [0,1,2,3] + [1,2,3,4,5] = [0,1,2,3,5] 联合
