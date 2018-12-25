<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/12/25
 * Time: 16:29
 */

require __DIR__ . '/../../bootstrap.php';

// ?= 前置约束 存在
preg_match('/(T|t)he(?=\sfat)/', "The fat cat sat on the mat.", $rs);
dump($rs[0]); // "The"

// ?! 前置约束 排除
preg_match('/(T|t)he(?!\sfat)/', "The fat cat sat on the mat.", $rs);
dump($rs[0]); // "the"

// ?<= 后置约束 存在
preg_match_all('/(?<=(T|t)he\s)(fat|mat)/', "The fat cat sat on the mat.", $rs);
dump($rs[0]); // ["fat", "mat"]

// ?<= 后置约束 排除
preg_match_all('/(?<!(T|t)he\s)(cat)/', "The cat sat on cat.", $rs);
dump($rs[0]); // ["cat"]

// 贪婪
preg_match('/(.*at)/', "The fat cat sat on the mat.", $rs);
dump($rs[0]); // "The fat cat sat on the mat"

// 惰性
preg_match('/(.*?at)/', "The fat cat sat on the mat.", $rs);
dump($rs[0]); // "The fat"
