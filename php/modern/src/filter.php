<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/7/29
 * Time: 20:30
 */

namespace PHP\Modern;

$email = 'a.@8@m.com';

$is_email = filter_var($email, FILTER_VALIDATE_EMAIL);

var_dump($is_email);

/*
// 过滤输入
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');
// 生成hash
$password_hash = password_hash($email, PASSWORD_DEFAULT, ['cost' => 12]);
// 验证hash
password_verify($password, $password_hash);
// 刷新hash
password_needs_rehash($password_hash, PASSWORD_DEFAULT, ['cost' => 15]);
*/
