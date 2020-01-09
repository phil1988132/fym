<?php
define('DIR', dirname(__FILE__));
include DIR .'/func.php';
$dbInfo = include DIR .'/db/conn.php';
include DIR .'/db/mmysql.php';
$mysql = new \MMYsql($dbInfo);
$num = 1;
$i=0
while(true){

    $sql = "select `name`,`num` from fym_valid_table where id>0";
    //echo $sql.'<br>';
    $res=$mysql->doSql($sql);
    foreach ($res as $key => $value) {
        $name = 'fym_'.$value['name'].'_'.$value['num'];
        $sql = "select id from `{$name}` where id>0 order by id desc limit 1";
        $curRes=$mysql->doSql($sql);
        $curRes = current($curRes);
        if(isset($curRes)&&$curRes['id']>$num){
            $curStatus=createTable($mysql,'fym_'.$value['name'],$value['num']);
            if($curStatus){
                updateNum($mysql,$value['name']);
            }
        }
    }
    $i++;
    if($i==10){
        $i=0;
        $mysql = new \MMYsql($dbInfo);
    }
    sleep(1000);
}
function createTable($mysql,$name,$num){
    try{
        $oldTable = "{$name}_{$num}";
        $num++;
        $newTable = "{$name}_{$num}";
        $sql = "create table {$newTable} like {$oldTable}";
        $res=$mysql->doSql($sql);  
        return true;
    }catch(\Exception $e){
        return false;
    }
}
function updateNum($mysql,$name){
    $sql = "update fym_valid_table set num=num+1 where name='".$name."'";
    $res=$mysql->doSql($sql);
    return $res;    
}
