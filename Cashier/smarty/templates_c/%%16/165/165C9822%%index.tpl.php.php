<?php /* Smarty version 2.6.18, created on 2016-10-27 09:27:31
         compiled from D:%5Ctest%5Cpay%5Cpay%5CCashier%5C./pigcms_tpl/Merchants/System/sysconf/index.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>系统设置</title>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<link href="<?php echo @RlStaticResource; ?>
plugins/css/iCheck/custom.css" rel="stylesheet">
	<script src="<?php echo @RlStaticResource; ?>
plugins/js/iCheck/icheck.min.js"></script>
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
                            <a>sysconf</a>
                        </li>
                        <li class="active">
                            <strong>系统设置</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
			   <div class="row">
				<div class="col-lg-7">
				<div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>系统设置</h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" id="saveSysConf" action="/merchants.php?m=System&c=sysconf&a=saveSysConf" method="POST" name="sysConfform">
                                <div class="form-group">
									<label class="col-lg-3 control-label">注册审核</label>
										<div class="col-sm-9 input-group">

										 <div class="i-checks">
										 <label> <input type="radio"  value="1" name="isregcheck" <?php if ($this->_tpl_vars['sysadmin']['isregcheck'] == 1): ?>checked="checked"<?php endif; ?>> <i></i> 开 启 </label>
										 </div>
										  <div class="i-checks">
										  <label> <input type="radio" value="0" name="isregcheck" <?php if ($this->_tpl_vars['sysadmin']['isregcheck'] == 0): ?>checked="checked"<?php endif; ?> > <i></i> 关 闭 </label>
										  </div>

										<div class="alert alert-warning">开启注册审核后，新注册的商户将是待审核状态<br/>
										 需要系统管理者手动在商家列表里审核通过，商家才能正常登录本收银台系统进行使用	。<br/>
										 注意：<font color="red">营销系统对接过来的商户不需审核</font>
										 </div>

										</div>
                                </div>
 

                                <div class="form-group">
                                    <div class="col-lg-offset-3 col-lg-2">
                                        <button type="submit" class="btn btn-sm btn-primary"> 确 &nbsp; 定 </button>
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

 <script type="text/javascript">
	    $('.i-checks').iCheck({
               checkboxClass: 'icheckbox_square-green',
               radioClass: 'iradio_square-green',
         });
	$('#saveSysConf .btn-primary').click(function(){
	  document.sysConfform.submit();
	});
</script>
</html>