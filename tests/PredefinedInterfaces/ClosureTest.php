<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/25
 * Time: 16:53
 */

namespace Tests;

use PHP\Demo\Closure\ClosureBind;
use PHP\Demo\Closure\ClosureBindTo;
use PHPUnit\Framework\TestCase;

class ClosureTest extends TestCase
{
    public function testClosureBindTo()
    {
        $obj = new ClosureBindTo();
        $this->assertEquals(2, $obj->add(function (array $params) {
            return ++$params[0];
        }, [1]));
    }

    public function testClosureBind()
    {
        $obj = new ClosureBind();
        $obj->addMethod('add', function (array $params) {
            return ++$params[0];
        });
        $this->assertEquals(2, $obj->add([1]));
    }

}
