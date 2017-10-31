
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>收银台 | 员工列表</title>
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
                    <h2>结算管理</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>业务员中心</a>
                        </li>
                       
                        <li class="active">
                            <strong>结算管理</strong>
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
            			<li class="cont">平台结算</li>
            			<li>业务员结算</li>
            			
            			
            		</ul>
            	</div>
            	
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                    	
                    	<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：平台结算
                        -->
                                                 
                         <div class="ibox-content" style="border-top:none">
                               
							<div class="employersDelAll" >
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter>
                                <thead>
                                <tr>
                                    <th style="text-align: center;"  data-hide="phone">日期</th>
                                    <th  style="text-align: center;">应结订单金额</th>
                                    <th style="text-align: center;" data-hide="phone">佣金</th>
                                    <th style="text-align: center;" data-hide="phone">佣金返点</th>
                                    <th style="text-align: center;" data-hide="phone">划账金额</th>
                                    <th style="text-align: center;" data-hide="phone">详情</th>
                                </tr>
                                </thead>
                                <tbody class="js-list-body-region" id="table-list-body">
									
										<tr class="widget-list-item bd_nr" style="text-align: center;">
												<td>2016-08</td>
												<td>130.91</td>
												<td>0.39</td>
												<td>0.3%</td>
												<td>0</td>
												<td>
													<p>
														<a href="#" style="text-align: center; color: #36a9e0; font-size: 50px;">···</a>
													</p>
												</td>
												
										</tr>
									<tr class="widget-list-item bd_nr" style="text-align: center;">
												<td>2016-08</td>
												<td>130.91</td>
												<td>0.39</td>
												<td>0.3%</td>
												<td>0</td>
												<td>
													<p>
														<a href="#" style="text-align: center; color: #36a9e0; font-size: 50px;">···</a>
													</p>
												</td>
												
										</tr>
								</tbody>
                            </table>
							</div>
                        </div>
                    <!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：业务员
                        -->
                       <div class="ibox-content yc" style="border-top:none">
                               <div id="dataselect" class="form-group" style="padding: 0 10px;">
									<div id="datepicker" class="input-daterange">
										<label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
										<input type="text" value="<?php if(isset($getdata['start'])) echo $getdata['start'];?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" margin-bottom: 0px; width: 20%; height: 40px;">
										&nbsp;<span> 到 </span>&nbsp; 
										<input type="text" value="<?php if(isset($getdata['end'])) echo $getdata['end'];?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" margin-bottom: 0px; width: 20%;height: 40px;"> 
										&nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">
									</div>
						</div>
							<div class="employersDelAll" >
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter style="margin-bottom: 0px;">
                                <thead>
                                <tr>
                                    <th style="text-align: center;"  data-hide="phone">代理商</th>
                                    <th  style="text-align: center;">日期</th>
                                    <th style="text-align: center;" data-hide="phone">应结订单金额</th>
                                    <th style="text-align: center;" data-hide="phone">佣金</th>
                                    <th style="text-align: center;" data-hide="phone">佣金返点</th>
                                    <th style="text-align: center;" data-hide="phone">划账金额</th>
                                    <th style="text-align: center;" data-hide="phone">详情</th>
                                </tr>
                                </thead>
                                <tbody class="js-list-body-region" id="table-list-body">
									
										<tr class="widget-list-item bd_nr" style="text-align: center;">
												<td>江浙</td>
												<td>2016-08</td>
												<td>130.91</td>
												<td>0.39</td>
												<td>0.3%</td>
												<td>0</td>
												<td>
													<p>
														<a href="#" style="text-align: center; color: #36a9e0; font-size: 50px;">···</a>
													</p>
												</td>
												
										</tr>
									<tr class="widget-list-item bd_nr" style="text-align: center;">
												<td>江浙</td>
												<td>2016-08</td>
												<td>130.91</td>
												<td>0.39</td>
												<td>0.3%</td>
												<td>0</td>
												<td>
													<p>
														<a href="#" style="text-align: center; color: #36a9e0; font-size: 50px;">···</a>
													</p>
												</td>
									</tr>
									
								</tbody>
                            </table>
							</div>
                       </div>
                    	<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：end
                        -->
                        
                    </div>
                </div>
            </div>
        </div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
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
	    $('#shou-kuan').attr('href','/merchants.php?m=User&c=alicashier&a=alipayment&type=1');
		$('#tui-kuan').attr('href','/merchants.php?m=User&c=alicashier&a=alipayment&type=2');
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
</body>
</html>