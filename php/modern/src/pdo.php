<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/7/29
 * Time: 20:53
 */
include 'config.php';
try {
//    $pdo = new \PDO(
//        'mysql:host=149.28.205.238;dbname=pdo;port=3306;charset=utf8',
//        'root',
//        'xxx'
//    );
    $pdo = new \PDO(
        sprintf(
            'mysql:host=%s;dbname=%s;port=%d;charset=%s',
            $sql['host'],
            $sql['db_name'],
            $sql['port'],
            $sql['charset']
        ),
        $sql['username'],
        $sql['password']
    );
    $db = $pdo->query('select version()');
    var_dump($row = $db->fetch()[0]);
} catch (\PDOException $e) {
    echo "connect failed";
    exit();
}