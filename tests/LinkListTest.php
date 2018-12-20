<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/20
 * Time: 15:44
 */

namespace Tests;

use PHP\DataStruct\LinkList;
use PHPUnit\Framework\TestCase;

class LinkListTest extends TestCase
{
    public function testShow()
    {
        $this->expectOutputString('1 2 3 4 5 10 9 8 7 6 ');

        $link = new LinkList([1, 2, 3, 4, 5, 10, 9, 8, 7, 6]);
        $head = $link->head;
        $link->show($head);
    }

    public function testInsert()
    {
        $this->expectOutputString('100 1 2 3 4 5 10 9 8 7 6 ');

        $link = new LinkList([1, 2, 3, 4, 5, 10, 9, 8, 7, 6]);
        $head = $link->head;
        if ($link->insert($head, 1, 100)) {
            $link->show($head);
        }
    }
}