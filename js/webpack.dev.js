/*
 * @Author: 小粽子
 * @Date: 2017-12-11 20:50:21
 * @Last Modified by:   小粽子
 * @Last Modified time: 2017-12-11 20:50:21
 */

const merge = require('webpack-merge');
const common = require('./webpack.common.js');

module.exports = merge(common, {
    devtool: 'inline-source-map',
    devServer: {
        contentBase: './dist'
    }
});