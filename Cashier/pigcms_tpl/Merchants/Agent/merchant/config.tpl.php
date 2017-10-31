<!DOCTYPE html>
<html>
	<head>
		<title>代理商|商户配置</title>
		<?php
			include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/header.tpl.php';
		?>
		<link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>wxCoupon/wxCoupon.css" rel="stylesheet">
		<link href="<?php echo $this -> RlStaticResource; ?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
		<link href="<?php echo $this -> RlStaticResource; ?>plugins/css/iCheck/custom.css" rel="stylesheet">
		 <script src="<?php echo $this->RlStaticResource;?>plugins/js/dropzone/dropzone.js"></script>
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
.weixin>h2,.zfb>h2{  margin-top: 0px; padding:0 20px; font-size: 14px; background: #f2f2f2; height: 35px; line-height: 35px; margin-bottom: 0px;}
.weixin>h2>span,.zfb>h2>span{ color: red;}
.weixin>h2>a,.zfb>h2>a{ float: right; color: #44b549;}
.weixin>div{ min-height: 60px; border-top:1px solid #f2f2f2;line-height: 60px; }
.weixin>div>label{width: 150px; text-align: right; margin-right: 10px; display: block;float: left;}
.weixin>div>input{ height: 25px;float: left; margin-top: 18px; margin-right: 10px;}
.weixin>div>div>p{min-height: 60px; }
.weixin>div>div>p>label{ width: 150px; text-align: right; margin-right: 10px;}
.weixin>div>div>p>input{ height: 25px; margin: 0 10px; width: 200px;}
.weixin>div>div>p>button{margin: 0 10px; width: 70px; height: 25px; line-height: 25px; text-align: center;border: none; border-radius: 5px; background: #36a9e0;}
.weixin>div>div>p>button{color: #FFFFFF;}
.weixin>div>div>p>button div{display: none;}
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

.title{ height: 40px; font-size: 14px; line-height: 40px;  text-align: center; margin: 0 -15px;}
.title>ul>li{float: left;width: 150px;}
.cent{ background: #ffffff; border-radius: 3px; border:1px solid #E4E4E4; border-bottom: none; cursor: pointer;}

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
									Agent
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
								<strong>参数配置</strong>
							</li>
						</ol>
					</div>
					<div class="col-lg-2"></div>
				</div>
				
				<div class="wrapper wrapper-content animated fadeInRight">
						<div class="title clearfix">
								<ul>
									<li <?php if($getdata['type']==1){echo "class=\"cent\"";} ?>>微信支付配置</li>
									<li <?php if($getdata['type']==2){echo "class=\"cent\"";} ?>>支付宝支付配置</li>
								</ul>
						</div>
					<div class="row payment_allocation">
						<div class="configure">
							<form action="" method="post"  onsubmit="return checkInput();">
							<input type="hidden" name="weixin[mid]" value="<?php if (isset($getdata['mid'])){echo $getdata['mid'];}else{echo $payConfig['mid'];} ?>" >
						
							<div class="weixin">
							
								<h2>微信支付配置
								    <?php if($state1['status'] != '2'){?>
								        <span>（收款通道暂未通过审核，审核通过方可保存）</span>
								    <?php }else{?>
								        <span style="color: green;">（审核通过）</span><input type='button' id='weixinpay' value="保存" style="float: right; height: 30px; background: none; color:green; line-height: 30px; border:none;">
								        
								    <?php }?>
								    
								    
								 </h2>
								<!-- <div class="clearfix">
									<label>是否认领商户：</label><input type="checkbox" />注：该商户为认领商户，由所属通方提供分润
								</div> -->
								<div class="clearfix">
                                    <?php if($mtype == 2){ ?>
                                        <li style="list-style: none;margin-left: 20px;"><label>微支付商户号：&nbsp;&nbsp;&nbsp;</label><input name='weixin[mchid]' class="shh" type="text" placeholder="请输入商户号" value='<?php echo $payConfig['configData']['weixin']['mchid'];?>'  onkeyup="this.value=this.value.replace(/\D/g,'')" style="line-height: 20px;"/><span class="ts" style="color: red;display: none;" >请填写商户号</span></li>
                                        <li style="list-style: none;margin-left: 20px;"><label>微支付商户简称：</label><input name='weixin[nickname]' class="shh" type="text" placeholder="请输入商户简称" value='<?php echo rawurldecode($payConfig['configData']['weixin']['nickname']);?>' style="line-height: 20px;"/><span class="ts" style="color: red;display: none;" >请填写商户简称</span></li>
                                    <?php }else{?>
                                        <label>微支付商户号</label><input name='weixin[mchid]' class="shh" type="text" placeholder="请输入商户号" value='<?php echo $payConfig['configData']['weixin']['mchid'];?>'  onkeyup="this.value=this.value.replace(/\D/g,'')" style="line-height: 20px;"/><span class="ts" style="color: red;display: none;" >请填写商户号</span>
                                    <?php } ?>
                                </div>


								<div>
									<label></label><input type="checkbox" id="gaoji"  value="on" />高级选项
									<div class="gaoji_nr" style="display: none;">
										
										<p>
											<label>appID</label>
											<input class="appid" type="text" value='<?php echo $payConfig['configData']['weixin']["appid"];?>' name='weixin[appid]' placeholder="请输入微信公众号" onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\@\.]/g,'')" style="line-height: 20px;"/>
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>
										<p>
											<label>AppSecret</label>
											<input class="appSecret" type="text" name='weixin[appSecret]' value='<?php echo $payConfig['configData']['weixin']["appSecret"];?>' placeholder="请输入微信公众号密匙" onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\@\.]/g,'')" style="line-height: 20px;" />
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>
										<p>
											<label>API密钥</label>
											<input class="partnerKey" type="text" name="weixin[partnerKey]"  value='<?php echo $payConfig['configData']['weixin']["partnerKey"];?>' placeholder="请输入微信支付商户号初始密匙" onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\@\.]/g,'')" style="line-height: 20px;" />
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>

										<p>
											<label>apiclient_cert私钥文件</label>
											<input class="apiclient_cert" readonly type="text"  value='<?php if (!empty($payConfig['configData']['weixin']['apiclient_cert'])){echo "证件已存在";} ?>' placeholder="请输入微信支付商户证书" />
											<input class='hiddeninput' type="hidden" name="weixin[apiclient_cert]" value="<?php echo $payConfig['configData']['weixin']["apiclient_cert"];?>">
											<button class='dropz' type='button'>浏览</button>
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>

										<p>
											<label>apiclient_key公钥文件</label>
											<input class="apiclient_key" readonly value='<?php if (!empty($payConfig['configData']['weixin']['apiclient_key'])){echo "证件已存在";} ?>' type="text"   placeholder="请输入微信支付商户证书密匙安全"/>
											<input class='hiddeninput' type="hidden" name="weixin[apiclient_key]" value="<?php echo $payConfig['configData']['weixin']["apiclient_key"];?>">
											<button class='dropz' type='button'>浏览</button>
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>
										<p>
											<label>CA证书文件</label>
											<input class="apiclient_key" readonly value='<?php if (!empty($payConfig['configData']['weixin']['rootca'])){echo "证件已存在";} ?>' type="text"  placeholder="请输入微信支付商户证书密匙安全"/>
											<input class='hiddeninput' type="hidden" name="weixin[rootca]" value="<?php echo $payConfig['configData']['weixin']["rootca"];?>">
											<button class='dropz' type='button'>浏览</button>
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>
									</div>
								</div>
							</div>
						</form>
						


                        		<form style="display: none;"  action=""  method="post" >
                        		<input type="hidden" name="alipay[mid]" value="<?php if (isset($getdata['mid'])){echo $getdata['mid'];}else{echo $payConfig['mid'];} ?>" >

							<div class="zfb clearfix" style="height:170px;">
								<h2>支付宝2.0收款参数配置
                                    <?php if($state2['status'] != '2'){?>
                                        <span>（收款通道暂未通过审核，审核通过方可保存）</span>
                                    <?php }else{?>
                                        <span style="color: green;">（审核通过）</span>
                                        <input type='button' value="保存"  id='alipay' style="float: right; height: 30px; background: none; color:green;line-height: 30px; border:none;">

                                    <?php }?>


                                </h2>
								<!-- 	<div>
										<label>是否认领商户:</label><input type="checkbox"  style="margin-top: 18px; width: 13px; height: 13px;" name="regdit" />注：该商户为非认领商户，官方没有给分润
									</div> -->
								<!-- 	<div>
										<label>口碑授权:</label><span>未授权</span><i class="fa fa-qrcode"></i><a href="#" class="ewm">点击扫码授权</a>
									</div> -->
									<div>
										<?php if($mtype == 2){ ?>
                                        <li style="list-style: none;margin-left: 20px;"><label>appID：&nbsp;&nbsp;&nbsp;&nbsp;</label><input class="zfbsh" type="text" name='alipay[appID]' placeholder="请输入支付宝商户号" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $payConfig['configData']['alipay']['appID']; ?>" style="line-height: 20px;"/></li>
                                        <li style="list-style: none;margin-left: 20px;"><label>商户简称：</label><input class="zfbsh" type="text" name='alipay[appNickname]' placeholder="请输入支付宝商户简称" onkeyup="" value="<?php echo rawurldecode($payConfig['configData']['alipay']['appNickname']); ?>" style="line-height: 20px;"/></li>
									    <?php }else{ ?>
                                            <label>授权token:</label>
                                            <input class="zfbsh" type="text" name='alipay[appauthtoken]' placeholder="请输入商户授权token"  value="<?php echo $payConfig['configData']['alipay']['appauthtoken']; ?>" style="line-height: 20px;width: 400px;"/>
                                        <?php } ?>
                                    </div>
							</div>
							<div class='ewm_nr' style="border: 1px solid #EEEEEE;"><img src=""></div>	
						</form>
						
					</div>

					</div>
				</div>
			</div>
		</div>
	

	</body>
<script>


$('#weixinpay').click(function(){

	var payConfigData = $(this).parents('form').serialize();

	$.post('?m=Agent&c=merchant&a=config',{data:htmlToArray(payConfigData)},function(result){
		if(result.status == 1){
			swal({
				title: "成功",
				text: result.msg,
				type: "success"
			}, function () {
				window.location.reload();
				});
		}else{
			swal("失败", result.msg , "error");
		}
	},'json');
});


$('#alipay').click(function(){

	var payConfigData = $(this).parents('form').serialize();

	$.post('?m=Agent&c=merchant&a=config',{data:htmlToArray(payConfigData)},function(result){
		if(result.status == 1){
			swal({
				title: "成功",
				text: result.msg,
				type: "success"
			}, function () {
				window.location.reload();
				});
		}else{
			swal("失败", result.msg , "error");
		}
	},'json');
});




	$(".dropz").dropzone({
		url: "?m=Agent&c=merchant&a=pem_upload",
		addRemoveLinks: false,
		maxFilesize: 1,
		acceptedFiles: ".pem",
		uploadMultiple: false,
		init: function() {
			this.on("success", function(file,responseText) {
				var rept = $.parseJSON(responseText);
				/***这里的this.element 是 $(".dropz")****/
				$(this.element).siblings('input').val('证书已上传成功');
				$(this.element).siblings('input').attr('readonly','readonly');
				$(this.element).siblings('.hiddeninput').val(rept.fileUrl);
			});
		}
	});


function htmlToArray(data){
	data = data.split('&');
	var info = {};
	$.each(data,function(k,v){
		v = v.replace('%5D','').split('=');
		var s = v[0].split('%5B');
		typeof(info[s[0]]) == 'undefined' && (info[s[0]] = {}),info[s[0]][s[1]] = v[1];
	});
	return info;
}
	function checkInput () {

		var mchid = $('input[name="mchid"]').val() ;

		if(mchid.length!=10) {
			swal('商户ID不能为空 或者 商户ID无效','请输入10位有效商户号','error');
		}

		var gradeSet = $('#gaoji');

		if (gradeSet[0].checked) {

			var appid = $('input[name="appid"]').val();
			if(appid.length == 0 || appid.length>50) {
				swal('公众号为空 或者 公众号无效','请输入有效公众号','error');
				return false;
			}

			var appSecret = $('input[name="appSecret"]').val();
			if (!appSecret) {
				swal('微信公众号密匙不能为空','请输入有效公众号密匙','error');
				return false;
			}

			var partnerKey = $('input[name="partnerKey"]').val();
			if (!partnerKey) {
				swal('请填写微信支付商户号','初始密匙不能为空','error');
				return false;
			}
			var apiclient_cert = $('input[name="apiclient_cert"]').val();
			if (!apiclient_cert) {
				swal('请上传证书','微信支付证书','error');
				return false;
			}

			var apiclient_key = $('input[name="apiclient_key"]').val();
			if (!apiclient_key) {
				swal('请上传证书','支付证书秘匙','error');
				return false;
			}	

			var rootca = $('input[name="rootca"]').val();
			if (!rootca) {
				swal('请上传ca证书','rootca证书','error');
				return false;
			}	
	
		}
	return false;	
	}


</script>

	<script>
	$(".title>ul>li").click(function(){
		var num = $(this).index();
		$(this).addClass("cent");
		$(this).next().removeClass("cent");
		$(this).prev().removeClass("cent");
		$(".configure>form").eq(num).show();
		$(".configure>form").eq(num).prev().hide();
		$(".configure>form").eq(num).next().hide();
	})
	window.onload=function(){
		var num = $(".cent").index();
		$(".configure>form").eq(num).show();
		$(".configure>form").eq(num).prev().hide();
		$(".configure>form").eq(num).next().hide();
	}
	
	
	$("#gaoji").click(function(){
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
	</script>
	<!-- iCheck -->
	<script src="<?php echo $this -> RlStaticResource; ?>plugins/js/iCheck/icheck.min.js"></script>
</html>