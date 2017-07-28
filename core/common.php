<?php
	 function uploadUserFile($file_save){
		if(!empty($_FILES['save_file']['tmp_name'])){
			$string = strrev($_FILES['save_file']['name']);
	        $array = explode('.',$string);
			$weibo_file =  '$file_save/'.time().'.'.strrev($array[0]);
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
?>