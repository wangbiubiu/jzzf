<!DOCTYPE html>
<html>
<head>
<title>门店详情</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>merchant/store_mangecss.css" rel="stylesheet">
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>merchant/baseshop.css" rel="stylesheet">
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>merchant/widget_add_img.css" rel="stylesheet">

<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/basic.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
<style type="text/css">
#dataselect .input-group-btn, #ym-select .input-group-btn {
	width: 12%;
}

#dataselect .input-sm, #ym-select .input-sm {
	border-radius: 7px;
	height: 40px;
}

#dataselect .btn-primary, #ym-select .btn-primary {
	margin-left: 20px;
	border-radius: 4px;
	margin-bottom: 0px;
}

#dataselect .input-group-addon, #ym-select .input-group-addon {
	border-radius: 7px;
}

.ibox-content {
	min-height: 800px;
}

#js_pic_url .dz-image-preview {
	display: none;
}

.img_upload_preview_box p {
	margin: 0px;
}

.js_category_container select {
	width: 200px;
	float: left;
}

#provinceS, #cityS, #districtS, #circleS {
	display: inline-block;
	width: auto;
}

#js_latitude, #js_longitude {
	width: 250px;
	display: inline;
}
.frm_textarea_box,.frm_input_box{border:0; color: #8d8d8d;}
</style>
<!-- Data picker -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
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
						<li><a>商家设置</a></li>
						<li><a href="/merchants.php?m=User&c=merchant&a=storefront">门店管理</a></li>
						<li class="active"><strong>门店详情</strong></li>
					</ol>
				</div>
				<div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeIn">

				<div class="row" id="wrapper-content-list">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-content">
								<div class="group main_bd">
									<form novalidate="novalidate" class="store_build" id="js_store_build">
										<div class="frm_section">
											<h3 class="frm_title">
												基本信息<span class="frm_title_dec">基本信息提交后不可修改</span>
											</h3>
											<div class="frm_control_group">
												<label for="" class="frm_label">门店名</label>
												<div class="frm_controls">
													<span class="frm_input_box"><?php echo $store['business_name'];?></span>
												</div>
											</div>
											<div class="frm_control_group">
												<label for="" class="frm_label">分店名</label>
												<div class="frm_controls">
													<span class="frm_input_box"><?php echo $store['branch_name'];?></span>
												</div>
											</div>
											<div class="frm_control_group">
												<label for="" class="frm_label">类目</label>
												<div class="frm_controls">
													<span class="frm_input_box"><?php echo $catestr;?></span>
												</div>
											</div>
											<div class="frm_control_group">
												<label for="" class="frm_label">地址</label>
												<div class="frm_controls">
													<span class="frm_input_box"><?php echo $store['provincename'] . $store['cityname'] . $store['address'];?></span>
												</div>
											</div>
										</div>
										<div class="frm_control_group">
											<label for="" class="frm_label">标注</label>
											<div class="frm_controls">
												<div id="js_upload_wrp">
													<div class="img_upload_wrp group">
														<div class="js_edit_pic_wrp">
														<img alt="" src="http://apis.map.qq.com/ws/staticmap/v2/?center=<?php echo $store['latitude'];?>,<?php echo $store['longitude'];?>&zoom=16&size=600*300&maptype=roadmap&markers=size:large|color:blue|<?php echo $store['latitude'];?>,<?php echo $store['longitude'];?>&key=S6PBZ-D7BRQ-BNB5S-G2LBZ-PYAIO-DJF4K">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="frm_section service_info">
											<div class="frm_control_group">
												<label for="" class="frm_label">门店图片</label>
												<div class="frm_controls">
													<div id="js_upload_wrp">
														<div class="img_upload_wrp group">
															<?php foreach ($photo_list as $photo) {?>
															<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp">
																<img src="<?php echo $photo['local_img'];?>">
															</div>
															<?php }?>
														</div>
													</div>
												</div>
											</div>
											<div class="frm_control_group">
												<label for="" class="frm_label">电话</label>
												<div class="frm_controls">
													<span class="frm_input_box"><?php echo $store['telephone'];?></span>
												</div>
											</div>
											<div class="frm_control_group">
												<label for="" class="frm_label">人均价格</label>
												<div class="frm_controls">
													<span class="frm_input_box"><?php echo $store['avg_price'];?></span>
												</div>
											</div>
											<div class="frm_control_group">
												<label for="" class="frm_label">营业时间</label>
												<div class="frm_controls">
													<span class="frm_input_box"><?php echo $date_str;?></span>
												</div>
											</div>
											<div class="frm_control_group">
												<label for="" class="frm_label">推荐</label>
												<div class="frm_controls">
													<div class="frm_textarea_box"><?php echo $store['recommend'];?></div>
												</div>
											</div>
											<div class="frm_control_group">
												<label for="" class="frm_label">特色服务</label>
												<div class="frm_controls">
													<div class="frm_textarea_box"><?php echo $store['special'];?></div>
												</div>
											</div>
											<div class="frm_control_group">
												<label for="" class="frm_label">简介</label>
												<div class="frm_controls">
													<div class="frm_textarea_box"><?php echo $store['introduction'];?></div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div>
			<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
	</div>
	<!-- DROPZONE -->
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/dropzone/dropzone.js"></script>
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
</body>
</html>