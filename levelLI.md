# 老李21问

## 1、PHP的垃圾回收机制以及大概实现

使用的是`引用计数`

PHP底层数据结构`zval`中有个字节`refcount`，用以表示指向这个zval的变量个数，初始化是1，当php文件执行结束或使用`unset()`函数，`refcount`变为0时就会自动被系统销毁，实现垃圾回收

## 2、PHP7比PHP5节省资源（内存占用），大概是如何实现的

PHP7优化了底层的数据结构和对Zend引擎的优化

## 3、PHP是弱语言类型，那么PHP中是如何实现类型转换的

PHP的底层有个联合体`_zend_value`表示变量的类型，程序运行期间会根据自己的类型选择使用不同的成员

## 4、一个APP或者网页从发起并完成一个完整的HTTP流程大概是怎样的

url->DNS域名解析->IP地址映射->TCP3次握手->HTTP请求->服务器处理http请求并返回http报文->浏览器渲染->结束

## 5、MYSQL的innodb引擎和MYISAM引擎有何不同，说出主要不同点

- innodb支持行锁、事务、外键，而myisam只支持表锁
- innodb是聚簇索引，myisam是非聚簇索引

## 6、MYSQL的innodb引擎中，聚簇索引和二级索引有什么不同，如何可以，请详细画出两种索引实现的数据结构以及不同

二级索引的叶子节点存的是主键值，而不是行指针

## 7、MYSQL的事务有几种隔离级别，分别是为了解决什么问题而出现

<https://tech.meituan.com/2014/08/20/innodb-lock.html>

4中隔离级别：

- 未提交读
- 提交读，不可重复读 RC 其它数据库默认
- 可重复读 RR mysql默认
- 可串行化

主要是RC和RR，RC解决了脏读，是一个事务只能看到自己的修改，其它事务是看不到的，RR解决了不可重复读，同一个事务中多次读取同样的记录的结果是一样的。

## 8、MYSQL的锁是怎么回事，和事务之间有什么千丝万缕的联系

数据库事务有不同的隔离级别，不同的隔离级别对锁的使用是不同的，锁的应用最终导致不同事务的隔离级别。

悲观锁：正如其名，它指的是对数据被外界（包括本系统当前的其他事务，以及来自外部系统的事务处理）修改持保守态度，因此，在整个数据处理过程中，将数据处于锁定状态。

乐观锁：大多是基于数据版本（ Version ）记录机制实现【MVCC】

<https://tech.meituan.com/2014/08/20/innodb-lock.html>

## 9、REDIS中常见的数据结构有几种？REIDS数据持久化有几种方案

- string 字符串
- list 列表
- set 集合
- zset 有序集合
- hash 哈希

持久化有：

- rdb 保存数据库中的键值对 rdb恢复更快，因为aof执行命令时间长
- aof 保存服务器所执行的命令 优先aof

## 10、简述一下REDIS中，字符串、set、zset、list以及hash底层是如何实现的

## 11、REDIS中key的过期有几种策略，然后redis中key的过期是如何实现的

expire key time(以秒为单位)–这是最常用的方式

setex(String key, int seconds, String value)–字符串独有的方式

三种过期策略：

- 定时删除 设置一个定时器，到了时间自动删除
- 懒汉式式删除 获取key时进行删除
- 定期删除 每隔一段时间进行key删除

## 12、你对微服务了解多少，如果你的经历中有这些信息，结合你的经历说说你们微服务是怎么做的

## 13、RPC了解多少，如果你经历过，结合你的经历说下你们RPC是通过什么协议实现的？消息格式是怎样的？采用哪种序列化方式

RPC：远程过程调用协议，且不依赖于具体的网络传输协议，比如restful需要依赖http协议

<https://www.zybuluo.com/phper/note/76641>

## 14、TCP协议握手的过程

三次握手，四次挥手

- Client发送SYN给Server
- Server返回SYN/ACK给Client
- Client返回ACK给Server

涉及到FIN_WAIT，CLOSE_WAIT

- Client发送FIN给Server
- Server收到FIN后返回ACK给Client
- Server发送FIN给Client
- Client收到FIN后发送ACK给Server

## 15、PHP异常你是如何使用的，简单说说

- 网络请求接口
- 耗时的计算
- 数据库连接

通过捕捉异常避免系统崩溃，同时输出错误信息到日志有助于排查

## 16、SWOOLE的进程模型是什么样的？和LNMP有什么不同

![swoole](./public/img/process.jpg)

如图所知swoole的进程模型是一个Master进程和Manager进程组成

Master进程是一个多线程进程，其中有一组非常重要的线程，叫做Reactor线程（组）

Manager进程，某种意义上可以看做一个代理层，它本身并不直接处理业务，其主要工作是将Master进程中收到的数据转交给Worker进程，或者将Worker进程中希望发给客户端的数据转交给Master进程进行发送。

Manager进程还负责监控Worker进程，如果Worker进程因为某些意外挂了，Manager进程会重新拉起新的Worker进程，有点像Supervisor的工作。而这个特性，也是最终实现热重载的核心机制。

Worker进程其实就是处理各种业务工作的进程，Manager将数据包转交给Worker进程，然后Worker进程进行具体的处理，并根据实际情况将结果反馈给客户端。

当客户端连接的时候这个过程中，三种进程之间是怎么协作的：

Client主动Connect的时候

1. Client实际上是与Master进程中的某个Reactor线程发生了连接。
2. 当TCP的三次握手成功了以后，由这个Reactor线程将连接成功的消息告诉Manager进程，再由Manager进程转交给Worker进程。
3. 在这个Worker进程中触发了OnConnect的方法。
  
当Client向Server发送了一个数据包的时候

1. 首先收到数据包的是Reactor线程，同时Reactor线程会完成组包，再将组好的包交给Manager进程，由Manager进程转交给Worker。
2. 此时Worker进程触发OnReceive事件。
3. 如果在Worker进程中做了什么处理，然后再用Send方法将数据发回给客户端时，数据则会沿着这个路径逆流而上。

https://www.158code.com/article/165

LNMP：主要是nginx与php-fpm的通信

nginx作为一个代理服务器，通过fastcgi协议与php-fpm进行通信

## 17、同步、异步、阻塞、非阻塞和IO多路复用是怎么回事，常见的服务器进程（线程）模型有哪些

对于一个network IO (这里我们以read举例)，它会涉及到两个系统对象，一个是调用这个IO的process (or thread)，另一个就是系统内核(kernel)。当一个read操作发生时，它会经历两个阶段：

1. 等待数据准备 (Waiting for the data to be ready)
2. 将数据从内核拷贝到进程中 (Copying the data from the kernel to the process)

同步（synchronous）：一次只能做一件事
异步（asynchronous）：可以同时做多件事
阻塞（blocking）：两个阶段都被block
非阻塞（non-blocking）：两个阶段都没被block
IO多路复用（IO multiplexing）：select，epoll

https://blog.csdn.net/historyasamirror/article/details/5778378

## 18、计算机基础中常见的基础数据结构和基础算法

- 链表
- 栈
- 队列
- 树
- 图
- 哈希表

- 排序
- 查找

## 19、哈希一致性算法是怎么回事？同时说下redis集群有什么认识吗

一致性Hash算法是对2^32取模，形成一个哈希环

一致性Hash算法对于节点的增减都只需重定位环空间中的一小部分数据，具有较好的容错性和可扩展性。

https://zhuanlan.zhihu.com/p/34985026
