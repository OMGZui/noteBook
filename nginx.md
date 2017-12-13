# nginx


<!-- TOC -->

- [nginx](#nginx)
    - [一、nginx是什么](#一nginx是什么)
    - [二、nginx安装](#二nginx安装)
    - [三、nginx配置](#三nginx配置)
    - [四、nginx使用](#四nginx使用)
        - [1、laravel](#1laravel)
        - [2、react.js](#2reactjs)
    - [五、nginx反向代理和负载均衡](#五nginx反向代理和负载均衡)
        - [1、反向代理](#1反向代理)
        - [2、负载均衡](#2负载均衡)
    - [六、参考资料](#六参考资料)

<!-- /TOC -->

## 一、nginx是什么

Nginx是一个Web服务器，也可以用作反向代理，负载平衡器和 HTTP缓存。该软件由Igor Sysoev 创建，并于2004年首次公开发布。同名公司成立于2011年，以提供支持。 Nginx 是免费的开源软件，根据类似BSD许可证的条款发布

## 二、nginx安装

```sh

# 下载源码包
wget https://nginx.org/download/nginx-1.12.1.tar.gz
# 解压
tar zxvf nginx-1.12.1.tar.gz
# 进入文件
cd nginx-1.12.1
# 编译
./configure
# 安装
make && make install
# 常见错误
./configure: error: C compiler cc is not found
解决：
yum -y install pcre-devel make gcc gcc-c++ ncurses-devel zlib zlib-devel openssl openssl--devel
niginx command not found
解决：
在.bash_profile或.zshrc中加入下面的环境变量
PATH=$PATH:/usr/local/nginx/sbin/nginx
export PATH
然后source .bash_profile
或 source .zshrcs
```

## 三、nginx配置

通用配置

```sh

# 用户
#user  nobody;
# 有1个工作的子进程,可以自行修改,但太大无益,因为要争夺CPU,一般设置为 CPU数*核数
worker_processes  1;

#error_log  logs/error.log;
#error_log  logs/error.log  notice;
#error_log  logs/error.log  info;

pid        logs/nginx.pid;

# 配置nginx连接的特性
events {
    # 一个子进程最大允许连1024个连接
    worker_connections  1024;
}

# 配置http服务器的主要段
http {
    include       mime.types;
    default_type  application/octet-stream;
    # 日志格式
    log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
                      '$status $body_bytes_sent "$http_referer" '
                      '"$http_user_agent" "$http_x_forwarded_for"';
    # 远程IP- 远程用户/用户时间 请求方法(如GET/POST) 请求体body长度 referer来源信息
    # http-user-agent用户代理/蜘蛛 ,被转发的请求的原始IP
    # http_x_forwarded_for:在经过代理时,代理把你的本来IP加在此头信息中,传输你的原始IP

    # 该server的访问日志的文件是logs/access.log,使用的格式”main”格式.
    access_log  logs/access.log  main;

    sendfile        on;
    #tcp_nopush     on;

    #keepalive_timeout  0;
    keepalive_timeout  65;

    #gzip  on;

    # 这是虚拟主机段
    server {
        listen       80;
        server_name  localhost;

        #charset koi8-r;

        #access_log  logs/host.access.log  main;

        location / {
            root   html;
            index  index.html index.htm;
        }

        #error_page  404              /404.html;

        # redirect server error pages to the static page /50x.html
        #
        error_page   500 502 503 504  /50x.html;
        location = /50x.html {
            root   html;
        }

        # proxy the PHP scripts to Apache listening on 127.0.0.1:80
        #
        #location ~ \.php$ {
        #    proxy_pass   http://127.0.0.1;
        #}

        # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
        #
        #location ~ \.php$ {
        #    root           html;
        #    fastcgi_pass   127.0.0.1:9000;
        #    fastcgi_index  index.php;
        #    fastcgi_param  SCRIPT_FILENAME  /scripts$fastcgi_script_name;
        #    include        fastcgi_params;
        #}

        # deny access to .htaccess files, if Apache's document root
        # concurs with nginx's one
        #
        #location ~ /\.ht {
        #    deny  all;
        #}
    }


    # another virtual host using mix of IP-, name-, and port-based configuration
    #
    #server {
    #    listen       8000;
    #    listen       somename:8080;
    #    server_name  somename  alias  another.alias;

    #    location / {
    #        root   html;
    #        index  index.html index.htm;
    #    }
    #}


    # HTTPS server
    #
    #server {
    #    listen       443 ssl;
    #    server_name  localhost;

    #    ssl_certificate      cert.pem;
    #    ssl_certificate_key  cert.key;

    #    ssl_session_cache    shared:SSL:1m;
    #    ssl_session_timeout  5m;

    #    ssl_ciphers  HIGH:!aNULL:!MD5;
    #    ssl_prefer_server_ciphers  on;

    #    location / {
    #        root   html;
    #        index  index.html index.htm;
    #    }
    #}

}
```

## 四、nginx使用

### 1、laravel

```sh
# laravel
server {
  listen 80;
  server_name blog.omgzui.pub;
  access_log /var/log/nginx/blog.omgzui.pub.access.log main;
  error_log /var/log/nginx/blog.omgzui.pub.error.log;
  index index.html index.htm index.php;
  root /var/www/html/;

  location / {
    try_files $uri /index.php$is_args$args;
    index  index.html index.htm index.php;
  }

  location ~ [^/]\.php(/|$) {
    fastcgi_pass   127.0.0.1:9000;
    fastcgi_index  index.php;
    fastcgi_split_path_info ^(.+\.php)(/.*)$;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    fastcgi_param DOCUMENT_ROOT $realpath_root;
    include        fastcgi_params;
  }
}
```

### 2、react.js

```sh
# react
server {
    listen 80;
    server_name react.lumen.omgzui.pub;
    index  index.html;
    root /data/wwwroot/react-lumen/build;
    location / {
        try_files $uri  /index.html;
    }
}
```

## 五、nginx反向代理和负载均衡

### 1、反向代理

- 1、我们这里做个实验

    82端口是我们访问的站点
    把 / 代理到90端口
    把 ~* \.(jpg|jpeg|gif|png) 代理到81端口

- 2、实验结果：我们分别查看3个端口的日志

![](http://omgzui.oss-cn-hangzhou.aliyuncs.com/nginx/82-access.jpg)

![](http://omgzui.oss-cn-hangzhou.aliyuncs.com/nginx/90-access.jpg)

![](http://omgzui.oss-cn-hangzhou.aliyuncs.com/nginx/81-access.jpg)

- 3、实验现象

    82端口日志(82.access.log)请求ip为客户端(client)，处理ip为服务器(server82端口)
    90端口日志(httpd-access_log)请求ip为客户端(server主机ip)，处理ip为服务器(server90端口)
    81端口日志(81.access.log)请求ip为客户端(server主机ip)，处理ip为服务器(server81端口)

- 4、实验结论

虽然我们访问的是82端口，这是我们知晓的，但是服务器背后做了什么呢？在这里nginx服务器把页面代理给了90端口(Apache)，把图片代理给了81端口，最后处理的还是82端口，这些是我们不知情的。

```sh
    # nginx 配置
    server {
        gzip on;
        gzip_comp_level 6;
        gzip_min_length 200;
        gzip_types text/plain application/x-javascript text/css application/xml application/javascript application/json;
        listen 81;
        server_name  104.223.3.138;
        root www/gzip;
        access_log  logs/81.access.log  main;
        error_log   logs/81.error.log ;
        index index.html index.htm index.php;
        location ~ \.php$ {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
         }
    }
    server {
        gzip on;
        gzip_comp_level 6;
        gzip_min_length 200;
        gzip_types text/plain application/x-javascript text/css application/xml application/javascript application/json;
        listen 82;
        server_name  104.223.3.138;
        access_log  logs/82.access.log  main;
        error_log   logs/82.error.log ;
        index index.html index.htm index.php;
        location / {
            proxy_set_header   X-Forwarded-For  $remote_addr;
            proxy_pass http://104.223.3.138:90;
        }
        location ~* \.(jpg|jpeg|gif|png) {
            expires 1d;
            proxy_set_header   X-Forwarded-For  $remote_addr;
            proxy_pass http://104.223.3.138:81;
        }
    }
    # apache 配置
    <VirtualHost 104.223.3.138:90>
        DocumentRoot /usr/local/nginx/www/httpd/
        ServerName 104.223.3.138
        ErrorLog logs/httpd-error_log
        CustomLog logs/httpd-access_log common
    </VirtualHost>
```

### 2、负载均衡

思考上面的图片代理81端口，我们是不是可以用几个端口来代理图片？

- 1、做个实验

    用多个端口来代理图片
    83端口
    84端口

- 2、实验结果：连续刷新4次页面，我们再分别查看83、84两个端口的日志

![](http://omgzui.oss-cn-hangzhou.aliyuncs.com/nginx/83-84-access.jpg)

- 3、实验现象

    第一次访问了83端口
    第二次访问了84端口
    第三次访问了83端口
    第四次访问了84端口
    。。。

- 4、实验结论

我们看到的现象是两个端口轮流访问，我们用的是nginx默认的算法，没有用比如一致性哈希这样的算法，说明是可以用多个端口来代理图片，nginx有自己的负载均衡算法分配访问端口。

```sh
    upstream imgserver {
        server 104.223.3.138:83 weight=1 max_fails=2 fail_timeout=3;
        server 104.223.3.138:84 weight=1 max_fails=2 fail_timeout=3;
    }
    server {
        listen 83;
        server_name 104.223.3.138;
        root www;
        access_log logs/83.access.log main;
        error_log   logs/84.error.log ;
    }
    server {
        listen 84;
        server_name 104.223.3.138;
        root www;
        access_log logs/84.access.log main;
        error_log   logs/84.error.log ;
    }

    server {
        gzip on;
        gzip_comp_level 6;
        gzip_min_length 200;
        gzip_types text/plain application/x-javascript text/css application/xml application/javascript application/json;
        listen 82;
        server_name  104.223.3.138;
        access_log  logs/82.access.log  main;
        error_log   logs/82.error.log ;
        index index.html index.htm index.php;
        location / {
            proxy_set_header   X-Forwarded-For  $remote_addr;
            proxy_pass http://104.223.3.138:90;
        }
        location ~* \.(jpg|jpeg|gif|png) {
            expires 1d;
            proxy_set_header   X-Forwarded-For  $remote_addr;
            proxy_pass http://imgserver;
        }
    }
```

## 六、参考资料
