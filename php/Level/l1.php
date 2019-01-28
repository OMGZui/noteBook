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

// 从用户在浏览器中输入网址并回车，到看到完整的见面，中间都经历了哪些过程。
// 1、浏览器是客户端，输入网址后第一步是dns解析，把网址解析成ip地址
// 2、通过ip地址可以定位到服务器
// 3、通过http协议进行客户端与服务器的连接，会经过三次握手和四次挥手
// 4、如果是nginx+php-fpm服务器，他们是通过fastcgi协议进行联系的，客户端传来的数据通过nginx处理后再给php-fpm
// 5、php-fpm是php的进程管理器，由一个master进程和n个worker进程组成，master进程会分配一个worker进程处理nginx传来的数据
// 6、处理过程是zendVM解析的，把php文件编译成opcode，再转成机器码，得到最终的结果
// 7、最后再返回给浏览器，就是用户看到的页面

// [0,1,2,3] + [1,2,3,4,5] = [0,1,2,3,5] 联合
