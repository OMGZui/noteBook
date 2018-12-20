<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/20
 * Time: 16:46
 */

namespace PHP\Demo\PredefinedInterfaces;

class MyIterator implements \Iterator
{
    private $arr = [];
    private $pos = 0;

    public function __construct()
    {
        $this->pos = 0;
    }

    public function add($value)
    {
        $this->arr[] = $value;
    }

    public function rewind()
    {
        $this->pos = 0;
    }

    public function current()
    {
        return $this->arr[$this->pos];
    }

    public function next()
    {
        $this->pos++;
    }

    public function key()
    {
        return $this->pos;
    }

    public function valid()
    {
        return isset($this->arr[$this->pos]);
    }
}