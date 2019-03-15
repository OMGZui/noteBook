<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/3/15
 * Time: 09:54
 */

namespace PHP\DataStruct;

/*计算页面执行时间*/

class Lottery
{
    private $StartTime = 0;
    private $StopTime = 0;

    public function __construct()
    {
        $this->StartTime = $this->getMicroTime();
    }

    private function getMicroTime()
    {
        list($use, $sec) = explode(' ', microtime());
        return ((float)$use + (float)$sec);
    }

    public function end()
    {
        $this->StopTime = $this->getMicroTime();
        return round(($this->StopTime - $this->StartTime) * 1000, 1);
    }

}

//开始计时
$runtime = new Lottery();

/*
 * 经典的概率算法，
 * $proArr是一个预先设置的数组，
 * 假设数组为：array(100,200,300，400)，
 * 开始是从1,1000 这个概率范围内筛选第一个数是否在他的出现概率范围之内，
 * 如果不在，则将概率空间，也就是k的值减去刚刚的那个数字的概率空间，
 * 在本例当中就是减去100，也就是说第二个数是在1，900这个范围内筛选的。
 * 这样 筛选到最终，总会有一个数满足要求。
 * 就相当于去一个箱子里摸东西，
 * 第一个不是，第二个不是，第三个还不是，那最后一个一定是。
 * 这个算法简单，而且效率非常 高，
 * 关键是这个算法已在我们以前的项目中有应用，尤其是大数据量的项目中效率非常棒。
 */
function get_rand($prize_arr)
{

    /*
     * 每次前端页面的请求，PHP循环奖项设置数组，
     * 通过概率计算函数get_rand获取抽中的奖项id。
     * 将中奖奖品保存在数组$res['yes']中，
     * 而剩下的未中奖的信息保存在$res['no']中，
     * 最后输出json个数数据给前端页面。
     */
    $proArr = [];
    foreach ($prize_arr as $key => $val) {
        $proArr[$val['id']] = $val['v'];
    }

    $result = '';
    //概率数组的总概率精度
    $proSum = array_sum($proArr);
    //概率数组循环
    foreach ($proArr as $key => $proCur) {
        $randNum = mt_rand(1, $proSum);
        if ($randNum <= $proCur) {
            $result = $key;
            break;
        } else {
            $proSum -= $proCur;
        }
    }
    unset ($proArr);

    $rid = $result;

    $res['yes'] = $prize_arr[$rid - 1]['prize']; //中奖项
    unset($prize_arr[$rid - 1]); //将中奖项从数组中剔除，剩下未中奖项
    shuffle($prize_arr); //打乱数组顺序
    $pr = [];
    for ($i = 0; $i < count($prize_arr); $i++) {
        $pr[] = $prize_arr[$i]['prize'];
    }
    $res['no'] = $pr;

    return $res;
}


/*
 * 奖项数组
 * 是一个二维数组，记录了所有本次抽奖的奖项信息，
 * 其中id表示中奖等级，prize表示奖品，v表示中奖概率。
 * 注意其中的v必须为整数，你可以将对应的 奖项的v设置成0，即意味着该奖项抽中的几率是0，
 * 数组中v的总和（基数），基数越大越能体现概率的准确性。
 * 本例中v的总和为100，那么平板电脑对应的 中奖概率就是1%，
 * 如果v的总和是10000，那中奖概率就是万分之一了。
 *
 */
$prize_arr = array(
    '0' => array('id' => 1, 'prize' => '平板电脑', 'v' => 1),
    '1' => array('id' => 2, 'prize' => '数码相机', 'v' => 5),
    '2' => array('id' => 3, 'prize' => '音箱设备', 'v' => 10),
    '3' => array('id' => 4, 'prize' => '4G优盘', 'v' => 50),
    '4' => array('id' => 5, 'prize' => '10Q币', 'v' => 100),
    '5' => array('id' => 6, 'prize' => '下次没准就能中哦', 'v' => 10000),
);

$rid = [];
for ($i = 0; $i < 10000; $i++) {
    $rid[] = get_rand($prize_arr); //根据概率获取奖项id
}

$n = count($rid);
$arr = array_column($rid, 'yes');

$p = $s = $y = $four = $q = $x = 0;
foreach ($arr as $item) {
    switch ($item) {
        case '平板电脑':
            $p++;
            break;
        case '数码相机':
            $s++;
            break;
        case '音箱设备':
            $y++;
            break;
        case '4G优盘':
            $four++;
            break;
        case '10Q币':
            $q++;
            break;
        case '下次没准就能中哦':
            $x++;
            break;
    }
}

function format($name, $num, $sum)
{
    echo sprintf("{$num}人中奖，{$name}中奖率为：%.2f%%\n", $num / $sum * 100);
}

format('平板电脑', $p, $n);
format('数码相机', $s, $n);
format('音箱设备', $y, $n);
format('4G优盘', $four, $n);
format('10Q币', $q, $n);
format('下次没准就能中哦', $x, $n);

//计时结束
echo "页面执行时间: " . $runtime->end() . " 毫秒";