<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/11/3
 * Time: 12:00
 */

require __DIR__ . '/../../bootstrap.php';

$handle = fopen("php://stdin", "r");
$s = fgets($handle);
while (!empty($s)) {
    [$a, $b] = explode(" ", $s);
    $sum = (int)$a + (int)$b;
    print $sum;
    print "\n";
    $s = fgets($handle);
}
fclose($handle);
