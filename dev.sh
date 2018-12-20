#!/bin/zsh
echo -n "输入你改动的内容："
read msg

echo "---开始构建---\n"
git add .
git commit -m "$msg"
git push origin master
echo "\n---构建完成---"