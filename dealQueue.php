<?php
ini_set('memory_limit','562M');
define('DIR', dirname(__FILE__));
include DIR .'/func.php';
$dbInfo = include DIR .'/db/conn.php';
include DIR .'/db/mmysql.php';
$mysql = new NMMYsql($dbInfo);
$i = 0;
while($i<2){
    $queueData= getQueue($mysql);
    if(empty($queueData)){
        sleep(1);
        continue;
    }
    foreach ($queueData as $key => $value) {
        if(empty($value['content'])){
            continue;
        }
        $content = decodeJson($value['content']);
        if(!isset($content['hostKey'])||empty($content['hostKey'])){
            continue;
        }    
        $result = addUserData($mysql,$content);//var_dump($result);exit;
        $value['content'] = NUll;
        if($result){
            //删除记录
            doDel($mysql,$value['id']);
        }
    }echo $i;
    $i++;
    if($i>10){
        $i = 0;
        $mysql = new NMMYsql($dbInfo);
    }
}
function doDel($mysql,$id){
    $mysql->where(['id'=>$id])->delete('fym_add_queue');
}
