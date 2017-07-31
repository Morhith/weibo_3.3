<?php
	class praise extends daoClass{
		public function praisenumByContentId($content_id){
			$query = "select count(*) num from weibo_praise where content_id='$content_id'";
			$res = $this -> select($query);
			return $res;
		}
	}
?>