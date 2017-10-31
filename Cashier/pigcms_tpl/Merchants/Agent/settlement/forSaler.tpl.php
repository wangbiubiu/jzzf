
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> 代理商 | 业务员结算</title>
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>


    <!-- FooTable -->
    <link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
		<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/cashier.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
<script
	src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
<!-- Data picker -->
<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
	<style>
		.ibox{
		 	border: 1px solid #e7eaec;
		}
		.part_item {
  			background: none repeat scroll 0 0 #fff;
  			border: 1px solid #ccc;
  			border-radius: 5px;
  			padding-bottom: 15px;
  			margin-bottom: 10px;
		}
		.form .part_item p {
  			display: inline-block;
  			font-size: 14px;
  			overflow: hidden;
  			padding: 10px 20px 0;
  			text-overflow: ellipsis;
  			white-space: nowrap;
		}
		.part_item_b {
  			border-top: 1px solid #ccc;
  			margin-top: 10px;
		}
		.form .part_item p.active {
  			color: #f87b00;
		}
		.part_item input {
  			font-size: 14px;
  			margin-bottom: 2px;
  			margin-right: 5px;
		}
		.pagination{
			margin:0px;
		}
		.mustInput {
  			color: red;
  			margin-right: 5px;
		}
		@media (min-width: 768px){
			.form .part_item p {
				width: 37%;
			}
		}
		@media (min-width: 992px){
			.form .part_item p {
				width: 24%;
			}
		}
	.form-control, .single-line{width: 50%;}
	
	.ibox {
    border: 1px solid #e7eaec;
    border-top: none;
}
	
	.tit ul li{ float: left; padding: 0 3%; list-style: none; color: #b1bac8; cursor: pointer; height: 40px; line-height: 40px;}
	.tit ul li:hover{ color: #8f99a7;}
	.cont{ background: #FFFFFF; color: #000000 !important;}
	.bd_nr>td{ line-height: 30px !important; height:30px !important; padding: 10px 0px 0px !important;}
	.bd_nr>td>button{ padding: 0 10px; margin: 0 10px; border: none; border-radius: 5px; height:30px; color: #FFFFFF;}
	.yc{display: none;}
	.tit_h4{ background: #f2f2f2; height: 40px; line-height: 40px; padding: 0 20px; width: 100%;margin:0px !important;}
	.tit_h4 span{ color: #676a6c; font-weight: normal;}
	.tit_h4 a{ color: #44b549; font-weight: normal;}
	.jbxi_bg>div{border-top: 1px solid #f2f2f2; padding: 20px 0; margin: 0px !important;}
	.jbxi_bg>div label{ display: block; width: 100px; text-align: right;height: 30px; line-height: 30px; overflow: hidden; float: left;}
	.jbxi_bg>div>p{margin-left: 20px; width: 50%; height: 30px; line-height: 30px; overflow: hidden; text-overflow: ellipsis;float: left;}
	.form-control{
    width: 80%;
}
.footable-odd {
    background-color: #ffffff;
}
.sl{background: #ebebed; border-bottom: 1px solid #EEEEEE;border-top: 1px solid #EEEEEE; height: 40px; line-height: 40px; text-align: right;}
.sl>span{margin-right: 40px;}
.fl{float: left;}
.fr{ float: right;}

tbody>tr>td{ padding: 10px 0 !important;}
	</style>
</head>

<body>

    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>

        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>业务员结算</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Agent</a>
                        </li>
                        <li>
                            <a>代理中心</a>
                        </li>
                       
                        <li class="active">
                            <strong>结算</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	<div class="tit">
            		<ul class="clearfix " style="margin-bottom: 0px; padding-left: 16px;">
            			<li <?php if ($getdata['type']==1){echo "class='cont'";} ?> onclick='settleM(1)'>待划账</li>
            			<li <?php if ($getdata['type']==2){echo "class='cont'";} ?> onclick='settleM(2)'>已划账</li>
            		</ul>
            	</div>
            	<script>
          
            		function settleM(type){
            			 window.location.href='?m=Agent&c=settlement&a=forSaler&type='+type;
            		}
            	</script>
            	
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <?php if ($getdata['type']==2){?>
		                     <div class="ibox-content" style="border-top:none">
		                     	<form method="get" action='?m=Agent&c=settlement&a=forSaler' >
		                     	<input type="hidden" name="m" value="Agent">
		                     	<input type="hidden" name="c" value="settlement">
		                     	<input type="hidden" name='a' value="forSaler">
		                     	<input type="hidden" name='type' value="<?php if (isset($getdata['type'])){echo $getdata['type'];} ?>">

		                           <div id="dataselect" class="form-group" style="padding: 0 10px;">
										<div id="datepicker" class="input-daterange">
											<label class="font-noraml">业务员姓名</label>
			                				<input class="input form-control" type="text" placeholder="业务员名称"  name="username" style="width: 15%;border-radius: 3px;height: 30px; margin-bottom: 0px;" value="<?php if (isset($getdata['username']) ){echo $getdata['username'];} ?> ">
											<label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
											<input type="text" value="<?php if(isset($getdata['start'])) echo $getdata['start'];?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" margin-bottom: 0px; width: 15%; height: 30px; border-radius:3px">
											&nbsp;<span> 到 </span>&nbsp;
											<input type="text" value="<?php if(isset($getdata['end'])) echo $getdata['end'];?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" margin-bottom: 0px; width: 15%;height: 30px;border-radius:3px">
											&nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:100px;border-radius:3px" href="?m=Agent&c=settlement&a=data2Excel&type=<?php echo $getdata['type']; ?>">导出Excel</a>
										</div>
									</div>
								</form>

							<div class="employersDelAll" >
                        <?php }?>
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter="#filter" style="border: 1px solid #f2f2f2;">
                                <thead>
                                <tr style="background: #f2f2f2">
                                    <th  style="text-align: center;">结算日期</th>
                                    <th style="text-align: center;"  data-hide="phone">业务员名称</th>
                                    <th style="text-align: center;"  data-hide="phone">商家名称</th>
                                    <th style="text-align: center;"  data-hide="phone">代理商佣金</th>
                                    <th style="text-align: center;"  data-hide="phone">佣金比例</th>

                                    <th style="text-align: center;" data-hide="phone">有效佣金</th>
                                    <th style="text-align: center;" data-hide="phone">操作</th>
                                </tr>
                                </thead>
                                <tbody class="js-list-body-region" id="table-list-body">
                                        <?php $count=0?>
									<?php if (!empty($datas)) { foreach ($datas as $ke => $va): ?>
										
									
										<tr class="widget-list-item bd_nr" style="text-align: center;">
                                               <td><?php echo date('Y年m月',strtotime($va['addtime'].'01')) ; ?></td>
												<td><?php echo $va['username']; ?></td>
												<td><?php echo $va['company']; ?></td>
												<td><?php echo $va['count_money']; ?></td>
												<td><?php echo $va['commission']*100; ?>%</td>
												<td><?php echo $va['money']; ?></td>
                                                   <?php $count+= $va['money'];?>
												<td>
                                                    <?php if($va['status']==1): ?>
													<p>
                                                        <button class="btn btn-sm btn-info money" value="<?php echo $va['id']?>" style="background: #008fd3;">划账</button>
													</p>
                                                    <?php endif;?>
                                                    <?php if($va['status']==2): ?>
                                                        <p>
                                                            <button class="btn btn-sm btn-info" style="background: #A0B4DC;">已划账</button>
                                                        </p>
                                                    <?php endif;?>
												</td>
												
										</tr>
									<?php endforeach ?>
									<?php } ?>
								</tbody>

                            </table>
                            <p style="text-align: right; padding-right: 150px; height: 50px; background: #f2f2f2; line-height: 50px;">合计金额:<?php echo $count ;?></p>
							</div>
                        </div>
        



                        </div>
                      <?php echo $p; ?>
                    </div>
                </div>
            </div>
        </div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
     </div>
    </div>
    
   </div>
    <script>
    	$(".tit>ul>li").click(function(){
    		var index=$(this).index();
    		var web = $(this).text();
    		$(".active>strong").html(web)
    		$(this).addClass("cont")
    		$(this).siblings().removeClass("cont");
    		$(".ibox>div").eq(index).show();
    		$(".ibox>div").eq(index).siblings().hide();
    	});
    	// 划账
//    	function remite (type,id) {
//    		if (type==1) {
//    			$.ajax({
//    				type:'post',
//    				url: '?m=Agent&c=settlement&a=remite',
//    				dataType:'json',
//    				data:{id:id},
//    				success: function (ev) {
//    					console.info(ev);
//    					if (ev.status==1) {
//    						swal({title:'划账成功',text:ev.msg,type:'success'});
//    						window.location.href='?m=Agent&c=settlement&a=forSaler&type=1';
//    					}
//
//    				}
//
//
//
//    			});











//    		}
//    	}
        $(function () {
            $('.money').click(function () {
                var id =$(this).val();
                $.post('?m=Agent&c=settlement&a=remite',{id:id},function (data) {
                    if (data.status == 1) {
                        swal({
                            title: data.msg,
//            text: "确认提交",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonText: "确定",
                            cancelButtonText: "取消",
                            closeOnConfirm: false,
                            closeOnCancel: true
                        },function (isConfirm) {
                            if(isConfirm){
                                window.location.reload();
                            }
                        })
                    }else {
                        swal({
                            title: data.msg,
//            text: "确认提交",
                            type: "error",
                            showCancelButton: false,
                            confirmButtonText: "确定",
                            cancelButtonText: "取消",
                            closeOnConfirm: false,
                            closeOnCancel: true
                        })
                    }
                },'json')
            })
        })
    </script>
    
	
	<script type="text/html" id="employersEditTpl">
		<figure>
              <iframe width="425" height="349" src="?m=User&c=merchant&a=employersEdit&eid={($eid)}" frameborder="0"></iframe>
        </figure>
	</script>

    <!-- FooTable -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all.min.js"></script>
	
	<!-- iCheck -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
	
	<!-- Jquery Validate -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/validate/jquery.validate.min.js"></script>


 <script type="text/javascript">
if(mobilecheck()){
$("#side-menu li").click(function () {
   $("#side-menu li").find('.nav-second-level').css('display','none');
   $(this).find('.nav-second-level').css('display','block').css('min-width','140px');
 });
}
	if(navigator.userAgent.indexOf("AlipayClient")!=-1){
	    $('#shou-kuan').attr('href','/merchants.php?m=Agent&c=alicashier&a=alipayment&type=1');
		$('#tui-kuan').attr('href','/merchants.php?m=Agent&c=alicashier&a=alipayment&type=2');
	}
</script> 
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
		           
				 GetChartData('smcount','linecountChart','canvasdesc');
				$('#dataselect .btn-primary').click(function(){
					GetChartData('smcount','linecountChart','canvasdesc');
				});
		});
    </script>
    <script>
   	/******导出处理********/
var tipshtm='';
var excellock=false;
function exportExcel(){
   if(excellock){
		$('#Export_excel_pop').show();
		$('body').append('<div class="modal-backdrop in"></div>');
	    return false;
	}
	excellock=true;
	$('#Export_excel_pop ul').html('<li style="padding-top:20px;">正在导出您的数据，请稍等......</li>');
  $('#Export_excel_pop').show();
  $('body').append('<div class="modal-backdrop in"></div>');
  var fromData=$('form').serialize();
      $.post('/merchants.php?m=User&c=statistics&a=exportExcel', fromData, function(resp){
			 if (resp.error){
				 alert(resp.msg);
				 return false;
			 } else {
				if(resp.tt>0){
				  tipshtm="<li>已经导出1到5000数据......."+
				   "<li id='extpage_1'>正在为您导出5001到10000条数据......</li>";
					$('#Export_excel_pop ul').append(tipshtm);
				  Run_Export_excel(2);
				}else{
				  tipshtm="<li>数据导出完成&nbsp;&nbsp;&nbsp;<a href='"+resp.fileurl+"'>下载<a></li>"
				  $('#Export_excel_pop ul').append(tipshtm);
				  excellock=false;
				}
			 }                                     	
        }, 'json');
   
    return false;
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
</body>
</html>