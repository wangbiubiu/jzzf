<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商户统计</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/cashier.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
<script	src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
<!-- Data picker -->
<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
<style type="text/css">
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

.payment tbody tr th,.payment1 tbody tr th{
	background: #f2f2f2;
}
.payment tbody tr th,.payment tbody tr td{ padding: 10px 10px; text-align: center;height: 60px;}
.payment1 tbody tr th,.payment1 tbody tr td{ padding: 10px 10px; text-align: center;}

.line-legend,.doughnut-legend,.bar-legend {
    list-style: outside none none;
    position: absolute;
    right: 25px;
    top: 60px;
}
.line-legend {
    top: 195px;
}
.line-legend li,.doughnut-legend li ,.bar-legend li{
    border-radius: 5px;
    cursor: default;
    display: block;
    font-size: 14px;
    margin-bottom: 4px;
    padding: 2px 15px 2px 28px;
    position: relative;
    transition: background-color 200ms ease-in-out 0s;
}
.line-legend li span,.doughnut-legend li span ,.bar-legend li span{
    border-radius: 5px;
    display: block;
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 20px;
}
	 #cibox-content{ min-height:550px;}
	  #dataselect .input-group-btn,#ym-select .input-group-btn{width: 12%;}
	  #dataselect .input-sm ,#ym-select .input-sm{ border-radius: 7px; height:40px;}
	  #dataselect .btn-primary ,#ym-select .btn-primary{ margin-left: 20px; border-radius:4px;margin-bottom: 0px;}
	  #dataselect .input-group-addon,#ym-select .input-group-addon{border-radius: 7px;}
	  .input-group .form-control{width: 45%;float:none;}
	  
	  .shanxin{float: right; width: 400px; height: 240px;margin-top: -270px; position: relative; margin-bottom: 20px; border: 1px solid #cccccc;}
	  
	  @media(max-width:1150px) {
	  	 .shanxin{float: left; width: 400px; height: 240px;margin-top:20px;}
	  }
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

.line-legend, .doughnut-legend, .bar-legend {
    list-style: outside none none;
    position: absolute;
    right: -10px;
    top: 40px;
}
.tk{ width: 50px; height: 30px; line-height: 30px; background: #008000; text-align: center; border-radius: 5px; margin: 0 auto;}
.tk a{ color: #FFFFFF;}
.ytk{width: 50px; height: 30px; line-height: 30px; background: #cdcdcd; text-align: center; border-radius: 5px; margin: 0 auto;}
.ytk a{ color: #FFFFFF;}

	  </style>
</head>

<body>
    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/tope.tpl.php';?>
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>商户统计</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>统计管理</a>
                        </li>
                        <li class="active">
                            <strong>商户统计</strong>
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
								<div class="form-group" style="border-bottom: 1px solid #cccccc; font-size: 18px;">
									<label class="font-noraml">商户数据</label>
							
								</div>
								<!--
                                	作者：2721190987@qq.com
                                	时间：2016-10-18
                                	描述：选择日期
                                -->
                                            <div class="ibox-title" id="screenForm">
                                            <form method="post" action="/merchants.php?m=User&c=count&a=storesdetail">
                                                  
                                                  <input type="hidden" value="User" name="m" >
                                                  <input type="hidden" value="count" name="c" >
                                                  <input type="hidden" value="storesdetail" name="a" >
                                                  <div id="dataselect" class="form-group" style="padding: 0 10px;">
                                                          <div id="datepicker" class="input-daterange">
                                                                  <label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
                                                                  <input type="text" value="<?php if(isset($getdata['start'])) echo $getdata['start'];?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" margin-bottom: 0px; width: 20%;">
                                                                  &nbsp;<span> 到 </span>&nbsp; 
                                                                  <input type="text" value="<?php if(isset($getdata['end'])) echo $getdata['end'];?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" margin-bottom: 0px; width: 20%;"> 
                                                                  &nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:100px;" href="javascript:;" onclick="exportExcel();">导出到excel</a>
                                                          </div>
                                                  </div>
                                             </form>
					</div>
                                      <!--
                                	作者：2721190987@qq.com
                                	时间：2016-10-18
                                	描述：统计
                                -->
                                <div class="clearfix">
                                	<table border="1" class="payment" style="margin: 30px 30px 30px 0px;" width="60%" bordercolor="#e0e0e0">
                                		<tbody>
                                			<tr>
                                				<th>统计日期/支付方式</th>
                                				<th>收款总额</th>
                                				<th>实收金额</th>
                                			</tr>
                                			<tr>
                                                <td><?php if($getdata['start'] && $getdata['end']){ echo $getdata['start'].'至'.$getdata['end'];}elseif($getdata['start']){ echo $getdata['start'].'起';}elseif($getdata['end']){ echo $getdata['end'].'止';}  else {
    
 echo '全部';}?></td>
                                				<td><?php echo $total['count'];?></td>
                                				<td><?php echo $total['income'];?></td>
                                			</tr>
                                			<tr>
                                				<td>微信支付</td>
                                				<td><?php echo $weixin['count'];?></td>
                                				<td><?php echo $weixin['income'];?></td>
                                			</tr>
                                			<tr>
                                				<td>支付宝</td>
                                				<td><?php echo $alipay['count'];?></td>
                                				<td><?php echo $alipay['income'];?></td>
                                			</tr>
                                		</tbody>
                                	</table>
                                	
                                	 <!--
                                	作者：2721190987@qq.com
                                	时间：2016-10-18
                                	描述：统计图
                                -->
                            <div class="shanxin clearfix ">
                            	<div style="text-align: center; height: 30px; line-height: 30px; background: #f2f2f2;">流水比例</div>
	                            <div>
	                                <canvas id="PieChart_m" height="200" width="400"></canvas>
	                            </div>
                                <ul class="doughnut-legend">
	                        		<li><span style="background-color:#a3e1d4"></span>微信支付</li>
	                        		<li><span style="background-color:#33EA90"></span>支付宝</li>
	                        	</ul>
                        	</div>
                             </div>
                               
                            <div class="clearfix">
                                	<table border="1" class="payment1" style="margin: 30px 30px 30px 0px;" width="100%" bordercolor="#e0e0e0">
                                		<tbody>
                                			<tr>
                                                <th>序号</th>
                                				<th>交易单号</th>
                                				<th>应收金额</th>
                                				<th>退款金额</th>
                                				<th>实收金额</th>
                                				<th>交易时间</th>
                                				<th>交易类型</th>
                                				<th>付款方式</th>
                                				<th>收银员</th>
                                				<th>操作</th>
                                				
                                			</tr>
                                                        <?php
                                                            if(!empty($neworder)){
                                                            foreach($neworder as $v){ 
                                                        ?>
                                			<tr>
                                				<td><?php echo $v['id'];?></td>
                                                                <td><?php echo $v['order_id'];?></td>
                                				<td><?php echo $v['goods_price']?></td>
                                                                <td><?php if($v['refund'] == 2){ echo $v['goods_price'];}?></td>
                                				<td><?php echo $v['income']?></td>
                                				<td><?php echo date('Y-m-d H:i:s',$v['paytime'])?></td>
                                                                <td><?php if($v['pay_way']=='weixin'){ echo '微信支付';}elseif($v['pay_way']=='alipay'){echo '支付宝';}?></td>
                                				<td>条码支付</td>
                                				<td><?php echo $v['username'] ?></td>
                                                                <?php if($v['refund'] !=1 && $v['refund'] !=2 ){ ?>
                                                                <td><button class="btn btn-sm" style="background: #008000;color: #FFF;" onclick="<?php if($v['pay_way']=='weixin'){echo 'wx';}elseif($v['pay_way']=='alipay'){echo 'ali';}?>RefundBtn(this,<?php echo $v['id'];?>,<?php echo $v['mid'];?>);"><strong> 退&nbsp;&nbsp;&nbsp;款 </strong></button> </td>
                                				
                                                                <?php  }else{ ?>
                                                                <td><button class="btn btn-sm btn-success btn-st"><strong> 已退款 </strong></button></td>
                                                                <?php } ?>
                                			</tr>
                                			<?php }}else{?>
                                                             <tr class="widget-list-item"><td colspan="11">暂无订单</td></tr>
                                                        <?php }?>
                                		</tbody>
                                	</table>
                      
                             </div>
                            
                                
							</div>
							
							</div>
						</div>
                            <?php echo $pagebar;?>
			</div>
		</div>

	</div>
</div>

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
 <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
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
</div>
	</div>
        <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>cashier/commonfunc.js"></script>
	<script type="text/javascript">
        $(document).ready(function() {
			$('#datepicker .input-sm').datepicker({
                keyboardNavigation: false,
                forceParse: false,
				format: "yyyy-mm-dd",
                autoclose: true
            });
			$('#datepicker .input-sm').datepicker({
                keyboardNavigation: false,
                forceParse: false,
				format: "yyyy-mm",
                autoclose: true
            });
            


	var screenH=$(window).height();
	screenH=  screenH-20;
	$('#oderinfo').css('height',screenH);
         
            
            
           var helpers = Chart.helpers;
    var doughnutData_m = [
        {
            value: <?php echo $weixin['count'] ?>,
            color: "#a3e1d4",
            highlight: "#1ab394",
            label: "微信支付"
        },
        {
            value: <?php echo $alipay['count'] ?>,
            color: "#33EA90",
            highlight: "#1ab394",
            label: "支付宝"
        },
    ];

    var doughnutOptions = {
        segmentShowStroke: true,
        segmentStrokeColor: "#fff",
        segmentStrokeWidth: 2,
        //percentageInnerCutout: 45, // This is 0 for Pie charts
		percentageInnerCutout: 0, // This is 0 for Pie charts
        animationSteps: 100,
        animationEasing: "easeOutBounce",
        animateRotate: true,
        animateScale: false,
        responsive: true,
		//tooltipTemplate : "<%if (label){%><%=label%>: <%}%><%= value %>kb", animation: false
    };


    var ctx = document.getElementById("PieChart_m").getContext("2d");
    var myNewChart = new Chart(ctx).Doughnut(doughnutData_m, doughnutOptions);

		$("#PieChart_m").parent().parent('.ibox-content').append(myNewChart.generateLegend());

   
   
    var doughnutOptions = {
        segmentShowStroke: true,
        segmentStrokeColor: "#fff",
        segmentStrokeWidth: 2,
        percentageInnerCutout: 45, // This is 0 for Pie charts
        animationSteps: 100,
        animationEasing: "easeOutBounce",
        animateRotate: true,
        animateScale: false,
        responsive: true,
		tooltipTemplate : "<%if (label){%><%=label%>: ￥<%}%><%= value %> 元", animation: false
    };


  

	function GetChartData(typ,idstr,idstr2){
		  $('#canvascontext').html('<canvas height="100" id="linecountChart"></canvas>');
		  var start = $.trim($('#datestart').val());
		  var end = $.trim($('#dateend').val());
		  var store_id = parseInt($('#store').val());
		  var pdatas={
		        'typ': typ,
			    'dstart':start,
			    'dend':end,
			    'store_id':store_id
			   }
			$.post('/merchants.php?m=User&c=statistics&a=getchart', pdatas, function(ret) {
				/*data = $.parseJSON(data);*/
				$('#'+idstr2+' .price1').text(' '+ret.expand.microC);
				$('#'+idstr2+' .price2').text(' '+ret.expand.nomicroC);
				$('#'+idstr2+' .price3').text(' '+ret.expand.barcodep);
				$('#'+idstr2+' .price4').text(' '+ret.expand.nobarcodep);
				var lineChartData = {
					labels: ret.xdata,
					datasets: [{
                        label: "微信刷卡次数",
                        fillColor: "rgba(1, 240, 17,0.5)",
                        strokeColor: "rgba(1, 240, 17,1)",
                        pointColor: "rgba(1, 240, 17,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(1, 240, 17,1)",
						data: ret.ydata.idx1
					}]
				}

				if(typeof(ret.ydata.idx2)!='undefined'){
					var tmpobj={
							label: '微信收银台扫码次数',
							fillColor: "rgba(24, 111, 49,0.5)",
							strokeColor: "rgba(24, 111, 49,0.7)",
							pointColor: "rgba(24, 111, 49,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(24, 111, 49,1)",
							data: ret.ydata.idx2
						}
					lineChartData.datasets.push(tmpobj);
					
				}

			if(typeof(ret.ydata.idx3)!='undefined'){
				var tmpobj={
						label: '支付宝条码次数',
						fillColor: "rgba(145, 174, 250,0.5)",
						strokeColor: "rgba(145, 174, 250,0.7)",
						pointColor: "rgba(145, 174, 250,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(145, 174, 250,1)",
						data: ret.ydata.idx3
					}
				lineChartData.datasets.push(tmpobj);
				
			}
		if(typeof(ret.ydata.idx4)!='undefined'){
				var tmpobj={
						label: '支付宝扫码次数',
						fillColor: "rgba(7, 80, 192,0.5)",
						strokeColor: "rgba(7, 80, 192,0.7)",
						pointColor: "rgba(7, 80, 192,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(7, 80, 192,1)",
						data: ret.ydata.idx4
					}
				lineChartData.datasets.push(tmpobj);
				
			}
				 var ctx = document.getElementById(idstr).getContext("2d");
				 var myNewChart = new Chart(ctx).Line(lineChartData, lineOptions);
				 $("#"+idstr).parent().parent('.ibox-content').append(myNewChart.generateLegend());
			},'JSON');
	}
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