<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/3/11
 * Time: 17:10
 */

namespace PHP\DataStruct;

class LoopLink
{
    // 是否有环
    function isLoop(Node $node)
    {
        $fast = $slow = $node;
        if ($node->value == null) {
            return false;
        }

        // 快慢指针
        while ($fast->link != null && $fast->link->link != null) {
            //快指针一次走两步
            $fast = $fast->link->link;
            //慢指针一次走一步
            $slow = $slow->link;
        }

        if ($fast === $slow) {
            return true;
        } else {
            return false;
        }
    }

    // 找出p点，即环的入口
    public function link(Node $node)
    {
        $fast = $slow = $node;
        if ($node->value == null) {
            return null;
        }

        while ($fast->link != null && $fast->link->link != null) {
            //快指针一次走两步
            $fast = $fast->link->link;
            //慢指针一次走一步
            $slow = $slow->link;
        }

        //慢指针追上快指针,说明有环
        if ($fast === $slow) {
            $p1 = $node;
            $p2 = $fast;
            //p1指针指向head节点,p2指针指向它们第一次相交的点,然后两个指针每次移动一步,当它们再次相交,即为环的入口
            while ($p1 !== $p2) {
                $p1 = $p1->link;
                $p2 = $p2->link;
            }
            return $p1; //环的入口节点
        } else {
            return null;
        }
    }
}