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
        body{padding: 0;margin: 0;font-size: 14px;background-color: rgb(239,239,239);color:#333;}
        a{text-decoration: none;}
        input[type='text']{width: 100%;height: 40px;border: none;text-indent: 10px;}
    </style>
</head>
<body>
<div style="padding: 10px;height: 50px;">
    <form method="get" action="/merchants.php?m=User&c=count&a=store">
        <input type="hidden" value="User" name="m"/>
        <input type="hidden" value="count" name="c"/>
        <input type="hidden" value="store" name="a"/>
        <div style="width: 90%;float:left;">
            <input class="" type="text" name="branch_name" placeholder="输入门店名称" value="" style="border-radius: 5px;border: none;">
        </div>
        <div style="width: 10%;float:right;text-align: center;">
            <input type="submit" value="搜索" style="border: none;background: none;height: 40px;"/>
        </div>
    </form>
</div>
<a href="/merchants.php?m=User&c=count&a=index" style="width: 100%;height: 50px;line-height:50px;text-indent:10px;color:#333;background-color: #fff;border-top: 1px solid #eee;border-bottom: 1px solid #eee;margin-top: 10px;display: block;">
    全部门店
</a>
<?php
if(!empty($store)){
foreach($store as $k=>$v){ ?>
    <a href="/merchants.php?m=User&c=count&a=storesdetail&id=<?php echo $v['id']?>" style="width: 100%;height: 50px;line-height:50px;text-indent:10px;color:#333;background-color: #fff;border-top: 1px solid #eee;border-bottom: 1px solid #eee;margin-top: 10px;display: block;">
        <?php echo  $v['business_name']."&nbsp;".$v['branch_name'] ?>
    </a>
<?php  }} ?>
<?php echo $pagebar;?>
</body>
</html>