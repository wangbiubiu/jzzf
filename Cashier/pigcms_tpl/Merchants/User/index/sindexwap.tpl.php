<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>商户中心</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <style type="text/css">
        body{padding: 0;margin: 0;font-size: 14px;background-color: #fff;color:#333;}
        a{text-decoration: none;}
    </style>
</head>
<body>
<div style="width: 100%;height: 100px;background-color: #008fd3;">
    <div style="width: 100%;height: 50px;line-height: 50px;">
        <a style="display: block;float:left;margin-left: 10px;color:#fff;">我的账户</a>
        <a href="/merchants.php?m=User&c=pay&a=ModifyPwd" style="display: block;float:right;margin-right: 10px;color:#fff;">商户管理 ></a>
    </div>
</div>
<div style="margin: -50px 10px 0;padding:20px 0;background-color: #fff;border-radius: 5px;box-shadow: 0 0 10px #008fd3;">
    <div style="text-align: center;color:#999;">
        今日收款金额（元）
    </div>
    <div style="text-align: center;font-size: 24px;line-height: 50px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">
        <?php echo sprintf("%.2f",$money2); ?>
    </div>
    <div style="margin: 10px 10px 0;border-top: 1px solid #f5f5f5;padding-top:15px;">
        <div style="width: 49%;float:left;text-align: center;border-right: 1px solid #f5f5f5;">
            <div style="line-height: 30px;font-size: 18px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;"><?php echo sprintf("%.2f",$money); ?></div>
            <div style="color:#999;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">昨日收款金额（元）</div>
        </div>
        <div style="width: 49%;float:right;text-align: center;">
            <div style="line-height: 30px;font-size: 18px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;"><?php echo $number; ?></div>
            <div style="color:#999;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">昨日收款笔数（笔）</div>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>
<div style="margin: 30px 10px;">
    <a href="/merchants.php?m=User&c=count&a=index" style="width: 25%;text-align: center;display: block;float:left;color:#333;">
        <div>
            <img src="./Cashier/pigcms_static/image/jycx.jpg"/>
        </div>
        <div>交易查询</div>
    </a>
    <?php if($mtype == 2){ ?>
        <?php if($sub_merchant != 1){//孙商户 ?>
            <a href="/merchants.php?m=User&c=settlement&a=cash" style="width: 25%;text-align: center;display: block;float:left;color:#333;">
                <div>
                    <img src="./Cashier/pigcms_static/image/qscx.jpg"/>
                </div>
                <div>我要提现</div>
            </a>
        <?php }else{ ?>
            <a href="/merchants.php?m=User&c=settlement&a=index" style="width: 25%;text-align: center;display: block;float:left;color:#333;">
                <div>
                    <img src="./Cashier/pigcms_static/image/qscx.jpg"/>
                </div>
                <div>清算记录</div>
            </a>
        <?php } ?>
    <a href="/merchants.php?m=User&c=settlement&a=bank" style="width: 25%;text-align: center;display: block;float:left;color:#333;">
        <div>
            <img src="./Cashier/pigcms_static/image/yhk.jpg"/>
        </div>
        <div>银行卡设置</div>
    </a>
    <?php } ?>
    <a href="/merchants.php?m=User&c=index&a=logout" style="width: 25%;text-align: center;display: block;float:left;color:#333;">
        <div>
            <img src="./Cashier/pigcms_static/image/tc.jpg"/>
        </div>
        <div>退出管理</div>
    </a>
    <a href="javascript:;" style="width: 25%;text-align: center;display: block;float:left;color:#999;">
        <div>
            <img src="./Cashier/pigcms_static/image/jqqd.jpg"/>
        </div>
        <div>敬请期待</div>
    </a>
    <div style="clear: both;"></div>
</div>
</body>
</html>