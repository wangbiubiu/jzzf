<?php /* Smarty version 2.6.18, created on 2016-11-16 15:24:07
         compiled from D:%5Ctest%5Cpay%5Cpay%5CCashier%5C./pigcms_tpl/Merchants/System/author/addrole.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>
<title>添加角色</title>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="<?php echo @RlStaticResource; ?>
plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo @RlStaticResource; ?>
plugins/css/iCheck/custom.css" rel="stylesheet">
<link href="<?php echo @RL_PIGCMS_STATIC_PATH; ?>
plugins/css/footable/footable.core.css" rel="stylesheet">
<style>
.ibox-title h5 {
	margin: 10px 0 0px;
}

select.input-sm {
	height: 35px;
	line-height: 35px;
}

.float-e-margins .btn-info {
	margin-bottom: 0px;
}

.fa-paste {
	margin-right: 7px;
	padding: 0px;
}

.dz-preview {
	display: none;
}

.ibox-title ul {
	list-style: outside none none !important;
	margin: 0 0 0 10px;
	padding: 0;
}

.ibox-title li {
	float: left;
	width: 15%;
}

#commonpage {
	float: right;
	margin-bottom: 10px;
}

#table-list-body .btn-st {
	background-color: #337ab7;
	border-color: #2e6da4;
	cursor: auto;
}

#select_Cardtype .i-checks label {
	cursor: pointer;
}

#ewmPopDiv .modal-body {
	text-align: center;
}

.modal-footer {
	text-align: center;
}

.modal-footer .btn {
	padding: 7px 30px;
}

.js_modify_quantity .fa {
	margin-left: 10px;
}

#ewmPopDiv .downewm {
	font-size: 14px;
	padding: 15px;
	text-align: center;
}

.modal-body {
	padding: 20px 30px 15px;
}

#select_Cardtype p {
	margin-bottom: 8px;
}

.role_permission{background: #FFFFFF;}
.role_permission>h1{ font-size: 18px; border-bottom:1px solid #f2f2f2 ; height: 40px; line-height: 40px; border-top: 3px solid #B5D6FD; margin: 0px; padding-left: 20px;}
.role_permission>div{ border: 1px solid #f2f2f2; margin:20px  auto; width: 98%;}
.role_permission>div>h2{ height: 40px; line-height: 40px; padding: 0 10px; background: #f2f2f2; margin: 0px; font-size: 16px; font-weight: normal;}
.role_permission>div>p{ height: 40px; line-height: 40px; margin-bottom: 0px;}
.role_permission>div>p>label{ width: 120px; text-align: right; margin-right: 20px; margin-bottom: 0px;}
.role_permission>div>p>input{ width: 200px; border: none; height: 30px;}

.select_permissions>table{ width: 100%; margin-top: 20px;}

.select_permissions_one{ text-align: center; border-right: 1px solid #f2f2f2;min-width: 160px;}
.select_permissions_one>label>input{ margin-right: 10px;}
.select_permissions_two{ text-align: left;border-right: 1px solid #f2f2f2; padding:0 10px; min-width: 150px;}
.select_permissions_two>p{line-height: 40px;}
.select_permissions_two>p{line-height: 40px; margin-bottom: 0px;min-height: 40px;border-top:1px solid #f2f2f2;}
.select_permissions_two>p:first-child{border-top: none;}
.select_permissions_two>p>label>input{ margin-right: 10px;}
.select_permissions_two>p>label{ margin-left: 20px;}
.select_permissions_three{ min-height: 40px;padding:0 10px;}
.select_permissions_three>p{min-height: 40px; margin-bottom: 0px; border-top:1px solid #f2f2f2}
.select_permissions_three>p:first-child{border-top: none;}
.select_permissions_three>p>label{ margin-left: 20px;}
.select_permissions_three>p>label>input{ margin-right: 10px;}

.bc{ text-align: center; height: 30px; line-height: 30px; background: #008fd3; color: #FFFFFF; border: none; border-radius: 2px; margin: 0 auto; width: 66px; position: absolute; left: 50%; margin-left: -33px; bottom: 20px;}
</style>
<script src="<?php echo @RlStaticResource; ?>
plugins/js/footable/footable.all2.min.js"></script>
</head>

<body>
	<div id="wrapper">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/leftmenu.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div id="page-wrapper" class="gray-bg">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/top.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>角色管理</h2>
					<ol class="breadcrumb">
						<li><a>User</a></li>
						<li><a>权限控制</a></li>
						<li><a>角色管理</a></li>
						<li class="active"><strong>编辑角色权限</strong></li>
					</ol>
				</div>
				<div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row role_permission" style="position: relative; padding-bottom: 50px;">
					<h1>编辑角色权限</h1>
					<div>
						<h2>角色添加</h2>
						<p>
							<label>角色名</label><input type="text" placeholder="请输入角色名" class="juese">
						</p>
					</div>
					
					<div class="select_permissions ">
						<h2>选择权限</h2>
						<table border="1" bordercolor="#f2f2f2">
							<tbody>
								
							
						<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-28
                        	描述：统计
                        -->
						<tr class="clearfix">
							<td class="select_permissions_one" style="height: 165px; line-height: 165px;"><label><input type="checkbox">统计中心</label></td>
							<td class="select_permissions_two">
								<p><label><input type="checkbox">服务商统计</label></p>
								<p><label><input type="checkbox">代理商统计</label></p>
								<p><label><input type="checkbox">商户统计</label></p>
								<p><label><input type="checkbox">业务员统计</label></p>
							</td>
							<td class="select_permissions_three">
								<p></p>
								<p><label><input type="checkbox">代理商统计详情</label></p>
								<p><label><input type="checkbox">商户商统计详情</label></p>
								<p><label><input type="checkbox">业务员统计详情</label></p>
							</td>
						</tr>
						
						<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-28
                        	描述：订单中心
                        -->
						<tr class="clearfix">
							<td class="select_permissions_one" style="height: 40px; line-height: 40px;"><label><input type="checkbox">订单中心</label></td>
							<td class="select_permissions_two">
								<p><label><input type="checkbox">订单管理</label></p>
							</td>
							<td class="select_permissions_three">
								<p><label><input type="checkbox">订单详情查看</label></p>
							
							</td>
						</tr>
						
						<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-28
                        	描述：商户中心
                        -->
						<tr class="clearfix">
							<td class="select_permissions_one" style="height: 40px; line-height: 40px;"><label><input type="checkbox">商户中心</label></td>
							<td class="select_permissions_two">
								<p><label><input type="checkbox">商户管理</label></p>
							</td>
							<td class="select_permissions_three">
								<p>
									<label><input type="checkbox">商户添加</label>
									<label><input type="checkbox">商户密码重置</label>
									<label><input type="checkbox">商户支付配置</label>
									<label><input type="checkbox">商户支付宝支付配置</label>
									<label><input type="checkbox">商户详细</label>
									<label><input type="checkbox">商户编辑</label>
									<label><input type="checkbox">商户订单查看</label>
									<label><input type="checkbox">商户分配业务员</label>
									<label><input type="checkbox">商户删除</label>
								</p>
							
							</td>
						</tr>
						
						<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-28
                        	描述：代理中心
                        -->
						<tr class="clearfix">
							<td class="select_permissions_one" style="height: 165px; line-height: 165px;"><label><input type="checkbox">代理中心</label></td>
							<td class="select_permissions_two">
								<p><label><input type="checkbox">代理商管理</label></p>
								<p><label><input type="checkbox">进件管理</label></p>
								<p><label><input type="checkbox">业务员商户管理</label></p>
								<p><label><input type="checkbox">代理管理</label></p>
							</td>
							<td class="select_permissions_three">
								<p>
									<label><input type="checkbox">添加代理商</label>
									<label><input type="checkbox">代理商密码重置</label>
									<label><input type="checkbox">代理商详细</label>
									<label><input type="checkbox">代理商编辑</label>
									<label><input type="checkbox">下级代理查看</label>
									<label><input type="checkbox">代理商商户查看</label>
									<label><input type="checkbox">代理商订单查看</label>
									<label><input type="checkbox">代理商删除</label>
								</p>
								<p>
									<label><input type="checkbox">进件查看</label>
									<label><input type="checkbox">进件删除</label>
									<label><input type="checkbox">进件编辑</label>
								</p>
								<p>
									<label><input type="checkbox">添加业务员</label>
									<label><input type="checkbox">业务员密码重置</label>
									<label><input type="checkbox">业务员详细信息查看</label>
									<label><input type="checkbox">业务员编辑</label>
									<label><input type="checkbox">业务员商户查看</label>
									<label><input type="checkbox">业务员订单查看</label>
									<label><input type="checkbox">业务员删除</label>
								</p>
								<p><label><input type="checkbox">代理设置修改</label></p>
							</td>
						</tr>
						
						<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-28
                        	描述：设置
                        -->
						<tr class="clearfix">
							<td class="select_permissions_one" style="height: 80px; line-height: 80px;"><label><input type="checkbox">设置</label></td>
							<td class="select_permissions_two">
								<p><label><input type="checkbox">账户设置</label></p>
								<p><label><input type="checkbox">安全设置</label></p>
							</td>
							<td class="select_permissions_three">
								<p><label><input type="checkbox">基本设置</label></p>
								<p>
								<label><input type="checkbox">密码重置</label>
								<label><input type="checkbox">绑定/解绑手机</label>
								<label><input type="checkbox">绑定/解绑邮箱</label>
								</p>
							</td>
						</tr>
						
						<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-28
                        	描述：设置
                        -->
						<tr class="clearfix">
							<td class="select_permissions_one" style="height: 40px; line-height: 40px;"><label><input type="checkbox">首页</label></td>							
						</tr>
						</tbody>
					</table>
				</div>
			<input class="bc" type="submit"  value="保存"/>
					
	            </div>
			</div>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
	</div>

<script>
	$(".select_permissions_one>label>input").click(function(){
		if($(this).is(':checked')){
			$(this).parents(".select_permissions_one").nextAll().find("input").prop("checked", true);
		}else{
			$(this).parents(".select_permissions_one").nextAll().find("input").removeAttr("checked", true);
		}
	});
	
	$(".select_permissions_two>p>label>input").click(function(){
		var index = $(this).parent("label").parent("p").index();
		if($(this).is(':checked')){
			$(this).parents(".select_permissions_two").next(".select_permissions_three").children("p").eq(index).find("input").prop("checked", true);
		}else{
			$(this).parents(".select_permissions_two").next(".select_permissions_three").children("p").eq(index).find("input").removeAttr("checked", true);
		}
	});
	
	$(".select_permissions_three>p>label>input").click(function(){
		var three_p = $(this).parent("label").parent("p").index()
		$(this).parent("label").parent("p").find('input').each(function(){
			$(this).parent("label").parent("p").parent(".select_permissions_three").prev(".select_permissions_two").children("p").eq(three_p).find("input").removeAttr("checked", true);
			$(this).parent("label").parent("p").parent(".select_permissions_three").prev(".select_permissions_two").prev(".select_permissions_one").find("input").removeAttr("checked", true);
			
			
		})
		
		
	});
	
	$(".select_permissions_two>p>label>input").click(function(){
		var three_p = $(this).parent("label").parent("p").index()
		$(this).parent("label").parent("p").find('input').each(function(){
			
			$(this).parent("label").parent("p").parent(".select_permissions_two").prev(".select_permissions_one").find("input").removeAttr("checked", true);
		})
	});
	
	$(".bc").click(function(){
		var juese = $(".juese").val();
		if(juese==""){
			alert("角色不能为空")
		}
	});
	
</script>
	
<!-- iCheck -->
<script src="<?php echo @RlStaticResource; ?>
plugins/js/iCheck/icheck.min.js"></script>

</html>