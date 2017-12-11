/*
 * @Author: 小粽子
 * @Date: 2017-12-11 20:50:41
 * @Last Modified by:   小粽子
 * @Last Modified time: 2017-12-11 20:50:41
 */

const merge = require('webpack-merge');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const common = require('./webpack.common.js');

module.exports = merge(common, {
    plugins: [new UglifyJSPlugin()]
});