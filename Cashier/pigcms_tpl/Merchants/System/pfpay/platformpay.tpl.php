<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 | 平台代支付列表</title>
	{pg:include file="$tplHome/System/public/header.tpl.php"}
	<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/iCheck/custom.css" rel="stylesheet">
	<script src="{pg:$smarty.const.RlStaticResource}plugins/js/footable/footable.all2.min.js"></script>
	<script src="{pg:$smarty.const.RlStaticResource}plugins/js/iCheck/icheck.min.js"></script>
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	<script src="{pg:$smarty.const.RlStaticResource}plugins/js/datapicker/bootstrap-datepicker.js"></script>
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
   #datepicker  input,#usertoname {border-radius: 7px;height: 35px;display: inline-block;width:220px;margin-bottom:1px; float: none;}
   #datepicker{margin-top:15px;}
   .dzbtn{padding: 3px 5px;}
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
                            <a>pfpay</a>
                        </li>
                        <li class="active">
                            <strong>平台代支付列表</strong>
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
                            <h5>平台代支付列表</h5>
							<span class="pull-right" style="margin-right: 15px;">总收款：{pg:$income} 元 &nbsp;&nbsp;总退款：{pg:$refund} 元&nbsp;&nbsp;总结余：{pg:$surplus} 元
							</span>
                        </div>
                        <div class="ibox-content">
						<div class="alert alert-warning">
						温馨提示：请配置好微信支付配置
						 </div>
						 		<div class="form-group input-group"  id="myFormAct">
								 <form method="get" action="">
								    <span><label class="font-noraml">支付类型选择：</label>
										<select class="form-control m-b" style="width:200px;display:inline-block;float:none;height:auto;" onchange="qyChaXun()" name="pty">
										<option value="0">请选择</option>
										<option value="1" {pg:if ($paytype eq 1)}selected="selected"{pg:/if}>微信支付</option>
										<option value="2" {pg:if ($paytype eq 2)}selected="selected"{pg:/if}>支付宝支付</option>
										</select></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
										
										<div id="datepicker" class="input-daterange">
											<label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
											<input type="text" value="{pg:$starttime}" name="stime" class="input-sm form-control" id="datestart" placeholder="开始时间">
											&nbsp;<span> T O </span>&nbsp; 
											<input type="text" value="{pg:$endtime}" name="etime" class="input-sm form-control" id="dateend" placeholder="结束时间"> 
											&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" style="width:70px;" onclick="qyChaXun()">查 询</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!--<a class="btn btn-primary"  style="width:80px;" href="javascript:;" onclick="exportExcel();">导 出</a>-->
										</div>

										</form>
								</div>
                            <table class="footable table table-stripped" data-page-size="30" id="listfootable">
                                <thead>
                                <tr>
									<th><label style="cursor: pointer;"><input type="checkbox"  class="i-checks" id="selectAll">&nbsp;&nbsp;全选</label></th>
									<th>商户名称</th>
									<th data-hide="phone">商户账号</th>
									<th>付款人</th>
									<th data-hide="phone">付款时间</th>
									<th data-hide="phone">付款金额(元)</th>
									<th data-hide="phone">支付类型</th>
									<th data-hide="phone">支付/退款情况</th>
									<th data-hide="phone">对账情况</th>
								   </tr>
                                </thead>
								  <tbody>
									{pg:if !empty($merOderInfo)}
									 {pg:section name=vv loop=$merOderInfo}
									  <tr>
									    <td class="selecttd">
										{pg:if $merOderInfo[vv].state != 2}
										<input type="checkbox" class="i-checks" value="{pg:$merOderInfo[vv].id}">
										{pg:else}
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										{pg:/if}&nbsp;
										{pg:$merOderInfo[vv].id}
										</td>
									    <td>{pg:$merOderInfo[vv].merwxname}</td>
									    <td>{pg:$merOderInfo[vv].username}</td>
									    <td>{pg:$merOderInfo[vv].payneme}</td>
									   <td>{pg:$merOderInfo[vv].paytimestr}</td>
									   <td>{pg:$merOderInfo[vv].goods_price}</td>
									   <td>{pg:if $merOderInfo[vv].pay_way=='weixin'}微信支付{pg:elseif $merOderInfo[vv].pay_way=='alipay'}支付宝支付{pg:else}其他支付{pg:/if}</td>
									   <td>已支付 / {pg:$merOderInfo[vv].refundstr}</td>
									   <td>{pg:$merOderInfo[vv].statestr}{pg:if $merOderInfo[vv].state != 2}&nbsp;&nbsp;&nbsp;<a class="btn btn-primary dzbtn" onclick="checkOrder({pg:$merOderInfo[vv].id},this);">点击对账</a>{pg:/if}</td>
									  </tr>
									 {pg:/section}
									  <tr class="widget-list-item"><td colspan="10"><a class="btn btn-primary" onclick="checkOrder()" style="margin-top:10px;">选择订单后点击这里批量对账</a></td></tr>
									{pg:else}
										   <tr class="widget-list-item"><td colspan="10">暂无平台代付商家支付信息</td></tr>
									{pg:/if}
								   </tbody> 
                            </table>

                        </div>
                    </div>
					 {pg:$pagebar}
                </div>
            </div>
        </div>

			
            </div>
        </div>




	{pg:include file="$tplHome/System/public/footer.tpl.php"}
</body>
<script  type="text/javascript">
 $(document).ready(function(){
	     $('.i-checks').iCheck({
              checkboxClass: 'icheckbox_square-green',
              radioClass: 'iradio_square-green'
          });
		$('#datepicker .input-sm').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		format: "yyyy-mm-dd",
		autoclose: true
	});
 });

	$('#selectAll').on('ifChecked ifUnchecked', function(event){
		if (event.type == 'ifChecked') {
			$('#listfootable tbody .i-checks').iCheck('check');
		} else {
			$('#listfootable tbody .i-checks').iCheck('uncheck');
		}
	});

	/*$('#listfootable tbody .i-checks').on('ifUnchecked', function(event) {
		//$('#selectAll').iCheck('uncheck');
	});*/

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
   var furl='http://'+window.location.host+'/merchants.php?m=System&c=pfpay&a=platformpay&mid='+mid+'&';
   window.location.href=furl+qyStr;
}

/***更新对账****/
function checkOrder(oid,obj){
	var oids='';
   if(typeof(oid)=='undefined'){

      $('#listfootable tbody .i-checks').each(function(){
		  if($(this).is(':checked')){
			oids+=$.trim($(this).val())+',';
		  }
	  });
	  if(!oids){
	      swal("温馨提示", '没有可更新订单' , "error");
	  }
   }else{
      oids=oid;
   }
   if(oids){
      $.post('/merchants.php?m=System&c=pfpay&a=mdystat',{oids:oids},function(ret){
		 if(!ret.error){
		    if(typeof(obj)=='object'){
			   $(obj).siblings('font').attr('color','green').text('已对账');
			   $(obj).parent().siblings('.selecttd').find('div').remove();
			   $(obj).remove();
			}else{
			   window.location.reload();
			}
		 }else{
		     swal("温馨提示", '对账状态更新失败！' , "error");
		 }
	  },'JSON');
   }
}
</script>
</html>