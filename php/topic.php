<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/11/9
 * Time: 21:53
 */

namespace PHP;

require '../vendor/autoload.php';

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


$str_p = '<p>啊实打实大苏打撒打算<img alt="docile.png" src="http://zmall.oss-cn-hangzhou.aliyuncs.com/fangde_sql%2F2017%2F11%2F15%2F143939docile.png" width="300" height="300"></p>';
$str_a = '<li>
<a href="www.baidu.com">拜服</a>
<a href="www.baidu.com">拜服</a>
</li>';
//$preg = '/<img.*\">/';
//$preg = '/alt=\"(\S*)\"/i';
$preg_p = '/src=\"(\S*)\"/i';

//$preg_a = '/\<li\>(\<a(.|\n)*>((.|\n)*)\<\/a\>)\<\/li\>/';
$preg_a = '/\<li\>[.\n]*(\<a.*>(.*)\<\/a\>\\n*)\<\/li\>/';
//$preg_a = '/\<li\>(.|\n)*\<\/li\>/';
preg_match($preg_a,$str_a,$match_a);
preg_match($preg_p,$str_p,$match_p);
//dump($match_a);
//dump($match_p);


$url = 'www.baidu.com';
$url = 'http://'.$url;

$html = file_get_contents($url);
preg_match('/\<title\>(.*)\<\/title\>/',$html,$icon_title);
$icon = $url.'/favicon.ico';
dump($icon_title[1]);
dump($icon);

