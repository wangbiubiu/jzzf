<!DOCTYPE html>
<html>
<head>
    <title>收银台 | 在线收银</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<style>
	#popPay .modal-footer{padding: 15px 0 0;
    text-align: center;}
	#popPay .modal-dialog{width: 530px;}
	#popPay .spiner-example{height: 170px;}
	#popPay .okk{height: 170px;color: #0ab85c;font-size: 45px;text-align: center;}
	#popPay .modal-footer button{font-size: 22px;}
	.inmodal .modal-header{padding: 30px 15px 15px 15px;}
	</style>
</head>
<body>
    <div id="wrapper">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>在线收款</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>Cashier</a>
                        </li>
                        <li class="active">
                            <strong>payment</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
       	 	<div class="wrapper wrapper-content animated fadeIn">
            	<div class="row">
                	<div class="col-lg-6">
                	    <div class="tabs-container weixin">
                	        <ul class="nav nav-tabs">
                	            <li class="active"><a data-toggle="tab" href="#tab-1">扫码收款</a></li>
                	            <li class=""><a data-toggle="tab" href="#tab-2">扫码退款</a></li>
                	        </ul>
                	        <div class="tab-content">
                	            <div id="tab-1" class="tab-pane active">
                	                <div class="panel-body">
                	                    <div class="row">
                            				<div class="col-sm-12 micropay"></div>
                        				</div>
                	                </div>
                	            </div>
                	            <div id="tab-2" class="tab-pane">
                	                <div class="panel-body">
                	                    <div class="row">
                            				<div class="col-sm-12 micropayRefund"></div>
                        				</div>
                	                </div>
                	            </div>
                	        </div>
                	    </div>
                	</div>
            	</div>
        	</div>
			<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
    </div>
	
	<div class="modal inmodal" tabindex="-1" role="dialog"  id="popPay">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
					<h6 class="modal-title">请耐心等待用户支付完成....</h6>
					<span>请耐心等待支付完成，不要点取消！</span>
				</div>
				<div class="modal-body">
					<div class="spiner-example" style="padding-top: 30px;">
					    <span style="display:none;">支付完成！</span>
						<div class="sk-spinner sk-spinner-circle" style="height: 100px;width: 100px;">
							<div class="sk-circle1 sk-circle"></div>
							<div class="sk-circle2 sk-circle"></div>
							<div class="sk-circle3 sk-circle"></div>
							<div class="sk-circle4 sk-circle"></div>
							<div class="sk-circle5 sk-circle"></div>
							<div class="sk-circle6 sk-circle"></div>
							<div class="sk-circle7 sk-circle"></div>
							<div class="sk-circle8 sk-circle"></div>
							<div class="sk-circle9 sk-circle"></div>
							<div class="sk-circle10 sk-circle"></div>
							<div class="sk-circle11 sk-circle"></div>
							<div class="sk-circle12 sk-circle"></div>
						</div>
					</div>
					<div class="modal-footer">
                    <button type="button" class="btn btn-white" onclick="$('#popPay').hide();$('.modal-backdrop').remove();"> 取 消 </button>
                </div>
				</div>
			</div>
		</div>
	</div>

	<script>
	wx.config({
	debug: false,
	appId: '<?php echo $signdata["appId"]; ?>',
	timestamp: '<?php echo $signdata["timestamp"]; ?>',
	nonceStr: '<?php echo $signdata["nonceStr"]; ?>',
	signature: '<?php echo $signdata["signature"]; ?>',
	jsApiList: [
		'checkJsApi',
		'onMenuShareTimeline',
		'onMenuShareAppMessage',
		'onMenuShareQQ',
		'onMenuShareWeibo',
		'scanQRCode',
		'chooseImage',
		'previewImage',
		'uploadImage',
		'downloadImage',
		'getLocation',
		'openLocation',
		'getNetworkType'
	]
});
	var screenW = $(window).width();
	if(screenW<550){
		screenW = screenW - 20;
		$('#popPay .modal-dialog').width(screenW);
	}
	var Ttype=<?php echo $type;?>;
	 if(Ttype==2){
		$('.nav-tabs li').removeClass('active');
	    $('.nav-tabs li:last').addClass('active');
		$('#tab-1').removeClass('active');
		$('#tab-2').addClass('active');
	 }
		!function(a,b,wx){
			function is_mobile(){
				var ua = navigator.userAgent.toLowerCase();
				if ((ua.match(/(iphone|ipod|android|ios|ipad)/i))){
					if(navigator.platform.indexOf("Win") == 0 || navigator.platform.indexOf("Mac") == 0){
						return false;
					}else{
						return true;
					}
				}else{
					return false;
				}
			}
			function is_weixin(){
			    var ua = navigator.userAgent.toLowerCase();
			    if(is_mobile() && ua.indexOf('micromessenger') != -1){  
			        return true;
			    } else {  
			        return false;  
			    }
			}
			var c = c || {};
			c.gosub=false;
			c.config = {
				data : ['weixin_micropay','weixin_micropayRefund']
			}
			c.init = function(){
				c.tpl();
			}
			
			c.loadJs = function(d){
				var oHead = document.getElementsByTagName('head').item(0),
   					oScript= document.createElement("script");   
   				oScript.type = "text/javascript";   
				oScript.src = d;   
  				oHead.appendChild( oScript);  
			}
			c.tmpl = function(d){
				var e = {
					weixin : {
						micropay : '<h3 class="m-t-none m-b">收款</h3><p>只适用微信扫码支付</p><p>扫码支付确认信息.</p><form role="form" action="?m=User&c=cashier&a=pay" id="micropay"><div class="form-group"><label>收款备注</label> <input type="text" placeholder="收款备注" name="goods_name"  id="goods_name" class="form-control"></div><div class="form-group"><label>支付金额</label> <input type="text" placeholder="支付金额(至少0.01元)" name="goods_price" id="goods_price" class="form-control"></div><div><button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>扫码收款</strong></button></div></form>',
						micropayRefund : '<h3 class="m-t-none m-b">退款</h3><p>只适用微信扫码支付退款</p><p>扫微信扫码支付交易详情页的条形码来退款.</p><form role="form" action="?m=User&c=cashier&a=wxSmRefund" id="wxSmRefund"><div><button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>扫码退款</strong></button></div></form>',
					}
				}
				var f;
				$.each(d,function(g,h){
					f = e = e[h];
				});
				return f;
			}
			c.tpl = function(){
				$.each(this.config.data,function(d,e){
					c.create(e.split('_'));
				});
			}
			c.submit = function(d){
				var tmpStr='';
				var formType=$.trim(d.attr('id'));
				if(formType=='micropay'){
					tmpStr=$.trim($('#goods_price').val());
					tmpStr=parseFloat(tmpStr);
					if(!(tmpStr>=0.01)){
					   swal("温馨提示",'支付金额必须填写一个大于0.01的数', "error");
					   $('#goods_price').focus();
					   return false;
					}
				}
				tmpStr=d.find('.auth_code').val();
				tmpStr=$.trim(tmpStr);
				if(!tmpStr){
				   swal("温馨提示",'支付auth_code为空,请填写或扫码获取', "error");
				   d.find('.auth_code').focus();
				   return false;
				}
				 if(formType=='micropay'){
					  $('#popPay .modal-header').html('<h6 class="modal-title">请耐心等待用户支付完成....</h6><span>请耐心等待支付完成，不要点取消！</span>');
					}else if(formType=='wxSmRefund'){
					   $('#popPay .modal-header').html('<h6 class="modal-title">请稍等，正在为您退款...</h6><span></span>');
					}
					
					$('#popPay .spiner-example').removeClass('okk');
				    $('#popPay .spiner-example span').hide();
					$('body').append('<div class="modal-backdrop in"></div>');
				    $('#popPay .spiner-example .sk-spinner-circle').show();
					$('#popPay').show();
    			    var e = d.serialize();
					c.gosub=true;
					b.post(d.attr('action'),e, function(data){
						c.gosub=false;
						if(data.error == 0){
							c.tpl();
							if(formType!='micropay'){
								$('#popPay').hide();
								$('.modal-backdrop').remove();
							  swal("成功!", data.msg, "success");
							}else{
							$('#popPay .spiner-example .sk-spinner-circle').hide();
							$('#popPay .spiner-example').addClass('okk');
							$('#popPay .spiner-example span').show();
							
								setTimeout(function(){
								  $('#popPay').hide();
								  $('.modal-backdrop').remove();
								  $('#popPay .spiner-example').removeClass('okk');
								  $('#popPay .spiner-example span').hide();
								  $('#popPay .spiner-example .sk-spinner-circle').show();
								},1000);
							}
						}else if(data.error == 3){
							 $('.modal-backdrop').remove();
							 $('#popPay').hide();
						    swal("温馨提示", '等待用户输入支付密码', "error");
						}else{
							 $('.modal-backdrop').remove();
							 $('#popPay').hide();
							swal("失败!", data.msg, "error");
						}
					},'JSON');
    			
			}
			c.create = function(s){
				function d(e){
					if(is_weixin()){
						wx.scanQRCode({
							needResult:1,
							scanType:["qrCode","barCode"],
							success:function (res){
								var result = res.resultStr;
								
								if(result.indexOf(',')>0){
									var result = result.split(',');
									result = result[1];
								}
								
								if(result && /^\d+$/g.test(result)){
				 					e.prepend('<input type="hidden" name="auth_code" class="auth_code" value="'+result+'">');
				  					c.submit(e);
				    				return false;
								}else{
									swal("错误!", "不是有效的码，非法输入！", "error");
								}	
							}
						});
					}else{
						swal("错误!", "您使用的不是微信浏览器，此功能无法使用！", "error");
					}
				}
				var e = this.tmpl(s),
					f,
					i = b('body');
				$.each(s,function(g,h){
					f = i = i.find('.'+h);
				});
				f.html(e);
	
				if(is_weixin()){
					f.find('form').find('button[type="submit"]').click(function(){
						if(c.gosub) return false;
						d(f.find('form'));
						return false;
					});
				}else{
					if(f.find('form').find('.form-group').size()){
						f.find('form').find('.form-group').last().after('<div class="form-group"><label>刷卡授权码</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>请连接扫码枪扫码</span><input type="text" placeholder="微信刷卡支付授权码(请连接扫码枪扫码)" name="auth_code" class="form-control auth_code"></div>');
					}else{
						f.find('form').prepend('<div class="form-group"><label>订单号</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>请连接扫码枪扫码</span> <input type="text" placeholder="需要退款的订单号(请连接扫码枪扫码)" name="auth_code" class="form-control auth_code"></div>');
					}
					f.find('form').find('button[type="submit"]').click(function(){
						 if(c.gosub) return false;
						c.submit(f.find('form'));
						return false;
					});
				}
			}
			b(document).ready(function(){
				c.init();
			});
		}(window,jQuery,wx||{});

	</script>
</body>
</html>