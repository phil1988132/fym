<?php
define('DIR', dirname(__FILE__));
include DIR .'/func.php';
$dbInfo = include DIR .'/db/conn.php';
include DIR .'/db/mmysql.php';
$mysql = new \MMYsql($dbInfo);
while(true){
    $queue = getQueue($mysql);
    if(empty($queue)){
        sleep(1);
        //continue;
    }
    foreach ($queue as $key => $value) {
        if(empty($value['content'])){
            continue;
        }
        $content = decodeJson($value['content']);    
        $result = addUserData($mysql,$content);//var_dump($result);exit;
        $value['content'] = NUll;
        if($result){
            //删除记录
            $mysql->where(['id'=>$value['id']])->delete('fym_add_queue');
        }
    }
}
