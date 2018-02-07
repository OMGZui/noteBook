# TCP/IP协议

<!-- TOC -->

- [TCP/IP协议](#tcpip协议)
    - [一、网络基础知识](#一网络基础知识)
        - [1、背景](#1背景)
        - [2、7个阶段](#27个阶段)
        - [3、协议](#3协议)
        - [4、协议标准化](#4协议标准化)
        - [5、协议分层和OSI参考模型](#5协议分层和osi参考模型)
            - [1、协议分层](#1协议分层)
            - [2、OSI参考模型](#2osi参考模型)
        - [6、参考模型通信处理举例](#6参考模型通信处理举例)
        - [7、传输方式的分类](#7传输方式的分类)
        - [8、地址](#8地址)
        - [9、网络的构成要素](#9网络的构成要素)
    - [二、TCP/IP基础知识](#二tcpip基础知识)
        - [1、TCP/IP与OSI分层模型](#1tcpip与osi分层模型)
        - [2、TCP/IP分层模型与通信示例](#2tcpip分层模型与通信示例)
    - [三、数据链路](#三数据链路)
        - [1、Mac地址](#1mac地址)
        - [2、半双工与全双工](#2半双工与全双工)
        - [3、以太网帧格式](#3以太网帧格式)
        - [4、无线通信](#4无线通信)
    - [四、IP协议](#四ip协议)
        - [1、IP基础知识](#1ip基础知识)
        - [2、IP地址基础知识](#2ip地址基础知识)
        - [3、IPv6](#3ipv6)
    - [五、IP协议相关技术](#五ip协议相关技术)
        - [1、DNS](#1dns)
        - [2、ARP](#2arp)
        - [3、ICMP](#3icmp)
        - [4、DHCP](#4dhcp)
    - [六、TCP与UDP](#六tcp与udp)
        - [1、TCP](#1tcp)
        - [2、UDP](#2udp)
        - [3、端口号](#3端口号)
    - [七、路由协议](#七路由协议)
    - [八、应用协议](#八应用协议)
        - [1、远程登录](#1远程登录)
            - [1、TELNET](#1telnet)
            - [2、SSH](#2ssh)
        - [2、文件传输](#2文件传输)
        - [3、电子邮件](#3电子邮件)
        - [4、WWW](#4www)
    - [九、网络安全](#九网络安全)
        - [1、防火墙](#1防火墙)
        - [2、VPN](#2vpn)
    - [十、参考资料](#十参考资料)

<!-- /TOC -->

## 一、网络基础知识

### 1、背景

独立模式->网络互连模式

计算机网络，根据规模分为广域网WAN（Wide Area Network）和局域网LAN（Local Area Network）

### 2、7个阶段

- 批处理系统 Batch Processing
  - 事先将用户程序和数据装入卡带或磁带，1950年
- 分时系统 Time Sharing System
  - 允许多个用户同时操作一台计算机，研究机关，1960年
- 计算机之间的通信
  - 计算机性能提升、体积小型化、价格下降，一般企业开始使用，1970年
- 计算机网络的产生
  - 窗口系统的诞生，个人，下载，邮件，1980年
- 互联网的普及
  - 一人一机，万维网WWW（World Wide Web），1990年
- 以互联网技术为中心的时代
  - IP（Internet Protocol）诞生，2000年
- TCP/IP
  - 互联网是由许多独立发展的网络通信技术融合而成，2010年

### 3、协议

大部分常见的协议都属于TCP/IP协议

简单说，协议就是计算机与计算机之间通过网络实现通信时事先达成的一种**约定**，相同的协议才能相互通信

![](public/img/tcp-ip/protocol.jpg)

分组交换协议是指将大数据分割为一个个包（Packet）的较小单位进行传输

![](public/img/tcp-ip/packet.jpg)

### 4、协议标准化

国际标准化组织ISO（International Origanizion for Standards）
制定了
开放式通信系统互联参考模型OSI（Open Systems Interconnection）

### 5、协议分层和OSI参考模型

#### 1、协议分层

- 分层的优点：可扩展性和灵活性
- 分层的缺点：每个模块不得不实现相似的处理逻辑

#### 2、OSI参考模型

7个分层
![](public/img/tcp-ip/open.jpg)

7个分层对应的作用
![](public/img/tcp-ip/use.jpg)

### 6、参考模型通信处理举例

略

### 7、传输方式的分类

- 面向有连接型与面向无连接型

![](public/img/tcp-ip/link.jpg)

- 电路交换与分组交换

![](public/img/tcp-ip/exchange.jpg)

- 根据接收端数量分类

这里截图有误，右上应该是广播
![](public/img/tcp-ip/cast.jpg)

### 8、地址

- 唯一性
- 层次性

![](public/img/tcp-ip/layer.jpg)

### 9、网络的构成要素

![](public/img/tcp-ip/network.jpg)

- 通信媒介与数据链路
  - 计算机通过电缆相互连接
  - 媒介是电磁波
- 网卡
  - 网络接口器NIC（Network Information Center）
- 中继器Repeater
  - 属于OSI第一层--物理层
- 网桥/2层交换机
  - 属于OSI第二层--数据链路层
- 路由器/3层交换机
  - 属于OSI第三层--网络层
- 4~7层交换机
  - 负责处理传输层到应用层的数据，比如防火墙
- 网关
  - 负责传输层到应用层的数据进行转换和转发，比如代理服务器

## 二、TCP/IP基础知识

### 1、TCP/IP与OSI分层模型

![](public/img/tcp-ip/osi.jpg)

### 2、TCP/IP分层模型与通信示例

![](public/img/tcp-ip/data-head.jpg)

## 三、数据链路

### 1、Mac地址

- 用于识别数据链路中互联的节点
- 长48比特
- 使用网卡的情况下，会烧入到ROM中，是唯一的

### 2、半双工与全双工

- 半双工：只发送或接收
- 全双工：既可以发送数据也可以接收数据

### 3、以太网帧格式

![](public/img/tcp-ip/frame.jpg)

### 4、无线通信

![](public/img/tcp-ip/wifi.jpg)

## 四、IP协议

### 1、IP基础知识

- 属于网络层
- 主要由IP和ICMP组成
- IPv4和IPv6
- IP三大作用块：IP寻址、路由、IP分包组包
- IP属于面向无连接型：一是为了简化，二是为了提速

### 2、IP地址基础知识

- IP地址由网络地址和主机地址组成

![](public/img/tcp-ip/ip.jpg)

### 3、IPv6

![](public/img/tcp-ip/ipv6.jpg)

## 五、IP协议相关技术

### 1、DNS

- DNS（Domain Name System）
- 系统为了自动将主机名转换为具体的IP地址，用了一个叫做hosts的数据库文件

![](public/img/tcp-ip/dns.jpg)

- 域名 -> t66y.com

![](public/img/tcp-ip/t66y.jpg)

### 2、ARP

- ARP（Address Resolution Protocol）

从一个IP地址发送ARP请求包以了解其MAC地址，目标地址将自己的MAC地址填入其中的ARP响应包返回到IP地址，因此可以通过ARP从IP地址中获得MAC地址，实现链路内的IP通信

![](public/img/tcp-ip/arp.jpg)

- RARP

![](public/img/tcp-ip/rarp.jpg)

### 3、ICMP

- 确认IP包是否成功送达目标地址
- 通知在发送过程当中IP包被废弃的原因
- 改善网络设置

### 4、DHCP

- DHCP（Dynamic Host Configuration Protocol）

![](public/img/tcp-ip/dhcp.jpg)

## 六、TCP与UDP

- 属于传输层
- IP首部有个协议字段，用来标识网络层的上一层所采用的是哪一种传输层协议（TCP、UDP）

### 1、TCP

![](public/img/tcp-ip/tcp.jpg)

- TCP是面向连接的、可靠的流协议
- 流是不间断的数据结构
- 将部分控制转移给其他程序去处理，自己只提供作为传输层协议的最基本功能
- 可以进行丢包重发
- 只有确认通信对端存在时才会发送数据
- 三次握手，四次挥手

![](public/img/tcp-ip/syn.jpg)

- 窗口控制
- 重发控制
- 流控制
- 拥塞控制

### 2、UDP

![](public/img/tcp-ip/udp.jpg)

- UDP是不具有可靠性的数据协议
- 包总量较小的通信，比如DNS、SNMP
- 视频、音频等多媒体通信
- 限定于LAN特定网络通信
- 广播通信

![](public/img/tcp-ip/diff.jpg)

### 3、端口号

- 端口号用来识别同一台计算机进行通信的不同应用程序

![](public/img/tcp-ip/port.jpg)

## 七、路由协议

略

## 八、应用协议

### 1、远程登录

为了实现分时系统TSS环境

#### 1、TELNET

利用TCP的一条连接，向主机发送文字命令并在主机上执行

![](public/img/tcp-ip/telnet.jpg)

#### 2、SSH

加密的远程登录系统，相比TELNET

- 可以使用更强的认证机制
- 可以转发文件
- 可以使用端口转发功能

![](public/img/tcp-ip/ssh.jpg)

### 2、文件传输

FTP利用两天TCP连接进行文件传输

- 一条用来控制
- 一条用来数据传输

### 3、电子邮件

- SMTP协议事项邮件发送，属于TCP协议
- 包括邮件地址、数据格式、发送协议
- POP用于接收电子邮件
- IMAP同样用于接收电子邮件，由服务器管理

### 4、WWW

略

## 九、网络安全

### 1、防火墙

为了避免域内受到非法访问，过滤非法的数据包，比如`防火长城GFW（Great Firewall of China）`

### 2、VPN

- IPsec 网络层
- PPTP 传输层
- SOCKS V5 应用层

## 十、参考资料

[图解TCP/IP](https://book.douban.com/subject/24737674/)