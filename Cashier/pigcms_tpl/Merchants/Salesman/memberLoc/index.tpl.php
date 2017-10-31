<!DOCTYPE html>
<html>
<head>
<title>本站会员卡</title>
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
						<li class="active"><strong>会员卡列表</strong></li>
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
										<button class="btn btn-primary" id="pop_add_card"><i class="fa fa-plus"></i> 创建本地会员卡</button>
									</li>
								</ul>
							</div>
							<div class="ibox-content">
								<div class="app__content js-app-main page-cashier">
									<div>
										<!-- 实时交易信息展示区域 -->
										<div class="cashier-realtime">
											<div class="realtime-title-block clearfix">
												<h1 class="realtime-title">会员卡列表</h1>
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
																<th data-hide="phone">会员卡名称</th>
																<th data-hide="phone">卡片总数</th>
																<th data-hide="phone">已开卡会员</th>
																<th data-hide="phone">领卡短信验证</th>
																<th data-hide="phone">领取卡券</th>
																<th data-hide="phone">操作</th>
															</tr>
														</thead>
														<tbody class="js-list-body-region" id="table-list-body">
															<?php
															if (! empty ( $cardsinfo )) {
															foreach ( $cardsinfo as $cvv ) {
															?>
															<tr class="widget-list-item">
																<td><?php echo $cvv['id'];?></td>
																<td><?php echo $cvv['cardname'];?></td>
																<td><?php echo $cvv['cardnums'];?></td> 
																<td><?php echo $cvv['membernums'];?></td>
																<td><?php if($cvv['ischeck']==0){ echo " 关 闭 ";}else{
																	echo "<font color='green'> 开 启 <font>";
																}?></td>
																 <td><button class="btn btn-sm btn-primary btn-primary-ewm"><strong>查看二维码</strong></button>
																 </td>
																<td class="footable-visible footable-last-column">
																	<a class="btn btn-sm  btn-primary" href="?m=User&c=memberLoc&a=mbCardSet&cdid=<?php echo $cvv['id'];?>">
																		<strong>会员卡设置</strong>
																	</a> &nbsp;&nbsp;

																	<a class="btn btn-sm btn-info" href="?m=User&c=memberLoc&a=notice&cdid=<?php echo $cvv['id'];?>" style="vertical-align: top;"> 会员通知 </a>
																	&nbsp;&nbsp;

																	<?php if ($cvv['isdonate'] == 1) {?>
																	<a class="btn btn-sm btn-info" href="?m=User&c=memberLoc&a=donate&cdid=<?php echo $cvv['id'];?>" style="vertical-align: top;"> 充值赠送 </a> 
																	&nbsp;&nbsp;
																	<?php }?>

																	<a class="btn btn-sm btn-info" href="?m=User&c=memberLoc&a=memberCard&cdid=<?php echo $cvv['id'];?>" style="vertical-align: top;"> 会员开卡 </a>&nbsp;&nbsp;

																	<a class="btn btn-sm btn-info" href="?m=User&c=memberLoc&a=createGift&cdid=<?php echo $cvv['id'];?>" style="vertical-align: top;"> 开卡赠送 </a>&nbsp;&nbsp;

																	<a class="btn btn-sm btn-info" href="?m=User&c=memberLoc&a=createCard&cdid=<?php echo $cvv['id'];?>" style="vertical-align: top;"> 修 改 </a>&nbsp;&nbsp;

																	<button onclick="deltheItem(this,<?php echo $cvv['id'];?>);" class="btn btn-sm btn-danger">
																		<strong> 删 除 </strong>
																	</button>
																</td>
															</tr>
															<?php }}else{?>
															<tr class="widget-list-item">
																<td colspan="11">暂无会员卡</td>
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

		<div class="modal inmodal" tabindex="-1" role="dialog"  id="ewmPopDiv">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
                    <button type="button" class="close _close"><span style="font-size: 35px;">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">本地会员卡领取二维码</h4>
                </div>
				<div class="modal-body">
				</div>
				<div class="downewm"><a href="javascript:;">点击下载此二维码</a></div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-white _close">关闭</button>
                </div>
			</div>
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

			  window.location.href="?m=User&c=memberLoc&a=createCard";
  
		   });

	});
 /****删除****/
function deltheItem(obj,cdid){
		swal({
		  title: "温馨提示",
		  text: "您确认要删除此项吗？",
		  type: "success"
		 }, function () {
		     $.post('?m=User&c=memberLoc&a=delCard',{cdid:cdid},function(ret){
			     if(!ret.error){
				   $(obj).parent('td').parent('tr').remove();
				 }else{
				 	swal({
					  title: "温馨提示",
					  text: ret.msg,
					  type: "error"
					 });
				 }
			 },'JSON');
		});
}

  $(".btn-primary-ewm").click(function(){
	   if($('.modal-backdrop').size()>0 || ($('.sweet-overlay').size()>0 && $('.sweet-overlay').attr('display')=='block')){
			return false;
	   }

	$('#ewmPopDiv .modal-body').append('<img src="<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=memberLoc&a=qrcode">');
	$('body').append('<div class="modal-backdrop in"></div>');
	$('#ewmPopDiv .downewm a').attr('href','<?php echo $this->SiteUrl;?>/merchants.php?m=User&c=memberLoc&a=qrcode&dwd=1');
	$('#ewmPopDiv').show();	

   });

  $("#ewmPopDiv ._close").click(function(){
	  $('#ewmPopDiv').hide();
	  $('.modal-backdrop').remove();
	  $('#ewmPopDiv .modal-body').html('');
	  $('#ewmPopDiv .downewm a').attr('href','javascript:;');
  });
</script>
</html>