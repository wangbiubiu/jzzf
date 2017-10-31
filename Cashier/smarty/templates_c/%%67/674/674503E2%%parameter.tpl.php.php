<?php /* Smarty version 2.6.18, created on 2016-10-27 13:36:56
         compiled from D:%5Ctest%5Cpay%5Cpay%5CCashier%5C./pigcms_tpl/Merchants/System/merchant/parameter.tpl.php */ ?>
<!DOCTYPE html>
<html>
	<head>
		<title>参数配置</title>
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
		<link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
plugins/css/footable/footable.core.css" rel="stylesheet">
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
.weixin>h2,.zfb>h2{  margin-top: 0px; padding:0 20px; font-size: 16px; background: #f2f2f2; height: 35px; line-height: 35px; margin-bottom: 0px;}
.weixin>h2>span,.zfb>h2>span{ color: red;}
.weixin>h2>a,.zfb>h2>a{ float: right; color: #44b549;}
.weixin>div{ min-height: 60px; border-top:1px solid #f2f2f2;line-height: 60px; }
.weixin>div>label{width: 150px; text-align: right; margin-right: 10px; display: block;float: left;}
.weixin>div>input{ height: 25px;float: left; margin-top: 18px; margin-right: 10px;}
.weixin>div>div>p{min-height: 60px; }
.weixin>div>div>p>label{ width: 150px; text-align: right; margin-right: 10px;}
.weixin>div>div>p>input{ height: 25px; margin: 0 10px; width: 200px;}
.weixin>div>div>p>button{margin: 0 10px; width: 70px; height: 25px; line-height: 25px; text-align: center;border: none; border-radius: 5px; background: #36a9e0;}
.weixin>div>div>p>button a{color: #FFFFFF}
.wh{color: #ffd74a;}
.du{color: green; display: none;}

.zfb>div{ height: 60px; line-height: 60px;}
.zfb>div>label{ width: 150px; text-align: right; margin-right: 10px;}
.zfb>div>span{ color: #44b549; margin-right: 10px; margin-left: 10px;}
.zfb>div>i,.zfb>div>a{ color: #e75160;}
.zfb>div>input{ margin-right: 10px; margin-left: 10px; height: 25px;}

.ewm_nr{ width:500px; height: 500px; background: #FFFFFF; position: fixed;top: 50%; margin-top: -250px; display: none;
left: 50%; margin-left: -250px;
padding: 50px;
}
.ewm_nr>img{width:400px; height: 400px;}
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
						<h1>支付配置</h1>
						<div>
							<form>
							<div class="weixin">
								<h2>微信支付配置<span>（收款通道暂未通过审核，审核通过方可保存）</span><a href="#" class="bc">保存</a></h2>
								<div class="clearfix">
									<label>是否认领商户：</label><input type="checkbox" />注：该商户为认领商户，由所属通方提供分润
								</div>
								<div class="clearfix">
									<label>mchID</label><input class="shh" type="text" placeholder="请输入商户号" onkeyup="this.value=this.value.replace(/\D/g,'')"/>
								</div>
								<!--
                                	作者：2721190987@qq.com
                                	时间：2016-10-25
                                	描述：高级选项
                                -->
								<div>
									<label></label><input type="checkbox" id="gaoji">高级选项
									<div class="gaoji_nr" style="display: block;">
										
										<p>
											<label>appID</label>
											<input class="appid" type="text" placeholder="请输入微信公众号" onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\@\.]/g,'')"/>
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>
										<p>
											<label>appSecret</label>
											<input class="appSecret" type="text" placeholder="请输入微信公众号密匙" onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\@\.]/g,'')"/>
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>
										<p>
											<label>partnerKey</label>
											<input class="partnerKey" type="text"  placeholder="请输入微信支付商户号初始密匙" onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\@\.]/g,'')"/>
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>
										<p>
											<label>apiclient-cert.pem</label>
											<input class="apiclient_cert" type="text" placeholder="请输入微信支付商户证书"/>
											<button><a href="#">浏览</a></button>
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>
										<p>
											<label>apiclient-key.pem</label>
											<input class="apiclient_key" type="text" placeholder="请输入微信支付商户证书密匙安全"/>
											<button><a href="#">浏览</a></button>
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>
									</div>
								</div>
							</div>
						</form>	
							<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-25
                        	描述：支付宝
                        -->
                        <form>
							<div class="zfb">
								<h2>支付宝2.0收款参数配置<span>（收款通道暂未通过审核，审核通过方可保存）</span><a href="#" class="bc1">保存</a></h2>
									<div>
										<label>是否认领商户:</label><input type="checkbox"  style="margin-top: 18px; width: 13px; height: 13px;"/>注：该商户为非认领商户，官方没有给分润
									</div>
									<div>
										<label>口碑授权:</label><span>未授权</span><i class="fa fa-qrcode"></i><a href="#" class="ewm">点击扫码授权</a>
									</div>
									<div>
										<label>appID:</label><input class="zfbsh" type="text" placeholder="请输入支付宝商户号" onkeyup="this.value=this.value.replace(/\D/g,'')"/>
									</div>
							</div>
							<div class='ewm_nr' style="border: 1px solid #EEEEEE;"><img src=""></div>	
						</form>
						
					</div>
					<!--
                    	作者：2721190987@qq.com
                    	时间：2016-10-25
                    	描述：二维码弹出框
                    -->	
								
						
					</div>
				</div>
                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
		</div>
	

	</body>
	<script>
	$(".gaoji").click(function(){
		if($(this).is(':checked')){
 		$(".gaoji_nr").show();
 	}else{
 		$(".gaoji_nr").hide();
 	}
	});
	
	
$("body").click(function(){
	$(".ewm_nr").hide();
})
	$(".ewm").click(function(e){
		e = e || window.event;
		if(e.stopPropagation){
		e.stopPropagation();
		}else{
		e.cancelBubble=true;
		}
		$(".ewm_nr").show();
		});
	
		$(".shh").blur(function(){
			if($(this).val()==""){
				alert("商户号不能为空");
			}else if($(this).val().length!=10){
				alert("商户号输入错误");
				$(this).val("")
			}
		});
		$(".appid").blur(function(){
			if($(this).val()==""){
				alert("微信公众号不能为空");
				$(this).siblings(".wh").show();
				$(this).siblings(".du").hide();

			}else if($(this).val().length!=18){
				alert("微信公众号输入错误");
				$(this).val("")
				$(this).siblings(".wh").show();
				$(this).siblings(".du").hide();
				
			}else{
				$(this).siblings(".wh").hide();
				$(this).siblings(".du").show();
			}
		});
		
		$(".appSecret").blur(function(){
			if($(this).val()==""){
				alert("微信公众号密匙不能为空");
				$(this).siblings(".wh").show();
				$(this).siblings(".du").hide();

			}else if($(this).val().length!=32){
				alert("微信公众号密匙输入错误");
				$(this).val("")
				$(this).siblings(".wh").show();
				$(this).siblings(".du").hide();
				
			}else{
				$(this).siblings(".wh").hide();
				$(this).siblings(".du").show();
			}
		});
		
		$(".partnerKey").blur(function(){
			if($(this).val()==""){
				alert("微信支付商户号初始密匙不能为空");
				$(this).siblings(".wh").show();
				$(this).siblings(".du").hide();

			}else if($(this).val().length!=32){
				alert("微信支付商户号初始密匙输入错误");
				$(this).val("")
				$(this).siblings(".wh").show();
				$(this).siblings(".du").hide();
				
			}else{
				$(this).siblings(".wh").hide();
				$(this).siblings(".du").show();
			}
		});
		
		
		
		$(".zfbsh").blur(function(){
			if($(this).val()==""){
				alert("商户号不能为空")
			}else if($(this).val().length!=10){
				alert("商户号输入错误");
				$(this).val("")
			}
		});
		
		$(".bc").click(function(){
			if($(".shh").val()==""){
				alert("商户号不能为空");
				return false;
			}else if($(".appid").val()==""){
				alert("微信公众号不能为空");
				return false;
			}else if($(".appSecret").val()==""){
				alert("微信公众号密匙不能为空");
				return false;
			}else if($(".partnerKey").val()==""){
				alert("微信支付商户号初始密匙不能为空");
				return false;
			}
		});	
		$(".bc1").click(function(){
			if($(".zfbsh").val()==""){
				alert("商户号不能为空");
				return false;
			}
		});
	</script>
	<!-- iCheck -->
	<script src="<?php echo @RlStaticResource; ?>
plugins/js/iCheck/icheck.min.js"></script>
</html>