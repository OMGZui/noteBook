<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/20
 * Time: 15:45
 */
namespace PHP\DataStruct;

// 结点
class Node
{
    public $link; // 指针域
    public $value; // 数据域

    public function __construct($value = null)
    {
        $this->value = $value;
    }
}
