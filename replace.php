<?php
	$commonData = $userDataArr = [];
	$commonData['read_tpl'] = $html;
	$userDataArr['visiter_key'] = $visiterKey;
	if(strstr($html,'<ky目录>')){
		if(isset($res['mulu_name'])){
			$mulu_name = $res['mulu_name'];
		}else{
			$commonData['mulu_name'] = $mulu_name;
		}
		$html = preg_replace('/<ky目录>/',$mulu_name,$html);
		
	}
	if(strstr($html,'<ky当前地址>')){
		if(isset($res['url'])){
			$url = $res['url'];
		}else{
			$commonData['url'] = $url;
		}
		$html = preg_replace('/<ky当前地址>/',$url,$html);
	}
	if(strstr($html,'<ky当前域名>')){
		if(isset($res['yuming'])){
			$yuming = $res['yuming'];
		}else{
			$commonData['yuming'] = $yuming;
		}
		$html = preg_replace('/<ky当前域名>/',$yuming,$html);
	}

	if(strstr($html,'<ky句子>')){
		$wk = count(explode('<ky句子>', $html)) - 1;
		//按人存
		if(isset($res['ky_juzi'])){
			for ($wi = 0; $wi < $wk; $wi++) {
				$newtext = $res['ky_juzi'][$wi];
				$newtext = preg_replace_callback("/(。|？|！|；|…|·|—)/iUs", "dyy_xgl", $newtext);
				$newtext = UnicodeEncode($newtext);
				$html = preg_replace('/<ky句子>/', $newtext, $html, 1);
			}	
		}else{
			for ($wi = 0; $wi < $wk; $wi++) {
				$userDataArr['ky_juzi'][$wi] = trim(varray_rand($juzi));
				$newtext = preg_replace_callback("/(。|？|！|；|…|·|—)/iUs", "dyy_xgl", $userDataArr['ky_juzi'][$wi]);
				$newtext = UnicodeEncode($newtext);
				$html = preg_replace('/<ky句子>/', $newtext, $html, 1);
			}		
		}
		
	}

	if(strstr($html,'<ky变态句子>')){
		//按人存
		$i0 = 0;
		if(isset($res['ky_btjz'])){
			while(strstr($html,'<ky变态句子>')){
				$zm_juzi = $res['ky_btjz'][$i0];
				$i0++;
				$html = preg_replace('/<ky变态句子>/',$zm_juzi,$html,1);
			}	
		}else{
			while(strstr($html,'<ky变态句子>')){
				$zm_juzi = zm_content($juzi);
				$userDataArr['ky_btjz'][$i0]=$zm_juzi;
				$i0++;
				$html = preg_replace('/<ky变态句子>/',$zm_juzi,$html,1);
			}			
		}

	}
	

	if(strstr($html,'<ky标题>')){
		$wk = count(explode('<ky标题>', $html)) - 1;
		//按人存
		if(isset($res['ky_bt'])){
			for ($wi = 0; $wi < $wk; $wi++) {
				$html = preg_replace('/<ky标题>/', $res['ky_bt'][$wi], $html, 1);
			}
		}else{
			for ($wi = 0; $wi < $wk; $wi++) {
				$cur_kybt = trim(varray_rand($title));
				$userDataArr['ky_bt'][$wi]=$cur_kybt;
				$html = preg_replace('/<ky标题>/',$cur_kybt, $html, 1);
			}		
		}
		
	}
	if(strstr($html,'<ky图片>')){
		$wk = count(explode('<ky图片>', $html)) - 1;
		//按人存
		if(isset($res['cur_kytp'])){
			for ($wi = 0; $wi < $wk; $wi++) {//var_dump($res['ky_tp'][$wi]);exit('33');
				$html = preg_replace('/<ky图片>/', $res['cur_kytp'][$wi], $html, 1);
			}
		}else{		
			for ($wi = 0; $wi < $wk; $wi++) {//exit('533');
				$cur_kytp = trim(varray_rand($pic));
				$userDataArr['cur_kytp'][$wi]=$cur_kytp;
				$html = preg_replace('/<ky图片>/', $cur_kytp, $html, 1);
			}		
		}
		
	}
	if(strstr($html,'<ky小图>')){
		$wk = count(explode('<ky小图>', $html)) - 1;
		//按人存
		if(isset($res['ky_xt'])){
			for ($wi = 0; $wi < $wk; $wi++) {
				$html = preg_replace('/<ky小图>/', $res['ky_xt'][$wi], $html, 1);
			}	
		}else{	
			for ($wi = 0; $wi < $wk; $wi++) {
				$cur_kyxt = trim(varray_rand($img));
				$userDataArr['ky_xt'][$wi] = $cur_kyxt;
				$html = preg_replace('/<ky小图>/', $cur_kyxt, $html, 1);
			}	
		}
		
	}

	if(strstr($html,'<ky乱码>')){		
		//按人存
		$i0=0;	
		if(isset($res['ky_luanma'])){
			while(strstr($html,'<ky乱码>')){
				$luanma = $res['ky_luanma'][$i0];
				$i0++; 
				$html = preg_replace('/<ky乱码>/',$luanma,$html,1);
			}
		}else{
			while(strstr($html,'<ky乱码>')){
				$luanma = zm_content(read_luanma());
				$userDataArr['ky_luanma'][$i0] = $luanma;
				$i0++; 
				$html = preg_replace('/<ky乱码>/',$luanma,$html,1);
			}
		}
	}

	if(strstr($html,'<ky权重标题>')){		
		//按人存
		$dk = count(explode('<ky权重标题>', $html)) - 1;
		if(isset($res['ky_qzbt'])){
			for ($di = 0; $di < $dk; $di++) {

				$html = preg_replace('/<ky权重标题>/', $res['ky_qzbt'][$di], $html, 1);
			}	
		}else{
			for ($di = 0; $di < $dk; $di++) {
				$cur_qzbt = trim(varray_rand($duankous));
				$userDataArr['ky_qzbt'][$di] = $cur_qzbt;

				$html = preg_replace('/<ky权重标题>/', $cur_qzbt, $html, 1);
			}		
		}	
	}
	if(strstr($html,'<ky栏目名称>')){		
		//按人存
		$dk = count(explode('<ky栏目名称>', $html)) - 1;
		if(isset($res['ky_lmmc'])){
			for ($di = 0; $di < $dk; $di++) {
				$cur_lmmc = $res['ky_lmmc'][$di];
				$html = preg_replace('/<ky栏目名称>/', $cur_lmmc, $html, 1);
			}	
		}else{
			for ($di = 0; $di < $dk; $di++) {
				$cur_lmmc = trim(varray_rand($lanmu));
				$userDataArr['ky_lmmc'][$di] = $cur_lmmc;

				$html = preg_replace('/<ky栏目名称>/', $cur_lmmc, $html, 1);
			}		
		}
		
	}

	if(strstr($html,'<ky时间>')){		
		//按人存
		if(isset($res['ky_sj'])){
			$time = $res['ky_sj'];
			$html = preg_replace('/<ky时间>/',$time,$html);				
		}else{
			$userDataArr['ky_sj'] = $time = date("Y年m月d日 H:i");
			$html = preg_replace('/<ky时间>/',$time,$html);		
		}

	}
	if(strstr($html,'<ky当天时间>')){		
		//按人存
		if(isset($res['ky_dtsj'])){
			$time = $res['ky_dtsj'];
			$html = preg_replace('/<ky当天时间>/',$time,$html);			
		}else{
			$userDataArr['ky_dtsj'] = $time = date("Y年m月d日 ");
			$html = preg_replace('/<ky当天时间>/',$time,$html);	
		}
	}

	if(strstr($html,'<ky关键词>')){
		if(isset($res['_keyword'])){
			$_keyword = $res['_keyword'];		
		}else{
			$commonData['read_keyword'] = $_keyword;
		}
		$html = preg_replace('/<ky关键词>/', $_keyword, $html);	
	}

	if(strstr($html,'<ky变态关键词>')){
		if(isset($res['bt_keyword'])){
			$keyword = $res['bt_keyword'];
		}else{
			$keyword = zm_content($_keyword);
			$commonData['bt_keyword'] = $keyword;
		}
		
		$html = preg_replace('/<ky变态关键词>/',$keyword,$html);
	}
/*	if(strstr($html,'<ky变态关键词>')){var_dump($_keyword);
		if(empty($res['bt_keyword'])){
			$keyword = zm_content($_keyword);
			$commonData['bt_keyword'] = $keyword;
		}else{
			$keyword = $res['bt_keyword'];
			$html = preg_replace('/<ky变态关键词>/',$keyword,$html);			
		}
	}*/

	if(strstr($html,'<ky随机字符>')){		
		//按人存
		$i0 = 0;
		if(isset($res['ky_sjzf'])){
			while(strstr($html,'<ky随机字符>')){
				$cur_sjzf = $res['ky_sjzf'][$i0];
				$i0++;
				$html = preg_replace('/<ky随机字符>/',$cur_sjzf,$html,1);
			}		
		}else{
			while(strstr($html,'<ky随机字符>')){
				$userDataArr['ky_sjzf'][$i0] = $cur_sjzf = randCode(mt_rand(2,8),-1);
				$i0++;
				$html = preg_replace('/<ky随机字符>/',$cur_sjzf,$html,1);
			}
		}
	}

	if(strstr($html,'<ky随机数字>')){		
		//按人存
		$i0 = 0;
		if(isset($res['ky_sjsz'])){
			while(strstr($html,'<ky随机数字>')){
				$cur_sjsz = $res['ky_sjsz'][$i0];
				$i0++;
				$html = preg_replace('/<ky随机数字>/',$cur_sjsz,$html,1);
			}		
		}else{
			while(strstr($html,'<ky随机数字>')){
				$userDataArr['ky_sjsz'][$i0] = $cur_sjsz = randCode(mt_rand(3,7),3);
				$i0++;
				$html = preg_replace('/<ky随机数字>/',$cur_sjsz,$html,1);
			}
		}
	}

	

	if(strstr($html,'<ky随机字母>')){		
		//按人存
		$i0 = 0;
		if(isset($res['ky_sjzm'])){
			while(strstr($html,'<ky随机字母>')){
				$cur_sjzm = $res['ky_sjzm'][$i0];
				$i0++;
				$html = preg_replace('/<ky随机字母>/',$cur_sjzm,$html,1);
			}		
		}else{
			while(strstr($html,'<ky随机字母>')){
				$userDataArr['ky_sjzm'][$i0] = $cur_sjzm = randCode(mt_rand(3,7),0);
				$i0++;
				$html = preg_replace('/<ky随机字母>/',$cur_sjzm,$html,1);
			}
		}
/*		while(strstr($html,'<ky随机字母>')){
			$html = preg_replace('/<ky随机字母>/',randCode(mt_rand(3,7),0),$html,1);
		}*/
	}

	if(strstr($html,'<ky吸引标题>')){
		if(!isset($res['var'])){
			$commonData['var'] = $var = read_var();
		}else{
			$var = $res['var'];
		}
		
		$html = preg_replace('/<ky吸引标题>/',$var,$html);
	}

	if(strstr($html,'<ky关键词2>')){
		if(!isset($res['vic_title'])){
			$commonData['read_victitle'] = $vic_title;
		}else{
			$vic_title = $res['vic_title'];
		}
		$html = preg_replace('/<ky尾部关键词2>/',$vic_title,$html);
	}
   if(strstr($html,'<ky变态关键词2>')){
   		if(isset($res['ky_btgjc2'])){
			$biant2 = $res['ky_btgjc2'];
   		}else{
			$vic_title = read_victitle();
			$biant2 = zm_content($vic_title);
			$userDataArr['ky_btgjc2'] =  $biant2; 			
   		}
		$html = preg_replace('/<ky变态关键词2>/',$biant2,$html);
	}

	if(strstr($html,'<ky短字符>')){
		if(isset($res['ky_dzf'])){
			$dzf = $res['ky_dzf'];		
		}else{
			$userDataArr['ky_dzf'] = $dzf = randCode(mt_rand(3,6),1);
		}		
		//按人存
		$html = preg_replace('/<ky短字符>/',$dzf,$html);
	}

	if(strstr($html,'<ky随机关键词>')){		
		//按人存
		$i0 = 0;
		if(isset($res['ky_sjgjc'])){
			while(strstr($html,'<ky随机关键词>')){
				$sj_keyword = $res['ky_sjgjc'][$i0];
				$i0++;
				$html = preg_replace('/<ky随机关键词>/',$sj_keyword,$html,1);
			}		
		}else{
			while(strstr($html,'<ky随机关键词>')){
				$userDataArr['ky_sjgjc'][$i0] = $sj_keyword = read_keyword();
				$i0++;
				$html = preg_replace('/<ky随机关键词>/',$sj_keyword,$html,1);
			}
		}
/*		while(strstr($html,'<ky随机关键词>')){
			$sj_keyword = read_keyword();
			$html = preg_replace('/<ky随机关键词>/',$sj_keyword,$html,1);
		}*/
	}

	//保留
	if(strstr($html,'<ky随机外链>')){
	
		$dk = count(explode('<ky随机外链>', $html)) - 1;
		for ($di = 0; $di < $dk; $di++) {
			$html = preg_replace('/<ky随机外链>/', trim(varray_rand($wailian)), $html, 1);
		}
		
	}
	function dyy_xgl($aa=array('')) {
	    $xxgl[0] = "";
	    $xxgl[1] = "";
	    $xxgl[2] = "";
	    $xxgl[3] = "";
	    $ds = mt_rand(3, 5);
	    $hash = "";
	    for ($i = 0; $i < $ds; $i++) {
	        $hash.= $xxgl[mt_rand(0, 3) ];
	    }
	    return $aa[0].$hash ;
		//return $hash.$aa[0] ;
	}
	function UnicodeEncode($str){
	    //split word
	    preg_match_all('/./u',$str,$matches);
	 
	    $unicodeStr = "";
	    foreach($matches[0] as $m){
	        //拼接
	        $unicodeStr .=$m;
	    }
	    return $unicodeStr;
	}
?>