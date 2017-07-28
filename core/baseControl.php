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

	public function reJson($status,$redata=array()){
		echo json_encode(array(
				'status'=> $status,
				'rearray'=> $redata
			));
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