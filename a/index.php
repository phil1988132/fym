<?php
error_reporting(0);
set_time_limit(0);
date_default_timezone_set("Asia/Shanghai");
//ini_set('memory_limit','1028M');
$arr = explode("/",$_SERVER['REQUEST_URI']);
$num = sizeof($arr);
function rand_str($length = 5)
{
	$str    = '';
	$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	$max    = strlen($strPol)-1;
	for($i = 0; $i < $length; $i++)
	{
	$str   .=$strPol[rand(0,$max)];
	}
	return $str;
}
header("Content-type: text/html; charset=utf-8");
if($arr[$num - 1] == 'sitemap.xml'){
	header("Content-Type: text/xml");
	$map = "\t<urlset>\r\n";
	$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
	$date = date("Y-m-d");
	for($i=0;$i<2000;$i++){
	$tmp = $host.rand_str().'/'.rand_str().'.xml';
	$map .= "\t\t<url>\n";
	$map .= "\t\t\t<loc>{$tmp}</loc>\r\n";
	$map .= "\t\t\t<priority>{$date}</priority>\r\n";
	$map .= "\t\t\t<lastmod>daily</lastmod>\r\n";
	$map .= "\t\t\t<changefreq>0.8</changefreq>\r\n";
	$map .= "\t\t</url>\n";
	}
	$map .= "\t</urlset>";
	echo $map;
	die;
}
if($arr[$num - 1] == 'sitemap.txt'){
	header("Content-Type: text/txt");
	$map = "";
	$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
	$date = date("Y-m-d");
	for($i=0;$i<1000;$i++){
	$tmp = $host.rand_str().'/'.rand_str().'.xml';
	$map .= "{$tmp}\r";
	}
	$map .= "";
	echo $map;
	die;
}
header('HTTP/1.1 200 OK');
function GetRandStr($length){
	$str='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$len=strlen($str)-1;
	$randstr='';
	for($i=0;$i<$length;$i++){
	$num=mt_rand(0,$len);
	$randstr .= $str[$num];
	}
	return $randstr;
}
$number=GetRandStr(6);
$visiterKey = sha1($_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]);
$cachefile = 'cache/'.$visiterKey.'.txt';//如需要动态请修改成：$number
ob_start();
if(file_exists($cachefile)){	
	include($cachefile);
	ob_end_flush();
	exit;
}	
$res = [];
include 'func.php';
$dbInfo = include './db/conn.php';
include './db/mmysql.php';
$mysql = new \MMYsql($dbInfo);
if(!empty($visiterKey)){
	$res = getUserData($mysql,$visiterKey,$_SERVER['HTTP_HOST'],$_SERVER['SERVER_NAME']);
	//var_dump($res);exit;
}
include 'config.php';
/*print_r(urlType());exit;*/
//其他
//end其他
//$html = read_tpl(1);var_dump($html['path']);exit;
if(empty($res)){
	$_keyword = read_keyword();
	$vic_title = read_victitle();
	$html = read_tpl();

	$title = $bak_juzi2 = getTitle();
	$img =  getImg();
	$pic =  getPic();
	$juzi = $bak_juzi = getJz();
	$duankous = getDuankous();
	$lanmu = getLanmu();
	$mulu_name = '/';//
	$url=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$yuming=$_SERVER['HTTP_HOST'];
	//var_dump($yuming);var_dump($url);exit('332');	
}else{
	$html = $res['read_tpl'];
}
include 'replace.php';
echo $html;
include './add.php';exit;
if(is_dir('cache')){
	$info = ob_get_contents();
	file_put_contents($cachefile,$info);
}else{
	if(@mkdir('cache')){
		$info = ob_get_contents();
		file_put_contents($cachefile,$info);
	}
}

?>



