<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>收银员统计</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/cashier.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
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
    .store tbody tr td p{ margin-bottom: 0px; padding: 10px 0;}
    .store tbody tr td p:first-child{ border-bottom: 1px solid #f2f2f2;}
    .store tbody tr td button{padding: 0 20px; height: 30px; line-height: 30px; text-align: center; background: #36a9e0; border: none; border-radius: 5px;}
    .store tbody tr td button a{ color: #FFFFFF;}

    .ze{ background: #f2f2f2; height: 50px; line-height: 50px; width: 98%; margin-left: 1%;}
    .ze>p{ float: right; margin-right: 50px;}
    .ze>p:nth-child(3){ margin-left: 50px;}
    .bg_hide{display: none;}
</style>
<body>
<div id="wrapper">
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/managerleft.tpl.php';?>
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>收银员统计</h2>
                <ol class="breadcrumb">
                    <li>
                        <a>User</a>
                    </li>
                    <li>
                        <a>统计管理</a>
                    </li>
                    <li class="active">
                        <strong>收银员统计</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row wrapper page-heading iconList" style="margin-top: 30px; border-top: 3px solid #edfbfe;">


            <!--
                作者：2721190987@qq.com
                时间：2016-10-19
                描述：微信支付数据
            -->
            <div class="store_nr">
                <div class="wrapper wrapper-content animated fadeInRight" style="width: 98%; background: #FFFFFF;">
                    <div class="row">
                        <form action="/merchants.php?m=User&c=manager&a=CashierCount" method="get">
                            <input type="hidden" value="User" name="m">
                            <input type="hidden" value="manager" name="c">
                            <input type="hidden" value="CashierCount" name="a">
                            <div id="dataselect" class="form-group" style="padding: 0 10px;width:98%">
                                <div id="datepicker" class="input-daterange">
                                    <label class="font-noraml">收银员名称</label>
                                    <input class=" form-control" type="text" name="username" placeholder="输入员工名称" value="<?php if(isset($getdata['username'])) echo $getdata['username'];?>" style="width: 20%;border-radius: 7px;height: 40px; margin-bottom: 0px;">
                                    <label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
                                    <input type="text" value="<?php if(isset($getdata['start'])){echo $getdata['start'];}else{echo date('Y-m-d');}?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" margin-bottom: 0px; width: 20%;">
                                    &nbsp;<span> 到 </span>&nbsp;
                                    <input type="text" value="<?php if(isset($getdata['end'])) {echo $getdata['end'];}else{echo date('Y-m-d');}?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" margin-bottom: 0px; width: 20%;">
                                    &nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:100px;" href="javascript:exportExcel();" >导出到excel</a>
                                </div>
                            </div>
                        </form>
                        <table class="store" border="1" bordercolor="#f2f2f2"  style="width:98%;margin-left:1%;">
                            <tbody>
                            <tr>
                                <th>收银员名称</th>
                                <th>支付方式</th>
                                <th>支付金额</th>
                                <th>交易笔数</th>

                                <th>操作</th>
                            </tr>

                            <?php
                            if(!empty($store)){
                                foreach($store as $k=>$v){ ?>

                                    <tr>
                                        <td><?php echo  $v['username'] ?></td>
                                        <td>
                                            <p>微信支付</p>
                                            <p>支付宝城市</p>
                                        </td>
                                        <td>
                                            <p><?php echo  $v['wxtotal_price'] ?> 元</p>
                                            <p><?php echo  $v['alitotal_price'] ?> 元</p>
                                        </td>
                                        <td>
                                            <p><?php echo  $v['wxcount'] ?></p>
                                            <p><?php echo  $v['alicount'] ?></p>
                                        </td>

                                        <td><a href="/merchants.php?m=User&c=manager&a=StaffCount&id=<?php echo $v['eid']?>"><button style="color:#FFFFFF;">查看</button></a></td>
                                    </tr>


                                <?php  }} ?>

                            </tbody>
                        </table>
                        <div class="ze">
                            <p>总收入：<?php echo $sum; ?>元</p>
                            <p>总笔数：<?php echo $num; ?>笔</p>

                        </div>
                    </div>
                    <?php echo $pagebar;?>
                </div>



            </div>
        </div>
    </div>
    <form action="/merchants.php?m=User&c=manager&a=CashierCountExecl" method="post" id="CashierCountExecl">

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
        $('#CashierCountExecl').submit();
    }


</script>
</body>
</html>