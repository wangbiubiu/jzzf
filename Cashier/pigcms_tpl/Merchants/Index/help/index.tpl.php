<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>收银台帮助中心</title>

    <link href="<?php echo $this->RlStaticResource;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>font-awesome/css/font-awesome.css" rel="stylesheet">
	 <link href="<?php echo $this->RlStaticResource;?>plugins/css/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/animate_new.css" rel="stylesheet">
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/style.css" rel="stylesheet">
</head>

<body>

    <div id="wrapper">
        <div class="gray-bg">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10 col-lg-offset-1">
                    <h2>帮助中心</h2>
                    <ol class="breadcrumb">
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

        <div class="wrapper wrapper-content  animated fadeInRight article">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="text-center article-title">
                                <h2>
                                    收银台使用帮助中心(支付宝收银步骤也是一样)
                                </h2>
                            </div>
                            <p>
                                <strong>1、扫码枪收银使用方法：首先然后让消费者打开微信——我——钱包——付款，用TAB键切换到输入商品描述、收款金额和付款条形码输入框，最后扫码枪扫微信付款码的条形码收款。</strong>
                            </p>
                            <div>
							   <img src=".<?php echo $imgpath;?>/pigcms_tpl/Merchants/Static/images/bz1.jpg">
							   <br/>
							   <br/>
								<p>2、扫码枪退款使用方法：让消费者打开微信的微信支付凭证找到需要退款的凭证，然后打开扫码退款功能，用扫码枪扫商户单号的条形码或手动输入数字退款。或者到扫码枪收银记录中操作退款。</p>
							    <img src=".<?php echo $imgpath;?>/pigcms_tpl/Merchants/Static/images/bz2.jpg">
								<br/>
								<br/>
								<p>3、二维码收银使用方法：输入商品描述、收款金额，然后生成二维码让客户扫码付款即可。（一次性二维码：只能一个客户扫一次即失效；永久金额二维码：永久不限次数使用，可作为每个商品独立的二维码使用；自助付款二维码：永久不限次数使用，客户扫码后自助输入付款金额。）</p>
							    <img src=".<?php echo $imgpath;?>/pigcms_tpl/Merchants/Static/images/bz3.jpg">
								<br/>
								<br/>
                            </div>
							
                            <hr>
                            <div class="row">

                            </div>


                        </div>
                    </div>
                </div>
            </div>


        </div>

        </div>
        </div>

</body>

</html>
