<?php
/* Smarty version 3.1.30, created on 2017-07-27 02:56:43
  from "D:\wamp64\www\yehith\weibo_3.3\view\weibo.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5979566b166b29_55601441',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9b2e2ea079b140fc92d26c5c9f9ce01247dc6b6c' => 
    array (
      0 => 'D:\\wamp64\\www\\yehith\\weibo_3.3\\view\\weibo.html',
      1 => 1501124201,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5979566b166b29_55601441 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<link rel="stylesheet" href="public/libarary/bootstrap-3.3.7/dist/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<!-- 左边盒子 -->
			<div class="col-lg-4" style="border:1px solid #000;">
				<!-- 我的微博 -->
				<div>
					<!-- 标题 -->
					<div>
						<h5>我的微博</h5>
					</div>
					<!-- 显示内容 -->
					<div>
						<div class="container">
							<!-- 头像信息 -->
							<div>
								<img src="" alt="">
								<div>
									<h6>RUA!</h6>
									<span>主菜单</span>
								</div>
							</div>
							<!-- 选择显示的三张图片 -->
							<div>
								<img src="" alt="">
								<img src="" alt="">
								<img src="" alt="">
							</div>
							<!-- 最新的三条微博 -->
							<div>
								<ul>
									<!-- 图片 -->
									<li>
										<div>
											<h6>其实我是可爱的标题</h6>
											<div>
												图片
											</div>
											<div>
												<!-- 四个按钮 -->
												<ul>
													<li>收藏</li>
													<li>点赞</li>
													<li>评论</li>
													<li>删除</li>
												</ul>
											</div>
										</div>
										<!-- 显示评论 -->
										<div>
											<ul>
												<li>我是评论1</li>
											</ul>
										</div>
									</li>
									<!-- 文字 -->
									<li>
										<div>
											<h6>其实我是可爱的标题</h6>
											<div>
												正文
											</div>
											<div>
												<!-- 四个按钮 -->
												<ul>
													<li>收藏</li>
													<li>点赞</li>
													<li>评论</li>
													<li>删除</li>
												</ul>
											</div>
										</div>
										<!-- 显示评论 -->
										<div>
											<ul>
												<li>我是评论1</li>
											</ul>
										</div>
									</li>
									<!-- 视频 -->
									<li>
										<div>
											<h6>其实我是可爱的标题</h6>
											<div>
												视频
											</div>
											<div>
												<!-- 四个按钮 -->
												<ul>
													<li>收藏</li>
													<li>点赞</li>
													<li>评论</li>
													<li>删除</li>
												</ul>
											</div>
										</div>
										<!-- 显示评论 -->
										<div>
											<ul>
												<li>我是评论1</li>
											</ul>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- 以后添加的好友关注列表 -->
				<!-- <div></div> -->
			</div>
			<!-- 右边盒子 -->
			<div class="col-lg-8" style="border:1px solid #000;">
				<!-- 上面显示已经发布的微博内容 -->
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['weibo_list']->value, 'value', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
					<div>
					<div class="col-lg-2">
						<img src="" alt="">
					</div>

					<div class="col-lg-10 content_box">
						<div class="sanjiao_box"></div>

						<div class="list_content">
							<h4></h4>
							<div>
								<?php echo $_smarty_tpl->tpl_vars['value']->value['content'];?>

							</div>
							<div>
								<!-- 四个按钮 -->
								<ul>
									<li>收藏</li>
									<li>点赞</li>
									<li>评论</li>
									<li>删除</li>
								</ul>
							</div>
						</div>

						<div class="commont_form_box hide_box">
							<div class="col-lg-2">
								<img src="" alt="">
							</div>
							<div class="col-lg-10">
								<textarea name=""  class="commont_texarea" style="width:100%"></textarea>
								<input type="button" class="btn btn-default send_commont" data-id="" value="发布评论"></div>
							</div>
							
							<ul class="commont_list">
								<li>我是评论1</li>
							</ul>
						</div>
					</div>
				<!-- 下面发布和显示最新内容 -->
				<div>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					<!-- 左边是发布 -->
					<div class="col-lg-8">
						<!-- 发布界面 -->
						<div class="col-lg-8">
							<form action="" method="post">
								<div class="tab-content">
									<!-- 第一个面板是放文字 -->
									<div class="tab-pane fade in active weibo_send_content" id="tab1">
										<textarea name="textarea" id="" class="weibo_textarea" cols="32" rows="10" placeholder="写点什么吧"></textarea>
									</div>
									<!-- 第二个面板是放图文发布框 -->
									<div class="tab-pane fade weibo_send_content" id="tab2">
										<textarea name="textarea" id="" class="weibo_textarea" cols="32" rows="10" placeholder="写点什么吧"></textarea>
										<input type="file" class="select_file">
									</div>
									<!-- 第三个面板是放音乐 -->
									<div class="tab-pane fade weibo_send_content" id="tab3">
										<textarea name="textarea" id="" class="weibo_textarea" cols="32" rows="10" placeholder="写点什么吧"></textarea>
										<input type="file" class="select_file">
									</div>
									<!-- 第四个面板是放视频 -->
									<div class="tab-pane fade weibo_send_content" id="tab4">
										<textarea name="textarea" id="" class="weibo_textarea" cols="32" rows="10" placeholder="写点什么吧"></textarea>
										<input type="file" class="select_file">
									</div>
									<!-- 第五个面板是放长微博 -->
									<div class="tab-pane fade weibo_send_content" id="tab5">
										<textarea name="textarea" id="" class="weibo_textarea" cols="32" rows="10" placeholder="写点什么吧"></textarea>
									</div>
								</div>
								<input type="button" class="btn btn-info btn-lg pull-right mt_20 send_content" value="发布">
							</form>
						</div>
						<!-- 选择发布类型 -->
						<div class="col-lg-4">
							<ul>
								<li>
									<a href="#tab1" data-toggle="tab">文字</a>
								</li>
								<li>
									<a href="#tab2" data-toggle="tab">图文</a>
								</li>
								<li>
									<a href="#tab3" data-toggle="tab">音乐</a>
								</li>
								<li>
									<a href="#tab4" data-toggle="tab">视频</a>
								</li>
								<li>
									<a href="#tab5" data-toggle="tab">长微博</a>
								</li>
							</ul>
						</div>
					</div>
					<!-- 右边是显示今天最新内容 -->
					<div class="col-lg-4">
						<ul>
							<li>我是评论1</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>



	<!-- 测试 -->
		<a href="#register_box" data-toggle="modal" id="test_btn">测试</a>
		<div class="modal fade" id="register_box">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">注册</div>
					<div class="modal-body">
						<form>
						  <div class="form-group">
						    <label for="exampleInputEmail1">用户名：</label>
						    <input type="text" class="form-control" id="user_name_register" placeholder="用户名">
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">设置密码：</label>
						    <input type="password" class="form-control" id="userPassword_register" placeholder="设置密码">
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">确认密码：</label>
						    <input type="password" class="form-control" id="userRePassword_register" placeholder="确认密码">
						  </div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-default" data-dismiss="modal">取消</button>
						<button class="btn btn-info register_btn" data-dismiss="modal">注册</button>
					</div>
				</div>
			</div>
		</div>

	<?php echo '<script'; ?>
 src="public/js/jquery-1.11.1.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="public/libarary/bootstrap-3.3.7/dist/js/bootstrap.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="public/js/weibo.js"><?php echo '</script'; ?>
>
</body>
</html><?php }
}
