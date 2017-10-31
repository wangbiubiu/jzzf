<!DOCTYPE html>
<html>
<head>
<title>业务员</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
<link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/cashier.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
<script
	src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
<!-- Data picker -->
<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>

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
					<h2>商户列表</h2>
					<ol class="breadcrumb">
						<li><a>Salesman</a></li>
						<li class="active"><strong>商户列表</strong></li>
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
										<button class="btn btn-primary" id="pop_add_shop"><i class="fa fa-plus"></i> 添加商户</button>
									</li>
								</ul>
							</div>
							<div class="ibox-content">
								<nav class="ui-nav clearfix"></nav>
								<div class="app__content js-app-main page-cashier">
									<div>
										<!-- 实时交易信息展示区域 -->
										<div class="cashier-realtime">
										<form action="/merchants.php?m=Salesman&c=merchant&a=merchantList" method="get">
											<div id="dataselect" class="form-group" style="padding: 0 10px;">
											    <input type="hidden" name='m' value='Salesman'>
                							    <input type="hidden" name='a' value='merchantList'>
                							    <input type="hidden" name='c' value='merchant'>
												<div id="datepicker" class="input-daterange">
													<label class="font-noraml">商户名称</label>
					                				<input class="form-control" type="text" placeholder="输入商户名称" style="width: 20%;border-radius:5px;height: 40px; margin-bottom: 0px;"name="company" value="<?php if(isset($getdata['company'])) echo $getdata['company'];?>" >
					                				
					                				
					                				<!--
													<label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
													<input type="text" value="<?php if(isset($getdata['start'])) echo $getdata['start'];?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" height: 40px; margin-bottom: 0px; width: 20%;">
													&nbsp;<span> 到 </span>&nbsp; 
													<input type="text" value="<?php if(isset($getdata['end'])) echo $getdata['end'];?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" height: 40px; margin-bottom: 0px; width: 20%;"> 
													-->
													
													&nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:100px;" href="javascript:;" onclick="exportExcel();">导出到excel</a>
												</div>
											</div>
									   </form>
										</div>
										<div class="js-real-time-region realtime-list-box loading">
											<div class="widget-list">
												<div class="js-list-filter-region clearfix ui-box"
													style="position: relative;">
													<div class="widget-list-filter"></div>
												</div>
												<div class="ui-box">
													<table class="ui-table ui-table-list" data-page-size="20" style="padding: 0px; text-align: center;">
														<thead class="js-list-header-region tableFloatingHeaderOriginal">
															<tr class="widget-list-header">
																
																<th>商户ID</th>
																<th>登录账号</th>
																<th data-hide="phone">商户名</th>
																<th data-hide="phone">添加时间</th>
																<!-- <th data-hide="phone">支付配置</th> -->
																<th data-hide="phone">操作</th>
															</tr>
														</thead>
														<tbody class="js-list-body-region" id="table-list-body">
											     <?php if($data){ ?>
													   <?php foreach ($data as $key => $val){?>	
															<tr class="widget-list-item">
																<td><?php echo $val['merchants_id'];?></td>
																<td><?php echo $val['username'];?></td>
																<td><?php echo $val['company'] ?></td>
																<td><?php echo date('Y-m-d H:i:s',$val['regTime'])?></td>
																<!--  
																<td>
																<?php if($val['mtype'] == '1'){?>
    																<?php if($val['isopenwxpay'] == '1'){?>
    																    <a href="?m=Salesman&c=merchant&a=config&type=1&mid=<?php echo $val['merchants_id'] ?>">
    																        <img src="./Cashier/pigcms_static/image/wechat_pay_yes.png">
    																    </a>     
    																<?php }else{?>
    																    <a href="?m=Salesman&c=merchant&a=config&type=1&mid=<?php echo $val['merchants_id'] ?>">
    																        <img src="./Cashier/pigcms_static/image/wechat_pay_no.png">
    																    </a>    
    																<?php }?>    
    																
    																<?php if($val['isopenalipay'] == '1'){?>
    																    <a href="?m=Salesman&c=merchant&a=config&type=2&mid=<?php echo $val['merchants_id'] ?>">
    																        <img src="./Cashier/pigcms_static/image/alipay_pay_yes.png">
    																    </a>    
    																<?php }else{?>
    																    <a href="?m=Salesman&c=merchant&a=config&type=2&mid=<?php echo $val['merchants_id'] ?>">
    																        <img src="./Cashier/pigcms_static/image/alipay_pay_no.png">
    																    </a>
    																<?php }?>
    															<?php }else if($val['mtype'] == '2'){?>	
    															                       二清商户 
    															<?php }?>
                                                                </td>
                                                                -->
																<td>
                                                                    <a class="btn btn-sm btn-info" href="<?php echo '?m=Salesman&c=merchant&a=mngMerchant&mid='.$val['merchants_id']?>" style="vertical-align: top; background: #337ab7;"> 管理 </a>
																	<!-- <a class="btn btn-sm btn-info" href="<?php echo '?m=User&c=Index&a=index&m_mid='.$val['merchants_id']?>" style="vertical-align: top; background: #36a9e0;"  target="_blank" >一键登录</a> </a> -->
																	
																</td>
															</tr>
														<?php }?>
												<?php }else{?>		
															<tr class="widget-list-item">
																<td colspan="9">暂无商户</td>
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

<div class="modal inmodal" tabindex="-1" role="dialog" id="popgetshop">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
					<h4 class="modal-title">正在获取微信商户数据....</h4>
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
    <form action="/merchants.php?m=Salesman&c=merchant&a=MerchantsExcel" id='excelmerchant' method="post">
    
    </form>
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
                    <button type="button" class="btn btn-white" onclick="$('#Export_excel_pop').hide();$('.modal-backdrop').remove();"> 取 消 </button>
                </div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>

<script type="text/javascript">
		        $(document).ready(function() {
					$('#datepicker .input-sm').datepicker({
		                keyboardNavigation: false,
		                forceParse: false,
						format: "yyyy-mm-dd",
		                autoclose: true
		            });
					$('#ymdatepicker .input-sm').datepicker({
		                keyboardNavigation: false,
		                forceParse: false,
						format: "yyyy-mm",
		                autoclose: true
		            });
		           
				
		});
    </script>
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
					text: "没有已审核的商户可同步！",
					type: "error"
					});
			}else{
				swal({
					title: "温馨提示",
					text: "已经同步完微信商户数据！",
					type: "success"
					}, function () {
						window.location.reload();
				});	 
			}
		},'JSON');
	});
	
	$("#pop_add_shop").click(function(){
		window.location.href="?m=Salesman&c=merchant&a=createMerchant";
	});

	$('.delete').click(function(){
		var id = $(this).attr('data-id');
		swal({
			title: "删除商户",   
			text: "您真的要删除该商户吗？",
			type: "warning",   
			showCancelButton: true,   
			confirmButtonText: "删除",   
			cancelButtonText: "取消",   
			closeOnConfirm: false,   
			closeOnCancel: true 
		}, function(isConfirm){
			if (isConfirm) {
				$.ajax({
					url:"?m=User&c=merchant&a=storedel",
					type:"POST",
					data:{'id':id},
					dataType:"JSON",
					success:function(ret){
						if(!ret.errcode){
							swal({
								  title: "删除成功",
								  text: '商户删除成功',
								  type: "success",
								  closeOnConfirm: false
								 },function(){
									location.reload();
								});
						} else {
							swal("删除商户失败", ret.errmsg, "error");
					   }
					}
				});
			}
		});
	});
});

/****商户删除*****/
function DelStore(storeId){
	swal({
		title: "删除商户商户",   
		text: "此商户尚未审核通过，您确定要删除吗？\n此时删除将无法同步删除微信公众后台此商户。",
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
							  text: '商户删除成功',
							  type: "success",
							  closeOnConfirm: false
							 },function(){
								location.reload();
							});
					} else {
						swal("删除商户失败", ret.errmsg, "error");
				   }
				}
			});
		}
	});
}
</script>
<script>
   	/******导出处理********/
var tipshtm='';
var excellock=false;
function exportExcel(){
	$('#excelmerchant').submit();
}


 
function Run_Export_excel(page){
	 var fromData=$('form').serialize();
	 fromData=fromData+'&page='+page;
      $.post('/merchants.php?m=User&c=statistics&a=exportExcel', fromData, function(resp){
			 if (resp.error){
				 alert(resp.msg);
				 return false;
			 } else {
				var tmp= resp.p +1;
				var idxs=(page-1);
				if(!resp.flag && (tmp<=resp.tt)){
				  var mc1=5000*idxs +1;
				  var mc2=5000*page;
				  var mc3=5000*tmp;
				   $('#extpage_'+idxs).html('已经导出'+mc1+'到'+mc2+'数据.......');
					mc2=mc2+1;
				    tipshtm="<li id='extpage_"+page+"'>正在为您导出"+mc2+"到"+mc3+"条数据......</li>";
					$('#Export_excel_pop ul').append(tipshtm);
				    Run_Export_excel(tmp);
				}else{
				  tipshtm="<li id='extpage_end'>完成导出,正在为你打包导出的文件......</li>";
				  $('#Export_excel_pop ul').append(tipshtm);
				    if(true){
				    $.post('/merchants.php?m=User&c=statistics&a=export_excel_zip', {page:resp.p}, function(rest){
				         if (rest.error){
							alert(resp.msg);
							return false;
							} else {
									 tipshtm="<li>打包完成。&nbsp;&nbsp;&nbsp;<a href='"+rest.fileurl+"'>下 载<a></li>";
								    $('#Export_excel_pop ul').append(tipshtm);
									excellock=false;
							}
				    }, 'json');
					}
				}
				 //window.location.reload();
			 }                                     	
        }, 'json');
      
}

   </script>
</html>