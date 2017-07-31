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
				$user_name = $_SESSION['user_name'];
				$this->assign("user_name",$user_name);
				$this->assign("user_pic",$_SESSION['user_pic']);
			}
			return $user_name;
		}
		//判断是否有权限
		public function joinUserpic($res){
			$new_weibo_list = $res;
			$user_name=$this->hasLogin();
			foreach ($res as $key=>$value) {
			$comment_num= $this->model("comment")->commentnumByContentId($value['content_id']);
			$praise_num= $this->model("praise")->praisenumByContentId($value['content_id']);
			if(!empty($value['user_id'])){
				$user = 
				$this->model("user")->getInfoByclo('weibo_user',array('user_id'=>$value['user_id']))[0];
				$user_pic = $user['user_pic'];
				if(!empty($user_pic)){
					$new_weibo_list[$key]["user_pic"]=$user_pic;
				}else{
					$new_weibo_list[$key]["user_pic"]='staticImages/user_head.jpg';
				}

				if($user_name == $user['user_name']){
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
			}
			return $new_weibo_list;
		}
	}
?>