$(function  (){


	var $send_btn = $('.send_content');
	$send_btn.click(function(){
		send_content();
	});
	function send_content(){



		var $content = $(".weibo_textarea");
		var $file = $('.select_file');
		var $title = $('.title_input').val();
		var $list = $('.content_box');
		// var dateStr = create_time();
		文字发送
		
		$.ajax({
			url:"index.php?control=weibo&action=send_content",
			type:"post",//为false则传给后台的不是对象	
	        data:{'content':$content.eq(0).val()},
			success: function(data){
				if($.isEmptyObject(data)){
					var redata = $.parseJSON(data);
				}
			}
		});
		// 
		
	}
	function save_file(formdata,obj){
	$.ajax({
		url:"index.php?control=weibo&action=send_content",
		type:"post",
        contentType:false,
        processData:false,//为false则传给后台的不是对象	
        data:formdata,
		success: function(data){
			 	var redata = $.parseJSON(data);
			 	var c_obj = obj;
			 	c_obj.rt_url = redata.info;
			 	c_obj.rt_upic = localStorage.getItem("user_pic");
			 	c_obj.rt_uid = localStorage.getItem("uid");
			 	c_obj.rt_id = redata.content_id;
			 	if(redata.music_name){
			 		c_obj.rt_name=redata.music_name;
			 	}
					var str = create_li_content(c_obj);
					c_obj.list.prepend($(str));
				}
			});
	}


	var $btn = $('#test_btn');
	$btn.click(function(){
		var $register = $("#register_box");
		var user_name = $register.find('#user_name_register');
		var user_pwd = $register.find('#userPassword_register');
		var user_repwd = $register.find('#userRePassword_register');

		$register.find('.register_btn').click(function(){
			$.ajax({
			url:"index.php?control=user&action=register",
			type:"post",//为false则传给后台的不是对象	
	        data:{'user_name':user_name.val(),'user_password':user_pwd.val()},
			success: function(data){
				if($.isEmptyObject(data)){
					var redata = $.parseJSON(data);
				}
			}
			});

		});
	});


	// $(".register_btn").click(function(){
	// 	var $uaerName = $("#userName").val();
	// 	var $passWord = $("#passWord").val();
	// 	var $rePassWord = $("#rePassWord").val();
	// 	if(''!=$uaerName){
	// 		if(isset(userName)){
	// 			if($passWord!=$rePassWord){
	// 				$.ajax({
	// 					url:'index.php',
	// 					type:'post',
	// 					data:{
	// 					 	'user_name':$uaerName,
	// 					 	'user_name':$passWord,
	// 				 	},
	// 					async : false,
	// 					success: function(data){
	// 						// var rtdata = $.parseJSON(data);
	// 					}
	// 				});
	// 				}
	// 				else{			
	// 					alert("密码不一致");
	// 				}
	// 		}else{
	// 			alert("用户名已存在！");
	// 		}
	// 	}else{
	// 		alert("用户名不能为空！");
	// 	}
	// });
	function isset(userName){
		var val = false;
		$.ajax({
			url:'index.php?',
			type:'post',
			data:{
			 	'user_name':$uaerName,
		 	},
			async : false,
			success: function(data){
				if($.isEmptyObject(data)){
					var rtdata = $.parseJSON(data);
					if(1==rtdata.status){
						val = true;
					}
					else if(0==rtdata.status){
						val = false;
					}
					else{
						val = false;
					}
				}
				else{
					val = false;
				}
			}
		});
		return val;
	}
	// 
	
});