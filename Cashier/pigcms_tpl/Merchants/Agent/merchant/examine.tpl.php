<!DOCTYPE html>
<html>
<head>
<title>门店管理</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
<link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
<style>
.ibox-title h5 {
	margin: 10px 0 0px;
}
button>a{display: block; width: 100%; height: 100%;}
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
p{ margin-bottom: 0px;}
.role_permission{background: #FFFFFF;}
.role_permission>h1{ font-size: 18px; border-bottom:1px solid #f2f2f2 ; height: 40px; line-height: 40px; border-top: 3px solid #B5D6FD; margin: 0px; padding-left: 20px;}
.role_permission>div{ border: 1px solid #f2f2f2; margin:20px  auto; width: 98%;}
.role_permission>div>h2{ height: 40px; line-height: 40px; padding: 0 10px; background: #f2f2f2; margin: 0px; font-size: 16px; font-weight: normal;}
.role_permission>div>div{ min-height: 40px; margin: 10px 0;}
.role_permission>div>div>label{ width: 120px; text-align: right; margin-right: 20px; float: left;}
.role_permission>div>div>label>span{ color: red;}
.role_permission>div>div>div{ float: left;}
.role_permission>div>div>div>input{ width: 310px; height: 30px;}
.tj{ width: 380px; margin: 0 auto;}
.tj>input{ width: 100px; text-align: center;height: 30px; line-height: 30px; border: none; border-radius: 2px; background: #2f9833; margin-right: 20px; color: #FFFFFF;}
.tj>button{ width: 100px; text-align: center;height: 32px; line-height: 32px; border-radius: 2px; background: #FFFFFF; margin-right: 20px; border: 1px solid #f2f2f2;}
.tj>button>a{ color: #202020;}
.ts{ display: none; color: red;}

.img_upload_box{ height: 40px !important }
.js_pager,.img_upload_box {float: none !important;}
.img_upload_box_oper {
display: block;
background: #d9dadc;
border: 1px solid #d9dadc !important;
width: 100%;
height: 30px !important;
text-align: center;
line-height: 30px;
color:#777777;
border-radius: 5px
}
</style>
<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all2.min.js"></script>
</head>

<body>
	<div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>商家信息管理</h2>
					<ol class="breadcrumb">
						<li><a>User</a></li>
						<li><a>商户中心</a></li>
						<li><a>进件管理</a></li>
						<li class="active"><strong>填写结算账户</strong></li>
					</ol>
				</div>
				<div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
			<form action="" method="post" >
			 <input name="type" type="hidden" value="<?php $_GET['type']?>">
				<div class="row role_permission" style="position: relative; padding-bottom: 50px;">
					<h1>填写结算账户 </h1>

					<div>
						<h2>结算账户</h2>
						<div class="clearfix">
							<label><span>*</span>账户类型：</label>
							<div><input type="text" name="accountType" value="<?php echo $accountType; ?>" readonly></div>
						</div>
						<div class="clearfix">
							<label><span>*</span>开户名称：</label>
							<div>

								<input type="hidden" name='mid' value='<?php echo $_GET['mid'];?>' required >


								<input id="account_ID" type="text" placeholder="" name='account' value='<?php echo $account; ?>' readonly>
								<p class="ts"></p>
								<p>为确保交易资金安全，银行账户开户名称需与营业执照登记公司名称一致。</p>
							</div>
						</div>
						
						<div class="clearfix">
							<label><span>*</span>开户银行：</label>
							<div>
								<input id="open_bank" type="text" name='bank' required value="<?php echo $reg['bank']?>">
								<p class="ts"></p>
								<p>填写开户银行</p>
							</div>
						</div>
						<div class="clearfix">
							<label><span>*</span>开户银行支行：</label>
							<div>
								<input id="open_bank" type="text" name='bank_branch' required value="<?php echo $reg['bank_branch']?>">
								<p class="ts"></p>
								<p>填写开户银行支行</p>
							</div>
						</div>
						<div class="clearfix">
							<label><span>*</span>开户银行城市：</label>
							<div>
								<input id="bank_city" type="text" name='bankaddress' required value="<?php echo $reg['bankaddress']?>">
								<p class="ts"></p>
								<p>填写开户银行所在城市</p>
							</div>
						</div>
						
						<div class="clearfix">
							<label><span>*</span>银行账号：</label>
							<div>
								<input id="bank_account" type="text" placeholder="" onkeyup="this.value=this.value.replace(/\D/g,'')" name='accountid' required value="<?php echo $reg['accountid']?>">
								<p class="ts"></p>
								<p>请填写企业的对公银行账号</p>
							</div>
						</div>
	
					</div>

					<p class="tj">
					     <?php if($_GET['type']){?>
					       <input  type="submit"  value="保存"/>
					     <?php }else{?>
					       <input  type="submit"  value="保存信息"/>
					     <?php }?>
						
						
					</p>
			</form>
	            </div>

			</div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
	</div>


<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
<script>
	$("#account_ID").blur(function(){
		if($(this).val()==""){
			$(this).next(".ts").show()
			$(this).next(".ts").text("请填写开户名称 ")
		}else{
			$(this).next(".ts").hide()
		}
	});
	$("#open_bank").blur(function(){
		if($(this).val()==""){
			$(this).next(".ts").show()
			$(this).next(".ts").text("请填写开户银行 ")
		}else{
			$(this).next(".ts").hide()
		}
	})
	$("#bank_city").blur(function(){
		if($(this).val()==""){
			$(this).next(".ts").show()
			$(this).next(".ts").text("请填写开户银行城市 ")
		}else{
			$(this).next(".ts").hide()
		}
	})
	$("#bank_account").blur(function(){
		if($(this).val()==""){
			$(this).next(".ts").show()
			$(this).next(".ts").text("银行账号不能为空  ")
		}else{
			$(this).next(".ts").hide()
		}
	})
	
	$(".tj>input").click(function(){
		
		if($("#account_ID").val()==""){
			$("#account_ID").next(".ts").show()
			$("#account_ID").next(".ts").text("请填写开户名称 ")
			return false
		}else{
			$("#account_ID").next(".ts").hide();
		}
		
		if($("#open_bank").val()==""){
			$("#open_bank").next(".ts").show()
			$("#open_bank").next(".ts").text("请填写开户银行 ")
			return false
		}else{
			$("#open_bank").next(".ts").hide();
		}

		if($("#bank_city").val()==""){
			$("#bank_city").next(".ts").show()
			$("#bank_city").next(".ts").text("请填写开户银行城市 ")
			return false
		}else{
			$("#bank_city").next(".ts").hide();
		}
		
		if($("#bank_account").val()==""){
			$("#bank_account").next(".ts").show()
			$("#bank_account").next(".ts").text("银行账号不能为空 ")
			return false
		}else{
			$("#bank_account").next(".ts").hide();
		}
	});
</script>
</html>