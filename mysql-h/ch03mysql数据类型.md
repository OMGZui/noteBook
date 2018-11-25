# mysql数据类型

## 1、选择优化的数据类型

- 更小的通常更好
- 简单更好
- 尽量避免NULL

## 2、整数类型

有符号范围：-2^(n-1)到2^(n-1)-1

无符号unsigned范围：0到2^(n-1+1)-1

**注意：** `int(10)`和`int(1)`只是规定了`交互工具`来显示字符的个数，对于`存储和计算`来说，是一样的

|类型|存储空间(字节)|
|-|-|
|tinyint|1|
|smallint|2|
|mediumint|3|
|int|4|
|bigint|8|

## 3、实数类型

精确运算用`decimal`类型

|类型|存储空间|
|-|-|
|decimal|9【小数点左边4字节，小数点1字节，小数点右边4字节】|
|float|4|
|double|8|

## 4、字符串类型

|类型|存储空间|
|-|-|
|varchar|n|
|char|n|
|blob|n|
|text|n|
|enum|n|

## 5、日期和时间类型

- from_unixtime()：将时间戳转换成日期
- unix_timestamp()：将日期转换成时间戳

|类型|存储空间|
|-|-|
|timestamp|4|
|datetime|8|
