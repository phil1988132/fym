<?php
function getTableName($mysql,$visiterKey,$host='',$serverName=''){
	if(empty($host)||empty($serverName)){
		return [];
	}
	$k = md5("{$host}{$serverName}");
	$res = $mysql->field(array('key_info'))
	    ->where(array('host'=>"'".$k."'"))
	    ->limit(1)
	    ->select('fym_visiter_table');
    if(empty($res)){
    	return [];
    }
    $res = current($res);
    if(empty($res)){
    	return [];
    }
    $info = json_decode($res['key_info'],true);
    $res = NULL;
  	$kData = isset($info[$visiterKey])&&!empty($info[$visiterKey]) ? $info[$visiterKey] : [];
    return $kData;
}
function getVisiterInfoByHost($mysql,$key){

	$k = $key;//md5("{$host}{$serverName}");
	$res = $mysql->field(array('id','key_info'))
	    ->where(array('host'=>"'".$k."'"))
	    ->limit(1)
	    ->select('fym_visiter_table');
    if(empty($res)){
    	return [];
    }
    $res = current($res);
    if(empty($res)){
    	return [];
    }
    $info = json_decode($res['key_info'],true);
    $res = NULL;
    return ['id'=>$res['id'],'info'=>$info];
}
/*
function getTableName($visiterKey){
	$res = $mysql->field(array('table_id','user_id'))
	    ->where(array('visiter_key'=>"'".$visiterKey."'"))
	    ->limit(1)
	    ->select('fym_visiter_table');
    if(empty($res)){
    	return [];
    }
    $res = current($res);
    if(empty($res)){
    	return [];
    }
    return $res;
}
*/
function getUserData($mysql,$visiterKey,$host='',$serverName=''){
	//$res = $mysql->field(array('read_keyword','read_victitle','read_tpl','var','mulu_name','url','yuming','bt_keyword','detail_id'))
	$keyInfo = getTableName($mysql,$visiterKey,$host,$serverName);
    if(empty($keyInfo)){
    	return [];
    }
    $curTableNo = $keyInfo['table_no'];
    $user_id = $keyInfo['id'];
    $curTable = "fym_user_{$curTableNo}";
	$res = $mysql->field(array('detail'))
	    ->where(array('id'=>$user_id))
	    ->limit(1)
	    ->select($curTable);//var_dump($res);exit;
    if(empty($res)){
    	return [];
    }
	$res = current($res);

    if(empty($res)||!isset($res['detail'])||empty($res['detail'])){
    	return [];
    }


	$detail = json_decode($res['detail'],true);//var_dump($detail);
	$data = ['read_keyword'=>'','read_victitle'=>'','read_tpl'=>'','var'=>'','mulu_name'=>'','url'=>'','yuming'=>'','bt_keyword'=>''];
	$detail_base_table = "fym_user_detail";
	$source_base_table = "fym_source";
	$resDetail = [];
	foreach ($detail as $key => $value) {
		if(empty($value['table_no'])||empty($value['id'])){
			continue;
		}
		$no = $value['table_no'];
		$id = (int)$value['id'];
		if($key == 'detail_id'){
			$curSourceTable = "{$detail_base_table}_{$no}";
		} else {
			$curSourceTable = "{$source_base_table}_{$no}";
		}
		
		$curRes = $mysql->field(array('content'))
		    ->where(array('id'=>$id))
		    ->limit(1)
		    ->select($curSourceTable);
		if(empty($curRes)){
			continue;
		} 
		$curRes = current($curRes);
		if(empty($curRes)){
			continue;
		}
		if($key == 'detail_id'){
			$resDetail = decodeJson($curRes['content']);
		} else {
			//var_dump($key);var_dump($id);var_dump($curRes);			
			switch ($key) {
				case 'read_keyword':
					$curKey = '_keyword';
					break;
				case 'read_victitle':
					$curKey = 'vic_title';
					break;				
				default:
					$curKey = $key;
					break;
			}
			$data[$curKey] = empty($curRes['content']) ? '' : stripslashes($curRes['content']);
		}		
	}
	//var_dump(array_merge($resDetail,$data));exit;
	return array_merge($resDetail,$data);
}
function decodeJson($arr){
	return unserialize($arr);

}
function encodeJson($arr){
	//return json_encode($arr,JSON_UNESCAPED_UNICODE);
	return serialize($arr);
}
function getInsertValidTable($mysql,$tableName){
	$curRes = $mysql->field(array('num'))
	    ->where(array('name'=>"'".$tableName."'"))
	    ->limit(1)
	    ->select('fym_valid_table');
	if(empty($curRes)){
		return false;
	} 
	$curRes = current($curRes);  
	if(empty($curRes)){
		return false;
	}
	return ['name'=>$tableName.'_'.$curRes['num'],'no'=>$curRes['num']];  	
}
function getSourceIndex($mysql,$mkey,$curType){
	$curNum = getInsertValidTable($mysql,'source');
	$curNum = $curNum['no'];
	$num = 1;
	for($i=1;$i<=$curNum;$i++){
		$num = $i;
		$curTable = "fym_source_{$i}";
		$res = $mysql->field(array('id'))
		    ->where(array('mkey'=>"'".$mkey."'",'type'=>$curType))
		    ->limit(1)
		    ->select($curTable);
	    if(!empty($res)){
	    	break;
	    }		
	}
    if(empty($res)){
    	return [];
    }
    $res = current($res);

    if(empty($res)||empty($res['id'])){
    	return [];
    }
    return ['table_no'=>$num,'id'=>$res['id']];
    
}
function addQueue($mysql,$data){
	if(empty($data)){
		return false;
	}
	$data = encodeJson($data);	
	$i = 0;
	while($i<3){
		$sql = "insert into fym_add_queue(`content`)values('{$data}')";
		$_result=$mysql->doSql($sql);
		if($_result){
			break;
		}
		$i++;	
	}
}
function getQueue($mysql){
	$sql = "select `content`,`id` from fym_add_queue where id>0 limit 50";
	//echo $sql.'<br>';
	$res=$mysql->doSql($sql);
    if(empty($res)){
    	return [];
    }
    return $res;
    /*
    $res = current($res);
    $content = decodeJson($res['content']);
    return ['content'=>$content,'id'=>$res['id']];
    */
}
function addUserData($mysql,$data){

	$time = time();
	$userData = $data['userData'];
	$commonData = $data['commonData'];
	$hostKey = $data['hostKey'];
	unset($data['hostKey']);
	$visiterKey = $userData['visiter_key'];
    unset($userData['visiter_key']);
	//unset($commonData['read_tpl']);var_dump($commonData);exit;

	$newKeyData = [
	];	
	$time = time();
	$newUserData = [
	];
	$keyIndex = [
		'read_keyword'=>1,
		'read_tpl'=>3,
		'read_victitle'=>2,
		'var'=>4,
		'mulu_name'=>5,
		'url'=>6,
		'yuming'=>7,
		'bt_keyword'=>8
	];
	try{
		$mysql->startTrans();
		//先插入source表
		$user_detail = ['read_keyword'=>'','read_victitle'=>'','read_tpl'=>'','var'=>'','mulu_name'=>'','url'=>'','yuming'=>'','bt_keyword'=>'','detail_id'=>''];
		foreach ($commonData as $key => $value) {
			if(!empty($value)){
				$newValue = '';
				if(isset($data[$key])&&is_array($data[$key])){
					//$newValue = json_encode($data[$key],JSON_UNESCAPED_UNICODE);
					$newValue = encodeJson($value);
					
				}else{
					$newValue = addslashes($value);
				}
				$_key = trim(md5($newValue));
				$curType = (int)$keyIndex[$key];
				//echo $curType.'--Type<br>';
				$keyRes = getSourceIndex($mysql,$_key,$curType);
				//var_dump($keyRes);
				if(!empty($keyRes)){
					$user_detail[$key] = $keyRes;
					//$newUserData[$key] = $keyRes;
				}else{
					$curTableInfo = getInsertValidTable($mysql,'source');
					$curTname = $curTableInfo['name'];
					$curNo = $curTableInfo['no'];
					$sql = "insert into fym_{$curTname}(`mkey`,`content`,`type`)values('{$_key}','{$newValue}',{$curType})";
					//echo $sql.'<br>';
					$_result=$mysql->doSql($sql);
					if(!$_result){
						$mysql->rollback();
						return false;
					}
					$user_detail[$key] = ['id'=>$mysql->getObj()->lastInsertId(),'table_no'=>$curNo];
				}
			}
		}
		//插入user_detail表
		$curDetailTableInfo = getInsertValidTable($mysql,'user_detail');
		$curDetailTname = $curDetailTableInfo['name'];
		$curDetailNo = $curDetailTableInfo['no'];
		$userDataFlag = $mysql->insert("fym_{$curDetailTname}",['content'=>encodeJson($userData)],1);
		if(!$userDataFlag){
			$mysql->rollback();
			return false;
		}
		$user_detail['detail_id'] = ['id'=>$userDataFlag,'table_no'=>$curDetailNo];
		$newUserData['detail'] = json_encode($user_detail);

		$curDetailTableInfo = getInsertValidTable($mysql,'user');
		$curDetailTname = $curDetailTableInfo['name'];
		$curDetailNo = $curDetailTableInfo['no'];

		$flag = $mysql->insert("fym_{$curDetailTname}",$newUserData,1);
		if(!$flag){
			$mysql->rollback();
			return false;
		}
		$newKeyData['table_no'] = $curDetailNo;
		$newKeyData['id'] = $flag;

		$hostData = getVisiterInfoByHost($mysql,$hostKey);
		//开始插入host表
		if(!empty($hostData)){
			$info = $hostData['info'];
			if(!isset($info[$visiterKey])||empty($info[$visiterKey])){
				$info[$visiterKey] = $newKeyData;
				$flag = $mysql->where(array('id'=>$hostData['id']))->update('fym_visiter_table',['info'=>json_encode($info)]);
				if(!$flag){
					$mysql->rollback();
					return false;
				}
			}
		}else{
			$_keyInfo[$visiterKey] = $newKeyData;
			$flag = $mysql->insert("fym_visiter_table",['host'=>$hostKey,'key_info'=>json_encode($_keyInfo)]);
			if(!$flag){
				$mysql->rollback();
				return false;
			}
		}
		
		$mysql->commit();
		return true;
	}catch(\Exception $e){
        //file_put_contents('./err.txt', json_encode($e));
        //var_dump($e);
		$mysql->rollback();
	}
}