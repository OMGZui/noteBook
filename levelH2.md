# 3 年经验 PHP 准备面试

## 1、引用变量

&，指向一个变量的指针

## 2、unset

unset 只会取消引用，不会销毁值

## 3、对象赋值采用引用方式，不会写时复制，需要使用 clone 进行复制

## 4、栗子 1

```php
$data = ['a', 'b', 'c'];
foreach ($data as $key=>$val)
{
    $val = &$data[$key];
    var_dump($data);
}

var_dump($data); // [b,c,c]
```

## 5、单引号和双引号

- 双引号会解析变量 HereDoc
- 单引号效率更高，NewDoc

## 6、数据类型

- 整数 integer
- 浮点数 float、double 计算使用 bcmath 库，mysql 使用 decimal 字段
- 字符串 string
- 布尔 boolean

- 数组 array
- 对象 object
- 回调 callback

- 资源 resource
- 空 null 赋值 null、未定义的变量、unset 销毁的变量

## 7、超全局数组

- \$SERVER['SERVER_ADDR']
- \$SERVER['REMOTE_ADDR']

## 8、预定义变量

- **FILE**

## 9、@错误控制符，==和===，++$a和$a++

## 10、栗子 2

```php
# 运算符优先级问题，++、>、||、=
$a = 0;
$b = 0;

if ($a = 3 > 0 || $b = 3 > 0)
{
    $a++;
    $b++;
    echo $a. "\n"; // 1
    echo $b. "\n"; // 1
}
```

## 11、foreach 会 reset 重置指针，switch...case 有一个跳转表的概念

## 12、栗子3

```php
# static只会初始化一次，是局部的，会记录值
$count = 5;
function get_count()
{
    static $count; 
    return $count++;
}

echo $count; // 5
++$count;

echo get_count(); // null
echo get_count(); // 1

```
