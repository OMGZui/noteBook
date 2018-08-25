# C基础

<!-- TOC -->

- [C基础](#c基础)
    - [1、编码](#1编码)
    - [2、函数](#2函数)
    - [3、字符串](#3字符串)
    - [4、风格](#4风格)
    - [5、函数](#5函数)

<!-- /TOC -->

## 1、编码

每个字符在计算机内部用一个整数表示，称为`字符编码`

`'a'+1 = 'b'` == `97 + 1 = 98`,ASCII码运算得来

## 2、函数

```c
// 标准库文件一般在/usr/inculde目录下
#inclue <stdio.h>

// 标准main函数
int main(int argc, char *argv[]){}
```

- 用户命令 /bin /usr/bin
- 系统命令 /sbin /usr/sbin 需要root权限

`Man Page`是Linux开发最常用的参考手册，包含很多section

|section |描述                      |
|-       |-                        |
|1       |用户命令 ls(1)             |
|2       |系统调用 _exit(2)          |
|3       |库函数 printf(3)          |
|5       |系统配置文件的格式 passwd(5)|
|8       |系统管理命令 ifconfig(8)   |

`增量式开发`是指将问题分解成多块，一块一块开发，如有关联，可先用伪代码填充

## 3、字符串

字符串字面值可以看做数组类型

`char str[10] = "hello"` == `char str[10] = {'h','e','l','l','o','\0'}` `\0`即为NULL

- `char c = "Hello"[0]` ✅ 可以通过类似数组访问字符
- `"hello"[0] = 'A'` ❌ 不能修改字符

## 4、风格

- i18n => internationalization => i 18个字母 n
- count cnt
- length len
- window win
- message msg
- block blk
- number nr
- temporary temp tmp
- trans x

## 5、函数

1. 函数应该只为了做一件事，增加复用性
2. 执行函数应该就是一个执行动作
3. 重要函数加注释
