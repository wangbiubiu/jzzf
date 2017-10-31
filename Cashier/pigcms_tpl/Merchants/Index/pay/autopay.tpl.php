<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <meta http-equiv="Cache-Control" content="no-cache,no-store">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script src="<?php echo PIGCMS_TPL_PATH_PLUGINS;?>js/browser.js"> </script>
    <script src="<?php echo PIGCMS_TPL_PATH_PLUGINS;?>js/zepto.min.js"> </script>
    <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/topay.js?var=<?php echo time();?>"> </script>
    <style>
        html,body{padding:0;margin:0;font-size:14px;font-family:"微软雅黑";background:#fff;position:relative;width:100%;height:100%;overflow: hidden;}
        .head{padding:20px 10px;line-height:26px;font-size:16px;background:#44b549;position: relative;text-align: center;color: #fff;}
        .head>div>div>p{ width:100%; margin:0px; text-align:left;}
        .money{margin:20px 10px 10px;padding:0 10px;border:1px solid #44b549;line-height:50px;height:50px;font-size:18px;moz-user-select: -moz-none;-moz-user-select: none;-o-user-select:none;-khtml-user-select:none;-webkit-user-select:none;-ms-user-select:none;user-select:none;border-radius:5px;}
        .spleft{width:80px;float:left;color:#44b549;font-weight: 600;}
        .spright{padding:0 5px;margin:0 10px 0 80px;text-align:right;position:relative;z-index:0;}

        /*
        .spright input{width:100%;line-height:40px; border:0;outline: none;font:14px Arial;user-select: none;}
        .spright input:focus{border:0;outline: none;}
        */
        #mdiv{color:#ccc;font-size:16px;text-align:right;}
        #mdiv1{position:absolute;z-index:1;right:-3px;top:-2px;font-size:24px;color:#44b549;}
        .clr{clear:both;height:0;line-height:0;font-size:0;overflow:hidden;}
        .amount{display:none}
        .amount_int{font-weight:700;font-size:24px;}
        .redbtn{background:#0388d1;}
        .footer{width:100%;min-height:250px;}
        .foot{position:fixed;left:0;bottom:0;height:208px;background:#eee;width:100%;display:block;}
        .foot_key{width:100%;height:208px;background:#eee;moz-user-select: -moz-none;-moz-user-select: none;-o-user-select:none;-khtml-user-select:none;-webkit-user-select:none;-ms-user-select:none;user-select:none;}
        .tab_key{width:100%;border-collapse: collapse;}
        .tab_key tr td{width:25%;text-align: center;line-height: 50px;font-size: 24px;background: #fff;position: relative;}
        .tab_key tr td:after{content: "";position: absolute;left: 0;top: 0;width: 200%;height: 200%;border-right: 1px solid #ccc;border-top: 1px solid #ccc;-webkit-box-sizing: border-box;box-sizing: border-box;-webkit-transform: scale(0.5);transform: scale(0.5);-webkit-transform-origin: left top;transform-origin: left top;}
        .ysd_fws{color:#0388d1;font-size:14px;text-align:center;display:block;text-decoration:none;line-height: 35px;}
        #liuyan {cursor: pointer;  }
    </style>
    <title>买单详情</title>
</head>
<body>
<div id="con">
    <header class="head">
        <div style="margin:0 10px;">
            <div style="text-align:center;">
                <!--<p style="font-size: 18px"><i></i></p>
    	<p style="font-size: 12px;color:#f1f1f1">门店名: <?php echo $branch_name['branch_name'];?></p>
    	<p style="font-size: 12px;color:#f1f1f1">收银员: <?php echo $ename['username'];?></p>-->
                <div class="weixin">
                    <p><i style="margin-right: 10px;"><img src="./Cashier/pigcms_static/image/weixin.png" align="absmiddle" style="width: 32px; height: 32px;"></i><?php echo $company['company'];echo '<br>';echo$branch_name['business_name'];?> </p>

                </div>
                <div class="zhifubao" style="display: none;">
                    <p><i style="margin-right: 10px;"><img src="./Cashier/pigcms_static/image/zfb.png" align="absmiddle" style="width: 32px; height: 32px;"></i><?php echo $company['company'];echo '<br>';echo$branch_name['business_name'];?></p>

                </div>
            </div>
        </div>
    </header>


    <section class="money" ontouchEnd="showkey()">
        <div class="spleft">消费金额</div>
        <div class="spright">
            <div id="mdiv1"><span id="guangbiao">|</span></div>
            <form method="post" action="" name="myform" id="mydataform">
                <div id="mdiv">
                    <span>输入服务员确认后的金额</span>
                    <input type="hidden" readonly="" value="<?php if(!empty($orderInfo)) echo $orderInfo['goods_price'];?>" style="width:100%;" onclick="return false" placeholder="输入服务员确认后的金额" id="m" name='goods_price'>
                    <input type="hidden" value="<?php echo $mid;?>"  name="mid">
                    <input type="hidden" value="<?php if(!empty($orderInfo)) {echo $orderInfo['goods_name'];}else{echo "消费商品";}?>"  name="goods_name">
                    <input type="hidden" value="<?php echo $eid;?>"  name="eid">
                    <input type="hidden" value="<?php echo $storeid;?>"  name="storeid">
                    <input type="hidden" value="" name="liuyan" id="levae">
                    <input type="hidden" value="" id="paytype" name="paytype">

                </div>
            </form>
            <div class="amount" id="a">
                <span class="amount_int" id="a_i">￥0</span>
                <!--<span class="amount_float" id="a_f">.00</span>-->
            </div>
        </div>
        <div class="clr"></div>
    </section>
<!--    //留言标签-->
    <a id='liuyan' style="float: left; font-size: 16px;margin-top: 30px;color: #44B549;text-decoration: none;padding-left: 20px;cursor: pointer">添加留言</a>

    <!--    <p class="ysd_fws" style="color: #737373;">由<span style="font-size: 18px; color: #00B7EE;">云极付</span><sup style="background: #888888; color: #FFFFFF;">TM</sup>提供技术支持</p>-->
</div>
<div class="footer" id="footer" style="height:640px;"><!--//撑高用--></div>
<footer class="foot" id="foot">
    <div class="foot_key" id="foot_key">
        <table class="tab_key">
            <tr><td>1</td><td>2</td><td>3</td><td rowspan="1"><img src="<?php echo PIGCMS_TPL_PATH_IMAGE;?>del.png" width="20" height="20"></td></tr>
            <tr><td>4</td><td>5</td><td>6</td><td rowspan="3"  style="line-height:20px;"></td></tr>
            <tr><td>7</td><td>8</td><td>9</td></tr>
            <tr><td colspan="2">0</td><td>.</td></tr>
            <div id="paybtn" rowspan="3"  style="line-height:20px;background:#81e686;color:#fff;font-size:16px; position: fixed; right: 0px; bottom: 0px; width: 25%;height: 156px;z-index: 999; line-height: 156px; text-align: center;">安全<br>支付</div>
        </table>
    </div>
</footer>
<iframe id="wzffrm" style="display:none"></iframe>
<div style="width:100%;height:100%;position:absolute;z-index:1;top:0;left:0;background:rgba(0,0,0, 0.5);display:none;" id="tip_bg"></div>
<div style="width:80%;height:110px;position:absolute;z-index:2;top:50%;left:10%;background:#fff;margin-top:-55px;display:none;padding:20px 20px 0;box-sizing:border-box;line-height:45px;" id="tip">
    <div>正在支付中,请稍后。。。</div>
    <div style="text-align:right;color:green;" onclick="clsTip()">关闭</div></div>
<script src="<?php echo PIGCMS_TPL_PATH_PLUGINS;?>js/browser.js"></script>
<script src="<?php echo PIGCMS_TPL_PATH_PLUGINS; ?>js/browser.js"></script>
<script src="<?php echo PIGCMS_TPL_PATH_PLUGINS; ?>layer_mobile/layer.js"></script>
<script>
    $(function(){
        var color;
        var ua = navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i)=='micromessenger') {
            $(".tab_key").click(function () {
                var money=parseFloat($("#m").val());
                if(money>0){
                    $("#paybtn").css("background","#44b549");
                }
                else {
                    $("#paybtn").css("background","#81e686");
                }
            })
            $("#paybtn").click(function () {
                $("#paybtn").text("支付中...");
                $("#paybtn").css("background","#81e686");
            })
            $("#paytype").val('weixin');
            $(".weixin").show();
            $(".zhifubao").hide();
            $("#paybtn").text("微信支付");
            $("#paybtn").css("background","#81e686");
            $(".head").css("background","#44b549");
            $("#mdiv1").css("color","#44b549");
            $(".spleft").css("color","#44b549");
            $(".money").css("border-color","#44b549");
            $("#liuyan").css("color","#44b549");
            color='#44b549'
        }else if(ua.match(/alipay/i) == 'alipay'){
            $(".tab_key").click(function () {
                var money=parseFloat($("#m").val());
                if(money>0){
                    $("#paybtn").css("background","#0388d1");
                }
                else {
                    $("#paybtn").css("background","#72b5da");
                }
            })
            $("#paybtn").click(function () {
                $("#paybtn").text("支付中...");
                $("#paybtn").css("background","#72b5da");
            })
            $("#paytype").val('alipay');
            $(".weixin").hide();
            $(".zhifubao").show();
            $("#paybtn").text("支付宝支付");
            $("#paybtn").css("background","#72b5da");
            $(".head").css("background","#0388d1");
            $("#mdiv1").css("color","#0388d1");
            $(".spleft").css("color","#0388d1");
            $(".money").css("border-color","#0388d1")
            $("#liuyan").css("color","#0388d1");
            color='#0388d1'
        }

        $('#paybtn').click(function(){

            var ua = navigator.userAgent.toLowerCase();
            if(ua.match(/MicroMessenger/i)=='micromessenger') {
                //在微信中打开
                <?php if(defined('ABS_UPLOAD_PATH')){?>
                var formPostUrl="<?php echo ABS_UPLOAD_PATH;?>/pay/wxpay/index.php?m=Index&c=pay&a=foreverpaying&ordid=auto";
                <?php }else{?>
                var formPostUrl="/pay/wxpay/index.php?m=Index&c=pay&a=foreverpaying&ordid=auto";
                <?php } ?>
                var myf=document.getElementById('mydataform');
                myf.action=formPostUrl;
                $('#paytype').val('weixin');
                document.myform.submit();
            } else if(ua.match(/alipay/i) == 'alipay'){
                //在支付宝中打开
                // var formPostUrl="/merchants.php?m=Index&c=pay&a=aliwappay&ordid=auto";
                var formPostUrl="/merchants.php?m=Index&c=pay&a=alitradepay";
                var myf=document.getElementById('mydataform');
                myf.action=formPostUrl;
                $('#paytype').val('alipay');
                document.myform.submit();
            } else{
                alert("非法请求!!!");
            }
        });
        //        留言功能
        $("body").on('click','#liuyan',function () {
            var content = $("#levae").val();
            layer.open({
                title: [
                    '添加留言',
                    'background-color:'+color+'; color:#fff;'
                ]
//                area:[
//                    '2000px',
//                    '1000px'
//                ]
                ,anim: 'up'
                ,content:'<input type="text"   id="yan"  maxlength="15" placeholder="限制15个字以内" style="width:95%;height: 30px" value='+content+'>'
                ,btn: ['确认','取消'],
                yes:function (index, layero){
                    var liuyan = $("#yan").val();
                    if (liuyan!=""){
                        $("#levae").val(liuyan);
                        $("#liuyan").html("<span >"+liuyan+"</span>"+"&nbsp;&nbsp;&nbsp;&nbsp;"+"<a href='#' id='xiugai' style='font-size: 16px;text-decoration: none;cursor: pointer;'>修改</a>");
                    }else {
                        $("#levae").val("");
                        $("#liuyan").html("<a href='#' id='liu' style='float: left; font-size: 16px;text-decoration: none;cursor: pointer;'>添加留言</a>");
                        $("#liu").css('color',color);
                    }
                    layer.close(index);
                },cancel:function () {
                    layer.close(index);
                }
            });
            $("#yan").focus();
        })

    });
</script>


<script>

    function $id(id){return document.getElementById(id);}
    function clsTip(){
        $id('tip_bg').style.display='none';
        $id('tip').style.display='none';
    }
    function shwTip(){
        $id('tip_bg').style.display='block';
        $id('tip').style.display='block';
    }

    var is_key = parseInt("0");
    var is_paying = 0; //0.可支付 1.支付中 2.取消支付 3.支付失败
    var wzfpara = "";
    var ua = navigator.userAgent;
    //ua = "asdf QQ/asdf";
    //$id("footer").innerHTML = (ua);
    if(ua.indexOf("UCBrowser")>0){$id("foot").style.position="absolute";} //兼容UC浏览器Fixed问题

    var st = 0;
    var conh = $id("con").offsetHeight ;
    var bodyh = Browser.ViewPort.innerHeight();
    var divh = bodyh-conh;
    var wzfsvl = null;
    var wzfsto = null;
    $id("footer").style.height = divh + "px";

    var itvShow = true;
    var itv = setInterval(function(){
        if(itvShow){
            itvShow = false;
            $('#guangbiao').show();
        }else{
            itvShow = true;
            $('#guangbiao').hide();
        }
    },600);
    function chg(){
        v = $id("m").value;
        //alert(v)
        if(v.indexOf(".")>0){
            re = /^[0-9]+\.?[0-9]{0,2}$/;
            if(re.test(v)){
                vs = v;
            }else{
                //alert("NO");
                //vs = v.substring(0,v.length-1);
            }
        }else if(v.indexOf(".")==0){
            vs = "";
            v = "";
        }else{
            re = /(0|[1-9][0-9]{0,8})[0-9]*/;
            vs = v.replace(re,"$1");
        }
        $id("m").value = vs;
        $id("a_i").innerHTML ='￥'+ vs;
        if(v!=""){
            $id("mdiv").style.display="none";
            $id("a").style.display="block";
        }else{
            $id("mdiv").style.display="block";
            $id("a").style.display="none";
        }
    }

    function setNone(){
        $id("mdiv").style.display="block";
        $id("a").style.display="none";
        $id("m").value = "";
        $id("a_i").innerHTML = "";
    }


    /*

     function pay(){
     var ua = navigator.userAgent.toLowerCase();
     if(ua.match(/MicroMessenger/i)=='micromessenger') {
     //在微信中打开
    <?php if(defined('ABS_UPLOAD_PATH')){?>
     var formPostUrl="<?php echo ABS_UPLOAD_PATH;?>/pay/wxpay/index.php?m=Index&c=pay&a=foreverpaying&ordid=auto";
    <?php }else{?>
     var formPostUrl="/pay/wxpay/index.php?m=Index&c=pay&a=foreverpaying&ordid=auto";
    <?php } ?>
     var myf=document.getElementById('mydataform');
     myf.action=formPostUrl;
     $('#paytype').val('weixin');
     document.myform.submit();
     } else if(ua.match(/alipay/i) == 'alipay'){
     //在支付宝中打开
     var formPostUrl="/merchants.php?m=Index&c=pay&a=aliwappay&ordid=auto";
     var myf=document.getElementById('mydataform');
     myf.action=formPostUrl;
     $('#paytype').val('alipay');
     document.myform.submit();
     } else{
     alert("非法请求!!!");
     }

     }*/

    //function pay(){
    //	if(is_paying){
    //		alert(['','正在支付中', '已取消支付, 请重新扫码~', '支付失败, 请重新扫码~'][is_paying]);
    //		return;
    //	}


    /* 	if(is_paying){
     alert(['','正在支付中', '已取消支付, 请重新扫码~', '支付失败, 请重新扫码~'][is_paying]);
     return;
     }
     /*
     //$id("paybtn").className = "graybtn";
     //$id("paybtn").onclick = null;
     if(ua.indexOf("baiduboxapp")>0||ua.indexOf("BaiduWallet")>0||ua.indexOf("BDNuomiAppAndroid")>=0){//百度
     pay_all(3);
     }else if(ua.indexOf("QQ/")>0){//QQ
     pay_all(7);
     }else if(ua.indexOf("MQQBrowser")>0||ua.indexOf("MicroMessenger")>0){ //微信
     pay_wzf();
     //pay_all(2);
     }else if(ua.indexOf("AliApp")>0){ //支付宝
     pay_all(1);
     //setNone();
     }else{
     pay_all(4);
     }
     */
    /*
     if("4"=="2"){
     if(""=="A00002016100000000051"){ //大商户
     pay_all("4");
     }else{
     pay_wzf();
     }
     }else{
     pay_all("4");
     } */


    function pay_all(tt){

        var v = $id("m").value;
        alert(v)
        if(parseFloat(v)==0 || v==''){alert('请输入正确的金额！');return;}
        is_paying = 1;
        //alert(tt);
        $id("m").value = "";
        if(""!=""){ //大商户
            location.href="payDsh.php?s=0fc114e5TkLq96QxYKRgpDU1EGAA9DTQ&v="+ v +"&tt="+ tt +"&o=&t="+Math.random();
        }else{
            location.href = "pay.php?s=0fc114e5TkLq96QxYKRgpDU1EGAA9DTQ&v="+ v +"&tt="+ tt +"&o=&t="+Math.random();
        }
    }

    function pay_wzf(){
        var v = $id("m").value;
        if(parseFloat(v)==0 || v==''){alert('请输入正确的金额！');return;}
        is_paying = 1;
        if(""!=""){
            src = "payDsh_wx.php?s=0fc114e5TkLq96QxYKRgpDU1EGAA9DTQ&code=&o=&v="+v+"&t="+Math.random();
        }else{
            src = "wzfonline_ajax.php?s=0fc114e5TkLq96QxYKRgpDU1EGAA9DTQ&co=&o=&v="+ v +"&t="+Math.random();
        }
        /*
         var frm = document.createElement("IFRAME");
         frm.style.display = 'none';
         frmsrc = "pay.php?s=0fc114e5TkLq96QxYKRgpDU1EGAA9DTQ&v="+ v +"&tt=2&o=&t="+ Math.random();
         alert(frmsrc);
         frm.setAttribute("src", frmsrc);
         document.documentElement.appendChild(frm);
         //frm.parentNode.removeChild(frm);
         //frm = null;
         */
        wzfsto = setTimeout(function(){
            if(wzfsvl){
                is_paying = 0;
                clearInterval(wzfsvl);
                wzfsvl = null;
                clearTimeout(wzfsto);
                wzfsto = null;
                alert("网络超时! 请检查网络后再试!");
            }
        },10000);//10秒超时

        $id("wzffrm").src = src;
        wzfsvl = setInterval(function(){
            if(wzfpara!=""){
                clsTip(); //关闭提示框
                clearInterval(wzfsvl);
                wzfsvl = null;
                clearTimeout(wzfsto);
                wzfsto = null;
                //setNone();
                WeixinJSBridge.invoke("getBrandWCPayRequest",eval("("+wzfpara+")"),function(res){
                    WeixinJSBridge.log(res.err_msg);
                    if(res.err_msg=="get_brand_wcpay_request:ok"){
                        window.location.href = "rlt.php?s=0fc114e5TkLq96QxYKRgpDU1EGAA9DTQ&out_trade_no=&t="+Math.random();
                    }else{
                        if(res.err_msg == 'get_brand_wcpay_request:cancel'){
                            is_paying = 2;
                            alert("取消支付");
                        }else{
                            is_paying = 3;
                            alert("支付失败("+ res.err_msg + ")");
                        }
                    }
                });

            }
        },1);

    }


    function hkey(v){
        if(is_key)return;
        if(v=='×'){
            //if(v=='x'){
            str = $id("m").value;
            if(str!='')$id("m").value = str.substring(0,str.length-1);
        }else{
            $id("m").value = $id("m").value + v;
        }
        chg();
    }

    function clskey(){
        if(st==0){st= Browser.Page.scrollTop();}
        $id("footer").style.display="none";
        $id("foot").style.display="none";
        $('#mdiv1').hide();
        window.scrollTo(0,0);
    }

    function showkey(){
        $id("foot").style.display="block";
        $id("footer").style.display="block";
        if(st == 0){st = divh;}
        $('#mdiv1').show();
        window.scrollTo(0,st);
    }
</script>

<script type="application/javascript" src="<?php echo PIGCMS_TPL_PATH_PLUGINS;?>js/zepto.min.js"></script>
<script type="application/javascript">

    $(document).ready(function(){

        //document.documentElement.addEventListener('dblclick', function(e){e.preventDefault();});

        var v = $id("m").value;
        if(v!=='' && parseFloat(v)>0){
            $id("a_i").innerHTML ='￥'+ v;
            $id("mdiv").style.display="none";
            $id("a").style.display="block";
        }
        var el = null;
        function getEvent(el, e, type) {
            e = e.changedTouches[0];
            var event = document.createEvent('MouseEvents');
            event.initMouseEvent(type, true, true, window, 1, e.screenX, e.screenY, e.clientX, e.clientY, false, false, false, false, 0, null);
            event.forwardedTouchEvent = true;
            return event;
        }
        $('td').on('touchstart',function(e){
            var firstTouch = e.touches[0];
            el = firstTouch.target;
            var obj = $(this);
            backColor = obj.css('background');
            $(el).css('background','#ccc');
            setTimeout(function(){
                obj.css('background',backColor);
            },50);
        });
        $('td').on('touchend',function(e){
            e.preventDefault();
            var event = getEvent(el, e, 'click');
            el.dispatchEvent(event);
        });
        $('td').on('click', function (e) {
            key = $(this).html();
            //alert(key)
            if(key=='<img src="<?php echo PIGCMS_TPL_PATH_IMAGE;?>del.png" width="20" height="20">' ||
                key=='<img src="<?php echo PIGCMS_TPL_PATH_IMAGE;?>del.png" width="20" height="20" style="-webkit-touch-callout: none; -webkit-user-select: none;">'){key='×';}
            if(key=='安全<br>支付'){pay();return;}
            if(key=='<img src="<?php echo PIGCMS_TPL_PATH_IMAGE;?>key.png" width="20" height="20">' ||
                key=='<img src="<?php echo PIGCMS_TPL_PATH_IMAGE;?>key.png" width="20" height="20" style="-webkit-touch-callout: none; -webkit-user-select: none;">'){clskey();return;}
            hkey(key);
        });

        if(is_key){//有带金额时自动付款
            shwTip();
            if("4"=='2'){
                if (typeof WeixinJSBridge == "undefined"){
                    if( document.addEventListener ){
                        document.addEventListener('WeixinJSBridgeReady', pay, false);
                    }else {
                        document.attachEvent('WeixinJSBridgeReady', pay);
                        //document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                    }
                }else{
                    pay();
                }
            }else{
                clsTip();
                pay();
            }
        }//有传金额时自动付, 微信有时候调不起来，
    });

    //fastclick1.js
    //window.addEventListener('load', function () {
    //	FastClick.attach(document.body);
    //}, false);
    //下拉
    var onOff=true;
    $('#down').on('touchend',function(){
        if(onOff){
            $('#name').css('display','block');
            $('#down').css({'transform':'rotate(180deg)','-webkit-transform':'rotate(180deg)','bottom':'-8px'});
            onOff=!onOff;
        }else{
            $('#name').css('display','none');
            $('#down').css({'transform':'rotate(0deg)','-webkit-transform':'rotate(0deg)','bottom':'-2px'});
            onOff=!onOff;
        }

    });




</script>
<script>
    var wAlert = window.alert;
    window.alert = function (message) {
        try {
            var iframe = document.createElement("IFRAME");
            iframe.style.display = "none";
            iframe.setAttribute("src", 'data:text/plain');
            document.documentElement.appendChild(iframe);
            var alertFrame = window.frames[0];
            var iwindow = alertFrame.window;
            if (iwindow == undefined) {
                iwindow = alertFrame.contentWindow;
            }
            iwindow.alert(message);
            iframe.parentNode.removeChild(iframe);
        }catch (exc) {
            return wAlert(message);
        }
    }
</script>

</body></html>
