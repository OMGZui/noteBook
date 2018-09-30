# elasticSearch

<!-- TOC -->

- [elasticSearch](#elasticsearch)
    - [一、elasticSearch是什么](#一elasticsearch是什么)
    - [二、安装](#二安装)
    - [三、基础](#三基础)
    - [四、增删改查](#四增删改查)
        - [1、新增](#1新增)
        - [2、更新](#2更新)
        - [3、查询](#3查询)
        - [4、删除](#4删除)
    - [五、搜索](#五搜索)
        - [1、分页](#1分页)
        - [2、映射](#2映射)
        - [3、分析](#3分析)
        - [4、映射和分析](#4映射和分析)
    - [六、高级搜索](#六高级搜索)
        - [1、精确搜索](#1精确搜索)
        - [2、多条件查询](#2多条件查询)
        - [3、范围查询](#3范围查询)
        - [4、null处理](#4null处理)
        - [5、全文搜索](#5全文搜索)
    - [参考](#参考)

<!-- /TOC -->

## 一、elasticSearch是什么

Elasticsearch 是一个实时的分布式搜索分析引擎， 它能让你以一个之前从未有过的速度和规模，去探索你的数据。 它被用作全文检索、结构化搜索、分析以及这三个功能的组合

## 二、安装

```bash
# mac直接brew
brew install elasticsearch
# 其它
https://www.elastic.co/downloads/elasticsearch
```

## 三、基础

概念：

- `hits` 中文意思是`击中`，这里相当于匹配到的数据
- `total` 匹配的总个数
- `max_score` 最大分值
- `_index` 索引 相当于SQL中的`database`
- `_type` 类型 相当于SQL中的`table`
- `_id` 唯一标识 相当于SQL中的`id`
- `_score` 分值，代表匹配的程度
- `_source` 元数据 相当于SQL中`table`中的`字段`合集
- `took` 搜索耗时
- `_shards` 查询中参与分片的总数
- `timed_out` 查询是否超时

```bash
curl -XGET "http://localhost:9200/website/blog/_search?pretty" -H 'Content-Type:application/json'

{
  "took" : 2,
  "timed_out" : false,
  "_shards" : {
    "total" : 5,
    "successful" : 5,
    "skipped" : 0,
    "failed" : 0
  },
  "hits" : {
    "total" : 4,
    "max_score" : 1.0,
    "hits" : [
      {
        "_index" : "website",
        "_type" : "blog",
        "_id" : "2",
        "_score" : 1.0,
        "_source" : {
          "title" : "标题2",
          "text" : "内容2",
          "views" : 10,
          "tags" : [
            "标签2",
            "标签3"
          ]
        }
      }
    ]
  }
}
```

## 四、增删改查

- `"_version": 1,` 版本号，每次操作都会递增
- `"result": "created",` 操作结果

### 1、新增

```bash
# 新增
curl -X PUT "http://localhost:9200/website/blog/123?pretty" -H 'Content-Type: application/json' -d'
{
    "title" : "标题123",
    "text" : "内容123",
    "views" : 123,
    "tags" : [
        "标签122",
        "标签133"
    ]
}
'

{
    "_index": "website",
    "_type": "blog",
    "_id": "123",
    "_version": 1,
    "result": "created",
    "_shards": {
        "total": 2,
        "successful": 1,
        "failed": 0
    },
    "_seq_no": 0,
    "_primary_term": 9
}

```

### 2、更新

```bash
# 更新
curl -X PUT "http://localhost:9200/website/blog/123?pretty" -H 'Content-Type: application/json' -d'
{
    "title" : "标题123",
    "text" : "内容123",
    "views" : 1230,
    "tags" : [
        "标签122",
        "标签133"
    ]
}
'

{
  "_index" : "website",
  "_type" : "blog",
  "_id" : "123",
  "_version" : 2,
  "result" : "updated",
  "_shards" : {
    "total" : 2,
    "successful" : 1,
    "failed" : 0
  },
  "_seq_no" : 2,
  "_primary_term" : 9
}

```

### 3、查询

```bash
curl -X GET "http://localhost:9200/website/blog/123?pretty" -H 'Content-Type: application/json'

{
  "_index" : "website",
  "_type" : "blog",
  "_id" : "123",
  "_version" : 5,
  "found" : true,
  "_source" : {
    "title" : "标题123",
    "text" : "内容123",
    "views" : 123,
    "tags" : [
      "标签122",
      "标签133"
    ]
  }
}
```

### 4、删除

```bash
curl -X DELETE "http://localhost:9200/website/blog/123?pretty" -H 'Content-Type: application/json'

{
  "_index" : "website",
  "_type" : "blog",
  "_id" : "123",
  "_version" : 3,
  "result" : "deleted",
  "_shards" : {
    "total" : 2,
    "successful" : 1,
    "failed" : 0
  },
  "_seq_no" : 3,
  "_primary_term" : 9
}
```

## 五、搜索

上面我们用过了基本的搜索`curl -XGET "http://localhost:9200/website/blog/_search?pretty" -H 'Content-Type:application/json'`

接下来进一步介绍

### 1、分页

- `size` 显示应该返回的结果数量，默认是 10
- `from` 显示应该跳过的初始结果数量，默认是 0

```bash
# 分页
curl -XGET "http://localhost:9200/website/blog/_search?size=1&from=0&pretty" -H 'Content-Type:application/json'

{
  "took" : 1,
  "timed_out" : false,
  "_shards" : {
    "total" : 5,
    "successful" : 5,
    "skipped" : 0,
    "failed" : 0
  },
  "hits" : {
    "total" : 5,
    "max_score" : 1.0,
    "hits" : [
      {
        "_index" : "website",
        "_type" : "blog",
        "_id" : "123",
        "_score" : 1.0,
        "_source" : {
          "title" : "标题123",
          "text" : "内容123",
          "views" : 123,
          "tags" : [
            "标签122",
            "标签133"
          ]
        }
      }
    ]
  }
}
```

### 2、映射

- `_mapping` 映射，对元数据字段的猜测，并不一定准确

```bash
curl -XGET "http://localhost:9200/website/_mapping/blog?pretty" -H 'Content-Type:application/json'

{
  "website" : {
    "mappings" : {
      "blog" : {
        "properties" : {
          "tags" : {
            "type" : "text",
            "fields" : {
              "keyword" : {
                "type" : "keyword",
                "ignore_above" : 256
              }
            }
          },
          "text" : {
            "type" : "text",
            "fields" : {
              "keyword" : {
                "type" : "keyword",
                "ignore_above" : 256
              }
            }
          },
          "title" : {
            "type" : "text",
            "fields" : {
              "keyword" : {
                "type" : "keyword",
                "ignore_above" : 256
              }
            }
          },
          "views" : {
            "type" : "long"
          }
        }
      }
    }
  }
}
```

### 3、分析

- `_analyze` 分析，对数据进行分析，比如分词
- `token` 是实际存储到索引中的词条
- `position` 指明词条在原始文本中出现的位置
- `start_offset` 和 `end_offset` 指明字符在原始字符串中的位置

> ik_max_word是中文分词[elasticsearch-analysis-ik](https://github.com/medcl/elasticsearch-analysis-ik)

```bash
curl -XPOST "http://localhost:9200/_analyze?pretty" -H 'Content-Type:application/json' -d '
{
  "analyzer": "standard",
  "text": "Text to analyze"
}
'

{
  "tokens" : [
    {
      "token" : "text",
      "start_offset" : 0,
      "end_offset" : 4,
      "type" : "<ALPHANUM>",
      "position" : 0
    },
    {
      "token" : "to",
      "start_offset" : 5,
      "end_offset" : 7,
      "type" : "<ALPHANUM>",
      "position" : 1
    },
    {
      "token" : "analyze",
      "start_offset" : 8,
      "end_offset" : 15,
      "type" : "<ALPHANUM>",
      "position" : 2
    }
  ]
}
```

### 4、映射和分析

```bash
# 新增映射
curl -XPUT "http://localhost:9200/gb?pretty" -H 'Content-Type:application/json' -d '
{
  "mappings": {
    "tweet" : {
      "properties" : {
        "tweet" : {
          "type" :    "text",
          "analyzer": "ik_max_word",
          "search_analyzer": "ik_max_word"
        },
        "date" : {
          "type" :   "date"
        },
        "name" : {
          "type" :   "text",
          "analyzer": "ik_max_word",
          "search_analyzer": "ik_max_word"
        },
        "user_id" : {
          "type" :   "long"
        }
      }
    }
  }
}
'

{
  "acknowledged" : true,
  "shards_acknowledged" : true,
  "index" : "gb"
}

# 测试映射
curl -XGET "http://localhost:9200/gb/_mapping/tweet?pretty" -H 'Content-Type:application/json'

{
  "gb" : {
    "mappings" : {
      "tweet" : {
        "properties" : {
          "date" : {
            "type" : "date"
          },
          "name" : {
            "type" : "text",
            "analyzer" : "ik_max_word"
          },
          "tweet" : {
            "type" : "text",
            "analyzer" : "ik_max_word"
          },
          "user_id" : {
            "type" : "long"
          }
        }
      }
    }
  }
}

```

## 六、高级搜索

### 1、精确搜索

- `constant_score` 非评分模式，`_score`都是1
- `filter` 过滤
- `term` 精确搜索单个
- `terms` 精确搜索多个

```sql
select * from blog where views=123
```

```bash
curl -XGET "http://localhost:9200/website/blog/_search?pretty" -H 'Content-Type:application/json' -d '
{
  "query": {
    "constant_score": {
      "filter": {
        "term": {
          "views": 123
        }
      }
    }
  }
}
'

{
  "took" : 30,
  "timed_out" : false,
  "_shards" : {
    "total" : 5,
    "successful" : 5,
    "skipped" : 0,
    "failed" : 0
  },
  "hits" : {
    "total" : 1,
    "max_score" : 1.0,
    "hits" : [
      {
        "_index" : "website",
        "_type" : "blog",
        "_id" : "123",
        "_score" : 1.0,
        "_source" : {
          "title" : "标题123",
          "text" : "内容123",
          "views" : 123,
          "tags" : [
            "标签122",
            "标签133"
          ]
        }
      }
    ]
  }
}
```

### 2、多条件查询

- `must` 所有的语句都 必须（must） 匹配，与 `AND` 等价。
- `must_not` 所有的语句都 不能（must not） 匹配，与 `NOT` 等价。
- `should` 至少有一个语句要匹配，与 `OR` 等价。

```sql
select * from blog where views=123 and text="内容123"
```

```bash
curl -XGET "http://localhost:9200/website/blog/_search?pretty" -H 'Content-Type:application/json' -d '
{
  "query": {
    "bool": {
      "must": [
        {"term": {"views": 123}},
        {"match": {"text": "内容"}}
      ]
    }
  }
}
'

结果同上
```

### 3、范围查询

- `range` 范围
- `gt` 大于
- `gte` 大于等于
- `lt` 小于
- `lte` 小于等于

```sql
select * from blog where views between 100 and 200

```

```bash
curl -XGET "http://localhost:9200/website/blog/_search?pretty" -H 'Content-Type:application/json' -d '
{
  "query": {
    "range": {
      "views": {
        "gte": 100,
        "lte": 200
      }
    }
  }
}
'

结果同上
```

### 4、null处理

- `exists` 存在值 `is not null`
- `missing` 缺失值 `is null`

```bash

curl -XGET "http://localhost:9200/website/blog/_search?pretty" -H 'Content-Type:application/json' -d '
{
  "query": {
    "constant_score": {
      "filter": {
        "exists": {
          "field": "tags"
        }
      },
      "boost": 1.2
    }
  }
}
'

```

### 5、全文搜索

- `match` 匹配，可以多词
- `"operator": "and"` 提高精度
- `"minimum_should_match": "75%"` 控制精度
- `boost` 权重

```sql
select * from blog where title like %标题%
```

```bash
curl -XGET "http://localhost:9200/website/blog/_search?pretty" -H 'Content-Type:application/json' -d '
{
  "query": {
    "match": {
      "title": "标题 2",
      "operator": "and",
      "minimum_should_match": "75%"
    }
  }
}
'

```

Elasticsearch 执行上面这个 match 查询的步骤是：

> 检查字段类型

标题 title 字段是一个 `text` 类型（ analyzed ）已分析的全文字段，这意味着查询字符串本身也应该被分析

> 分析查询字符串

将查询的字符串 `标题` 传入标准分析器中，输出的结果是单个项 `标题` 。因为只有一个单词项，所以 match 查询执行的是单个底层 term 查询

> 查找匹配文档

用 term 查询在倒排索引中查找 `标题` 然后获取一组包含该项的文档

> 为每个文档评分

用 term 查询计算每个文档相关度评分 _score ，这是种将 词频（term frequency，即词 `标题` 在相关文档的 title 字段中出现的频率）和反向文档频率（inverse document frequency，即词 `标题` 在所有文档的 title 字段中出现的频率），以及字段的长度（即字段越短相关度越高）相结合的计算方式

## 参考

[Elasticsearch: 权威指南](https://www.elastic.co/guide/cn/elasticsearch/guide/current/index.html)