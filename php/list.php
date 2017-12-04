<?php

namespace PHP;

require 'index.php';

/**
 *
 * @version:1.0
 * @date:2016-05-22
 *单链表的基本操作
 *1.初始化单链表 __construct()
 *2.清空单链表 clearSLL()
 *3.返回单链表长度 getLength()
 *4.判断单链表是否为空 getIsEmpty()
 *5.头插入法建表 getHeadCreateSLL()
 *6.尾插入法建表 getTailCreateSLL()
 *7.返回第$i个元素 getElemForPos()
 *8.查找单链表中是否存在某个值的元素 getElemIsExist()
 *9.单链表的插入操作 getInsertElem()
 *10.遍历单链表中的所有元素 getAllElem()
 *11.删除单链中第$i个元素 getDeleteElem()
 *12.删除单链表所有重复的值 getElemUnique()
 **/
header("content-type:text/html;charset=UTF-8");


class LNode
{
    public $mElem;
    public $mNext;

    public function __construct()
    {
        $this->mElem = null;
        $this->mNext = null;
    }
}

class SingleLinkedList
{
    //头结点数据
    public $mElem;
    //下一结点指针
    public $mNext;
    //单链表长度
    public static $mLength = 0;

    public function __construct()
    {
        $this->mElem = null;
        $this->mNext = null;
    }

    //返回单链表长度
    public static function getLength()
    {
        return self::$mLength;
    }

    public function getIsEmpty()
    {
        if (self::$mLength == 0 && $this->mNext == null) {
            return true;
        } else {
            return false;
        }
    }

    public function clearSLL()
    {
        if (self::$mLength > 0) {
            while ($this->mNext != null) {
                $q = $this->mNext->mNext;
                $this->mNext = null;
                unset($this->mNext);
                $this->mNext = $q;
            }
            self::$mLength = 0;
        }
    }

    public function getHeadCreateSLL($sarr)
    {
        $this->clearSLL();

        if (is_array($sarr) and count($sarr) > 0) {
            foreach ($sarr as $key => $value) {
                $p = new LNode;
                $p->mElem = $value;
                $p->mNext = $this->mNext;
                $this->mNext = $p;
                self::$mLength++;
            }
        } else {
            return false;
        }
        return true;
    }

    public function getTailCreateSLL($sarr)
    {
        $this->clearSLL();

        if (is_array($sarr) and count($sarr) > 0) {
            $q = $this;
            foreach ($sarr as $value) {
                $p = new LNode;
                $p->mElem = $value;
                $p->mNext = $q->mNext;
                $q->mNext = $p;
                $q = $p;
                self::$mLength++;
            }
        } else {
            return false;
        }
    }

    public function getElemForPos($i)
    {
        if (is_numeric($i) && $i < self::$mLength && $i > 0) {
            $p = $this->mNext;
            for ($j = 1; $j < $i; $j++) {
                $q = $p->mNext;
                $p = $q;
            }
            return $p->mElem;
        } else {
            return null;
        }
    }

    public function getElemIsExist($value)
    {
        if ($value) {
            $p = $this;
            while ($p->mNext != null and $p->mElem != value) {
                $q = $p->mNext;
                $p = $q;
            }
            if ($p->mElem == value) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getElemPosition($value)
    {
        if ($value) {
            $p = $this;
            $pos = 0;
            while ($p->mNext != null and $p->mElem != $value) {
                $q = $p->mNext;
                $p = $q;
                $pos++;
            }
            if ($p->mElem == $value) {
                return $pos;
            } else {
                return -1;
            }
        }
    }

    /**
     * 单链表的插入操作
     *
     * @param int $i 插入元素的位序，即在什么位置插入新的元素,从1开始
     * @param mixed $e 插入的新的元素值
     * @return boolean 插入成功返回true，失败返回false
     */
    public function getInsertElem($i, $e)
    {
        if ($i < self::$mLength) {
            $j = 1;
            $p = $this;
        } else {
            return false;
        }
        while ($p->mNext != null and $j < $i) {
            $q = $p->mNext;
            $p = $q;
            $j++;
        }
        $q = new LNode;
        $q->mElem = $e;
        $q->mNext = $p->mNext;
        $p->mNext = $q;
        self::$mLength++;
        return true;
    }

    /**
     *删除单链中第$i个元素
     * @param int $i 元素位序
     * @return boolean 删除成功返回true,失败返回false
     */
    public function getDeleteElem($i)
    {
        if ($i > self::$mLength || $i < 1) {
            return false;
        } else {
            $p = $this;
            $j = 1;
            while ($j < $i) {
                $p = $p->mNext;
                $j++;
            }
            $q = $p->mNext;
            $p->mNext = $q->mNext;
            unset($q);
            self::$mLength--;
            return true;
        }
    }

    public function getAllElem()
    {
        $all = array();
        if (!$this->getIsEmpty()) {
            $p = $this->mNext;
            while ($p->mNext) {
                $all[] = $p->mElem;
                $p = $p->mNext;
            }
            if ($p->mElem)
                $all[] = $p->mElem;
            return $all;
        }
    }

    public function getElemUnique()
    {
        if (!$this->getIsEmpty()) {
            $p = $this;
            while ($p->mNext != null) {
                $q = $p->mNext;
                $ptr = $p;
                while ($q->mNext != null) {
                    if (strcmp($p->mElem, $q->mElem) === 0) {
                        $ptr->mNext = $q->mNext;
                        $q->mNext = null;
                        unset($q->mNext);
                        $q = $ptr->mNext;
                        self::$mLength--;
                    } else {
                        $ptr = $q;
                        $q = $q->mNext;
                    }
                }
                //处理最后一个元素
                if (strcmp($p->mElem, $q->mElem) === 0) {
                    $ptr->mNext = null;
                    self::$mLength--;
                }
                $p = $p->mNext;
            }//end of while
        }
    }
}


$node = new SingleLinkedList();
$arr = array('linux', 'nginx', 'mysql', 'php');
$node->getTailCreateSLL($arr);
dump($node->getElemForPos(2));
$pos = $node->getElemPosition('mysql');
dump($pos);
$node->getDeleteElem($pos);
$node->getInsertElem(1, 'js');
dump($node->getAllElem());
