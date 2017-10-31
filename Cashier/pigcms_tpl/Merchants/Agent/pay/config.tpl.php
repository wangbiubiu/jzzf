
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>收银台 | 在线支付配置</title>
	 <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/basic.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
    <!-- iCheck -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
	<!-- DROPZONE -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/dropzone/dropzone.js"></script>
	<style>
		.ibox-title h5 {
  			margin: 10px 0 0px;
		}
		select.input-sm {
  			height: 35px;
  			line-height: 35px;
		}
		.float-e-margins .btn-info{
			margin-bottom:0px;
			padding:3px;
		}
		.fa-paste{
			margin-right:7px;
			padding: 0px;
		}
		.dz-preview{
			display:none;
		}
	</style>
</head>

<body>

    <div id="wrapper">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>在线支付配置</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>Pay</a>
                        </li>
                        <li class="active">
                            <strong>Config</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	<div class="col-lg-6">
            	    <div class="ibox float-e-margins">
            	        <div class="ibox-title clearfix">
            	            <h5 style="margin: 10px 0 0px;">支付配置</h5>
							<!--<div class="col-sm-2 m-b-xs">
								<select class="input-sm form-control input-s-sm inline switch">
                                    <option <?php if($payConfig['isOpen'] == 0){ echo 'selected="selected"'; }?> value="0">关闭</option>
                                    <option <?php if($payConfig['isOpen'] == 1){ echo 'selected="selected"'; }?> value="1">开启</option>
                             	</select>
                            </div>-->
            	        </div>
            	        <div class="ibox-content">
						<div class="alert alert-warning">
							温馨提示：1、如果平台代付被勾选上了，我们将启用平台管理总后台支付配置来代理你的支付配置，您可以无需配置任何微信相关配置即可使用本平台所有功能。<br/>
							2、平台代付情况下所产生的支付金额以及其他相关都会属于平台管理总后台商家，如有需要请联系平台管理总后台管理员磋商。<br/>
							3、如果使用独立配置支付或平台管理总后台特约商户配置支付，请务必不勾选平台代付。<br/>
							<strong style="color:green;">4、如果你勾选了支付宝或微信的平台代收款，请配置一下银行卡信息，以便平台线下对账汇款</strong><br/>
							<strong style="color:red;">5、特别提醒：一旦配置好，请勿再改换配置。如果改换了配置，那么在原来的配置上所付款将不能退款，所发的卡券不能核销等等</strong>
						 </div>
							<table class="table table-striped">
            	                <tr>
            	                    <!--<td style="padding-top:12px;"><input type="checkbox" <?php if($payConfig['configData']['weixin']['isOpen'] == 1){ echo 'checked="checked"'; }?> data-type='weixin' class="i-checks isOpen"></td>-->
            	                    <td><img style="margin-left: 15px" src="<?php echo $this->RlStaticResource;?>pay_icon/weixin.png"></td>
            	                    <td style="padding-top: 14px;">微信支付</td>
            	                    <td id="wxapiinfo1"><button class="btn btn-info " type="button" <?php if($payConfig['configData']['alipay']['isOpen'] == 1){ echo 'checked="checked"'; }?> data-toggle="modal" data-target="#weixinSetting"><i class="fa fa-paste"></i>配置信息</button></td>
									<td id="wxapiinfo2"></td>
									 <?php if($this->merchant['isadmin']!=1 && $iswxhave){?>
									  <td style="padding-top:12px;color:#44b549;font-weight: bold;"><input type="checkbox" <?php if($payConfig['pfpaymid'] > 0){ echo 'checked="checked"'; }?> class="i-checks" id="is_pfpay"> &nbsp;平台收款及制券</td>
									  <?php }else{?>
									   <td></td>
									   <?php }?>
            	                </tr>
								<tr>
            	                    <!--<td style="padding-top:12px;"><input type="checkbox" data-type='alipay' <?php if($payConfig['configData']['alipay']['isOpen'] == 1){ echo 'checked="checked"'; }?> class="i-checks isOpen"></td>-->
            	                    <td><img style="margin-left: 15px" src="<?php echo $this->RlStaticResource;?>pay_icon/alipay.png"></td>
            	                    <td style="padding-top: 14px;">支付宝支付</td>
            	                    <td><button class="btn btn-info " type="button"  data-toggle="modal" data-target="#alipaySetting"><i class="fa fa-paste"></i>配置信息</button></td>
									<td></td>
									<?php if($this->merchant['isadmin']!=1 && $isalihave){?>
									  <td style="padding-top:12px;color:#44b549;font-weight: bold;"><input type="checkbox" <?php if($payConfig['pfalipaymid'] > 0){ echo 'checked="checked"'; }?> class="i-checks" id="is_pfalipay"> &nbsp;平台代收款</td>
									<?php }else{?>
									   <td></td>
									   <?php }?>
            	                </tr>
								<tr>
								 <td><img style="margin-left: 15px;width: 45px;height: 40px;" src="<?php echo $this->RlStaticResource;?>pay_icon/yinhangka.png"></td>
            	                    <td style="padding-top: 14px;">汇款银行卡</td>
									 <td><button class="btn btn-info " type="button"  data-toggle="modal" data-target="#hkbankset"><i class="fa fa-paste"></i>配置信息</button></td>
									<td></td>
									<td></td>
								</tr>
            	            </table>
            	        </div>
            	    </div>
            	</div>
            </div>
        </div>
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
    </div>
	<div class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true" id="weixinSetting">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<form action="" method="post" enctype="multipart/form-data">
				<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">微信支付 支付配置</h4>
					<?php if($payConfig['proxymid']>0){?>
					<div class="alert alert-warning" style="margin:15px 0px 0px 0px;">您已经成为管理员的特约商家，请不要改动以下配置信息</div>
					<?php }?>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="new_wxpay_box" class="wxpay_box">
							
							<div class="form-group">
								<label>Appid</label>
								<?php if($payConfig['configData']['weixin']['appid']){?>
									<?php if($payConfig['proxymid']>0){ ?>
									 <input type="text" placeholder="微信Appid" value="<?php echo $payConfig['configData']['weixin']['appid']; ?>" name="weixin[appid]" class="form-control" readonly="readonly" >
									<?php }else{?>
									  <input type="text" placeholder="微信Appid" value="<?php echo $payConfig['configData']['weixin']['appidm']; ?>" class="form-control config1" readonly="readonly">
									  <input type="hidden" placeholder="微信Appid" value="<?php echo $payConfig['configData']['weixin']['appid']; ?>" name="weixin[appid]" class="form-control config2" >
									<?php } ?>

								<?php }else{?>
								 <input type="text" placeholder="微信Appid" value="" name="weixin[appid]" class="form-control">
								<?php } ?>
							</div>

							<div class="form-group">
								<label>AppSecret</label>
								<?php if($payConfig['configData']['weixin']['appSecret']){?>
									<?php if($payConfig['proxymid']>0){ ?>
									<input type="text" placeholder="应用密钥appSecret" value="<?php echo $payConfig['configData']['weixin']['appSecret']; ?>" name="weixin[appSecret]" class="form-control" readonly="readonly">
									<?php }else{?>
									<input type="text" placeholder="应用密钥appSecret" value="<?php echo $payConfig['configData']['weixin']['appSecretm']; ?>" class="form-control config1" readonly="readonly">
									<input type="hidden" placeholder="应用密钥" value="<?php echo $payConfig['configData']['weixin']['appSecret']; ?>" name="weixin[appSecret]" class="form-control config2">
									<?php } ?>
								<?php }else{?>
								   <input type="text" placeholder="应用密钥appSecret" value="" name="weixin[appSecret]" class="form-control">
								<?php } ?>
							</div>

							<div class="form-group">
								<label>微支付商户号</label>
							<?php if($payConfig['configData']['weixin']['mchid']){?>
							   <?php if($payConfig['proxymid']>0){ ?>
								<input type="text" placeholder="商户号" value="<?php echo $payConfig['configData']['weixin']['mchid']; ?>" name="weixin[mchid]" class="form-control" readonly="readonly">
								 <?php }else{?>
								 <input type="text" placeholder="商户号" value="<?php echo $payConfig['configData']['weixin']['mchidm']; ?>" class="form-control config1" readonly="readonly">
								 <input type="hidden" placeholder="商户号" value="<?php echo $payConfig['configData']['weixin']['mchid']; ?>" name="weixin[mchid]" class="form-control config2">
							     <?php } ?>
							<?php }else{?>
							   <input type="text" placeholder="商户号" value="" name="weixin[mchid]" class="form-control">
							<?php } ?>
							</div>
							<div class="form-group">
								<label>API密钥</label>
								<?php if($payConfig['configData']['weixin']['key']){?>
								  <?php if($payConfig['proxymid']>0){ ?>
								 <input type="text" placeholder="Api密钥" value="<?php echo $payConfig['configData']['weixin']['key']; ?>" name="weixin[key]" class="form-control" readonly="readonly">
								 <?php }else{?>
								 	<input type="text" placeholder="Api密钥" value="<?php echo $payConfig['configData']['weixin']['keym']; ?>"  class="form-control config1" readonly="readonly">
									<input type="hidden" placeholder="Api密钥" value="<?php echo $payConfig['configData']['weixin']['key']; ?>" name="weixin[key]" class="form-control config2">
								 <?php } ?>
							 <?php }else{?>
							   <input type="text" placeholder="Api密钥" value="" name="weixin[key]" class="form-control">
							<?php } ?>
							</div>
							<div class="form-group uploade">
								<label>apiclient_cert私钥文件</label>
								<input type="text" placeholder="apiclient_cert私钥文件" <?php if($payConfig['configData']['weixin']['apiclient_cert']){echo 'value="pem文件已上传" readonly="readonly"';}else{echo 'value=""';} ?> class="form-control" >
								<input type="hidden" placeholder="apiclient_cert私钥文件" value="<?php echo urldecode($payConfig['configData']['weixin']['apiclient_cert']); ?>" name="weixin[apiclient_cert]" class="hiddeninput">
								<div class="dropz" style="height: 34px;line-height: 34px;border: 1px solid #e5e6e7;width: 70px;text-align: center;position: relative;top: -34px;float: right;cursor: pointer;">文件上传</div>
							</div>
							<div class="form-group uploade">
								<label>apiclient_key公钥文件</label>
								<input type="text" placeholder="apiclient_key公钥文件" <?php if($payConfig['configData']['weixin']['apiclient_key']){echo 'value="pem文件已上传" readonly="readonly"';}else{echo 'value=""';} ?> class="form-control">
								<input type="hidden" placeholder="apiclient_key公钥文件" value="<?php echo urldecode($payConfig['configData']['weixin']['apiclient_key']); ?>" name="weixin[apiclient_key]" class="hiddeninput">
								<div class="dropz" style="height: 34px;line-height: 34px;border: 1px solid #e5e6e7;width: 70px;text-align: center;position: relative;top: -34px;float: right;cursor: pointer;">文件上传</div>
							</div>
								<div class="form-group uploade">
								<label>CA证书文件</label>
								<input type="text" placeholder="微信支付rootca文件" <?php if($payConfig['configData']['weixin']['rootca']){echo 'value="rootca.pem文件已上传" readonly="readonly"';}else{echo 'value=""';} ?> class="form-control">
								<input type="hidden" placeholder="微信支付rootca文件" value="<?php echo urldecode($payConfig['configData']['weixin']['rootca']); ?>" name="weixin[rootca]" class="hiddeninput">
								<div class="dropz" style="height: 34px;line-height: 34px;border: 1px solid #e5e6e7;width: 70px;text-align: center;position: relative;top: -34px;float: right;cursor: pointer;">文件上传</div>
							</div>

						</div>
					</div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary btn-confirm">确定</button>
                </div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal inmodal" tabindex="-1"  id="wxApi_Setting">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				
				<div class="modal-header">
                    <button type="button" class="close _close"><span>×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">微信服务器配置接口信息</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="wxActionBox" class="wxpay_box">
							<div class="form-group">
								<label>URL：</label>
								<input type="text" placeholder="服务器推送事件地址" value="<?php echo $this->SiteUrl?>/merchants.php?m=Index&c=wxAction&a=index&mymid=<?php echo $this->mid?>" class="form-control" readonly="readonly">
							</div>
							<div class="form-group">
								<label>Token：</label>
								<input type="text" placeholder="Token令牌" value="" class="form-control wxtoken" readonly="readonly">
							</div>
							<div class="form-group">
								<label>EncodingAESKey：</label>
								<input type="text" placeholder="消息加解密密钥" value="" class="form-control aeskey" readonly="readonly">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-primary _close">关闭</button>
                </div>
			</div>
		</div>
	</div>

	<div class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true" id="alipaySetting">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<form action="" method="post" enctype="multipart/form-data">
				<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    
                    <h4 class="modal-title">支付宝支付 支付配置</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="new_alipay_box" class="wxpay_box">
							
							<div class="form-group">
								<label>Appid</label>
								<?php if($payConfig['configData']['alipay']['appid']){?>
								<input type="text" placeholder="支付宝Appid(必填)" value="<?php echo $payConfig['configData']['alipay']['appidm']; ?>" class="form-control config1" readonly="readonly">
								<input type="hidden" placeholder="支付宝Appid(必填)" value="<?php echo $payConfig['configData']['alipay']['appid']; ?>" name="alipay[appid]" class="form-control config2">
								<?php }else{ ?>
								 <input type="text" placeholder="支付宝Appid(必填)" value="" name="alipay[appid]" class="form-control">
								<?php } ?>
							</div>
							<div class="form-group">
								<label>PID</label>
								<?php if($payConfig['configData']['alipay']['pid']){?>
								<input type="text" placeholder="合作者身份Partner id(必填)" value="<?php echo $payConfig['configData']['alipay']['pidm']; ?>" class="form-control config1" readonly="readonly">

								<input type="hidden" placeholder="合作者身份Partner id(必填)" value="<?php echo $payConfig['configData']['alipay']['pid']; ?>" name="alipay[pid]" class="form-control config2">
								<?php }else{ ?>
								<input type="text" placeholder="合作者身份Partner id(必填)" value="" name="alipay[pid]" class="form-control">
								<?php } ?>
							</div>
							<div class="form-group">
								<label>Key</label>
								<?php if($payConfig['configData']['alipay']['key']){?>
								 <input type="text" placeholder="Key(选填)" value="<?php echo $payConfig['configData']['alipay']['keym']; ?>" class="form-control config1" readonly="readonly">
								 <input type="hidden" placeholder="Key(选填)" value="<?php echo $payConfig['configData']['alipay']['key']; ?>" name="alipay[key]" class="form-control config2">
								<?php }else{ ?>
								<input type="text" placeholder="Key(选填)" value="" name="alipay[key]" class="form-control">
								<?php } ?>
							</div>
							<div class="form-group">
								<label>卖家账号</label>
								<?php if($payConfig['configData']['alipay']['name']){?>
								<input type="text" placeholder="卖家账号(选填)" value="<?php echo urldecode($payConfig['configData']['alipay']['namem']); ?>" class="form-control config1" readonly="readonly">
							    <input type="hidden" placeholder="卖家账号(选填)" value="<?php echo urldecode($payConfig['configData']['alipay']['name']); ?>" name="alipay[name]" class="form-control config2">
								<?php }else{ ?>
								<input type="text" placeholder="卖家账号(选填)" value="" name="alipay[name]" class="form-control">
								<?php } ?>
							</div>
							<div class="form-group">
							<label>公钥（服务窗）&nbsp;&nbsp;&nbsp;复制这个公钥到支付宝需要上传的地方</label>
							<input type="text" placeholder="公钥（服务窗）" value="<?php echo $rsapublickey; ?>" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary btn-confirm">确定</button>
                </div>
				</form>
			</div>
		</div>
	</div>


	<div class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true" id="hkbankset">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<form action="" method="post" enctype="multipart/form-data">
				<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    
                    <h4 class="modal-title">汇款银行卡 信息配置</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="new_bank_box" class="wxpay_box">
							
							<div class="form-group">
								<label>银行名称</label>
								<?php if($bankConfig['bankname']){?>
								<input type="text" placeholder="请填写银行名称" value="<?php echo $bankConfig['bankname']; ?>" class="form-control config1" readonly="readonly" id="mbankname">
								<input type="hidden" placeholder="请填写银行名称" value="<?php echo $bankConfig['bankname']; ?>" name="bankname" class="form-control config2">
								<?php }else{ ?>
								 <input type="text" placeholder="请填写银行名称" value="" name="bankname" class="form-control">
								<?php } ?>
							</div>
							<div class="form-group">
								<label>银行卡号</label>
								<?php if($bankConfig['bankcardnum']){?>
								<input type="text" placeholder="请填写银行卡号" value="<?php echo $bankConfig['bankcardnumm']; ?>" class="form-control config1" readonly="readonly">

								<input type="hidden" placeholder="请填写银行卡号" value="<?php echo $bankConfig['bankcardnum']; ?>" name="bankcardnum" class="form-control config2">
								<?php }else{ ?>
								<input type="text" placeholder="请填写银行卡号" value="" name="bankcardnum" class="form-control">
								<?php } ?>
							</div>
							<div class="form-group">
								<label>开卡人姓名</label>
								<?php if($bankConfig['banktruename']){?>
								 <input type="text" placeholder="填写银行卡开卡人姓名" value="<?php echo $bankConfig['banktruename']; ?>" class="form-control config1" readonly="readonly" id="mbanktruename">
								 <input type="hidden" placeholder="填写银行卡开卡人姓名" value="<?php echo $bankConfig['banktruename']; ?>" name="banktruename" class="form-control config2">
								<?php }else{ ?>
								<input type="text" placeholder="填写银行卡开卡人姓名" value="" name="banktruename" class="form-control">
								<?php } ?>
							</div>
							<div class="form-group">
								<label>开卡人手机号</label>
								<?php if($bankConfig['phone']){?>
								<input type="text" placeholder="填写银行卡开卡人手机号" value="<?php echo $bankConfig['phonem']; ?>" class="form-control config1" readonly="readonly">
							    <input type="hidden" placeholder="填写银行卡开卡人手机号" value="<?php echo $bankConfig['phone']; ?>" name="phone" class="form-control config2">
								<?php }else{ ?>
								<input type="text" placeholder="填写银行卡开卡人手机号" value="" name="phone" class="form-control">
								<?php } ?>
							</div>

							<div class="form-group">
								<label>开卡人身份证号</label>
								<?php if($bankConfig['identitycode']){?>
								<input type="text" placeholder="填写银行卡开卡人身份证号" value="<?php echo $bankConfig['identitycodem']; ?>" class="form-control config1" readonly="readonly">
							    <input type="hidden" placeholder="填写银行卡开卡人身份证号" value="<?php echo $bankConfig['identitycode']; ?>" name="identitycode" class="form-control config2">
								<?php }else{ ?>
								<input type="text" placeholder="填写银行卡开卡人身份证号" value="" name="identitycode" class="form-control">
								<?php } ?>
							</div>

						</div>
					</div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary btn-confirm-b">确定</button>
                </div>
				</form>
			</div>
		</div>
	</div>

	
    <script>
	 var apihtml="<button class='btn btn-info api' type='button' <?php if($payConfig['configData']['alipay']['isOpen'] == 1){ echo 'checked=\"checked\"'; }?> id=\"wxApiSetting\"> API接口 </button>";
	 <?php if(in_array($this->merchant['source'],array(1,2,3))){?>
		apihtml='';
	 <?php }?>
	 if(mobilecheck()){
	     $('#wxapiinfo1').append(apihtml);
		 $('#wxapiinfo1 .api').css('margin-top','15px');
		 $('#new_wxpay_box .uploade').css('display','none');
		 $('#new_wxpay_box').append('<div class="form-group noticee"><label>apiclient_cert私钥文件，apiclient_key公钥文件，CA证书文件等配置请登陆PC端修改</label></div>');
	 }else{
		 $('#new_wxpay_box .uploade').css('display','block');
		 $('#new_wxpay_box .noticee').remove();
	     $('#wxapiinfo2').html(apihtml);
	 }
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
			/*$('.switch').change(function(){
				if($(this).val() == 1){
					$('.ibox-content').hasClass('hide') && ($('.ibox-content').removeClass('hide')),$('.ibox-content').show();
				}else if($(this).val() == 0){
					$('.ibox-content').hide();
				}
				$.post('?m=User&c=pay&a=field',{isOpen:$(this).val()});
			});*/
			$('.btn-confirm').click(function(){
				var payConfigData = $(this).parents('form').serialize();
				$.post('?m=User&c=pay&a=config',{data:htmlToArray(payConfigData)},function(result){
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
			$('.btn-confirm-b').click(function(){
				var bankConfig = $(this).parents('form').serialize();
				$.post('?m=User&c=pay&a=bankConfig',bankConfig,function(result){
					if(!result.error){
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
			
			$('#is_pfpay').on('ifChanged', function(){
				if($(this).is(':checked')){
					var is_pfpay = 1;
				}else{
					var is_pfpay = 0;
				}
				$.post('?m=User&c=pay&a=SetFieldV',{ispfpay:is_pfpay},function(ret){
				   if(ret.error){
				      swal("保存失败", '请重新尝试一次' , "error");
				   }else{
				      if(is_pfpay==1){
					     swal("保存成功", '将启用平台管理总后台支付配置来代理您的支付' , "success");
					  }else{
					      swal("保存成功", '将启用您自己独立支付配置来进行支付' , "success");
					  }
				   }
				},'JSON');
			});

			$('#is_pfalipay').on('ifChanged', function(){
				if($(this).is(':checked')){
					var is_alipfpay = 1;
				}else{
					var is_alipfpay = 0;
				}
				$.post('?m=User&c=pay&a=SetFieldV',{isalipfpay:is_alipfpay},function(ret){
				   if(ret.error){
				      swal("保存失败", '请重新尝试一次' , "error");
				   }else{
				      if(is_alipfpay==1){
					     swal("保存成功", '将启用平台管理总后台支付配置来代理您的支付' , "success");
					  }else{
					      swal("保存成功", '将启用您自己独立支付配置来进行支付' , "success");
					  }
				   }
				},'JSON');
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

		 $("#wxApiSetting").click(function(){
			$.post('/merchants.php?m=User&c=pay&a=getApiData',function(ret){
			    $('#wxApi_Setting .wxtoken').val(ret.wxtoken);
				$('#wxApi_Setting .aeskey').val(ret.aeskey);
				
				var winW=$(window).width();
				if(winW<750){
				   $('#wxApi_Setting .modal-dialog').css('width','92%');
				}else{
				   $('#wxApi_Setting .modal-dialog').width(730);
				}
				$('body').append('<div class="modal-backdrop in"></div>');
				$('#wxApi_Setting').show();
			},'JSON');
		  });
		  $("#wxApi_Setting ._close").click(function(){
			  $('#wxApi_Setting').hide();
			  $('#wxApi_Setting .wxtoken').val('');
			  $('#wxApi_Setting .aeskey').val('');
			  $('.modal-backdrop').remove();
		  });
    
    $('#new_wxpay_box .config1,#new_alipay_box .config1,#new_bank_box .config1').click(function(){
	   $(this).hide().siblings('.config2').prop('type','text').focus();
	});
    $('#new_wxpay_box .config2,#new_alipay_box .config2,#new_bank_box .config2').blur(function(){
		var value=$.trim($(this).val());
		if(value){
			$(this).prop('type','hidden').siblings('.config1').val(value.toXingStr()).show();
		}else{
		   $(this).val('');
		}
	});
	String.prototype.toXingStr=function(){
	   var returnStr='';
	   var lenstr=this.length;
	   if(lenstr>4){
	    var xingLen=lenstr-4;
		 for(i=0;i<lenstr;i++){
			if(i<2 || xingLen==0){
			  returnStr+=this.charAt(i);
			}else{
			  returnStr+='*';
			  --xingLen;
			}
		 }
	   }else{
	     for(i=0;i<lenstr;i++){
			  returnStr+='*';
		 }
	   }

        return returnStr;
	}

	$('#mbankname').val("<?php echo $bankConfig['bankname'];?>".toXingStr())
	$('#mbanktruename').val("<?php echo $bankConfig['banktruename'];?>".toXingStr())
    </script>

</body>

</html>