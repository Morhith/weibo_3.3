<?php
class  userControl extends baseControl{
	public function index()
	{
		// $smarty->display("weibo.html");
	}
	public function register(){
		$_POST['create_user_time'] = time();
		return $this->model("user")->addInfo("weibo_user",$_POST);
	}

	public function login()
	{
		
		// where user_name =1 and user_password=2
		$this->model("user")->getInfoByclo("weibo_user",$_POST);
		return $this->model("user")->addInfo("weibo_user",$_POST);
	}

	
}

?>