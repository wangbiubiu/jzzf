<!DOCTYPE html>
<html>
<head>
<title>{pg:$thisCard.cardname}</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<!-- Mobile Devices Support @begin -->
<meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
<meta content="telephone=no, address=no" name="format-detection">
<meta name="apple-mobile-web-app-capable" content="yes" /> <!-- apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<!-- Mobile Devices Support @end -->
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/cardmain.css" rel="stylesheet" type="text/css">
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>
</head>
<body onselectstart="return true;" ondragstart="return false;">
    <div class="container integral integran_teach">
        <header>
            <ul class="tbox tbox_1">
                <li>
                    <p>&nbsp;</p>
                </li>
                <li>
                    <a href="javascript:;" style="padding-top:20px;"><label>积分<br/>攻略</label></a>
                </li>
                <li>
                    <p>&nbsp;</p>
                </li>
            </ul>
        </header>
        <div class="body">
            <article>
                <label>赚积分指南：</label>
                <p>{pg:$thisCard.integralrule}</p>      
            </article>
        </div>
    </div>
{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}
</body>
</html>