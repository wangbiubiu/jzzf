<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>管理后台 | 活动列表</title> 
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
						<li><a>活动管理</a></li>
						<li class="active"><strong>{pg:$title}</strong></li>
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
									<input type="text" class="form-control"  id="keyword" placeholder="请输入活动名称" value="{pg:$keyword}">
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
													<table class="ui-table ui-table-list" data-page-size="{pg:$total}" style="padding: 0px;">
														<input type="hidden" id="table_name" value="{pg:$table_name}" />
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
															{pg:if !empty($lists)}
															{pg:foreach item=row from=$lists}
															<tr>
																<td>{pg:$row.id}</td>
																<td>{pg:$row.title}</td>
																<td><img src="{pg:$row.pic}" style="width: 80;height:80px;"></td>
																<td>{pg:$row.price}</td>
																<td>{pg:$row.endtime}</td>
																<td>{pg:$row.typename}</td>
																<td><button class="btn btn-sm btn-danger delete" data-id="{pg:$row.id}">删除 </button></td>
															</tr>
															{pg:/foreach} 
															{pg:else}
															<tr class="widget-list-item">
																<td colspan="6">暂无活动</td>
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
						{pg:$pagebar}
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