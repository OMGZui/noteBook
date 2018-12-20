<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/10/17
 * Time: 17:27
 */

namespace PHP\Demo\Old;

require __DIR__ . '/../../bootstrap.php';

class IteratorDemo implements \Iterator
{
    private $var = [];

    public function __construct($arr)
    {
        if (is_array($arr)) {
            $this->var = $arr;
        }
    }

    public function rewind()
    {
        reset($this->var);
    }

    public function current()
    {
        return current($this->var);
    }

    public function key()
    {
        return key($this->var);
    }

    public function next()
    {
        return next($this->var);
    }

    public function valid()
    {
        return $this->current() !== false;
    }
}

$it = new IteratorDemo([1, 2, 3]);
dump($it);

foreach ($it as $k => $item) {
    dump("$k:$item");
}