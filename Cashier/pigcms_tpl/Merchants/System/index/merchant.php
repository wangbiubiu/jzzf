<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 | 特约商户管理</title>
	{pg:include file="$tplHome/System/public/header.tpl.php"}
	<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/iCheck/custom.css" rel="stylesheet">
	<script src="{pg:$smarty.const.RlStaticResource}plugins/js/footable/footable.all2.min.js"></script>
	<script src="{pg:$smarty.const.RlStaticResource}plugins/js/iCheck/icheck.min.js"></script>
	<style type="text/css">
	#listfootable .fa-edit{ color: #3DA142;font-size: 20px;}
	#listfootable .tips{ color: #3DA142;cursor: pointer;}
	#listfootable .tips span{ display: none;} 
	#listfootable .prelative .form-control {
    display: none;
    vertical-align: middle;
    width: auto;
	height: 30px;
	padding: 3px 10px;
 }
 #usertoname {border-radius: 7px;height: 35px;display: inline-block;width:220px;margin-bottom:1px; float: none;}
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
                        <li>
                            <a>System</a>
                        </li>
                        <li>
                            <a>index</a>
                        </li>
                        <li class="active">
                            <strong>设置微信特约商户</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>设置微信特约商户</h5>
							<span style="float:right;">商家信息列表&nbsp;&nbsp;(共：{pg:$totalnum} 条)</span>
                        </div>
                        <div class="ibox-content">
						<div class="alert alert-warning">
						温馨提示：如果你对微信商户平台的 服务商功能=》特约商户管理 功能不够了解，请慎用此功能。<br/>
						{pg:if empty($sub_mchidarr)}
						  <div>必须配置特约子商户号才能使用此功能，请到到 支付配置中配置.</div>
						{pg:/if}
						<div>使用此功能请配置好支付配置相关项。</div>
						 </div>

						 	<div class="form-group input-group"  id="myFormAct">
							 <form method="get" action="">
								<span><label class="font-noraml">商户名称筛选：</label>
									<select class="form-control m-b" style="width:200px;display:inline-block;float:none;height:auto;" onchange="qyChaXun(this.value)" id="mid">
									{pg:if !empty($merInfos)}
									<option value="0">请选择</option>
									{pg:section name=mvv loop=$merInfos}
									<option value="{pg:$merInfos[mvv].mid}" {pg:if ($mid eq $merInfos[mvv].mid)}selected="selected"{pg:/if}>{pg:$merInfos[mvv].wxname}</option>
									{pg:/section}
									{pg:/if}
									</select></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span><label class="font-noraml">商户账号筛选：</label>
								<select class="form-control m-b" style="width:200px;display:inline-block;float:none;height:auto;" onchange="qyChaXun(this.value)" id="midd">
									{pg:if !empty($merInfos)}
									<option value="0">请选择</option>
									{pg:section name=mvv loop=$merInfos}
									<option value="{pg:$merInfos[mvv].mid}" {pg:if ($mid eq $merInfos[mvv].mid)}selected="selected"{pg:/if}>{pg:$merInfos[mvv].username}</option>
									{pg:/section}
									{pg:/if}
									</select></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<span><label class="font-noraml">商户账号：</label>
									<input type="text" value="{pg:$uname}" name="uname" class="input form-control"   placeholder="输入商户账号筛选" id="usertoname">
									</span>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<a class="btn btn-primary" style="width:70px;" onclick="qyChaXun()">查 询</a>
						
									</form>
							</div>

                            <table class="footable table table-stripped" data-page-size="30" id="listfootable">
                                <thead>
                                <tr>
									<th style="width: 120px;">选为特约商家</th>
									<th>Mid号</th>
									<th>特约子商户号</th>
									<th>商户名称</th>
									<th data-hide="phone">商户账号</th> 
									<th data-hide="phone">Appid</th>
									<th data-hide="phone">Mchid</th>
									<th data-hide="phone">银行卡</th>
								   </tr>
                                </thead>
								  <tbody>
									{pg:if !empty($merInfo)}
									 {pg:section name=vv loop=$merInfo}
									  <tr>
									    <td style="padding-top:12px;" class="ptd"><input type="checkbox" {pg:if $merInfo[vv].proxymid eq $_mid} checked="checked" {pg:/if} data-type='weixin' class="i-checks"></td>
									   <td class="midnum">{pg:$merInfo[vv].mid}</td>
									   <td class="wxsubmchid">{pg:$merInfo[vv].wxsubmchid}</td>
									      <td class="prelative"><span class="wxname">{pg:$merInfo[vv].wxname}</span><input type="text" class="form-control" placeholder="请输入商户名称">&nbsp;&nbsp;&nbsp;<span class="tips"><i class="fa fa-edit"></i><span>保存修改</span></span>
										</td>
									   
									   <td>{pg:$merInfo[vv].username}</td>
									   <td>{pg:$merInfo[vv].wx_appid}</td>
									   <td>{pg:$merInfo[vv].wx_mchid}
									   </td>
									   <td><a class="btn btn-primary"  onclick="lookBanck({pg:$merInfo[vv].mid})">查看信息</a></td>
									  </tr>
									 {pg:/section}
									{pg:else}
										   <tr class="widget-list-item"><td colspan="8">暂无商家信息</td></tr>
									{pg:/if}
								   </tbody> 
                            </table>

							<div id="editable_paginate" class="dataTables_paginate paging_simple_numbers">
                                <ul class="pagination pull-right"></ul>
							</div>

                        </div>
                    </div>
					{pg:$pagebar}
                </div>
            </div>
        </div>

			
            </div>
        </div>

	{pg:include file="$tplHome/System/public/footer.tpl.php"}

		<div class="modal inmodal" tabindex="-1"  id="submhid_Setting">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
                    <button type="button" class="close _close"><span>×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">选择子商户</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="wxActionBox" class="wxpay_box">
							<div class="form-group">
								<label>选择子商户：</label>
								<select class="form-control" id="submhid" style="width:80%">
								 	{pg:if !empty($sub_mchidarr)}
									 {pg:section name=vv loop=$sub_mchidarr}
									 <option value="{pg:$sub_mchidarr[vv]}">{pg:$sub_mchidarr[vv]}</option>
									 {pg:/section}
									 {pg:/if}
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="button" class="btn btn-primary btn-confirm" onclick="ProxyedMe();">确定</button>
                    <button type="button" class="btn btn-white _close">关闭</button>
                </div>
			</div>
		</div>
	</div>

	<div class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true" id="hkbankset">
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
								<label>开卡人手机号：</label>
								<p id="phone"></p>
							</div>

							<div class="form-group">
								<label>开卡人身份证号：</label>
								<p id="identitycode"></p>
							</div>

						</div>
					</div>
				</div>
				<div class="modal-footer">   
                    <button type="button" class="btn btn-primary _close">关闭</button>
                </div>
				</form>
			</div>
		</div>
	</div>

</body>
<script  type="text/javascript">
var sdata={};
var nosub_mchid=false;
var obj=null
{pg:if empty($sub_mchidarr)}
var nosub_mchid=true;
{pg:/if}

 $(document).ready(function(){
	$('#listfootable').footable();
	 $('.i-checks').iCheck({
           checkboxClass: 'icheckbox_square-green',
           radioClass: 'iradio_square-green',
        });

		$('.i-checks').on('ifChanged', function(){
			var isselect=0;
			if($(this).is(':checked')){
				 isselect = 1;
			}else{
				 isselect = 0;
			}
			var s_mid=0;
			s_mid=$(this).parents('.ptd').siblings('.midnum').text();
			obj=$(this).parents('.ptd').siblings('.wxsubmchid');
			s_mid=$.trim(s_mid);
			sdata={ischeck:isselect,mid:s_mid,submhid:''};
			if(isselect==0){
			    $.post('?m=System&c=pay&a=isproxyed',sdata,function(ret){
					obj.text('');
					sdata={};
					$('#submhid_Setting').hide();
					$('.modal-backdrop').remove();
				 },'JSON');
			}else{
                if(nosub_mchid){
				   $(this).prop("checked", false);
				   swal({title: "温馨提示",text:'您没有配置特约子商户号',type: "error"});
				}else{
				 $('body').append('<div class="modal-backdrop in"></div>');
				 $('#submhid_Setting').show();
				}
			}
			return false;
		});
	});

	 $('#listfootable .prelative .tips').click(function(){
	if($(this).hasClass('fedit')){
	   var mid= $(this).parent().siblings('.midnum').text();
	   mid=parseInt($.trim(mid));
	   var vv=$(this).siblings('.form-control').val();
	   vv=$.trim(vv);
	   if(!vv){
	      swal({title: "温馨提示",text:'没填写内容！',type: "error"});
		  return false;
	   }else{
		  var _this= $(this);
	     $.post('?m=System&c=index&a=mdfyName',{mid:mid,wxname:vv},function(ret){
		    if(!ret.error){
			 _this.siblings('.wxname').text(vv);
			 }else{
			    swal({title: "温馨提示",text:'修改失败！',type: "error"});
			 }
	   _this.siblings('.wxname').show();
	   _this.siblings('.form-control').hide();
	   _this.find('span').hide();
	   _this.removeClass('fedit');
		 },'JSON');
	   }
	}else{
	   $(this).siblings('.wxname').hide();
	   var wxname=$(this).siblings('.wxname').text();
	   $(this).siblings('.form-control').val(wxname).show();
	   $(this).find('span').show();
	   $(this).addClass('fedit');
	}
 });
   
 function ProxyedMe(){
	 var submhid=$.trim($('#submhid').val());
	 sdata.submhid=submhid;
	 $.post('?m=System&c=pay&a=isproxyed',sdata,function(ret){
		sdata={};
		swal({title: "温馨提示",text:'设置成功',type: "success"});
		obj.text(submhid);
		obj=null;
		$('#submhid_Setting').hide();
		$('.modal-backdrop').remove();
	 },'JSON');
    
 }
 	$("#submhid_Setting ._close").click(function(){
		sdata={};
	  $('#submhid_Setting').hide();
	  $('.modal-backdrop').remove();
	});

function qyChaXun(middd){
   if(typeof(middd)!='undefined'){
	 $('#usertoname').val('');
	 var qyStr=$('form').serialize();
     mid=parseInt(middd);
   }else{
	   var qyStr=$('form').serialize();
	   var mid=$('#mid').val();
	   mid=parseInt(mid);
	   var midd=$('#midd').val();
	   midd=parseInt(midd);
	   if(midd>0){
		 mid=midd;
	   }
   }
   mid=mid >0 ? mid :0;

   var furl='http://'+window.location.host+'/merchants.php?m=System&c=index&a=affiliate&mid='+mid+'&';
   window.location.href=furl+qyStr;
}

function lookBanck(mid){
  $.post('/merchants.php?m=System&c=index&a=getCashierBank',{midd:mid},function(rets){
	  rets.error=parseInt(rets.error);
     if(!rets.error){
	    $('#new_bank_box #banckname').text(rets.data.bankname);
		$('#new_bank_box #bankcardnumm').text(rets.data.bankcardnum);
		$('#new_bank_box #banktruename').text(rets.data.banktruename);
		$('#new_bank_box #phone').text(rets.data.phone);
		$('#new_bank_box #identitycode').text(rets.data.identitycode);
		$('#hkbankset').show();
		$('body').append('<div class="modal-backdrop in"></div>');
	 }else{
	    swal("温馨提示",'此商家没有配置线下汇款银行卡信息' , "error");
	 }
  },'JSON');
}
	 $('#hkbankset ._close').click(function(){
		$('#hkbankset').hide();
		$('.modal-backdrop').remove();;
		$('#new_bank_box p').html('');
	 });
</script>
</html>