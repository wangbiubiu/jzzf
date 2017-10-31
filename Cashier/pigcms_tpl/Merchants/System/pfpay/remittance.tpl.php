<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 | 线下汇款</title>
	{pg:include file="$tplHome/System/public/header.tpl.php"}
	<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	<script src="{pg:$smarty.const.RlStaticResource}plugins/js/datapicker/bootstrap-datepicker.js"></script>
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
	.ibox-title .nav li{float:left;}
	.ibox-title .nav li{margin-right:55px;}
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
                            <strong>线下汇款列表</strong>
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
						 <ul class="nav"> 
							<li><button id="pop_addhk" class="btn btn-primary"><i class="fa fa-plus"></i>添加汇款记录</button></li> 
							<li> <h2 class="realtime-title">线下汇款订单列表&nbsp;&nbsp;<span style="font-size:14px;">(共：{pg:$totalnum} 条)<span></h2></li> 
						</ul>
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
			<th>汇款金额</th> 
			<th data-hide="phone">汇款日期</th> 
			<th data-hide="phone">查看对账</th> 
			<th data-hide="phone">银行卡</th>
			<th data-hide="phone">账号来源</th>
			<th data-hide="phone">操作</th>
           </tr>
          </thead>

          <tbody id="table-list-body" class="js-list-body-region">
			{pg:if !empty($merRemittance)}
			 {pg:section name=vv loop=$merRemittance}
			  <tr class="widget-list-item">
			   <td class="mid">{pg:$merRemittance[vv].mid}</td>
			   <td class="prelative"><span class="wxname">{pg:$merRemittance[vv].wxname}</span>
			 </td>
			   <td>{pg:$merRemittance[vv].username}{pg:if $merRemittance[vv].isadmin eq 1}<br/>(此后台关联收银平台账号){pg:/if}</td>
			   <td>{pg:$merRemittance[vv].money} / 元</td>
			   <td>{pg:$merRemittance[vv].paytime|date_format:"%Y-%m-%d"}</td>
			   <td><a class="btn btn-primary" href="/merchants.php?m=System&c=pfpay&a=platformpay&mid={pg:$merRemittance[vv].mid}">对账信息</a></td>
			   <td><a class="btn btn-primary"  onclick="lookBanck({pg:$merRemittance[vv].mid})">查看信息</a></td>
			   	<td>{pg:if $merRemittance[vv].source eq 1}
			       微信营销系统
				   {pg:elseif $merRemittance[vv].source eq 2}
				   微店系统
				   {pg:elseif $merRemittance[vv].source eq 3}
				   o2o系统
				   {pg:else}
				   本站注册{pg:if $merRemittance[vv].isadmin eq 1}<br/>(此后台关联收银平台账号){pg:/if}
				   {pg:/if}
			   </td>
			   <td><a class="btn btn-primary"  onclick="delRecord({pg:$merRemittance[vv].id})">删 除</a></td>
			  </tr>
			 {pg:/section}
			{pg:else}
		   		   <tr class="widget-list-item"><td colspan="8">暂无商家汇款信息</td></tr>
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

	<div class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true" id="hkRecord">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<form action="" method="post" enctype="multipart/form-data">
				<div class="modal-header">
                    <button type="button" class="close _close"><span>×</span><span class="sr-only">Close</span></button>
                    
                    <h4 class="modal-title">添加汇款信息</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="pay_bank_box" class="wxpay_box">
							<div class="form-group">
								<label>汇款金额：</label>
								<input type="text" placeholder="汇款金额（元）必填" value="" name="money" class="form-control"  onkeyup="value=value.replace(/[^1234567890\.]+/g,'')">
							</div>
							<div class="form-group">
								<label>汇款日期：</label>
								<input type="text" value="" name="ptime" class="input-sm form-control" id="datepicker" placeholder="选择日期">
							</div>

							<div class="form-group">
								<label>汇款商家账号：</label> （如果您不想选可以在下面输入框填上）
								<select class="form-control m-b"  name="mid" id="miidd">
									{pg:if !empty($merInfos)}
									<option value="0">请选择</option>
									{pg:section name=mvv loop=$merInfos}
									<option value="{pg:$merInfos[mvv].mid}" {pg:if ($mid eq $merInfos[mvv].mid)}selected="selected"{pg:/if}>{pg:$merInfos[mvv].username}</option>
									{pg:/section}
									{pg:/if}
								</select>
							</div>

							<div class="form-group">
								<label>汇款商家账号：</label>（如果都填了，以上面选择为准）
								<input type="text" placeholder="汇款商家账号" value="" name="meraccount" class="form-control">
							</div>

						</div>
					</div>
				</div>
				<div class="modal-footer">   
                    <button type="button" class="btn btn-primary _close" >取消</button>
					<button type="button" class="btn btn-primary btn-confirm-b">确定</button>
                </div>
				</form>
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
	$('#datepicker').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		format: "yyyy-mm-dd",
		autoclose: true
	});
  var istopost=false;
 $('#hkRecord .btn-confirm-b').click(function(){
	if(istopost){
	   return false;
	}
	var money = $("#pay_bank_box input[name='money']").val();
	money=$.trim(money);
	if(!money){
	   swal("温馨提示",'金额必须填上！' , "error");
	   return false;
	}
	var ptime = $("#pay_bank_box input[name='ptime']").val();
	ptime=$.trim(ptime);
	if(!ptime){
	   swal("温馨提示",'汇款日期请选择一下！' , "error");
	   return false;
	}

	var miidd=$.trim($("#miidd").val());
	miidd=parseInt(miidd);
	if(!(miidd >0)){
	   var meraccount=$("#pay_bank_box input[name='meraccount']").val();
	   meraccount=$.trim(meraccount);
	   if(!meraccount){
	   	   swal("温馨提示",'汇款商家账号必须填写上！' , "error");
		   return false;
	   }
	}
   var datas=$('#hkRecord form').serialize();
  istopost=true;
  $.post('/merchants.php?m=System&c=pfpay&a=SaveRecord',datas,function(rets){
	  istopost=false;
	  rets.error=parseInt(rets.error);
     if(!rets.error){
        	$('#hkRecord').hide();
			$('.modal-backdrop').remove();;
			$('#pay_bank_box input').val('');
			$('#pay_bank_box select').val('0');
			swal("温馨提示",rets.msg , "success");
			setTimeout(function(){window.location.reload()},1500);
	 }else{
	    swal("温馨提示",rets.msg , "error");
	 }
  },'JSON');

 });

 function qyChaXun(middd){
   if(typeof(middd)!='undefined'){
	 $('#usertoname').val('');
	 var qyStr=$('#myFormAct form').serialize();
     mid=parseInt(middd);
   }else{
	   var qyStr=$('#myFormAct form').serialize();
	   var mid=$('#mid').val();
	   mid=parseInt(mid);
	   var midd=$('#midd').val();
	   midd=parseInt(midd);
	   if(midd>0){
		 mid=midd;
	   }
   }
   mid=mid >0 ? mid :0;

   var furl='http://'+window.location.host+'/merchants.php?m=System&c=pfpay&a=remittance&mid='+mid+'&';
   window.location.href=furl+qyStr;
}
  
 function delRecord(idd){
   idd=parseInt(idd);
   if(idd>0){
     if(confirm('您确定要删除吗？')){
	    $.post('/merchants.php?m=System&c=pfpay&a=delRecord',{idd:idd},function(rets){
		  swal({
			title: "温馨提示",
				text: rets.msg,
				type: "info",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "确定",
				cancelButtonText: "取消",
				closeOnConfirm: false
			}, function () {
				window.location.reload();
    		 });
		},'JSON');
	 }
   }
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

 $('#pop_addhk').click(function(){
     $('#pay_bank_box').val('');
	 $('body').append('<div class="modal-backdrop in"></div>');
	 $('#hkRecord').show();
 });

 $('#hkRecord ._close').click(function(){
	$('#hkRecord').hide();
	$('.modal-backdrop').remove();;
	$('#pay_bank_box input').val('');
	$('#pay_bank_box select').val('0');
 });
 $('#hkbankset ._close').click(function(){
	$('#hkbankset').hide();
	$('.modal-backdrop').remove();;
	$('#new_bank_box p').html('');
 });
</script>
</html>