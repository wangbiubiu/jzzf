<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>结算管理 | 平台提现</title>
    {pg:include file="$tplHome/System/public/header.tpl.php"}


    <!-- FooTable -->
    <link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
    <link href="{pg:$smarty.const.RlStaticResource}plugins/css/iCheck/custom.css" rel="stylesheet">
    <link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}css/cashier.css" rel="stylesheet">
    <link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="{pg:$smarty.const.RlStaticResource}plugins/css/datapicker/datepicker3.css" rel="stylesheet">
    <script src="{pg:$smarty.const.RlStaticResource}plugins/js/datapicker/bootstrap-datepicker.js"></script>
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
        .ibox-content{
            padding: 15px 20px 50px 20px;
        }
        .tit ul li{ float: left; list-style: none; color: #b1bac8; cursor: pointer; height: 40px; line-height: 40px; width: 110px; text-align: center;}
        .tit ul li:hover{ color: #8f99a7;}
        .tit ul li a{display: inline-block; width: 100%; height: 100%; color:#999999}
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
    {pg:include file="$tplHome/System/public/leftmenu.tpl.php"}

    <div id="page-wrapper" class="gray-bg">
        {pg:include file="$tplHome/System/public/top.tpl.php"}
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>平台提现</h2>
                <ol class="breadcrumb">
                    <li>
                        <a>System</a>
                    </li>
                    <li>
                        <a>结算中心</a>
                    </li>

                    <li class="active">
                        <strong>平台提现</strong>
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
                        <li> <a href="/merchants.php?m=System&c=settlement&a=cash">平台提现</a></li>
                        <li class="cont"><a href="/merchants.php?m=System&c=settlement&a=cashlist">提现记录</a></li>


                    </ul>
                </div>

                <div class="col-lg-12">
                    <div class="ibox float-e-margins">

                        <!--
                                    作者：2721190987@qq.com
                                    时间：2016-10-20
                                    描述：已划账
                        -->
                        <div class="ibox-content" style="border-top:none">
                            <form action="/merchants.php?m=System&c=settlement&a=cashlist" method="get">
                                <input type="hidden" value="System" name="m" >
                                <input type="hidden" value="settlement" name="c" >
                                <input type="hidden" value="cashlist" name="a" >
                                <div id="dataselect" class="form-group" style="padding: 0 10px;">
                                    <div id="datepicker" class="input-daterange">
                                        <label class="font-noraml">信息搜索</label>
                                        <input class="input form-control" type="text" name="txt" value="{pg: if (isset($data.txt))}{pg: $data.txt}{pg:/if}" placeholder="输入开户姓名/银行卡号/手机号码" style="width: 17%;border-radius:3px;height: 30px; margin-bottom: 0px;">
                                        <label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" value="{pg: if (isset($data.start))}{pg: $data.start}{pg:/if}" name="start" class="input-sm form-control" id="start" placeholder="开始时间" style=" margin-bottom: 0px; width: 17%;border-radius:3px;height: 30px">
                                        &nbsp;<span> 到 </span>&nbsp;
                                        <input type="text" value="{pg: if (isset($data.end))}{pg: $data.end}{pg:/if}" name="end" class="input-sm form-control" id="end" placeholder="结束时间" style=" margin-bottom: 0px; width: 17%;border-radius:3px;height: 30px">
                                        &nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">
                                        <!--                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:100px;" href="?m=System&c=settlement&a=data2Excel&type=mchb" >导出excel</a>-->
                                    </div>
                                </div>
                            </form>
                            <div class="employersDelAll" >
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter style="margin-bottom: 0px;">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;"  data-hide="phone">订单号码</th>
                                        <th style="text-align: center;"  data-hide="phone">开户银行</th>
                                        <th style="text-align: center;"  data-hide="phone">银行卡号</th>
                                        <th style="text-align: center;"  data-hide="phone">开户姓名</th>
                                        <th style="text-align: center;"  data-hide="phone">手机号码</th>
                                        <th  style="text-align: center;">发起提现时间</th>
                                        <th style="text-align: center;" data-hide="phone">提现金额</th>
                                        <th style="text-align: center;" data-hide="phone">提现状态</th>
                                    </tr>
                                    </thead>
                                    <tbody class="js-list-body-region" id="table-list-body">
                                    {pg:foreach item=vv from=$rows}
                                    <tr class="widget-list-item bd_nr" style="text-align: center;">
                                        <td>{pg:$vv.orderNo}</td>
                                        <td>
                                            {pg: if ($vv.settBankNo == "ICBC")}工商银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "ABC")}农业银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "BOC")}中国银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "CCB")}建设银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "CMB")}招商银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "BOCM")}交通银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "CMBC")}民生银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "CNCB")}中信银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "CEBB")}光大银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "CIB")}兴业银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "BOB")}北京银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "GDB")}广发银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "HXB")}华夏银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "PAB")}平安银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "BOS")}上海银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "BOHC")}渤海银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "BOJ")}江苏银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "SPDB")}浦发银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "PSBC")}邮储银行{pg:/if}
                                            {pg: if ($vv.settBankNo == "")}其他银行{pg:/if}
                                        </td>
                                        <td>{pg:$vv.acctNo}</td>
                                        <td>{pg:$vv.customerName}</td>
                                        <td>{pg:$vv.phoneNo}</td>
                                        <td>{pg:$vv.time}</td>
                                        <td>{pg:$vv.transAmt}</td>
                                        <td>{pg: if ($vv.state == "0")}提现中{pg: else}提现成功{pg:/if}</td>
                                    </tr>
                                    {pg:/foreach}


                                    </tbody>
                                </table>
                                <p style="text-align: right; padding-right: 150px; height: 50px; background: #f2f2f2; line-height: 50px;">合计金额:{pg:$total}元</p>
                            </div>
                            {pg:$pagebar}
                        </div>

                        <!--
                                    作者：2721190987@qq.com
                                    时间：2016-10-20
                                    描述：打印机
                        -->

                        <!--
                                作者：2721190987@qq.com
                                时间：2016-10-20
                                描述：end
                        -->

                    </div>
                </div>
            </div>
        </div>
        {pg:include file="$tplHome/System/public/footer.tpl.php"}
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
<script>
    $(".tit>ul>li").click(function () {
        var index = $(this).index();
        var web = $(this).text();
        $(".active>strong").html(web)
        $(this).addClass("cont")
        $(this).siblings().removeClass("cont");

    });
    window.onload=function(){
        var index =  $(".cont").index();
        $(".ibox>div").eq(index).show();
        $(".ibox>div").eq(index).siblings().hide();

    }
</script>


<script type="text/html" id="employersEditTpl">
    <figure>
        <iframe width="425" height="349" src="?m=User&c=merchant&a=employersEdit&eid={($eid)}" frameborder="0"></iframe>
    </figure>
</script>

<!-- FooTable -->
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/footable/footable.all.min.js"></script>

<!-- iCheck -->
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/iCheck/icheck.min.js"></script>

<!-- Jquery Validate -->
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/validate/jquery.validate.min.js"></script>


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
<script type="text/javascript">
    $(document).ready(function () {
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

        GetChartData('smcount', 'linecountChart', 'canvasdesc');
        $('#dataselect .btn-primary').click(function () {
            GetChartData('smcount', 'linecountChart', 'canvasdesc');
        });
    });
</script>
</body>
</html>