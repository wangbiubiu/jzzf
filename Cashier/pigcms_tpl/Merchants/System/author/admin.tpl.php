<!DOCTYPE html>
<html>
<head>
<title>管理员列表</title> 
{pg:include file="$tplHome/System/public/header.tpl.php"}
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/iCheck/custom.css" rel="stylesheet">
<link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}css/cashier.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	<script src="{pg:$smarty.const.RlStaticResource}plugins/js/datapicker/bootstrap-datepicker.js"></script>
<script
	src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
<!-- Data picker -->
<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>

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
.sh{ width:100px; height: 30px;padding: 0px !important;  color:#ffffff !important;line-height: 30px;}
.sh:hover{ background:#4EBE53 !important }
.md_xinxi>label{margin-right: 30px;}
.md_xinxi>label>select,.md_xinxi>label>input{ width: 120px; height: 30px; line-height: 30px;}
.md_xinxi>button{ padding: 0 10px; background: #4EBE53; border: none; height: 30px; line-height: 30px; text-align: center; color: #FFFFFF; border-radius: 5px;}
th{ text-align: center;}
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
					<h2>员工管理</h2>
					<ol class="breadcrumb">
						<li><a>User</a></li>
						<li><a>权限控制</a></li>
						<li class="active"><strong>员工管理</strong></li>
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
										  <a  class="sh btn btn-primary" id="pop_add_shop" href="/merchants.php?m=System&c=author&a=addm"><i class="fa fa-plus"></i> 添加管理员</a>
									</li>
								</ul>
							</div>
							<div class="ibox-content">
								<nav class="ui-nav clearfix"></nav>
								<div class="app__content js-app-main page-cashier">
									<div>
										<!-- 实时交易信息展示区域 -->
									
										<div class="js-real-time-region realtime-list-box loading">
											<div class="widget-list">
												<div class="js-list-filter-region clearfix ui-box"
													style="position: relative;">
													<div class="widget-list-filter"></div>
												</div>
												<div class="ui-box">
													<table class="ui-table ui-table-list" data-page-size="20" style="padding: 0px; text-align: center;">
														<thead class="js-list-header-region tableFloatingHeaderOriginal">
															<tr class="widget-list-header">
																<th>序号</th>
																<th>姓名</th>
																<th data-hide="phone">用户名</th>
																<th data-hide="phone">联系电话</th>
																<th data-hide="phone">角色</th>
																<th data-hide="phone">操作</th>
															</tr>
														</thead>
														<tbody class="js-list-body-region" id="table-list-body">
															<?php
															//if (!empty($stores)) {
															//foreach ($stores as $ovv) {
															?>
															<tr class="widget-list-item">
																<td>1</td>
																<td>管理员</td>
																<td>秀峰</td>
																<td>15401212512</td>
																<td>管理员</td>
																<td>
                                                                    <a class="btn btn-sm btn-info" href="#" style="vertical-align: top; background: #337ab7;"> 编辑 </a>
																	<a class="btn btn-sm btn-info" href="#" style="vertical-align: top;">修改密码 </a>
																	<?php if(!empty($ovv['poi_id'])){?>
																	<button class="btn btn-sm btn-danger delete" data-id=""><strong>删&nbsp;&nbsp;除 </strong></button>
																	<?php }else{?>
																	<button class="btn btn-sm btn-danger" onclick="DelStore(<?php echo $ovv['id'];?>)"><strong>删&nbsp;&nbsp;除</strong></button>
																	<?php }?>
																</td>
															</tr>
															<?php //}}else{?>
															<tr class="widget-list-item">
																<td colspan="9">暂无员工</td>
															</tr>
															<?php// }?>
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
		{pg:include file="$tplHome/System/public/footer.tpl.php"}
        </div>
	</div>

<div class="modal inmodal" tabindex="-1" role="dialog" id="popgetshop">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
					<h4 class="modal-title">正在获取微信员工数据....</h4>
				</div>
				<div class="modal-body">
					<div class="spiner-example" style="padding-top: 30px;">
						<div class="sk-spinner sk-spinner-circle" style="height: 100px; width: 100px;">
							<div class="sk-circle1 sk-circle"></div>
							<div class="sk-circle2 sk-circle"></div>
							<div class="sk-circle3 sk-circle"></div>
							<div class="sk-circle4 sk-circle"></div>
							<div class="sk-circle5 sk-circle"></div>
							<div class="sk-circle6 sk-circle"></div>
							<div class="sk-circle7 sk-circle"></div>
							<div class="sk-circle8 sk-circle"></div>
							<div class="sk-circle9 sk-circle"></div>
							<div class="sk-circle10 sk-circle"></div>
							<div class="sk-circle11 sk-circle"></div>
							<div class="sk-circle12 sk-circle"></div>
						</div>
					</div>
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

	$("#pop_get_shop").click(function(){
		$('body').append('<div class="modal-backdrop in"></div>');
		$('#popgetshop').show();
		$.post('?m=User&c=merchant&a=getWxStore',function(rets){
			$('#popgetshop').hide();
			$('.modal-backdrop').remove();
			if(rets.error){
			     swal({
					title: "温馨提示",
					text: "没有已审核的员工可同步！",
					type: "error"
					});
			}else{
				swal({
					title: "温馨提示",
					text: "已经同步完微信员工数据！",
					type: "success"
					}, function () {
						window.location.reload();
				});	 
			}
		},'JSON');
	});
	
	$("#pop_add_shop").click(function(){
		window.location.href="?m=User&c=merchant&a=createStore";
	});

	$('.delete').click(function(){
		var id = $(this).attr('data-id');
		swal({
			title: "删除员工",   
			text: "您真的要删除该员工吗？",
			type: "warning",   
			showCancelButton: true,   
			confirmButtonText: "删除",   
			cancelButtonText: "取消",   
			closeOnConfirm: false,   
			closeOnCancel: true 
		}, function(isConfirm){
			if (isConfirm) {
				$.ajax({
					url:"?m=User&c=merchant&a=storedel",
					type:"POST",
					data:{'id':id},
					dataType:"JSON",
					success:function(ret){
						if(!ret.errcode){
							swal({
								  title: "删除成功",
								  text: '员工删除成功',
								  type: "success",
								  closeOnConfirm: false
								 },function(){
									location.reload();
								});
						} else {
							swal("删除员工失败", ret.errmsg, "error");
					   }
					}
				});
			}
		});
	});
});

/****员工删除*****/
function DelStore(storeId){
	swal({
		title: "删除员工",   
		text: "此员工尚未审核通过，您确定要删除吗？\n此时删除将无法同步删除微信公众后台此员工。",
		type: "warning",   
		showCancelButton: true,   
		confirmButtonText: "删除",   
		cancelButtonText: "取消",   
		closeOnConfirm: false,   
		closeOnCancel: true 
	}, function(isConfirm){
		if (isConfirm) {
			$.ajax({
				url:"?m=User&c=merchant&a=store2del",
				type:"POST",
				data:{'id':storeId},
				dataType:"JSON",
				success:function(ret){
					if(!ret.errcode){
						swal({
							  title: "删除成功",
							  text: '员工删除成功',
							  type: "success",
							  closeOnConfirm: false
							 },function(){
								location.reload();
							});
					} else {
						swal("删除员工失败", ret.errmsg, "error");
				   }
				}
			});
		}
	});
}
</script>

</html>