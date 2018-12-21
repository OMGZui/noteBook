<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/21
 * Time: 11:24
 */

namespace PHP\Demo\PredefinedInterfaces;

class MySerializable implements \Serializable
{
    private $serialized = '';


    public function __construct()
    {
        $this->serialized = '';
    }

    public function add($value)
    {
        $this->serialized = $value;
    }

    public function __wakeup()
    {
        return '序列化';
    }

    public function __sleep()
    {
        return '反序列化';
    }

    public function serialize()
    {
        return serialize($this->serialized);
    }

    public function unserialize($serialized)
    {
        $this->serialized = unserialize($serialized);
    }

    public function getData()
    {
        return $this->serialized;
    }

}