#!/usr/bin/env bash

date=$(date "+%Y-%m-%d %H:%M:%S")

git add .
git commit -m "$date"
git push origin master