<!DOCTYPE html>
<html>
<head>
<title>{pg:$thisCard.cardname}</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<meta name="Keywords" content=""/>
<meta name="Description" content=""/>
<!-- Mobile Devices Support @begin -->
<meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
<meta content="telephone=no, address=no" name="format-detection">
<meta name="apple-mobile-web-app-capable" content="yes"/>
<!-- apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
<!-- Mobile Devices Support @end -->
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/cardmain.css" rel="stylesheet" type="text/css">
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>
</head>
<body onselectstart="return true;" ondragstart="return false;">
<div class="container addr_add  integran_teach">
    <header class="center">
        <label style="display:inline-block;">
            <span>&nbsp;</span>
            会员充值
        </label>
    </header>
    <div class="body">
        <div>
            <form action="" name="myform" id="Js-myform" method="post">
                <table class="table_addr">
                <tr>
                    <td>
                      会员卡号
                    </td>
                    <td>
                        {pg:$membernum.numstr}
                    </td>
                </tr>
                <tr>
                    <td>
                      充值金额
                    </td>
                    <td>
                        <input type="text" value="" name="xprice" onkeyup="value=value.replace(/[^1234567890\.]+/g,'')" placeholder="请输入充值金额（元）,支持到分"/>
                        <input type="hidden" name="cdid" value="{pg:$thisCard.id}" />
                        <input type="hidden" name="numberStr" value="{pg:$membernum.numstr}" />
                        <input type="hidden" name="mid" value="{pg:$mid}" />
                        <input type="hidden" name="openid" value="{pg:$openid}" />
                    </td>
                </tr>
                </table>
            </form>
        </div>
        <div class="pt_10 pb_10 pl_10 pr_10">
            <a href="javascript:void(0);" class="button">提&nbsp;&nbsp;&nbsp;交</a>
        </div>
        {pg:if !empty($donatearr)}
            <article>
                <h3 style="text-align:center;font-size:18px;">充值赠送说明</h3>
                {pg:$donatearr.donateinfo}
            </article>
		{pg:/if}
    </div>
</div>
{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}

<script>
$(function(){


    $('.button').click(function(){
        $('#Js-myform').submit();
    });

});
</script>
</body>
</html>