<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/20
 * Time: 16:29
 */

namespace Tests\PredefinedInterfaces;

use PHP\Demo\PredefinedInterfaces\MyIterator;
use PHPUnit\Framework\TestCase;

class IteratorTest extends TestCase
{
    public function testIterator()
    {
        // 迭代器接口其实实现的原理就是类似指针的移动
        // 迭代顺序 rewind()->valid()->key()->current()->next()->valid()->key()->current()->next()
        $iterator = new MyIterator();
        $this->assertInstanceOf(\Traversable::class, $iterator);

        $iterator->add(1);
        $iterator->add(2);
        $iterator->add(3);

        $exceptArr = [];
        foreach ($iterator as $item) {
            $exceptArr[] = $item;
        }

        $this->assertSame(
            [1, 2, 3],
            $exceptArr
        );

        $exceptArr2 = [];
        $iterator->rewind();
        while ($iterator->valid()) {
            $exceptArr2[] = $iterator->current();
            $iterator->next();
        }

        $this->assertSame(
            [1, 2, 3],
            $exceptArr2
        );

    }
}