<?php /* Smarty version 2.6.18, created on 2017-06-20 11:55:42
         compiled from E:%5CWWW%5C20170619%5CCashier%5C./pigcms_tpl/Merchants/System/count/mdetail.tpl.php */ ?>
<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>商户统计</title>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
wxCoupon/wxCoupon.css" rel="stylesheet">
        <link href="<?php echo @RlStaticResource; ?>
plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="<?php echo @RL_PIGCMS_STATIC_PATH; ?>
plugins/css/footable/footable.core.css" rel="stylesheet">
        <link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
css/cashier.css" rel="stylesheet">
        <link href="<?php echo @RlStaticResource; ?>
plugins/css/datapicker/datepicker3.css" rel="stylesheet">
        <script src="<?php echo @RlStaticResource; ?>
plugins/js/datapicker/bootstrap-datepicker.js"></script>
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
            .payment tbody tr th,.payment tbody tr td{ padding: 10px 10px; text-align: center;height: 52px;}
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
                padding: 2px 12px 2px 28px;
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
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/leftmenu.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div id="page-wrapper" class="gray-bg dashbard-1">
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/top.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>商户统计</h2>
                        <ol class="breadcrumb">
                            <li>
                                <a>System</a>
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
                                        <label class="font-noraml"><?php echo $this->_tpl_vars['name']['company']; ?>
的流水统计</label>

                                    </div>
                                    <!--
            作者：2721190987@qq.com
            时间：2016-10-18
            描述：选择日期
                                    -->
                                    <form action="/merchants.php?m=System&c=count&a=mdetail" method="get">
                                        <input type="hidden" value="System" name="m" >
                                        <input type="hidden" value="count" name="c" >
                                        <input type="hidden" value="mdetail" name="a" >
                                        <div id="dataselect" class="form-group" style="padding: 0 10px;">
                                            <div id="datepicker" class="input-daterange">
                                                <label class="font-noraml">支付类型</label>
                                                <select name="type" style=" width: 120px; height: 30px; margin-bottom: 0px">
                                                    <option value="">请选择</option>
                                                    <option value="weixin" <?php if ($this->_tpl_vars['getdata']['type'] == 'weixin'): ?>selected="selected"<?php endif; ?>>微信</option>
                                                    <option value="alipay" <?php if ($this->_tpl_vars['getdata']['type'] == 'alipay'): ?>selected="selected"<?php endif; ?>>支付宝</option>
                                                </select>
                                                <label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
                                                <input type="text"  value="<?php if (( isset ( $this->_tpl_vars['getdata']['start'] ) )): ?><?php echo $this->_tpl_vars['getdata']['start']; ?>
<?php else: ?><?php echo $this->_tpl_vars['today']; ?>
<?php endif; ?>"  name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" margin-bottom: 0px; width: 20%;">
                                                &nbsp;<span> 到 </span>&nbsp;
                                                <input type="text"  value="<?php if (( isset ( $this->_tpl_vars['getdata']['end'] ) )): ?><?php echo $this->_tpl_vars['getdata']['end']; ?>
<?php else: ?><?php echo $this->_tpl_vars['today']; ?>
<?php endif; ?>"  name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" margin-bottom: 0px; width: 20%;">
                                                &nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:100px;" href="?m=System&c=count&a=data2ExcelDetail&mid=<?php echo $_GET['mid']; ?>" >导出excel</a>
                                            </div>
                                        </div>
                                    </form>
                                    <!--
            作者：2721190987@qq.com
            时间：2016-10-18
            描述：统计
                                    -->
                                    <div class="clearfix" style="height:240px; position: relative;">
                                        <table border="1" class="payment" style="margin: 30px 30px 30px 0px;" width="60%" bordercolor="#e0e0e0">
                                            <tbody>
                                                <tr>
                                                    <th>统计日期/支付方式</th>
                                                    <th>收款总额</th>
                                                    <th>实收金额</th>
                                                </tr>

                                                <?php if ($this->_tpl_vars['getdata']['type'] == 'weixin'): ?>
                                                <tr>
                                                    <td>微信支付</td>
                                                    <td><?php if (! empty ( $this->_tpl_vars['wxsum']['0']['money'] )): ?><?php echo $this->_tpl_vars['wxsum']['0']['money']; ?>
<?php else: ?>0<?php endif; ?> </td>
                                                    <td><?php if (! empty ( $this->_tpl_vars['wxsum']['0']['income'] )): ?><?php echo $this->_tpl_vars['wxsum']['0']['income']; ?>
<?php else: ?>0<?php endif; ?></td>
                                                </tr>
                                                <?php elseif ($this->_tpl_vars['getdata']['type'] == 'alipay'): ?>
                                                <tr>
                                                    <td>支付宝支付</td>
                                                    <td><?php if (! empty ( $this->_tpl_vars['alisum']['0']['money'] )): ?><?php echo $this->_tpl_vars['alisum']['0']['money']; ?>
<?php else: ?>0<?php endif; ?></td>
                                                    <td><?php if (! empty ( $this->_tpl_vars['alisum']['0']['income'] )): ?><?php echo $this->_tpl_vars['alisum']['0']['income']; ?>
<?php else: ?>0<?php endif; ?></td>
                                                </tr>
                                                <?php else: ?>
                                                    <tr>
                                                        <td><?php if ($this->_tpl_vars['getdata']['start'] && $this->_tpl_vars['getdata']['end']): ?><?php echo $this->_tpl_vars['getdata']['start']; ?>
至<?php echo $this->_tpl_vars['getdata']['end']; ?>
<?php elseif ($this->_tpl_vars['getdata']['start']): ?><?php echo $this->_tpl_vars['getdata']['start']; ?>
起<?php elseif ($this->_tpl_vars['getdata']['end']): ?><?php echo $this->_tpl_vars['getdata']['end']; ?>
止<?php else: ?>全部<?php endif; ?></td>
                                                        <td><?php if (! empty ( $this->_tpl_vars['total_sum']['0']['money'] )): ?><?php echo $this->_tpl_vars['total_sum']['0']['money']; ?>
<?php else: ?>0<?php endif; ?></td>
                                                        <td><?php if (! empty ( $this->_tpl_vars['total_sum']['0']['income'] )): ?><?php echo $this->_tpl_vars['total_sum']['0']['income']; ?>
<?php else: ?>0<?php endif; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>微信支付</td>
                                                        <td><?php if (! empty ( $this->_tpl_vars['wxsum']['0']['money'] )): ?><?php echo $this->_tpl_vars['wxsum']['0']['money']; ?>
<?php else: ?>0<?php endif; ?> </td>
                                                        <td><?php if (! empty ( $this->_tpl_vars['wxsum']['0']['income'] )): ?><?php echo $this->_tpl_vars['wxsum']['0']['income']; ?>
<?php else: ?>0<?php endif; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>支付宝支付</td>
                                                        <td><?php if (! empty ( $this->_tpl_vars['alisum']['0']['money'] )): ?><?php echo $this->_tpl_vars['alisum']['0']['money']; ?>
<?php else: ?>0<?php endif; ?></td>
                                                        <td><?php if (! empty ( $this->_tpl_vars['alisum']['0']['income'] )): ?><?php echo $this->_tpl_vars['alisum']['0']['income']; ?>
<?php else: ?>0<?php endif; ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>

                                        <!--
                                       作者：2721190987@qq.com
                                       时间：2016-10-18
                                       描述：统计图
                                        -->
                                        <div class="shanxin clearfix " style=" position: absolute; top: 30px; right: 0px; margin-top: 0px; height: 210px">
                                            <div style="text-align: center; height: 30px; line-height: 30px; background: #f2f2f2;">流水比例</div>
                                            <div>
                                                <canvas id="PieChart_m" height="150" width="350"></canvas>
                                            </div>
                                            <ul class="doughnut-legend">
                                               <li><span style="background-color:#33EA90"></span>微信支付</li>
	                        		<li><span style="background-color:#00a3d2"></span>支付宝</li>
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
                                                <?php $_from = $this->_tpl_vars['order']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['row']['order_id']; ?>
</td>
                                                    <td><?php echo $this->_tpl_vars['row']['goods_price']; ?>
</td>
                                                    <td><?php if ($this->_tpl_vars['row']['refund'] == 2): ?><?php echo $this->_tpl_vars['row']['goods_price']; ?>
<?php endif; ?></td>
                                                    <td><?php echo $this->_tpl_vars['row']['income']; ?>
</td>
                                                    <td><?php echo $this->_tpl_vars['row']['paytime']; ?>
</td>
                                                    <td><?php if ($this->_tpl_vars['row']['pay_way'] == 'weixin'): ?>微信<?php elseif ($this->_tpl_vars['row']['pay_way'] == 'alipay'): ?>支付宝<?php endif; ?></td>
                                                    <td><?php echo $this->_tpl_vars['row']['goods_describe']; ?>
</td>
                                                    <td><?php echo $this->_tpl_vars['row']['business_name']; ?>
 <?php echo $this->_tpl_vars['row']['branch_name']; ?>
</td>
                                                    <?php if ($this->_tpl_vars['row']['refund'] == 2): ?>
                                                        <td><button class="btn btn-sm" style="background: #CCC;color: #FFF;">已退款</button></td>
                                                    <?php else: ?>
                                                        <td><button class="btn btn-sm" style="background: #008000;color: #FFF;" onclick="<?php if ($this->_tpl_vars['row']['pay_way'] == 'weixin'): ?>wx<?php elseif ($this->_tpl_vars['row']['pay_way'] == 'alipay'): ?>ali<?php endif; ?>RefundBtn(this,<?php echo $this->_tpl_vars['row']['id']; ?>
,<?php echo $this->_tpl_vars['row']['mid']; ?>
);"><strong> 退&nbsp;&nbsp;&nbsp;款 </strong></button> </td>
                                                    <?php endif; ?>
                                                </tr>
                                                <?php endforeach; endif; unset($_from); ?>


                                            </tbody>
                                        </table>
                                    <?php echo $this->_tpl_vars['pagebar']; ?>

                                    </div>


                                </div>

                            </div>
                        </div>
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
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <script type="text/javascript">
        if (mobilecheck()) {
            $("#side-menu li").click(function () {
                $("#side-menu li").find('.nav-second-level').css('display', 'none');
                $(this).find('.nav-second-level').css('display', 'block').css('min-width', '140px');
            });
        }
        if (navigator.userAgent.indexOf("AlipayClient") != -1) {
            $('#shou-kuan').attr('href', '/merchants.php?m=User&c=alicashier&a=alipayment&type=1');
            $('#tui-kuan').attr('href', '/merchants.php?m=User&c=alicashier&a=alipayment&type=2');
        }
    </script>
</div>
</div>
<script src="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
cashier/commonfunc.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
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



        var screenH = $(window).height();
        screenH = screenH - 20;
        $('#oderinfo').css('height', screenH);



        var helpers = Chart.helpers;
        var doughnutData_m = [
            {
                value: <?php if ($this->_tpl_vars['getdata']['type'] == 'alipay'): ?><?php echo 0; ?>
<?php else: ?> <?php if (! empty ( $this->_tpl_vars['wxsum']['0']['money'] )): ?><?php echo $this->_tpl_vars['wxsum']['0']['money']; ?>
<?php else: ?>0<?php endif; ?> <?php endif; ?>,
                color: "#33EA90",
            highlight: "#4BFFA8",
                label: "微信支付"
            },
            {
                value: <?php if ($this->_tpl_vars['getdata']['type'] == 'weixin'): ?><?php echo 0; ?>
<?php else: ?> <?php if (! empty ( $this->_tpl_vars['alisum']['0']['money'] )): ?><?php echo $this->_tpl_vars['alisum']['0']['money']; ?>
<?php else: ?>0<?php endif; ?> <?php endif; ?>,
                color: "#00a3d2",
            highlight: "#24c7f6",
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
            tooltipTemplate: "<%if (label){%><%=label%>: ￥<%}%><%= value %> 元", animation: false
        };




        function GetChartData(typ, idstr, idstr2) {
            $('#canvascontext').html('<canvas height="100" id="linecountChart"></canvas>');
            var start = $.trim($('#datestart').val());
            var end = $.trim($('#dateend').val());
            var store_id = parseInt($('#store').val());
            var pdatas = {
                'typ': typ,
                'dstart': start,
                'dend': end,
                'store_id': store_id
            }
            $.post('/merchants.php?m=User&c=statistics&a=getchart', pdatas, function (ret) {
                /*data = $.parseJSON(data);*/
                $('#' + idstr2 + ' .price1').text(' ' + ret.expand.microC);
                $('#' + idstr2 + ' .price2').text(' ' + ret.expand.nomicroC);
                $('#' + idstr2 + ' .price3').text(' ' + ret.expand.barcodep);
                $('#' + idstr2 + ' .price4').text(' ' + ret.expand.nobarcodep);
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

                if (typeof (ret.ydata.idx2) != 'undefined') {
                    var tmpobj = {
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

                if (typeof (ret.ydata.idx3) != 'undefined') {
                    var tmpobj = {
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
                if (typeof (ret.ydata.idx4) != 'undefined') {
                    var tmpobj = {
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
                $("#" + idstr).parent().parent('.ibox-content').append(myNewChart.generateLegend());
            }, 'JSON');
        }
        GetChartData('smcount', 'linecountChart', 'canvasdesc');
        $('#dataselect .btn-primary').click(function () {
            GetChartData('smcount', 'linecountChart', 'canvasdesc');
        });
    });


</script>

<script>
    /******导出处理********/
    var tipshtm = '';
    var excellock = false;
    function exportExcel() {
        if (excellock) {
            $('#Export_excel_pop').show();
            $('body').append('<div class="modal-backdrop in"></div>');
            return false;
        }
        excellock = true;
        $('#Export_excel_pop ul').html('<li style="padding-top:20px;">正在导出您的数据，请稍等......</li>');
        $('#Export_excel_pop').show();
        $('body').append('<div class="modal-backdrop in"></div>');
        var fromData = $('form').serialize();
        $.post('/merchants.php?m=User&c=statistics&a=exportExcel', fromData, function (resp) {
            if (resp.error) {
                alert(resp.msg);
                return false;
            } else {
                if (resp.tt > 0) {
                    tipshtm = "<li>已经导出1到5000数据......." +
                            "<li id='extpage_1'>正在为您导出5001到10000条数据......</li>";
                    $('#Export_excel_pop ul').append(tipshtm);
                    Run_Export_excel(2);
                } else {
                    tipshtm = "<li>数据导出完成&nbsp;&nbsp;&nbsp;<a href='" + resp.fileurl + "'>下载<a></li>"
                    $('#Export_excel_pop ul').append(tipshtm);
                    excellock = false;
                }
            }
        }, 'json');

        return false;
    }



    function Run_Export_excel(page) {
        var fromData = $('form').serialize();
        fromData = fromData + '&page=' + page;
        $.post('/merchants.php?m=User&c=statistics&a=exportExcel', fromData, function (resp) {
            if (resp.error) {
                alert(resp.msg);
                return false;
            } else {
                var tmp = resp.p + 1;
                var idxs = (page - 1);
                if (!resp.flag && (tmp <= resp.tt)) {
                    var mc1 = 5000 * idxs + 1;
                    var mc2 = 5000 * page;
                    var mc3 = 5000 * tmp;
                    $('#extpage_' + idxs).html('已经导出' + mc1 + '到' + mc2 + '数据.......');
                    mc2 = mc2 + 1;
                    tipshtm = "<li id='extpage_" + page + "'>正在为您导出" + mc2 + "到" + mc3 + "条数据......</li>";
                    $('#Export_excel_pop ul').append(tipshtm);
                    Run_Export_excel(tmp);
                } else {
                    tipshtm = "<li id='extpage_end'>完成导出,正在为你打包导出的文件......</li>";
                    $('#Export_excel_pop ul').append(tipshtm);
                    if (true) {
                        $.post('/merchants.php?m=User&c=statistics&a=export_excel_zip', {page: resp.p}, function (rest) {
                            if (rest.error) {
                                alert(resp.msg);
                                return false;
                            } else {
                                tipshtm = "<li>打包完成。&nbsp;&nbsp;&nbsp;<a href='" + rest.fileurl + "'>下 载<a></li>";
                                $('#Export_excel_pop ul').append(tipshtm);
                                excellock = false;
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