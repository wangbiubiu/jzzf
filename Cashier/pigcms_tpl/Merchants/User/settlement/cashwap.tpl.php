<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>账户设置</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link href="<?php echo $this->RlStaticResource;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo RL_PIGCMS_STATIC_PATH;?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/animate_new.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/style.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/app.css" rel="stylesheet">
    <!-- Mainly scripts -->
    <script src="<?php echo $this->RlStaticResource;?>js/jquery-2.1.1.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/Cashier/pigcms_static/plugins/layer/layer.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>js/inspinia.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/pace/pace.min.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/jquery.qrcode.min.js"></script>
    <!----开放式头部，请在自己的页面加上--</head>-->
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
    <script src="https://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
    <style type="text/css">
        body{padding: 0;margin: 0;font-size: 14px;background-color: #fff;color:#333;}
        a{text-decoration: none;}
        input[type='text']{width: 100%;height: 30px;border: none;text-indent: 10px;}
    </style>
</head>
<body>
<div style="width: 100%;height: 50px;line-height: 50px;background-color: #008fd3;">
    <a href="/merchants.php?m=User&c=index&a=sindex" onclick="" style="color:#fff;padding:0 20px 0 10px;display: inline-block;">< 返回</a>
</div>
<div style="padding:15px 10px;border-bottom: 1px solid #efefef;">
    <form id="form1" onsubmit="return isSubmit()" method="post" action="/merchants.php?m=User&c=settlement&a=iscash">
        <div style="padding:10px 0 0;color:#666;">提现金额</div>
        <div style="padding:0px;font-size: 50px;">￥<input type="text" name="money" style="height: 54px;width: 200px;border: none;-webkit-appearance: none;padding:0;margin:0;" placeholder=""/></div>
        <div style="border-top: 1px solid #efefef;padding-top: 10px;font-size: 12px;color:#999;">可用余额：<?php echo $usermoney; ?>元（提现单笔3元手续费）</div>
        <div style="margin-top: 20px;text-align: center;">
            <input type="submit" value="立即提现" style="border: none;color:#fff;background-color: #008fd3;width: 200px;height: 40px;"/>
        </div>
    </form>
    <script type="text/javascript">
        function isSubmit(){
            var bank = '<?php echo $bank; ?>';
            var usermoney = parseFloat("<?php echo $usermoney; ?>");
            var cashmoney = parseInt($("input[name='money']").val());
            if(bank == "0"){
                swal('没有设置银行信息!', "", 'error');
                return false;
            }
            if(bank == "1"){
                swal('银行信息未审核!', "", 'error');
                return false;
            }
            if(bank == "2"){
                swal('银行信息错误，请先修改!', "", 'error');
                return false;
            }
            if(cashmoney.trim() == ""){
                swal('请输入提现金额!', "", 'error');
                return false;
            }
            if(usermoney < cashmoney){
                swal('提现金额大于可提金额!', "", 'error');
                return false;
            }
            if(cashmoney > 5000){
                swal('单笔提现最高5000元!', "", 'error');
                return false;
            }
            if(cashmoney < 5){
                swal('单笔提现最低5元!', "", 'error');
                return false;
            }
            return true;
        }
    </script>
</div>
<div style="padding: 10px;border-bottom: 1px solid #efefef;">
    <form method="get" action="/merchants.php?m=User&c=settlement&a=cash">
        <input type="hidden" name="m" value="User"/>
        <input type="hidden" name="c" value="settlement"/>
        <input type="hidden" name="a" value="cash"/>
        <div style="padding: 10px 0;">
            <div style="width: 20%;float:left;line-height: 30px;">选择日期</div>
            <div style="width: 80%;float:right;">
                <input type="text" readonly="readonly" value="<?php if(isset($getdata['start'])) echo $getdata['start'];?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style="text-indent: 0;text-align: center; padding:5px 10px;margin-bottom: 0px; width: 40%;border: 1px solid #efefef;height: 30px;display: inline-block;">
                <span style="width: 15%;display: inline-block;text-align: center;">到</span>
                <input type="text" readonly="readonly" value="<?php if(isset($getdata['end'])) echo $getdata['end'];?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style="text-indent: 0;text-align: center; padding:5px 10px;margin-bottom: 0px; width: 40%;border: 1px solid #efefef;height: 30px;display: inline-block;">
            </div>
            <div style="clear: both;"></div>
        </div>
        <div style="padding: 0 0 10px;">
            <div style="width: 20%;float:left;line-height: 30px;">划账状态</div>
            <div style="width:80%;float:right;">
                <select name="status" style="width: 50%;height: 30px;text-indent: 10px;border: 1px solid #efefef;">
                    <option value="">全部</option>
                    <option value="1" <?php if($_GET['status'] == 1){echo 'selected="selected"';} ?>>未划账</option>
                    <option value="2" <?php if($_GET['status'] == 2){echo 'selected="selected"';} ?>>已划账</option>
                </select>
                <input type="submit" value="搜索" style="width: 30%;height: 30px;border: none;color:#fff;background-color: #008fd3;"/>

            </div>

            <div style="clear: both;"></div>
        </div>
    </form>
</div>
<div style="padding:0 10px;">
    <style type="text/css">
        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9{
            padding: 0;;
        }
        input[type='text']{border: 1px solid #eee;;height: auto;width: auto;}
        .pagination{margin: 0 0 20px;}
    </style>
    <table border="1" class="payment1" style="margin: 20px 0 20px 0;text-align: center;" width="100%" bordercolor="#e0e0e0">
        <tbody>
        <tr style="height: 40px;">
            <th style="text-align: center;">时间</th>
            <th style="text-align: center;">提现金额</th>
            <th style="text-align: center;">到账金额</th>
            <th style="text-align: center;">状态</th>
        </tr>
        <?php if(!empty($rows)){ foreach ($rows as $ssk => $ssv): ?>
            <tr class="widget-list-item bd_nr" style="height:40px;text-align: center;">
                <td><?php echo date('m-d H:i',$ssv['addtime']); ?></td>
                <td style="display: none;">
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
                <td style="display: none;"><?php echo $ssv['bank']['acctNo']; ?></td>
                <td style="display: none;"><?php echo $ssv['bank']['customerName']; ?></td>
                <td><?php echo $ssv['money2']; ?></td>
                <td><?php echo $ssv['money']; ?></td>
                <td><span class="<?php if ($ssv['status']==2){echo 'w';}if($ssv['status']==1){echo 'y';}if($ssv['status']==0){echo 'z';} ?>hz"><?php if ($ssv['status']==2){echo '未到账';}if($ssv['status']==1){echo '已到账';}if($ssv['status']==0){echo '提现中';} ?></span></td>
            </tr>
        <?php endforeach ?>
        <?php } ?>
        </tbody>
    </table>
    <?php echo $pagebar;?>
</div>
<script src="/Cashier/pigcms_static/plugins/cashier/commonfunc.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.input-sm').datepicker({
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
    });
</script>
</body>
</html>