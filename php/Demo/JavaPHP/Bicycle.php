<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/28
 * Time: 14:14
 */

namespace PHP\Demo\JavaPHP;

class Bicycle
{
    // 预定义变量
    public $cadence;
    public $speed;
    public $gear;

    // 构造函数
    public function __construct(int $startCadence, int $startSpeed, int $startGear)
    {
        $this->cadence = $startCadence;
        $this->speed = $startSpeed;
        $this->gear = $startGear;
    }

    // 设置踏板
    public function setCadence(int $newValue)
    {
        $this->cadence = $newValue;
    }

    // 设置齿轮
    public function setGear(int $newValue)
    {
        $this->gear = $newValue;
    }

    // 减速
    public function applyBrake(int $decrement)
    {
        $this->speed -= $decrement;
    }

    // 加速
    public function speedUp(int $increment)
    {
        $this->speed += $increment;
    }
}

$bicycle = new Bicycle(30, 0, 8);

echo $bicycle->cadence." ".$bicycle->speed." ".$bicycle->gear."\n";