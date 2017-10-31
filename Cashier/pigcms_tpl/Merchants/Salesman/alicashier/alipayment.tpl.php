<!DOCTYPE html>
<html>
<head>
    <title>收银台 | 在线收银</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<script type = "text/javascript">
	function loadJs (src){
			var oHead = document.getElementsByTagName('head').item(0),
				oScript= document.createElement("script");   
			oScript.type = "text/javascript";   
			oScript.src = src;   
			oHead.appendChild(oScript);  
		}
	var isAlipayClient=false;
	if(navigator.userAgent.indexOf("AlipayClient")===-1){
	
	}else{
           loadJs('https://static.alipay.com/aliBridge/1.0.0/aliBridge.min.js');
		   isAlipayClient=true;
	}
	</script>
	<style>
	#alipopPay .modal-footer{padding: 15px 0 0;
    text-align: center;}
	#alipopPay .modal-dialog{width: 530px;}
	#alipopPay .spiner-example{height: 170px;}
	#alipopPay .okk{height: 170px;color: #0ab85c;font-size: 45px;text-align: center;}
	#alipopPay .modal-footer button{font-size: 22px;}
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
                    <h2>支付宝在线收款</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>alicashier</a>
                        </li>
                        <li class="active">
                            <strong>alipayment</strong>
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
                            				<div class="col-sm-12 alimicropay"></div>
                        				</div>
                	                </div>
                	            </div>
                	            <div id="tab-2" class="tab-pane">
                	                <div class="panel-body">
                	                    <div class="row">
                            				<div class="col-sm-12 alimicropayRefund"></div>
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
	
	<div class="modal inmodal" tabindex="-1" role="dialog"  id="alipopPay">
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
                    <button type="button" class="btn btn-white" onclick="$('#alipopPay').hide();$('.modal-backdrop').remove();"> 取 消 </button>
                </div>
				</div>
			</div>
		</div>
	</div>

	<script>
	var screenW = $(window).width();
	if(screenW<550){
		screenW = screenW - 20;
		$('#alipopPay .modal-dialog').width(screenW);
	}

	var Ttype=<?php echo $type;?>;
	var AliObj=typeof(Ali)!='undefined' ? Ali : {};
	 if(Ttype==2){
		$('.nav-tabs li').removeClass('active');
	    $('.nav-tabs li:last').addClass('active');
		$('#tab-1').removeClass('active');
		$('#tab-2').addClass('active');
	 }
		!function(a,b,Ali){
			var c = c || {};
			c.gosub=false;
			c.config = {
				data : ['weixin_alimicropay','weixin_alimicropayRefund']
			}
			c.init = function(){
				c.tpl();
			}
			c.tmpl = function(d){
				var e = {
					weixin : {
						alimicropay : '<h3 class="m-t-none m-b">收款</h3><p>只适用支付宝条码支付</p><p>条码支付确认信息.</p><form role="form" action="?m=User&c=alicashier&a=alipay" id="alimicropay"><div class="form-group"><label>商品描述</label> <input type="text" placeholder="商品名称" name="goods_name"  id="goods_name" class="form-control"></div><div class="form-group"><label>支付金额</label> <input type="text" placeholder="支付金额(至少0.01元)" name="goods_price" id="goods_price" class="form-control"></div><div><button type="submit" class="btn btn-sm btn-primary pull-right m-t-n-xs"><strong>扫码收款</strong></button></div></form>',
						alimicropayRefund : '<h3 class="m-t-none m-b">退款</h3><p>只适用支付宝条码支付退款</p><form role="form" action="?m=User&c=alicashier&a=aliSmRefund" id="alimicropayRefund"><div><button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>扫码退款</strong></button></div></form>',
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
				if(formType=='alimicropay'){
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
				
				 if(formType=='alimicropay'){
					  $('#alipopPay .modal-header').html('<h6 class="modal-title">请耐心等待用户支付完成....</h6><span>请耐心等待支付完成，不要点取消！</span>');
					}else if(formType=='alimicropayRefund'){
					   $('#alipopPay .modal-header').html('<h6 class="modal-title">请稍等，正在为您退款...</h6><span></span>');
					}
					$('#alipopPay .spiner-example').removeClass('okk');
				    $('#alipopPay .spiner-example span').hide();
					$('body').append('<div class="modal-backdrop in"></div>');
					$('#alipopPay .spiner-example .sk-spinner-circle').show();
					$('#alipopPay').show();
    			    var e = d.serialize();
					var subbtn=d.find('.btn-primary');
					subbtn.removeClass('btn-primary');
					subbtn.addClass('btn-default');
					c.gosub=true;
					b.post(d.attr('action'),e, function(data){
						subbtn.removeClass('btn-default');
						subbtn.addClass('btn-primary');
						c.gosub=false;
						if(data.error == 0){
							c.tpl();
							if(formType!='alimicropay'){
							  $('#alipopPay').hide();
							  $('.modal-backdrop').remove();
							  swal("成功!", data.msg, "success");
							}else{
							$('#alipopPay .spiner-example .sk-spinner-circle').hide();
							$('#alipopPay .spiner-example').addClass('okk');
							$('#alipopPay .spiner-example span').show();
								setTimeout(function(){
								  $('#alipopPay').hide();
								  $('.modal-backdrop').remove();
								  $('#alipopPay .spiner-example').removeClass('okk');
								  $('#alipopPay .spiner-example span').hide();
								  $('#alipopPay .spiner-example .sk-spinner-circle').show();
								},1000);
							}
						}else if(data.error == 3){
							 $('.modal-backdrop').remove();
							 $('#alipopPay').hide();
						    swal("温馨提示", '等待用户输入支付密码', "error");
						}else{
							 $('.modal-backdrop').remove();
							 $('#alipopPay').hide();
							swal("失败!", data.msg, "error");
						}
					},'JSON');
    			
			}
			c.create = function(s){
				var e = this.tmpl(s),
					f,
					i = b('body');
				$.each(s,function(g,h){
					f = i = i.find('.'+h);
				});
				f.html(e);
				if(isAlipayClient && (Ali.alipayVersion).slice(0,3)>=8.1){
					f.find('form').find('.btn-primary').click(function(){
					 if(c.gosub) return false;
						var __fthis=$(this);
						 __fthis=__fthis.parent().parent('form');
							Ali.scan({
								type: 'qr' //qr(二维码) / bar(条形码) / card(银行卡号)
							}, function(result) {
								if(result.errorCode){
									//没有扫码的情况
									//errorCode=10，用户取消
									//errorCode=11，操作失败
									return false;
								}else{
									//成功扫码的情况
									//result.barCode	string	扫描所得条码数据
									//result.qrCode	string	扫描所得二维码数据
									//result.cardNumber	string	扫描所得银行卡号
									var Codestring=typeof(result.qrCode)!='undefined' ? result.qrCode :'';
									Codestring=Codestring ? Codestring:(typeof(result.barCode)!='undefined' ? result.barCode :'');
									 __fthis.prepend('<input type="hidden" name="auth_code" class="auth_code" value="'+Codestring+'">');
									c.submit(__fthis);
									return false;
								}
							});

					});
				}else{
					if(f.find('form').find('.form-group').size()){
						f.find('form').find('.form-group').last().after('<div class="form-group authcode"><label>付款码</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>请连接扫码枪扫码<input type="text" placeholder="支付宝付款码(请连接扫码枪扫码)" name="auth_code" class="form-control auth_code"></div>');
					}else{
						f.find('form').prepend('<div class="form-group authcode"><label>订单号</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>请连接扫码枪扫码 <input type="text" placeholder="输入订单号(请连接扫码枪扫码)" name="auth_code" class="form-control auth_code"></div>');
					}
					f.find('form').find('.btn-primary').click(function(){
						 if(c.gosub) return false;
						  c.submit(f.find('form'));
						  return false;
					});
				}
			}

			b(document).ready(function(){
				c.init();
			});
		}(window,jQuery,AliObj);
	</script>
</body>
</html>