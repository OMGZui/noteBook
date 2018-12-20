<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/11/8
 * Time: 15:07
 */

namespace PHP\Demo\Old;

require __DIR__ . '/../../bootstrap.php';

class Con
{
    private $host = "localhost";
    private $db = "mac";
    private $user_name = "root";
    private $password = "root";
    private $port = 3306;
    /**
     * @var \PDO
     */
    private $conn;
    private $add_sql = "insert into `user` (name,password) values ('abc360','123456'),('abc366','123456') ";
    private $select_sql = "select * from `user`";
    private $pdo;
    private $dsn;

    public function __construct()
    {
        $this->dsn = "mysql:dbname={$this->db};host={$this->host};port={$this->port}";

//        $this->conn = new \mysqli($this->host, $this->user_name, $this->password, $this->db, $this->port);
//        if ($this->conn->connect_error) {
//            die('Fail' . $this->conn->connect_error);
//        }

        $this->pdo = new \PDO($this->dsn, $this->user_name, $this->password);
    }

    function addMysqli()
    {
        return $this->conn->query($this->add_sql);
    }

//    function selectMysqli()
//    {
//        $this->conn->set_charset('utf8');
//        $rows = $this->conn->query($this->select_sql);
//        $rs = [];
//        while ($row = $rows->fetch_assoc()) {
//            $rs[] = $row;
//        }
//        return $rs;
//    }
//
//    function closeMysqli()
//    {
//        return $this->conn->close();
//    }

    function addPdo()
    {
        return $this->pdo->exec($this->add_sql);
    }

    function selectPdo()
    {
        $rows = [];
        foreach ($this->pdo->query($this->select_sql, \PDO::FETCH_ASSOC) as $row) {
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

dump($db->selectPdo());
//$db->addPdo();
//dump($db->selectPdo());
$db->closePdo();
