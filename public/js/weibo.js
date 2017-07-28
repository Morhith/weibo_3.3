$(function  (){
	var screenX = document.body.clientWidth;
	var Multiple = screenX/1640;//1600/20
	if(screenX<=1366){
		document.documentElement.style.fontSize = 20*Multiple+"px";
	}else{
		document.documentElement.style.fontSize = "20px";
	}

	//登录
	$("#weibo_login_btn").click(function(event) {
		/* Act on the event */
		$user_name = $('#userName');
		$user_pwd = $('#userPassword');
		$.ajax({
			url:"index.php?control=user&action=issetUser",
			type:"post",	
	        data:{'user_name':$user_name.val(),'user_password':$user_pwd.val()},
			success: function(data){
				if(!$.isEmptyObject(data)){	
					var redata = $.parseJSON(data);
					if(1==redata.status){
						localStorage.setItem("user_id",redata.rearray[0].user_id);
						localStorage.setItem("user_name",redata.rearray[0].user_name);
						localStorage.setItem("user_pic",redata.rearray[0].user_pic);
						$('.login').html(redata.rearray[0].user_name);
						$('.closeOut').stop().show(500);
						$('.weibo_body_name>h3').html(redata.rearray[0].user_name);
						$('.head_photo>img').attr('src',redata.rearray[0].user_pic);
						$('#login_modal').modal('hide');
						$('.reg').html('欢迎你回来');
					}
					else{
						console.log('登录失败')
					}
				}
			}
		});
	});
	//注册
	
	// 匹配用户名
	function issetUser(userName){
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
	// 退出事件
	$('.closeOut').click(function(event) {
		/* Act on the event */
		logout();
	});
	function logout(){
		localStorage.removeItem("user_id");
	 	localStorage.removeItem("user_name");
	 	localStorage.removeItem("user_pic");
	 	$.post('index.php?control=user&action=logout',{},function(data){
	 		if(!$.isEmptyObject(data)){
	 			var redata = $.parseJSON(data);
					if(1==redata.status){
						$('.weibo_body_name h3').html('游客，你好');
						$('.closeOut').stop().hide(500);
						$('.head_photo>img').attr('src',"staticImages/00000.jpg");
						$('.login').html('<a href="#login_modal" id="login_btn" data-toggle="modal">登录</a>');
	 					$('.reg').html('<a href="#register" id="register_btn" data-toggle="modal">注册</a>');
					}else{
						console.log('退出失败')
					}
	 		}
	 	});
	}

	//发表微博
	var $weibo_btn_a = $('.weibo_btn_a');
	$weibo_btn_a.each(function(index, el) {
		var val = index;
		var that = this;
		$weibo_btn_a.eq(index).on('click',function(){
			ev_index = val;
			$weibo_btn_a.eq(index).siblings().removeClass('text_red');
			$weibo_btn_a.eq(index).addClass('text_red');
		});
	});
	
});