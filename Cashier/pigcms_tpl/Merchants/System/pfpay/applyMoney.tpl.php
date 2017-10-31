
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>收银台 | 对账申请</title>
	 {pg:include file="$tplHome/System/public/header.tpl.php"}
	<!-- DROPZONE -->
	<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
	
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	<script src="{pg:$smarty.const.RlStaticResource}plugins/js/datapicker/bootstrap-datepicker.js"></script>
	<style>
		.ibox-title h5 {
  			margin: 10px 0 0px;
		}
		select.form-control {
  			height: 35px;
  			line-height: 35px;
		}
		.float-e-margins .btn-info{
			margin-bottom:0px;
			padding:3px;
		}
		.fa-paste{
			margin-right:7px;
			padding: 0px;
		}
		.dz-preview{
			display:none;
		}
	#usertoname {border-radius: 7px;display: inline-block;float: none;height: 35px;margin-bottom: 1px;width: 220px;}
	.icon_edit .fa-pencil{ font-size: 25px; margin-left: 7px;}
	.frm_control_group::after{padding-bottom:0px;}
	</style>
</head>

<body>

    <div id="wrapper">
		{pg:include file="$tplHome/System/public/leftmenu.tpl.php"}
        <div id="page-wrapper" class="gray-bg">
        {pg:include file="$tplHome/System/public/top.tpl.php"}
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>对账申请</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>pfpay</a>
                        </li>
                        <li class="active">
                            <strong>对账申请</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	<div class="col-lg-10">
            	    <div class="ibox float-e-margins">
            	        <div class="ibox-title clearfix">
            	            <h5 style="margin: 10px 0 0px;">对账申请</h5>
            	        </div>

            	        <div class="ibox-content">
							<div class="alert alert-warning">
							   这里可以修改商户对账申请处理的进程，点击申请状态的铅笔标识来做修改状态<br/>
							   以便商家在收银台申请对账页面及时看到他的申请处理状况
								</div>	
							<div class="form-group input-group"  id="myFormAct">
							 <form method="get" action="">
								<span><label class="font-noraml">商户名称筛选：</label>
									<select class="form-control m-b" style="width:200px;display:inline-block;float:none;" onchange="qyChaXun(this.value)" id="mid">
									{pg:if !empty($merInfos)}
									<option value="0">请选择</option>
									{pg:section name=mvv loop=$merInfos}
									<option value="{pg:$merInfos[mvv].mid}" {pg:if ($mid eq $merInfos[mvv].mid)}selected="selected"{pg:/if}>{pg:$merInfos[mvv].wxname}</option>
									{pg:/section}
									{pg:/if}
									</select></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span><label class="font-noraml">商户账号筛选：</label>
								<select class="form-control m-b" style="width:200px;display:inline-block;float:none;" onchange="qyChaXun(this.value)" id="midd">
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

						<table  class="table table-striped table-bordered table-hover" data-page-size="20" style="padding: 0px;">
						<thead class="js-list-header-region tableFloatingHeaderOriginal">
							<tr class="widget-list-header">
							<th data-hide="phone" width="5%">编号</th>
							<th data-hide="phone">商家名称</th>
							<th data-hide="phone">商家账号</th>
							<th data-hide="phone" width="15%">标题</th>
							<th data-hide="phone" width="15%">申请时间段</th>
							<th data-hide="phone" width="15%">申请状态</th>
							<th data-hide="phone">申请说明</th>
							<th data-hide="phone" width="12%">申请添加时间</th>
							</tr>
							</thead>
							<tbody class="js-list-body-region" id="table-list-body">
							{pg:if !empty($applyRecord)}
							 {pg:foreach item=row from=$applyRecord}
            	                <tr>
            	                    <td>{pg:$row.id}</td>
									<td>{pg:if !empty($row.wxname)}{pg:$row.wxname}{pg:else}{pg:$row.weixin}{pg:/if}</td>
									<td>{pg:$row.username}</td>
									<td>{pg:$row.atitle}</td>
									<td>{pg:$row.starttime|date_format:"%Y-%m-%d"} &nbsp; 到 &nbsp; {pg:$row.endtime|date_format:"%Y-%m-%d"}</td>
									<td><span>{pg:$statusStr[$row.status]}</span>

									<a data-actionid="{pg:$row.id}" data-actmid="{pg:$row.mid}" href="javascript:;" class="icon_edit js_modify_status" title="状态修改"><i class="fa fa-pencil"></i></a>
									</td>

            	                    <td>{pg:$row.remark}</td>
									<td>{pg:$row.addtime|date_format:"%Y-%m-%d %H:%M:%S"}</td>
            	                </tr>
								{pg:/foreach}
								{pg:else}
								<tr><td colspan="6">您还没有对账申请记录</td></tr>
								{pg:/if}
								</tbody> 
            	            </table>

            	        </div>
            	    </div>
					{pg:$pagebar}
            	</div>
            </div>
        </div>
	{pg:include file="$tplHome/System/public/footer.tpl.php"}
        </div>
    </div>

<div class="popover" id="changeStatus">
    <div class="popover_inner">
		<div class="popover_content">
		<p style="font-weight: bold;color: #22911B;text-align: center;">对账申请处理状态</p>
		<div class="pop_store">
		
			<div class="frm_control_group">
				<div class="frm_controls">
					<select class="form-control m-b" id="astatus" style="margin:10px 0 0 20px">
					<option value="0">未处理</option>
					<option value="1">已查看</option>
					<option value="2">核算中</option>
					<option value="3">核对完成</option>
					<option value="4">准备汇款</option>
					<option value="5">已添加汇款记录</option>
					<option value="6">已处理完成</option>
					</select>
				</div>
			</div>
		
		</div>
		</div>

		<div class="popover_bar">
			<button type="button" class="btn btn-primary btn_confirm">确 定</button>&nbsp;&nbsp;&nbsp;
			<button type="button" class="btn btn-white c-close">取 消</button>
		</div>

    </div>
    <i class="popover_arrow popover_arrow_out"></i>
    <i class="popover_arrow popover_arrow_in"></i>
</div>

    <script type="text/javascript">
		 function qyChaXun(middd){
		   if(typeof(middd)!='undefined'){
			 var qyStr='';
			 $('#usertoname').val('');
			 
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

		   var furl='http://'+window.location.host+'/merchants.php?m=System&c=pfpay&a=applyMoney&mid='+mid;
		   if(qyStr){
			 furl=furl+'&'+qyStr;
		   }
		   window.location.href=furl;
		}   
	function delofItem(idd,obj){
	 	swal({
		  title: "温馨提示",
		  text: "您确认要删除此项吗？",
		  type: "success"
		 }, function () {
		     $.post('?m=User&c=pfpay&a=delItem',{idd:idd},function(ret){
			     if(!ret.error){
				   $(obj).parent('td').parent('tr').remove();
				 }else{
				 	swal({
					  title: "温馨提示",
					  text: "删除失败！",
					  type: "error"
					 });
				 }
			 },'JSON');
		});
	}

	String.prototype.toXingStr=function(){
	   var returnStr='';
	   var lenstr=this.length;
	   if(lenstr>4){
	    var xingLen=lenstr-4;
		 for(i=0;i<lenstr;i++){
			if(i<2 || xingLen==0){
			  returnStr+=this.charAt(i);
			}else{
			  returnStr+='*';
			  --xingLen;
			}
		 }
	   }else{
	     for(i=0;i<lenstr;i++){
			  returnStr+='*';
		 }
	   }

        return returnStr;
	}

	 var actid=miid=0,numObj='';
	$(document).on('click',function(e){
		   var target = $(e.target);
		   var statusobj=target.closest(".js_modify_status");
		   if(statusobj.size()!=0){
			   actid=statusobj.data('actionid');
			   miid=statusobj.data('actmid');
			   numObj=statusobj.siblings('span');
			   var offsetpx=statusobj.offset();
			   $('#changeStatus').css('position','absolute').css('left',offsetpx.left-141).css('top',offsetpx.top+5).css('zIndex','100').show();
		     }else if(target.closest("#changeStatus").size()==0){
			    actid=miid=0;numObj='';
		        $("#changeStatus").hide();
		   }
		});

		$("#changeStatus .c-close").click(function(){
			  actid=miid=0;numObj='';
		     $("#changeStatus").hide();
		});

		$("#changeStatus .btn_confirm").click(function(){
			var datas = {id:actid,mid:miid};
			var astatus=$('#astatus').val();
			astatus=parseInt(astatus);
			datas.astatus=astatus;
		    if(actid>0){
		     $("#changeStatus").hide();
				actid=miid=0;
				$.ajax({
				url: "?m=System&c=pfpay&a=changeStatus",
				type: "POST",
				dataType: "json",
				data:datas,
				success: function(res){
					if(!res.error){
						if(numObj){
						     numObj.html(res.data);
						}
						numObj='';
						swal({
							title: "修改成功",
								text: "修改成功",
								type: "success"
							});
					}else{
						swal({
								title: "修改失败",
								text: res.msg,
								type: "error"
							}, function () {
								//window.location.reload();
							});
					}
				}
				});
			}
		});
    </script>

</body>

</html>