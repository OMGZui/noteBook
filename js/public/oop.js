/*
 * @Author: 小粽子 
 * @Date: 2017-12-02 21:28:33 
 * @Last Modified by: 小粽子
 * @Last Modified time: 2017-12-02 23:01:31
 */

// 早期对象写法
var person = new Object();

person.name = 'Shengj'
person.age = 24
person.job = 'Software Engineer'

person.sayName = function () {
    console.log(this.name)
}

 console.log(person)

// 对象字面量写法
var person_new = {
    name: 'Shengj',
    age: 24,
    job: 'Software Engineer',

    sayName: function () {
        console.log(this.name)
    }
}

// console.log(person_new)

var obj = {}

Object.defineProperty(obj, "name", {
    writable: false,
    value: 'Shengj'
})

// console.log(obj) //友情提示：不要在IE8上使用Object.defineProperty() 啊哈哈哈

var person_name = Object.getOwnPropertyDescriptor(person, 'name')
// console.log(person_name)
// configurable:true
// enumerable:true
// value:"Shengj"
// writable:true
// console.log(typeof person_name.get)
// undefined

var person_sayName = Object.getOwnPropertyDescriptor(person, 'sayName')
// console.log(person_sayName)
// configurable:true
// enumerable:true
// value:f()
// writable:true
// console.log(typeof person_sayName.get)
// undefined

// 工厂模式
function crestePerson(name, job){
    var o = new Object()
    o.name = name
    o.job = job

    o.sayName = function(){
        console.log(this.name)
    }
    return o
}

var zongzi_show = crestePerson('小粽子','PHP Engineer')
console.log(zongzi_show)

// 构造函数模式

function Person(name, job){
    this.name = name
    this.job = job

    this.sayName = function(){
        console.log(this.name)
    }
}

var zongzi_construct = new Person('小粽子','PHP Engineer')
console.log(zongzi_construct)
// Person {name: "小粽子", job: "PHP Engineer", sayName: ƒ}
// job:"PHP Engineer"
// name:"小粽子"
// sayName:ƒ ()
// __proto__:
// constructor:ƒ Person(name, job)
// __proto__:Object

// 检测
console.log(zongzi_construct instanceof Object) //true
console.log(zongzi_construct instanceof Person) //true


// 把构造函数当做普通函数

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

// 构造函数的问题
console.log(person_compare1.sayName == person_compare2.sayName) //false