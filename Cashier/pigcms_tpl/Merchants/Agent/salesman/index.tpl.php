<!DOCTYPE html>
<html>
<head>
<title>代理商|业务员列表</title>
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
th{ text-align: center;}
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
				<h2>业务员列表</h2>
				<ol class="breadcrumb">
					<li><a>Agent</a></li>
					<li><a>业务员中心</a></li>
					<li class="active"><strong>业务员列表</strong></li>
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
									<button class="btn btn-primary" id="pop_add_shop"><i class="fa fa-plus"></i> 添加业务员</button>
								</li>
							</ul>
						</div>
						<div class="ibox-content">
							<nav class="ui-nav clearfix"></nav>
							<div class="app__content js-app-main page-cashier">
								<div>
									<!-- 实时交易信息展示区域 -->
									<div class="cashier-realtime">
									<form action='?m=Agent&c=salesman&a=index' method="post" >
										<div class="realtime-title-block clearfix md_xinxi">

											<label>名称<input type="text" name='username' placeholder="输入业务员称"></label>
											<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">
											<a   class="btn btn-primary"  style="width:100px;" href="?m=Agent&c=salesman&a=data2Excel">导出到excel</a>
										</div>

										</form>
							
									<div class="js-real-time-region realtime-list-box loading">
										<div class="widget-list">
											<div class="js-list-filter-region clearfix ui-box"
												style="position: relative;">
												<div class="widget-list-filter"></div>
											</div>
											<div class="ui-box">
											<form name='form2'>	
												<table class="ui-table ui-table-list" data-page-size="20" style="padding: 0px; text-align: center;">
													<thead class="js-list-header-region tableFloatingHeaderOriginal">
														<tr class="widget-list-header">
															<th>序号</th>
															<th>登录账号</th>
															<th data-hide="phone">业务员名</th>
															<th data-hide="phone">佣金返点</th>
<!--															<th data-hide="phone">支付宝佣金返点</th>-->
															<th data-hide="phone">联系方式</th>
															<th data-hide="phone">个人配置</th>
															<th data-hide="phone">操作</th>
														</tr>
													</thead>
													<tbody class="js-list-body-region" id="table-list-body">
			<?php
			if (!empty($salesmans)) {
			foreach ($salesmans as $ovv) {
			?>
			<tr class="widget-list-item">
				<td><?php if (empty($ovv['id'])) {echo '';}else{echo $ovv['id'];}?></td>
				<td><?php if (empty($ovv['account'])) { echo '';}else{echo $ovv['account'];}?></td>
				<td><?php if (empty($ovv['username'])) { echo '';}else{echo $ovv['username'];}?></td>

					<td><?php if (empty($ovv['wxrate'])) { echo '';}else{echo $ovv['wxrate']*100;}?>%</td>
<!--																<td><?php if (empty($ovv['alirate'])) { echo '';}else{echo $ovv['alirate'];}?>%</td>-->
					<td><?php if (empty($ovv['phone'])) { echo '';}else{echo $ovv['phone'];}?></td>
					<td><a href="javascript:void(0);" class="btn btn-primary" onclick="lookBanck(<?php echo $ovv['id']; ?>)">查看信息</a></td>
			<td>
                                 <a class="btn btn-sm btn-info" href="?m=agent&c=salesman&a=mngSaler&sid=<?php echo $ovv['id'];?>" style="vertical-align: top; background: #337ab7;"> 管理 </a>
																<a class="btn btn-sm btn-info" href="<?php echo '?m=Salesman&c=index&a=index&sid='.$ovv['id']?>" style="vertical-align: top;"  target="_blank">一键登录</a>
																<?php if(!empty($ovv['id'])){?>
																<button class="btn btn-sm btn-danger delete" data-id="<?php echo $ovv['id'];?>"><strong>删&nbsp;&nbsp;除 </strong></button>
																<?php }else{?>
																<button class="btn btn-sm btn-danger" onclick="delSaler(<?php echo $ovv['id'];?>)"><strong>删&nbsp;&nbsp;除</strong></button>
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

												</form>
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
			<?php echo $p;?>
      </div>


      <!-- 弹框 -->

       <div class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true" id="hkbankset" style=" overflow-y: auto;">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<form action="" method="post" enctype="multipart/form-data">
			<div class="modal-header">
              <button type="button" class="close _close"><span>×</span><span class="sr-only">Close</span></button>
              
              <h4 class="modal-title">汇款银行卡 信息配置</h4>
          </div>
			<div class="modal-body">
				<div class="setting_rows">
					<div id="new_bank_box" class="wxpay_box">
						<div class="form-group">
							<label>银行名称：</label>
							<p id="banckname"></p>
						</div>
						<div class="form-group">
							<label>银行卡号：</label>
							<p id="bankcardnumm"></p>
						</div>
						<div class="form-group">
							<label>开卡人姓名：</label>
							 <p id="banktruename"></p>
						</div>

						<div class="form-group">
							<label>开卡人身份证号：</label>
							<p id="identitycode"></p>
						</div>
                                    <div class="form-group">
							<label>开卡人身份证图片：</label>
                                                          <p id=""><img id="identitycodeA" style="width:45%; height: 200px ;" src='' ><img style="width:45%; margin-left: 40px;height: 200px ;" id="identitycodeB" src='' ></p>
						</div>
                                    <div class="form-group">
							<label>开卡人银行卡图片：</label>
							<p id=""><img id="bankA" style="width:45%;height: 200px ; " src='' ><img id="bankB" style="width:45%;  margin-left: 40px;height: 200px ;" src='' ></p>
						</div>
                                    <div class="form-group">
							<label>开卡人手持银行卡和身份证：</label>
							<p id=""><img id="in_bank" style="width:45%;height: 200px ;" src='' ></p>
						</div>
      <!--  -->
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

<div class="modal inmodal" tabindex="-1" role="dialog"  id="Export_excel_pop">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<h6 class="modal-title">请耐心等待导出完成...</h6>
				<span>数据比较多请耐心等待导出完成，不要点取消！</span>
			</div>
			<div class="modal-body">
			<ul></ul>
			</div>
				<div class="modal-footer">
              <button type="button" class="btn btn-white" > 取 消 </button>
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
	$.post('?m=Agent&c=salesman&a=getWxStore',function(rets){
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
	window.location.href="?m=Agent&c=salesman&a=createSaler";
});



$('.delete').click(function(){
	var id = $(this).attr('data-id');
	swal({
		title: "删除业务员",   
		text: "您真的要删除该业务员吗？",
		type: "warning",   
		showCancelButton: true,   
		confirmButtonText: "删除",   
		cancelButtonText: "取消",   
		closeOnConfirm: false,   
		closeOnCancel: true 
	}, function(isConfirm){

		if (isConfirm) {
			$.ajax({
				url:"?m=Agent&c=salesman&a=delSaler",
				type:"POST",
				data:{'id':id},
				dataType:"JSON",
				success:function(ret){
					if(!ret.errcode){
						swal({
							  title: "删除成功",
							  text: '业务员删除成功',
							  type: "success",
							  closeOnConfirm: false
							 },function(){
								location.reload();
							});
					} else {
						swal("删除业务员失败", ret.errmsg, "error");
				   }
				}
			});
		}
	});
});
});





function lookBanck(sid){
$.post('?m=Agent&c=salesman&a=getCashierBank',{sid:sid},function(rets){
	console.log(rets);
rets.error=parseInt(rets.error);
if(!rets.error){
	$('#new_bank_box #banckname').text(rets.bankname);
	$('#new_bank_box #bankcardnumm').text(rets.bankcard);
	$('#new_bank_box #banktruename').text(rets.bankaccount);
	$('#new_bank_box #identitycode').text(rets.idcard);
	$('#new_bank_box #bankA').attr('src',rets.bankA);
	$('#new_bank_box #bankB').attr('src',rets.bankB);
	$('#new_bank_box #identitycodeA').attr('src',rets.idA);
	$('#new_bank_box #identitycodeB').attr('src',rets.idB);
	$('#new_bank_box #in_bank').attr('src',rets.bankAndID);
	$('#hkbankset').show();
	$('body').append('<div class="modal-backdrop in"></div>');
 }else{
    swal("温馨提示",'此业务员没有配置线下汇款银行卡信息' , "error");
 }
},'JSON');
}

$('#hkbankset ._close').click(function(){
$('#hkbankset').hide();
$('.modal-backdrop').remove();
	//$('#new_bank_box p').html('');
});
</script>




</html>