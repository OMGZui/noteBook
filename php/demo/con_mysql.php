<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/11/8
 * Time: 15:07
 */

namespace PHP\Demo;

require __DIR__.'/../bootstrap.php';

/**
 *
 *
 * Class Con
 * @package PHP
 */
class Con
{
    private $host = "104.223.3.138";
    private $db = "demo";
    private $user_name = "shengj";
    private $password = "Root666,.";
    private $conn;
    private $add_sql = "insert into user (account,password) values ('abc360','1234560')";
    private $select_sql = "select * from user";
    private $pdo;
    private $dsn;


    public function __construct()
    {
        $this->dsn = "mysql:dbname=$this->db;host=$this->host";

        $this->conn = new \mysqli($this->host,$this->user_name,$this->password,$this->db);
        if ($this->conn->connect_error){
            die('Fail'.$this->conn->connect_error);
        }

        try{
            $this->pdo  = new \PDO($this->dsn,$this->user_name,$this->password);
        }catch (\PDOException $e){
            dump('Fail'.$e->getMessage());
        }
    }

    function addMysqli()
    {
        return $this->conn->query($this->add_sql);
    }

    function selectMysqli()
    {
        $this->conn->set_charset('utf8');
        $rows = $this->conn->query($this->select_sql);
        $rs = [];
        while($row = $rows->fetch_assoc()){
            $rs[] = $row;
        }
        return $rs;
    }

    function closeMysqli()
    {
        return $this->conn->close();
    }

    function addPdo()
    {
        return $this->pdo->exec($this->add_sql);
    }

    function selectPdo()
    {
        $rows = [];
        foreach ($this->pdo->query($this->select_sql,\PDO::FETCH_ASSOC) as $row) {
            $rows[] = $row;
        }
        return $rows;
    }

    function closePdo()
    {
        unset($this->pdo);
    }
}

$db = new Con();

//dump($db->selectMysqli());
//$db->addMysqli();
//dump($db->selectMysqli());
//$db->closeMysqli();

dump($db->selectPdo());
$db->addPdo();
dump($db->selectPdo());
$db->closePdo();
