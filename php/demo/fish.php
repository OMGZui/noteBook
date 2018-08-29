<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/11/3
 * Time: 12:00
 */

namespace PHP\Demo;

require __DIR__ . '/../bootstrap.php';

function solveMeFirst($a, $b)
{
    return $a + $b;
}

$handle = fopen("php://stdin", "r");
$s = fgets($handle);
while (!empty($s)) {
    $a = explode(" ", $s);
    $sum = solveMeFirst((int)$a[0], (int)$a[1]);
    print ($sum);
    print ("\n");
    $s = fgets($handle);
}
fclose($handle);