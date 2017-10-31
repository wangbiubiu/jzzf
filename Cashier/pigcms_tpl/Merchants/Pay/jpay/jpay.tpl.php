<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>收银台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <style type="text/css">
        .clear{clear:both;}
        body{background-color:#ffffff;}
        .header{position:absolute;left:15%;right:15%;height:42px;background-color:#81868C;color:white;line-height:42px;letter-spacing:2px;z-index:10;}
        .comp{float:right;}
        .log{position:absolute;left:15%;right:15%;top:0%;bottom:80%;background-color:#ffffff;}
        .main{position:absolute;left:15%;right:15%;top:16%;bottom:0%;background-color:#EDF1F4;}
        .shang_box{width:540px;height:540px;padding:10px;background-color:#fff;border-radius:10px;position:fixed;z-index:1000;left:50%;top:50%;margin-left:-280px;margin-top:-280px;border:1px dotted #dedede;display:block;}
        .shang_box img{border:none;border-width:0;}
        .dashang{display:block;width:100px;margin:5px auto;height:25px;line-height:25px;padding:10px;background-color:#E74851;color:#fff;text-align:center;text-decoration:none;border-radius:10px;font-weight:bold;font-size:16px;transition: all 0.3s;}
        .dashang:hover{opacity:0.8;padding:15px;font-size:18px;}
        .shang_logo{display:block;text-align:center;margin:20px auto;}
        .shang_tit{width: 100%;height: 75px;text-align: center;line-height: 66px;color: #a3a3a3;font-size: 16px;font-family: 'Microsoft YaHei';margin-top: 7px;margin-right:2px;}
        .shang_tit p{color:#a3a3a3;text-align:center;font-size:16px;}
        .shang_payimg{width:140px;padding:10px;border:6px solid #EA5F00;margin:0 auto;border-radius:3px;height:140px;}
        .shang_payimg img{display:block;text-align:center;width:140px;height:140px; }
        .pay_explain{text-align:center;margin:10px auto;font-size:12px;color:#545454;}
        .money{text-align:center;margin:10px auto;font-size:12px;color:#545454;color:red}
        .radiobox{width: 16px;height: 16px;/*background: url('img/radio2.jpg');*/display: block;float: left;margin-top: 5px;margin-right: 14px;}
        /*.checked .radiobox{background:url('img/radio1.jpg');}*/
        .shang_payselect{text-align:center;margin:0 auto;margin-top:40px;cursor:pointer;height:60px;width:280px;}
        .shang_payselect .pay_item{display:inline-block;margin-right:10px;float:left;}
        .shang_info{clear:both;}
        .shang_info p,.shang_info a{color:#C3C3C3;text-align:center;font-size:20px;text-decoration:none;line-height:2em;}
    </style>
</head>
<body>
<div class="header"><div class='comp'>你好欢迎使用云支付！</div></div>
<div class='clear'></div>
<div class="log">
    <div class='img'>

    </div>
</div>
<div class="main">
    <div class="shang_box">
        <img style="height: 40px" class="shang_logo" src="./Cashier/pigcms_static/image/mountain0.png" alt="云极付" />
        <div class="shang_tit">
            <span>请在 <span id="sec">60</span> 秒完成支付</span>
        </div>
        <div class="shang_payimg">
            <div id="output"></div>
        </div>
        <div class="pay_explain">订单金额：  <span class="money"><?php echo $data['goods_price'];?></span></div>
        <div class="pay_explain">订单编号：  <span class="money"><?php echo $data['order_id'];?></span></div>
        <div class="pay_explain">
            <div class="pay_explain">
                <span class="pay_logo"><img src="<?php if($data['paymethod']=="6001"){echo "./Cashier/pigcms_static/image/wechat.jpg";}else{echo "./Cashier/pigcms_static/image/qq.jpg";}?>" " alt="<?php if($data['paymethod']=='6001'){echo '微信支付';}else{echo 'QQ支付';}?>" /></span>
            </div>
        </div>
        <div class="shang_info">
            <p>打开<span id="shang_pay_txt"><?php if($data['paymethod']=='6001'){echo '微信';}else{echo 'QQ';}?></span>扫一扫，即可进行扫码支付!</p>
            <p> <a></a></p>
        </div>
    </div>
</div>
</body>

<script type="text/javascript" src="./Cashier/pigcms_static/tipcss/jquery.qrcode.min.js"></script>

<script>
    jQuery(function(){

        jQuery('#output').qrcode("<?php echo $data['url'];?>");

    });

    //    var getting = {
    //        url:"<?php //echo "http://" . $_SERVER['SERVER_NAME'] ."/merchants.php?m=pay&c=jhzpay&a=order";?>//",
    //        data:
    //        dataType:'json',
    //        success:function(res) {
    //            console.log(res);
    //        }
    //    };
    setTimeout(function () {
        var myVar = window.setInterval(function(){$.post("http://b.jizhipay.com/merchants.php?m=Pay&c=jpay&a=order",{order_id:"<?php echo $data['order_id'];?>"},function (data) {
            if(data=="success"){
                console.log(data);
                clearInterval(myVar);
                window.history.go(-1);
            }else{
                console.log(data);
                //clearInterval(myVar);window.history.back(-1);
                setTimeout(function () {window.history.go(-1);},60000);
                //setTimeout(function () {window.location.href="http://www.baidu.com";},40000);
            }
        });},1500);
    },6000);

    $(function () {
        setTimeout("lazyGo();", 1000);
    });
    function lazyGo() {
        var sec = $("#sec").text();
        $("#sec").text(--sec);
        if (sec > 0){
            setTimeout("lazyGo();", 1000);}
        else{
            window.history.go(-1);
        }
    }
    //关键在这里，Ajax定时访问服务端，不断获取数据 ，这里是1秒请求一次。

</script>
</html>