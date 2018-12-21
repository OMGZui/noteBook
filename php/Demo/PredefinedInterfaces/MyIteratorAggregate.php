<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/21
 * Time: 10:47
 */
namespace PHP\Demo\PredefinedInterfaces;

class MyIteratorAggregate implements \IteratorAggregate
{
    public $property1 = 'one';
    public $property2 = 'two';
    public $property3 = 'three';

    public function __construct()
    {
        $this->property4 = 'four';
    }

    public function getIterator()
    {
        return new \ArrayIterator($this);
    }
}