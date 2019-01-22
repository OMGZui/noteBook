# ElasticSearch简明教程

<!-- TOC -->

- [ElasticSearch简明教程](#elasticsearch%E7%AE%80%E6%98%8E%E6%95%99%E7%A8%8B)
  - [一、ElasticSearch是什么](#%E4%B8%80elasticsearch%E6%98%AF%E4%BB%80%E4%B9%88)
  - [二、基本概念](#%E4%BA%8C%E5%9F%BA%E6%9C%AC%E6%A6%82%E5%BF%B5)
    - [2、安装](#2%E5%AE%89%E8%A3%85)
    - [3、探索集群](#3%E6%8E%A2%E7%B4%A2%E9%9B%86%E7%BE%A4)
      - [集群健康](#%E9%9B%86%E7%BE%A4%E5%81%A5%E5%BA%B7)
      - [索引](#%E7%B4%A2%E5%BC%95)
    - [4、修改数据](#4%E4%BF%AE%E6%94%B9%E6%95%B0%E6%8D%AE)
    - [5、探索数据](#5%E6%8E%A2%E7%B4%A2%E6%95%B0%E6%8D%AE)
      - [搜索](#%E6%90%9C%E7%B4%A2)
      - [执行过滤](#%E6%89%A7%E8%A1%8C%E8%BF%87%E6%BB%A4)
      - [执行聚合](#%E6%89%A7%E8%A1%8C%E8%81%9A%E5%90%88)

<!-- /TOC -->

## 一、ElasticSearch是什么

ElasticSearch是一个高可扩展的开源全文搜索和分析引擎，它允许您快速和接近实时地存储、搜索、分析大量数据，通常用作底层引擎/技术，为具有复杂搜索功能和要求的应用程序提供支持。

## 二、基本概念

- `Near Realtime (NRT)`接近实时，因为从索引文档到搜索文档有个一秒的延时
- `Cluster`集群：一个或多个`nodes`节点的集合
- `Node`节点：存储数据并参与集群的`index`索引和搜索功能，默认名为`elasticsearch`
- `Index`索引：某些类似特征的`document`文档集合，类似mysql中的`database`
- `Type`类型：允许您在同一索引中存储不同类型的`document`文档，类似mysql中的`table`
- `Document`文档：索引的基本单元，类似mysql中的`column`
- `Shards & Replicas`分片和副本：一个索引默认5个分片1个副本

### 2、安装

我是macOS，使用

```bash
brew install elasticsearch
```

其它系统参考 https://www.elastic.co/guide/en/elasticsearch/reference/current/install-elasticsearch.html

### 3、探索集群

#### 集群健康

```bash
curl -X GET "localhost:9200/_cat/health?v"
epoch      timestamp cluster              status node.total node.data shards pri relo init unassign pending_tasks max_task_wait_time active_shards_percent
1548136656 05:57:36  elasticsearch_shengj yellow          1         1     37  37    0    0       36             0                  -                 50.7%

curl -X GET "localhost:9200/_cat/nodes?v"
ip             heap.percent ram.percent cpu load_1m load_5m load_15m node.role master name
192.168.22.239           27         100  40    3.33                  mdi       *      sS2JSA-
```

- Green - 一切都好 (集群全功能)
- Yellow - 所有数据都可用，但是有些副本没有分配 (集群全功能)
- Red - 有些数据由于某些原因不可用 (集群部分功能)

#### 索引

```bash
# 创建索引
curl -X PUT "localhost:9200/customer?pretty"
{
  "acknowledged" : true,
  "shards_acknowledged" : true,
  "index" : "customer"
}

# 列出所有索引
curl -X GET "localhost:9200/_cat/indices?v"
health status index      uuid                   pri rep docs.count docs.deleted store.size pri.store.size
yellow open   customer   KAp8iTCHSnWBkTqa5UB_Hw   5   1          1            0      4.5kb          4.5kb

# 删除索引
curl -X DELETE "localhost:9200/customer?pretty"
{
  "acknowledged" : true,
}

# customer索引新增文档 "_version" : 1,"result" : "created"
curl -X PUT "localhost:9200/customer/_doc/1?pretty" -H 'Content-Type: application/json' -d'
{
  "name": "John Doe"
}
'
{
  "_version" : 1,
  "result" : "created",

}

# customer索引获取文档
curl -X GET "localhost:9200/customer/_doc/1?pretty"
{
  "_index" : "customer",
  "_type" : "_doc",
  "_id" : "1",
  "_version" : 1,
  "found" : true,
  "_source" : {
    "name" : "John Doe"
  }
}
```

### 4、修改数据

```bash
# customer索引替换文档 "_version" : 2,"result" : "updated"
curl -X PUT "localhost:9200/customer/_doc/1?pretty" -H 'Content-Type: application/json' -d'
{
  "name": "John Doe"
}
'
{
  "_version" : 2,
  "result" : "updated",

}

# customer索引更新文档 "_version" : 3,"result" : "updated"
curl -X POST "localhost:9200/customer/_doc/1/_update?pretty" -H 'Content-Type: application/json' -d'
{
  "doc": { "name": "Jane Doe", "age": 20 }
}
'
{
  "_version" : 3,
  "result" : "updated",
}

# customer索引使用脚本更新文档 "_version" : 4,"result" : "updated"
curl -X POST "localhost:9200/customer/_doc/1/_update?pretty" -H 'Content-Type: application/json' -d'
{
  "script" : "ctx._source.age += 5"
}
'
{
  "_version" : 4,
  "result" : "updated",
}

# customer索引获取文档
curl -X GET "localhost:9200/customer/_doc/1?pretty"
{
  "_index" : "customer",
  "_type" : "_doc",
  "_id" : "1",
  "_version" : 4,
  "found" : true,
  "_source" : {
    "name" : "Jane Doe",
    "age" : 25
  }
}

# customer索引删除文档 "_version" : 5,"result" : "deleted"
curl -X DELETE "localhost:9200/customer/_doc/1?pretty"
{
  "_version" : 5,
  "result" : "deleted",
}

# 多个操作
curl -X POST "localhost:9200/customer/_doc/_bulk?pretty" -H 'Content-Type: application/json' -d'
{"index":{"_id":"1"}}
{"name": "John Doe" }
{"index":{"_id":"2"}}
{"name": "Jane Doe" }
'
{
  "took" : 70,
  "errors" : false,
  "items" : [
    {
      "index" : {
        "_index" : "customer",
        "_type" : "_doc",
        "_id" : "1",
        "_version" : 1,
        "result" : "created",
      }
    },
    {
      "index" : {
        "_index" : "customer",
        "_type" : "_doc",
        "_id" : "2",
        "_version" : 1,
        "result" : "created",
      }
    }
  ]
}
curl -X POST "localhost:9200/customer/_doc/_bulk?pretty" -H 'Content-Type: application/json' -d'
{"update":{"_id":"1"}}
{"doc": { "name": "John Doe becomes Jane Doe" } }
{"delete":{"_id":"2"}}
'
{
  "took" : 256,
  "errors" : false,
  "items" : [
    {
      "update" : {
        "_index" : "customer",
        "_type" : "_doc",
        "_id" : "1",
        "_version" : 2,
        "result" : "updated",
        "status" : 200
      }
    },
    {
      "delete" : {
        "_index" : "customer",
        "_type" : "_doc",
        "_id" : "2",
        "_version" : 2,
        "result" : "deleted",
      }
    }
  ]
}
```

### 5、探索数据

```bash
# 导入样本数据
wget https://github.com/elastic/elasticsearch/blob/master/docs/src/test/resources/accounts.json
curl -H "Content-Type: application/json" -XPOST "localhost:9200/bank/_doc/_bulk?pretty&refresh" --data-binary "@accounts.json"
curl -X GET "localhost:9200/_cat/indices?v"
health status index      uuid                   pri rep docs.count docs.deleted store.size pri.store.size
yellow open   bank       2FefWFSMTYyVbRa64U5ZIg   5   1       1000            0    483.3kb        483.3kb
yellow open   customer   TPcMKbdjSuSZSd1jcC7bYA   5   1          1            0      4.4kb          4.4kb

```

#### 搜索

- took – es执行搜索所消耗的时间，毫秒
- timed_out – 是否超时
- _shards – 搜索了多少分片，以及成功或失败了多少分片
- hits – 搜索结果
- hits.total – 符合搜索条件的文件总数
- hits.hits – 实际的搜索结果数组（默认为前10个文档）
- hits.sort - 排序结果的关键字（如果按分数排序则丢失）
- hits._score - 分值，代表匹配的程度
- hits.max_score - 最大分值

```bash
curl -X GET "localhost:9200/bank/_search?pretty" -H 'Content-Type: application/json' -d'
{
  "query": { "match_all": {} },
  "sort": [
    { "account_number": "asc" }
  ]
}
'
{
  "took" : 12,
  "timed_out" : false,
  "_shards" : {
    "total" : 5,
    "successful" : 5,
    "skipped" : 0,
    "failed" : 0
  },
  "hits" : {
    "total" : 1000,
    "max_score" : null,
    "hits" : [
      {
        "_index" : "bank",
        "_type" : "_doc",
        "_id" : "0",
        "_score" : null,
        "_source" : {
          "account_number" : 0,
          "balance" : 16623,
          "firstname" : "Bradshaw",
          "lastname" : "Mckenzie",
          "age" : 29,
          "gender" : "F",
          "address" : "244 Columbus Place",
          "employer" : "Euron",
          "email" : "bradshawmckenzie@euron.com",
          "city" : "Hobucken",
          "state" : "CO"
        },
        "sort" : [
          0
        ]
      }
    ]
  }
}

# select * from bank
curl -X GET "localhost:9200/bank/_search" -H 'Content-Type: application/json' -d'
{
  "query": { "match_all": {} }
}
'

# select * from bank limit 1
curl -X GET "localhost:9200/bank/_search" -H 'Content-Type: application/json' -d'
{
  "query": { "match_all": {} },
  "size": 1
}
'

# select * from bank limit 10,10
curl -X GET "localhost:9200/bank/_search" -H 'Content-Type: application/json' -d'
{
  "query": { "match_all": {} },
  "from": 10,
  "size": 10
}
'

# select * from bank order by balance desc
curl -X GET "localhost:9200/bank/_search" -H 'Content-Type: application/json' -d'
{
  "query": { "match_all": {} },
  "sort": { "balance": { "order": "desc" } }
}
'

# select account_number,balance from bank
curl -X GET "localhost:9200/bank/_search" -H 'Content-Type: application/json' -d'
{
  "query": { "match_all": {} },
  "_source": ["account_number", "balance"]
}
'

# select * from bank where account_number=20
curl -X GET "localhost:9200/bank/_search" -H 'Content-Type: application/json' -d'
{
  "query": { "match": { "account_number": 20 } }
}
'

# select * from bank where address='mill' or address='lane'
curl -X GET "localhost:9200/bank/_search" -H 'Content-Type: application/json' -d'
{
  "query": { "match": { "address": "mill lane" } }
}
'
curl -X GET "localhost:9200/bank/_search" -H 'Content-Type: application/json' -d'
{
  "query": {
    "bool": {
      "should": [
        { "match": { "address": "mill" } },
        { "match": { "address": "lane" } }
      ]
    }
  }
}
'

# select * from bank where address='mill lane'
curl -X GET "localhost:9200/bank/_search" -H 'Content-Type: application/json' -d'
{
  "query": { "match_phrase": { "address": "mill lane" } }
}
'

# select * from bank where address='mill' and address='lane'
curl -X GET "localhost:9200/bank/_search" -H 'Content-Type: application/json' -d'
{
  "query": {
    "bool": {
      "must": [
        { "match": { "address": "mill" } },
        { "match": { "address": "lane" } }
      ]
    }
  }
}
'

# must must_not should 可以组合使用
```

#### 执行过滤

```bash
# select * from bank where balance>=20000 and balance<=30000
curl -X GET "localhost:9200/bank/_search" -H 'Content-Type: application/json' -d'
{
  "query": {
    "bool": {
      "must": { "match_all": {} },
      "filter": {
        "range": {
          "balance": {
            "gte": 20000,
            "lte": 30000
          }
        }
      }
    }
  }
}
'
```

#### 执行聚合

```bash

# 按年龄段（20-29岁，30-39岁和40-49岁）进行分组，然后按性别进行分组，最后得到每个年龄段的平均帐户余额
# sql还不知道怎么写
curl -X GET "localhost:9200/bank/_search" -H 'Content-Type: application/json' -d'
{
  "size": 0,
  "aggs": {
    "group_by_age": {
      "range": {
        "field": "age",
        "ranges": [
          {
            "from": 20,
            "to": 30
          },
          {
            "from": 30,
            "to": 40
          },
          {
            "from": 40,
            "to": 50
          }
        ]
      },
      "aggs": {
        "group_by_gender": {
          "terms": {
            "field": "gender.keyword"
          },
          "aggs": {
            "average_balance": {
              "avg": {
                "field": "balance"
              }
            }
          }
        }
      }
    }
  }
}
'

```