<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>管理后台 | 店铺分类</title> 
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
						<li><a href="#">系统配置</a></li>
						<li class="active"><strong>店铺分类</strong></li>
					</ol>
				</div>
				<div class="col-lg-2"></div>
			</div>
			
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							{pg:if empty($category)}
							<div class="ibox-title clearfix">
								<ul class="nav">
									<li>
										<button class="btn btn-primary" id="refresh_weixin_categroy"><i class="fa fa-refresh"></i>刷新同步微信中的分类信息</button>
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
												<h1 class="realtime-title">{pg:if $category}【{pg:$category.name}】的子分类列表{pg:else}店铺分类列表{pg:/if}</h1>
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
																<th data-hide="phone">分类ID</th>
																<th data-hide="phone">分类名</th>
																<th data-hide="phone">分类图标</th>
																<th data-hide="phone">使用状态</th>
																<th data-hide="phone">首页显示状态</th>
																<th data-hide="phone">查看子分类</th>
																<th data-hide="phone">操作</th>
															</tr>
														</thead>
														<tbody class="js-list-body-region" id="table-list-body">
															{pg:if !empty($lists)}
															{pg:foreach item=row from=$lists}
															<tr>
																<td>{pg:$row.id}</td>
																<td>{pg:$row.name}</td>
																<td><img alt="" src="{pg:$row.icon}" id="js_icon_{pg:$row.id}" style="width: 80;height:80px;"></td>
																<td>
																	<div class="switch">
										                                <div class="onoffswitch">
										                                    <input type="checkbox" {pg:if $row.is_hide == 0}checked{pg:/if} class="onoffswitch-checkbox" id="is_hide_{pg:$row.id}" data-id="{pg:$row.id}" data-type="is_hide">
										                                    <label class="onoffswitch-label" for="is_hide_{pg:$row.id}">
										                                        <span class="onoffswitch-inner"></span>
										                                        <span class="onoffswitch-switch"></span>
										                                    </label>
										                                </div>
										                            </div>
                            									</td>
																<td>
																	<div class="switch">
										                                <div class="onoffswitch">
										                                    <input type="checkbox" {pg:if $row.is_home_show == 1}checked{pg:/if} class="onoffswitch-checkbox" id="is_home_show_{pg:$row.id}" data-id="{pg:$row.id}" data-type="is_home_show">
										                                    <label class="onoffswitch-label" for="is_home_show_{pg:$row.id}">
										                                        <span class="onoffswitch-inner"></span>
										                                        <span class="onoffswitch-switch"></span>
										                                    </label>
										                                </div>
										                            </div>
                            									</td>
																<td><a class="btn btn-sm btn-info"  href="?m=System&c=merchant&a=index&fid={pg:$row.id}" style="vertical-align:top;">查看子分类 </a></td>
																<td>
																	<button class="btn btn-sm btn-info upload" data-id="{pg:$row.id}">修改图标 </button>
																	<script type="text/javascript">

																	</script>
																</td>
															</tr>
															{pg:/foreach} 
															{pg:else}
															<tr class="widget-list-item">
																<td colspan="3">暂无分类信息</td>
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
		</div>
	</div>
	{pg:include file="$tplHome/System/public/footer.tpl.php"}
	
	<div class="modal inmodal" tabindex="-1" role="dialog"  id="popgetshop">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
					<h4 class="modal-title">正在刷新同步微信中的分类信息....</h4>
				</div>
				<div class="modal-body">
					<div class="spiner-example" style="padding-top: 30px;">
						<div class="sk-spinner sk-spinner-circle" style="height: 100px;width: 100px;">
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
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/dropzone/dropzone.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var flag = false;
	$('#refresh_weixin_categroy').click(function(){
		if (flag) return false;
		flag = true;
		$('body').append('<div class="modal-backdrop in"></div>');
		$('#popgetshop').show();
		$.ajax({
				url:'?m=System&c=merchant&a=refreshCategroy',
				type:"get",
				dataType:"JSON",
				success:function(ret){
					$('#popgetshop').hide();
				    $('.modal-backdrop').remove();
					if(!ret.errcode){
						swal("提示", ret.errmsg, "success");
					} else {
						flag = false;
						swal("提示", ret.errmsg, "error");
					}
				}
		});
		return false;
	});

	$('.onoffswitch-checkbox').click(function(){
		var id = parseInt($(this).attr('data-id'));
		var type = $(this).attr('data-type');
		if (type == 'is_hide') {
			var is_hide = 0;
			if ($(this).attr('checked')) {
				is_hide = 1;
			}
		} else {
			var is_hide = 1;
			if ($(this).attr('checked')) {
				is_hide = 0;
			}
		}
		$.post('?m=System&c=merchant&a=chnagehide', {'id':id, 'is_hide':is_hide, 'type':type}, function(data){});
	});

	$(".upload").each(function(){
		var __this = $(this);
		$(this).dropzone({
			url: "?m=System&c=merchant&a=uploadIcon&id=" + __this.data("id"),
			addRemoveLinks: false,
			maxFilesize: 1,
			acceptedFiles: ".jpg,.png",
			uploadMultiple: false,
			init: function() {
				this.on("success", function(file,responseText) {
					var rept = $.parseJSON(responseText);
					if (!rept.error) {
						$('#js_icon_' + rept.id).attr('src', rept.icon);
						$('.dz-preview').remove();
					}else{
						swal({
							title: "上传失败",
							text: rept.msg,
							type: "error"
						});
					}
				});
			}
		});
	});
	
});
</script>
</html>