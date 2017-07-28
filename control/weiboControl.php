<?php

// 微博控制器
class  weiboControl extends baseControl{


	public function index()
	{
		$weibo_list = $this->model("weibo")->getInfoAll("weibo_content");

		// var_dump($weibo_list);
		
		session_start();
		$user_name = '';
		if ($_SESSION['user_id']>0){
			$user_name = $_SESSION['user_name'];
			$this->assign("user_name",$user_name);
			$this->assign("user_pic",$_SESSION['user_pic']);
		}

		$this->assign('weibo_list',$weibo_list);

		$this->display("main.html");
	}
	//长微博
	public function send_long()
	{ 
		
	}
	public function save()
	{	
		
	}
	/**
	 * [send_content 短微博的发表]
	 * @return [type] [description]
	 */
	public function send_content(){
		//判断是否存在
		if(isset($_FILES['save_file']['tmp_name'])){
			$file_name = '';
			if(1==$_POST['type']){
				$file_name = 'images';
			}else if(2==$_POST['type']){
				$file_name = 'music';
			}else if(3==$_POST['type']){
				$file_name = 'video';
			}
			$save_file=uploadUserFile($file_name);
		}
		return $this->model("weibo")->addInfo("weibo_content",$_POST);
	}
	//获取最近几条信息
	/**
	 * [getLastInfo 获取最近几条信息]
	 * @return [type] [description]
	 */
	public function getLastInfo()
	{
		$res = $this->model("weibo")->getInfoByclo("weibo_content",array('user_id'=>'1'),1);
		if(!empty($res)){
		   $this->reJson('1',$res);
		}
		else{
			$this->reJson('0');
		}
	}
	//收藏
	public function collection(){

	}
	//转发
	public function transmite(){

	}
	//点赞
	public function praise(){

	}
}

?>