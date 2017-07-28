<?php
class  userControl extends baseControl{
	public function index()
	{
		// $smarty->display("weibo.html");
	}
	//注册
	public function register(){
		$_POST['create_user_time'] = time();
		$_POST['user_pic'] = "";
		return $this->model("user")->addInfo("weibo_user",$_POST);
	}
	//匹配
	public function issetUser(){
		$res =  $this->model("user")->getInfoByclo("weibo_user",$_POST);
		if(!empty($res)){
			unset($res['user_password']);

			$this->login($res);

			$this->reJson('1',$res);
		}
		else{
			$this->reJson('0',$res);
		}
	}
	//登录
	public function login($res){
		session_start();
		$_SESSION['user_id'] =$res[0]['user_id'] ;
		$_SESSION['user_name'] = $res[0]['user_name'];
		$_SESSION['user_pic'] = $res[0]['user_pic'];
	}
	//退出
	public function logout(){
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