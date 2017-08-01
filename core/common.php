<?php
	//上传文件
	function uploadUserFile($file_save){
		if(!empty($_FILES['save_file']['tmp_name'])){
			$string = strrev($_FILES['save_file']['name']);
	        $array = explode('.',$string);
			$weibo_file =  "$file_save/".time().rand(0,999).".".strrev($array[0]);
			//存储文件
			if(move_uploaded_file($_FILES['save_file']['tmp_name'], $weibo_file)){	
			//反馈图片名字
				return $weibo_file;
			}else{
				return '上传失败';
			}
		}
		else{
			return '文件为空';
		}
	}
	//计算时间
	function format_date($time){
		 	$text = '';
		    // $time = $time === NULL || $time > time() ? time() : intval($time);
		    $t = time() - $time; //时间差 （秒）
		    $y = date('Y', $time)-date('Y', time());//是否跨年
		    switch($t){
		     case $t < 60:
		      $text = '刚刚'; // 一分钟内
		      break;
		     case $t < 3600:
		      $text = floor($t / 60) . '分钟前'; //一小时内
		      break;
		     case $t < 86400:
		      $text = floor($t / (60 * 60)) . '小时前'; // 一天内
		      break;
		     case $t < 259200:
		      $text = floor($time/(60*60*24)) ==1?'昨天'.date('H:i', $time) : '前天 '.date('H:i', $time); //昨天和前天
		      break;
		     case $t < 2592000:
		      $text = "个月前"; //一个月内
		      break;
		     case $t < 31536000&&$y==0:
		      $text = date('m月d日', $time); //一年内
		      break;
		     default:
		      $text = "1年以前"; //一年以前
		      break; 
		    }
    		return $text;
	}
?>