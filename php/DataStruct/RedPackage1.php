<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/3/11
 * Time: 10:21
 */

include_once __DIR__ . '/../bootstrap.php';

// 二倍均值法
/**
 * 假设有10个人，红包总额100元。
 *
 * 100/10X2 = 20, 所以第一个人的随机范围是（0，20 )，平均可以抢到10元。
 *
 * 假设第一个人随机到10元，那么剩余金额是100-10 = 90 元。90/9X2 = 20, 所以第二个人的随机范围同样是（0，20 )，平均可以抢到10元。
 *
 * 假设第二个人随机到10元，那么剩余金额是90-10 = 80 元。80/8X2 = 20, 所以第三个人的随机范围同样是（0，20 )，平均可以抢到10元。
 *
 * 以此类推，每一次随机范围的均值是相等的。
 * @param $totalAmount
 * @param $peopleNum
 * @return array
 */
function red($totalAmount, $peopleNum)
{
    $restAmount = $totalAmount;
    $restNum = $peopleNum;
    $amountList = [];

    for ($i = 0; $i < $peopleNum - 1; $i++) {
        $amount = mt_rand(0, $restAmount / $restNum * 2 - 1) + 1;
        $restAmount -= $amount;
        $restNum--;
        $amountList[] = $amount;
    }
    $amountList[] = $restAmount;
    return $amountList;
}

dump(red(100, 10));
//dump(array_sum(red(100, 10)));

$total = 10;//红包总额
$num = 8;// 分成8个红包，支持8人随机领取
$min = 0.01;//每个人最少能收到0.01元
for ($i = 1; $i < $num; $i++) {
    $safe_total = ($total - ($num - $i) * $min) / ($num - $i);
    //随机安全上限
    $money = mt_rand($min * 100, $safe_total * 100) / 100;
    $total = $total - $money;
    echo '第' . $i . '个红包：' . $money . ' 元，余额：' . $total . " 元 \n";
}
echo '第' . $num . '个红包：' . $total . ' 元，余额：0 元';

function getRedPacket(&$packet)
{
    //红包发完了
    if ($packet['totalNum'] < 1) {
        return 0.0;
    } //红包只剩一个了
    elseif ($packet['totalNum'] === 1) {
        $packet['totalNum']--;
        return $packet['totalMoney'];
    } else {
        //保证用户抢到的红包不出现0.00
        $min = 0.01;
        //该计算保证结果的期望值接近红包总额/红包总数的100倍（减一是为了保证最后一个红包不为0），化为整数计算是因为浮点数运算费时
        $max = ($packet['totalMoney'] * 100 - 1) / $packet['totalNum'] * 2 * mt_rand(0, 100) / 100;
        //化为浮点数，并保证精度是2
        $max = round($max / 100, 2);
        $money = $max < $min ? $min : $max;
        $packet['totalNum']--;
        $packet['totalMoney'] -= $money;
        return $money;
    }
}

echo "\n";
//测试
$packet = [
    'totalNum' => 8,
    'totalMoney' => 10
];
$sent = 0.00;
while ($packet['totalNum'] > 0) {
    $money = getRedPacket($packet);
    echo $money . '    ';
    $sent += $money;
}
echo $sent;