<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/12/4
 * Time: 10:04
 */

namespace PHP\Ext\Date;

class ExtDate
{
    const FORMAT = 'Y-m-d';
    public function __construct()
    {
        echo "-------------------------------  ExtDate  ---------------------------------\n";
        $this->cal();
        $this->dateTime();
        $this->func();
        echo "-------------------------------  ExtDate  ---------------------------------\n";
    }

    public function cal(): void
    {
        echo "-------------------------------  cal  ---------------------------------\n";
        dump(cal_days_in_month(0, 12, 2017));
    }

    public function dateTime(): void
    {
        echo "-------------------------------  dateTime  ---------------------------------\n";
        $date = new \DateTime();
        $now = $date->format(static::FORMAT);
        $now_modify = $date->modify('+30 days')->format(static::FORMAT);
        dump($now);
        dump($now_modify);

        $now = date_create($now);
        $now_modify = date_create($now_modify);
        dump(date_diff($now,$now_modify)->format('%R%a days'));

        dump($date->getTimestamp());
        dump($date->getTimezone()->getName());
    }

    public function func()
    {
        echo "-------------------------------  func  ---------------------------------\n";
        dump(date_default_timezone_get());
        date_default_timezone_set('PRC');

        dump(checkdate(13,30,2017));
        dump(checkdate(12,31,2017));

        dump(microtime(true));

        dump(mktime(0,0,0,12,12,2017));
        dump(time());
        dump(getdate());
        dump(date('Y-m-d H:i:s',time()));
        dump(strtotime((new \DateTime())->format(static::FORMAT)));
    }
}
