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
    - [四、mysql事务](#四mysql事务)
    - [五、mysql优化](#五mysql优化)
    - [六、参考资料](#六参考资料)

<!-- /TOC -->

## 一、mysql是什么

MySQL（官方发音为/maɪ ˌɛskjuːˈɛl/“My S-Q-L”[1]，但也经常读作/maɪ ˈsiːkwəl/“My Sequel”）原本是一个开放源代码的关系数据库管理系统，原开发者为瑞典的MySQL AB公司，该公司于2008年被昇阳微系统（Sun Microsystems）收购。2009年，甲骨文公司（Oracle）收购昇阳微系统公司，MySQL成为Oracle旗下产品。

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

## 2、源码安装

## 三、mysql使用

数据库：demo

数据表：user

字段：id int(11) | account varchar(255) | password varchar(255)

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

## 四、mysql事务

## 五、mysql优化

## 六、参考资料
