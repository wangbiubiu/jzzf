<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 | 用户管理</title>
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
                            <strong>用户列表</strong>
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
		    <th>gid号</th>
			<th>角色名称</th>
            <th data-hide="phone">角色等级</th>
            <th data-hide="phone">操作</th>
           </tr>
          </thead>

          <tbody id="table-list-body" class="js-list-body-region">
			{pg:if !empty($rlgroup)}
			 {pg:section name=vv loop=$rlgroup}
			  <tr class="widget-list-item">
			   <td class="mid">{pg:$rlgroup[vv].gid}</td>
			   <td class="prelative"><span class="wxname">{pg:$rlgroup[vv].gname}</span>
			 </td>
			   <td>{pg:$rlgroup[vv].level}</td>

			   <td>
			   {pg:if $rlgroup[vv].gid neq 1}
			   <button class="btn btn-primary" data-sid={pg:$rlgroup[vv].gid}>编辑权限</button>
			   {pg:else}
			     <span style="color:red;">超级管理员</span>
			   {pg:/if}
			   </td>
			  </tr>
			 {pg:/section}
			{pg:else}
		   		   <tr class="widget-list-item"><td colspan="5"></td></tr>
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

</script>
</html>