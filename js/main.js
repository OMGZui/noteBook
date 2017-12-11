/*
 * @Author: 小粽子 
 * @Date: 2017-12-02 21:39:29 
 * @Last Modified by: 小粽子
 * @Last Modified time: 2017-12-11 21:29:35
 */

var express = require('express');
var app = express();


app.use(express.static('public'));

app.listen(5000, function () {
    console.log('port 5000!');
})