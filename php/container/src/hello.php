<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/12/9
 * Time: 12:32
 */

namespace Shengj\Container;

class Hello implements HelloInterface
{
    public function __construct()
    {

    }

    public function echo()
    {
        return 'echo';
    }

    public function hello()
    {
        return 'hello';
    }

}