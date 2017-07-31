<?php 
class baseControl{

	// smarty实例化
	
	private  $smarty;
	
	function __construct(){

		$this->smarty = new Smarty();

		$this->smarty->template_dir = "view";
	}

	// 获取子类需要实例化的模型对象
	public function model($model_name)
	{
		 require_once "model/$model_name.php";
		 return  new $model_name("mysql:dbhost=localhost;dbname=weibo_db;charset=utf8","root","",true);
	}

	public function display($html)
	{
		$this->smarty->display($html);
	}

	public function assign($name,$value)
	{
		$this->smarty->assign($name,$value);
	}
	public function fetch($name,$value)
	{
		return $this->smarty->fetch($name,$value);
	}

	public function reJson($status,$redata=array()){
		echo json_encode(array(
				'status'=> $status,
				'rearray'=> $redata
			));
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
		$comment_num= $this->model("praise")->praisenumByContentId($value['content_id']);
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
			$new_weibo_list[$key]["praise_num"] = $comment_num[0]['num'];
		}
		return $new_weibo_list;
	}
	// 入口文件调用
	public function run()
	{
		$control_str ="weibo";
		if(!empty($_REQUEST['control'])){
			$control_str = $_REQUEST['control'];
		}
		$control_name =  $control_str.'Control';
		require_once "control/$control_name.php";

		$control  = new $control_name();
		// $user  = new userControl();
		if (!empty($_REQUEST['action'])) {
			$action = $_REQUEST['action'];
			$control ->$action();
		}else{
			$control ->index();
		}

	}
}


 ?>