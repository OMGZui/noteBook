<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/25
 * Time: 16:50
 */

namespace PHP\Demo\Closure;

class ClosureBindTo
{
    public function __call($name, $arguments)
    {
        if (count($arguments) > 1 && $arguments[0] instanceof \Closure) {
            return call_user_func_array($arguments[0]->bindTo($this), array_slice($arguments, 1));
        }
        throw new \InvalidArgumentException("没有这个方法");
    }
}