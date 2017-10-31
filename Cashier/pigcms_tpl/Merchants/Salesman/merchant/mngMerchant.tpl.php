<!DOCTYPE html>
<html>
	<head>
		<title>代理中心 | 商户管理</title>
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
.zfb>div>span{ margin-right: 10px; margin-left: 10px;}
.zfb>div>i,.zfb>div>a{ color: #e75160;}
.zfb>div>input{ margin-right: 10px; margin-left: 10px; height: 25px;}

.ewm_nr{ width:500px; height: 500px; background: #FFFFFF; position: fixed;top: 50%; margin-top: -250px; display: none;
left: 50%; margin-left: -250px;
padding: 50px;
}
.ewm_nr>img{width:400px; height: 400px;}

.title{ margin:0 -15px;  }
.title>ul{margin-left: -40px}
.title>ul>li{ float: left; width: 120px; height: 40px; text-align: center;  line-height: 40px; }
.cnt{ background: #ffffff }
</style>
		<script src="<?php echo $this -> RlStaticResource; ?>plugins/js/footable/footable.all2.min.js"></script>
	</head>

	<body>
		<div id="wrapper">
			<?php
			include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/leftmenu.tpl.php';
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
									Salesman
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
								<strong>商户信息管理</strong>
							</li>
						</ol>
					</div>
					<div class="col-lg-2"></div>
				</div>
				<div class="wrapper wrapper-content animated fadeInRight"   >
					<div class="clearfix title">
					<ul>
						<li class="cnt">基本信息</li>

						<?php if ($merchant['mtype']!=2){ ?>
							<li>进件管理</li>
						<?php } ?>
					</ul>
				</div>
				<div class="row payment_allocation">
						

					<div class="zh_nr">
							
								<div class="weixin">
									<h2>账号信息</h2>
									<!--  <a href="?m=Salesman&c=merchant&a=createMerchant&mid=<?php echo $merchant['mid']; ?>" class="bc">编辑</a>-->
									<div class="clearfix">

										<label>商户ID：</label><span><?php echo $merchant['mid'];?></span>
									</div>
									<div class="clearfix">
										<label>商户名</label><span><?php echo $merchant['company'];?></span>
									</div>
									<div class="clearfix">
										<label>登录账号</label><span><?php echo $merchant['username'];?></span>
									</div>
									<div class="clearfix">
										<label>微信回扣率</label><span><?php echo $merchant['commission'] * 100 . '%';?></span>
									</div>
									<div class="clearfix">
										<label>支付宝回扣率</label><span><?php echo $merchant['alicommission'] * 100 . '%';?></span>
									</div>
									<div class="clearfix">
										<label>联系人</label><span><?php echo $merchant['realname'];?></span>
									</div>
									<div class="clearfix">
										<label>联系电话</label><span><?php echo $merchant['phone'];?></span>&nbsp&nbsp&nbsp&nbsp<span><?php echo $merchant['tel'];?></span>
									</div>
									<div class="clearfix">
										<label>地址</label><span><?php echo $merchant['address'];?></span>
									</div>
							</div>



								<div style='display: none;'>
					                        <div class="zfb">
					                          <h2>微信收单</h2>
					                            <div>
					                              <label>微信收单:</label>
					                     <?php if(isset($status)){?>         
    					                     <strong style="color: #44b549;">
    					                      <?php switch ($status) {
    									      	case '0':echo '待初审';break;
    									      	case '1':echo '初审成功并审核中';break;
    									      	case '2':echo '审核成功';break;
    									      	case '3':echo '审核失败';break;
    									      	case '4':echo '初审失败';break;
    									      	default:echo '';break;
    									      } ?> 
    					                     </strong>
					                      <a href="?m=Salesman&c=merchant&a=regist&mid=<?php echo $_GET['mid']; ?>"><?php switch ($status) {
									        case '0':echo '待初审';break;
    								      	case '1':echo '初审成功并审核中';break;
    								      	case '2':echo '审核成功';break;
    								      	case '3':echo '点击修改进件信息';break;
    								      	case '4':echo '点击修改进件信息';break;
									      	default:echo '';break;
									      } ?>
									      </a>
									   <?php }else{?>
									        <a href="?m=Salesman&c=merchant&a=regist&mid=<?php echo $_GET['mid']; ?>" class="ewm"><i class="fa fa-clipboard"></i>点击开通</a>
									       
									   <?php }?>
					                            </div>
					                        </div>
					                      </form>
					                      <form style="margin-top: 20px;">
					                        <div class="zfb">
					                          <h2>支付宝收单</h2>
					                            
					                            <div>
					                              <label>支付宝收单:</label><a href="#" class="ewm"><i class="fa fa-clipboard"></i>点击开通</a>
					                            </div>
					                        </div>
					             </div>


						</div>
					</div>
						
				
								
						
					</div>
				</div>
			</div>
		</div>
	

	</body>
	<script>
$(".title>ul>li").click(function(){
	var index = $(this).index();
	$(this).addClass("cnt");
	$(this).next().removeClass("cnt");
	$(this).prev().removeClass("cnt");
	$(".zh_nr>div").eq(index).show();
	$(".zh_nr>div").eq(index).prev().hide();
	$(".zh_nr>div").eq(index).next().hide();
})
	


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
	<script src="<?php echo $this -> RlStaticResource; ?>plugins/js/iCheck/icheck.min.js"></script>
</html>