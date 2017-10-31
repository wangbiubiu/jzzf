<!DOCTYPE html>
<html>
<head>
<title>管理后台 | 城市区域</title> 
{pg:include file="$tplHome/System/public/header.tpl.php"}
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/iCheck/custom.css" rel="stylesheet">
<link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dropzone/basic.css" rel="stylesheet">
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dropzone/dropzone.css" rel="stylesheet">
<!-- iCheck -->
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/iCheck/icheck.min.js"></script>
<!-- DROPZONE -->
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/dropzone/dropzone.js"></script>
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
	margin: 0;
	padding: 0;
}

.ibox-title li {
	float: left;
	width: 30%;
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
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/footable/footable.all2.min.js"></script>
</head>

<body>
	<div id="wrapper">
		{pg:include file="$tplHome/System/public/leftmenu.tpl.php"}
        <div id="page-wrapper" class="gray-bg">
			{pg:include file="$tplHome/System/public/top.tpl.php"}
            <div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>城市列表</h2>
					<ol class="breadcrumb">
						<li><a>System</a></li>
						<li><a>merchant</a></li>
						<li class="active"><strong>district</strong></li>
					</ol>
				</div>
				<div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							{pg:if $area.level == 3}
							<div class="ibox-title clearfix">
								<ul class="nav">
									<li>
										<button class="btn btn-primary" id="pop_add_card"><i class="fa fa-plus"></i> 新建商圈</button>
									</li>
								</ul>
							</div>
							{pg:/if}
							<div class="ibox-content">
								<div class="app__content js-app-main page-cashier">
									<div>
										<!-- 实时交易信息展示区域 -->
										<div class="cashier-realtime">
											<div class="realtime-title-block clearfix">
												<h1 class="realtime-title">{pg:if $area}【{pg:$area.fullname}】包含的{pg:if $area.level == 1}市{pg:elseif $area.level == 2}区{pg:elseif $area.level == 3}商圈{pg:/if}列表{pg:else}省市列表{pg:/if}</h1>
											</div>
										</div>
										<div class="js-real-time-region realtime-list-box loading">
											<div class="widget-list">
												<div class="js-list-filter-region clearfix ui-box" style="position: relative;">
													<div class="widget-list-filter"></div>
												</div>
												<div class="ui-box">
													<table class="ui-table ui-table-list" data-page-size="{pg:$total}" style="padding: 0px;">
														<thead class="js-list-header-region tableFloatingHeaderOriginal">
															<tr class="widget-list-header">
																<th>编号</th>
																<th data-hide="phone">区域名称</th>
																<th data-hide="phone">操作</th>
															</tr>
														</thead>
														<tbody class="js-list-body-region" id="table-list-body">
															{pg:if !empty($lists)}
															{pg:foreach item=row from=$lists}
															<tr class="widget-list-item">
																<td>{pg:$row.id}</td>
																<td>{pg:$row.fullname}</td>
																<td class="footable-visible footable-last-column">
																	{pg:if $row.level == 4}
																	<a class="btn btn-sm btn-info edit" href="javascript:;" style="vertical-align: top;" data-fullname="{pg:$row.fullname}" data-pinyin="{pg:$row.pinyin}" data-id="{pg:$row.id}">修改 </a>
																	<a class="btn btn-sm btn-danger delete" href="javascript:;" style="vertical-align: top;" data-id="{pg:$row.id}">删除 </a>
																	{pg:else}
																	<a class="btn btn-sm btn-info" href="?m=System&c=merchant&a=district&fid={pg:$row.id}" style="vertical-align: top;">查看{pg:if $row.level eq 1}市{pg:elseif $row.level eq 2}区{pg:elseif $row.level eq 3}商圈{pg:/if}列表 </a>
																	{pg:/if}
																</td>
															</tr>
															{pg:/foreach} 
															{pg:else}
															<tr class="widget-list-item">
																<td colspan="3">没有区域</td>
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
				{pg:$pagebar}
            </div>
		</div>
		{pg:include file="$tplHome/System/public/footer.tpl.php"}
        </div>
	</div>

	<div class="modal inmodal" tabindex="-1" role="dialog"  id="Pop_Set_Cardtype">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
                    <button type="button" class="close _close"><span style="font-size: 35px;">×</span><span class="sr-only">Close</span></button>
					<input type="hidden" class="form-control" name="fid" id="fid" value="{pg:$area.id}"/> 
					<input type="hidden" class="form-control" name="id" id="id" value="0"/> 
                    <h4 class="modal-title">创建新的商圈</h4>
                </div>
				<div class="modal-body">
					<div class="dialog_bd">
						<div class="setting_rows">
							<div class="frm_control_group">
								<div class="form-group">
									<label class="col-sm-2 control-label">商圈名称</label>
									<div class="col-sm-5 input-group m-b">
										<input type="text" class="form-control" name="fullname" id="fullname" > 
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">商圈拼音</label>
									<div class="col-sm-5 input-group m-b">
										<input type="text" class="form-control" name="pinyin" id="pinyin" > 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				   <button type="button" class="btn btn-primary btn-confirm">确 定</button>&nbsp;&nbsp;&nbsp;
                   <button type="button" class="btn btn-white _close">取 消</button>
                </div>
			</div>
		</div>
	</div>
</body>
<!-- iCheck -->
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/iCheck/icheck.min.js"></script>
<script>
$(document).ready(function(){
	$('.ui-table-list').footable();
	$('#select_Cardtype .i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});
	$("#pop_add_card").click(function(){
		$('body').append('<div class="modal-backdrop in"></div>');
		$('#Pop_Set_Cardtype').show();
	});

	$("#Pop_Set_Cardtype ._close").click(function(){
		$("#fullname").val(''), $("#pinyin").val(''), $('#id').val(0);
		$('#Pop_Set_Cardtype').hide();
		$('.modal-backdrop').remove();
	});

	$(".edit").click(function(){
		$("#fullname").val($(this).attr('data-fullname')), $("#pinyin").val($(this).attr('data-pinyin')), $('#id').val($(this).attr('data-id'));
		$('body').append('<div class="modal-backdrop in"></div>');
		$('#Pop_Set_Cardtype').show();
	});

	$("#Pop_Set_Cardtype .btn-confirm").click(function(){
		var fullname = $("#fullname").val(), pinyin = $("#pinyin").val(), fid = $('#fid').val(), id = $('#id').val();
		if (fullname.length < 1) {
			swal('提示', '商圈名称不能为空', 'error');
			return false;
		}
		if (pinyin.length < 1) {
			swal('提示', '商圈拼音不能为空', 'error');
			return false;
		}
		$.ajax({
				url:'?m=System&c=merchant&a=addcircle',
				type:"post",
				data:{'fullname':fullname, 'pinyin':pinyin, 'fid':fid, 'id':id},
				dataType:"JSON",
				success:function(ret){
					if(!ret.errcode){
						swal({
							  title: "操作",
							  text: ret.errmsg,
							  type: "success",
							  closeOnConfirm: false
						 },function(){
							location.reload();
						});
					} else {
						swal({
						  title: "操作",
						  text: ret.errmsg,
						  type: "error"
						 });
				   }
				}
		});
		return false;
	});

	$('.delete').click(function(){
		var id = $(this).val(), obj = $(this).parents('.widget-list-item');
		swal({
				title: "确定要删除吗？",   
				text: "您确定要删除该商圈吗",
				type: "warning",   
				showCancelButton: true,   
				confirmButtonText: "确定",   
				cancelButtonText: "取消",   
				closeOnConfirm: false,   
				closeOnCancel: false 
			}, function(isConfirm){
				if (isConfirm) {
					$.ajax({
						url:'?m=System&c=merchant&a=cancelcircle',
						type:"post",
						data:{'id':id},
						dataType:"JSON",
						success:function(ret){
							if(!ret.error){
								swal({
									  title: "删除提示",
									  text: ret.errmsg,
									  type: "success",
									  closeOnConfirm: false
									 },function(){
										 location.reload();
									});
							} else {
								swal("删除提示", ret.errmsg, "error");
						   }
						}
					});
				} else {
					swal("放弃删除", "您放弃删除该商圈", "success");   
				} 
		});
		return false;
	});
});
</script>
</html>