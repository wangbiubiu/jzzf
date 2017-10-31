<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>门店统计</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link	href="http://cashier.b0.upaiyun.com/pigcms_static/plugins/css/datapicker/datepicker3.css" rel="stylesheet">
<script
	src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
<!-- Data picker -->
<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
</head>

<style>
.clearfix:after {
	height: 0;
	content: " ";
	display: block;
	overflow: hidden;
	clear: both;
}
.clearfix {
	zoom: 1;/*IE低版本浏览器不支持after伪类所以要加这一句*/
}
	.tit ul li{ float:left; font-size: 12px; padding: 0 20px; height: 40px; line-height: 40px;}
	.tit ul li a{color: #BDBDBD ; display: inline-block;}
	.tit ul li:hover{ background: #FFFFFF;}
	.tit ul li:hover a{ color: #000000 !important;}
	
	.content{background: #FFFFFF;}
	.content a{color:#000000 !important;}
	
#dataselect .input-group-btn, #ym-select .input-group-btn {
	width: 12%;
}

#dataselect .input-sm, #ym-select .input-sm {
	border-radius: 7px;
	height: 40px;
}

#dataselect .btn-primary, #ym-select .btn-primary {
	margin-left: 20px;
	border-radius: 4px;
	margin-bottom: 0px;
}

#dataselect .input-group-addon, #ym-select .input-group-addon {
	border-radius: 7px;
}

.ibox-content {
	min-height: 550px;
}

.input-group .form-control {
	width: 45%;
	float: none;
}
#cibox-content{ min-height:550px;}
	  #dataselect .input-group-btn,#ym-select .input-group-btn{width: 12%;}
	  #dataselect .input-sm ,#ym-select .input-sm{ border-radius: 7px; height:40px;}
	  #dataselect .btn-primary ,#ym-select .btn-primary{ margin-left: 20px; border-radius:4px;margin-bottom: 0px;}
	  #dataselect .input-group-addon,#ym-select .input-group-addon{border-radius: 7px;}
	  .input-group .form-control {
    width: 45%;
    float: none;
 }

.store tbody tr th{ background: #f2f2f2; height: 40px; text-align: center;}
.store tbody tr td{height: 40px; line-break: 40px; text-align: center;}
.store tbody tr td span{ color: #36a9e0;}
.green{color: green;}
.red{color: red;}
.bg_hide{display: none;}
.shangjia_tit{border-bottom:2px solid #f2f2f2 ; margin-bottom: 10px; padding-left: 0px; background: #FFFFFF; margin-left: 1%; width: 98%; height: 50px; line-height: 50px; text-align: left; border-top:3px solid #d9e6e9 ;font-size: 18px;}
</style>
<body>
    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>结算中心</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>结算中心</a>
                        </li>
                        <li class="active">
                            <strong>业务员结算</strong>
                        </li>
                    </ol>
                </div>
		</div>
        <div class="row wrapper page-heading iconList">
           
            
               
                <div class="wrapper wrapper-content animated fadeInRight" style="width: 100%; background: #FFFFFF; padding-top: 0px; margin-top: 30px;">
                	<div class="row">
                		<p class="shangjia_tit">我的结算</p>
                		<div style="width: 100%; padding: 0 10px; ">
                			
                			<label class="font-noraml">业务员名称</label>
                			<p><input class="input-sm form-control" type="text" placeholder="输入业务员名称" style="width: 39%;border-radius: 7px;height: 40px;"></p>
                		</div>
	                	<div id="ym-select" class="form-group" style="padding: 0 10px;">
								<label class="font-noraml">选择年月</label>
								<div id="ymdatepicker" class="input-daterange input-group">
									<input type="text" value="2016-04" name="start" class="input-sm form-control" id="ymstart">
									&nbsp;<span> 到 </span>&nbsp; 
									<input type="text" value="2016-10" name="end" class="input-sm form-control" id="ymend"> 
									<span class="input-group-btn">
										<button class="btn btn-primary">搜 索</button>
									</span>
								</div>
						</div>
	                	<table class="store" border="1" bordercolor="#f2f2f2" width="98%" style="margin-left:1%;">
	                		<tbody>
	                			<tr>
	                				<th>商户</th>
	                				<th>日期</th>
	                				<th>应结订单金额</th>
	                				<th>分润比</th>
	                				<th>佣金</th>
	                				<th>划账金额</th>
	                				<th>状态</th>
	                				<th>详情</th>
	                			</tr>
	                			<tr>
	                				<td>赵曦</td>
	                				<td>2016-16</td>
	                				<td>254.12</td>
	                				<td>0.39%</td>
	                				<td>0.39</td>
	                				<td>0</td>
	                				<td class="green">以划账</td>
	                				<td><a href="#"><span>···</span></a></td>
	                			</tr>
	                			<tr>
	                				<td>赵曦</td>
	                				<td>2016-16</td>
	                				<td>254.12</td>
	                				<td>0.39%</td>
	                				<td>0.39</td>
	                				<td>0</td>
	                				<td class="red">未划账</td>
	                				<td><a href="#"><span>···</span></a></td>
	                			</tr>
	                		</tbody>
	                	</table>
                	</div>                	
                </div>           
           </div>    
        </div>
    </div>
   <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
<script>
	$(".tit>ul>li").click(function(){
		var index = $(this).index();
		$(this).siblings().removeClass("content");
		$(this).addClass("content");
		$(".store_nr>div").hide();
		$(".store_nr>div").eq(index).show();

	});
</script>


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
					$('#datepicker input').datepicker({
		                keyboardNavigation: false,
		                forceParse: false,
						format: "yyyy-mm-dd",
		                autoclose: true
		            });
					$('#ymdatepicker input').datepicker({
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