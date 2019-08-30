# git简明教程

<!-- TOC -->

- [git简明教程](#git简明教程)
    - [一、安装](#一安装)
        - [1、直接安装](#1直接安装)
        - [2、源码安装](#2源码安装)
        - [3、配置](#3配置)
    - [二、初始化](#二初始化)
    - [三、工作流](#三工作流)
    - [四、添加和提交](#四添加和提交)
    - [五、推送改动](#五推送改动)
    - [六、分支](#六分支)
    - [七、更新与合并](#七更新与合并)
    - [八、标签](#八标签)
    - [九、日志](#九日志)
    - [十、版本回退](#十版本回退)
    - [十一、使用技巧](#十一使用技巧)
    - [十二、参考资料](#十二参考资料)

<!-- /TOC -->

## 一、安装

### 1、直接安装

[下载](https://book.git-scm.com/downloads)

### 2、源码安装

```sh

# 下载源码包
wget https://www.kernel.org/pub/software/scm/git/git-2.9.5.tar.gz
# 解压
tar zxvf git-2.9.5
# 依赖包
yum -y install curl-devel expat-devel gettext-devel openssl-devel zlib-devel asciidoc xmlto docbook2x perl-devel
# 进入开始编译
cd git-2.9.5
# 简易安装
./configure --prefix=/usr/local/git && make && make install
# doc一起安装
make configure && ./configure --prefix=/usr/local/git && make all && make install
```

### 3、配置

```sh
# 配置
git config --global user.name "omgzui"
git config --global user.email "862275679@qq.com"
# .ssh
ssh-keygen -t rsa -C "862275679@qq.com"
# 用公钥关联远程仓库
cat .ssh/id_rsa.pub
复制填入对应的git仓库
```

## 二、初始化

```sh

# 初始化仓库
git init
# 克隆仓库
本地克隆
git clone /Users/shengj/mac/php/noteBook
远程克隆
git clone https://github.com/OMGZui/noteBook

```

## 三、工作流

你的本地仓库由 git 维护的三棵“树”组成。

- 第一个是你的 `工作目录`，它持有实际文件
- 第二个是 `暂存区（Index`），它像个缓存区域，临时保存你的改动
- 最后是 `HEAD`，它指向你最后一次提交的结果

![](http://omgzui.oss-cn-hangzhou.aliyuncs.com/github/git-flow.jpg)

## 四、添加和提交

```sh
你可以提出更改（把它们添加到暂存区）
# 添加
# 某个文件
git add git.md
# 全部文件
git add .
或者
git add *

实际提交改动
# 提交
git commit -m '代码提交信息'
你的改动已经提交到了 HEAD，但是还没到你的远端仓库
```

## 五、推送改动

```sh

提交到远端仓库
# 推送
git push origin master

如果你还没有克隆现有仓库，并欲将你的仓库连接到某个远程服务器
# 添加远程服务器
git remote add origin https://github.com/OMGZui/noteBook
```

## 六、分支

分支是用来将特性开发绝缘开来的。在你创建仓库的时候，master 是“默认的”分支。在其他分支上进行开发，完成后再将它们合并到主分支上。

![](http://omgzui.oss-cn-hangzhou.aliyuncs.com/github/git-branch.jpg)

```sh

# 创建一个叫做“bug_fix”的分支，并切换过去
git checkout -b bug_fix
# 切换回主分支
git checkout master
# 再把新建的分支删掉
git branch -d bug_fix
# 除非你将分支推送到远端仓库，不然该分支就是 不为他人所见的
git push origin bug_fix
```

## 七、更新与合并

在master合并bug_fix分支

```sh
# 要更新你的本地仓库至最新改动，执行：
git pull
# 以在你的工作目录中 获取（fetch） 并 合并（merge） 远端的改动。
# 要合并其他分支到你的当前分支（例如 master），执行：
git merge bug_fix
# 在这两种情况下，git 都会尝试去自动合并改动。遗憾的是，这可能并非每次都成功，并可能出现冲突（conflicts）。 这时候就需要你修改这些文件来手动合并这些冲突（conflicts）。改完之后，你需要执行如下命令以将它们标记为合并成功：
git add .
# 在合并改动之前，你可以使用如下命令预览差异：
git diff bug_fix master
```

## 八、标签

```sh

# 为软件发布创建标签是推荐的。这个概念早已存在，在 SVN 中也有。你可以执行如下命令创建一个叫做 v1.0.0 的标签：
git tag v1.0.0 1b2e1d63ff
# 1b2e1d63ff 是你想要标记的提交 ID 的前 10 位字符。可以使用下列命令获取提交 ID：
git log
# 你也可以使用少一点的提交 ID 前几位，只要它的指向具有唯一性。
```

## 九、日志

```sh

# 如果你想了解本地仓库的历史记录，最简单的命令就是使用
git log
# 你可以添加一些参数来修改他的输出，从而得到自己想要的结果。 只看某一个人的提交记录
git log --author=shengj
# 一个压缩后的每一条提交记录只占一行的输出
git log --pretty=oneline
# 或者你想通过 ASCII 艺术的树形结构来展示所有的分支, 每个分支都标示了他的名字和标签: 
git log --graph --oneline --decorate --all
# 看看哪些文件改变了
git log --name-status
# 这些只是你可以使用的参数中很小的一部分。更多的信息，参考
git log --help
```

## 十、版本回退

```sh

# 假如你操作失误（当然，这最好永远不要发生），你可以使用如下命令替换掉本地改动：
git checkout -- <filename>
# 此命令会使用 HEAD 中的最新内容替换掉你的工作目录中的文件。已添加到暂存区的改动以及新文件都不会受到影响。

# 假如你想丢弃你在本地的所有改动与提交，可以到服务器上获取最新的版本历史，并将你本地主分支指向它：
git fetch origin
git reset --hard origin/master
```

## 十一、使用技巧

- 使用图形界面大大提升效率，Mac推荐`SourceTree`
- 冲突解决

> 经常在合并分支时出现冲突，解决冲突还是很容易的，时刻 `git pull` 是个好习惯，有工具的话，会自动提示的，提示冲突也别怕，
> 可以先`git stash`缓存起来，然后 `git pull`，这时再 `git stash pop`把缓存内容拿出来，打开冲突文件，进行修改即可。

- 反悔

> 有这样的需求，我们上线了最新版本，但是功能还不成熟，给客户演示时需要暂时成熟的版本，此时我们可以有两种做法：
>
> 1、切回到成熟版本，合并到master分支上
>
> 2、备份master，查看log，回退到成熟提交点。

- 简单部署脚本
  
    ```sh
    #!/usr/bin/env bash

    # 切分支到master
    echo '切分支到master'
    git checkout master

    # 合并dev分支内容
    echo '合并dev分支内容'
    git merge dev

    # 提交代码
    echo '提交代码'
    git add .

    # 提交至本地暂存区
    echo '提交至本地暂存区'
    git commit -m 'push'

    # 上传至远程仓库
    echo '上传至远程仓库'
    git push origin master

    # 完成后切回dev分支
    echo '完成后切回dev分支'
    git checkout dev
    ```

## 十二、参考资料

- [git - 简明指南](http://rogerdudler.github.io/git-guide/index.zh.html)
