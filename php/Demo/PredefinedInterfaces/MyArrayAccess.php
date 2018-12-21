<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/21
 * Time: 11:24
 */

namespace PHP\Demo\PredefinedInterfaces;

class MyArrayAccess implements \ArrayAccess
{
    private $container = [];

    public function __construct()
    {
        $this->container = [];
    }

    public function add($value)
    {
        $this->container = array_merge($this->container, $value);
    }


    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }
}