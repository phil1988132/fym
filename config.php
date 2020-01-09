<?php
include 'cxfg.php';
define('DIR', dirname(__FILE__));
function read_keyword(){
	$keyword_sz = array();
	foreach (glob(DIR . '/peizhi/keyword/*.txt') as $keyword){
		$keyword_sz[] = basename($keyword);
	}
	$keyword_szsl = count($keyword_sz)-1;
	$keyword_qbnr = @file(DIR . '/peizhi/keyword/'.$keyword_sz[mt_rand(0,$keyword_szsl)]);
	$keyword_qbsl = count($keyword_qbnr)-1;
	$keyword_nr = trim($keyword_qbnr[mt_rand(0,$keyword_qbsl)]);
	return $keyword_nr;
}

function rdomain($_var_5)
{
	$_var_6 = array();
	return str_replace('*', dechex(date('s') . mt_rand(1111, 9999)) . $_var_6[rarray_rand($_var_6)], $_var_5);
}
function rarray_rand($_var_7)
{
	return mt_rand(0, count($_var_7) - 1);
}
function varray_rand($_var_8)
{
	return $_var_8[rarray_rand($_var_8)];
}
function get_folder_files($_var_9)
{
	$_var_10 = opendir($_var_9);
	while (false != ($_var_11 = readdir($_var_10))) {
		if ($_var_11 != '.' && $_var_11 != '..') {
			$_var_11 = "{$_var_11}";
			$_var_12[] = $_var_11;
		}
	}
	closedir($_var_10);
	return $_var_12;
}
function getTitle(){
	$wenku_list2 = get_folder_files(DIR . '/peizhi/bt/');
	$title = $bak_juzi2 = file(DIR . '/peizhi/bt/' . varray_rand($wenku_list2));
	return $title;
}
function getImg(){
	$img_list = get_folder_files(DIR . '/peizhi/img/');
	$img =  file(DIR . '/peizhi/img/' . varray_rand($img_list));
	return $img;
}
function getPic(){
	$pic_list = get_folder_files(DIR . '/peizhi/pic/');
	$pic =  file(DIR . '/peizhi/pic/' . varray_rand($pic_list));
	return $pic;
}
function getJz(){
	$wenku_list = get_folder_files(DIR . '/peizhi/juzi/');
	$juzi = $bak_juzi = file(DIR . '/peizhi/juzi/' . varray_rand($wenku_list));
	return $juzi;
}
function getDuankous(){
	$duankous = file(DIR . '/peizhi/wzmz/wzmz.txt');
	return $duankous;
}
function getLanmu(){
	$lanmu = file(DIR . '/peizhi/lanmu/lanmu.txt');
	return $lanmu;
}


/*$wenku_list = get_folder_files(DIR . '/peizhi/juzi/');
$wenku_list2 = get_folder_files(DIR . '/peizhi/bt/');
$title = $bak_juzi2 = file(DIR . '/peizhi/bt/' . varray_rand($wenku_list2));
$img_list = get_folder_files(DIR . '/peizhi/img/');
$img =  file(DIR . '/peizhi/img/' . varray_rand($img_list));
$pic_list = get_folder_files(DIR . '/peizhi/pic/');
$pic =  file(DIR . '/peizhi/pic/' . varray_rand($pic_list));
$juzi = $bak_juzi = file(DIR . '/peizhi/juzi/' . varray_rand($wenku_list));
$duankous = file(DIR . '/peizhi/wzmz/wzmz.txt');
$lanmu = file(DIR . '/peizhi/lanmu/lanmu.txt');*/
//保留外链
$wailian_list = get_folder_files(DIR . '/peizhi/wailian/');
$wailian = file(DIR . '/peizhi/wailian/' . varray_rand($wailian_list));
//$wailian = file(DIR . '/peizhi/wailian/wailian.txt');
	// php 获取当前访问的完整url
/*	function GetCurUrl() {
	    $url = 'http://';
	    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
	        $url = 'https://';
	    }
	     
	    // 判断端口
	    if($_SERVER['SERVER_PORT'] != '80') {
	        $url .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . ':' . $_SERVER['REQUEST_URI'];
	    } else {
	        $url .= $_SERVER['SERVER_NAME'] . '' . $_SERVER['REQUEST_URI'];
	    }
	     
	    return $url;
	}*/
	function GetCurUrlPath()
	{
		if(!empty($_SERVER["REQUEST_URI"]))
		{
			$scriptName = $_SERVER["REQUEST_URI"];
			$nowurl = $scriptName;
		}
		else
		{
			$scriptName = $_SERVER["PHP_SELF"];
			if(empty($_SERVER["QUERY_STRING"]))
			{
			$nowurl = $scriptName;
			}
			else
			{
			$nowurl = $scriptName."?".$_SERVER["QUERY_STRING"];
			}
		}
		return $nowurl;
	}
	function urlType(){
		$path = GetCurUrlPath();
		$origPath = explode('/', rtrim($path,'/'));
		if(!isset($origPath[1]) or strstr($origPath[1],"index")){
			return 0;
		}
		$path = $origPath[count($origPath)-1];
		$path = explode('.', $path);
		$type = 0;
		if(count($path)>1){
			$type = $path[0]!='index' ? 2 : 1;
		}else if(count($path)==1){
			$type = 1;
		}
		return $type;
	}
	//juzi
	function read_tpl($type=0){
		$urlType = urlType();
		$mobanPath = DIR.'/peizhi/moban';
		$mobanDir = ['index','list','show'];
		$mobanPath = $mobanPath.'/'.$mobanDir[$urlType];
		$tpl_sz = array();//echo "{$mobanPath}/*.html";exit;
		foreach(glob("{$mobanPath}/*.html") as $tpl){
			$tpl_sz[] = basename($tpl);
		}
		$tpl_szsl = count($tpl_sz)-1;
		$tpl_path = $mobanPath.'/'.$tpl_sz[mt_rand(0,$tpl_szsl)];//echo $tpl_path;exit;
		$tpl = file_get_contents($tpl_path);
		if($type){
			return ['content'=>$tpl,'path'=>$tpl_path];
		}
		return $tpl;
	}
	function zm_content($str){
		$content_sz = mb_str_split($str);
		foreach($content_sz as $content){
			$contents .= '&#'.base_convert(bin2hex(mb_convert_encoding($content, 'ucs-4', 'utf-8')), 16, 10).';';
		}
		return $contents;
	}

	function mb_str_split($str){  
   		return preg_split('/(?<!^)(?!$)/u', $str );  
	} 

	function randCode($length, $type) {
    $arr = array(1 => "abcdefghijklmnopqrstuvwxyz", 2 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 3 => "0123456789");
    	if($type == 0) {
        	array_pop($arr);
        	$string = implode("", $arr);
    	}elseif($type == "-1") {
        	$string = implode("", $arr);
    	}else{
        	$string = $arr[$type];
    	}
    	$count = strlen($string) - 1;
    	for($i = 0; $i < $length; $i++) {
        	$str[$i] = $string[rand(0, $count)];
        	$code .= $str[$i];
    	}
    	return $code;
	}

	function read_var(){
		$var_sz = file(DIR . '/peizhi/zhon.txt');
		$var = trim($var_sz[mt_rand(0,count($var_sz)-1)]);
		return $var;
	}

	function read_victitle(){
		$vic_sz = file(DIR . '/peizhi/hou.txt');
		$vic = trim($vic_sz[mt_rand(0,count($vic_sz)-1)]);
		return $vic;
	}

	
	function read_luanma(){
		$juzi = read_data('ly_juzi');
		$luanma = iconv("gb2312","utf-8//IGNORE",$juzi);
		return $luanma;
	}
?>