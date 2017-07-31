<?php 
// 微博操作数据库的类

// 子类
// 
// 继承 extends
// 
// 特点：1、继承的父类也会自动执行构造函数
// 		2、无需再写这一个相同类集合的方法

class  weibo  extends daoClass {


	//获取微博列表
	public function getList($page="0,10")
	{
		// $sql ="select * from weibo_content order by content_id desc  limit $page";
		 
		// return $this->select($sql); 
	}
	 
	//获取用户最近几天数据
	public function getLastInfo($uid,$page=3)
	{

		// $sql ="select * from weibo_content where user_id=$uid order by content_id desc  limit $page";
		 
		// return $this->select($sql); 


	}
	public function collectionNumByContentId($content_id){
			$query = "select count(*) num from weibo_collection where content_id='$content_id'";
			$res = $this -> select($query);
			return $res;
		}

}


 ?>