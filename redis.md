# redis笔记

前言：redis是什么，是一种非关系型数据库，统称nosql。
<!-- TOC -->

- [redis笔记](#redis笔记)
    - [一、redis与memcached比较：](#一redis与memcached比较)
    - [二、安装](#二安装)
    - [三、配置](#三配置)
    - [四、通用key操作](#四通用key操作)
    - [五、redis中的5中数据结构](#五redis中的5中数据结构)
        - [1. 字符串（string）](#1-字符串string)
        - [2. 列表（list）链表支持 有序 可重复](#2-列表list链表支持-有序-可重复)
        - [3. 集合（set）无序 不可重复](#3-集合set无序-不可重复)
        - [4. 哈希（hash）键值对  key => value](#4-哈希hash键值对--key--value)
        - [5. 有序集合（zset）键值对  成员 => 分值 成员必须唯一](#5-有序集合zset键值对--成员--分值-成员必须唯一)

<!-- /TOC -->
## 一、redis与memcached比较：

1. redis受益于“持久化”可以做存储(storge)，memcached只能做缓存(cache)
2. redis有多种数据结构，memcached只有一种类型“字符串(string)”

## 二、安装

安装最新稳定版

```sh
# 源码安装redis-4.0
# 下载
wget http://download.redis.io/releases/redis-4.0.1.tar.gz
# 解压
tar zxvf redis-4.0.1.tar.gz
cd redis-4.0.1
# 编译
make && make test && make install
错误：You need tcl 8.5 or newer in order to run the Redis test
解决：yum -y install tcl
cd utils
# 赋予运行权限
chmod +x install_server.sh
# 运行脚本
./install_server.sh
# 配置
Port           : 6379
Config file    : /etc/redis/redis.conf
Log file       : /var/log/redis.log
Data dir       : /var/lib/redis/redis
Executable     : /usr/local/bin/redis-server
Cli Executable : /usr/local/bin/redis-cli
# 自启动
chkconfig redis_6379 on
vim /etc/redis/redis.conf
requirepass Root666,./
service redis_6379 restart
```

## 三、配置

```sh
redis-benchmark     redis性能测试工具
redis-check-aof     检查aof日志的工具
redis-check-rdb     检查rdb日志的工具
redis-cli           连接用的客户端
redis-server        服务进程

# 配置文件启动 这样会霸占终端
/usr/local/bin/redis-server /etc/redis/redis.conf
# 修改为不霸占终端
vim /etc/redis/redis.conf
daemonize no  => yes

# redis 默认有16个数据库，默认使用0号数据库，可使用select、move等命令操作
databases 16
```

## 四、通用key操作

1. keys 查询

```sh
在redis里,允许模糊查询key
有3个通配符 * ? []
*: 通配任意多个字符
?: 通配单个字符
[]: 通配括号内的某1个字符

```

2. del 删除
3. rename 重命名
4. move 移到另外一个库
5. randomkey 随机
6. exists 存在
7. type 类型
8. ttl 剩余生命周期
9. expire 设置生命周期
10. persist 永久有效
11. flushdb 清空

## 五、redis中的5中数据结构

### 1. 字符串（string）

* set
    * set name shengj -> OK
* get
    * get name -> "shengj"
* del
    * del name -> (integer) 1
    * get name -> (nil)
* mset
    * mset name shengj age 23 sex male -> OK
* mget
    * mget age sex
    ```sh
    1) "23"
    2) "male"
    ```
* setrange
    * setrange sex 2 1 将sex的第3个字符改成1  -> (integer) 4
    * get sex -> "ma1e"
* append
    * append name GG -> (integer) 8
    * get name -> "shengjGG"
* getrange
    * getrange name 1 2 -> "he"
* incr 自增
* incrby 自增一个量级
* incrbyfloat 自增一个浮点数
* decr 递减
* decrby 递减一个量级
* decrbyfloat 递减一个浮点数
* setbit 设置二进制位数
* getbit 获取二进制表示
* bitop 位操作

---

### 2. 列表（list）链表支持 有序 可重复

* rpush 右边插入
    * rpush list item1 -> (integer) 1
    * rpush list item2 -> (integer) 2
    * rpush list item3 -> (integer) 3
* lrange 列出链表值
    * lrange list 0 -1
    ```sh
    1) "item1"
    2) "item2"
    3) "item3"
    ```
* lindex
    * lindex list 1 -> "item2"
* lpop
    * lpop list -> "item1"
    * lrange list 0 -1
    ```sh
    1) "item2"
    2) "item3"
    ```
* ltrim
    * ltrim list 3 0 -> OK
    * lrange list 0 -1 -> (empty list or set)
* lpush 左边插入
* rpop 右边删除
* lrem

---

### 3. 集合（set）无序 不可重复

* sadd 增加
    * sadd set item1 -> (integer) 1
    * sadd set item2 -> (integer) 1
    * sadd set item3 -> (integer) 1
    * sadd set item1 -> (integer) 0  已存在
* smembers 所有集合元素
    * smembers set
    ```sh
    1) "item3"
    2) "item2"
    3) "item1"
    ```
* sismember 存不存在
    * sismember set item1 -> (integer) 1
    * sismember set item -> (integer) 0 不存在
* srem 移除元素
    * srem set item1 -> (integer) 1
    * smembers set
    ```sh
    1) "item3"
    2) "item2"
    ```
* spop 随机删除一个元素
* srandmember 随机获取一个元素 -> 抽奖
* scard 多少个元素
* smove 移动
* sinter 交集
* sinterstore 交集并赋值
* suion 并集
* sdiff 差集
---

### 4. 哈希（hash）键值对  key => value

* hset 设置一个
    * hset hash key1 value1 -> (integer) 1
    * hset hash key2 value2 -> (integer) 1
    * hset hash key3 value3 -> (integer) 1
    * hset hash key1 value1 -> (integer) 0 已存在
* hgetall 获取全部
    * hgetall hash
    ```sh
    1) "key1"
    2) "value1"
    3) "key2"
    4) "value2"
    5) "key3"
    6) "value3"
    ```
* hget 获取一个
    * hget hash key1 -> "value1"
* hdel 删除
    * hdel hash key1 -> (integer) 1
    * hgetall hash
    ```sh
    1) "key2"
    2) "value2"
    3) "key3"
    4) "value3"
    ```
* hmset 设置多个
* hmget 获取多个
* hlen 个数
* hexists 是否存在增长
* hinrby 
---

### 5. 有序集合（zset）键值对  成员 => 分值 成员必须唯一

* zadd 增加
    * zadd zset 100 item1 -> (integer) 1
    * zadd zset 200 item2 -> (integer) 1
    * zadd zset 300 item3 -> (integer) 1
    * zadd zset 100 item1 -> (integer) 0 已存在
* zrange 按分值排序
    * zrange zset 0 -1 withscores
    ```sh
    1) "item1"
    2) "100"
    3) "item2"
    4) "200"
    5) "item3"
    6) "300"
    ```
* zrangebyscore 按分值的一部分排序
    * zrangebyscore zset 0 200 withscores
    ```sh
    1) "item1"
    2) "100"
    3) "item2"
    4) "200"
    ```
* zrem 删除
    * zrem zset item1 -> (integer) 1
    * zrange zset 0 -1 withscores
    ```sh
    1) "item2"
    2) "200"
    3) "item3"
    4) "300"
    ```
* zrank 排名升序
* zremrangebyscore 按分值删除一部分
* zremrangebyrank 按排名删除一部分
* zcard 个数