<!DOCTYPE html>
<html>
	<head>
		<title>商户配置</title>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
		<link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>wxCoupon/wxCoupon.css" rel="stylesheet">
		<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
		<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
		<link href="<?php echo RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
                <script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
                <script src="<?php echo $this->RlStaticResource;?>plugins/js/dropzone/dropzone.js"></script>
                
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
.weixin>div>div>p>input{ height: 30px; margin: 0 10px; width: 250px;}
.dropz{color: #FFFFFF;display: inline-block; margin: 0 10px; width: 70px; height: 25px; line-height: 25px; text-align: center;border: none; border-radius: 5px; background: #36a9e0;}
.dropz:hover{color: #FFFFFF;}
.dropz div{display: none;}
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

.title{ height: 40px; font-size: 18px; line-height: 40px;  text-align: center; margin: 0 -15px;}
.title>ul>li{float: left;width: 150px;}
.cent{ background: #ffffff; border-radius: 3px; border:1px solid #E4E4E4; border-bottom: none; cursor: pointer;}

.form-control{display: inline-block;}
</style>
		<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all2.min.js"></script>
	</head>

	<body>
		<div id="wrapper">
		<?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/setupleftmenu.tpl.php'; ?>
			
			<div id="page-wrapper" class="gray-bg">
				<?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/top.tpl.php'; ?>
				
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
									支付配置
								</a>
							</li>
							
						</ol>
					</div>
					<div class="col-lg-2"></div>
				</div>
				
				<div class="wrapper wrapper-content animated fadeInRight">
						<div class="title clearfix">
								<ul>
									<li class='cent' >微信支付配置</li>
									<li>支付宝支付配置</li>
								</ul>
						</div>
					<div class="row payment_allocation">
						<div class="configure">
                          <form id="wxform" action="" method="post" enctype="multipart/form-data" data-mode='weixin'>
							<div class="weixin">
                                <h2>微信支付配置
								    <?php if($regist['status'] != '2'){?>
								        <span>（收款通道暂未通过审核，审核通过方可保存）</span>
								    <?php }else{?>
								        <span style="color: green;">（审核通过）</span><input type='button' id='weixinpay' class="btn-confirm" value="保存" style="float: right; height: 30px; background: none; color:green; line-height: 30px; border:none;">
								        
								    <?php }?>
								    
								    
								 </h2>
								<div class="clearfix">
                                     <label>mchID</label><input class="shh" type="text" name="weixin[mchid]" value="<?php echo $payConfig['configData']['weixin']['mchid'];?>" placeholder="请输入商户号" style="line-height: 24px;" /><span class="ts" style="color: red;display: none;">请填写商户号</span>
								</div>
								<!--
                                	作者：2721190987@qq.com
                                	时间：2016-10-25
                                	描述：高级选项
                                -->
								<div>
                                                                    <label></label><input type="checkbox" value="1" id="gaoji">高级选项
									<div class="gaoji_nr" style="display: none;">
										
										<p>
											<label>appID</label>
                                            <input class="appid" type="text" name='weixin[appid]' value="<?php echo $payConfig['configData']['weixin']['appid'];?>" placeholder="请输入微信公众号"  style="line-height: 24px;"/>
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>
										<p>
											<label>appSecret</label>
                                            <input class="appSecret" type="text" name='weixin[appSecret]' value="<?php echo $payConfig['configData']['weixin']['appSecret'];?>" placeholder="请输入微信公众号密匙"  style="line-height: 24px;"/>
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>
										<p>
											<label>partnerKey</label>
                                            <input class="partnerKey" type="text" name="weixin[key]" value="<?php echo $payConfig['configData']['weixin']['key'];?>" placeholder="请输入微信支付商户号初始密匙" style="line-height: 24px;"/>
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>
										<p>
											<label>apiclient-cert.pem</label>
                                                                                        <input class="apiclient_cert form-control" <?php if($payConfig['configData']['weixin']['apiclient_cert']){?> value="pem文件已上传" readonly="readonly"<?php }?> type="text" placeholder="请输入微信支付商户证书"/>
											<input type="hidden" name="weixin[apiclient_cert]" placeholder="apiclient_cert私钥文件" value="<?php echo $payConfig['configData']['weixin']['apiclient_cert'];?>"  class="hiddeninput">
                                                                                        <a class="dropz">浏览</a>
											<i class="wh fa fa-question-circle"></i>
											<i class="du fa  fa-check-circle"></i>
										</p>
										<p>
											<label>apiclient-key.pem</label>
                                                                                        <input class="apiclient_key form-control"  <?php if($payConfig['configData']['weixin']['apiclient_key']){?> value="pem文件已上传" readonly="readonly" <?php }?> type="text" placeholder="请输入微信支付商户证书密匙安全"/>
											<input type="hidden" name='weixin[apiclient_key]' placeholder="微信支付rootca文件" value="<?php echo $payConfig['configData']['weixin']['apiclient_key'];?>"  class="hiddeninput">
                                                                                        <a class="dropz">浏览</a>
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
                        <form style="display: none;" action="" name='ali' method="post" data-mode='alipay'>
							<div class="zfb clearfix">
                                                            <h2>支付宝2.0收款参数配置<span>（收款通道暂未通过审核，审核通过方可保存）</span><input type="button" class="btn-confirm" value="保存" name="" style="float: right; height: 30px; background: none; color:green;line-height: 30px; border:none;"></h2>
									
									<div>
										<label>口碑授权:</label><span>未授权</span><i class="fa fa-qrcode"></i><a href="#" class="ewm">点击扫码授权</a>
									</div>
									<div>
                                                                            <label>appID:</label><input class="zfbsh" type="text" value="<?php echo $payConfig['configData']['alipay']['appid'];?>" name='alipay[appid]' placeholder="请输入支付宝商户号" onkeyup="this.value=this.value.replace(/\D/g,'')"/>
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
			</div>
		</div>
	

	</body>
        <script>
        $(document).ready(function(){
            $('.btn-confirm').click(function(){
                if($(this).parents('form').attr('data-mode')=='weixin'){
                 if($("#gaoji").is(":checked")){
                    if($(".shh").val()==""){
                            swal("微信商户号不能为空","", "error");
                            return false;
                    }else if($(".shh").val().length!=10){
                            swal("商户号长度为10位","", "error");
                            return false;
                    }else if($(".appid").val()==""){
                            swal("微信公众号不能为空","", "error");
                            return false;
                    }else if($(".appid").val().length!=18){
                            swal("微信公众号appid为18位","", "error");
                         return false;
                    }else if($(".appSecret").val()==""){
                            swal("微信公众号密匙不能为空","", "error");  
                            return false;
                    }else if($(".appSecret").val().length!=32){
                            swal("微信公众号密匙appSecret为32位","", "error");
                            return false;
                    }else if($(".partnerKey").val()==""){
                            swal("微信支付商户号初始密匙不能为空","", "error");
                            return false;
                    }
                }else{
                     if($(".shh").val()==""){
                           swal("微信商户号不能为空","", "error");
                            return false;
                    }else if($(".shh").val().length!=10){
                             swal("商户号长度为10位","", "error");                  
                            return false;
                    }
                }
                }else{
                    if($('.zfbsh').val() == ""){
                        swal("支付宝商户号不能为空","", "error");
                       // alert("支付宝商户号不能为空");
                         return false;
                    }
                    
                }
                
                
                var payConfigData = $(this).parents('form').serialize();
               
                $.post('?m=User&c=pay&a=payconfig',{data:htmlToArray(payConfigData)},function(result){
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
                    url: "?m=User&c=pay&a=pem_upload",
                    addRemoveLinks: false,
                    maxFilesize: 1,
                    acceptedFiles: ".pem",
                    uploadMultiple: false,
                    init: function() {
                            this.on("success", function(file,responseText) {
                                    var rept = $.parseJSON(responseText);
                                    /***这里的this.element 是 $(".dropz")****/
                                    $(this.element).siblings('.form-control').val('pem文件已上传');
                                    $(this.element).siblings('.form-control').attr('readonly','readonly');
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
        });          
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
          var index = $(".cent").index();
          $(".configure>form").eq(index).show();
		$(".configure>form").eq(index).prev().hide();
		$(".configure>form").eq(index).next().hide();
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
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
</html>