# mysql简介

## 1、mysql逻辑架构

- 最上层，客户端

    连接处理、授权认证、安全

- 中间层，核心服务

    查询解析、分析、优化、缓存、内置函数、存储引擎、触发器、视图

- 最下层，存储引擎

    存储引擎负责mysql中数据的存储和提取

## 2、并发控制

### 读写锁

读锁又叫共享锁，多用户可以同一个时刻读取同一个资源，而互不干扰

写锁又叫排它锁，同一个时刻只能有一个用户读写数据

### 锁策略和锁粒度

表锁，开销最小的策略

行锁，最大程度支持并发处理，同时开销极大

## 3、事务

事务就是一组原子性的sql查询，事务内的语句，要么全部执行，要么全部执行失败

ACID特性：

- 原子性

    事务要不就在执行中，要不然就是成功或者失败的状态

- 一致性

    执行事务过程中，所有对数据库写入的操作都应该是合法的，并不能产生不合法的数据状态

- 隔离性

    一个事务结束前，对另一个事务是不可见的

- 持久性

    一旦事务被提交，那么数据一定会被写入到数据库中并持久存储起来。

### 隔离级别

- 未提交读 READ-UNCOMMITTED

    事务可以读取未提交的数据，会产生脏读

- 提交读 READ-COMMITTED

    不可重复读

- 可重复读 REPEATABLE-READ

    mysql默认隔离级别，会产生幻读，意思是当事务在读取某个范围内的记录时，另外一个事务又在该范围内插入了新的记录

- 可串行化 SERIALIZABLE

    最高隔离级别

### 死锁

指两个或者多个事务在同一资源上相互占用，并请求锁定对方占用资源，从而导致恶性循环的现象

自动提交：`show variables like "autocommit";`
设置隔离级别：`show variables like "transaction_isolation";`,`set transaction isolation level;`
MVCC：多版本并发控制

## 4、存储引擎

```sql

show table status like 'users'\G
*************************** 1. row ***************************
           Name: users
         Engine: InnoDB
        Version: 10
     Row_format: Dynamic
           Rows: 0
 Avg_row_length: 0
    Data_length: 16384
Max_data_length: 0
   Index_length: 0
      Data_free: 0
 Auto_increment: 2
    Create_time: 2018-09-26 10:40:42
    Update_time: NULL
     Check_time: NULL
      Collation: utf8mb4_unicode_ci
       Checksum: NULL
 Create_options:
        Comment:
1 row in set (0.05 sec)
```