/*
 * @Author: 小粽子
 * @Date: 2017-12-04 20:09:21
 * @Last Modified by: 小粽子
 * @Last Modified time: 2017-12-04 21:47:45
 */

// 函数表达式 # 函数声明
function functionName1(arg) {}
// console.log(functionName1.name) //functionName1
// # 函数表达式
var functionName2 = function (arg) {}
// console.log(functionName2.name) //functionName2

// # 递归
function factorial(num) {
    if (num <= 1) {
        return 1
    }
    return num + factorial(num - 1)
}

function factorial_better(num) {
    if (num <= 1) {
        return 1
    }
    return num + arguments.callee(num - 1)
}

var factorial_best = (function f(num) {
    if (num <= 1) {
        return 1
    }
    return num + f(num - 1)
})

// console.log(factorial(100)) //5050
// console.log(factorial_better(100)) //5050
// console.log(factorial_best(100)) //5050

// # 全局作用域
// (function () {
//     var now = new Date()
//     if (now.getMonth() == 0 && now.getDate() == 1) {
//         console.log("Happy New Year!")
//     }
// })()



