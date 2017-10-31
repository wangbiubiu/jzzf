<!DOCTYPE html>
<html>
<head>
<title>代理商|我的结算</title>
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

.md_xinxi>label{margin-right: 30px;}
.md_xinxi>label>select,.md_xinxi>label>input{ width: 120px; height: 30px; line-height: 30px;}
.md_xinxi>button{ padding: 0 10px; background: #4EBE53; border: none; height: 30px; line-height: 30px; text-align: center; color: #FFFFFF; border-radius: 5px;}
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
					<h2>微信门店</h2>
					<ol class="breadcrumb">
						<li><a>User</a></li>
						<li><a>merchant</a></li>
						<li class="active"><strong>门店管理</strong></li>
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
										<button class="btn btn-primary" id="pop_add_shop"><i class="fa fa-plus"></i> 创建新门店</button>
									</li>
									<?php if($getWxStore){?>
									<li>
										<button class="btn btn-primary" id="pop_get_shop"><i class="fa fa-refresh"></i> 获取微信门店</button>
									</li>
									<?php }?>
								</ul>
							</div>
							<div class="ibox-content">
								<nav class="ui-nav clearfix"></nav>
								<div class="app__content js-app-main page-cashier">
									<div>
										<!-- 实时交易信息展示区域 -->
										<div class="cashier-realtime">
											<div class="realtime-title-block clearfix md_xinxi">
												<label>门店名称<input type="text" placeholder="输入门店名称"></label>
												<label>门店地址 <input type="text" placeholder="省/市/县"></label>
												<label>所属行业
													<select value="">
													<option>所有的行业</option>
													<option>it</option>
													<option>医药</option>
													</select> 
												</label>
												<button>查询</button>
												<button>导出到excel</button>
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
																<th>编号</th>
																<th>微信门店ID</th>
																<th data-hide="phone">门店名称</th>
																<th data-hide="phone">门店地址</th>
																<th data-hide="phone">营业时间</th>
																<th data-hide="phone">联系电话</th>
																<th data-hide="phone">状态</th>
																<th data-hide="phone">操作</th>
															</tr>
														</thead>
														<tbody class="js-list-body-region" id="table-list-body">
															<?php
															if (!empty($stores)) {
															foreach ($stores as $ovv) {
															?>
															<tr class="widget-list-item">
																<td><?php echo $ovv['id'];?></td>
																<td><?php echo $ovv['poi_id'];?></td>
																<td><?php echo $ovv['business_name'].' '.$ovv['branch_name'];?></td>
																<td><?php echo $ovv['provincename'].$ovv['cityname'].$ovv['address'];?></td>
																<td><?php echo date('H:i',$ovv['starttime']).' 至 '.date('H:i',$ovv['endtime']);?></td>
																<td><?php echo $ovv['telephone'];?></td>
																<td><?php echo $ovv['statusstr'];?></td>
																<td>
                                                                <a class="btn btn-sm btn-info" href="/merchants.php?m=User&c=index&a=index&id=<?php echo $ovv['id'];?>" style="vertical-align: top;"> 进入管理 </a>
																	<?php if(!empty($ovv['poi_id'])){?>
																	<button class="btn btn-sm btn-danger delete" data-id="<?php echo $ovv['id'];?>"><strong>删&nbsp;&nbsp;除 </strong></button>
																	<?php }else{?>
																	<button class="btn btn-sm btn-danger" onclick="DelStore(<?php echo $ovv['id'];?>)"><strong>删&nbsp;&nbsp;除</strong></button>
																	<?php }?>
																</td>
															</tr>
															<?php }}else{?>
															<tr class="widget-list-item">
																<td colspan="9">暂无门店</td>
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

	<div class="modal inmodal" tabindex="-1" role="dialog" id="popgetshop">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
					<h4 class="modal-title">正在获取微信门店数据....</h4>
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
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
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
					text: "没有已审核的门店可同步！",
					type: "error"
					});
			}else{
				swal({
					title: "温馨提示",
					text: "已经同步完微信门店数据！",
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
			title: "删除门店",   
			text: "您真的要删除该门店吗？",
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
								  text: '门店删除成功',
								  type: "success",
								  closeOnConfirm: false
								 },function(){
									location.reload();
								});
						} else {
							swal("删除门店失败", ret.errmsg, "error");
					   }
					}
				});
			}
		});
	});
});

/****门店删除*****/
function DelStore(storeId){
	swal({
		title: "删除门店",   
		text: "此门店尚未审核通过，您确定要删除吗？\n此时删除将无法同步删除微信公众后台此门店。",
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
							  text: '门店删除成功',
							  type: "success",
							  closeOnConfirm: false
							 },function(){
								location.reload();
							});
					} else {
						swal("删除门店失败", ret.errmsg, "error");
				   }
				}
			});
		}
	});
}
</script>
</html>