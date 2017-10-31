<?php /* Smarty version 2.6.18, created on 2016-10-27 09:27:57
         compiled from D:%5Ctest%5Cpay%5Cpay%5CCashier%5C./pigcms_tpl/Merchants/System/merchant/banner.tpl.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars_decode', 'D:\\test\\pay\\pay\\Cashier\\./pigcms_tpl/Merchants/System/merchant/banner.tpl.php', 91, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>管理后台 | 首页幻灯片</title> 
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
<style type="text/css">
#table-list-body .fa-edit {
	color: #3DA142;
	font-size: 20px;
}

#table-list-body .tips {
	color: #3DA142;
	cursor: pointer;
}

#table-list-body .tips span {
	display: none;
}

#table-list-body .prelative .form-control {
	display: none;
	vertical-align: middle;
	width: auto;
	height: 30px;
	padding: 3px 10px;
}
.dz-preview{display:none;}
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
						<li><a>系统配置</a></li>
						<li class="active"><strong>首页幻灯片</strong></li>
					</ol>
				</div>
				<div class="col-lg-2"></div>
			</div>
			
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-title clearfix">
								<ul class="nav">
									<li>
										<button class="btn btn-primary" id="refresh_weixin_categroy"><i class="fa fa-plus"></i>新增首页幻灯片</button>
									</li>
								</ul>
							</div>
							<div class="ibox-content">
								<div class="app__content js-app-main page-cashier">
									<div>
										<div class="js-real-time-region realtime-list-box loading">
											<div class="widget-list">
												<div class="js-list-filter-region clearfix ui-box" style="position: relative;">
													<div class="widget-list-filter"></div>
												</div>
												<div class="ui-box">
													<table class="ui-table ui-table-list" data-page-size="<?php echo $this->_tpl_vars['total']; ?>
" style="padding: 0px;">
														<thead class="js-list-header-region tableFloatingHeaderOriginal">
															<tr class="widget-list-header">
																<th data-hide="phone">首页幻灯片ID</th>
																<th data-hide="phone">首页幻灯片标题</th>
																<th data-hide="phone">首页幻灯片图片</th>
																<th data-hide="phone">首页幻灯片外链</th>
																<th data-hide="phone">排序</th>
																<th data-hide="phone">操作</th>
															</tr>
														</thead>
														<tbody class="js-list-body-region" id="table-list-body">
															<?php if (! empty ( $this->_tpl_vars['banners'] )): ?>
															<?php $_from = $this->_tpl_vars['banners']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
															<tr>
																<td><?php echo $this->_tpl_vars['row']['id']; ?>
</td>
																<td><?php echo $this->_tpl_vars['row']['title']; ?>
</td>
																<td><img src="<?php echo $this->_tpl_vars['row']['pic']; ?>
" style="width: 80;height:80px;"></td>
																<td><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['url'])) ? $this->_run_mod_handler('htmlspecialchars_decode', true, $_tmp) : htmlspecialchars_decode($_tmp)); ?>
</td>
																<td><?php echo $this->_tpl_vars['row']['sort']; ?>
</td>
																<td>
																	<a class="btn btn-sm btn-info" href="?m=System&c=merchant&a=addbanner&id=<?php echo $this->_tpl_vars['row']['id']; ?>
" style="vertical-align: top;">编辑 </a>
																	<button class="btn btn-sm btn-danger delete" data-id="<?php echo $this->_tpl_vars['row']['id']; ?>
">删除 </button>
																</td>
															</tr>
															<?php endforeach; endif; unset($_from); ?> 
															<?php else: ?>
															<tr class="widget-list-item">
																<td colspan="5">暂无首页幻灯片</td>
															</tr>
															<?php endif; ?>
														</tbody>
													</table>
													<div class="js-list-empty-region"></div>
												</div>
												<div class="js-list-footer-region ui-box">
													<div class="widget-list-footer"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
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
<script src="<?php echo @RlStaticResource; ?>
plugins/js/dropzone/dropzone.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#refresh_weixin_categroy').click(function(){
		window.location.href='?m=System&c=merchant&a=addbanner';
		return false;
	});
	
	$('.delete').click(function(){
		var id = $(this).attr('data-id');
		swal({
			title: "删除首页幻灯片",   
			text: "您真的要删除该首页幻灯片吗？",
			type: "warning",   
			showCancelButton: true,   
			confirmButtonText: "删除",   
			cancelButtonText: "取消",   
			closeOnConfirm: false,   
			closeOnCancel: true 
		}, function(isConfirm){
			if (isConfirm) {
				$.ajax({
					url:"?m=System&c=merchant&a=delbanner",
					type:"get",
					data:{'id':id},
					dataType:"JSON",
					success:function(ret){
						if(!ret.errcode){
							swal({
								  title: "删除首页幻灯片",
								  text: '删除成功',
								  type: "success",
								  closeOnConfirm: false
								 },function(){
									location.reload();
								});
						} else {
							swal("删除首页幻灯片", ret.errmsg, "error");
					   }
					}
				});
			}
		});
	});
});
</script>
</html>