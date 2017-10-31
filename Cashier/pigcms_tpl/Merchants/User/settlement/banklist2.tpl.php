
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
                   


</body>
</html>