<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/3/10
 * Time: 15:48
 */

namespace PHP\DataStruct;

Class SortFactory
{
    /**
     * @var SortInterface
     */
    protected static $instance;

    public static function getInstance(SortInterface $sort)
    {
        if (is_null(static::$instance)) {
            static::$instance = $sort;
        }

        return static::$instance;
    }
}