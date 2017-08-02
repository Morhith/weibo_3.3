<?php
	class authControl extends baseControl{
		function __construct(){
			parent::__construct();
		}
		//用户是否登录
		public function hasLogin(){
			session_start();
			$user_name = '';
			if ($_SESSION['user_id']>0){
				$user_id = $_SESSION['user_id'];
				$this->assign("user_name",$_SESSION['user_name']);
				$this->assign("user_pic",$_SESSION['user_pic']);
			}
			return $user_id;
		}
		//判断是否有权限
		public function joinUserpic($res){
			$new_weibo_list = $res;
			$user_id=$this->hasLogin();
			foreach ($res as $key=>$value) {
			// $comment_num= $this->model("comment")->commentnumByContentId($value['content_id']);
			$praise_num= $this->model("praise")->praisenumByContentId($value['content_id']);
			$collection = '';
			if(!empty($user_id)){	
				$collection = $this->model("weibo")->getInfoByclo("weibo_collection",array("content_id"=>$value['content_id'],"user_id"=>$user_id))[0];
				// print_r($collection);
			}
			if(!empty($value['user_id'])){
				$user = 
				$this->model("user")->getInfoByclo('weibo_user',array('user_id'=>$value['user_id']))[0];
				$user_pic = $user['user_pic'];
				if(!empty($user_pic)){
					$new_weibo_list[$key]["user_pic"]=$user_pic;
				}else{
					$new_weibo_list[$key]["user_pic"]='staticImages/user_head.jpg';
				}

				if($user_id == $value['user_id']){
					$new_weibo_list[$key]["del_content"] = '1';
				}else{
					$new_weibo_list[$key]["del_content"] = '0';
				}
			}
			else{
				$new_weibo_list[$key]["user_pic"]='staticImages/user_head.jpg';
			}
				$new_weibo_list[$key]["comment_num"] = $comment_num[0]['num'];
				$new_weibo_list[$key]["praise_num"] = $praise_num[0]['num'];
				if(!empty($collection)){
					$new_weibo_list[$key]["collection"] = '1';
				}else{
					$new_weibo_list[$key]["collection"] = '0';
				}
			}
			return $new_weibo_list;
		}
	}
?>