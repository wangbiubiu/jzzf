<?php /* Smarty version 2.6.18, created on 2016-12-01 20:18:46
         compiled from D:%5Ctest%5Cpay%5Cpay%5CCashier%5C./pigcms_tpl/Merchants/System/pay/rebate.tpl.php */ ?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>费率配置</title>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <link href="<?php echo @RlStaticResource; ?>
plugins/css/iCheck/custom.css" rel="stylesheet">
	<link href="<?php echo @RlStaticResource; ?>
plugins/css/dropzone/basic.css" rel="stylesheet">
    <link href="<?php echo @RlStaticResource; ?>
plugins/css/dropzone/dropzone.css" rel="stylesheet">
    <!-- iCheck -->
    <script src="<?php echo @RlStaticResource; ?>
plugins/js/iCheck/icheck.min.js"></script>
	<!-- DROPZONE -->
    <script src="<?php echo @RlStaticResource; ?>
plugins/js/dropzone/dropzone.js"></script>
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
		.red{color:red;}
               
	</style>
</head>

<body>

    <div id="wrapper">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/leftmenu.tpl2.php", 'smarty_include_vars' => array()));
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
                    <h2>费率配置</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>System</a>
                        </li>
                        <li>
                            <a>pay</a>
                        </li>
                        <li class="active">
                            <strong>费率配置</strong>
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
                        <div class="ibox-title">
                            <h5>费率修改</h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" id="pwdform" action="/merchants.php?m=System&c=pay&a=rebate" method="post">
                               
                                <p style="color:red;">注意：修改了费率，将在下个月1号开始生效。</p>
                                 <h2>一清商户</h2>
                                 <p>微信当前值：<?php echo $this->_tpl_vars['row']['0']['rebate']; ?>
 %</p>
                                 <p>支付宝当前值：<?php echo $this->_tpl_vars['row']['1']['rebate']; ?>
 %</p>
                                  <h2>二清清商户</h2>
                                  <p>微信当前值：<?php echo $this->_tpl_vars['row']['2']['rebate']; ?>
 %</p>
                                  <p>支付宝当前值：<?php echo $this->_tpl_vars['row']['3']['rebate']; ?>
 %</p>
                                
                                <div class="col-sm-12">
                                    <h2>一清商户</h2>
                                    <div class="form-group col-sm-6">
    									<label class="col-lg-5 control-label">新微信结算费率</label>
    									<div class="col-sm-7 input-group"><input type="text" class="form-control" placeholder="输入新的费率" name="aclear_wx_edit_rebate" style="width:70%" value="<?php echo $this->_tpl_vars['row']['0']['edit_rebate']; ?>
"><span style="padding-top:10px; display: inline-block; margin-left: 10px">%</span></div>
                                   </div>
                                   <div class="form-group col-sm-6">
    									<label class="col-lg-5 control-label">新支付宝结算费率</label>
                                        <div class="col-sm-7 input-group"><input type="text" class="form-control" placeholder="输入新的费率" name="aclear_ali_edit_rebate" style="width:70%" value="<?php echo $this->_tpl_vars['row']['1']['edit_rebate']; ?>
"><span style="padding-top:10px; display: inline-block; margin-left: 10px">%</span></div>
                                   </div>
                                </div>
                                
                                <div  class="col-sm-12">
                                    <h2>二清商户</h2>
                                    <div class="form-group col-sm-6">
    									<label class="col-lg-5 control-label">新微信结算费率</label>
    									<div class="col-sm-7 input-group"><input type="text" class="form-control" placeholder="输入新的费率" name="an_wx_edit_rebate" style="width:70%" value="<?php echo $this->_tpl_vars['row']['2']['edit_rebate']; ?>
" ><span style="padding-top:10px; display: inline-block; margin-left: 10px" >%</span></div>
                                   </div>
                                   <div class="form-group col-sm-6">
    									<label class="col-lg-5 control-label">新支付宝结算费率</label>
                                        <div class="col-sm-7 input-group"><input type="text" class="form-control" placeholder="输入新的费率" name="an_ali_edit_rebate" style="width:70%" value="<?php echo $this->_tpl_vars['row']['3']['edit_rebate']; ?>
"><span style="padding-top:10px; display: inline-block; margin-left: 10px" >%</span></div>
                                   </div>
                                </div>
								
                                <div class="form-group">
                                    <div class="col-lg-offset-4 col-lg-12" style="margin-left: 38.33333333%">
                                        <button type="submit" class="btn btn-sm btn-primary" style="padding: 5px 40px"> 确 定 </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                       <div class="ibox float-e-margins" style=" margin-top: 30px">
                        <div class="ibox-title">
                            <h5>商户费率设置</h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" id="pwdform" action="/merchants.php?m=System&c=pay&a=MerchantRate" method="POST">
                               
                                <p style="color:red;">注意：费率从0.01-1.00之间，多个参数以（‘,’）逗号隔开。</p>
                                <div class="col-sm-12">
                                    <h2>商户费率配置</h2>
                                    <div class="form-group col-sm-12">
    									<label class="col-lg-3 control-label">微信结算费率</label>
    									<div class="col-sm-9 input-group"><input type="text" class="form-control" placeholder="输入新的费率" name="aclear_wx_interest" style="width:70%" value="<?php echo $this->_tpl_vars['row_an']['0']['rebate']; ?>
"><span style="padding-top:10px; display: inline-block; margin-left: 10px">%</span></div>
                                   </div>
                                   <div class="form-group col-sm-12">
    									<label class="col-lg-3 control-label">支付宝结算费率</label>
                                        <div class="col-sm-9 input-group"><input type="text" class="form-control" placeholder="输入新的费率" name="aclear_ali_interest" style="width:70%" value="<?php echo $this->_tpl_vars['row_an']['1']['rebate']; ?>
"><span style="padding-top:10px; display: inline-block; margin-left: 10px">%</span></div>
                                   </div>
                                </div>
                                <!--  
                                    <div  class="col-sm-12">
                                        <h2>二清商户</h2>
                                        <div class="form-group col-sm-12">
        									<label class="col-lg-3 control-label">微信结算费率</label>
        									<div class="col-sm-9 input-group"><input type="text" class="form-control" placeholder="输入新的费率" name="an_wx_interest" style="width:70%" value="<?php echo $this->_tpl_vars['row_an']['2']['rebate']; ?>
"><span style="padding-top:10px; display: inline-block; margin-left: 10px">%</span></div>
                                       </div>
                                       <div class="form-group col-sm-12">
        									<label class="col-lg-3 control-label">支付宝结算费率</label>
                                            <div class="col-sm-9 input-group"><input type="text" class="form-control" placeholder="输入新的费率" name="an_ali_interest" style="width:70%" value="<?php echo $this->_tpl_vars['row_an']['3']['rebate']; ?>
"><span style="padding-top:10px; display: inline-block; margin-left: 10px">%</span></div>
                                       </div>
                                    </div>
								-->
                                <div class="form-group" >
                                    <div class="col-lg-offset-4 col-lg-12" style="margin-left: 38.33333333%">
                                        <button type="submit" class="btn btn-sm btn-primary" style="padding: 5px 40px"> 确 定 </button>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                     </div>
                        
                        
						</div>
                    </div>
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
	 var apihtml="<button class='btn btn-info api' type='button' <?php if (( $this->_tpl_vars['payConfig']['alipay']['isOpen'] == 1 )): ?> checked='checked' <?php endif; ?> id='wxApiSetting'> API接口 </button>";
	 <?php if (! ( $this->_tpl_vars['_mid'] > 0 )): ?>
		apihtml='';
	 <?php endif; ?>
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
				$.post('?m=System&c=pay&a=field',{isOpen:$(this).val()});
			});*/
			$('.btn-confirm').click(function(){
				var payConfigData = $(this).parents('form').serialize();
				$.post('?m=System&c=pay&a=config',{data:htmlToArray(payConfigData)},function(result){
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
			/*$('.isOpen').on('ifChanged', function(){
				if($(this).is(':checked')){
					var isOpen = 1;
				}else{
					var isOpen = 0;
				}
				var payConfigData = {};
				typeof(payConfigData[$(this).attr('data-type')]) == 'undefined' && (payConfigData[$(this).attr('data-type')] = {}),payConfigData[$(this).attr('data-type')].isOpen = isOpen;
				$.post('?m=System&c=pay&a=config',{data:payConfigData});
			});*/
			$(".dropz").dropzone({
				url: "?m=System&c=pay&a=pem_upload",
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
			$.post('/merchants.php?m=System&c=pay&a=getApiData',function(ret){
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
    </script>

</body>

</html>