<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/7/29
 * Time: 20:53
 */
include 'config.php';
try {
    // 原生
//    $pdo = new \PDO(
//        'mysql:host=149.28.205.238;dbname=pdo;port=3306;charset=utf8',
//        'root',
//        'xxx'
//    );
    // 原生加配置文件
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
    // 原生sql
//    $db = $pdo->query('select version()');
//    var_dump($row = $db->fetch()[0]);

    // 预处理
    $s = "select * from user where name = :name";
    $db = $pdo->prepare($s);
    $name = 'omgzui';
    $db->bindValue(':name', $name, PDO::PARAM_STR);
    $db->execute();
    // PDO::FETCH_ASSOC 关联数组
    // PDO::FETCH_OBJ 关联对象
    while (($row = $db->fetch(PDO::FETCH_ASSOC))) {
        echo $row['id'] . ' => ' . $row['name'] . PHP_EOL;
    }

//    // 事务
//    $pdo->beginTransaction();
//    // balabala
//    $pdo->commit();
} catch (\PDOException $e) {
    echo $e->getMessage();
    exit();
}