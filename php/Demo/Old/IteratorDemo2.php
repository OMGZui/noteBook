<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/10/17
 * Time: 17:27
 */

namespace PHP\Demo\Old;

require __DIR__ . '/../../bootstrap.php';

class IteratorDemo2 implements \Iterator
{
    private $var = [];
    private $n;

    public function __construct($arr)
    {
        if (is_array($arr)) {
            $this->var = $arr;
        }
    }

    public function rewind()
    {
        $this->n = 0;
    }

    public function current()
    {
        return $this->var[$this->n];
    }

    public function key()
    {
        return $this->n;
    }

    public function next()
    {
        return $this->n++;
    }

    public function valid()
    {
        return isset($this->var[$this->n]);
    }
}

$it = new IteratorDemo([1, 2, 3]);
dump($it);

foreach ($it as $k => $item) {
    dump("$k:$item");
}