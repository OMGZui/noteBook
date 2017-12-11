/*
 * @Author: 小粽子 
 * @Date: 2017-12-02 21:39:29 
 * @Last Modified by: 小粽子
 * @Last Modified time: 2017-12-11 19:28:20
 */

var express = require('express');
var app = express();


app.use(express.static('dist'));

app.listen(5000, function () {
    console.log('port 5000!');
})