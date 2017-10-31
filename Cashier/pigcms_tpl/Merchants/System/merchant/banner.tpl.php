<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>管理后台 | 首页幻灯片</title> 
{pg:include file="$tplHome/System/public/header.tpl.php"}
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
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
		{pg:include file="$tplHome/System/public/leftmenu.tpl.php"}
		<div id="page-wrapper" class="gray-bg dashbard-1">
			{pg:include file="$tplHome/System/public/top.tpl.php"}
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
													<table class="ui-table ui-table-list" data-page-size="{pg:$total}" style="padding: 0px;">
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
															{pg:if !empty($banners)}
															{pg:foreach item=row from=$banners}
															<tr>
																<td>{pg:$row.id}</td>
																<td>{pg:$row.title}</td>
																<td><img src="{pg:$row.pic}" style="width: 80;height:80px;"></td>
																<td>{pg:$row.url|htmlspecialchars_decode}</td>
																<td>{pg:$row.sort}</td>
																<td>
																	<a class="btn btn-sm btn-info" href="?m=System&c=merchant&a=addbanner&id={pg:$row.id}" style="vertical-align: top;">编辑 </a>
																	<button class="btn btn-sm btn-danger delete" data-id="{pg:$row.id}">删除 </button>
																</td>
															</tr>
															{pg:/foreach} 
															{pg:else}
															<tr class="widget-list-item">
																<td colspan="5">暂无首页幻灯片</td>
															</tr>
															{pg:/if}
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
	{pg:include file="$tplHome/System/public/footer.tpl.php"}
</body>
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/dropzone/dropzone.js"></script>
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