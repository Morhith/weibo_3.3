
// $(document).ready(function(){
// 	// $('#loading_box').modal('show');
// 	// 
// 	$('#loading').fadeOut(2000);
// 	$('#weibo_mask').fadeOut(2000);
// });

var user_val=false;
$(function  (){
	//实例化
	// window.UEDITOR_CONFIG.initialFrameWidth = 900;  
 //    window.UEDITOR_CONFIG.initialFrameHeight = 600;  
 //    UE.getEditor("baiduEditor"); 
	//屏幕自适应
	var screenX = document.body.clientWidth;
	var Multiple = screenX/1700;//1600/20
	if(screenX<=1366){
		document.documentElement.style.fontSize = 20*Multiple+"px";
	}else{
		document.documentElement.style.fontSize = "20px";
	}

	var ev_index = 0;

	//检测是否有登陆
	function haslogin(){
		let uid = localStorage.getItem("user_id");
		  if (uid>0) {
		  	return true
		  }else{
		  	return false;
		  }
	}
	//登录
	$("#weibo_login_btn").click(function(event) {
		/* Act on the event */

		$user_name = $('#userName');
		$user_pwd = $('#userPassword');
		if($user_name.val() == "") {
			$(".user_name").html("请输入手机号码");
            return false;
		}
		else if (!(/^1[34578]\d{9}$/.test($user_name.val()))) {
			$(".user_name").html("手机号码有误，请重填");
            return false; 
		}else{
			$.ajax({
				url:"index.php?control=user&action=issetUser",
				type:"post",	
		        data:{'user_phone':$user_name.val(),'user_password':$user_pwd.val()},
				success: function(data){
					if(!$.isEmptyObject(data)){	
						var redata = $.parseJSON(data);
						if(1==redata.status){
							localStorage.setItem("user_id",redata.rearray.user_id);
							localStorage.setItem("user_name",redata.rearray.user_name);
							localStorage.setItem("user_pic",redata.rearray.user_pic);
							$('.login').html(redata.rearray.user_name);
							$('#content_list').html(redata.rearray.html);
							$('.closeOut').stop().show(500);
							$('nav_top_text').stop().hide(500);
							$('#h3_name').html(redata.rearray.user_name);
							$('.weibo_body_show').stop().show(500);
							$('.head_photo>a>img').attr('src',redata.rearray.user_pic);
							$('#login_modal').modal('hide');
							$('.reg').html('欢迎你回来');
							weibo_click();
							header_img_click();
						}else if(2==redata.status){
									alert('检测到你已经登录');
								}
						else{
							$(".user_pwd").html("密码有误");
						}
					}
				}
			});
		}
		
	});
	//注册
	$("#weibo_register_btn").click(function() {
		var $register = $("#register_modal");
		var user_phone = $register.find('#user_phone_register');
		var user_name = $register.find('#user_name_register');
		var user_pwd = $register.find('#userPassword_register');
		var user_repwd = $register.find('#userRePassword_register');

		if(user_phone.val() == "") {
			$(".user_phone").html("请输入手机号码");
            return false;
		}
		else if (!(/^1[34578]\d{9}$/.test(user_phone.val()))) {
			$(".user_phone").html("手机号码有误，请重填");
            return false; 
		}
		else if (user_pwd.val() == "") {
			$(".userPassword").html("密码不能为空");
            return false;
		}
		else if (!(/^(\w){6,20}$/.test(user_pwd.val()))) {
			$(".userPassword").html("请输入6-20位密码，包含字母、数字、下划线");
            return false;
		}
		else if (user_repwd.val() == "") {
			$(".userRePassword").html("请再次输入密码");
			return false;
		}
		else if (user_repwd.val() != user_pwd.val() ) {
			$(".userRePassword").html("与密码不一致");
			return false;
		}else{
			issetUser(user_phone.val(),refun=function(){
				$(".user_name").html("");
				$(".userPassword").html("");
				$(".userRePassword").html("");
				$(".user_phone").html("");

				$("#register_modal").modal("hide");

				$.ajax({
					url:"index.php?control=user&action=register",
					type:"post",//为false则传给后台的不是对象	
		        	data:{'user_phone':user_phone.val(),'user_password':user_pwd.val(),'user_name':user_name.val()},
					success: function(data){
						if(!$.isEmptyObject(data)){	
							var redata = $.parseJSON(data);
							if(1==redata.status){
								$('#login_modal').modal('show');
							}
							else {
								alert('注册时出错');
							}
						}

					}
				});	
			});
		}
	});
	// 上传头像
	function header_img_click(){
		$("#head_btn").click(function(){
		var fd = new FormData();
		var user_id = localStorage.getItem("user_id");

		fd.append("user_id",user_id);
		fd.append("save_file",$("#headPhoto").get(0).files[0]);
		console.log(fd);
		$.ajax({
			url:"index.php?control=user&action=upUserpic",
			type:"post",
			contentType:false,
			processData:false,
			data:fd,
			success:function (data) {
				if(!$.isEmptyObject(data)){
				 	var redata = $.parseJSON(data);
				 	if(1==redata.status){
				 		$("#head_modal").modal("hide");
				 		location.reload();
				 	}else{
				 		alert("上传失败");
				 	}
				 }
			}
			})
		});
	}	
	// 匹配用户名
	function issetUser($user_phone,refun){
		$.ajax({
			url:'index.php?control=user&action=issetUserName',
			type:'post',
			data:{
			 	'user_phone':$user_phone,
		 	},
			success: function(data){
				if(!$.isEmptyObject(data)){
					var rtdata = $.parseJSON(data);
					if(1==rtdata.status){
						refun();
					}
					else if(0==rtdata.status){
						$(".user_name").html("用户名已存在");
					}
					else{
						$(".user_name").html("用户名已存在");
					}
				}
				else{
					$(".user_name").html("用户名已存在");
				}
			}
		});
	}
	// 退出事件
	$('.closeOut').click(function(event) {
		/* Act on the event */
		logout();
	});
	function logout(){
		var user_id = localStorage.getItem("user_id");
	 	$.post('index.php?control=user&action=logout',{'user_id':user_id},function(data){
	 		if(!$.isEmptyObject(data)){
	 			var redata = $.parseJSON(data);
					if(1==redata.status){
						localStorage.removeItem("user_id");
	 					localStorage.removeItem("user_name");
	 					localStorage.removeItem("user_pic");
						$('#h3_name').html('游客，你好');
						$('.closeOut').stop().hide(500);
						$('.weibo_body_show').hide(500);
						$('#nav_top_text').stop().show(500);
						$('.head_photo>a>img').attr('src',"staticImages/00000.jpg");
						$('.login').html('<a href="#login_modal" id="login_btn" data-toggle="modal">登录</a>');
	 					$('.reg').html('<a href="#register_modal" id="register_btn" data-toggle="modal">注册</a>');
					}else{
						console.log('退出失败')
					}
	 		}
	 	});
	}

	//发表微博
	//tab选项卡的值更改
	//定义
	var $weibo_btn_a = $('.weibo_release_type a');
	var $login_box = $('#login_modal');
	$weibo_btn_a.each(function(index, el) {
		var val = index;
		var that = this;
		$weibo_btn_a.eq(index).on('click',function(){
			ev_index = val;
		});
	});
	//发布按钮事件
	function weibo_click(){
	$('.weibo_main_btn').click(function(event) {
		/* Act on the event */
			if(haslogin ()){
				send_content();
			}else{
				$login_box.modal('show');
			}
		});
	}
	function send_content(){
		var $content = $(".weibo_textarea");
		var $file = $('.select_file');
		//文字发送
			if(0 == ev_index){
				if(''==$content.eq(ev_index).val()||null==$content.eq(ev_index).val()){
				alert('更新内容为空！');
				}else{
					$.ajax({
					url:'index.php?control=weibo&action=send_content',
					type:'post',
					data:{'user_id':localStorage.getItem("user_id"),'content':$content.eq(ev_index).val(),'type':ev_index},	
					success: function(data){
							var redata = $.parseJSON(data);
							$content.eq(ev_index).val('');
							if(!$.isEmptyObject(data)){
							 	var redata = $.parseJSON(data);
							 	if(1==redata.status){
							 		var obj = redata.rearray;
							 		var str = create_li(obj);
							 		$('.weibo_show_ul').html($(str));
							 		alert("发布成功");
							 	}else if(0==redata.status){
							 		alert("发布失败");
							 	}
							 	else{
					 				alert("发生未知错误");
					 			}
						 }
						}
					});
				}
				//图文或音频发
			}else{
				var $select_files = $file.eq(ev_index-1).get(0).files[0];
				if(''==$select_files||null==$select_files){
					alert('文件为空！');
				}else if(''==$content.eq(ev_index).val()||null==$content.eq(ev_index).val()){
					alert('内容为空！')
				}else{
					var pic_data = new FormData();
					pic_data.append("content",$content.eq(ev_index).val());
					pic_data.append("user_id",localStorage.getItem("user_id"));
					pic_data.append("save_file",$select_files);
					pic_data.append("type",ev_index);
					//更新文件
					save_file(pic_data);
					//清空文本
					$content.eq(ev_index).val('');
				}
			
		}
	}
	function save_file(formdata){
		$.ajax({
			url:'index.php?control=weibo&action=send_content',
			type:"post",
	        contentType:false,
	        processData:false,//为false则传给后台的不是对象	
	        data:formdata,
			success: function(data){
					if(!$.isEmptyObject(data)){
					 	var redata = $.parseJSON(data);
					 	if(1==redata.status){
					 		var obj = redata.rearray;
					 		var str = create_li(obj);
					 		$('.weibo_show_ul').html($(str));
					 		alert("发布成功");
					 	}else if(0==redata.status){
					 		alert("发布失败");
					 	}else if(2==redata.status){
							$('#tip_modal').find(".weibo_tip").html("你还不是会员");
							$('#tip_modal').modal("show");
						}
					 	else{
					 		alert("发生未知错误");
					 	}
					 }
				 }
		});
	}
	function create_li(obj){
		var str = '<li class="weibo_show_li">'+
					'<div class="weibo_show_zan">'+
					'<h3>'+obj.content+'</h3>'+
					'<div class="weibo_zan_img">';
					if(0==ev_index){

					}else if(1==ev_index){//图文
						str+='<img src="'+obj.pic+'"/><br/>';
					}else if(2==ev_index){//音乐
						if(obj.rt_name){
							str+='歌名：'+obj.rt_name+'<br>';
						}
							str+='<audio src="'+obj.music+'" controls></audio><br/>';

					}else if(3==ev_index){//视频
						str+='<video src="'+obj.video+'" controls></video><br/>';
					}
					str+='</div><div class="weibo_zan_button">'+			
					'<ul>'+
					'<li>收藏</li>'+
					'<li>点赞</li>'+
					'<li>评论</li>'+
					'<li>删除</li>'+
					'</ul>'+
					'</div>'+
					'</div>';
								
		return str; 
	}
	// 长微博
	// function longText_click() {
	// 	$("#long_btn").click(function() {
	// 		$(".weibo_right_showAllBody").hide(500);
	// 		$("#edui1_iframeholder").animate({
	// 			height : "19.1rem"
	// 		});
	// 	})
	// 	$("#text_tab").click(function() {
	// 		$(".weibo_right_showAllBody").show(500);
	// 	})
	// 	$("#pic_tab").click(function() {
	// 		$(".weibo_right_showAllBody").show(500);
	// 	})
	// 	$("#music_tab").click(function() {
	// 		$(".weibo_right_showAllBody").show(500);
	// 	})
	// 	$("#video_tab").click(function() {
	// 		$(".weibo_right_showAllBody").show(500);
	// 	})
	// }
	// 下拉加载
	// function pubuliu(){
	// 	$(window).scroll(function(){
	// 		console.log($('.weibo_right_showAll').height() - $(".weibo_right_showAll").scrollTop() - $(window).height());
	// 	});
	// }
	//导航条事件
	function nav_href(){
		var $nav_text = $('#nav_top_text .nav_text');
		$nav_text.each(function(index,el){
			$nav_text.eq(index).click(function(){
				var type = '';
				if(0==index){
					type = '短微博';
				}else if(1==index){
					type = '图片';
				}else if(2==index){
					type = '音乐';
				}else if(3==index){
					type = '视频';
				}else if(4==index){
					type = '长微博';
				}
				var obj= {
					"type":type,
				};
				search('index.php?control=weibo&action=search_weibo',obj);
			});
		});
	}
	function nav_big(){
		var $nav_text = $('.nav_big li');
		$nav_text.each(function(index,el){
			$nav_text.eq(index).click(function(){
				var type = '';
				if(0==index){
					type = '短微博';
				}else if(1==index){
					type = '长微博';
				}else if(2==index){					
					type = '图片';
				}else if(3==index){
					type = '音乐';
				}else if(4==index){
					type = '视频';
				}else if(5==index){
					type='全部';
				}
				var obj= {
					"type":type,
				};
				search('index.php?control=weibo&action=search_weibo',obj);
			});
		});	
	}
	//搜索请求
	function search(url,val){
		$.ajax({
				url: url,
				type: 'post',
				data: val,
				success:function(data){
					if(!$.isEmptyObject(data)){	
						var redata = $.parseJSON(data);
						if(1==redata.status){
							$('#content_list').html(redata.rearray.html);
							list_click();
						}else{
							$('#content_list').html('暂无该板块的内容');
						}
					}
				}
			});
				
	}
	//评论事件
	function list_click(){
		var user_id = localStorage.getItem("user_id");
		$(".weibo_right_showAll").on('click',function(e) {
			/* Act on the event */
			let this_elm = $(e.target);
			if(this_elm.hasClass("comment_up")){
				var $comment_news = 
				this_elm.parent().parent().parent().parent().siblings('.weibo_shwo_comment');
				//weibo_shwo_commentRelease
				var $comment_send = 
				this_elm.parent().parent().parent().parent().siblings('.weibo_shwo_commentRelease');
				if($comment_news.is(":hidden")){
					var obj = {
						'content_id':this_elm.attr('data-id'),
					}
					$('.weibo_shwo_comment').hide(500);
					$('.weibo_shwo_commentRelease').hide(500);
					find_comment(obj,$comment_news.find('ul'));
					$comment_news.show(500);
					$comment_send.show(500);
				}
				else{
					$comment_news.hide(500);
					$comment_send.hide(500);
				}
			}else if(this_elm.hasClass("send_commont")){
				var comment = this_elm.siblings('.commont_texarea').val();
				var content_id = this_elm.attr('data-id');
				if(haslogin()){
					var obj = {
						'user_id':user_id,
						'content_id':content_id,
						'comment':comment
					}
					var $elm = this_elm.parent().siblings('.weibo_shwo_comment').find("ul");
					send_comment(obj,$elm);
				}else{
					$login_box.modal('show');
				}
			}else if(this_elm.hasClass("praise_btn")){
				if(haslogin()){
					var content_id=this_elm.parent().parent().attr('data-id');
					var obj = {
						'user_id':user_id,
						'content_id':content_id,
					}
					$.ajax({
					url: 'index.php?control=weibo&action=praise',
					type: 'post',
					data: obj
				})
				.done(function(data) {
					var val = Number(this_elm.find('.praise_num').text());
					if(!$.isEmptyObject(data)){	
						var redata = $.parseJSON(data);
						if(1==redata.status){
							val++;
						}else if(2==redata.status){
							val--;
						 }
						 else{
						 	alert("操作失败");
						 }
						}
					this_elm.find('.praise_num').html(val);
				});
			}else{
				$login_box.modal('show');
			}
				
				
			}else if(this_elm.hasClass('del_content_btn')){
				var content_id=this_elm.parent().parent().attr('data-id');
					var obj = {
						'user_id':user_id,
						'content_id':content_id,
					};
				var $del =this_elm.parents(".weibo_content_list_hf");
				$.ajax({
					url: 'index.php?control=weibo&action=delete_content',
					type: 'post',
					data: obj,
				})
				.done(function(data) {
					if(!$.isEmptyObject(data)){	
						var redata = $.parseJSON(data);
						if(1==redata.status){
							$del.hide(500);
						}else{
							alert("删除失败");
						}
					}
				});
			}else if(this_elm.hasClass('transmite_btn')){
				var val = this_elm.parents(".weibo_show_content").find('.weibo_content_img').find('p').text();
				$('#tranmit_modal').modal('show');
				$('#tranmit_modal').find(".weibo_tran").html(val);
				$('#weibo_tran_btn').click(function(){
					$.ajax({
					url:'index.php?control=weibo&action=send_content',
					type:'post',
					data:{'user_id':localStorage.getItem("user_id"),'content':val,'type':'短微博'},	
					success: function(data){
							var redata = $.parseJSON(data);
							if(!$.isEmptyObject(data)){
							 	var redata = $.parseJSON(data);
							 	if(1==redata.status){
							 		var obj = redata.rearray;
							 		var str = create_li(obj);
							 		$('.weibo_show_ul').html($(str));
							 		$('#tranmit_modal').modal('hide');
							 		alert("发布成功");
							 	}else if(0==redata.status){
							 		alert("发布失败");
							 	}
							 	else{
					 				alert("发生未知错误");
					 			}
						 }
						}
					});
				});
			}else if (this_elm.hasClass('collection_btn')) {
				var content_id=this_elm.parent().parent().attr('data-id');
				var obj = {
						'user_id':user_id,
						'content_id':content_id,
					};
				$.ajax({
					url: 'index.php?control=weibo&action=collectionAdd',
					type: 'post',
					data: obj,
				})
				.done(function(data) {
					if(!$.isEmptyObject(data)){	
						var redata = $.parseJSON(data);
						if(1==redata.status){
							this_elm.html("已收藏");
						}else if(2==redata.status){
							this_elm.html("收藏");
						}else{
							alert("收藏失败");
						}
					}
				});
			}else if(this_elm.hasClass('del_comment_btn')){
				var comment_id =this_elm.attr('data-id');
				var $del =this_elm.parent().parent().parent();
				$.ajax({
					url: 'index.php?control=comment&action=delete_comment',
					type: 'post',
					data: {'comment_id':comment_id},
				})
				.done(function(data) {
					if(!$.isEmptyObject(data)){	
						var redata = $.parseJSON(data);
						if(1==redata.status){
							$del.hide(500);
						}else{
							alert("删除失败");
						}
					}
				});
			}
		});
	}
	//发表评论的ajax
	function send_comment(obj,$elm){
		$.ajax({
			url: 'index.php?control=comment&action=send_comment',
			type: 'post',
			data: obj,
		})
		.done(function(data) {
			if(!$.isEmptyObject(data)){	
				var redata = $.parseJSON(data);
				if(1==redata.status){
					var str = '<li><div class="weibo_comment_header">'+
							  '<img src="'+localStorage.getItem("user_pic")+'" alt=""></div>'+
							  '<div class="weibo_comment_text">'+
							  '<p>'+obj.comment+'</p>'+
							  '<p class="float-right">刚刚 <span class="del_comment_btn">删除</span><p>'
							  '</div>';
					$elm.prepend($(str));
					$('.commont_texarea').val("");
					list_click();
				}else{
					alert('与服务器断开连接...');
				}
			}
		});
		
	}
	//搜索评论的ajax
	function find_comment(obj,$elm){
		$.ajax({
			url: 'index.php?control=comment&action=find_comment',
			type: 'post',
			data: obj,
		})
		.done(function(data) {
			if(!$.isEmptyObject(data)){	
				var redata = $.parseJSON(data);
				// console.log(redata.rearray);
				if(1==redata.status){
					$elm.html(redata.rearray);
				}else if(0==redata.status){
					$elm.html('');
				}
				else{
					alert('与服务器断开连接...');
				}
			}
		});
	}
	function back_first(){
		$.ajax({
			url: 'index.php?control=weibo&action=index',
			type: 'post',
		})
		.done(function() {
		});		
	}

	function init(){
		// pubuliu();
		nav_href();
		nav_big();
		weibo_click();
		list_click();
		header_img_click();
		// longText_click();
	}
	init();
});