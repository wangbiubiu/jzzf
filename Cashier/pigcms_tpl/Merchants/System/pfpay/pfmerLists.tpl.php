<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 | 商家列表</title>
	{pg:include file="$tplHome/System/public/header.tpl.php"}
	<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
	<style type="text/css">
	#table-list-body .fa-edit{ color: #3DA142;font-size: 20px;}
	#table-list-body .tips{ color: #3DA142;cursor: pointer;}
	#table-list-body .tips span{ display: none;} 
	#table-list-body .prelative .form-control {
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
                            <a href="#">System</a>
                        </li>
                        <li>
                            <a>pfpay</a>
                        </li>
                        <li class="active">
                            <strong>商家列表</strong>
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
            	        <div class="ibox-title clearfix">
						 <h2 class="realtime-title">使用代理支付的商家&nbsp;&nbsp;<span style="font-size:14px;">(共：{pg:$totalnum} 条)<span></h2>
            	     </div>
<div class="ibox-content"> 
   <div class="app__content js-app-main page-cashier">
    <div>
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
      <div class="js-real-time-region realtime-list-box loading">
       <div class="widget-list">
        <div style="position: relative;" class="js-list-filter-region clearfix ui-box">
         <div class="widget-list-filter"></div>
        </div> 
        <div class="ui-box"> 
         <table style="padding: 0px;" data-page-size="20" class="ui-table ui-table-list default no-paging footable-loaded footable"> 
          <thead class="js-list-header-region tableFloatingHeaderOriginal">
           <tr class="widget-list-header">
		    <th>Mid号</th>
			<th>商户名称</th>
            <th data-hide="phone">商户账号</th>
            <th data-hide="phone">微信配置</th>
			<th data-hide="phone">代付类型</th> 
            <th data-hide="phone">来源</th>
			<th data-hide="phone">查看对账</th> 
			<th data-hide="phone">银行卡</th>
           </tr>
          </thead>

          <tbody id="table-list-body" class="js-list-body-region">
			{pg:if !empty($merInfo)}
			 {pg:section name=vv loop=$merInfo}
			  <tr class="widget-list-item">
			   <td class="mid">{pg:$merInfo[vv].mid}</td>
			   <td class="prelative"><span class="wxname">{pg:$merInfo[vv].wxname}</span><input type="text" class="form-control" placeholder="请输入商户名称">&nbsp;&nbsp;&nbsp;<span class="tips"><i class="fa fa-edit"></i><span>保存修改</span></span>
			 </td>
			   <td>{pg:$merInfo[vv].username}{pg:if $merInfo[vv].isadmin eq 1}<br/>(此后台关联收银平台账号){pg:/if}</td>
			   <td>{pg:if $merInfo[vv].configData && $merInfo[vv].configData.weixin && $merInfo[vv].configData.weixin.mchid && $merInfo[vv].configData.weixin.appid}
					已配置
				   {pg:else}
				   未配置
				   {pg:/if}
			   </td>
			   <td>{pg:$merInfo[vv].wxpfpay} &nbsp; {pg:$merInfo[vv].alipfpay}</td>
			   <td>{pg:if $merInfo[vv].source eq 1}
			       微信营销系统
				   {pg:elseif $merInfo[vv].source eq 2}
				   微店系统
				   {pg:elseif $merInfo[vv].source eq 3}
				   o2o系统
				   {pg:else}
				   本站注册{pg:if $merInfo[vv].isadmin eq 1}<br/>(此后台关联收银平台账号){pg:/if}
				   {pg:/if}
			   </td>
			   <td><a class="btn btn-primary" href="/merchants.php?m=System&c=pfpay&a=platformpay&mid={pg:$merInfo[vv].mid}">对账信息</a></td>
			   <td><a class="btn btn-primary"  onclick="lookBanck({pg:$merInfo[vv].mid})">查看信息</a></td>
			  </tr>
			 {pg:/section}
			{pg:else}
		   		   <tr class="widget-list-item"><td colspan="8">暂无商家信息</td></tr>
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
  {pg:$pagebar}
  </div>
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

	{pg:include file="$tplHome/System/public/footer.tpl.php"}
</body>
<script type="text/javascript">
 $('#table-list-body .prelative .tips').click(function(){
	if($(this).hasClass('fedit')){
	   var mid= $(this).parent().siblings('.mid').text();
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

   var furl='http://'+window.location.host+'/merchants.php?m=System&c=pfpay&a=pfmerLists&mid='+mid+'&';
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