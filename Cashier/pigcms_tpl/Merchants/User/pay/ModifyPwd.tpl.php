<!DOCTYPE html>
<html>
	<head>
		<title>账户设置</title>
		<?php
			include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/header.tpl.php';
		?>
		<link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>wxCoupon/wxCoupon.css" rel="stylesheet">
		<link href="<?php echo $this -> RlStaticResource; ?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
		<link href="<?php echo $this -> RlStaticResource; ?>plugins/css/iCheck/custom.css" rel="stylesheet">
		<link href="<?php echo RL_PIGCMS_STATIC_PATH; ?>plugins/css/footable/footable.core.css" rel="stylesheet">
		<style>.payment_allocation h1 {
	font-size: 18px;
	border-bottom: 1px solid #d9e6e9;
	border-top: 3px solid #edfbfe;
	background: #FFFFFF;
	height: 40px;
	line-height: 40px;
	padding: 0px 20px; 
	margin-bottom: 0px;
}
.payment_allocation>div{ background: #FFFFFF;padding: 10px;}
.weixin,.zfb{border:1px solid #f2f2f2; margin-bottom: 20px;}
.weixin>h2,.zfb>h2{ margin-top: 0px; padding:0 20px; font-size: 16px; background: #f2f2f2; height: 35px; line-height: 35px; margin-bottom: 0px;}
.weixin>h2>span,.zfb>h2>span{ color: red;}
.weixin>h2>a,.zfb>h2>a{ float: right; color: #44b549;}
.weixin>div{ min-height: 60px; border-top:1px solid #f2f2f2;line-height: 60px; }
.weixin>div>label{width: 150px; text-align: right; margin-right: 10px; display: block;float: left;}
.weixin>div>input{ height: 25px;float: left; margin-top: 18px; margin-right: 10px;    line-height: 24px;}
.weixin>p{min-height: 40px;line-height: 40px; margin-bottom: 0px;}
.weixin>p>label{ width: 150px; text-align: right; margin-right: 10px;}
.weixin>p>input{ height: 25px; margin: 0 10px; width: 200px;    line-height: 24px;}
.weixin>p>button{margin: 0 10px; width: 70px; height: 25px; line-height: 25px; text-align: center;border: none; border-radius: 5px; background: #36a9e0;}
.weixin>p>button a{color: #FFFFFF}
.wh{color: #ffd74a;}
.du{color: green; display: none;}

.zfb>div{ height: 60px; line-height: 60px;}
.zfb>div>label{ width: 150px; text-align: right; margin-right: 10px;}
.zfb>div>span{ color: #44b549; margin-right: 10px; margin-left: 10px;}
.zfb>div>i,.zfb>div>a{ color: #e75160;}
.zfb>div>input{ margin-right: 10px; margin-left: 10px; height: 25px;  line-height: 24px;}

.ewm_nr{ width:500px; height: 500px; background: #FFFFFF; position: fixed;top: 50%; margin-top: -250px; display: none;
left: 50%; margin-left: -250px;
padding: 50px;
}
.ewm_nr>img{width:400px; height: 400px;}
input{border-radius: 3px;border: 1px solid #bbbbbb;}
</style>
		<script src="<?php echo $this -> RlStaticResource; ?>plugins/js/footable/footable.all2.min.js"></script>
	</head>

	<body>
		<div id="wrapper">
			<?php
			include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/setupleftmenu.tpl.php';
			?>
			<div id="page-wrapper" class="gray-bg">
				<?php
				include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/top.tpl.php';
				?>
				<div class="row wrapper border-bottom white-bg page-heading">
					<div class="col-lg-10">
						<h2>商户列表</h2>
						<ol class="breadcrumb">
							<li>
								<a>
									User
								</a>
							</li>
							<li>
								<a>
									商户中心
								</a>
							</li>
							<li>
								<a>
									商户列表
								</a>
							</li>
							<li class="active">
								<strong>支付配置</strong>
							</li>
						</ol>
					</div>
					<div class="col-lg-2"></div>
				</div>
				<div class="wrapper wrapper-content animated fadeInRight">
					<div class="row payment_allocation">
						<h1>商家帐号信息</h1>
						<div>
                                                    <form id="form" action="?m=User&c=pay&a=ModifyPwd" method="post">
							
								<div>
								
									<div class="weixin" >
										<h2>帐号信息<a href="javascript:void(0);" class="bc">修改</a></h2>
										<p>
											<label>商户ID</label>
                                                                                        <input type="text" readonly="readonly" value="<?php echo $merchants['mid'];?>"></span>
										</p>
										<p>
											<label>商户名</label>
                                                                                        <input type="text" name="company" value="<?php echo $merchants['company'];?>"></span>
										</p>
										<p>
											<label>登录账号</label>
                                                                                        <input type="text" readonly="readonly" value="<?php echo $merchants['username'];?>"></span>
										</p>
										<p>
											<label>联系人</label>
                                                                                        <input type="text" name="realname" value="<?php echo $merchants['realname'];?>"></span>
										</p>
										<p>
											<label>联系电话</label>
											<input type="text" name="phone" value="<?php echo $merchants['phone'];?>"></span>
										</p>
										<p>
											<label>地址</label>
                                                                                        <input type="text" name="address" value="<?php echo $merchants['address'];?>"></span>
										</p>
									</div>
								</div>
						
						</form>	
			
                                                    <form action="?m=User&c=pay&a=doModifyPwd" method="post" id="pform">
							<div class="zfb">
								<h2>帐号信息<a href="javascript:void(0);" class="bc1">修改</a></h2>
									<div style="width:100%; padding-left: 30px; border-bottom: 1px solid #f3f3f3; height: 30px; line-height: 30px;">
										修改密码
									</div>
									<div>
                                                                            <label>新密码:</label><input name="password" type="password" id="newmm" placeholder="请输入新密码">
									</div>
									<div>
                                                                            <label>新密码:</label><input name="repassword" type="password" id="qrmm" placeholder="请确认新密码">
									</div>
							</div>
							
						</form>
                                                    
					</div>
					<!--
                    	作者：2721190987@qq.com
                    	时间：2016-10-25
                    	描述：二维码弹出框
                    -->	
								
						
					</div>
				</div>
			</div>
		</div>
	

	</body>
	<script>
            //修改密码
		$(".bc1").click(function(){
                        var password = $("#newmm").val();
                        var repassword = $("#qrmm").val();
			if(password==""){
                                swal("密码不能为空",'','error');
				return false;
			}else if(password.length<6 || password.length>16){
                             swal("密码长度不正确",'','error');
				return false;
			}else if(repassword==""){
                             swal("确认密码不能为空",'','error');
				return false;
			}else if(repassword != password){
                                swal("密码不一致",'','error');
				return false;
			}
                       $('#pform').submit();
                       
		});	
                
                //修改商户信息
               $('.bc').click(function(){
                        if($(":input[name='company']").val()==""){
				swal("商户名不能为空",'','error');
				return false;
			}else if($(":input[name='realname']").val()==""){
				swal("联系人不能为空",'','error');
				return false;
			}else if($(":input[name='phone']").val()==""){
				swal("电话不能为空",'','error');
				return false;
			}else if($(":input[name='address']").val()==""){
				swal("地址不能为空",'','error');
				return false;
			}
                        var company = $(":input[name='company']").val();
                        var realname = $(":input[name='realname']").val();
                        var phone = $(":input[name='phone']").val();
                        var address = $(":input[name='address']").val();
                       
                        $.post('?m=User&c=pay&a=ModifyPwd',{company:company,realname:realname,phone:phone,address:address},function(e){
                            if(e.code==1){
                                swal({
                                    title:'修改成功!',
                                    text:'',
                                    type:'success',
                                    closeOnConfirm:false
                                },function(){
                                    location.reload();
                                });
                                
                            }else{
                                swal("修改失败!",'','error');
                            }
                        },'json');
               });
	</script>
	<!-- iCheck -->
	<script src="<?php echo $this -> RlStaticResource; ?>plugins/js/iCheck/icheck.min.js"></script>
</html>