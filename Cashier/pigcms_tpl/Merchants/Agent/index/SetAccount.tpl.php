<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>代理商|账户设置</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	
</head>

<style>
.account_set{ background: #FFFFFF; width: 98%; padding-bottom: 20px;}
.account_set h1{ width: 100%; height: 40px; line-height: 40px; padding:0 20px;
 border-bottom: 1px solid #d9e6e9;
 border-top: 3px solid #edfbfe;
 font-size: 16px;
 margin-bottom: 0px;
 margin-top: 0px;
 }
 .account_set h1 a{ float: right; color: #44b549;}
 .account_set>div{ border: 1px solid #f3f3f3; width: 98%; margin: 20px auto 0;}
 .account_set>div h2{ padding:0 10px; font-size: 12px; margin: 0px; height: 35px; line-height: 35px; background: #f5f5f6;}
 .account_set>div>div>div{height: 50px; line-height: 50px; border-top: 1px solid #f2f2f2; padding-left: 10px; margin-bottom: 0px;}
.account_set>div>div>div>label{ margin-bottom: 0px; width: 60px; margin-left: 20px; text-align: right; margin-right: 10px;}
.account_set>div>div>div>input{ height: 25px; line-height: 25px;}
.account_set>div>div>div>p>label{margin-bottom: 0px;}
.account_set>div>div>div>p>label input{ height: 25px; margin-left: 10px; margin-right: 10px;line-height: 25px;}
.account_set>div>div>div>label>input{ height: 25px; margin: 10px;}
</style>
<body>
    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>收银台</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Agent</a>
                        </li>
                        <li>
                            <a>index</a>
                        </li>
                        <li class="active">
                            <strong>账户设置</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
			   <div class="row">
			   	<form action="?m=Agent&c=index&a=setAccount" method="post">
			   		<div class="account_set">
			   			<h1>账户设置<a href="javascript:void(0);" onclick="submit();" id="pwdform">保存</a></h1>
			   			<div>
			   				<h2>基本信息</h2>
			   				<div>
			   					<div><label>用户名</label><input type="text" id="name1" value="<?php echo $agenter['account']; ?>"  disabled style="width: 170px;"></div>
			   					<div><label>姓名</label><input type="text" id="name2" name='uname' value="<?php echo $agenter['uname'];?>" style="width: 170px;"></div>
			   					<input type="hidden" name="aid" value="<?php echo $agenter['aid'];?>">
			   					<div class="clearfix">
			   						<label style="float: left;">设置密码</label><input style="float: left; margin: 13px 10px 0;" id="xuanzhe" type="checkbox" name='setPw' value='on'>

			   						<p class="mima"  style="float: left; margin-bottom: 0px; display:none;">
			   							<label>原始密码<input type="password" name="oldpwd" id="oldpwd"></label>
			   							<label>新密码<input type="password" name="newpwd" id="newpwd"></label>
			   						</p>
			   					</div>	
			   					
			   				</div>
			   			</div>
			   		</div>
				</form>

			</div>


			
            </div>
            </div>
        </div>
   <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
</body>

 <script>

 function submit () {
 	$('form').submit();
 }
 $("#xuanzhe").click(function(){
 	if($(this).is(':checked')){
 		$(".mima").show();
 	}else{
 		$(".mima").hide();
 	}
 });
 
 // $("#pwdform").click(function(){
 // 	 var name1 =$("#name1").val();
 // 	 var oldpwd =$("#oldpwd").val();
 //     var newpwd =$("#newpwd").val();
 //     var fenyun =$("#fenyun").val();
 // 	 var name2 =$("#name2").val();
 // 	 var tel =$("#tel").val();
 // 	 if(name1==""){
 // 	 	alert("用户名不能为空");
 // 	 	 return false;
 // 	 }else if(oldpwd==""){
 // 	 	alert("旧密码不能为空");
 // 	 	 return false;
 // 	 }else if(newpwd==""){
 // 	 	alert("新密码不能为空");
 // 	 	 return false;
 // 	 }else if(newpwd!=oldpwd){
 // 	 	alert("密码不一致");
 // 	 	 return false;
 // 	 }else if(fenyun==""){
 // 	 	alert("分润比不能为空");
 // 	 	 return false;
 // 	 }else if(name2==""){
 // 	 	alert("姓名不能为空");
 // 	 	 return false;
 // 	 }else if(tel==""){
 // 	 	alert("服务热线不能为空");
 // 	 	 return false;
 // 	 }
 	 
 	 
 // });
</script>
</html>