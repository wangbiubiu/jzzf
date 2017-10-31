<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <meta http-equiv="Cache-Control" content="no-cache,no-store">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script src="<?php echo PIGCMS_TPL_PATH_PLUGINS;?>js/zepto.min.js"/> </script>
    <title>测试收款</title>
</head>
<body>
<p id="result">result: <?php echo $orderid;?> | </p>

<script type="application/javascript">
    // 调试时可以通过在页面定义一个元素，打印信息，使用alert方法不够优雅
    function log(obj) {
        $("#result").append(obj).append(" ").append("<br />");
    }

    $(document).ready(function () {
        // 页面载入完成后即唤起收银台
        // 此处${tradeNO}为模板语言语法，实际调用样例类似为tradePpay("2016072621001004200000000752")
        tradePay("<?php echo $tradeno;?>");

        // 点击payButton按钮后唤起收银台
        $("#payButton").click(function () {
            tradePay("<?php echo $tradeno;?>");
        });

        // 通过jsapi关闭当前窗口，仅供参考，更多jsapi请访问
        // https://doc.open.alipay.com/docs/doc.htm?treeId=193&articleId=104510&docType=1
        $("#closeButton").click(function () {
            AlipayJSBridge.call('closeWebview');
        });
    });

    // 由于js的载入是异步的，所以可以通过该方法，当AlipayJSBridgeReady事件发生后，再执行callback方法
    function ready(callback) {
        if (window.AlipayJSBridge) {
            callback && callback();
        } else {
            document.addEventListener('AlipayJSBridgeReady', callback, false);
        }
    }

    function tradePay(tradeNO) {
        ready(function () {
            // 通过传入交易号唤起快捷调用方式(注意tradeNO大小写严格)
            AlipayJSBridge.call("tradePay", {
                tradeNO: tradeNO
            }, function (data) {
                log(JSON.stringify(data));
                if ("9000" == data.resultCode) {
                    log("支付成功");
                }
            });
        });
    }
</script>
</body>
</html>
