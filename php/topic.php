<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/11/9
 * Time: 21:53
 */

//- 1、mysql事务的并行，锁问题
//- 2、mysql论坛表设计
//- 3、设计模式运用
//- 4、php代码解释
//- 5、百度统计的实现原理

// 注册百度统计，拿到id，并赋值一段js代码嵌入到需要统计的网站内
// 发送一个类似http://hm.baidu.com/hm.gif?cc=1&ck=1&cl=32-bit&ds=1366×768&ep=0&et=0&fl=11.0&ja=1&ln=zh-cn 的请求给百度服务器
// 百度统计服务端，通过接收到这个请求，并从这个图片的网址附带的参数获取相关信息，记录访客访问记录；当页面被用户关闭的时候，同样会触发一次请求hm.gif的过程，但这个过程不是所有浏览器和所有关闭动作都支持。
// 百度统计是基于cookie的，当请求js脚本的时候，会在你电脑里保存一个永久cookie，该cookie作为你的用户标识
// http://blog.csdn.net/iqzq123/article/details/8877645

//- 6、自己最满意的代码
//- 7、共享session，丢失怎么办

// 可以将session数据保存在memcached，redis之类内存数据库中，memcached是基于内存存储数据的，性能很高，用户并发量很大的时候尤其合适。
// 主要是利用内存的数据读取速度是很快的，与磁盘读取的速度不是一个数量级的。
// 使用内存存储：方便统计 在线人数，内存的速度比磁盘访问快、内存数据库系统能够控制内存中的过期数据自动失效(刚好符合session过期需要)。
// 存储在redis比较理想的选择，存储在数据库中方便存储统计在线人数，那么存储在redis中也实现了这个要求。
// 也可以存储在memcache中。但redis支持的数据类型多。所以用它好点。
// http://www.cnblogs.com/wangtao_20/p/3395518.html#commentform
// 丢失可以集群redis（个人理解）

//- 8、git流程（master需要上一个bug_fix分支）

// git rebase

//- 9、app和pc端的处理不同？

// 有不同吗？

//- 10、restful设计