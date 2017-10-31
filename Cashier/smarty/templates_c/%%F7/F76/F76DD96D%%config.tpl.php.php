<?php /* Smarty version 2.6.18, created on 2016-05-20 22:50:37
         compiled from C:%5Cpay%5CCashier%5C./pigcms_tpl/Merchants/System/merchant/config.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>短信配置</title>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
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
                    <h2>收银台管理后台</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>System</a>
                        </li>
                        <li>
                            <a>index</a>
                        </li>
                        <li class="active">
                            <strong>短信配置</strong>
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
                            <h5>短信配置</h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" id="pwdform" action="/merchants.php?m=System&c=merchant&a=saveconfig" method="POST">
                                <p>填写购买后获得的相关信息</p>
                                <div class="form-group"><label class="col-lg-2 control-label">短信秘钥</label>
                                    <div class="col-sm-9 input-group"><input type="text" class="form-control" name="sms_key" value="<?php echo $this->_tpl_vars['sms']['sms_key']; ?>
"></div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">您的签名</label>
                                    <div class="col-sm-9 input-group"><input type="text" class="form-control" name="sms_sign" value="<?php echo $this->_tpl_vars['sms']['sms_sign']; ?>
"></div>
                                </div>
								<div class="form-group"><label class="col-lg-2 control-label">绑定的顶级域名</label>
                                    <div class="col-sm-9 input-group"><input type="text" class="form-control" name="sms_topdomain" value="<?php echo $this->_tpl_vars['sms']['sms_topdomain']; ?>
"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <button type="submit" class="btn btn-sm btn-primary"> 确定 </button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
</body>

 <script>
    	 /*$("#pwdform").submit(function(){
			var sms_key=$.trim($('input[name="sms_key"]').val());
			var sms_sign=$.trim($('input[name="sms_sign"]').val());
			var sms_topdomain=$.trim($('input[name="sms_topdomain"]').val());
			if(!sms_key){
			     swal("温馨提醒", "您没有输入短信秘钥", "error");
				 $('input[name="sms_key"]').focus();
				 return false;
			}
			if(!sms_sign){
			     swal("温馨提醒", "您没有输入您的签名", "error");
				 $('input[name="sms_sign"]').focus();
				 return false;
			}
			if(!sms_topdomain){
			     swal("温馨提醒", "您没有输入绑定的顶级域名！", "error");
				 $('input[name="sms_topdomain"]').focus();
				 return false;
			}
		   return true;
		 });*/
</script>
</html>