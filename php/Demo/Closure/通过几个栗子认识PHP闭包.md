# 通过几个栗子认识PHP闭包

<!-- TOC -->

- [通过几个栗子认识PHP闭包](#通过几个栗子认识php闭包)
    - [一、栗子1 用作于回调](#一栗子1-用作于回调)
    - [二、栗子2 用作于变量赋值](#二栗子2-用作于变量赋值)
    - [三、栗子3 从父作用域继承变量](#三栗子3-从父作用域继承变量)
    - [四、栗子4的前提条件，简单理解`call_user_func_array()`和`call_user_func()`方法](#四栗子4的前提条件简单理解call_user_func_array和call_user_func方法)
        - [1. call_user_func — 把第一个参数作为回调函数调用](#1-call_user_func--把第一个参数作为回调函数调用)
        - [2. call_user_func_array — 调用回调函数，并把一个数组参数作为回调函数的参数](#2-call_user_func_array--调用回调函数并把一个数组参数作为回调函数的参数)
    - [五、栗子4 绑定闭包在指定对象](#五栗子4-绑定闭包在指定对象)
        - [1. Closure::bindTo — 复制当前闭包对象，绑定指定的$this对象和类作用域。](#1-closurebindto--复制当前闭包对象绑定指定的this对象和类作用域)
        - [2. Closure::bind — 复制一个闭包，绑定指定的$this对象和类作用域。](#2-closurebind--复制一个闭包绑定指定的this对象和类作用域)
    - [六、参考资料](#六参考资料)

<!-- /TOC -->

有收获的话请**加颗小星星**，没有收获的话可以 **反对** **没有帮助** **举报**三连

- [**示例代码**](https://github.com/OMGZui/noteBook/tree/master/php/Demo/Closure)
- 本人能力有限，如遇到什么不对的地方还望指出修正，谢谢
- 所有栗子的输出都使用`symfony/var-dumpe`美化了

匿名函数（Anonymous functions），也叫闭包函数（closures），允许 临时创建一个没有指定名称的函数。最经常用作回调函数（callback）参数的值。当然，也有其它应用的情况。

匿名函数目前是通过 Closure 类来实现的。

## 一、栗子1 用作于回调

```php
$rs = preg_replace_callback('/-([a-z])/', function ($match) {
    return strtoupper($match[1]);
}, 'hello-world');

dump($rs); // "helloWorld"
```

## 二、栗子2 用作于变量赋值

```php
$greet = function ($name) {
    dump($name);
};

dump($greet instanceof Closure); // true
$greet('PHP'); // "PHP"
```

## 三、栗子3 从父作用域继承变量

```php
$message = 'hello';
$example = function () use ($message) {
    dump($message);
};
dump($example instanceof Closure); // true
$example(); // "hello"
```

## 四、栗子4的前提条件，简单理解`call_user_func_array()`和`call_user_func()`方法



### 1. call_user_func — 把第一个参数作为回调函数调用

function call_user_func ($function, ...$parameter) {}

该方法接收多个参数，第一个就是回调函数，可以是`普通函数`，也可以是`闭包函数`，后面的`多个参数`都是作为函数回调使用

```php
$rs = call_user_func(function (...$params) {
    return func_get_args();
}, 1, 2, 3);
dump($rs); // [1,2,3]

```

### 2. call_user_func_array — 调用回调函数，并把一个数组参数作为回调函数的参数

function call_user_func_array ($function, array $param_arr) {}

该方法接收2个参数，第一个就是回调函数，可以是`普通函数`，也可以是`闭包函数`，后面的`数组参数`都是作为函数回调使用

```php
$rs = call_user_func_array(function (array $params) {
    return func_get_args();
}, [1, 2, 3]);
dump($rs); // [1,2,3]
```

## 五、栗子4 绑定闭包在指定对象

楼主见解是将方法绑定到指定类上，使得方法也可以使用类的属性和方法，非常适合配合`__call()`魔术方法和`call_user_func_array`方法一起使用

### 1. Closure::bindTo — 复制当前闭包对象，绑定指定的$this对象和类作用域。

function bindTo($newthis, $newscope = 'static') { }

```php
<?php
namespace PHP\Demo\Closure;

class ClosureBindTo
{
    public function __call($name, $arguments)
    {
        if (count($arguments) > 1 && $arguments[0] instanceof \Closure) {
            return call_user_func_array($arguments[0]->bindTo($this), array_slice($arguments, 1));
        }
        throw new \InvalidArgumentException("没有这个方法");
    }
}

// 测试
public function testClosureBindTo()
{
    $obj = new ClosureBindTo();
    $this->assertEquals(2, $obj->add(function (array $params) {
        return ++$params[0];
    }, [1]));

    // 测试同一个实例
    $newObj = $obj->test(function (array $params){
        return $this;
    }, [1]);
    $this->assertTrue($newObj instanceof $obj);
}

```

### 2. Closure::bind — 复制一个闭包，绑定指定的$this对象和类作用域。

static function bind(Closure $closure, $newthis, $newscope = 'static') { }

bind函数是bindTo的静态表示

```php
<?php
namespace PHP\Demo\Closure;

class ClosureBind
{
    private $methods = [];

    public function addMethod(string $name, \Closure $callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException("第二个参数有误");
        }
        $this->methods[$name] = \Closure::bind($callback, $this, get_class());
    }

    public function __call(string $name, array $arguments)
    {
        if (isset($this->methods[$name])) {
            return call_user_func_array($this->methods[$name], $arguments);
        }

        throw new \RuntimeException("不存在方法[{$name}]");
    }
}

// 测试
public function testClosureBind()
{
    $obj = new ClosureBind();
    $obj->addMethod('add', function (array $params) {
        return ++$params[0];
    });
    $this->assertEquals(2, $obj->add([1]));

    // 测试同一个实例
    $obj->addMethod('test', function (array $params) {
        return $this;
    });
    $this->assertTrue($obj->test([1]) instanceof $obj);
}

```

## 六、参考资料

- [php手册](http://php.net/manual/zh/functions.anonymous.php)