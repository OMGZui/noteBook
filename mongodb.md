# mongodb

<!-- TOC -->

- [mongodb](#mongodb)
    - [一、什么是mongodb](#一什么是mongodb)
        - [**mongo和传统型数据库相比，最大的不同：**](#mongo和传统型数据库相比最大的不同)
    - [二、安装](#二安装)
    - [三、基本使用](#三基本使用)
    - [四、游标 cursor](#四游标-cursor)
        - [**游标是什么**](#游标是什么)
    - [五、索引](#五索引)
    - [六、Mongodb导出与导入](#六mongodb导出与导入)
    - [七、mongodb的用户管理](#七mongodb的用户管理)
    - [八、分片](#八分片)
    - [九、参考资料](#九参考资料)

<!-- /TOC -->

## 一、什么是mongodb

- memcached和redis属于kv数据库(key/value)
- mongodb 文档数据库，存储的是文档(Bson->json的二进制化)

**特点：** 内部执行引擎为JS解释器，把文档存储成bson结构，在查询时，转换为JS对象，并可以通过熟悉的js语法来操作

### **mongo和传统型数据库相比，最大的不同：**

- **传统型数据库：** 结构化数据,定好了表结构后，每一行的内容，必是符合表结构的，就是说--列的个数，类型都一样

- **mongo文档型数据库：** 表下的每篇文档，都可以有自己独特的结构(json对象都可以有自己独特的属性和值)

## 二、安装

```sh
# 下载
wget https://fastdl.mongodb.org/linux/mongodb-linux-x86_64-rhel62-3.4.10.tgz
# 解压
tar -zxvf mongodb-linux-x86_64-rhel62-3.4.10.tgz
# 解压过程
mongodb-linux-x86_64-rhel62-3.4.10/README
mongodb-linux-x86_64-rhel62-3.4.10/THIRD-PARTY-NOTICES
mongodb-linux-x86_64-rhel62-3.4.10/MPL-2
mongodb-linux-x86_64-rhel62-3.4.10/GNU-AGPL-3.0
mongodb-linux-x86_64-rhel62-3.4.10/bin/mongodump
mongodb-linux-x86_64-rhel62-3.4.10/bin/mongorestore
mongodb-linux-x86_64-rhel62-3.4.10/bin/mongoexport
mongodb-linux-x86_64-rhel62-3.4.10/bin/mongoimport
mongodb-linux-x86_64-rhel62-3.4.10/bin/mongostat
mongodb-linux-x86_64-rhel62-3.4.10/bin/mongotop
mongodb-linux-x86_64-rhel62-3.4.10/bin/bsondump
mongodb-linux-x86_64-rhel62-3.4.10/bin/mongofiles
mongodb-linux-x86_64-rhel62-3.4.10/bin/mongooplog
mongodb-linux-x86_64-rhel62-3.4.10/bin/mongoreplay
mongodb-linux-x86_64-rhel62-3.4.10/bin/mongoperf
mongodb-linux-x86_64-rhel62-3.4.10/bin/mongod
mongodb-linux-x86_64-rhel62-3.4.10/bin/mongos
mongodb-linux-x86_64-rhel62-3.4.10/bin/mongo

# readme
MongoDB README

Welcome to MongoDB 3.4!

COMPONENTS

  mongod - The database server.
  mongos - Sharding router.
  mongo  - The database shell (uses interactive javascript).

UTILITIES

  mongodump         - Create a binary dump of the contents of a database.
  mongorestore      - Restore data from the output created by mongodump.
  mongoexport       - Export the contents of a collection to JSON or CSV.
  mongoimport       - Import data from JSON, CSV or TSV.
  mongofiles        - Put, get and delete files from GridFS.
  mongostat         - Show the status of a running mongod/mongos.
  bsondump          - Convert BSON files into human-readable formats.
  mongooplog        - Poll the oplog and apply to a local server.
  mongoreplay       - Traffic capture and replay tool.
  mongotop          - Track time spent reading and writing data.

RUNNING

  For command line options invoke:

    $ ./mongod --help

  To run a single server database:

    $ sudo mkdir -p /data/db
    $ ./mongod
    $
    $ # The mongo javascript shell connects to localhost and test database by default:
    $ ./mongo
    > help

# 访问web界面
./bin/mongod --rest
默认端口是28017
http://104.223.3.138:28017/

```

## 三、基本使用

```sh
# 查看数据库
show dbs

# 创建数据库
use shengj 并且 db.createCollection('shengj')

# 使用数据库
use shengj

# 查看表
show tables 或者 show collections

# CURD
# 单条插入
db.shengj.insert({_id:1,name:'wangm',age:24})

# 多条插入
db.shengj.insert([{_id:3,name:'wangm',age:24},{_id:2,sex:'male'}])

# 查询全部
db.shengj.find()

{ "_id" : ObjectId("5a1f69dfe8b4168b306d93e0"), "name" : "wangm" }
{ "_id" : 1, "name" : "wangm", "age" : 24 }
{ "_id" : 3, "name" : "wangm", "age" : 24 }
{ "_id" : 2, "sex" : "male" }
{ "_id" : ObjectId("5a1f6bf1e8b4168b306d93e1"), "name" : "wangyn", "sex" : "female", "age" : 25 }
{ "_id" : 5, "name" : "ergou" }

# 查询1个条件，默认显示_id
db.shengj.find({},{age:24})

# 查询1个条件，不显示_id
db.shengj.find({},{age:24,_id:0})

# 查询多个条件
db.shengj.find({name:'wangm'},{age:24,_id:0})

# 删除
db.shengj.remove({name:'ergou'})

# 更新，这里的更新是替换，只保留_id和你写的值
db.shengj.update({age:24},{age:22})

# 更新，upsert如果没有则创建，有则更新，这个是更新
db.shengj.update({age:22},{$set:{name:wangm}},{upsert:true})

# 更新，upsert如果没有则创建，有则更新，这个是创建
db.shengj.update({_id:22},{$set:{name:'wangm'}},{upsert:true})

db.shengj.find()
{ "_id" : ObjectId("5a1f69dfe8b4168b306d93e0"), "name" : "wangm" }
{ "_id" : 1, "age" : 22, "name" : "wangm" }
{ "_id" : 3, "age" : 22 }
{ "_id" : 2, "sex" : "male" }
{ "_id" : ObjectId("5a1f6bf1e8b4168b306d93e1"), "name" : "wangyn", "sex" : "female", "age" : 25 }
{ "_id" : 22, "name" : "wangm" }

# 查询表达式
$ne => != {field:{$nq:value}}
$nin => not in
$all => {field:{$all:[v1,v2]}} 至少包括v1,v2
$exists => {field:{$exists:1}}

$nor => {$nor,[条件1,条件2]} 所有条件都不满足的文档为真返回
正则 => 用正则表达式查询 以”诺基亚”开头的商品
db.goods.find({goods_name:/诺基亚.*/},{goods_name:1})

$where => 用$where表达式来查询
db.goods.find({$where:'this.cat_id != 3 && this.cat_id != 11'})

注意: 用$where查询时, mongodb是把bson结构的二进制数据转换为json结构的对象,
然后比较对象的属性是否满足表达式.
速度较慢

例子：update的option使用
db.user.insert({name:'lisi',age:12,sex:'male',height:123,area:'haidian'})
db.user.update({name:'lisi'},{$set:{area:'chaoyang'},$unset:{height:1},$inc:{age:1},$rename:{sex:'gender'}})
db.user.find()

{ "_id" : ObjectId("51fc01c4f5de93e1f2856e33"), "age" : 13, "area" : "chaoyang", "gender" : "male", "name" : "lisi" }


```

## 四、游标 cursor

### **游标是什么**

    通俗的说,游标不是查询结果,而是查询的返回资源,或者接口.
    通过这个接口,你可以逐条读取.
    就像php中的fopen打开文件,得到一个资源一样, 通过资源,可以一行一行的读文件.

```sh
# 定义游标
var mycursor = db.shengj.find()

# while循环游标
> while(mycursor.hasNext()){
... printjson(mycursor.next());
... }
{ "_id" : ObjectId("5a1f69dfe8b4168b306d93e0"), "name" : "wangm" }
{ "_id" : 1, "age" : 22, "name" : "wangm" }
{ "_id" : 3, "age" : 22 }
{ "_id" : 2, "sex" : "male" }
{
	"_id" : ObjectId("5a1f6bf1e8b4168b306d93e1"),
	"name" : "wangyn",
	"sex" : "female",
	"age" : 25
}
{ "_id" : 22, "name" : "wangm" }

# 简写
for(var  cursor=db.goods.find(), doc=true;cursor.hasNext();) { printjson(cursor.next());}

# 游标在分页中的应用
比如查到10000行,跳过100页,取10行.
一般地,我们假设每页N行, 当前是page页
就需要跳过前 (page-1)*N 行, 再取N行, 在mysql中, limit offset,N来实现
在mongo中,用skip(), limit()函数来实现的

# 查询第901页,每页10条
var mytcursor = db.bar.find().skip(9000).limit(10);

# 通过cursor一次性得到所有数据, 并返回数组
var cursor = db.goods.find();
printjson(cursor.toArray());  //看到所有行
printjson(cursor.toArray()[2]);  //看到第2行

注意: 不要随意使用toArray()
原因: 会把所有的行立即以对象形式组织在内存里.
可以在取出少数几行时,用此功能.

```

## 五、索引

- 索引提高查询速度,降低写入速度,权衡常用的查询字段,不必在太多列上建索引
- 在mongodb中,索引可以按字段升序/降序来创建,便于排序
- 默认是用btree来组织索引文件,2.4版本以后,也允许建立hash索引.

```sh

> db.shengj.find({age:22}).explain()
{
	"queryPlanner" : {
		"plannerVersion" : 1,
		"namespace" : "shengj.shengj",
		"indexFilterSet" : false,
		"parsedQuery" : {
			"age" : {
				"$eq" : 22
			}
		},
		"winningPlan" : {
			"stage" : "COLLSCAN",
			"filter" : {
				"age" : {
					"$eq" : 22
				}
			},
			"direction" : "forward"
		},
		"rejectedPlans" : [ ]
	},
	"serverInfo" : {
		"host" : "omgzui",
		"port" : 27017,
		"version" : "3.4.10",
		"gitVersion" : "078f28920cb24de0dd479b5ea6c66c644f6326e9"
	},
	"ok" : 1
}

# 查看当前索引状态
db.shengj.getIndexes()

# 创建普通单列索引
db.shengj.ensureIndex({name:1/-1})  1是升续 2是降续

# 删除单个索引
db.shengj.dropIndex({name:1/-1})

# 删除所有索引
db.shengj.dropIndexes()

# 创建多列索引
db.shengj.ensureIndex({name:1/-1, mobile:1/-1})

# 创建子文档索引
db.shengj.ensureIndex({name.subfield:1/-1})

# 创建唯一索引
db.shengj.ensureIndex({name.subfield:1/-1}, {unique:true})

# 创建哈希索引(2.4新增的)
哈希索引速度比普通索引快,但是,无能对范围查询进行优化.
适宜于---随机性强的散列
db.shengj.ensureIndex({name:’hashed’})

# 重建索引
一个表经过很多次修改后,导致表的文件产生空洞,索引文件也如此.
可以通过索引的重建,减少索引文件碎片,并提高索引的效率.
类似mysql中的optimize table

db.shengj.reIndex()

```

## 六、Mongodb导出与导入

## 七、mongodb的用户管理

## 八、分片

## 九、参考资料