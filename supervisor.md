# supervisor

<!-- TOC -->

- [supervisor](#supervisor)
    - [零、supervisor是什么](#零supervisor是什么)
    - [一、安装](#一安装)
    - [二、配置](#二配置)
    - [三、管理服务](#三管理服务)
        - [1、管理php-fpm](#1管理php-fpm)
        - [2、管理nginx](#2管理nginx)
    - [四、supervisorctl](#四supervisorctl)
    - [五、参考资料](#五参考资料)

<!-- /TOC -->

## 零、supervisor是什么

Supervisor是用Python开发的一套通用的进程管理程序，能将一个普通的命令行进程变为后台daemon，并监控进程状态，异常退出时能自动重启。它是通过fork/exec的方式把这些被管理的进程当作supervisor的子进程来启动，这样只要在supervisor的配置文件中，把要管理的进程的可执行文件的路径写进去即可。也实现当子进程挂掉的时候，父进程可以准确获取子进程挂掉的信息的，可以选择是否自己启动和报警。

## 一、安装

```bash
apt -y install supervisor
yum -y install supervisor
```

## 二、配置

```bash
[unix_http_server]
file=/var/run/supervisor.sock
chmod=0700

[inet_http_server]
port=0.0.0.0:7020
username=root
password=xxxxxx

[supervisord]
logfile=/var/log/supervisor/supervisord.log
pidfile=/var/run/supervisord.pid
childlogdir=/var/log/supervisor

[rpcinterface:supervisor]
supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface

[supervisorctl]
serverurl=unix:///var/run/supervisor.sock

[include]
files = /etc/supervisor/conf.d/*.conf

```

## 三、管理服务

- 需要前台运行交于supervisor控制，原理是fork一个守护进程进行监控
- program 标识，比如php-fpm，可以在后台supervisorctl中进行start/stop/restart操作
- command 命令，需要加上sleep 1，防止进程还没退出supervisor就去检测，还挺好用

### 1、管理php-fpm

```bash
[program:php-fpm]
command=bash -c "sleep 1 && sudo /usr/local/php7.4/sbin/php-fpm"
process_name=%(program_name)s
autostart=true
autorestart=true
startretries=5
exitcodes=0,2,70
stopsignal=QUIT
stopwaitsecs=2
stdout_logfile=/var/log/supervisor/php-fpm.log
```

```bash
ps -ef|grep php-fpm
root     23034 22175  0 23:37 ?        00:00:00 sudo /usr/local/php7.4/sbin/php-fpm
root     23043 23034  0 23:37 ?        00:00:00 php-fpm: master process (/usr/local/php7.4/etc/php-fpm.conf)
www-data 23044 23043  0 23:37 ?        00:00:00 php-fpm: pool www
www-data 23045 23043  0 23:37 ?        00:00:00 php-fpm: pool www
```

### 2、管理nginx

```bash
[program:nginx]
command=bash -c "sleep 1 && sudo /usr/local/nginx/sbin/nginx -g 'daemon off;'"
process_name=%(program_name)s
autostart=true
autorestart=true
startretries=5
exitcodes=0,2,70
stopsignal=INT
stopwaitsecs=2
stdout_logfile=/var/log/supervisor/nginx.log
```

```bash
ps -ef|grep nginx
root     22613 22175  0 23:35 ?        00:00:00 sudo /usr/local/nginx/sbin/nginx -g daemon off;
root     22616 22613  0 23:35 ?        00:00:00 nginx: master process /usr/local/nginx/sbin/nginx -g daemon off;
www-data 22617 22616  0 23:35 ?        00:00:00 nginx: worker process
www-data 22618 22616  0 23:35 ?        00:00:00 nginx: worker process
www-data 22619 22616  0 23:35 ?        00:00:00 nginx: worker process
www-data 22620 22616  0 23:35 ?        00:00:00 nginx: worker process
```

## 四、supervisorctl

`supervisorctl`

```bash
supervisor> status
nginx                            RUNNING   pid 22613, uptime 0:03:40
php-fpm                          RUNNING   pid 23034, uptime 0:01:43
supervisor> ?

default commands (type help <topic>):
=====================================
add    exit      open  reload  restart   start   tail
avail  fg        pid   remove  shutdown  status  update
clear  maintail  quit  reread  signal    stop    version

```

## 五、参考资料

[Supervisor使用详解](https://www.jianshu.com/p/0b9054b33db3)