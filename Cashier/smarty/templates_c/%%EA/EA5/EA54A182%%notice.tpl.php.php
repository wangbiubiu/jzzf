<?php /* Smarty version 2.6.18, created on 2016-11-11 11:41:12
         compiled from D:%5Ctest%5Cpay%5Cpay%5CCashier%5C./pigcms_tpl/Merchants/System/index/notice.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>总后台 | 公告详情</title>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
wxCoupon/wxCoupon.css" rel="stylesheet">
	<link href="<?php echo @RlStaticResource; ?>
plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="<?php echo @RL_PIGCMS_STATIC_PATH; ?>
plugins/css/footable/footable.core.css" rel="stylesheet">
<style>
.clearfix:after {
	height: 0;
	content: " ";
	display: block;
	overflow: hidden;
	clear: both;
}
.clearfix {
	zoom: 1;/*IE低版本浏览器不支持after伪类所以要加这一句*/
}
ul li{ list-style: none;}
a{text-decoration: none;}

.notice_nr_tit{ text-align: center; border-bottom: 1px  dashed #f2f2f2; padding-top: 30px;}
.notice_nr_tit p{ margin-bottom: 10px; font-size: 18px; color: #36a9e0;}
.notice_nr_tit p span{font-size: 14px; color: #cccccc;}
.notice_nr_zt{ max-width: 530px; margin: 20px auto;}
.notice_nr_zt div{ margin: 10px 0;}
/*.notice_nr_zt div h4{ font-size: 18px;}
.notice_nr_zt div p{font-size: 14px;}*/
</style>
</head>

<body>
    <div id="wrapper">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/leftmenu.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/top.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>管理后台</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="#">System</a>
                        </li>
                        <li>
                            <a>index</a>
                        </li>
                        <li class="active">
                            <strong>首页</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight" >
 
              	<div class="notice_nr" style="background: #FFFFFF; width: 100%; padding-bottom: 30px; margin-top: 30px;">
              		<div class="notice_nr_tit">
              			<p><?php echo $this->_tpl_vars['row']['title']; ?>
</p>
              			<p><span>来源：<?php echo $this->_tpl_vars['row']['source']; ?>
</span><span style="margin-left: 20px;">时间：<?php echo $this->_tpl_vars['row']['addtime']; ?>
</span></p>
              		</div>
              		<div class="notice_nr_zt">
                            <div>
              				<?php echo $this->_tpl_vars['row']['content']; ?>

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

</html>