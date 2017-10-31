<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>业务员</title>
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
 .account_set>div p{ line-height: 40px; line-height: 40px; border-top: 1px solid #f2f2f2; padding-left: 10px; margin-bottom: 0px;}
 .account_set>div p label{ width: 60px; text-align: right; margin-right: 20px;}
</style>
<body>
    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/setupleftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>收银台</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>Pay</a>
                        </li>
                        <li class="active">
                            <strong>账户设置</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
					
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
			   <div class="row">
			   		<div class="account_set">
			   			<h1>账户设置<a href="?m=Salesman&c=pay&a=setMyself">编辑</a></h1>
			   			<div>
			   				<h2>基本信息</h2>
			   				<div>
			   					<p><label>用户名</label><span><?php echo $saler['account']; ?></span></p>
			   					<p><label>分润比</label><span><?php echo $saler['commission'] * 100 . '%'; ?></span></p>
			   					<p><label>姓名</label><span><?php echo $saler['username']; ?></span></p>
			   					<p><label>手机号</label><span><?php echo $saler['phone']; ?></span></p>
			   				</div>
			   			</div>
			   		</div>
				</div>
            </div>
            </div>
        </div>
   <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
</body>

 <script>
$("#pwdform").submit(function(){
	var oldpwd=$.trim($('input[name="oldpwd"]').val());
	var newpwd=$.trim($('input[name="newpwd"]').val());
	var new2pwd=$.trim($('input[name="new2pwd"]').val());
	
	if(!oldpwd){
		swal("温馨提醒", "您没有输入旧密码", "error");
		$('input[name="oldpwd"]').focus();
		return false;
	}
	if(!newpwd){
		swal("温馨提醒", "您没有输入新密码", "error");
		$('input[name="newpwd"]').focus();
		return false;
	}
	if(!new2pwd){
		swal("温馨提醒", "您没有输入新密码！", "error");
		$('input[name="new2pwd"]').focus();
		return false;
	}
	if(newpwd != new2pwd){
		swal("温馨提醒", "两次输入的新密码不一致", "error");
		$('input[name="new2pwd"]').focus();
		return false;
	}
	<?php if ($phone && isset($sms_config['sms_key']) && $sms_config['sms_key']) {?>
	var code = $.trim($('input[name="code"]').val());
	if(!code){
		swal("温馨提醒", "短信验证码不能为空", "error");
		$('input[name="code"]').focus();
		return false;
	}
	<?php } else {?>
	var phone = $.trim($('input[name="phone"]').val());
	if(!phone){
		swal("温馨提醒", "手机号不能为空", "error");
		$('input[name="phone"]').focus();
		return false;
	}
	<?php }?>
	return true;
});
		 
var flag = false;
$(document).ready(function(){
	$('.input-group-addon').click(function(){
		if (flag) return false;
		flag = true;
		$.ajax({
			url:'?m=User&c=index&a=getCode',
			type:"post",
			dataType:"JSON",
			success:function(ret){
				if(!ret.error){
					$('#codetime').val(60);
					count_down();
				} else {
					flag = false;
					swal({
					  title: "获取短信验证码",
					  text: ret.info,
					  type: "error"
					 });
			   }
			}
		});
	});
});

function count_down(){
	var down = setInterval(function(){
		var num = $('#codetime').val();
		if(num > 0){
			$('#codetime').val(num - 1);
			$('.input-group-addon').html('(' + parseInt(num - 1) + ')秒后重新获取');
		}else{
			flag = false;
			$('#codetime').val(-1);
			$('.input-group-addon').html('获取验证码');
			clearInterval(down);
		}
	},1000);
}
</script>
</html>