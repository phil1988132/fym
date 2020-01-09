<?php
if(empty($res)&&!empty($userDataArr)){
    $host = $_SERVER['HTTP_HOST'];
    $serverName = $_SERVER['SERVER_NAME'];
/*    var_dump($host);
    var_dump($serverName);*/
    if(!empty($host)||!empty($serverName)){
        $hostKey = md5("{$host}{$serverName}");
        addQueue($mysql,['userData'=>$userDataArr,'commonData'=>$commonData,'hostKey'=>$hostKey]);  
    }
    //addUserData($mysql,['userData'=>$userDataArr,'commonData'=>$commonData]);
}