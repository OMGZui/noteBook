# mysql

<!-- TOC -->

- [mysql](#mysql)
    - [一、mysql是什么](#一mysql是什么)
    - [二、mysql安装](#二mysql安装)
        - [1、yum安装](#1yum安装)
        - [2、源码安装](#2源码安装)
    - [三、mysql使用](#三mysql使用)
        - [1、数据库](#1数据库)
        - [2、数据表](#2数据表)
        - [3、数据库CURD操作](#3数据库curd操作)
    - [四、mysql视图](#四mysql视图)
    - [五、mysql索引](#五mysql索引)
    - [六、mysql事务](#六mysql事务)
        - [1、原子性](#1原子性)
        - [2、一致性](#2一致性)
        - [3、隔离性](#3隔离性)
        - [4、持久性](#4持久性)
        - [5、锁](#5锁)
        - [6、总结](#6总结)
    - [七、存储过程](#七存储过程)
        - [栗子1：参数的种类分3种，分别是IN、OUT、INOUT，其中IN为输入参数类型，OUT为输出参数类型，而INOUT既是输入类型又是输出类型，下面我们创建一个存储过程，以达到对user表的用户名称进行模糊查询的目的，存储过程名称为sp_search_user](#栗子1参数的种类分3种分别是inoutinout其中in为输入参数类型out为输出参数类型而inout既是输入类型又是输出类型下面我们创建一个存储过程以达到对user表的用户名称进行模糊查询的目的存储过程名称为sp_search_user)
        - [栗子2：关键字OUT则是指明相应参数用来从存储过程传出的一个值,也可以理解为存储过程的返回值，而对于INOUT则是两者结合体。现在我们创建一个存储过程，用于返回商品的最大值、最小值和平均值，命名为sp_item_price](#栗子2关键字out则是指明相应参数用来从存储过程传出的一个值也可以理解为存储过程的返回值而对于inout则是两者结合体现在我们创建一个存储过程用于返回商品的最大值最小值和平均值命名为sp_item_price)
    - [八、触发器](#八触发器)
    - [九、游标](#九游标)
    - [十、mysql优化](#十mysql优化)
        - [1、编码](#1编码)
        - [2、多列索引规则](#2多列索引规则)
        - [3、myisam和innodb索引区别](#3myisam和innodb索引区别)
        - [4、索引选择](#4索引选择)
        - [5、分页优化](#5分页优化)
        - [6、索引与排序](#6索引与排序)
    - [十、docker实现mysql主从复制](#十docker实现mysql主从复制)
    - [十一、参考资料](#十一参考资料)

<!-- /TOC -->

## 一、mysql是什么

MySQL（官方发音为/maɪ ˌɛskjuːˈɛl/“My S-Q-L”，但也经常读作/maɪ ˈsiːkwəl/“My Sequel”）原本是一个开放源代码的关系数据库管理系统，原开发者为瑞典的MySQL AB公司，该公司于2008年被昇阳微系统（Sun Microsystems）收购。2009年，甲骨文公司（Oracle）收购昇阳微系统公司，MySQL成为Oracle旗下产品。

## 二、mysql安装

### 1、yum安装

```sh

# 检测已安装的mysql
yum list installed | grep mysql

# 移除已安装的mysql
yum -y remove mysql-libs.x86_64

# 下载mysql5.7的rpm包
wget https://dev.mysql.com/get/mysql57-community-release-el6-11.noarch.rpm

# yum本地安装源
yum localinstall mysql57-community-release-el6-11.noarch.rpm

# 检测允许安装的mysql插件
yum repolist enabled | grep mysql
yum search mysql-community

# 安装mysql
yum -y install mysql-community-server.x86_64

# 启动mysql
service mysqld start

# 自启动
chkconfig mysqld on

# 初始密码
-> 2lNu<K?kk;6%
grep 'temporary password' /var/log/mysqld.log

# 进入数据库
mysql -u root -p 2lNu<K?kk;6%

# 修改密码
ALTER USER 'root'@'localhost' IDENTIFIED BY 'Root666,.';

# 远程登录密码
GRANT ALL ON *.* to root@'%' IDENTIFIED BY 'Root666,.';
GRANT ALL ON *.* to shengj@'%' IDENTIFIED BY 'Root666,.';

# 远程登录
mysql -h 104.223.3.138  -u root  -p Root666,.
```

### 2、源码安装

## 三、mysql使用

数据库：demo

数据表：user

字段：id int(11) | account varchar(255) | password varchar(255)

数据表：user_info

字段：id int(11) | uid int(11) | name varchar(255) | wx varchar(255)

### 1、数据库

```sql

# 创建数据库
create database `demo`;

# 查看所有数据库
show databases;

# 查看某个数据库
show create database `demo`;

# 修改数据库编码
alter database `demo` default character set utf8 collate utf8_unicode_ci;

# 删除数据库
drop database `demo`;
```

### 2、数据表

```sql

# 选择使用哪个数据库
use `demo`;

# 创建user表
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# 查看表字段名
desc `user`;

# 修改表名
alter table `user` rename to `users`;

# 修改字段名
alter table `user` change `account` `name` varchar(255) NOT NULL;

# 修改字段数据类型
alter table `user` modify `password` varchar(500) NOT NULL;

# 添加字段
alter table `user` add `uid` varchar(50) NOT NULL after `id`;

# 删除字段
alter table `user` drop `uid`;

# 修改字段位置
alter table `user` modify `password` varchar(500) first;
注：字段类型必须带上
alter table `user` modify `password` varchar(500) NOT NULL after `account`;

# 删除数据表
drop table `user`;
```

### 3、数据库CURD操作

```bash

# 添加数据
【单条数据】insert into `user` (account,password) values ('shengj','123456');
【批量】insert into `user` (account,password) values ('shengj','123456'),('wangm','123456');

# 更新数据
【单条数据】update `user` set password='123456789' where id=1;
【批量】update `user` set password='123456789' where id>1;

# 删除数据
【单条数据】delete from `user` where id=1;
【批量】delete from `user` where id>1;

# 查询
查询全部
select * from `user`;

查询某个字段
select `account` from `user`;

where条件查询
select * from `user` where id=1;

in/not in 关键字查询
select * from `user` where id in (1,2);
select * from `user` where id not in (1,2);

between and 关键字查询
select * from `user` where id between 1 and 3;

空值(null)查询，使用is null来判断
alter table `user` add `age` varchar(10) default null;
select * from `user` where age is null;

distinct(去重)关键字查询
select distinct(account) from `user`;

like关键字查询
select * from `user` where `account` like "%en%";

and关键字多条件查询,or关键字的使用也是类似
select * from `user` where `account`='shengj' and `id`>1;
select * from `user` where `account`='shengj' or  `account`='cenh';

# 聚合函数
count()函数 -> 记录总条数
sum()函数 -> 某个字段的总和
avg()函数 -> 字段的平均数
max()函数 -> 字段的最大值
min()函数 -> 字段的最小值

排序 order by
select * from `user` order by `id` desc; // 倒序
select * from `user` order by `id` asc; // 升序 默认

分组 group by
select * from `user` group by `id`;

使用limit限制查询结果的数量
select * from `user` limit 2;

别名 as
select u.id from `user` as u; // 表别名
select account as name from `user`; // 字段别名

联表 join
select i.name, i.wx, u.account
from `user` as u
inner join `user_info` as i on u.id = i.uid
where u.name = 'omgzui';
```

## 四、mysql视图

视图是虚拟的表，可以替代复杂sql查询

```sql
比如上面的
select i.name, i.wx, u.account
from `user` as u
inner join `user_info` as i on u.id = i.uid
where name = 'omgzui';
可以使用
select * from user_info_data where name = 'omgzui';

user_info_data就是视图

创建
create view user_info_data as
select i.name, i.wx, u.account
from `user` as u
inner join `user_info` as i on u.id = i.uid
where name = 'omgzui';

```

注意：

- 与创建表一样，创建视图的名称必须唯一
- 创建视图的个数并没限制，但是如果一张视图嵌套或者关联的表过多，同样会引发性能问题，在实际生产环节中部署时务必进行必要的性能检测。
- 在过滤条件数据时如果在创建视图的sql语句中存在where的条件语句，而在使用该视图的语句中也存在where条件语句时，这两个where条件语句会自动组合
- order by 可以在视图中使用，但如果从该视图检索数据的select语句中也含有order by ，那么该视图中的order by 将被覆盖。
- 视图中不能使用索引，也不能使用触发器
- 使用可以和普通的表一起使用，编辑一条联结视图和普通表的sql语句是允许的。

## 五、mysql索引

作用：提高表中数据的查询速度

    1.普通索引(单列索引)
    2.唯一索引
    3.全文索引
    4.多列索引(符合索引)

```sql

CREATE TABLE `love` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `quote` varchar(50) NOT NULL,
  `space` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`uid`), # 普通索引
  UNIQUE INDEX unique_name(`name`), # 唯一索引
  FULLTEXT INDEX fulltext_quote(`quote`), # 全文索引
  INDEX multi(id,space(20)) # 多列索引
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

```

索引设计：

- where子句中的列可能最适合做为索引
- 不要尝试为性别或者有无这类字段等建立索引(因为类似性别的列，一般只含有`0`和`1`，无论搜索结果如何都会大约得出一半的数据)
- 如果创建复合索引，要遵守`最左前缀`法则。即查询从索引的最左前列开始，并且不跳过索引中的列
- 不要过度使用索引。每一次的更新，删除，插入都会维护该表的索引，更多的索引意味着占用更多的空间
- 使用InnoDB存储引擎时，记录(行)默认会按照一定的顺序存储，如果已定义主键，则按照主键顺序存储，由于普通索引都会保存主键的键值，因此主键应尽可能的选择较短的数据类型，以便节省存储空间
- 不要尝试在索引列上使用函数。

## 六、mysql事务

mysql事务可以理解为一系列操作，要么成功执行，要么失败。

```sql
-- 声明事务的开始
BEGIN(或START TRANSACTION);

-- 提交整个事务
COMMIT;

-- 回滚到事务初始状态
ROLLBACK;
```

四个特性ACID

- atomicity  原子性
- consistency 一致性
- isolation 隔离性
- durability 持久性

### 1、原子性

下图可以很好的描述事务的原子性：事务要不就在执行中，要不然就是成功或者失败的状态

![事务](https://raw.githubusercontent.com/OMGZui/noteBook/master/public/img/mysql_transaction.jpg)

### 2、一致性

如果一个事务原子地在一个一致地数据库中独立运行，那么在它执行之后，数据库的状态一定是一致的。对于这个概念，它的第一层意思就是对于数据完整性的约束，包括主键约束、引用约束以及一些约束检查等等，在事务的执行的前后以及过程中不会违背对数据完整性的约束，所有对数据库写入的操作都应该是合法的，并不能产生不合法的数据状态。

### 3、隔离性

如果所有的事务的执行顺序都是线性的，那么对于事务的管理容易得多，但是允许事务的并行执行却能能够提升吞吐量和资源利用率，并且可以减少每个事务的等待时间。

### 4、持久性

事务的持久性就体现在，一旦事务被提交，那么数据一定会被写入到数据库中并持久存储起来。

### 5、锁

关于锁的锁定，对于UPDATE、DELETE和INSERT语句，InnoDB会自动给涉及数据集加排他锁（X)；对于普通SELECT语句，InnoDB不会加任何锁

### 6、总结

事务的 ACID 四大基本特性是保证数据库能够运行的基石，但是完全保证数据库的 ACID，尤其是隔离性会对性能有比较大影响，在实际的使用中我们也会根据业务的需求对隔离性进行调整，除了隔离性，数据库的原子性和持久性相信都是比较好理解的特性，前者保证数据库的事务要么全部执行、要么全部不执行，后者保证了对数据库的写入都是持久存储的、非易失的，而一致性不仅是数据库对本身数据的完整性的要求，同时也对开发者提出了要求 - 写出逻辑正确并且合理的事务。

## 七、存储过程

存储过程就是数据库中保存的一系列SQL命令的集合

### 栗子1：参数的种类分3种，分别是IN、OUT、INOUT，其中IN为输入参数类型，OUT为输出参数类型，而INOUT既是输入类型又是输出类型，下面我们创建一个存储过程，以达到对user表的用户名称进行模糊查询的目的，存储过程名称为sp_search_user

```sql
-- 改变分隔符
DELIMITER //
-- 创建存储过程
create procedure sp_search_user (in name varchar(20));
    begin
    if name is null or name='' then
        select * from user;
    else
        select * from user where username like name;
    end if;
    end
    //
DELIMITER ; -- 恢复分隔符

-- name传入null值，查询所有用户。
call sp_search_user(null);
call sp_search_user('%omg%');
```

### 栗子2：关键字OUT则是指明相应参数用来从存储过程传出的一个值,也可以理解为存储过程的返回值，而对于INOUT则是两者结合体。现在我们创建一个存储过程，用于返回商品的最大值、最小值和平均值，命名为sp_item_price

```sql
DELIMITER //
-- 创建存储过程
create procedure sp_item_price(out plow decimal(8,2),
                                out phigh decimal(8,2),
                                out pavg decimal(8,2))
    begin
       select min(price) into plow from items;
       select max(price) into phigh from items;
       select avg(price) into pavg from items;
    end;
    //
DELIMITER ; -- 恢复分隔符
-- 调用存储过程
call sp_item_price(@pricelow,@pricehigh,@priceavg);
-- 查询执行结果
select @pricelow;
select @pricehigh;
select @priceavg;
```

## 八、触发器

触发器可以简单理解一种特殊的存储过程

```sql
DELIMITER //
-- 创建触发器
create trigger trg_user_history after delete
    on user
    for each row
    begin
      insert into user_history(uid,name,pinyin,birth,sex,address,updated)
      values(OLD.id,OLD.name,OLD.pinyin,OLD.birth,OLD.sex,OLD.address,NOW());
    end
    //
DELIMITER ;

trg_user_history 触发器名字
after 触发时间
delete 触发事件
user 需要触发的表
for each row 固定写法

上述sql中创建语句的形式与前面的存储过程或者存储函数都很类似，这里有点要注意的是，使用OLD/NEW关键字可以获取数据变更前后的记录，其中OLD用于AFTER时刻，而NEW用于BEFORE时刻的变更。如OLD.name表示从user表删除的记录的名称。INSERT操作一般使用NEW关键字，UPDATE操作一般使用NEW和OLD，而DELETE操作一般使用OLD。
```

## 九、游标

游标就就是可以将检索出来的数据集合保存在内存中然后依次取出每条数据进行处理

```sql
-- 声明游标
DECLARE cursor_name CURSOR FOR SELECT 语句;
-- 打开游标
OPEN cursor_name;
-- 从游标指针中获取数据
FETCH cursor_name INTO 变量名 [,变量名2,...];
-- 关闭游标
CLOSE cursor_name
```

## 十、mysql优化

### 1、编码

```sql
# 查看mysql编码
show variables like 'character%';
+--------------------------+----------------------------+
| Variable_name            | Value                      |
+--------------------------+----------------------------+
| character_set_client     | utf8mb4                    | 客户端来源数据使用的字符集
| character_set_connection | utf8mb4                    | 连接层字符集
| character_set_database   | utf8                       | 当前选中数据库的默认字符集
| character_set_results    | utf8mb4                    | 查询结果字符集
| character_set_server     | latin1                     | 默认的内部操作字符集
| character_set_system     | utf8                       | 系统元数据(字段名等)字符集
+--------------------------+----------------------------+
8 rows in set (0.01 sec)

# 字符集
utf8、utf8mb4
要在 Mysql 中保存 4 字节长度的 UTF-8 字符，需要使用 utf8mb4 字符集，但只有 5.5.3 版本以后的才支持(查看版本： select version();)。我觉得，为了获取更好的兼容性，应该总是使用 utf8mb4 而非 utf8.  对于 CHAR 类型数据，utf8mb4 会多消耗一些空间，根据 Mysql 官方建议，使用 VARCHAR  替代 CHAR。

# 排序规则
_ci、_bin
_ci表示大小写不敏感
_bin表示按编码值比较

```

### 2、多列索引规则

左前缀规则

举例：index(a,b,c)

|条件|索引是否发挥作用|用了哪些列|
|-|-|-|
|Where a=3 | 是|只使用了a列|
|Where a=3 and b=5| 是|使用了a,b列|
|Where a=3 and b=5 and c=4| 是|使用了abc|
|Where b=3  or  where c=4| 否||
|Where a=3 and c=4| 是|a列能发挥索引,c不能|
|Where a=3 and b>10 and c=7| 是|a能利用,b能利用, c不能利用|
|where a=3 and b like ‘xxxx%’ and c=7| 是|a能用,b能用,c不能用|

### 3、myisam和innodb索引区别

描述

- myisam主索引和次索引都指向物理行，比如id指向了物理行，由索引到磁盘拿数据（回行）
- innodb的主索引行上直接存储行的数据，称为聚簇索引，次索引指向主索引，比如id行包括了name、age等等数据，name包括了id

聚簇索引缺点：节点分裂，行数据搬运缓慢，因此尽量用递增整形做索引
myisam则分裂较快

索引覆盖：查找的字段正好是索引，速度快

### 4、索引选择

1. 查询频繁
2. 区分度高
3. 长度小 比如在word字段上设索引，最短长度为2，最长为14，需要测试覆盖率，count(left(word, 4))/count(*)
4. 尽量能覆盖常用查询字段

### 5、分页优化

- 使用where id > 5000000 limit 10  => limit 5000000,10
  - 这样的做法是会走id主键索引，速度是非常快的
  - 需要id连续，因为逻辑删除数据
- 延迟关联，先取索引数据，再由索引到磁盘拿数据（回行）
  - select id,name from lx limit 5000000,10 => select lx.id,name from lx inner join (select id
  - from lx limit 5000000,10) as tmp on lx.id = tmp.id

### 6、索引与排序

1. 对于覆盖索引,直接在索引上查询时,就是有顺序的, using index
2. 先取出数据,形成临时表做filesort(文件排序,但文件可能在磁盘上,也可能在内存中)

我们的争取目标-----取出来的数据本身就是有序的! 利用索引来排序.

## 十、docker实现mysql主从复制

```bash
# 准备容器
docker pull mysql:5.5

# 目录
├── docker-compose.yml
├── .env
├── master
│   ├── Dockerfile
│   └── my.cnf
├── slave1
│   ├── Dockerfile
│   └── my.cnf
└── slave2
    ├── Dockerfile
    └── my.cnf

# 主容器
GRANT REPLICATION SLAVE ON *.* to 'backup'@'%' identified by 'backup';

# 从容器
# 关于主容器ip地址可以使用 docker inspect master_slave_master_1
STOP SLAVE;
CHANGE MASTER TO
MASTER_HOST='172.22.0.2', # HOST由自己主机决定
MASTER_PORT=3306,
MASTER_USER='backup',
MASTER_PASSWORD='backup';
START SLAVE;
show slave status;

# 错误
stop slave ;
set GLOBAL SQL_SLAVE_SKIP_COUNTER=1;
start slave ;
```

## 十一、参考资料

- [mysql基本操作命令汇总](http://www.jianshu.com/p/118e1c41e9f0)
- [『浅入深出』MySQL 中事务的实现](http://draveness.me/mysql-transaction.html)
- [MySQL的初次见面礼基础实战篇](https://blog.csdn.net/javazejian/article/details/61614366)
- [MySQL的进阶实战篇](https://blog.csdn.net/javazejian/article/details/69857949)
- [基于Docker搭建MySQL主从复制](https://my.oschina.net/u/3773384/blog/1810111?p=1)