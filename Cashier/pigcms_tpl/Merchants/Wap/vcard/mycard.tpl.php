<!DOCTYPE html>
<html>
<head>
<title>{pg:$thisCard.cardname}</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
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
<div class="container card">
    <header>
    <div class="header card">
        <div id="card" data-role="card" onClick="this.classList.toggle('on');">
            <div class="front" style="background-image:url({pg:if !empty($thisCard.diybg)}{pg:$thisCard.diybg} {pg:else} {pg:$thisCard.bgstyle}{pg:/if});">
                <span class="logo"><img id="cardlogo" class="logo" src="{pg:$thisCard.mclogo}"></span>
                <span class="name" style="color:{pg:$thisCard.vipnamecolor};padding-right:5px;">{pg:$thisCard.cardname}</span>
                <span class="no" style="color:{pg:$thisCard.numbercolor};">{pg:$thisMember.numstr}</span>
            </div>
        </div>
        <p class="explain"><span>点击卡片查看会员卡条码</span></p>
        <div class="code">
            <img src="/merchants.php?m=Wap&c=vcard&a=showCode&mid={pg:$mid}&cdid={pg:$thisCard.id}&tcode={pg:$thisMember.numstr}&openid={pg:$openid}" alt="条形码">
        </div>
        <div class="mask"></div>
    </div>
    <div>
        <ul class="box group_btn">
            <li><a href="/merchants.php?m=Wap&c=vcard&a=xrecharge&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}">充值</a></li>
            <li><a href="/merchants.php?m=Wap&c=vcard&a=xconsume&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}">付款</a></li>
        </ul>
    </div>
    </header>
    <div class="body">
        <ul class="list_ul">
            <div>
			{pg:if !empty($thisCard.welfaretitle)}
			<li class="li_a">
				<label class="label" onClick="this.parentNode.classList.toggle('on');"><i>&nbsp;</i>{pg:$thisCard.welfaretitle}<span>&nbsp;</span></label>
				<ol>
					<h6>详细说明：</h6>
					<p>
						{pg:$thisCard.welfareinfo}
					</p>
				</ol>
			</li>
			{pg:/if}
                <!--<li class="li_b">
                    <a href="">
                        <label class="label">
                            <i>&nbsp;</i>
                            会员优惠
                            <span>&nbsp;</span>
                        </label>
                    </a>
                </li>-->
                <li class="li_e">
                    <a href="/merchants.php?m=Wap&c=vcard&a=notice&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}">
                        <label class="label">
                            <i>&nbsp;</i>
                            消息通知
                            <span>&nbsp;</span>
                        </label>
                    </a>
                </li>
                <li class="li_d">
                    <a href="/merchants.php?m=Wap&c=vcard&a=userInfo&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}">
                        <label class="label">
                            <i>&nbsp;</i>
                            完善会员卡资料 
                            <span>&nbsp;</span>
                        </label>
                    </a>
                </li>

            </div>
            <div>
                <li class="li_v">
                    <a href="/merchants.php?m=Wap&c=vcard&a=memberInfo&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}">
                        <label class="label"><i>&nbsp;</i>
                            <p class="mutipleLine">
                                会员卡介绍
                            </p>
                            <span>&nbsp;</span>
                        </label>
                    </a>
                </li>
                <!-- 门店-->
                <li class="li_k">
                    <a href="/merchants.php?m=Wap&c=vcard&a=companyDetail&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}">
                        <label class="label">
                            <i>&nbsp;</i>
                            商家门店
                            <span>&nbsp;</span>
                        </label>
                    </a>
                </li>
            </div>
        </ul>
    </div>
    <div style="display: none;" id="orderpay"></div>
</div>
{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}
<script>
    $('.explain,.front').click(function(){
        $('.code').show();
        $('.mask').show();
    });
    $('.mask,.code').click(function(){
        $('.code').hide();
        $('.mask').hide();
    });
</script>
</body>
</html>