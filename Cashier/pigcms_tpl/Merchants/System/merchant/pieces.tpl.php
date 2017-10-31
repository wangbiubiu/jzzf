<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>商户中心 | 进件管理</title> 
{pg:include file="$tplHome/System/public/header.tpl.php"}
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/iCheck/custom.css" rel="stylesheet">
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/footable/footable.all2.min.js"></script>
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
.md_xinxi>input{ padding: 0 10px; background: #4EBE53; border: none; height: 30px; line-height: 30px; text-align: center; color: #FFFFFF; border-radius: 5px;}
.ibox-content{ padding-top:0px;padding-bottom: 60px;}
.widget-list-header th{ text-align: center;border-right: 1px solid #e5e5e5;}
.ui-table.ui-table-list{border-left: 1px solid #e5e5e5;border-top: 1px solid #e5e5e5;}
.widget-list-item>td{text-align: center;height:80px;padding: 0;border-right: 1px solid #e5e5e5;}
.widget-list-item>td p{
    width: 100%;
    height: 60px;
    line-height: 60px;
    margin-bottom: 0px;
}
.widget-list-item>td p:nth-child(2){

    border-top: 1px solid #e5e5e5;
}
.jinjian{ background: #337ab7; height: 35px; line-height: 35px; border: none; border-radius: 5px;}
.jinjian a{ color: #FFFFFF;}
.sc{ background: #ed5565; height: 35px; line-height: 35px;border: none;border-radius: 5px;}
.sc a{ color: #FFFFFF;}
#commonpage{margin-top: 17px; }
</style>

</head>
<body>
	<div id="wrapper">
	{pg:include file="$tplHome/System/public/leftmenu.tpl.php"}
        <div id="page-wrapper" class="gray-bg">
	{pg:include file="$tplHome/System/public/top.tpl.php"}
            <div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>进件管理</h2>
					<ol class="breadcrumb">
						<li><a>User</a></li>
						<li><a>商户中心</a></li>
						<li class="active"><strong>进件管理</strong></li>
					</ol>
				</div>
				<div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<nav class="ui-nav clearfix" style="height: 40px; line-height: 40px; border-bottom: 1px solid #d9e6e9; background: #FFFFFF; padding-left: 10px; border-top: 3px solid #edfbfe;">
								进件管理
							</nav>
							<div class="ibox-content" >
								
								<div class="app__content js-app-main page-cashier" style="padding-top: 10px;">
									<div>
										<!-- 实时交易信息展示区域 -->
                                                                                <form action="?m=System&c=merchant&a=pieces" method="post">
										<div class="cashier-realtime">
											<div class="realtime-title-block clearfix md_xinxi">
                                                                                            <label>商户名称: <input type="text" name="name" placeholder="输入商户名称"></label>
												<input type="submit"></button>
											</div>
										</div>
                                                                                </form>
										<div class="js-real-time-region realtime-list-box loading" style="margin-top: 10px;">
											<div class="widget-list">
												<div class="js-list-filter-region clearfix ui-box"
													style="position: relative;">
													<div class="widget-list-filter"></div>
												</div>
												<div class="ui-box">
													<table class="ui-table ui-table-list" data-page-size="20" style="padding: 0px;">
														<thead class="js-list-header-region tableFloatingHeaderOriginal">
															<tr class="widget-list-header">
																<th>编号</th>
																<th>商户ID</th>
																<th data-hide="phone">商户简称</th>
																<th data-hide="phone">联系人</th>
																<th data-hide="phone">电话</th>
                                                                <th data-hide="phone">支付渠道</th>
                                                                <th data-hide="phone">审核状态</th>
																<th data-hide="phone">操作</th>
															</tr>
														</thead>
														<tbody class="js-list-body-region" id="table-list-body">
                                                                                                          
															{pg: if (!empty($rows))}
                                                            {pg: foreach item=v from=$rows }
															<tr class="widget-list-item">
																<td>{pg:$v.id}</td>
																<td>{pg:$v.mid}</td>
																<td>{pg:$v.company}</td>
																<td>{pg:$v.realname}</td>
                                                                <td>{pg:$v.phone}</td>
                                                                <td>
                                                                    {pg:if ($v.mtype==2)}
                                                                    {pg: if (!empty($v.alipay))}
                                                                    <p>支付宝</p>
                                                                    {pg: /if}
                                                                    {pg: if (!empty($v.wechat))}
                                                                    <p>微信</p>
                                                                    {pg: /if}
                                                                    {pg:else}
                                                                    <p>微信</p>
                                                                    {pg: /if}
                                                                </td>
                                                                <td>
                                                                    {pg:if ($v.mtype==1)}
                                                                    <!--默认状态start-->
                                                                    {pg:if ($v.status==0)}
                                                                    待初审
                                                                    {pg: elseif ($v.status==1)}
                                                                    初审成功并审核中
                                                                    {pg: elseif ($v.status==2)}
                                                                    审核成功
                                                                    {pg:elseif ($v.status==3)}
                                                                    审核失败
                                                                    {pg:elseif ($v.status==4)}
                                                                    初审失败
                                                                    {pg:/if}
                                                                    <!--默认状态end-->
                                                                    {pg:else}
                                                                    {pg: if (!empty($v.alipay))}
                                                                    <!--支付宝状态start-->
                                                                    {pg:if ($v.alipaystatus==0)}
                                                                    <p>待初审</p>
                                                                    {pg: elseif ($v.alipaystatus==1)}
                                                                    <p>初审成功并审核中</p>
                                                                    {pg: elseif ($v.alipaystatus==2)}
                                                                    <p>审核成功</p>
                                                                    {pg:elseif ($v.alipaystatus==3)}
                                                                    <p>审核失败</p>
                                                                    {pg:elseif ($v.alipaystatus==4)}
                                                                    <p>初审失败</p>
                                                                    {pg:/if}
                                                                    <!--支付宝状态end-->
                                                                    {pg: /if}
                                                                    {pg: if (!empty($v.wechat))}
                                                                    <!--微信状态start-->
                                                                    {pg:if ($v.wechatstatus==0)}
                                                                    <p>待初审</p>
                                                                    {pg: elseif ($v.wechatstatus==1)}
                                                                    <p>初审成功并审核中</p>
                                                                    {pg: elseif ($v.wechatstatus==2)}
                                                                    <p>审核成功</p>
                                                                    {pg:elseif ($v.wechatstatus==3)}
                                                                    <p>审核失败</p>
                                                                    {pg:elseif ($v.wechatstatus==4)}
                                                                    <p>初审失败</p>
                                                                    {pg:/if}
                                                                    <!--微信状态end-->
                                                                    {pg: /if}
                                                                    {pg:/if}
                                                                </td>
																<td><!---->
                                                                    {pg:if ($v.mtype==1)}
                                                                    <a href="?m=System&c=merchant&a=seepieces&id={pg:$v.id}"><button class="jinjian" style="color:#ffffff">查看进件</button></a>
                                                                    <button class="btn btn-sm btn-danger delete" data-id="{pg:$v.id}"><strong>删&nbsp;&nbsp;除 </strong></button>
                                                                    {pg: else}
                                                                    {pg: if (!empty($v.alipay))}
                                                                    <p>
                                                                        <a href="?m=System&c=merchant&a=seepieces&id={pg:$v.alipay}"><button class="jinjian" style="color:#ffffff">查看进件</button></a>
                                                                    <button class="btn btn-sm btn-danger delete" data-id="{pg:$v.alipay}"><strong>删&nbsp;&nbsp;除 </strong></button>
                                                                    </p>
                                                                    {pg: /if}
                                                                    {pg: if (!empty($v.wechat))}
                                                                    <p>
                                                                    <a href="?m=System&c=merchant&a=seepieces&id={pg:$v.wechat}"><button class="jinjian" style="color:#ffffff">查看进件</button></a>
                                                                    <button class="btn btn-sm btn-danger delete" data-id="{pg:$v.wechat}"><strong>删&nbsp;&nbsp;除 </strong></button>
                                                                    </p>
                                                                    {pg:/if}
                                                                    {pg:/if}
																</td>
															</tr>
															{pg:/foreach}
                                                            {pg: else }
															<tr class="widget-list-item">
																<td colspan="9">暂无进件</td>
															</tr>
															{pg: /if }
														</tbody>
													</table>
                                                                                                    
													<div class="js-list-empty-region"></div>
												</div>
                                                                                            
												<div class="js-list-footer-region ui-box">
													<div class="widget-list-footer"></div>
												</div>
                                                                                            {pg:$pagebar }
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
		{pg:include file="$tplHome/System/public/footer.tpl.php"}
        </div>
	</div>

</body>
<!-- iCheck -->
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/iCheck/icheck.min.js"></script>
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
		$.post('?m=User&c=merchant&a=getWxStore',function(rets){
			$('#popgetshop').hide();
			$('.modal-backdrop').remove();
			if(rets.error){
			     swal({
					title: "温馨提示",
					text: "没有已审核的进件可同步！",
					type: "error"
					});
			}else{
				swal({
					title: "温馨提示",
					text: "已经同步完微信进件数据！",
					type: "success"
					}, function () {
						window.location.reload();
				});	 
			}
		},'JSON');
	});
	
	$("#pop_add_shop").click(function(){
		window.location.href="?m=User&c=merchant&a=createStore";
	});

	$('.delete').click(function(){
		var id = $(this).attr('data-id');
		swal({
			title: "删除进件",   
			text: "您真的要删除该进件吗？",
			type: "warning",   
			showCancelButton: true,   
			confirmButtonText: "删除",   
			cancelButtonText: "取消",   
			closeOnConfirm: false,   
			closeOnCancel: true 
		}, function(isConfirm){
			if (isConfirm) {
				$.ajax({
					url:"?m=System&c=merchant&a=piecesdel",
					type:"POST",
					data:{'id':id},
					dataType:"JSON",
					success:function(ret){
						if(ret.code==1){
                                                swal({
                                                          title: "删除成功",
                                                          text: '进件删除成功',
                                                          type: "success",
                                                          closeOnConfirm: false
                                                         },function(){
                                                                location.reload();
                                                        });
						} else {
							swal("删除进件失败", ret.errmsg, "error");
					   }
					}
				});
			}
		});
	});
});

/****进件删除*****/
function DelStore(storeId){
	swal({
		title: "删除进件",   
		text: "此进件尚未审核通过，您确定要删除吗？\n此时删除将无法同步删除微信公众后台此进件。",
		type: "warning",   
		showCancelButton: true,   
		confirmButtonText: "删除",   
		cancelButtonText: "取消",   
		closeOnConfirm: false,   
		closeOnCancel: true 
	}, function(isConfirm){
		if (isConfirm) {
			$.ajax({
				url:"?m=User&c=merchant&a=store2del",
				type:"POST",
				data:{'id':storeId},
				dataType:"JSON",
				success:function(ret){
					if(!ret.errcode){
						swal({
							  title: "删除成功",
							  text: '进件删除成功',
							  type: "success",
							  closeOnConfirm: false
							 },function(){
								location.reload();
							});
					} else {
						swal("删除进件失败", ret.errmsg, "error");
				   }
				}
			});
		}
	});
}
</script>
</html>