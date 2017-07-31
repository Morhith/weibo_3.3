<?php

// 微博控制器
class  weiboControl extends authControl{


	public function index()
	{
		$weibo_list = $this->model("weibo")->getInfoAll("weibo_content",1,"content_id");

		// var_dump($weibo_list);
		
		$this->hasLogin();
		$weibo_list = $this->joinUserpic($weibo_list);

		$this->assign('weibo_list',$weibo_list);

		$this->display("mainTestRight.html");
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
		$user = $this->model("user")->getInfoByclo('weibo_user',array('user_id'=>$_POST['user_id']))[0];
		if(0==$_POST['type']){
				$_POST['type'] = '短微博';
				$val = 1;
		}else{
			//判断是否存在文件
			if(isset($_FILES['save_file']['tmp_name'])){
				$file_name = '';
				if(1==$_POST['type']){
					$file_name = 'weibofile/images';
					$_POST['pic'] = uploadUserFile($file_name);
					$_POST['type'] = '图片';
					$val = 1;
				}else if(2==$_POST['type']){
					if(1!=$user['user_status']){
						$file_name = 'weibofile/music';
						$_POST['music'] = uploadUserFile($file_name);
						$_POST['type'] = '音乐';
						$val = 1;
					}else{
						$val = 0;
					}
				}else if(3==$_POST['type']){
					if(1!=$user['user_status']){
						
						$file_name = 'weibofile/video';
						$_POST['video'] = uploadUserFile($file_name);
						$_POST['type'] = '视频';
						$val = 1;
					}else{
						$val = 0;
					}
				}
			}
		}
		if($val>0){
			$_POST['create_content_time'] = time();
			$content_id =  $this->model("weibo")->addInfo("weibo_content",$_POST);
			if($content_id>0){
				$_POST['content_id'] = $content_id;
				$this->reJson('1',$_POST);
			}else{
				$this->reJson('0');
			}
		}else{
			$this->reJson('2');
		}
	}
	/**
	 * [search_weibo description]
	 * @return [type] [description]
	 */
	public function search_weibo(){
		$res = $this->model("weibo")->getInfoByclo("weibo_content",$_POST);
		$this->hasLogin();
		if(!empty($res)){
			$res = $this->joinUserpic($res);
			$this->assign("weibo_list",$res);
			$html = $this->fetch("weibo_list.html",$res);
			$res['html'] = $html; 
		    $this->reJson('1',$res);
		}
		else{
			$this->reJson('0');
		}
	}
	//获取最近几条信息
	/**
	 * [getLastInfo 获取最近几条信息]
	 * @return [type] [description]
	 */
	public function getLastInfo()
	{
		$res = $this->model("weibo")->getInfoByclo("weibo_content",$_POST,1);
		if(!empty($res)){
		   $this->reJson('1',$res);
		}
		else{
			$this->reJson('0');
		}
	}
	//收藏
	public function collectionAdd(){
		
	}
	//取消收藏
	public function collectionclose(){
		
	}
	//转发
	public function transmite(){

	}
	//点赞
	public function praise(){
		$res = $this->model("praise")->getInfoByclo("weibo_praise",$_POST);
		if (!empty($res)) {
			if($this->model("praise")->deleteOneInfo("weibo_praise",$_POST)){
				$this->reJson('2');
			}else{
				$this->reJson('3');
			}
		}else{
			$content_id =  $this->model("praise")->addInfo("weibo_praise",$_POST);
			if($content_id>0){
				$this->reJson('1',$content_id);
			}else{
				$this->reJson('4');
			}
		}
	}
	//取消点赞
	public function praiseclose(){
		
	}
}

?>