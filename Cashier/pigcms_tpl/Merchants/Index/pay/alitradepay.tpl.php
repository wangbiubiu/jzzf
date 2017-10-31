<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport"
          content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <title>支付宝支付</title>
    <script language="javascript">
        var tradeNO = '<?php echo $tradeno; ?>';
        var orderId = '<?php echo $orderid; ?>';
        var getTimes = 0;

        function getTradeResult() {
            getTimes = getTimes + 1;
            if (getTimes > 60) { 
                $('#successDom').find('.tit').html('支付失败');
                $('#successDom').find('.con').html('获取支付结果超时，请联系商家');
                return;
            }

            // 异步获取支付宝支付结果
            $.ajax({ 
                type: 'get', 
                url: '/merchants.php?m=Index&c=pay&a=<?php if($merchant['mtype'] == 1){echo 'alitraderesult';}else{echo 'alitradebankresult';} ?>',
                data: {'orderid': orderId},
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        if (data.data == 'TRADE_SUCCESS' || data.data == 'TRADE_FINISHED') {
                            var link2= "<?php echo $adresult['link2'];?>";
                            if(link2!==""){
                                window.location.href = "<?php echo $adresult['link2'];?>";
                            }
                            else {
                                $('#successDom').find('.tit').html('支付成功');
                                $('#successDom').find('.con').html('恭喜您，支付成功');
                            }
                        } else if (data.data == 'TRADE_CLOSED') {
                            $('#successDom').find('.tit').html('支付失败');
                            $('#successDom').find('.con').html('本次交易已关闭，请重新扫码支付');
                        } else {
                            // 延迟3秒后再试
                            setTimeout("getTradeResult()", 5000);
                        }
                    } else {zz
                        $('#successDom').find('.tit').html('支付失败');
                        $('#successDom').find('.con').html(data.errmsg);
                    }
                },
                error: function (data) {

                }
            });
        }

        function showResult(resultCode) {
            switch (resultCode) {
                case '9000':
                    $('#successDom').show();
                    $('#failDom').hide();
                    getTradeResult();
                    break;
                default:
                    $('#successDom').hide();
                    $('#failDom').show();

                    var con = '';
                    switch (resultCode) {
                        case '6001':
                            con = '您已取消本次支付';
                            break;
                        case '6002':
                            con = '网络链接出错，请点击再次支付再试';
                            break;
                        case '99':
                            con = '您已点击忘记密码，请找回密码后再试';
                            break;
                        default:
                            con = '请点击再次支付再试';
                            break;
                    }

                    $('#failDom').find('.con').html(con);
                    break;
            }
        }

        function ready(callback) {
            if (window.AlipayJSBridge) {
                callback && callback();
            } else {
                document.addEventListener('AlipayJSBridgeReady', callback, false);
            }
        }

        function tradePay() {
            ready(function () {
                // 通过传入交易号唤起快捷调用方式(注意tradeNO大小写严格)
                AlipayJSBridge.call("tradePay", {
                    tradeNO: tradeNO
                }, function (data) {
                    showResult(data.resultCode);
                });
            });
        }

    </script>
    <script src="<?php echo PIGCMS_TPL_PATH_PLUGINS;?>js/zepto.min.js"> </script>
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/styles/weixin_pay.css?ver=1.001" rel="stylesheet"/>
        </head>
<body style="padding-top:20px;">
<div id="payDom" class="cardexplain">
    <ul class="round">
        <li class="title mb"><span class="none">支付信息</span></li>
        <li class="nob">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                <tr>
                    <th>金额</th>
                    <td><?php echo $goodsprice; ?>元</td>
                </tr>
            </table>
        </li>
    </ul>
    <!--    <div class="footReturn" style="text-align:center">-->
    <!--        <input type="button" style="margin:0 auto 20px auto;width:100%" onclick="tradePay()" class="submitbtn"-->
    <!--               value="点击进行支付宝支付"/>-->
    <!--    </div>-->
</div>
<div id="failDom" style="display:none" class="cardexplain">
    <ul class="round">
        <li class="title mb"><span class="none">支付结果</span></li>
        <li class="nob">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                <tr>
                    <th class="tit">支付失败</th>
                    <td>
                        <div class="con"></div>
                    </td>
                </tr>
            </table>
        </li>
    </ul>
    <div class="footReturn" style="text-align:center">
        <input type="button" style="margin:0 auto 20px auto;width:100%" onclick="tradePay()" class="submitbtn"
               value="重新进行支付"/>
    </div>
</div>
<div id="successDom" style="display:none" class="cardexplain">
    <ul class="round">
        <li class="title mb"><span class="none">支付结果</span></li>
        <li class="nob">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                <tr>
                    <td class="tit">支付中</td>
                </tr>
            </table>
            <div class="con">请稍候…，请勿关闭</div>
        </li>
    </ul>
</div>
<script language="javascript">
    $(document).ready(function () {
        // 页面载入完成后即唤起收银台
        tradePay();
        getTradeResult();
    });
</script>
</body>
</html>