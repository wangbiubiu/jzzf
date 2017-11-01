
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
                                        <th  style="text-align: center;">当前资金池</th>
                                        <th style="text-align: center;" data-hide="phone">当前日额</th>
                                        <th style="text-align: center;"  data-hide="phone">已用日额</th>
                                        <th style="text-align: center;"  data-hide="phone">可用日额</th>
                                        <th style="text-align: center;" data-hide="phone">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody class="js-list-body-region" id="table-list-body">

                                    <tr class="widget-list-item bd_nr" style="text-align: center;">

                                        <td><?php echo $lists['upastrict']; ?></td>
                                        <td><?php echo $lists['dayastrict'] ?></td>
                                        <td><?php echo $sum_money;?></td>
                                        <td>
                                            <?php  echo $lists['dayastrict']-$sum_money;?>
                                        </td>
                                        <td>
                                            <p>
                                                <button class="btn btn-sm btn-info jump" style="background: #008fd3;color:white;" >申请提现</button>

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
                                        &nbsp;&nbsp;&nbsp;<input class="btns btn-primary" type="submit" value="查 询" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!--<a class="btns btn-primary" id="excel" style="width:100px;" >导出excel</a>-->
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
                                    </tr>
                                    </thead>
                                    <tbody class="js-list-body-region" id="table-list-body">
                                    
                                   
                                    <?php if(!empty($rows)){ foreach ($rows as $ssk => $ssv): ?>
                                        <tr class="widget-list-item bd_nr" style="text-align: center;">
                                            <td><?php {echo date('Y-m-d H:i:s',$ssv['paytime']);} ?></td>
                                            <td>
                                             <?php echo $ssv['bank_name']?>
                                            </td>
                                            <td><?php echo $ssv['bank']; ?></td>
                                            <td><?php echo $ssv['name']; ?></td>
                                            <td><?php echo $ssv['money']; ?></td>
                                            <td><?php if($ssv['status']==1){?>处理中<?php }else{?>处理成功<?php }?></td>
                                        </tr>
                                    <?php endforeach ?>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <!--<p style="text-align: right; padding-right: 150px; height: 50px; background: #f2f2f2; line-height: 50px;">合计金额：<?php if (!empty($sum_money)){ echo  $sum_money;}else{echo 0;} ?> 元</p>-->
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
   
</script>




<!-- FooTable -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all.min.js"></script>

<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>

<!-- Jquery Validate -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/validate/jquery.validate.min.js"></script>

<script>
   $('.jump').click(function(){
	window.location.href='merchants.php?m=User&c=settlement&a=addorder';
	   })
</script>


<script>
  
</script>
</body>
</html>