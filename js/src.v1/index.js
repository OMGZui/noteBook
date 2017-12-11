/*
 * @Author: 小粽子
 * @Date: 2017-12-11 19:05:08
 * @Last Modified by: 小粽子
 * @Last Modified time: 2017-12-11 19:59:07
 */
import _ from 'lodash';
import './style.css';
import Icon from './icon.jpg';
import Data from './data.xml';

function component() {
    var element = document.createElement('div');

    element.innerHTML = _.join([
        'Hello', 'webpack'
    ], ' ');
    element.classList.add('hello');

    // Add the image to our existing div.
    var myIcon = new Image();
    myIcon.src = Icon;

    element.appendChild(myIcon);
    
    console.log(Data);
    return element;
}

document.body.appendChild(component());
