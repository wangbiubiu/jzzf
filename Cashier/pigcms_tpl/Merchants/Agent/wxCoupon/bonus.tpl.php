<!DOCTYPE html>
<html>
<head>
<title>会员积分记录</title>
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
					<h2>会员积分记录</h2>
					<ol class="breadcrumb">
						<li><a>User</a></li>
						<li><a>wxCoupon</a></li>
						<li class="active"><strong>bonus</strong></li>
					</ol>
				</div>
				<div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-content">
								<div class="app__content js-app-main page-cashier">
									<div>
										<!-- 实时交易信息展示区域 -->
										<div class="cashier-realtime">
											<div class="realtime-title-block clearfix">
												<h1 class="realtime-title">会员积分记录列表</h1>
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
																<th data-hide="phone">获得积分数</th>
																<th data-hide="phone">获得详情</th>
																<th data-hide="phone">获得时间</th>
																<th data-hide="phone">来源</th>
															</tr>
														</thead>
														<tbody class="js-list-body-region" id="table-list-body">
															<?php
															if (!empty ($bonus_list)) {
																foreach ($bonus_list as $ovv) {
															?>
           													<tr class="widget-list-item">
																<td><?php echo $ovv['id'];?></td>
																<td><?php echo $ovv['add_bonus'];?></td>
																<td><?php echo $ovv['record_bonus'];?></td>
																<td><?php echo date('Y-m-d H:i:s',$ovv['create_time']);?></td>
																<td>
																	<?php
																		switch ($voo ['fromid']) {
																			case 0 :
																				echo "本系统";
																				break;
																			case 1 :
																				echo "微信营销";
																				break;
																		}
																	?>
            													</td>
															</tr>
		   													<?php }}else{?>
	   														<tr class="widget-list-item">
																<td colspan="5">暂无记录</td>
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
</html>