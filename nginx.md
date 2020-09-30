# nginx

<!-- TOC -->

- [nginx](#nginx)
    - [一、nginx是什么](#一nginx是什么)
    - [二、nginx安装](#二nginx安装)
        - [apt/yum](#aptyum)
        - [源码安装](#源码安装)
    - [三、nginx配置](#三nginx配置)
    - [四、nginx使用](#四nginx使用)
        - [1、laravel](#1laravel)
        - [2、react](#2react)
    - [五、nginx反向代理和负载均衡](#五nginx反向代理和负载均衡)
        - [1、反向代理](#1反向代理)
        - [2、负载均衡](#2负载均衡)
    - [六、一些指令解释](#六一些指令解释)
        - [1、try_files](#1try_files)
        - [2、fastcgi](#2fastcgi)
    - [七、参考资料](#七参考资料)

<!-- /TOC -->

## 一、nginx是什么

Nginx是一个Web服务器，也可以用作反向代理，负载平衡器和 HTTP缓存。该软件由Igor Sysoev 创建，并于2004年首次公开发布。同名公司成立于2011年，以提供支持。 Nginx 是免费的开源软件，根据类似BSD许可证的条款发布

## 二、nginx安装

### apt/yum

```sh
apt -y install nginx
yum -y install nginx
```

### 源码安装

```sh
./configure --prefix=/usr/local/nginx \
--user=www-data \
--group=www-data \
--sbin-path=/usr/local/nginx/sbin/nginx \
--modules-path=/usr/local/nginx/modules \
--conf-path=/usr/local/nginx/conf/nginx.conf \
--http-log-path=/usr/local/nginx/logs/access.log \
--error-log-path=/usr/local/nginx/logs/error.log \
--pid-path=/usr/local/nginx/logs/nginx.pid \
--with-http_ssl_module \
--with-http_v2_module \
--with-http_stub_status_module \
--with-http_realip_module \
--with-threads \
--with-http_gunzip_module \
--with-http_gzip_static_module \
--with-http_image_filter_module=dynamic \
--http-client-body-temp-path=/usr/local/nginx/body \
--http-fastcgi-temp-path=/usr/local/nginx/fastcgi \
--http-proxy-temp-path=/usr/local/nginx/proxy \
--http-scgi-temp-path=/usr/local/nginx/scgi \
--http-uwsgi-temp-path=/usr/local/nginx/uwsgi \
--with-mail=dynamic \
--with-mail_ssl_module \
--with-stream=dynamic \
--with-stream_ssl_module \
--with-stream_geoip_module \
--with-stream_geoip_module=dynamic \
--add-module=/usr/local/nginx/parts \
--add-dynamic-module=/usr/local/nginx/dynamic \
--with-pcre-jit \
--with-debug
```

## 三、nginx配置

通用配置

```sh
user www-data;
worker_processes 4;
worker_rlimit_nofile 65535;
pid /run/nginx.pid;
include /etc/nginx/modules-enabled/*.conf;

events {
    use epoll;
    worker_connections 65535;
    # multi_accept on;
}

http {
    ##
    # Basic Settings
    ##
    sendfile on;
    tcp_nopush on;
    tcp_nodelay on;
    keepalive_timeout 0;
    types_hash_max_size 2048;
    # server_tokens off;

    # server_names_hash_bucket_size 64;
    # server_name_in_redirect off;

    include /etc/nginx/mime.types;
    default_type application/octet-stream;

    client_max_body_size 50m;
    ##
    # SSL Settings
    ##

    ssl_protocols TLSv1 TLSv1.1 TLSv1.2; # Dropping SSLv3, ref: POODLE
    ssl_prefer_server_ciphers on;

    ##
    # Logging Settings
    ##
    log_format  main  '$http_host $remote_addr - $remote_user [$time_local]"$request"'
                    '$status $body_bytes_sent "$http_referer" '
                    '"$http_user_agent" "$http_x_forwarded_for" '
                    '$request_time $upstream_response_time';

    access_log /var/log/nginx/access.log main;
    error_log /var/log/nginx/error.log;

    ##
    # Gzip Settings
    ##

    gzip on;
    gzip_vary on;
    gzip_proxied any;
    gzip_comp_level 6;
    gzip_buffers 4 16k;
    gzip_http_version 1.1;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;

    ##
    # Virtual Host Configs
    ##

    include /etc/nginx/conf.d/*.conf;
    include /etc/nginx/sites-enabled/*;
}
```

## 四、nginx使用

### 1、laravel

```sh
server {
    listen 443 ssl;
    server_name xxxxxx;
    root /var/www/laravel/public;
    index index.php index.html index.htm;

    ssl_certificate  1_xxxxxx_bundle.crt;
    ssl_certificate_key 2_xxxxxx.key;
    ssl_session_timeout 5m;
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    ssl_prefer_server_ciphers on;

    location / {
         try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_buffers 16 16k;
        fastcgi_buffer_size 32k;
        fastcgi_read_timeout 600;
        include fastcgi.conf;
    }
    error_log /var/log/nginx/laravel_error.log;
    access_log /var/log/nginx/laravel_access.log;
}
server {
    listen 80;
    server_name xxxxxx;
    return 301 https://xxxxxx;
}
```

### 2、react

```sh
server {
    listen 80;
    server_name xxxxxx;
    root /var/www/xxxxxx/build;
    index  index.html;
    location / {
        try_files $uri  /index.html;
    }
}
```

## 五、nginx反向代理和负载均衡

### 1、反向代理

比如代理到es服务

```sh
server {
    listen 80;
    server_name xxxxxx;
    location / {
        proxy_pass http://xxxxxx:9200;
        index index.html index.htm;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}
```

### 2、负载均衡

通过 upserver 负载到7001和7002端口，并设置了权重

```sh
upstream upserver {
    server xxxxxx:7001 weight=1;
    server xxxxxx:7002 weight=2;
}

server {
    listen 80;
    server_name xxxxxx;
    index idnex.html;
    location / {
        proxy_pass http://upserver;
    }
}

```

## 六、一些指令解释

### 1、try_files

```bash
root /var/www/laravel/public

try_files $uri $uri/ /index.php$is_args$args;

/index.php指向 location ~ \.php$
$is_args表示请求中的URL是否带参数，如果带参数，$is_args值为"?"，否则为空
$args只接收参数

# 访问php.omgzui.cn/index
1、查找$uri，即index文件 无
2、查找$uri/，即index目录 无
3、查找/index.php$is_args$args，把index当成参数，即index.php?index

最终访问xxxxxx/index.php?index

```

### 2、fastcgi

```bash
# 端口模式
fastcgi_pass 127.0.0.1:9000;
# socket模式，推荐
fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
# include
include fastcgi.conf;
等价于下面
fastcgi_param  SCRIPT_FILENAME    $document_root$fastcgi_script_name;
include fastcgi_params;
```

## 七、参考资料

无
