<!DOCTYPE html>
<html>
<head>
<title>会员通知</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
<link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/basic.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
<!-- DROPZONE -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/dropzone/dropzone.js"></script>
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
<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all2.min.js"></script>
</head>

<body>
	<div id="wrapper">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>本站会员卡</h2>
					<ol class="breadcrumb">
						<li><a>User</a></li>
						<li><a>memberLoc</a></li>
						<li class="active"><strong>会员通知</strong></li>
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
										<button class="btn btn-primary" id="pop_add_card"><i class="fa fa-plus"></i> 新建通知</button>
									</li>
								</ul>
							</div>
							<div class="ibox-content">
								<div class="app__content js-app-main page-cashier">
									<div>
										<!-- 实时交易信息展示区域 -->
										<div class="cashier-realtime">
											<div class="realtime-title-block clearfix">
												<h1 class="realtime-title">通知列表</h1>
											</div>
										</div>
										<div class="js-real-time-region realtime-list-box loading">
											<div class="widget-list">
												<div class="js-list-filter-region clearfix ui-box"
													style="position: relative;">
													<div class="widget-list-filter"></div>
												</div>
												<div class="ui-box">
													<table class="ui-table ui-table-list" data-page-size="20"
														style="padding: 0px;">
														<thead
															class="js-list-header-region tableFloatingHeaderOriginal">
															<tr class="widget-list-header">
																<th>卡序号</th>
																<th data-hide="phone">标题</th>
																<th data-hide="phone">截止日期</th>
																<th data-hide="phone">添加时间</th>
																<th data-hide="phone">操作</th>
															</tr>
														</thead>
														<tbody class="js-list-body-region" id="table-list-body">
															<?php
															if (! empty ( $mbnotices )) {
															foreach ( $mbnotices as $nvv ) {
															?>
															<tr class="widget-list-item">
																<td><?php echo $nvv['id'];?></td>
																<td><?php echo $nvv['ntitle'];?></td>
																<td><?php echo date('Y-m-d',$nvv['endtime']);?></td> 
																<td><?php echo date('Y-m-d',$nvv['addtime']);?></td>
																<td class="footable-visible footable-last-column">
																	<a class="btn btn-sm btn-info" href="?m=User&c=memberLoc&a=createNotice&cdid=<?php echo $nvv['cdid'];?>&ntid=<?php echo $nvv['id'];?>" style="vertical-align: top;"> 编 辑 </a>&nbsp;&nbsp;

																	<button onclick="deltheItem(this,<?php echo $nvv['cdid'];?>,<?php echo $nvv['id'];?>);" class="btn btn-sm btn-danger">
																		<strong> 删 除 </strong>
																	</button>
																</td>
															</tr>
															<?php }}else{?>
															<tr class="widget-list-item">
																<td colspan="11">暂无内容</td>
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
 
var actid=0,cdid;
var numObj='';
 $(document).ready(function(){
		$('.ui-table-list').footable();
         $('#select_Cardtype .i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

		  $("#pop_add_card").click(function(){

			  window.location.href="?m=User&c=memberLoc&a=createNotice&cdid=<?php echo $cardinfo['id'];?>";
  
		   });

	});
 /****删除****/
function deltheItem(obj,cdid,ntid){
		swal({
		  title: "温馨提示",
		  text: "您确认要删除此项吗？",
		  type: "success"
		 }, function () {
		     $.post('?m=User&c=memberLoc&a=delNotice',{cdid:cdid,ntid:ntid},function(ret){
			     if(!ret.error){
				   $(obj).parent('td').parent('tr').remove();
				 }else{
				 	swal({
					  title: "删除失败！",
					  text: ret.msg,
					  type: "error"
					 });
				 }
			 },'JSON');
		});
}
</script>
</html>