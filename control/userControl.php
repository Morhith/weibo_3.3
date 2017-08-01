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
	//修改用户信息
	public function upUserpic(){
		//获取上传的用户id
		// $user_id = $_POST['user_id'];
		//查询数据库获取用户头像的图片路径
		$user = $this->model("user")->getInfoByclo("weibo_user",$_POST)[0];
		//判断是否为默认的头像，是则不做删除，否则删除旧的图片
		if('staticImages/show3.jpg'!=$user['user_pic']){
			//获取文件
			$file = $user['user_pic'];
			//判断是否有该文件，有则删除，否则不做操作
			if (is_file($file)) {
				unlink($file);
			}				
		}
		//保存文件
		//判断是否有文件
		if(!empty($_FILES['save_file']['tmp_name'])){
			//反转文件名
			$string = strrev($_FILES['save_file']['name']);
			//获取后缀名
	        $array = explode('.',$string);
	        //设定新的文件名
	        $user_pic =  'weibofile/userHp/'.time().rand(0,999).'.'.strrev($array[0]);
	        //转存到指定的文件夹
	        move_uploaded_file($_FILES['save_file']['tmp_name'], $user_pic);
	        //执行数据入库操作
	        if($this->model("user")->updataInfo("weibo_user",array("user_pic"=>$user_pic),"user_id",$_POST['user_id'])){
	        	//成功则开启会话，保存用户的图片
	        	session_start();
	        	$_SESSION['user_pic'] = $user_pic;
	        	//返回图片的路径
	        	$this->reJson('1',$user_pic);
	        }else{
	        	$this->reJson('0');
	        }
	    }
	    else{
	    	$this->reJson('2');
	    }
	}
}

?>