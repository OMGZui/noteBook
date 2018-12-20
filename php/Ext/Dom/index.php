<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/12/4
 * Time: 10:04
 */

namespace PHP\Ext\Dom;

class ExtDom
{
    public function __construct()
    {
        echo "-------------------------------  ExtDom  ---------------------------------\n";
        $this->xml();
        $this->createXmlByDom();
        $this->createXmlBySimple();
        echo "-------------------------------  ExtDom  ---------------------------------\n";
    }

    public function xml()
    {
        echo "-------------------------------  xml  ---------------------------------\n";
        $xml = new \DOMDocument('1.0', 'utf-8');

//        $xml->validateOnParse = true;

        $xml->load(__DIR__ . '/book.xml');

        dump($xml->saveXML());

        $books = $xml->getElementsByTagName('row');
        foreach ($books as $book) {
            dump($book->nodeValue);
        }

        dump($books->item(1)->nodeValue);

//        dump($xml->getElementById('books')->tagName);
    }

    public function createXmlByDom()
    {
        echo "-------------------------------  createXmlByDom  ---------------------------------\n";
        //创建xml文档对象
        $dom = new \DomDocument('1.0','utf-8');
        //创建根元素节点
        $root = $dom->createElement("root");
        //将根元素节点添加到文档对象中
        $dom->appendChild($root);
        //为根元素节点创建属性节点
        $name_attr = $dom->createAttribute('name');
        //创建属性值
        $attr_val = $dom->createTextNode('落花流水');
        //将文本节点添加到属性元素节点上
        $name_attr->appendChild($attr_val);
        //将属性节点添加到根元素节点当中
        $root->appendChild($name_attr);
        //创建文本节点
        $text = $dom->createTextNode("你无情");
        //将文本节点添加到父元素节点上
        $root->appendChild($text);
        //保存显示
        dump($dom->saveXML());
    }

    public function createXmlBySimple()
    {
        echo "-------------------------------  createXmlBySimple  ---------------------------------\n";
        $xml = <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<person>
</person>
EOT;

        //创建一个新的SimpleXMLElement对象 其中$xml参数可是字符串也可以是url
        $xml = new \SimpleXMLElement($xml);
        //通过addChild函数向指定节点中添加一个子节点,返回一个子节点的对象
        $name = $xml->addChild('name', '落花流水');
        //向name节点中添加属性节点
        $name->addAttribute('type', 'aa');
        //再次向父节点中添加子节点
        $xml->addChild('age', 24);
        //向父节点中添加性别节点
        $sex = $xml->addChild('sex', '男');
        //在性别节点中设置属性
        $sex->addAttribute('att', 'img');

        //获取元素的值和元素的名称
        foreach ($xml->children() as $child) {
            dump($child->getName());
        }
    }
}
