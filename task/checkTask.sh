#!/bin/bash

project2=('dealQueue.php','checkTables.php')
dir_path = "$1/task"
for v in {1..10}  
do  
PythonPid=`ps -ef | grep $v | grep -v grep | wc -l `
#echo $PythonPid
if [ $PythonPid -eq 0 ];
        then

        cd $dir_path

        nohup php v &

fi
done  
