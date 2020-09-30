# PHPStorm+Xdebug

<!-- TOC -->

- [PHPStorm+Xdebug](#phpstormxdebug)
    - [一、工具](#一工具)
    - [二、开箱](#二开箱)
        - [1、PHP配置](#1php配置)
        - [2、PHPStorm配置](#2phpstorm配置)
    - [三、成果](#三成果)
    - [四、参考文献](#四参考文献)

<!-- /TOC -->

## 一、工具

- PHPStorm
- brew
- php7.4
- xdebug
- zsh

## 二、开箱

### 1、PHP配置

```bash
# 安装php7.4，替换本地的php
brew install php
echo 'export PATH="/usr/local/opt/php/sbin:$PATH"' >> ~/.zshrc
source ~/.zshrc
# 手动启动
php-fpm -D
# 暴力关闭
killall php-fpm
# 安装xdebug扩展，如果报错，一般是缺少依赖，直接brew install xxx即可
pecl install xdebug
# 查找php.ini，php-cli和php-fpm用的是同一个ini
php --ini
Configuration File (php.ini) Path: /usr/local/etc/php/7.4
Loaded Configuration File:         /usr/local/etc/php/7.4/php.ini
Scan for additional .ini files in: /usr/local/etc/php/7.4/conf.d
Additional .ini files parsed:      /usr/local/etc/php/7.4/conf.d/ext-opcache.ini
# 修改
vim  /usr/local/etc/php/7.4/php.ini
[xdebug]
;我不会告诉你docker这里使用docker.for.mac.localhost
xdebug.remote_host=localhost
xdebug.remote_connect_back=0
;防止端口冲突
xdebug.remote_port=9001
;标识
xdebug.idekey=PHPSTORM
xdebug.remote_autostart=1
xdebug.remote_enable=1
xdebug.cli_color=1
xdebug.profiler_enable=0
xdebug.remote_handler=dbgp
xdebug.remote_mode=req
;确保这个日志文件存在
xdebug.remote_log = /var/log/xdebug.log
xdebug.var_display_max_children=-1
xdebug.var_display_max_data=-1
xdebug.var_display_max_depth=-1
```

### 2、PHPStorm配置

Q: 为什么用PHP Remote Debug

A：可以不用下载浏览器xdebug插件

![从1开始的PHPStorm+Xdebug包搭建不包使用教程](https://cdn.learnku.com/uploads/images/202009/16/5373/UtASCBgToE.png!large)

![从1开始的PHPStorm+Xdebug包搭建不包使用教程](https://cdn.learnku.com/uploads/images/202009/16/5373/8AZHMb1HJr.png!large)

![从1开始的PHPStorm+Xdebug包搭建不包使用教程](https://cdn.learnku.com/uploads/images/202009/16/5373/klP1ujM6YS.png!large)

![从1开始的PHPStorm+Xdebug包搭建不包使用教程](https://cdn.learnku.com/uploads/images/202009/16/5373/P714DLzpMs.png!large)

![从1开始的PHPStorm+Xdebug包搭建不包使用教程](https://cdn.learnku.com/uploads/images/202009/16/5373/LafFFVRZkT.png!large)

## 三、成果

![从1开始的PHPStorm+Xdebug包搭建不包使用教程](https://cdn.learnku.com/uploads/images/202009/16/5373/k648VWBAxH.png!large)

## 四、参考文献

无
