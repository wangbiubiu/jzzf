
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> 商户中心 | 结算中心</title>
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
        .bd_nr>td{ line-height: 30px !important; height:30px !important; padding: 10px 0px 0px !important;text-align: center;}
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
        h3{ width: 100%; height: 40px; line-height: 40px; border-bottom: 1px solid #f2f2f2; border-top: 3px solid #B5D6FD; font-size: 18px; background: #FFFFFF; margin: 0px; padding-left: 10px; font-weight: normal;}
        th{ font-size: 16px }
        .sl{background: #ebebed; border-bottom: 1px solid #EEEEEE;border-top: 1px solid #EEEEEE; height: 40px; line-height: 40px; text-align: right;}
        .sl>span{margin-right: 40px;}
        .fl{float: left;}
        .fr{ float: right;}

        .whz{color: red;}
        .yhz{color: green;}
        tbody>tr>td{ padding: 10px 0 !important;text-align: center;}
        .btns{
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px
        }
    </style>
</head>

<body>

<div id="wrapper">
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>

    <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>商户结算</h2>
                <ol class="breadcrumb">
                    <li>
                        <a>Agent</a>
                    </li>
                    <li>
                        <a>商户中心</a>
                    </li>

                    <li class="active">
                        <strong>我的结算</strong>
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
                        <h3>我的结算</h3>
                        <div class="ibox-content" style="border-top:none; margin-bottom:20px">
                            <div class="employersDelAll" >

                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter="#filter" style="border: 1px solid #f2f2f2;">
                                    <thead>
                                    <tr style="background: #f2f2f2">
                                        <th style="text-align: center;"  data-hide="phone">日期</th>
                                        <th  style="text-align: center;">应结结算金额（实时）</th>
                                        <th style="text-align: center;" data-hide="phone">可提现金额</th>
                                        <th style="text-align: center;" data-hide="phone">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody class="js-list-body-region" id="table-list-body">

                                    <tr class="widget-list-item bd_nr" style="text-align: center;">

                                        <td><?php echo date('Y-m-d H:i:s',time()); ?></td>
                                        <td><?php if(!empty($total[0]['money'])){echo $total[0]['money'];}else{echo 0;} ?></td>

                                        <td>
                                            <?php if (!empty($order_money[0]['money'])) {echo $order_money[0]['money'];}else{echo 0;} ?>
                                        </td>
                                        <td>
                                            <p>
                                                <button class="btn btn-sm btn-info" style="background: #008fd3;" >申请提现</button>

                                            </p>
                                        </td>

                                    </tr>

                                    </tbody>
                                </table>
                                <p style="color: red;">注：应结算金额为提醒的实时金额，可提现金额不包括当日应结算金额，申请提现每笔扣提现手续费3元</p>
                            </div>
                        </div>
                        <!--
                                作者：2721190987@qq.com
                                时间：2016-10-20
                                描述：已划账
                            -->
                        <div class="cashier-realtime">
                            <form action="" method="get" >
                                <div id="dataselect" class="form-group" style="padding: 0 10px;">
                                    <input type="hidden" name='m' value='User'>
                                    <input type="hidden" name='c' value='settlement'>
                                    <input type="hidden" name='a' value='index'>
                                    <div id="datepicker" class="input-daterange">
                                        <label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" value="<?php echo $getdata['start']?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" height: 40px; margin-bottom: 0px; width: 20%;">
                                        &nbsp;<span> 到 </span>&nbsp;
                                        <input type="text" value="<?php echo $getdata['end']?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" height: 40px; margin-bottom: 0px; width: 20%;">
                                        &nbsp;&nbsp;&nbsp;<input class="btns btn-primary" type="submit" value="查 询" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btns btn-primary" id="excel" style="width:100px;" >导出excel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <h3>提现记录</h3>
                        <div class="ibox-content" >

                            <div class="employersDelAll" >

                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter style="margin-bottom: 0px;">
                                    <thead>
                                    <tr style="background: #f2f2f2">
                                        <th  style="text-align: center;">提现时间</th>
                                        <th style="text-align: center;"  data-hide="phone">开户银行</th>
                                        <th style="text-align: center;"  data-hide="phone">银行卡号</th>
                                        <th style="text-align: center;"  data-hide="phone">开户姓名</th>
                                        <th  style="text-align: center;">收款金额</th>
                                        <th style="text-align: center;" data-hide="phone">提现金额</th>
                                        <th style="text-align: center;" data-hide="phone">订单状态</th>
                                    </tr>
                                    </thead>
                                    <tbody class="js-list-body-region" id="table-list-body">
                                    <?php if(!empty($data)){ ?>
                                    <tr>
                                        <td><?php echo $data['time'] ?></td>
                                        <td>
                                            <?php
                                            switch($data['bank']){
                                                case "ICBC":
                                                    echo '工商银行';
                                                    break;
                                                case "ABC":
                                                    echo '农业银行';
                                                    break;
                                                case "BOC":
                                                    echo '中国银行';
                                                    break;
                                                case "CCB":
                                                    echo '建设银行';
                                                    break;
                                                case "CMB":
                                                    echo '招商银行';
                                                    break;
                                                case "BOCM":
                                                    echo '交通银行';
                                                    break;
                                                case "CMBC":
                                                    echo '民生银行';
                                                    break;
                                                case "CNCB":
                                                    echo '中信银行';
                                                    break;
                                                case "CEBB":
                                                    echo '光大银行';
                                                    break;
                                                case "CIB":
                                                    echo '兴业银行';
                                                    break;
                                                case "BOB":
                                                    echo '北京银行';
                                                    break;
                                                case "GDB":
                                                    echo '广发银行';
                                                    break;
                                                case "HXB":
                                                    echo '华夏银行';
                                                    break;
                                                case "PAB":
                                                    echo '平安银行';
                                                    break;
                                                case "BOS":
                                                    echo '上海银行';
                                                    break;
                                                case "BOHC":
                                                    echo '渤海银行';
                                                    break;
                                                case "BOJ":
                                                    echo '江苏银行';
                                                    break;
                                                case "SPDB":
                                                    echo '浦发银行';
                                                    break;
                                                case "PSBC":
                                                    echo '邮储银行';
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $data['bankid'] ?></td>
                                        <td><?php echo $data['bankname'] ?></td>
                                        <td><?php echo $data['money'] ?></td>
                                        <td><?php echo $data['money2'] ?></td>
                                        <td><?php echo $data['status'] ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if(!empty($rows)){ foreach ($rows as $ssk => $ssv): ?>
                                        <tr class="widget-list-item bd_nr" style="text-align: center;">
                                            <td><?php if($ssv['status'] == 1){echo date('Y-m-d H:i:s',$ssv['addtime']);} ?></td>
                                            <td>
                                                <?php
                                                switch($ssv['bank']['settBankNo']){
                                                    case "ICBC":
                                                        echo '工商银行';
                                                        break;
                                                    case "ABC":
                                                        echo '农业银行';
                                                        break;
                                                    case "BOC":
                                                        echo '中国银行';
                                                        break;
                                                    case "CCB":
                                                        echo '建设银行';
                                                        break;
                                                    case "CMB":
                                                        echo '招商银行';
                                                        break;
                                                    case "BOCM":
                                                        echo '交通银行';
                                                        break;
                                                    case "CMBC":
                                                        echo '民生银行';
                                                        break;
                                                    case "CNCB":
                                                        echo '中信银行';
                                                        break;
                                                    case "CEBB":
                                                        echo '光大银行';
                                                        break;
                                                    case "CIB":
                                                        echo '兴业银行';
                                                        break;
                                                    case "BOB":
                                                        echo '北京银行';
                                                        break;
                                                    case "GDB":
                                                        echo '广发银行';
                                                        break;
                                                    case "HXB":
                                                        echo '华夏银行';
                                                        break;
                                                    case "PAB":
                                                        echo '平安银行';
                                                        break;
                                                    case "BOS":
                                                        echo '上海银行';
                                                        break;
                                                    case "BOHC":
                                                        echo '渤海银行';
                                                        break;
                                                    case "BOJ":
                                                        echo '江苏银行';
                                                        break;
                                                    case "SPDB":
                                                        echo '浦发银行';
                                                        break;
                                                    case "PSBC":
                                                        echo '邮储银行';
                                                        break;
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $ssv['bank']['acctNo']; ?></td>
                                            <td><?php echo $ssv['bank']['customerName']; ?></td>
                                            <td><?php echo $ssv['money2']; ?></td>
                                            <td><?php echo $ssv['money']; ?></td>
                                            <td><span class="<?php if ($ssv['status']==0){echo 'w';}else{echo 'y';} ?>hz"><?php if ($ssv['status']==0){echo '未';}else{echo '已';} ?>划账</span></td>
                                        </tr>
                                    <?php endforeach ?>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <p style="text-align: right; padding-right: 150px; height: 50px; background: #f2f2f2; line-height: 50px;">合计金额：<?php if (!empty($sum_money)){ echo  $sum_money;}else{echo 0;} ?> 元</p>
                            </div>
                        </div>
                        <?php echo $pagebar;?>

                    </div>
                </div>
            </div>
        </div>
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
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




<!-- FooTable -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all.min.js"></script>

<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>

<!-- Jquery Validate -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/validate/jquery.validate.min.js"></script>

<script>
    <?php if($bank == 0 || $bank == 1 || $bank == 2){ ?>
    swal({
        title: "<?php if($bank == 0){ echo '您还没有开通自动结算功能，请先设置银行卡信息!'; }elseif($bank == 1){echo '您的银行卡信息正在审核中，预计需要1-3个工作日，请耐心等待!';}else{echo '您的银行卡信息被驳回，请及时修改!'.$bankmsg.'，请修改!';} ?>",
        text: '',
        type: "error",
        closeOnConfirm: false
    }, function () {
        location.href="/merchants.php?m=User&c=settlement&a=bank";
    });
    <?php } ?>
    // 提现
    flag = true;
    $('.btn').click(function(){

        var money = <?php if($order_money[0]['money']){ echo $order_money[0]['money'];}else{echo 0;}?>;
        if(money==0){
            swal("提现金额不能为0", '', 'error');
            return false;
        }
        //可提现金额的,今天之前00:00的时间
        var time = <?php echo $time;?>;
        if(flag){
            flag = false;
            $.post('?m=User&c=settlement&a=withdrawals',{money:money,time:time},function(e){
                if(e.code==1){
                    swal({
                        title: "申请提现成功!",
                        text: '',
                        type: "success",
                        closeOnConfirm: false
                    }, function () {
                        location.reload();
                    });
                }else{
                    swal({
                        title: e.msg,
                        text: '',
                        type: "error",
                        closeOnConfirm: false
                    }, function () {
                        location.reload();
                    });

                }

            },'json');
        }
    });




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
    $(function () {
        $("#excel").click(function () {
//
            var stats= $('#datestart').val();
            var end=$('#dateend').val();
            window.location.href='?m=User&c=settlement&a=data2Excel&stats="'+stats+'"&end="'+end+'"';

        })

    })
</script>
</body>
</html>