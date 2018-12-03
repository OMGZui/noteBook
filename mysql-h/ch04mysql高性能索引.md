# 高性能的索引

## 1、索引基础

索引是存储引擎用于快速找到记录的一种数据结构

索引类型：

- B-Tree
- 哈希索引

索引的优点：

- 大大减少了服务器需要扫描的数据量
- 可以帮助服务器避免排序和临时表
- 可以将随机I/O变为顺序I/O

## 2、高性能索引策略

### 独立的列

`select a_id from xx where a_id + 1 = 5;`

### 前缀索引和索引选择性

`select count(*) as cnt, left(city, 7) as pref from xxx group by pref order by cnt desc limit 10;`

### 多列索引

### 索引列顺序

### 聚簇索引

数据行实际上存放在索引的叶子页中，术语叫`聚簇`

索引列包含的是整数值

- myisam主索引和次索引都指向物理行，比如id指向了物理行，由索引到磁盘拿数据（回行）
- innodb的主索引行上直接存储行的数据，称为聚簇索引，次索引指向主索引，比如id行包括了name、age等等数据，name包括了id
