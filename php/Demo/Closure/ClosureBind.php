<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/25
 * Time: 17:00
 */

namespace PHP\Demo\Closure;

use http\Exception\InvalidArgumentException;

class ClosureBind
{
    private $methods = [];

    public function addMethod(string $name, \Closure $callback)
    {
        if (!is_callable($callback)) {
            throw new InvalidArgumentException("第二个参数有误");
        }
        $this->methods[$name] = \Closure::bind($callback, $this, get_class());
    }

    public function __call(string $name, array $arguments)
    {
        if (isset($this->methods[$name])) {
            return call_user_func_array($this->methods[$name], $arguments);
        }

        throw new \RuntimeException("不存在方法[{$name}]");
    }

}