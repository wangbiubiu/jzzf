<?php /* Smarty version 2.6.18, created on 2016-12-29 15:47:26
         compiled from /phpstudy/www/pay.yunjifu.net/Cashier/./pigcms_tpl/Merchants/System/merchant/distribution.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>
<title>商户管理</title>
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
<style>
.ibox-title h5 {
	margin: 10px 0 0px;
}

select.input-sm {
	height: 35px;
	line-height: 35px;
}

.float-e-margins .btn-info {
	margin-bottom: 0px;
}

.fa-paste {
	margin-right: 7px;
	padding: 0px;
}

.dz-preview {
	display: none;
}

.ibox-title ul {
	list-style: outside none none !important;
	margin: 0 0 0 10px;
	padding: 0;
}

.ibox-title li {
	float: left;
	width: 15%;
}

#commonpage {
	float: right;
	margin-bottom: 10px;
}

#table-list-body .btn-st {
	background-color: #337ab7;
	border-color: #2e6da4;
	cursor: auto;
}
.navbar-header .bgcolor {
    background-color: none;
    border-color: none;
}
.title{ height: 40px; line-height: 40px; border-top: 3px solid #edfbfe; border-bottom: 1px solid #d9e6e9; font-size: 18px; background: #FFFFFF; padding-left: 20px; margin-bottom: 0px; margin-top: 0px;}
.content{ background: #FFFFFF; width: 100%; padding: 30px 0 60px;}
.content form{ width: 95%; margin:0px auto;border: 1px solid #f2f2f2;  position: relative;}
.content form p{border-bottom: 1px solid #f2f2f2; height: 40px; line-height: 40px; margin-bottom: 0px;}
.content form p>label:first-child{ width: 100px; text-align: right; margin-right: 20px;}
.content form p>label>select{ width: 120px;}
.content form input{ position: absolute; bottom: -45px;height: 30px; line-height: 30px; left:50%; background: #36a9e0; border: none; border-radius: 5px; padding: 0 20px;margin-left: -30px; color: #FFFFFF;}
</style>
<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all2.min.js"></script>
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
						<li><a>商户中心</a></li>
						<li><a>商户列表</a></li>
						<li class="active"><strong>分配到代理商</strong></li>
					</ol>
				</div>
				<div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
					<h1 class="title">分配到代理商</h1>
				<div class="content">
                                    <form action="/merchants.php?m=System&c=merchant&a=distribution" method="post">
                                        <input type="hidden" name="mid" value="<?php echo $this->_tpl_vars['mer']['mid']; ?>
">
						<p><label>商户名:</label><span><?php echo $this->_tpl_vars['mer']['company']; ?>
</span></p>
						<p><label>分配:</label>
							<label>
								代理商：
                                                                <select name="aid">
                                                                    <option value="">请选择</option>
                                                                    <?php $_from = $this->_tpl_vars['agent']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                                                                    <option value="<?php echo $this->_tpl_vars['v']['aid']; ?>
" <?php if ($this->_tpl_vars['v']['aid'] == $this->_tpl_vars['mer']['aid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['v']['uname']; ?>
</option>
                                                                    <?php endforeach; endif; unset($_from); ?>        
								</select>
							</label>
						</p>
						<input type="submit"  value="保存" class="bc"/>
					</form>
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

</body>
<!-- iCheck -->
<script src="<?php echo @RlStaticResource; ?>
plugins/js/iCheck/icheck.min.js"></script>
</html>