<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/11/9
 * Time: 21:53
 */

namespace PHP\Demo;

require __DIR__.'/../bootstrap.php';

// 单例和工厂一起

class Factory
{
     static function createInstance()
     {
         return DB::getInstance();
     }
}


class DB
{
    private static $db;

    final private function __construct(){}

    final private function __clone(){}

    public static function getInstance()
    {
        if (!self::$db){
            self::$db = new self();
        }
        return self::$db;
    }
}

Factory::createInstance();


