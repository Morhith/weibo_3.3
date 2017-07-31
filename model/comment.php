<?php
	class  comment  extends daoClass {
		public function commentnumByContentId($content_id){
			$query = "select count(*) num from weibo_comment where content_id='$content_id'";
			$res = $this -> select($query);
			return $res;
		}
		public function commentFindByconntentId($content_id){
			$query ="select weibo_comment.*,weibo_user.user_pic,weibo_user.user_name from weibo_comment inner join weibo_user on weibo_comment.user_id=weibo_user.user_id WHERE content_id = $content_id";
			$res = $this -> select($query);
			return $res;
		}
	}

?>