# JavaScript

<!-- TOC -->

- [JavaScript](#javascript)
    - [什么是JavaScript](#什么是javascript)
    - [面向对象](#面向对象)
        - [属性类型](#属性类型)
            - [1.数据属性](#1数据属性)
            - [2.访问器属性](#2访问器属性)
        - [定义属性](#定义属性)
        - [读取属性](#读取属性)
        - [工厂模式](#工厂模式)
        - [构造函数模式](#构造函数模式)
            - [1.构造函数当函数](#1构造函数当函数)
            - [2.构造函数的问题](#2构造函数的问题)
        - [原型模式](#原型模式)

<!-- /TOC -->

## 什么是JavaScript

## 面向对象

### 属性类型

#### 1.数据属性

- [[Configurable]] true delete方法
- [[Enumberable]] true for-in方法
- [[Writable]] true 修改属性
- [[Value]] undefined 数据值

#### 2.访问器属性

getter/setter

- [[Configurable]] true delete方法
- [[Enumberable]] true for-in方法
- [[Get]] undefined 读取时调用
- [[Set]] undefined 写入时调用

```js

get()/set()
__defineGetter__()/__defineSetter__() 兼容老版本，呵呵哒

```

### 定义属性

定义对象属性可以使用`Object.defineProperty()`和`Object.defineProperties()`方法

推荐使用 IE9+/Firefox 4+/Safari 5+/Opear 12+/Chrome

### 读取属性

读取对象属性可以使用`Object.getOwnPropertyDescriptor()`和`Object.getOwnPropertyDescriptors()`

### 工厂模式

```js

function crestePerson(name, job){
    var o = new Object()
    o.name = name
    o.job = job

    o.sayName = function(){
        console.log(this.name)
    }
    return o
}

var zongzi = crestePerson('小粽子','PHP Engineer')

console.log(zongzi)

```

### 构造函数模式

```js

function Person(name, job){
    this.name = name
    this.job = job

    this.sayName = function(){
        console.log(this.name)
    }
}

var zongzi_construct = new Person('小粽子','PHP Engineer')
console.log(zongzi_construct)

// 检测
console.log(zongzi_construct instanceof Object) //true
console.log(zongzi_construct instanceof Person) //true

```

#### 1.构造函数当函数

```js
// 当构造函数
var person_compare1 = new Person('小粽子1','PHP')
person_compare1.sayName()

// 当普通函数
Person('小粽子2', 'PHP')
window.sayName()

// 另一个对象中使用
var person_compare2 = new Object()
Person.call(person_compare2, '小粽子3', 'PHP')
person_compare2.sayName()
```

#### 2.构造函数的问题

不同实例的同名函数是不等的

`console.log(person_compare1.sayName == person_compare2.sayName) //false`

### 原型模式
