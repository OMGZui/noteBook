# HTTP协议

<!-- TOC -->

- [HTTP协议](#http协议)
    - [一、网络基础](#一网络基础)
        - [1、TCP/IP协议族各层作用](#1tcpip协议族各层作用)
            - [应用层](#应用层)
            - [传输层](#传输层)
            - [网络层](#网络层)
            - [链路层](#链路层)
        - [2、TCP/IP 通信传输流](#2tcpip-通信传输流)
        - [3、关系密切的IP、TCP、DNS协议](#3关系密切的iptcpdns协议)
        - [4、URI和URL](#4uri和url)
    - [二、简单的HTTP协议](#二简单的http协议)
        - [1、通过请求和响应的交换达成通信](#1通过请求和响应的交换达成通信)
        - [2、HTTP是一种无状态协议](#2http是一种无状态协议)
        - [3、HTTP方法](#3http方法)
        - [4、持久连接 keep-alive](#4持久连接-keep-alive)
        - [5、cookie](#5cookie)
    - [三、HTTP报文](#三http报文)
    - [四、HTTP状态码](#四http状态码)
    - [五、HTTP协作的Web服务器](#五http协作的web服务器)
        - [1、通信数据转发：代理、网关、隧道](#1通信数据转发代理网关隧道)
        - [2、缓存](#2缓存)
    - [六、HTTP首部](#六http首部)
        - [HTTP首部字段](#http首部字段)

<!-- /TOC -->

## 一、网络基础

### 1、TCP/IP协议族各层作用

#### 应用层

决定了向用户提供应用服务时通信的活动

比如：FTP、DNS、HTTP

#### 传输层

提供数据传输

比如：TCP、UDP

#### 网络层

处理在网络上流动的数据包（网络传输最小单位）

比如IP协议

#### 链路层

用来处理连接网络的硬件部分

### 2、TCP/IP 通信传输流

发送端从应用层往下走，接收端则往应用层往上走

发送端每经过一层打上一个该层的首部信息  -》 封装

接收端每经过一层把首部信息消去

### 3、关系密切的IP、TCP、DNS协议

```sh

IP协议的作用是把各种数据包传送给对方。 IP地址和MAC地址。 ARP协议（解析地址的协议)。

TCP协议把数据准确的传给对方，可以分割大数据。 为了准确传输，采用三次握手策略。

*三次握手
发送端发送一个带有SYN标志的数据包给对方
接收端收到后，回传一个带有SYN/ACK标志的数据包表示确认信息
发送端再回传一个ACK标志的数据包，代表握手结束

DNS服务提供域名到IP地址之间的解析服务  发送端发送http://t66y.com/，DNS解析对应一个IP地址，然后访问服务器

```

### 4、URI和URL

http://t66y.com/index.php  => URI  定位资源

http://t66y.com/ => URL

## 二、简单的HTTP协议

客户端：请求访问文本或图像等资源的一端
服务端：提供资源响应的一端

### 1、通过请求和响应的交换达成通信

请求报文是由请求方法、请求URI、协议版本、可选的请求首部字段和内容实体构成

响应报文是由协议版本、状态码、状态码的原因短语、可选的响应首部字段和主体构成

### 2、HTTP是一种无状态协议

使用HTTP协议，每当有新的请求发送，就会有新的响应产生

cookie可以保存状态

### 3、HTTP方法

```sh

GET：获取资源
POST：传输实体主体
PUT：传输文件
HEAD：获得报文首部
DELETE：删除文件
OPTIONS：询问支持的方法

```

### 4、持久连接 keep-alive

HTTP/1.1默认持久连接

特点：只要任意一端没有明确提出断开连接，则保持TCP连接状态

好处：减少重复连接和断开的开销，减轻服务器的负载，减少响应时间，提高速度

### 5、cookie

Cookie技术通过在请求和响应报文中写入Cookie信息来控制客户端的状态   Set-Cookie

## 三、HTTP报文

用于HTTP协议交互的信息称为HTTP报文

可以通过压缩来提升传输效率

```sh
请求报文
GET /index.php HTTP/1.1   #请求行
Host: t66y.com
Connection: keep-alive
Cache-Control: max-age=0
Upgrade-Insecure-Requests: 1
User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8
Accept-Encoding: gzip, deflate
Accept-Language: zh-CN,zh;q=0.8
```

```sh
响应报文
HTTP/1.1 200 OK  #状态行
Date: Tue, 17 Oct 2017 12:01:57 GMT
Content-Type: text/html
Content-Length: 4122
Connection: keep-alive
X-Powered-By: PHP/5.3.3
Vary: Accept-Encoding
Content-Encoding: gzip
Server: cloudflare-nginx
CF-RAY: 3af31b2d8039228e-LAX

```

## 四、HTTP状态码

|状态码|英文描述|类别|原因短语|
|--|--|--|--|
|1XX|Informational|信息性|接收的请求正在处理|
|2XX|Success|成功|请求正常处理完毕|
|3XX|Redirection|重定向|需要进行附加操作已完成请求|
|4XX|Client Error|客户端错误|服务器无法处理请求|
|5XX|Server Error|服务器错误|服务器处理请求出错|

常见的状态码：

```sh
200 ok 请求正常，响应信息会随方法不同而不同
204 No Content 响应报文不含实体的主体部分
206 partial Content 范围请求

301 Moved Permanently 永久性重定向
302 Found 临时性重定向
303 See Other GET方法临时重定向
304 Not Modified 服务端资源未改变
307 Temporary Redirect 临时性重定向

400 Bad Request 请求语法错误
401 Unauthorized 认证失败
403 Forbidden 服务器拒绝
404 Not Found 服务器没有请求的资源

500 Internal Server Error 服务器端执行请求错误
503 Server Unavailable 服务器超负载
```

## 五、HTTP协作的Web服务器

虚拟主机：一台服务器为多位客户服务

### 1、通信数据转发：代理、网关、隧道

代理：扮演“中间人”角色，每层代理加上Via首部信息

网关：提供非HTTP协议服务，使得网络通信更加安全

隧道：使用SSL通信，保证安全性

### 2、缓存

服务器端缓存和客户端缓存，目的都是加快请求，具有有效期限

## 六、HTTP首部

### HTTP首部字段

4种：

1.通用首部字段
名字|说明
|--|--|
|Cache-Control|控制缓存行为|
|Connection|逐跳首部、连接的管理|
|Date|创建报文的日期时间|

2.请求首部字段

3.响应首部字段

4.实体首部字段
