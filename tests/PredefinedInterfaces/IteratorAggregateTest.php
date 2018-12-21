<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/20
 * Time: 16:29
 */

namespace Tests\PredefinedInterfaces;

use PHP\Demo\PredefinedInterfaces\MyIteratorAggregate;
use PHPUnit\Framework\TestCase;

class IteratorAggregateTest extends TestCase
{
    public function testIteratorAggregate()
    {
        // 相比迭代器，聚合式迭代器已经实现了迭代，同时可以对类的属性进行迭代
        $aggregate = new MyIteratorAggregate();

        $testKey = [];
        $testValue = [];

        foreach ($aggregate as $key => $value) {
            $testKey[] = $key;
            $testValue[] = $value;
        }

        $this->assertInstanceOf(\Traversable::class, $aggregate);

        $this->assertSame(
            ['property1', 'property2', 'property3', 'property4'],
            $testKey
        );

        $this->assertSame(
            ['one', 'two', 'three', 'four'],
            $testValue
        );

        $testKey = [];
        $testValue = [];

        // 可见直接迭代类本身和迭代getIterator()是一样的
        foreach ($aggregate->getIterator() as $key => $value) {
            $testKey[] = $key;
            $testValue[] = $value;
        }

        $this->assertInstanceOf(\Traversable::class, $aggregate);

        $this->assertSame(
            ['property1', 'property2', 'property3', 'property4'],
            $testKey
        );

        $this->assertSame(
            ['one', 'two', 'three', 'four'],
            $testValue
        );
    }
}