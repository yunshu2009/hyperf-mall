#!/bin/bash

bashpath=$(cd `dirname $0`;pwd)
cd $bashpath
if [ -f "../runtime/hyperf.pid" ];then
  cat ../runtime/hyperf.pid | awk '{print $1}' | xargs kill && rm -rf ../runtime/hyperf.pid && rm -rf ../runtime/container
fi
php hyperf.php start