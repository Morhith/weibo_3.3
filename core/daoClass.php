<?php
	//数据库操作类
	class daoClass{
		//属性
		public $link;
		//初始化操作
		//构造函数
		function __construct($dbhost,$db_user,$db_pwd,$debug= false){
			$this->debug = $debug;
			$this->link = new PDO($dbhost,$db_user,$db_pwd);
		}
		/**
		 * [exec description]
		 * @param  [type] $sql [description]
		 * @return [type]      [description]
		 */
		public function exec($sql)
			{
				$num = $this->link ->exec($sql);

				if ($this->link->errorCode() != "000000") {
					if ($this->debug == true) {
						var_dump($this->link->errorInfo());
					} else {
						return $this->link->errorInfo();
					}
				} else {
					return $num;
			}
		}
		/**
		 * 数据添加
		 * [addInfo description]
		 * @param [string] $table   [数据库表名]
		 * @param array  $addData [数据]
		 */
		function addInfo($table,$addData=array()){
				$col_str =  implode(",", array_keys($addData));
				
				$val_data = array_values($addData);
				$val_str = "";
				$douhao = "";

				foreach ($val_data as $key => $value) {
					 // 怎么判断变量的类型
					 if(is_string($value)){
					 	$val_str.=$douhao."'".$value."'";
					 }else{
					 	$val_str.=$douhao.$value;
					 }
					 $douhao =",";
				}
				//执行数据语句
				// print_r("insert into $table ($col_str) values($val_str)");
				$this->link->exec("insert into $table ($col_str) values($val_str)");
				//返回插入数据的id
				return $this->link->lastInsertId();
 
		}
		/**
		 * 数据删除
		 * 
		 * [deleteInfo 对某一条数据进行数据的删除]
		 * @return [type] [description]
		 */
		function deleteOneInfo($table,$deleteData=array()){
			$val_str = "";
			$douhao = "";
			foreach ($deleteData as $key => $value) {
				$val_str.=$douhao.$key."='".$value."' ";
				$douhao=" and ";

			}
			$deleteSql = "DELETE FROM $table WHERE $val_str";
			// print_r($deleteSql);
			if($this->link->exec($deleteSql)){
				return true;
			}
			else{
				return false;
			}
		}
		/**
		 * [getError 返回错误信息]
		 * @param  [type] $num [description]
		 * @return [type]      [description]
		 */
		public function getError($num)
		{
			 if( $this->link->errorCode() != "00000"){
			 	if ($this->debug == true) {
			 		var_dump($this->link->errorInfo());
			 	}else{
			 		return $this->link->errorInfo();
			 	}
			 }else{
			 		return $num;
			 }
		}
		/**
		 * [execute description]
		 * @param  [type] $sql [description]
		 * @return [type]      [description]
		 */
		public function execute($sql)
		{
			$this->pstate = $this->link->prepare($sql);

			$num = $this->pstate->execute(); 

			return $this->getError($num);
			
		}
		/**
		 * 获取多条记录
		 * @param  string $sql sql语句
		 * @return array      多条记录
		 */
		public function select($sql,$val=0)
		{
			$this->execute($sql);
			if(0==$val){
				return $this->pstate->fetchAll();
			}else if(1==$val){
				return $this->pstate->fetch();
			}
		}
		/**
		 * 数据更新
		 * [updataInfo description]
		 * @return [type] [description]
		 */
		function updataInfo($table,$clo_array,$clo,$val){
			$updataSql = "update $table set";
			$douhao = "";
			foreach($clo_array as $key => $value){
				$timp = $douhao.$key."="."'$value'";
				$updataSql.=" ".$timp." ";
				$douhao = ",";
			}
			$updataSql.= "WHERE $table.$clo = $val";
			// print_r($updataSql);
			if($this->link->exec($updataSql)){
				return true;
			}
			else{
				return false;
			}
			// return "update $table set $col_str = '$user_pic' WHERE $table.user_id = '$user_id'";
		}
		/**
		 * 数据查询
		 * [getInfo description]
		 * @return [type] [description]
		 */
		function getInfoByclo($table,$getData,$val=0,$clo=''){
			$querySql="select * from $table";
			$val_str = "";
			$douhao = "";
			foreach ($getData as $key => $value) {
				$val_str.=$douhao.$key."='".$value."' ";
				$douhao=" and ";

			}
			$querySql.= " where ".$val_str;
			if(1==$val){
				$querySql.=" ORDER BY $clo DESC LIMIT 3";
			}
			// print_r($querySql);
			$res = $this->link->query($querySql);
			return $res->fetchAll(PDO::FETCH_ASSOC);
			// return $querySql;
		}
		function getInfoAll($table,$val=0,$clo=''){
			$querySql = "select * from $table";
			if(1==$val){
				$querySql.=" ORDER BY $clo DESC";
			}
			$res = $this->link->query($querySql);
			return $res->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	// $pdo =  new dao("mysql:dbhost=localhost;dbname=weibo_db;charset=utf8","root","");
	// echo $pdo->updataInfo("weibo_content",array("content"=>"val","music"=>"jiushsdj1"),"content_id",1);
	// var_dump($pdo->getInfoById("weibo_content",array("user_id"=>"1"),1));
	// var_dump($pdo->getInfoAll("weibo_content"));
	// $pdo->addInfo("weibo_content",array("content"=>"开心"));

?>