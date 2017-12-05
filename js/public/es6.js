/*
 * @Author: 小粽子
 * @Date: 2017-12-05 09:24:46
 * @Last Modified by: 小粽子
 * @Last Modified time: 2017-12-05 16:07:43
 */

// let、const、var let 块级作用域 var 全局作用域

(function () {
    // {
    //     let a = 10;
    //     var b = 1;
    // }

    // console.log(a); //ReferenceError: a is not defined console.log(b); //1

    var a = [];
    for (let i = 0; i < 10; i++) {
        a[i] = function () {
            console.log(i);
        };
    }
    a[6](); //6

    var b = [];
    for (var i = 0; i < 10; i++) {
        b[i] = function () {
            console.log(i);
        };
    }
    b[6](); //10

    // var变量提升
    // if (true) {
    //     console.log(foo); //undefined
    //     var foo = 2;

    //     console.log(bar); //ReferenceError: bar is not defined
    //     let bar = 2;
    // }

    var tmp = new Date();
    function f() {
        console.log(tmp);
        if (false) {
            var tmp = 'hello world'; // var变量提升
        }
    }
    f(); //undefined

    // const声明一个只读的常量
    
}());

// // IIFE 写法
// (function(){
//     ...
// }())

// // 块级作用域写法
// {
//     ...
// }

(function(){
    // 解构赋值 Destructuring 本质上，这种写法属于“模式匹配”
    {
        let [a,b,c] = [1,2,3];
        console.log(c);
    }

    // 数组的元素是按次序排列的，变量的取值由它的位置决定；而对象的属性没有次序，变量必须与属性同名，才能取到正确的值。
    {
        let { foo, bar } = { foo: "aaa", bar: "bbb" };
        // let { foo: foo, bar: bar } = { foo: "aaa", bar: "bbb" };
        console.log(foo);
    }

    // 字符串
    {
        const [a, b, c, d, e] = 'hello';
        console.log(d);
    }

    // 函数参数
    {
        function add([x, y]) {
            return x + y;
        }

        console.log(add([1, 2])); // 3
    }

    // 提取JSON
    {
        let jsonData = {
            id: 42,
            status: "OK",
            data: [867, 5309]
          };
          
          let { id, status, data: number } = jsonData;
          
          console.log(id, status, number);
    }

    // 遍历Map
    {
        const map = new Map();
        map.set('first', 'hello');
        map.set('second', 'world');
        
        for (let [key, value] of map) {
          console.log(key + " is " + value);
        }
    }
}());

// 字符串
(function(){

    console.log("\u{20BB7}");

    // 字符串的遍历器接口 for of
    // for (const i of 'object') {
    //     console.log(i);
    // }

    // repeat
    console.log('hello'.repeat(10));

    // 模板字符串 ``
    let zongzi = '粽子';
    console.log(`
        我是
        你
        大爷
        ${zongzi}
    `);
}());

// 正则
(function(){
    
}());

// 数值
(function(){
    
}());

// 函数
(function(){
    // es5居然不能指定默认值，只能用 y = y || 'hello'代替，哈哈哈

    // 写法一函数参数的默认值是空对象，但是设置了对象解构赋值的默认值
    // 写法二函数参数的默认值是一个有具体属性的对象，但是没有设置对象解构赋值的默认值
    // 写法一
    function m1({
        x = 0,
        y = 0
    } = {}) {
        return [x, y];
    }

    // 写法二
    function m2({x, y} = {
        x: 0,
        y: 0
    }) {
        return [x, y];
    }
    console.log(m1({})); // [0, 0]
    console.log(m2({})); // [undefined, undefined]

    // 指定了默认值以后，函数的length属性将失真
    // (function (a) {}).length // 1
    // (function (a = 5) {}).length // 0
    // (function (a, b, c = 5) {}).length // 2

    // rest参数
    function add(...values) {
        let sum = 0;

        for (var val of values) {
            sum += val;
        }

        return sum;
    }
    console.log(add(2, 5, 3)); // 10

    // 箭头函数
    {
        var f = v => v;
        // var f = function(v) {
        //     return v;
        // };
        console.log(f('箭头函数'));

        let x = [1,2,3].map(x => x * x);
        console.log(x); // [1, 4, 9]

        // 前者的this绑定定义时所在的作用域（即Timer函数）
        // 后者的this指向运行时所在的作用域（即全局对象）
        function Timer() {
            this.s1 = 0;
            this.s2 = 0;
            // 箭头函数
            setInterval(() => this.s1++, 1000);
            // 普通函数
            setInterval(function () {
              this.s2++;
            }, 1000);
        }
        
        var timer = new Timer();
        
        // setTimeout(() => console.log('s1: ', timer.s1), 3100); //3
        // setTimeout(() => console.log('s2: ', timer.s2), 3100); //0

        // es6 => es5
        {
            // ES6
            function foo() {
                setTimeout(() => {
                    console.log('id:', this.id);
                }, 100);
            }

            // ES5
            function foo() {
                var _this = this;

                setTimeout(function () {
                    console.log('id:', _this.id);
                }, 100);
            }
        }
    }
}());

// 数组
(function(){
    console.log(...[1,2,3]);
    {
        function push(array, ...items) {
            array.push(...items);
        }

        function add(x, y) {
            return x + y;
        }

        const numbers = [4, 38];
        console.log(add(...numbers)); // 42
    }
    // ES5 的写法
    Math.max.apply(null, [14, 3, 77])
    // ES6 的写法
    Math.max(...[14, 3, 77])
    // 等同于
    Math.max(14, 3, 77);

    console.log([...'hello']);    
}());

// 对象
(function(){
    {
        let birth = '2000/01/01';
        
        const Person = {
        
          name: '张三',
        
          //等同于birth: birth
          birth,
        
          // 等同于hello: function ()...
          hello() { console.log('我的名字是', this.name); }
        
        };
    }

    // ES6 一共有 5 种方法可以遍历对象的属性。
    
    // （1）for...in
    
    // for...in循环遍历对象自身的和继承的可枚举属性（不含 Symbol 属性）。
    
    // （2）Object.keys(obj)
    
    // Object.keys返回一个数组，包括对象自身的（不含继承的）所有可枚举属性（不含 Symbol 属性）的键名。
    
    // （3）Object.getOwnPropertyNames(obj)
    
    // Object.getOwnPropertyNames返回一个数组，包含对象自身的所有属性（不含 Symbol 属性，但是包括不可枚举属性）的键名。
    
    // （4）Object.getOwnPropertySymbols(obj)
    
    // Object.getOwnPropertySymbols返回一个数组，包含对象自身的所有 Symbol 属性的键名。
    
    // （5）Reflect.ownKeys(obj)
    
    // Reflect.ownKeys返回一个数组，包含对象自身的所有键名，不管键名是 Symbol 或字符串，也不管是否可枚举。
    
    // 以上的 5 种方法遍历对象的键名，都遵守同样的属性遍历的次序规则。
    
    // 首先遍历所有数值键，按照数值升序排列。
    // 其次遍历所有字符串键，按照加入时间升序排列。
    // 最后遍历所有 Symbol 键，按照加入时间升序排列。

    const person = {
        name: '小粽子',
        job: function(){
            console.log('PHP')
        }
    };
    // console.log(Object.getOwnPropertyNames(person));
    // console.log(Object.getOwnPropertySymbols(person));
    // console.log(Reflect.ownKeys(person));
    console.log(Object.keys(person));
    console.log(Object.values(person));
    console.log(Object.entries(person));

    // super
    
}());

// Symbol
(function(){
    let s = Symbol();
    console.log(typeof s);

    let s1 = Symbol('s');
    let s2 = Symbol('s');
    console.log(s1 === s2); //false
}());

// Set/Map
(function(){
    // Set
    // 类似于数组，但是成员的值都是唯一的
    // const s = new Set();
    
    // [2, 3, 5, 4, 5, 2, 2].forEach(x => s.add(x));
    
    // for (let i of s) {
    //   console.log(i);
    // }

    // 操作方法（用于操作数据）和遍历方法（用于遍历成员）

    // add(value)：添加某个值，返回 Set 结构本身。
    // delete(value)：删除某个值，返回一个布尔值，表示删除是否成功。
    // has(value)：返回一个布尔值，表示该值是否为Set的成员。
    // clear()：清除所有成员，没有返回值。

    // keys()：返回键名的遍历器
    // values()：返回键值的遍历器
    // entries()：返回键值对的遍历器
    // forEach()：使用回调函数遍历每个成员

    // Map
    // 它类似于对象，也是键值对的集合，但是“键”的范围不限于字符串，各种类型的值（包括对象）都可以当作键。
    
}());

// Proxy
(function(){
    var obj = new Proxy({}, {
        get: function (target, key, receiver) {
            console.log(`getting ${key}!`);
            return Reflect.get(target, key, receiver);
        },
        set: function (target, key, value, receiver) {
            console.log(`setting ${key}!`);
            return Reflect.set(target, key, value, receiver);
        }
    });
    obj.count = 1; 
    //setting count!

    ++obj.count;
    //getting count!
    //setting count!

    console.log(obj.count);
    //getting count!
    //2

}());

// Reflect
(function(){
    
}());

// Promise 异步编程的一种解决方案
(function () {
    // let promise = new Promise(function (resolve, reject) {
    //     console.log('Promise');
    //     resolve();
    // });

    // promise.then(function () {
    //     console.log('resolved.');
    // });

    // console.log('Hi!');

    // Promise
    // Hi!
    // resolved.
}());

// Iterator
(function(){
    
}());

// Generator
(function(){
    
}());

// async
(function(){
    
}());

// class
(function () {
    class Point {
        constructor(x, y) {
            this.x = x;
            this.y = y;
        }

        toString() {
            return '(' + this.x + ', ' + this.y + ')';
        }
    }
    console.log(new Point(1,2));
    console.log(new Point(1,2).toString());
    console.log(typeof Point);
    console.log(Point === Point.prototype.constructor);

    {
        class MyClass {
            constructor() {
                // ...
            }
            get prop() {
                return 'getter';
            }
            set prop(value) {
                console.log('setter: ' + value);
            }
        }

        let inst = new MyClass();

        inst.prop = 123;
        // setter: 123

        console.log(inst.prop);
        // 'getter'
    }
    {
        class Foo {
            static classMethod() {
                return 'hello';
            }
        }

        class Bar extends Foo {
            static classMethod() {
                return super.classMethod() + ', too';
            }
        }

        Bar.classMethod() // "hello, too"
    }
    {
        function Person(name) {
            if (new.target !== undefined) {
                this.name = name;
            } else {
                throw new Error('必须使用 new 命令生成实例');
            }
        }

        // 另一种写法
        function Person(name) {
            if (new.target === Person) {
                this.name = name;
            } else {
                throw new Error('必须使用 new 命令生成实例');
            }
        }

        // var person = new Person('张三'); // 正确
        // var notAPerson = Person.call(person, '张三'); // 报错
}
}());

// decorator
(function(){
    // // CommonJS模块
    // let { stat, exists, readFile } = require('fs');

    // // 等同于
    // let _fs = require('fs');
    // let stat = _fs.stat;
    // let exists = _fs.exists;
    // let readfile = _fs.readfile;

    // // ES6模块
    // import { stat, exists, readFile } from 'fs';


    // 报错
    // function f() {}
    // export f;

    // 正确
    // export function f() {};

    // 正确
    // function f() {}
    // export {f};

    // 整体加载
    // import * as fs from 'fs';

    // export default命令，为模块指定默认输出
}());

// module
(function(){
    
}());

// 风格
(function(){
    
}());

