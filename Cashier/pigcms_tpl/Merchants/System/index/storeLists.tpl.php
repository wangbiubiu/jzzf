<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 | 店铺列表</title>
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
 #table-list-body .btn-primary{padding:3px;margin-bottom:0px;margin-left:7px;}
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
                            <a>index</a>
                        </li>
                        <li class="active">
                            <strong>所有店铺列表</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	<div class="col-lg-12">
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
            	    <div class="ibox float-e-margins">
            	        <div class="ibox-title clearfix">
						 <h1 class="realtime-title">店铺信息列表&nbsp;&nbsp;(共：{pg:$totalnum} 条)</h1>
            	     </div>
<div class="ibox-content"> 
   <nav class="ui-nav clearfix"> 
   </nav> 
   <div class="app__content js-app-main page-cashier">
    <div>
      <div class="cashier-realtime"> 
       <div class="realtime-title-block clearfix"> 
        
       </div> 
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
            <th data-hide="phone">店铺名称</th>
            <th data-hide="phone">店铺地址</th> 
            <th data-hide="phone">店铺电话</th>
			<th data-hide="phone">状态</th>
			<th data-hide="phone">wap显示状态</th>
           </tr>
          </thead>

          <tbody id="table-list-body" class="js-list-body-region">
			{pg:if !empty($storesInfo)}
			 {pg:section name=vv loop=$storesInfo}
			  <tr class="widget-list-item">
			   <td class="mid">{pg:$storesInfo[vv].mid}</td>
			   <td class="prelative"><span class="wxname">{pg:$storesInfo[vv].wxname}</span>
			 </td>
			   <td>{pg:$storesInfo[vv].username}{pg:if $storesInfo[vv].isadmin eq 1}<br/>(此后台关联收银平台账号){pg:/if}</td>
			   <td>{pg:$storesInfo[vv].business_name}{pg:$storesInfo[vv].branch_name}
			   </td>
			   <td>{pg:$storesInfo[vv].provincename}{pg:$storesInfo[vv].cityname}{pg:$storesInfo[vv].districtname}{pg:$storesInfo[vv].address}</td>
			   <td>{pg:$storesInfo[vv].telephone}
			   </td>
			   <td>{pg:if $storesInfo[vv].available_state eq 3}<font color="green">已通过</font>
			   {pg:elseif $storesInfo[vv].available_state gt 3 OR $storesInfo[vv].available_state eq 1}<font color="red">审核失败</font>
			   {pg:elseif $storesInfo[vv].available_state eq 0 OR $storesInfo[vv].available_state eq 2}<font color="red">审核中</font>
			   {pg:/if}
			   </td>
			   <td><span>{pg:if $storesInfo[vv].isshow eq 0}<font color="red">不显示</font>{pg:elseif $storesInfo[vv].isshow gt 0}<font color="green">显&nbsp;&nbsp;示</font>{pg:/if}</span><button class="btn btn-primary" data-sid={pg:$storesInfo[vv].id}>更新状态</button> </td>
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
	{pg:include file="$tplHome/System/public/footer.tpl.php"}
</body>
<script type="text/javascript">
 $('#table-list-body .btn-primary').click(function(){
	 var stoid=$(this).data("sid");
	  var __this= $(this);
	 if(stoid){
	   $.post('?m=System&c=index&a=mdfysShow',{sid:stoid},function(ret){
		  if(!ret.error){
			   if(ret.data==1){
			      __this.siblings('span').html('<font color="green">显&nbsp;&nbsp;示</font>');
			   }else{
			      __this.siblings('span').html('<font color="red">不显示</font>');
			   }
			 }else{
			    swal({title: "温馨提示",text:'修改失败！',type: "error"});
			 }

		 },'JSON');
	 }
 });
  function SelectByMid(vv,typ){
	var furl=window.location.href;
	if(furl.indexOf('mid=')>0){
	   furl=furl.replace(/mid=\d+/,'mid='+vv);
	   furl=furl.replace(/typ=\d+/,'typ='+typ);
	   window.location.href=furl;
	}else{
       window.location.href=furl+'&mid='+vv+'&typ='+typ;
	}
 }

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

   var furl='http://'+window.location.host+'/merchants.php?m=System&c=index&a=storeLists&mid='+mid+'&';
   window.location.href=furl+qyStr;
}
</script>
</html>