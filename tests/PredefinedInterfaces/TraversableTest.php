<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/20
 * Time: 16:29
 */

namespace Tests\PredefinedInterfaces;

use PHP\Demo\PredefinedInterfaces\MyTraversable;
use PHPUnit\Framework\TestCase;

class TraversableTest extends TestCase
{
    public function testTraversable()
    {
        // \Traversable::class不能直接implement，它只是可以检测类能否遍历
        $this->assertInstanceOf(\Traversable::class, new MyTraversable());
    }
}