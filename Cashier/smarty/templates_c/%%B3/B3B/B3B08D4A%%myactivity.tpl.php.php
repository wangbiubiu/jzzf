<?php /* Smarty version 2.6.18, created on 2016-01-07 09:52:13
         compiled from D:%5Cvirtualhost%5Cxxzckj%5CCashier%5C./pigcms_tpl/Merchants/System/activity/myactivity.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>管理后台 | 活动列表</title> 
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
						<li><a>活动管理</a></li>
						<li class="active"><strong><?php echo $this->_tpl_vars['title']; ?>
</strong></li>
					</ol>
				</div>
				<div class="col-lg-2"></div>
			</div>
			
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-content">
								<div class="form-group">
									<div class="col-sm-2 input-group">
									<input type="text" class="form-control"  id="keyword" placeholder="请输入活动名称" value="<?php echo $this->_tpl_vars['keyword']; ?>
">
									<span class="input-group-btn">
										<button class="btn btn-primary" id="search">查 询</button>
									</span>
									</div>
								</div>
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
														<input type="hidden" id="table_name" value="<?php echo $this->_tpl_vars['table_name']; ?>
" />
														<thead class="js-list-header-region tableFloatingHeaderOriginal">
															<tr class="widget-list-header">
																<th data-hide="phone">活动ID</th>
																<th data-hide="phone">活动名称</th>
																<th data-hide="phone">活动图片</th>
																<th data-hide="phone">单价</th>
																<th data-hide="phone">活动结束时间</th>
																<th data-hide="phone">活动类型</th>
																<th data-hide="phone">操作</th>
															</tr>
														</thead>
														<tbody class="js-list-body-region" id="table-list-body">
															<?php if (! empty ( $this->_tpl_vars['lists'] )): ?>
															<?php $_from = $this->_tpl_vars['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
															<tr>
																<td><?php echo $this->_tpl_vars['row']['id']; ?>
</td>
																<td><?php echo $this->_tpl_vars['row']['title']; ?>
</td>
																<td><img src="<?php echo $this->_tpl_vars['row']['pic']; ?>
" style="width: 80;height:80px;"></td>
																<td><?php echo $this->_tpl_vars['row']['price']; ?>
</td>
																<td><?php echo $this->_tpl_vars['row']['endtime']; ?>
</td>
																<td><?php echo $this->_tpl_vars['row']['typename']; ?>
</td>
																<td><button class="btn btn-sm btn-danger delete" data-id="<?php echo $this->_tpl_vars['row']['id']; ?>
">删除 </button></td>
															</tr>
															<?php endforeach; endif; unset($_from); ?> 
															<?php else: ?>
															<tr class="widget-list-item">
																<td colspan="6">暂无活动</td>
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
						<?php echo $this->_tpl_vars['pagebar']; ?>

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
	
	$('.delete').click(function(){
		var id = $(this).attr('data-id');
		swal({
			title: "删除活动",   
			text: "您真的要删除该活动吗？",
			type: "warning",   
			showCancelButton: true,   
			confirmButtonText: "删除",   
			cancelButtonText: "取消",   
			closeOnConfirm: false,   
			closeOnCancel: true 
		}, function(isConfirm){
			if (isConfirm) {
				$.ajax({
					url:"?m=System&c=activity&a=delact",
					type:"get",
					data:{'id':id},
					dataType:"JSON",
					success:function(ret){
						if(!ret.errcode){
							swal({
								  title: "删除活动",
								  text: '删除成功',
								  type: "success",
								  closeOnConfirm: false
								 },function(){
									location.reload();
								});
						} else {
							swal("删除活动", ret.errmsg, "error");
					   }
					}
				});
			}
		});
	});
	$('#search').click(function(){
		var keyword = $('#keyword').val(), table_name = $('#table_name').val();
		if (keyword == '') return false;
		location.href = '?m=System&c=activity&a=myactivity&keyword=' + keyword 
	});
});
</script>
</html>