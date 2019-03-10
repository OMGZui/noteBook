<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/3/10
 * Time: 16:05
 */

namespace Tests;

use PHP\DataStruct\BubbleSort;
use PHP\DataStruct\InsertSort;
use PHP\DataStruct\QuickSort;
use PHP\DataStruct\SelectSort;
use PHP\DataStruct\SortFactory;
use PHPUnit\Framework\TestCase;

class SortTest extends TestCase
{
    protected $except;

    protected function setUp()
    {
        parent::setUp();
        $this->except = range(1, 5);
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->except);
    }

    public function testBubble()
    {
        $arr = $this->except;
        shuffle($arr);
        $sort = SortFactory::getInstance(new BubbleSort());
        $this->assertSame($this->except, $sort->sort($arr));
    }

    public function testQuick()
    {
        $arr = $this->except;
        shuffle($arr);
        $sort = SortFactory::getInstance(new QuickSort());
        $this->assertSame($this->except, $sort->sort($arr));
    }

    public function testInsert()
    {
        $arr = $this->except;
        shuffle($arr);
        $sort = SortFactory::getInstance(new InsertSort());
        $this->assertSame($this->except, $sort->sort($arr));
    }

    public function testSelect()
    {
        $arr = $this->except;
        shuffle($arr);
        $sort = SortFactory::getInstance(new SelectSort());
        $this->assertSame($this->except, $sort->sort($arr));
    }
}