<?php

/**
* micro php Crawler
* 以下代码结构仅供参考，可自由发挥，只要能实现挑战目的就可以。
*/
namespace PHP\Demo;

require __DIR__.'/../bootstrap.php';

class Crawler
{
    private $content;
    private $data;
    static private $mysql;
    function __construct()
    {
        echo "开始爬取内容...<br>";
        self::$mysql = new \PDO("mysql:dbname=shiyanlou_data;host=127.0.0.1","root",'root');
//        self::$mysql = new \mysqli('127.0.0.1','root','root','shiyanlou_data');
    }

    public function loadFile($file_path)
    {
        echo "正在加载文件...<br>";
        $this->content = file_get_contents($file_path);
    }

    public function parseCourseBody()
    {
        //TODO
    }

    public function parseContent()
    {
        echo "开始解析内容...<br>";
        $this->parseTitle();
        $this->parseDesc();
        $this->parseType();
        $this->titleIsLong();
        echo "解析内容结束! <br>";
//        dump($this->content);
        dump($this->data);
    }

    public function saveData()
    {
        echo "存入数据库...";
        //TODO
    }

    public function parseTitle()
    {
        echo "解析课程标题...<br>";
        // <div class="course-name">Django 入门教程</div>
        $pattern = '/\<div class=\"course\-name\"\>(.*)\<\/div\>/';
        preg_match_all($pattern, $this->content,$title );
        $this->data['title'] = $title[1];
    }

    public function parseDesc()
    {
        echo "解析课程简介...<br>";
        // <div class="course-desc">本课程使用的开发环境并结</div>
        $pattern = '/\<div class=\"course\-desc\"\>(.*)\<\/div\>/';
        preg_match_all($pattern, $this->content,$desc );
        $this->data['desc'] = $desc[1];

    }

    public function parseType()
    {
        echo "解析课程类型...<br>";
        // <span class="course-bootcamp pull-right">训练营</span>
        $pattern = '/\<span class=\".* pull\-right\"\>(.*)\<\/span\>/';
        preg_match_all($pattern, $this->content,$type );
        $this->data['type'] = $type[1];

    }

    public function titleIsLong()
    {
        echo "判断课程名是否超长...<br>";
        foreach ($this->data['title'] as $datum) {
            if (mb_strlen($datum) > 16){
                $this->data['nlong'][] = 'true';
            }else{
                $this->data['nlong'][] = 'false';
            }
        }

    }
}

$Crawler = new Crawler();
$Crawler->loadFile('shiyanlou.html');
$Crawler->parseContent();

//CREATE TABLE `course_data` (
//`id` int(11) NOT NULL AUTO_INCREMENT,
//  `cname` varchar(255) DEFAULT NULL,
//  `cdesc` varchar(255) DEFAULT NULL,
//  `ctype` varchar(255) DEFAULT NULL,
//  `nlong` enum('true','false') DEFAULT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;