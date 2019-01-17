# docker

<!-- TOC -->

- [docker](#docker)
  - [什么是docker](#%E4%BB%80%E4%B9%88%E6%98%AFdocker)
  - [安装docker](#%E5%AE%89%E8%A3%85docker)
  - [基本概念](#%E5%9F%BA%E6%9C%AC%E6%A6%82%E5%BF%B5)
    - [镜像](#%E9%95%9C%E5%83%8F)
    - [容器](#%E5%AE%B9%E5%99%A8)
    - [数据卷](#%E6%95%B0%E6%8D%AE%E5%8D%B7)
    - [挂载](#%E6%8C%82%E8%BD%BD)
  - [Dockerfile定制镜像](#dockerfile%E5%AE%9A%E5%88%B6%E9%95%9C%E5%83%8F)
  - [docker-compose](#docker-compose)
  - [实践](#%E5%AE%9E%E8%B7%B5)
  - [参考资料](#%E5%8F%82%E8%80%83%E8%B5%84%E6%96%99)

<!-- /TOC -->

## 什么是docker

|特性|容器|虚拟机|
|-|-|-|
|启动|秒级|分钟级|
|硬盘使用|一般为 MB|一般为 GB|
|性能|接近原生|弱于|
|系统支持量|单机支持上千个容器|一般几十个|

## 安装docker

我自己用的是Docker for Mac

其它系统可以参考 http://docker_practice.gitee.io/install/

## 基本概念

- 镜像（Image）

Docker 镜像是一个特殊的文件系统，除了提供容器运行时所需的程序、库、资源、配置等文件外，还包含了一些为运行时准备的一些配置参数（如匿名卷、环境变量、用户等）。镜像不包含任何动态数据，其内容在构建之后也不会被改变。

- 容器（Container）

镜像（Image）和容器（Container）的关系，就像是面向对象程序设计中的 类 和 实例 一样，镜像是静态的定义，容器是镜像运行时的实体。容器可以被创建、启动、停止、删除、暂停等。

- 仓库（Repository）

镜像构建完成后，可以很容易的在当前宿主机上运行，但是，如果需要在其它服务器上使用这个镜像，我们就需要一个集中的存储、分发镜像的服务，Docker Registry 就是这样的服务。

一个 Docker Registry 中可以包含多个仓库（Repository）；每个仓库可以包含多个标签（Tag）；每个标签对应一个镜像。

通常，一个仓库会包含同一个软件不同版本的镜像，而标签就常用于对应该软件的各个版本。我们可以通过 <仓库名>:<标签> 的格式来指定具体是这个软件哪个版本的镜像。如果不给出标签，将以 latest 作为默认标签。

### 镜像

```bash
# 获取镜像
docker pull ubuntu:16.04

# 以这个镜像为基础启动并运行一个容器
docker run -it --rm \
    ubuntu:16.04 \
    bash
-it：这是两个参数，一个是 -i：交互式操作，一个是 -t 终端。我们这里打算进入 bash 执行一些命令并查看返回结果，因此我们需要交互式终端。
--rm：这个参数是说容器退出后随之将其删除。默认情况下，为了排障需求，退出的容器并不会立即删除，除非手动 docker rm。我们这里只是随便执行个命令，看看结果，不需要排障和保留结果，因此使用 --rm 可以避免浪费空间。
ubuntu:16.04：这是指用 ubuntu:16.04 镜像为基础来启动容器。
bash：放在镜像名后的是命令，这里我们希望有个交互式 Shell，因此用的是 bash。

# 列出镜像
docker image ls
docker images

# 镜像占用
docker system df

# 清楚悬挂镜像
docker image prune

# 删除镜像
docker image rm
docker rmi

# 批量删除
docker image rm $(docker image ls -q redis)
docker image rm $(docker image ls -q -f before=mongo:3.2)

```

### 容器

```bash
# 启动并创建容器
docker run ubuntu

# 进入容器，交互模式
docker run -t -i ubuntu bash

# 运行后就可以通过ID exec进入
docker exec -it dcc12b7c45c5 bash

# 守护状态运行
docker run -d ubuntu /bin/sh -c "while true; do echo hello world; sleep 1; done"

# 查看容器
docker container ls

# 查看容器日志
docker container logs xxx

# 终止容器
docker container stop xxx

# 启动容器
docker container start xxx

# 重启容器
docker container restart

# 进入容器
docker attach

# 执行命令
docker exec -it ID bash

# 导出容器
docker export

# 导入容器
docker import

# 删除容器
docker container rm
docker rm

# 清除所有容器
docker container prune

```

### 数据卷

```bash
# 创建数据卷
docker volume create

# 列出数据卷
docker volume ls

# 删除数据卷
docker volume rm

# 清除没用的数据卷
docker volume prune

```

### 挂载

```bash
--mount

# 栗子
docker run -d -P \
    --name web \
    # -v /src/webapp:/opt/webapp \
    --mount type=bind,source=/src/webapp,target=/opt/webapp \
    training/webapp \
    python app.py

加载主机的 /src/webapp 目录到容器的 /opt/webapp目录

# 查看数据卷
docker volume inspect

```

## Dockerfile定制镜像

```bash
# FROM 指定基础镜像
FROM 镜像

# RUN 执行
RUN <命令>
or
RUN ["可执行文件", "参数1", "参数2"]

RUN echo '<h1>Hello, Docker!</h1>' > /usr/share/nginx/html/index.html

# COPY 复制文件
COPY <源路径>... <目标路径>

# ADD 复制文件或目录，如果是tgz，会被解压缩
ADD <源路径>... <目标路径>

# CMD 容器启动
CMD echo $HOME => CMD [ "sh", "-c", "echo $HOME" ]

# ENTRYPOINT 入口点
ENTRYPOINT ["docker-entrypoint.sh"]
存在 ENTRYPOINT 后，CMD 的内容将会作为参数传给 ENTRYPOINT

# ENV 环境变量
ENV <key> <value>

# ARG 与ENV差不多
ARG 所设置的构建环境的环境变量，在将来容器运行时是不会存在这些环境变量的

# VOLUME 匿名卷
VOLUME ["<路径1>", "<路径2>"...]

# EXPOSE 暴露端口
EXPOSE <端口1> [<端口2>...]

# WOEKDIR 指定工作目录
WORKDIR <工作目录路径>

# USER 指定当前用户
USER <用户名>

```

## docker-compose

- 服务 (service)：一个应用的容器，实际上可以包括若干运行相同镜像的容器实例。

- 项目 (project)：由一组关联的应用容器组成的一个完整业务单元，在 docker-compose.yml 文件中定义。

## 实践

[docker-php](https://github.com/OMGZui/docker-php)

docker-compose.yml

```yml
version: '3'

networks:
  frontend:
    driver: ${NETWORKS_DRIVER}
  backend:
    driver: ${NETWORKS_DRIVER}

volumes:
  mysql:
    driver: ${VOLUMES_DRIVER}
  redis:
    driver: ${VOLUMES_DRIVER}
  mongo:
    driver: ${VOLUMES_DRIVER}

services:

### Workspace Utilities ##################################
    workspace:
      build:
        context: ./workspace
        args:
          - LARADOCK_PHP_VERSION=${PHP_VERSION}
          - INSTALL_MONGO=${WORKSPACE_INSTALL_MONGO}
          - INSTALL_PHPREDIS=${WORKSPACE_INSTALL_PHPREDIS}
          - INSTALL_NODE=${WORKSPACE_INSTALL_NODE}
          - NPM_REGISTRY=${WORKSPACE_NPM_REGISTRY}
          - COMPOSER_GLOBAL_INSTALL=${WORKSPACE_COMPOSER_GLOBAL_INSTALL}
          - COMPOSER_REPO_PACKAGIST=${WORKSPACE_COMPOSER_REPO_PACKAGIST}
          - INSTALL_SWOOLE=${WORKSPACE_INSTALL_SWOOLE}
          - PUID=${WORKSPACE_PUID}
          - PGID=${WORKSPACE_PGID}
          - TZ=${WORKSPACE_TIMEZONE}
      volumes:
        - ${APP_CODE_PATH_HOST}:${APP_CODE_PATH_CONTAINER}
      ports:
        - "${WORKSPACE_SSH_PORT}:22"
      tty: true
      environment:
        - PHP_IDE_CONFIG=${PHP_IDE_CONFIG}
      networks:
        - frontend
        - backend

### PHP-FPM ##############################################
    php-fpm:
      build:
        context: ./php-fpm
        args:
          - LARADOCK_PHP_VERSION=${PHP_VERSION}
          - INSTALL_MONGO=${PHP_FPM_INSTALL_MONGO}
          - INSTALL_PHPREDIS=${PHP_FPM_INSTALL_PHPREDIS}
          - INSTALL_OPCACHE=${PHP_FPM_INSTALL_OPCACHE}
          - INSTALL_SWOOLE=${PHP_FPM_INSTALL_SWOOLE}
          - INSTALL_IMAGE_OPTIMIZERS=${PHP_FPM_INSTALL_IMAGE_OPTIMIZERS}
          - INSTALL_IMAGEMAGICK=${PHP_FPM_INSTALL_IMAGEMAGICK}
      volumes:
        - ./php-fpm/php${PHP_VERSION}.ini:/usr/local/etc/php/php.ini
        - ${APP_CODE_PATH_HOST}:${APP_CODE_PATH_CONTAINER}
      expose:
        - "9000"
      environment:
        - PHP_IDE_CONFIG=${PHP_IDE_CONFIG}
      depends_on:
        - workspace
      networks:
        - backend

### NGINX Server #########################################
    nginx:
      build:
        context: ./nginx
        args:
          - PHP_UPSTREAM_CONTAINER=${NGINX_PHP_UPSTREAM_CONTAINER}
          - PHP_UPSTREAM_PORT=${NGINX_PHP_UPSTREAM_PORT}
          - CHANGE_SOURCE=${CHANGE_SOURCE}
      volumes:
        - ${APP_CODE_PATH_HOST}:${APP_CODE_PATH_CONTAINER}
        - ${NGINX_HOST_LOG_PATH}:/var/log/nginx
        - ${NGINX_SITES_PATH}:/etc/nginx/sites-available
        - ${NGINX_SSL_PATH}:/etc/nginx/ssl
      ports:
        - "${NGINX_HOST_HTTP_PORT}:80"
        - "${NGINX_HOST_HTTPS_PORT}:443"
      depends_on:
        - php-fpm
      networks:
        - frontend
        - backend

### MySQL ################################################
    mysql:
      build:
        context: ./mysql
        args:
          - MYSQL_VERSION=${MYSQL_VERSION}
      environment:
        - MYSQL_DATABASE=${MYSQL_DATABASE}
        - MYSQL_USER=${MYSQL_USER}
        - MYSQL_PASSWORD=${MYSQL_PASSWORD}
        - MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD}
        - TZ=${WORKSPACE_TIMEZONE}
      volumes:
        - ${DATA_PATH_HOST}/mysql:/var/lib/mysql
        - ${MYSQL_ENTRYPOINT_INITDB}:/docker-entrypoint-initdb.d
      ports:
        - "${MYSQL_PORT}:3306"
      networks:
        - backend

### MongoDB ##############################################
    mongo:
      build: ./mongo
      ports:
        - "${MONGODB_PORT}:27017"
      volumes:
        - ${DATA_PATH_HOST}/mongo:/data/db
      networks:
        - backend

### Redis ################################################
    redis:
      build: ./redis
      volumes:
        - ${DATA_PATH_HOST}/redis:/data
      ports:
        - "${REDIS_PORT}:6379"
      networks:
        - backend


# 参考之https://github.com/laradock/laradock

```

.env

```.env
APP_CODE_PATH_HOST=/Users/shengj/mac/php
APP_CODE_PATH_CONTAINER=/var/www:cached
DATA_PATH_HOST=~/.laradock/data

### Drivers ################################################
VOLUMES_DRIVER=local
NETWORKS_DRIVER=bridge

### Docker compose files ##################################
COMPOSE_FILE=docker-compose.yml
COMPOSE_PATH_SEPARATOR=:
COMPOSE_PROJECT_NAME=laradock

### PHP Version ###########################################
PHP_VERSION=7.2

### PHP Interpreter #######################################
PHP_INTERPRETER=php-fpm

### Docker Host IP ########################################
DOCKER_HOST_IP=10.0.75.1

### Remote Interpreter ####################################
PHP_IDE_CONFIG=serverName=laradock

### Environment ###########################################
CHANGE_SOURCE=true

### WORKSPACE #############################################
WORKSPACE_COMPOSER_GLOBAL_INSTALL=true
WORKSPACE_COMPOSER_REPO_PACKAGIST=https://packagist.laravel-china.org
WORKSPACE_INSTALL_NODE=true
WORKSPACE_NODE_VERSION=node
WORKSPACE_NPM_REGISTRY=https://registry.npm.taobao.org
WORKSPACE_INSTALL_PHPREDIS=true
WORKSPACE_INSTALL_MONGO=true
WORKSPACE_INSTALL_SWOOLE=true
WORKSPACE_PUID=1000
WORKSPACE_PGID=1000
WORKSPACE_TIMEZONE=PRC
WORKSPACE_SSH_PORT=2222

### PHP_FPM ###############################################
PHP_FPM_INSTALL_ZIP_ARCHIVE=true
PHP_FPM_INSTALL_BCMATH=true
PHP_FPM_INSTALL_MYSQLI=true
PHP_FPM_INSTALL_INTL=true
PHP_FPM_INSTALL_IMAGEMAGICK=false
PHP_FPM_INSTALL_OPCACHE=true
PHP_FPM_INSTALL_IMAGE_OPTIMIZERS=false
PHP_FPM_INSTALL_PHPREDIS=true
PHP_FPM_INSTALL_MONGO=true
PHP_FPM_INSTALL_SWOOLE=true

### NGINX #################################################
NGINX_HOST_HTTP_PORT=80
NGINX_HOST_HTTPS_PORT=443
NGINX_HOST_LOG_PATH=./logs/nginx/
NGINX_SITES_PATH=./nginx/sites/
NGINX_PHP_UPSTREAM_CONTAINER=php-fpm
NGINX_PHP_UPSTREAM_PORT=9000
NGINX_SSL_PATH=./nginx/ssl/

### MYSQL #################################################
MYSQL_VERSION=5.5
MYSQL_DATABASE=default
MYSQL_USER=default
MYSQL_PASSWORD=secret
MYSQL_PORT=3306
MYSQL_ROOT_PASSWORD=root
MYSQL_ENTRYPOINT_INITDB=./mysql/docker-entrypoint-initdb.d

### REDIS #################################################
REDIS_PORT=6379

### MONGODB ###############################################
MONGODB_PORT=27017
```

## 参考资料

- [Docker — 从入门到实践](http://docker_practice.gitee.io/)
- [laradock](https://github.com/laradock/laradock)
