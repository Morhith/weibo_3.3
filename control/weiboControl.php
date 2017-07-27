<?php

// 微博控制器
class  weiboControl extends baseControl{


	public function index()
	{
		$weibo_list = $this->model("weibo")->getList();

		$this->assign('weibo_list',$weibo_list);

		$this->display("weibo.html");
	}
	//长微博
	public function send_long()
	{ 
		// $this->display("weibo_long.html");
	}
	public function save()
	{	
		// $this->model("weibo")->addInfo("weibo_detailed",array("weibo_content"=>$_POST['content']));
	
	}
	public function send_content(){	
		return $this->model("weibo")->addInfo("weibo_content",$_POST);
	}

	//获取最近几条信息
	/**
	 * [getLastInfo 获取最近几条信息]
	 * @return [type] [description]
	 */
	public function getLastInfo()
	{
		 
		// $weibo_list= $this->model("weibo")->getLastInfo($_REQUEST['uid']);
		
		echo json_encode($weibo_list);
	}




}

?>