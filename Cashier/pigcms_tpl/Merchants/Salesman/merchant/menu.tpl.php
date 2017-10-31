<!DOCTYPE html>
<html>
<head>
<title><?php if($cf=='card'){ ?>幻灯片设置<?php }else{ ?>导航管理<?php } ?></title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
<link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
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

#select_Cardtype .i-checks label {
	cursor: pointer;
}

#ewmPopDiv .modal-body {
	text-align: center;
}

.modal-footer {
	text-align: center;
}

.modal-footer .btn {
	padding: 7px 30px;
}

.js_modify_quantity .fa {
	margin-left: 10px;
}

#ewmPopDiv .downewm {
	font-size: 14px;
	padding: 15px;
	text-align: center;
}

.modal-body {
	padding: 20px 30px 15px;
}

#select_Cardtype p {
	margin-bottom: 8px;
}
</style>
<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all2.min.js"></script>
</head>

<body>
	<div id="wrapper">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>导航列表</h2>
					<ol class="breadcrumb">
						<li><a>商家设置</a></li>
						<li><a>导航管理</a></li>
						<li class="active"><strong><?php if($cf=='card'){ ?>幻灯片列表<?php }else{ ?>导航列表<?php } ?></strong></li>
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
										<button class="btn btn-primary" id="pop_add_shop">
											<i class="fa fa-plus"></i> <?php if($cf=='card'){ ?>创建幻灯片<?php }else{ ?>创建新导航<?php } ?>
										</button>
									</li>
								</ul>
							</div>
							<div class="ibox-content">
								<nav class="ui-nav clearfix"></nav>
								<div class="app__content js-app-main page-cashier">
									<div>
										<div class="cashier-realtime">
											<div class="realtime-title-block clearfix">
												<h1 class="realtime-title"><?php if($cf=='card'){ ?>创建幻列表<?php }else{ ?>导航列表<?php } ?></h1>
											</div>
										</div>
										<div class="js-real-time-region realtime-list-box loading">
											<div class="widget-list">
												<div class="js-list-filter-region clearfix ui-box"
													style="position: relative;">
													<div class="widget-list-filter"></div>
												</div>
												<div class="ui-box">
													<table class="ui-table ui-table-list" data-page-size="20" style="padding: 0px;">
														<thead class="js-list-header-region tableFloatingHeaderOriginal">
															<tr class="widget-list-header">
																<th>编号ID</th>
																<th>菜单名称</th>
																<th data-hide="phone">图标</th>
																<th data-hide="phone">外链地址</th>
																<th data-hide="phone">显示顺序</th>
																<th data-hide="phone">显示状态</th>
																<th data-hide="phone">操作</th>
															</tr>
														</thead>
														<tbody class="js-list-body-region" id="table-list-body">
															<?php
															if (!empty($lists)) {
																foreach ($lists as $row) {
															?>
															<tr class="widget-list-item">
																<td><?php echo $row['id'];?></td>
																<td><?php echo $row['name'];?></td>
																<td><img src="<?php echo $row['icon'];?>" style="width: 80px;height:80px;"></td>
																<td><?php echo htmlspecialchars_decode($row['url']);?></td>
																<td><?php echo $row['sort'];?></td>
																<td>
																	<div class="switch">
										                                <div class="onoffswitch">
										                                    <input type="checkbox" <?php if ($row['is_hide'] == 0) echo 'checked';?> class="onoffswitch-checkbox" id="is_hide_<?php echo $row['id'];?>" data-id="<?php echo $row['id'];?>">
										                                    <label class="onoffswitch-label" for="is_hide_<?php echo $row['id'];?>">
										                                        <span class="onoffswitch-inner"></span>
										                                        <span class="onoffswitch-switch"></span>
										                                    </label>
										                                </div>
										                            </div>
																</td>
																<td>
																	<a class="btn btn-sm btn-info" href="?m=User&c=merchant&a=addmenu&id=<?php echo $row['id'];?>&cf=<?php echo $cf;?>" style="vertical-align: top;">编辑 </a>
																	<button class="btn btn-sm btn-danger delete" data-id="<?php echo $row['id'];?>"><strong>删 除 </strong></button>
																</td>
															</tr>
															<?php }}else{?>
															<tr class="widget-list-item">
																<td colspan="7">暂无门店</td>
															</tr>
															<?php }?>
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
				<?php echo $pagebar;?>
            </div>
			</div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
	</div>
</body>
<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
<script>
$(document).ready(function(){
	$('.ui-table-list').footable();
	$('#select_Cardtype .i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});
	
	$("#pop_add_shop").click(function(){
		window.location.href="?m=User&c=merchant&a=addmenu&cf=<?php echo $cf;?>";
	});

	$('.onoffswitch-checkbox').click(function(){
		var is_hide = 0;
		var id = parseInt($(this).attr('data-id'));
		if ($(this).attr('checked')) {
			is_hide = 1;
		}
		$.post('?m=User&c=merchant&a=chnagehide', {'id':id, 'is_hide':is_hide}, function(data){});
	});

	$('.delete').click(function(){
		var id = $(this).attr('data-id');
		swal({
			title: "删除导航",   
			text: "您真的要删除该导航吗？",
			type: "warning",   
			showCancelButton: true,   
			confirmButtonText: "删除",   
			cancelButtonText: "取消",   
			closeOnConfirm: false,   
			closeOnCancel: true 
		}, function(isConfirm){
			if (isConfirm) {
				$.ajax({
					url:"?m=User&c=merchant&a=delmenu",
					type:"get",
					data:{'id':id},
					dataType:"JSON",
					success:function(ret){
						if(!ret.errcode){
							swal({
								  title: "删除导航",
								  text: '删除成功',
								  type: "success",
								  closeOnConfirm: false
								 },function(){
									location.reload();
								});
						} else {
							swal("删除门店", ret.errmsg, "error");
					   }
					}
				});
			}
		});
	});
});
</script>
</html>