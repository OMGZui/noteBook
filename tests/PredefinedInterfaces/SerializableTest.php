<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/20
 * Time: 16:29
 */

namespace Tests\PredefinedInterfaces;

use PHP\Demo\PredefinedInterfaces\MySerializable;
use PHPUnit\Framework\TestCase;

class SerializableTest extends TestCase
{
    public function testSerializable()
    {
        // 实现了Serializable接口，__wakeup()和__sleep()将失效
        // 楼主感觉这个作用不大呀。。。
        $obj = new MySerializable();
        $obj->add('你个小可爱');

        $ser = serialize($obj);
        $serUn = unserialize($ser);
        $this->assertEquals('你个小可爱', $serUn->getData());

    }
}