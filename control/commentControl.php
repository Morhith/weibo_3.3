<?php 
	class commentControl extends authControl{
		/**
		 * [send_comment 发表评论]
		 * @return [type] [description]
		 */
		public function send_comment(){
			$_POST['create_comment_time'] = time();
			$comment_id =  $this->model("comment")->addInfo("weibo_comment",$_POST);
			if($comment_id>0){
				$_POST['comment_id'] = $comment_id;
				$this->reJson('1',$_POST);
			}else{
				$this->reJson('0');
			}
		}
		public function find_comment(){
			$comment_list =  $this->model("comment")->commentFindByconntentId($_POST['content_id']);

			if(!empty($comment_list)){
				$comment_list = $this->joinUserpic($comment_list);
				$comment_list = array_reverse($comment_list);
				$this->assign("comment_list",$comment_list);
				$html = $this->fetch("weiboComment.html",$comment_list); 
			   	$this->reJson('1',$html);
			}
			else{
				$this->reJson('0');
			}

		}
		public function delete_comment(){
			if($this->model("comment")->deleteOneInfo("weibo_comment",$_POST)){
				$this->reJson('1');
			}else{
				$this->reJson('0');
			}
		}
	} 
?>