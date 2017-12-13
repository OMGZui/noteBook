# linux


<!-- TOC -->

- [linux](#linux)
    - [一、linux简介](#一linux简介)
    - [二、linux与windows对比](#二linux与windows对比)
    - [三、在vps中使用linux](#三在vps中使用linux)
        - [1、换源](#1换源)
        - [2、查看系统使用的Linux版本](#2查看系统使用的linux版本)
        - [3、配置防火墙 iptables](#3配置防火墙-iptables)
        - [4、配置远程连接 ssh](#4配置远程连接-ssh)
        - [5、清除登录日志](#5清除登录日志)
        - [6、查看linux上启动的服务](#6查看linux上启动的服务)
    - [四、linux服务器部署](#四linux服务器部署)
    - [五、参考资料](#五参考资料)

<!-- /TOC -->

## 一、linux简介

Linux（聆听i/ˈlɪnəks/ lin-əks）是一种自由和开放源码的类UNIX作业系统。目前运用领域最广泛、使用人数最多的操作系统。该操作系统的内核由林纳斯·托瓦兹在1991年10月5日首次发布。在加上使用者空间的应用程式之后，成为Linux作业系统。Linux也是自由软件和开放源代码软件发展中最著名的例子。只要遵循GNU通用公共许可证，任何个人和机构都可以自由地使用Linux的所有底层源代码，也可以自由地修改和再发布。大多数Linux系统还包括像提供GUI的X Window之类的程序。除了一部分专家之外，大多数人都是直接使用Linux发行版，而不是自己选择每一样组件或自行设置。

## 二、linux与windows对比

- linux免费开源，windows商业付费
- linux操作复杂，windows操作简单
- linux适合程序员开发，windows适合一般人员
- linux相对更安全高效

## 三、在vps中使用linux

centos6 为例

### 1、换源

```sh

mv /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.backup
wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.163.com/.help/CentOS6-Base-163.repo
yum clean all
yum update

```

### 2、查看系统使用的Linux版本

```sh

# 内核版本
cat /proc/version
# 发行版本
cat /etc/redhat-release

```

### 3、配置防火墙 iptables

```sh

# 保存至 /etc/sysconfig/iptables
/etc/rc.d/init.d/iptables save
# 写入规则
# ssh服务器
iptables -A INPUT -p tcp --dport 22 -j ACCEPT
# ftp服务器
iptables -A INPUT -p tcp --dport 21 -j ACCEPT
# web服务器
iptables -A INPUT -p tcp --dport 80 -j ACCEPT
# mysql服务器
iptables -A INPUT -p tcp --dport 3306 -j ACCEPT
# 邮件服务器
iptables -A INPUT -p tcp --dport 25 -j ACCEPT
iptables -A INPUT -p tcp --dport 110 -j ACCEPT
# DNS服务器
iptables -A INPUT -p tcp --dport 53 -j ACCEPT
# redis服务器
iptables -A INPUT -p tcp --dport 6379 -j ACCEPT
# 保存
/etc/rc.d/init.d/iptables save
# 重启
service iptables restart

```

### 4、配置远程连接 ssh

```sh

vim /etc/ssh/sshd_config
# 禁止root登陆
    #PermitRootLogin yes  => PermitRootLogin no
# 修改端口号
    #Port 22 => Port 1657
service sshd restart

```

### 5、清除登录日志

```sh

# 用户最近登录信息的命令
last命令，对应的日志文件/var/log/wtmp； 成功登录用户
lastb命令，对应的日志文件/var/log/btmp； 尝试登录信息
lastlog命令，对应的日志文件/var/log/lastlog； 显示最近登录信息

# 清空日志文件
echo > /var/log/wtmp
echo > /var/log/btmp
echo > /var/log/lastlog

清除Bash历史

# 清除当前登录session的历史
history -r
# 清除所有历史
history -cw

```

### 6、查看linux上启动的服务

```sh

# 查看系统运行的进程
ps aux

# 查看系统监听的服务
netstat -antp

# 查看当前所有服务的状态
service  --status-all

```

## 四、linux服务器部署

## 五、参考资料
