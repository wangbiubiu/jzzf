<!DOCTYPE html>
<html class="" lang="zh-CN">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
  <meta charset="utf-8" /> 
  <meta name="keywords" content="" /> 
  <meta name="HandheldFriendly" content="True" /> 
  <meta name="MobileOptimized" content="320" /> 
  <meta name="format-detection" content="telephone=no" /> 
  <meta http-equiv="cleartype" content="on" /> 
  <title><?php echo $ordertmp['title'];?></title> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> 
  <link rel="stylesheet" href="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/styles/foreverpay.css"/> 
  <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/jquery.js"/> </script>
    <style>
.btn.btn-green {
    background-color: #00A0E9;
	border-color: #00A0E9;
}
  </style>
 </head> 
 <body> 
  <div class="container" style="margin-top:15px;"> 
   <div class="content fixed-cash "> 
   <form method="post" action="" name="myform" id="mydataform">
    <div class="cashier-info-container center"> 
	
     <div class="avatar cashier-avatar"> 
      <a href="javascript:;"> <img class="circular" src="<?php echo PIGCMS_STATIC_PATH_FOLDER;?>image/alibiao.png" /> </a> 
     </div> 

     <p class="avatar-price anonym"> <span class="rmb">￥</span><?php echo $ordertmp['price'];?> </p> 
     <p class="reason"> 收款理由：<?php echo $ordertmp['title'];?> </p> 
	 
    </div>
	<input type="hidden" value="<?php echo $ordertmp['mid'];?>"  name="mid">
	<input type="hidden" value="<?php echo $ordertmp['eid'];?>"  name="eid">
	<input type="hidden" value="<?php echo $ordertmp['storeid'];?>"  name="storeid">
	<input type="hidden" value="<?php echo $ordertmp['price'];?>"  name="goods_price">
	<input type="hidden" value="<?php echo $ordertmp['title'];?>"  name="goods_name">
	<input type="hidden" value="<?php echo $orderid;?>"  name="extrainfo">
	<input type="hidden" value="alipay" id="paytype" name="paytype">
	</form>
    <div class="action-container" id="js-cashier-action">
     <div style="margin-bottom: 10px;"> 
      <button class="btn-pay btn btn-block btn-large btn-umpay  btn-green" onclick="ByAliPay();"> 支付宝支付 </button>
     </div>
     <div style="margin-bottom: 10px;"> 
      <!--<button type="button" data-pay-type="baiduwap" class="btn-pay btn btn-block btn-large btn-baiduwap  btn-white"> 储蓄卡付款 </button>-->
     </div>
    </div> 
	
    <!--<div class="center action-tip js-cashier-tip">
     支付完成后，如需退款请及时联系卖家
    </div>-->
   </div> 
  </div> 
  <div class="footer"> 
  </div> 
  <script type="text/javascript">

  var formPostUrl="/merchants.php?m=Index&c=pay&a=aliwappay&ordid=<?php echo  $orderid;?>";

  </script>
	<script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/topay.js?var=<?php echo time();?>"/> </script>
 </body>
</html>