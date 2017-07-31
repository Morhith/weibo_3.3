<?php
class  userControl extends authControl{
	public function index()
	{
		// $smarty->display("weibo.html");
	}
	//注册
	public function register(){
		$_POST['create_user_time'] = time();
		$_POST['user_pic'] = "staticImages/show3.jpg";
		$_POST['user_status'] = "0";
		$_POST['user_auth '] = '1';
		if(empty($_POST['user_name'])){
			$_POST['user_name'] ="user_".$_POST['user_phone'];
		}
		$user_id = $this->model("user")->addInfo("weibo_user",$_POST);
		if($user_id>0){
			$this->reJson('1',$content_id);
		}else{
			$this->reJson('0');
		}
	}
	//匹配
	public function issetUserName(){
		$res =  $this->model("user")->getInfoByclo("weibo_user",$_POST);
		if(empty($res)){
			$this->reJson('1');
		}
		else{
			$this->reJson('0');
		}
	}
	//登录
	public function issetUser(){
		$res =  $this->model("user")->getInfoByclo("weibo_user",$_POST);
		if(!empty($res)){
			unset($res[0]['user_password']);

			$reval = $this->login($res);

			// $this->assign("item",$new_content);

			// // html编码统一返回null
			if($reval){
				$html = $this->fetch("mainTest.html",$res);
				$res[0]['html'] = $html; 
				$this->reJson('1',$res[0]);
			}else{
				$this->reJson('2');
			}
		}
		else{
			$this->reJson('0');
		}
	}
	//登录
	public function login($res){
		$reval =$this->model("user")->updataInfo("weibo_user",array("user_status"=>1),"user_id",$res[0]['user_id']);
		if($reval){
			session_start();
			$_SESSION['user_id'] =$res[0]['user_id'] ;
			$_SESSION['user_name'] = $res[0]['user_name'];
			$_SESSION['user_pic'] = $res[0]['user_pic'];
			return true;
		}else{
			return false;
		}
	}
	//退出
	public function logout(){
		$reval =$this->model("user")->updataInfo("weibo_user",array("user_status"=>0),"user_id",$_POST['user_id']);
		if($reval){
			session_start();
			unset($_SESSION['uid']);
			unset($_SESSION['user_name']);
			unset($_SESSION['user_pic']);
			if(session_destroy()){	
				$this->reJson('1');
			}
			else{
				$this->reJson('0');
			}
		}else{
			$this->reJson('2');
		}	
	}
	//关注
	public function follow(){

	}
	//取消关注
	public function unFollow(){

	}
	//添加好友
	public function addFriend(){

	}
	//删除好友
	public function delFriend(){

	}
}

?>