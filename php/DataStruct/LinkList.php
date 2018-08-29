<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/8/29
 * Time: 10:55
 */

// 结点
class Node
{
    public $link;
    public $value;

    public function __construct($value = null)
    {
        $this->value = $value;
    }
}

class LinkList
{
    public $head;

    public function __construct($arr)
    {
        $this->create($arr);
    }

    private function create($arr)
    {
        $this->head = new Node();
        $next = $this->head;
        for ($i = 0; $i < count($arr); $i++) {
            // 新结点
            $new = new Node();
            $new->value = $arr[$i];
            // 指向下一个结点
            $next->link = $new;
            $new->link = null;
            // 新的下一个结点
            $next = $new;
        }
    }

    public function show(Node $head)
    {
        $next = $head->link;
        while ($next != null) {
            echo $next->value . ' ';
            $next = $next->link;
        }
        echo "\n";
    }

    public function insert(Node $head, $pos, $val)
    {
        $next = $head;
        $i = 0;
        // 拿到第pos个结点的地址
        while ($i < $pos - 1 && $next != null) {
            $next = $next->link;
            $i++;
        }

        if ($i > $pos - 1 || $next == null) {
            return false;
        }

        // 新结点
        $new = new Node();
        $new->value = $val;
        // 临时结点
        $tmp = $next->link;
        // 插入
        $next->link = $new;
        $new->link = $tmp;
        return true;
    }
}

$link = new LinkList([1, 2, 3, 4, 5, 10, 9, 8, 7, 6]);
$head = $link->head;
$link->show($head);
if ($link->insert($head, 1, 100)) {
    $link->show($head);
}
