<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html lang="zh-cn">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<script src="__JS__/mzuser/login.js"></script>
	<link rel="stylesheet" type="text/css" href="__CSS__/mzuser/login.css" />
	<script src="__JS__/jquery-1.9.1.min.js"></script>
	<script type="text/javascript">
		$(function(){

			var flag = true;
			var verifylogin_name = true;
			var verifyPwd = true;
			var verifyCode = true;
			var om = $('#login_name');
			var op = $('#password');
			var oc = $('#captcha');


			/////////////////////////////////////////
			//邮箱登陆名校验事件
			var login_text='邮箱或昵称';
			$("#login_name").focus(function(){
				    $("#login_name").val("");
			});
			$('#login_name').blur(function(){

				if($("#login_name").val() == ""){
					$("#login_name").val(login_text);
				};
				if(om.val() == '' || om.val()==login_text){
					$('#login_name_err').text('请填写邮箱或昵称!');
					$('#login_name').css({
						  "border":"1px solid red"
					 });
					verifylogin_name = false;
				}else{
	           		//ajax获取校验邮箱数据
					$.post('__URL__/checkloginName',{login_name:$('#login_name').val()},function(jsonData){
						if(jsonData.status=='0'){
							$('#login_name_err').css('color','green').text('该用户已注册,可登录!');
							$('#login_name').css({"border":"0px solid red"});
							verifylogin_name=true;
						}else{
							$('#login_name').css("border","1px solid red");
							$('#login_name_err').css('color','red').text('该用户未注册,请先注册');
							verifylogin_name=false;
						}
						},'json');
	           		////////////
	           	}
			});
			//密码位数校验
			$('#password').blur(function(){
				if(op.val() == ''){
					$('#pwd_msg').text('请填写密码!');
					$('#password').css({
						  "border":"1px solid red"
					 });
					verifyPwd = false;
				}else if(op.val().length < 6){
					$('#pwd_msg').text('密码位数最小为6位!');
					$('#password').css("border","1px solid red");
					$('#password').focus();
	                verifyPwd=false;
				}else{
	           		$('#password').css("border","0px solid red");
					$('#pwd_msg').text('');
					verifyPwd=true;
	           	}
			});

			//验证码位数校验
			$('#captcha').blur(function(){
				if(oc.val() == ''){
					$('#frm_error').text('请填写验证码!').css('display','block');
					$('#captcha').css({
						  "border":"1px solid red"
					 });
					verifyCode = false;
				}else if(oc.val().length !=4){
					$('#frm_error').text('验证码不正确!');
					$('#captcha').css("border","1px solid red");
					$('#captcha').focus();
	                verifyCode=false;
				}else{
					//ajax获取数据
					$.post('__URL__/checkCode',{captcha:$('#captcha').val()},function(jsonData){
						if(jsonData.status=='0'){
							$('#frm_error').text('验证码不正确!');
							$('#captcha').css({
								  "border":"1px solid red"
							 });
							verifyCode = false;
						}else{
							$('#captcha').css("border","0px solid red");
							$('#frm_error').css('color','green').text('验证码正确');
							verifyCode = true;
						}
						},'json');
	           	}
			});

			//提交
			$('#button').click(function(){
					if(om.val() =='' || !verifylogin_name){
						$('#login_name_err').text('请填写正确邮箱或昵称!');
						$('#login_name').css({
							  "border":"1px solid red"
						 });
						flag = false;
					}
					if(op.val() == '' || !verifyPwd){
						$('#pwd_msg').text('请填写完整密码!');
						$('#password').css({
							  "border":"1px solid red"
						 });
						flag = false;
					}
					if(oc.val() == '' || !verifyCode){
						$('#captcha').css({
							  "border":"1px solid red"
						 });
						flag = false;
					}

					if(om.val() !='' && op.val() != ''&& oc.val() != '' && verifylogin_name && verifyPwd && verifyCode){
						flag = true;
					}
					//校验通过
					if(flag){
						$("#logForm").attr("action","__URL__/doLogin").submit();
					}
			});
		});
	</script>
	<script>
		//解决IE下无法刷新的问题、、this.src=this.src"+"?"+"Math.random();
		var refreshCode=function (){
			var CodeIm = document.getElementById('code');
			CodeIm.src="__APP__/Public/code/"+"?"+Math.random();
		}
	</script>
</head>
<body>
	<div class="login_content">
		<div class="left_img">
			<img width="398" height="298" src="__IMAGE__/mz_banner.gif" alt="logo">
		</div>
		<div class="right_form">
			<h2>登陆Cos405</h2>
			<form name="logForm" id="logForm" action="" method="post">
				<div class="item">
					<label>账&nbsp;&nbsp;号</label><input id="login_name" class="basic-input2" type="text" name="username" value="邮箱或昵称"/>
					 <span id="login_name_err" style="color:red;font-size: 12px;width: 120px;"></span>
				</div>
				<div class="item">
					<label>密&nbsp;&nbsp;码</label><input id="password" class="basic-input" type="password" name="password"/>
					 <span id="pwd_msg" style="color:red;font-size: 12px;width: 120px;"></span>
				</div>
				<div class="item">
					<label>验证码</label><input class="basic-input" type="text" name="captcha" id="captcha"/>
					<img id="code" src="__APP__/Public/code/" onclick="refreshCode();"/></br>
				</div>
				<div class="item_tw">
					<label></label>
					<p class="remember">
						<!--input id="remember" type="checkbox" tabindex="4" name="remember">
						<label class="remember" for="remember">下次自动登录</label-->
						<a href="__APP__/MzUser/resetpassword">忘记密码了</a>
					</p>
					<p class="register">
						<label class="register">&nbsp;&nbsp;&gt;&nbsp;还没有账号</label>
						<a href="__APP__/MzUser/register">立即注册</a>
					</p>
				</div>
				<div class="item_th">
					<label></label>
					<input class="btn-submit" id="button" type="button" tabindex="5" name="user_login" value="登录">
				</div>
			</form>
		</div>
	</div>
</body>