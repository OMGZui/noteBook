/*
 * @Author: 小粽子 
 * @Date: 2017-12-02 21:28:33 
 * @Last Modified by: 小粽子
 * @Last Modified time: 2017-12-03 22:23:40
 */

// 早期对象写法
var person = new Object();

person.name = 'Shengj'
person.age = 24
person.job = 'Software Engineer'

person.sayName = function () {
    console.log(this.name)
}

//  console.log(person)

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
// console.log(zongzi_construct instanceof Object) //true
// console.log(zongzi_construct instanceof Person) //true


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
// console.log(person_compare1.sayName == person_compare2.sayName) //false


// 原型模式
function PersonPrototype(){

}

PersonPrototype.prototype.name = 'Shengj'
PersonPrototype.prototype.job = 'PHP Engineer'
PersonPrototype.prototype.sayName = function(){
    console.log(this.name)
}

var person1 = new PersonPrototype()
var person2 = new PersonPrototype()

// # isPrototypeOf() 判断实例中[[Prototype]]是否指向原型的 PersonPrototype.prototype
// # getPrototypeOf() 获取实例中[[Prototype]]的值
// console.log(person1.sayName == person2.sayName) //true
// console.log(PersonPrototype.prototype.isPrototypeOf(person1)) //true
// console.log(Object.getPrototypeOf(person1) == PersonPrototype.prototype) //true

// # 屏蔽原型属性，类似方法重载，js里是由于两层搜索，先搜索实例再搜索原型
person1.name = 'Shengj_1'
// console.log(person1.name) //Shengj_1 来自实例
// console.log(person2.name) //Shengj 来自原型

// # hasOwnProperty() 判断实例是否有这个属性或方法
// console.log(person1.hasOwnProperty('name')) //true
// console.log(person2.hasOwnProperty('name')) //false

// # keys
// console.log(Object.keys(PersonPrototype.prototype)) //(3) ["name", "job", "sayName"]
// console.log(Object.getOwnPropertyNames(PersonPrototype.prototype)) //(3) ["name", "job", "sayName"]
// console.log(Object.keys(person1)) //["name"]
// console.log(Object.getOwnPropertyNames(person1)) //["name"]

// 原生对象的原型
console.log('hello world'.indexOf('hello'))

// 组合使用构造函数模式和原型模式
function PersonTrue(name, job){
    this.name = name
    this.job = job
    this.friends = ['wangm','chensw']
}

PersonTrue.prototype = {
    constructor: PersonTrue,
    sayName: function(){
        console.log(this.name)
    }
}

var personTrue1 = new PersonTrue('小粽子_True1','PHP')
var personTrue2 = new PersonTrue('小粽子_True2','PHP')

personTrue1.friends.push('liwt')

// console.log(personTrue1)
// console.log(personTrue2)

// console.log(personTrue1.name === personTrue2.name) //false
// console.log(personTrue1.sayName === personTrue2.sayName) //true

// 继承
// 原型链
function SuperType(){
    this.property = true
}

SuperType.prototype.getSuperValue = function(){
    return this.property
}

function SubType(){
    this.subproperty = false
}

// 继承
SubType.prototype = new SuperType()

SubType.prototype.getSubValue = function(){
    return this.subproperty
}

var instance = new SubType()
// console.log(instance.getSuperValue()) //true

// # instance指向SubType的原型，SubType的原型又指向SuperType的原型，SuperType的原型又指向Object的原型
// console.log(instance instanceof Object) //true
// console.log(instance instanceof SuperType) //true
// console.log(instance instanceof SubType) //true

// console.log(Object.prototype.isPrototypeOf(instance)) //true
// console.log(SuperType.prototype.isPrototypeOf(instance)) //true
// console.log(SubType.prototype.isPrototypeOf(instance)) //true

// 组合继承
function SuperTypeCombine(name){
    this.name = name
    this.colors = ['red', 'blue', 'green']
}
SuperTypeCombine.prototype.sayName = function(){
    console.log(this.name)
}
function SubTypeCombine(name, job){
    SuperTypeCombine.call(this, name)

    this.job = job
}

// 继承

SubTypeCombine.prototype = new SuperTypeCombine()
SubTypeCombine.prototype.constructor = SubTypeCombine
SubTypeCombine.prototype.sayJob = function(){
    console.log(this.job)
}

var instance_combine1 = new SubTypeCombine('小性子','JS')
instance_combine1.colors.push('black')
console.log(instance_combine1.colors) //(4) ["red", "blue", "green", "black"]
instance_combine1.sayName() //小性子
instance_combine1.sayJob() //JS

var instance_combine2 = new SubTypeCombine('小粽子','PHP')
console.log(instance_combine2.colors) //(3) ["red", "blue", "green"]
instance_combine2.sayName() //小粽子
instance_combine2.sayJob() //PHP

// 寄生组合继承
/**
 * 寄生组合继承
 * 
 * inheritProtoType(SubTypeCombine,SuperTypeCombine)用来替换掉
 * SubTypeCombine.prototype = new SuperTypeCombine()
 * SubTypeCombine.prototype.constructor = SubTypeCombine
 * 目的是为了减少一次调用SuperTypeCombine的constructor
 * 
 * @param {any} SubTypeCombine
 * @param {any} SuperTypeCombine
 */
function inheritProtoType(SubTypeCombine, SuperTypeCombine){
    var property = object(SuperTypeCombine.property) //创建对象
    property.constructor = SubTypeCombine //增强对象
    SubTypeCombine.property = property //指定对象
}


