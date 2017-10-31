<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商户统计</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link	href="http://cashier.b0.upaiyun.com/pigcms_static/plugins/css/datapicker/datepicker3.css" rel="stylesheet">
<script
	src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
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
    padding: 2px 8px 2px 28px;
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
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
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
								<div id="ym-select" class="form-group">
									<label class="font-noraml">选择年月</label>
									<div id="ymdatepicker" class="input-daterange input-group">
										<input type="text" value="2016-04" name="start" class="input-sm form-control" id="ymstart">
										&nbsp;<span> 到 </span>&nbsp; 
										<input type="text" value="2016-10" name="end" class="input-sm form-control" id="ymend"> 
										<span class="input-group-btn">
											<button class="btn btn-primary">搜 索</button>
											<button class="btn btn-primary">导出到excel</button>
										</span>
									</div>
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
                                				<td>2016-9-28至2016-9-28</td>
                                				<td>4548.4</td>
                                				<td>4548.4</td>
                                			</tr>
                                			<tr>
                                				<td>微信支付</td>
                                				<td>4548.4</td>
                                				<td>4548.4</td>
                                			</tr>
                                			<tr>
                                				<td>支付宝城市</td>
                                				<td>4548.4</td>
                                				<td>4548.4</td>
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
	                        		<li><span style="background-color:#33EA90"></span>支付宝城市</li>
	                        	</ul>
                        	</div>
                             </div>
                               
                            <div class="clearfix">
                                	<table border="1" class="payment1" style="margin: 30px 30px 30px 0px;" width="100%" bordercolor="#e0e0e0">
                                		<tbody>
                                			<tr>
                                				<th>交易单号</th>
                                				<th>应收金额</th>
                                				<th>退款金额</th>
                                				<th>实收金额</th>
                                				<th>交易时间</th>
                                				<th>交易类型</th>
                                				<th>付款方式</th>
                                				<th>门店</th>
                                				<th>操作</th>
                                				
                                			</tr>
                                			<tr>
                                				<td>014456478546987452</td>
                                				<td>56.5</td>
                                				<td>150</td>
                                				<td>3</td>
                                				<td>2016-9-18 10:28:08</td>
                                				<td>微信支付</td>
                                				<td>条码支付</td>
                                				<td>康庄美地店</td>
                                				<td><p class="ytk"><a href="#">已退款</a></p></td>
                                			</tr>
                                			<tr>
                                				<td>014456478546987452</td>
                                				<td>56.5</td>
                                				<td>150</td>
                                				<td>3</td>
                                				<td>2016-9-18 10:28:08</td>
                                				<td>微信支付</td>
                                				<td>条码支付</td>
                                				<td>康庄美地店</td>
                                				<td><p class="tk"><a href="#">退款</a></p></td>
                                			</tr>
                                			<tr>
                                				<td>014456478546987452</td>
                                				<td>56.5</td>
                                				<td>150</td>
                                				<td>3</td>
                                				<td>2016-9-18 10:28:08</td>
                                				<td>微信支付</td>
                                				<td>条码支付</td>
                                				<td>康庄美地店</td>
                                				<td><p class="tk"><a href="#">退款</a></p></td>
                                			</tr>
                                			<tr>
                                				<td>014456478546987452</td>
                                				<td>56.5</td>
                                				<td>150</td>
                                				<td>3</td>
                                				<td>2016-9-18 10:28:08</td>
                                				<td>微信支付</td>
                                				<td>条码支付</td>
                                				<td>康庄美地店</td>
                                				<td><p class="tk"><a href="#">退款</a></p></td>
                                			</tr>
                                		</tbody>
                                	</table>
                      
                             </div>
                            
                                
							</div>
							
							</div>
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
           var helpers = Chart.helpers;
    var doughnutData_m = [
        {
            value: 15,
            color: "#a3e1d4",
            highlight: "#1ab394",
            label: "微信支付"
        },
        {
            value: 18,
            color: "#33EA90",
            highlight: "#1ab394",
            label: "支付宝城市"
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
		/*var legendHolder = document.createElement('div');
		legendHolder.innerHTML = myNewChart.generateLegend();
		// Include a html legend template after the module doughnut itself
		helpers.each(legendHolder.firstChild.childNodes, function(legendNode, index){
			helpers.addEvent(legendNode, 'mouseover', function(){
				var activeSegment = myNewChart.segments[index];
				activeSegment.save();
				activeSegment.fillColor = activeSegment.highlightColor;
				myNewChart.showTooltip([activeSegment]);
				activeSegment.restore();
			});
		});
		helpers.addEvent(legendHolder.firstChild, 'mouseout', function(){
			myNewChart.draw();
		});*/
		$("#PieChart_m").parent().parent('.ibox-content').append(myNewChart.generateLegend());

   /* var doughnutData_w = [
        {
            value: ,
            color: "#a3e1d4",
            highlight: "#1ab394",
            label: "扫码总次数"
        },
        {
            value: ,
            color: "#CDE443",
            highlight: "#1ab394",
            label: "扫码支付次数"
        },
        {
            value: ,
            color: "#F38630",
            highlight: "#1ab394",
            label: "扫码支付金额￥"
        }
    ];

    var ctx = document.getElementById("PieChart_w").getContext("2d");
    var myNewChart = new Chart(ctx).Doughnut(doughnutData_w, doughnutOptions);
	$("#PieChart_w").parent().parent('.ibox-content').append(myNewChart.generateLegend());
    */
    /*var barData = {
        labels: ["扫码总次数", "扫码支付次数", "扫码支付金额￥"],
        datasets: [
            {
                label: "刷卡支付数据（正扫）",
                fillColor: "rgba(87,187,7,0.5)",
                strokeColor: "rgba(87,187,7,0.8)",
                highlightFill: "rgba(87,187,7,0.75)",
                highlightStroke: "rgba(87,187,7,1)",
                data: [, , ]
            },
            {
                label: "收银台扫码次数（反扫）",
                fillColor: "rgba(245,129,37,0.5)",
                strokeColor: "rgba(245,129,37,0.8)",
                highlightFill: "rgba(245,129,37,0.75)",
                highlightStroke: "rgba(245,129,37,1)",
                data: [, , ]
            }
        ]
    };

    var barOptions = {
        scaleBeginAtZero: true,
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        barShowStroke: true,
        barStrokeWidth: 2,
        barValueSpacing: 5,
        barDatasetSpacing: 1,
        responsive: true,
    }


    var ctx = document.getElementById("mwbarChart").getContext("2d");
    var myNewChart = new Chart(ctx).Bar(barData, barOptions);
	$("#mwbarChart").parent().parent('.ibox-content').append(myNewChart.generateLegend());
	*/
    var doughnutData = [
        {
            value: 0.09,
            color: "#5AC054",
            highlight: "#1ab394",
            label: "本平台(线下)支付总额"
        },
        {
            value: 0,
            color: "#a3e1d4",
            highlight: "#1ab394",
            label: "其他平台(线上)支付总额"
        },
       /* {
            value: 0,
            color: "#b5b8cf",
            highlight: "#1ab394",
            label: "退款总额"
        }*/
    ];

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


    var ctx = document.getElementById("doughnutChart").getContext("2d");
    var myNewChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);
	$("#doughnutChart").parent().parent('.ibox-content').append(myNewChart.generateLegend());
	//var myNewChart = new Chart(ctx).Pie(doughnutData,doughnutOptions);

	var lineOptions = {
		//scaleStartValue:0,
		//scaleSteps : 10,//y轴刻度的个数
		//scaleStepWidth : 100,   //y轴每个刻度的宽度
		//scaleOverride :true ,   //是否用硬编码重写y轴网格线
		scaleShowGridLines: true,
		scaleGridLineColor: "rgba(0,0,0,.05)",
		scaleGridLineWidth: 1,
		bezierCurve: true,
		bezierCurveTension: 0.4,
		pointDot: true,
		pointDotRadius: 4,
		pointDotStrokeWidth: 1,
		pointHitDetectionRadius: 20,
		datasetStroke: true,
		datasetStrokeWidth: 2,
		datasetFill: true,
		responsive: true,
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

   
</body>
</html>