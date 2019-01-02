<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/28
 * Time: 14:21
 */

namespace PHP\Demo\JavaPHP;

class MountainBike extends Bicycle
{
    public $seatHeight;

    public function __construct(int $startHeight, int $startCadence, int $startSpeed, int $startGear)
    {
        parent::__construct($startCadence, $startSpeed, $startGear);
        $this->seatHeight = $startHeight;
    }


    public function setHeight(int $newValue)
    {
        $this->seatHeight = $newValue;
    }
}