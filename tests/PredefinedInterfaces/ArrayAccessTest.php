<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/20
 * Time: 16:29
 */

namespace Tests\PredefinedInterfaces;

use PHP\Demo\PredefinedInterfaces\MyArrayAccess;
use PHPUnit\Framework\TestCase;

class ArrayAccessTest extends TestCase
{
    public function testArrayAccess()
    {
        $obj = new MyArrayAccess();
        $obj->add(['one' => 1]);
        $obj->add(['two' => 2]);
        $obj->add(['three' => 3]);

        $this->assertTrue(isset($obj['two']));
        $this->assertEquals(2, $obj['two']);

        $obj['four'] = 4;
        $this->assertTrue(isset($obj['four']));
        $this->assertEquals(4, $obj['four']);

        unset($obj['four']);
        $this->assertFalse(isset($obj['four']));

    }
}