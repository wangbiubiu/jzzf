<!DOCTYPE html>
<html>
<head>
<title>会员开卡</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
<link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">

<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
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

.erdiv{margin: 8px 0px 12px 0px;background-color:#F5F5F4}

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
						<li class="active"><strong>会员开卡</strong></li>
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
										<button class="btn btn-primary" id="pop_add_card"><i class="fa fa-plus"></i> 创建卡号 </button>
									</li>
								</ul>
							</div>
							<div class="ibox-content">
								<div class="app__content js-app-main page-cashier">
									<div>
										<!-- 实时交易信息展示区域 -->
										<div class="cashier-realtime">
											<div class="realtime-title-block clearfix">
												<h1 class="realtime-title">会员卡号列表</h1>
											</div>
										</div>
										<div class="js-real-time-region realtime-list-box loading">
											<div class="widget-list">
												<div class="erdiv">
													<button class="btn btn-primary" onclick="delCardnum();"><i class="fa  fa-minus-circle"></i> 选择删除 </button>
													<span style="margin-left:20px;">已经领取 <font color="red"><?php echo $y_count;?></font> 张，剩余 <font color="red"><?php echo ($_count-$y_count);?></font> 张未领取，一共&nbsp;<font color="red"><?php echo $_count;?></font> 张</span>
												</div>
												<div class="ui-box">
													<table class="ui-table ui-table-list" data-page-size="20"
														style="padding: 0px;">
														<thead
															class="js-list-header-region tableFloatingHeaderOriginal">
															<tr class="widget-list-header">
																<th><label style="cursor: pointer;"><input type="checkbox"  class="i-checks" id="selectAll">&nbsp;&nbsp;全选</label></th>
																<th data-hide="phone">会员卡号</th>
																<th data-hide="phone">状态</th>
																<th data-hide="phone">会员资料</th>
															</tr>
														</thead>
														<tbody class="js-list-body-region" id="table-list-body">
															<?php
															if (! empty ($locmbnumber )) {
															foreach ($locmbnumber as $cvv ) {
															?>
															<tr class="widget-list-item">
																<td><input type="checkbox" class="i-checks" value="<?php echo $cvv['id'];?>">&nbsp;&nbsp;<?php echo $cvv['id'];?></td>
																<td><?php echo $cvv['numstr'];?></td>
																<td><?php if(empty($cvv['openid'])){
																    echo '<font color="green">空闲卡</font>';
																}else{
																   echo '<font>使用中</font>';
																}?></td> 
																<td></td>
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
 $(document).ready(function(){
         $('.ui-table-list .i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

		  $("#pop_add_card").click(function(){

			  window.location.href="?m=User&c=memberLoc&a=createCnum&cdid=<?php echo $cardinfo['id'];?>";
  
		   });
		$('#selectAll').on('ifChecked ifUnchecked', function(event){
			if (event.type == 'ifChecked') {
				$('#table-list-body .i-checks').iCheck('check');
			} else {
				$('#table-list-body .i-checks').iCheck('uncheck');
			}
		});
	});

function delCardnum(){
   var cdid="<?php echo $cardinfo['id'];?>";
   var idArr=new Array();
   var tmpidStr='';
	$('#table-list-body .i-checks').each(function(){
		  if($(this).is(':checked')){
			tmpidStr =$.trim($(this).val());
			idArr.push(tmpidStr);
		  }
	  });

	if(idArr.length>0){
	   tmpidStr=idArr.join(',');
	   swal({
		  title: "温馨提示",
		  text: "您确认要删除此项吗？",
		  type: "success"
		 }, function () {
		   $.post('?m=User&c=memberLoc&a=delCardnum',{cnumid:tmpidStr,cdid:cdid},function(ret){
				alert(ret.msg);
				window.location.reload();
		   },'JSON');
	 });
	}
}

</script>
</html>