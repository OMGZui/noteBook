# docker

<!-- TOC -->

- [docker](#docker)
    - [什么是docker](#什么是docker)
    - [安装docker](#安装docker)
    - [基本概念](#基本概念)
        - [镜像](#镜像)
        - [容器](#容器)
        - [数据卷](#数据卷)
        - [挂载](#挂载)
    - [Dockerfile定制镜像](#dockerfile定制镜像)
    - [docker-compose](#docker-compose)
    - [实践](#实践)
    - [参考资料](#参考资料)

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

其它系统可以参考 `http://docker_practice.gitee.io/install/`

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

# 镜像占用
docker system df

# 清楚悬挂镜像
docker image prune

# 删除镜像
docker image rm

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
docker container logs

# 终止容器
docker container stop

# 启动容器
docker container start

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

```bash
# 版本2
version: "2"

# 服务
services:
  # 应用
  applications:
    image: tianon/true
    volumes:
        - ${APPLICATION}:/var/www
  # 工作空间
  workspace:
    build:
      context: ./workspace
      args:
        - WORKSPACE_SSH_PORT=${WORKSPACE_SSH_PORT}
        - INSTALL_IMAP=${WORKSPACE_INSTALL_IMAP}
        - INSTALL_XDEBUG=${WORKSPACE_INSTALL_XDEBUG}
        - INSTALL_WORKSPACE_SSH=${WORKSPACE_INSTALL_WORKSPACE_SSH}
        - INSTALL_MONGO=${WORKSPACE_INSTALL_MONGO}
        - INSTALL_PHPREDIS=${WORKSPACE_INSTALL_PHPREDIS}
        - INSTALL_IMAGEMAGICK=${WORKSPACE_INSTALL_IMAGEMAGICK}
      dockerfile: "Dockerfile-${PHP_VERSION}"
    volumes_from:
      - applications
    extra_hosts:
      - "dockerhost:${DOCKER_HOST_IP}"
    ports:
      - "${WORKSPACE_SSH_PORT}:22"
    tty: true
    networks:
      - frontend
      - backend
  # php解析器
  php-fpm:
    build:
      context: ./php-fpm
      args:
        - INSTALL_XDEBUG=${PHP_FPM_INSTALL_XDEBUG}
        - INSTALL_PHPREDIS=${PHP_FPM_INSTALL_PHPREDIS}
        - INSTALL_SWOOLE=${PHP_FPM_INSTALL_SWOOLE}
        - INSTALL_MONGO=${PHP_FPM_INSTALL_MONGO}
        - INSTALL_ZIP_ARCHIVE=${PHP_FPM_INSTALL_ZIP_ARCHIVE}
        - INSTALL_MEMCACHED=${PHP_FPM_INSTALL_MEMCACHED}
        - INSTALL_EXIF=${PHP_FPM_INSTALL_EXIF}
        - INSTALL_OPCACHE=${PHP_FPM_INSTALL_OPCACHE}
        - INSTALL_MYSQLI=${PHP_FPM_INSTALL_MYSQLI}
        - INSTALL_TOKENIZER=${PHP_FPM_INSTALL_TOKENIZER}
        - INSTALL_IMAGEMAGICK=${PHP_FPM_INSTALL_IMAGEMAGICK}
      dockerfile: "Dockerfile-${PHP_VERSION}"
    volumes_from:
      - applications
    volumes:
      - "./php-fpm/php${PHP_VERSION}.ini:/usr/local/etc/php/php.ini"
    expose:
      - "9000"
    depends_on:
      - workspace
    extra_hosts:
      - "dockerhost:${DOCKER_HOST_IP}"
    environment:
      - "PHP_IDE_CONFIG=${PHP_IDE_CONFIG}"
    networks:
      - backend
  # nginx构建
  nginx:
    build:
      context: ./nginx
    volumes_from:
      - applications
    volumes:
      - "${NGINX_HOST_LOG_PATH}:/var/log/nginx"
      - "${NGINX_SITES_PATH}:/etc/nginx/sites-available"
    ports:
      - "${NGINX_HOST_HTTP_PORT}:80"
      - "${NGINX_HOST_HTTPS_PORT}:443"
    depends_on:
      - php-fpm
    networks:
      - frontend
      - backend
  # mysql构建
  mysql:
    build:
      context: ./mysql
      args:
        - "MYSQL_VERSION=${MYSQL_VERSION}"
    environment:
      - "MYSQL_DATABASE=${MYSQL_DATABASE}"
      - "MYSQL_USER=${MYSQL_USER}"
      - "MYSQL_PASSWORD=${MYSQL_PASSWORD}"
      - "MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD}"
      - "TZ=${WORKSPACE_TIMEZONE}"
    volumes:
      - "${DATA_SAVE_PATH}/mysql:/var/lib/mysql"
    ports:
      - "${MYSQL_PORT}:3306"
    networks:
      - backend
  # mongodb构建
  mongo:
    build: ./mongo
    ports:
      - "${MONGODB_PORT}:27017"
    volumes:
      - "${DATA_SAVE_PATH}/mongo:/data/db"
    networks:
      - backend
  # redis构建
  redis:
    build: ./redis
    volumes:
      - "${DATA_SAVE_PATH}/redis:/data"
    ports:
      - "${REDIS_PORT}:6379"
    networks:
      - backend
  # memcached构建
  memcached:
    build: ./memcached
    volumes:
      - "${DATA_SAVE_PATH}/memcached:/var/lib/memcached"
    ports:
      - "${MEMCACHED_HOST_PORT}:11211"
    depends_on:
      - php-fpm
    networks:
      - backend
  # phpmyadmin构建
  phpmyadmin:
    build: ./phpmyadmin
    environment:
      - PMA_ARBITRARY=1
      - "MYSQL_USER=${PMA_USER}"
      - "MYSQL_PASSWORD=${PMA_PASSWORD}"
      - "MYSQL_ROOT_PASSWORD=${PMA_ROOT_PASSWORD}"
    ports:
      - "${PMA_PORT}:80"
    depends_on:
      - "${PMA_DB_ENGINE}"
    networks:
      - frontend
      - backend

# 网络
networks:
  frontend:
    driver: bridge
  backend:
    driver: bridge

# 数据卷
volumes:
  mysql:
    driver: local
  memcached:
    driver: local
  redis:
    driver: local
  mongo:
    driver: local
  phpmyadmin:
    driver: local

# 参考之https://github.com/laradock/laradock

```

## 参考资料

- [Docker — 从入门到实践](http://docker_practice.gitee.io/)
- [laradock](https://github.com/laradock/laradock)
