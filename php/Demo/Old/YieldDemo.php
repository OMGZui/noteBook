<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/10/18
 * Time: 10:45
 */

require __DIR__ . '/../../bootstrap.php';

const N = 1000000;

function xRange($start, $limit, $step = 1)
{
    if ($start < $limit) {
        if ($step <= 0) {
            throw new \LogicException('Step must be +ve');
        }

        for ($i = $start; $i <= $limit; $i += $step) {
            yield $i;
        }
    } else {
        if ($step >= 0) {
            throw new \LogicException('Step must be -ve');
        }

        for ($i = $start; $i >= $limit; $i += $step) {
            yield $i;
        }
    }
}

dump($a = memory_get_usage()); //533824
$n1 = range(0, N);
dump($b = memory_get_usage(), $b - $a); //34440680 33906552 32mb
$n2 = xRange(0, N);
dump(memory_get_usage() - $b); // 768 bytes

function count_num()
{
    yield from [10, 2, 3];
}

foreach (count_num() as $item) {
    dump($item);
}
