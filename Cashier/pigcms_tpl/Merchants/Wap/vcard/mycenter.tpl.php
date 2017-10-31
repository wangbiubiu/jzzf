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

<div class="container my">
    <header>
        <div class="header">
            <a href="/merchants.php?m=Wap&c=vcard&a=userInfo&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}" class="setting">&nbsp;</a>
            <div>
                <ul class="tbox">
                    <li>
                        <span id="upload_header">                
                            <img src="{pg:$UserInfo.headimgurl}" />                          
                        </span>
                    </li>
                    <li>
                        <h3>{pg:$UserInfo.nickname}</h3>
                        <p><sban>&nbsp;</sban>{pg:$thisCard.cardname}</p>
                    </li>
                </ul>
            </div>
            <div>
                <ul class="box">
                   <!-- <li>
                        <a href="javascipt:void(0);">
                            <label>优惠券</label>
                            <span></span>
                        </a>
                    </li>
                    <li>
                        <a href="javascipt:void(0);">
                            <label>代金券</label>
                            <span></span>
                        </a>
                    </li>
					-->
                    <li>
                        <a href="javascipt:void(0);">
                            <label>积分</label>
                            <span>{pg:$UserInfo.total_score}</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascipt:void(0);">
                            <label>余额</label>
                            <span>{pg:$UserInfo.balance}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="body">
        <ul class="list_ul">
            <div>
                <!--<li class="li_t">
                    <a href=""><label class="label"><i>&nbsp;</i>我的优惠券<span>&nbsp;</span></label></a>
                </li>
                <li class="li_s">
                    <a href=""><label class="label"><i>&nbsp;</i>我的代金券<span>&nbsp;</span></label></a>
                </li>
                <li class="li_u">
                    <a href=""><label class="label"><i>&nbsp;</i>我的礼品券<span>&nbsp;</span></label></a>
                </li>--->
                <li class="li_v">
                    <a href="/merchants.php?m=Wap&c=vcard&a=payRecord&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}"><label class="label"><i>&nbsp;</i>交易记录<span>&nbsp;</span></label></a>
                </li>
            </div>
            <div>
                <li class="li_o">
                    <label class="label"><i>&nbsp;</i>收货地址<a href="/merchants.php?m=Wap&c=vcard&a=mdyaddress&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}" class="button">管  理</a></label>
                </li>
                
                <li class="li_y">
                    <label class="label"><i>&nbsp;</i>会员卡密码<a href="/merchants.php?m=Wap&c=vcard&a=mdypwd&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}" class="button">管  理</a></label>
                    
                </li>

                <!--<li class="li_b">
                    <label class="label">
                        <i>&nbsp;</i>绑定线下会员卡<a  href="/merchants.php?m=Wap&c=vcard&a=bindoffcard&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}" class="button" >绑定</a>
                    </label>
                </li>--->

            </div>
        </ul>
    </div>
</div>
{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}
</body>
</html>