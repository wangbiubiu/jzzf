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
    <div class="container integral integral_record integral_my coupon">
        <header>
            <nav id="nav_1" class="p_10">
                <ul class="box">
                    <li><a href="/merchants.php?m=Wap&c=vcard&a=payRecord&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}"  {pg:if $route_Action=='payRecord'}class="on"{pg:/if}>会员卡交易</a></li>
                    <li><a href="/merchants.php?m=Wap&c=vcard&a=offExpense&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}"
					 {pg:if $route_Action=='offExpense'}class="on"{pg:/if}>线下交易</a></li>
                </ul>
            </nav>
        </header>
        <div class="bill_header Calendar" style="height: 95px;">
            <ul class="bill_detail box">
                <li>
                    <label>消费总额:<span>{pg:$UserInfo.expensetotal}</span></label>
                </li>
                <li>
                    <label>卡上余额:<span>{pg:$UserInfo.balance}</span></label>
                </li>
				<li>
                    <label>剩余积分:<span>{pg:$UserInfo.total_score}</span></label>
                </li>
            </ul>
			<header> 
			   <div id="idCalendarPre">
				<a href="/merchants.php?m=Wap&c=vcard&a=offExpense&mid={pg:$mid}&cdid={pg:$thisCard.id}&month={pg:$premonth}&year={pg:$pyear}&openid={pg:$openid}">
				  <span class="icons icons_before">&nbsp;</span>
				</a>
			   </div> 
			   <div id="idCalendarNext">
				<a href="/merchants.php?m=Wap&c=vcard&a=offExpense&mid={pg:$mid}&cdid={pg:$thisCard.id}&month={pg:$nextmonth}&year={pg:$nyear}&openid={pg:$openid}">
				  <span class="icons icons_after">&nbsp;</span>
				</a>
			   </div> 
			   <span id="idCalendarYear">{pg:$nowdate}</span>
      </header> 

        </div>

        <div class="body">
            <section>
                <table class="table_record">
                    <thead>
                    <tr>
                        <td style="width:25%;">日期</td>
                        <td style="width:25%;">消费(元)</td>
                        <td style="width:25%;">积分</td>
                        <td style="width:25%;">类型</td>
                    </tr>
                    </thead>
					{pg:if !empty($locmbpayrecord)}
                    <table class="table_record">
					   {pg:foreach item=row from=$locmbpayrecord}
                        <tr>
                            <td style="width:25%;" align="center">{pg:$row.addtime|date_format:"%Y-%m-%d"}</td>
                            <td style="width:25%;" align="center">{pg:$row.expense}</td>
                            <td style="width:25%;" align="center">{pg:if $row.score gt 0} + {pg:/if}{pg:$row.score}</td>
                            <td style="width:25%;" align="center"> {pg:if $row.cat eq 2}积分换券
							{pg:elseif $row.cat eq 3}后台赠送{pg:elseif $row.cat eq 4}使用礼品券{pg:elseif $row.cat eq 1}签到积分{pg:elseif $row.cat eq 5}会员充值{pg:elseif $row.cat eq 6}开卡赠送{pg:else}消费获取积分{pg:/if}</td>
                        </tr>
						{pg:/foreach}
                    </table>
					{pg:else}
					<table class="table_record empty1">
					 <tr></tr>
					</table>
					{pg:/if}
                </table>
            </section>
        </div>
    </div>

{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}

<script>

</script>
</body>
</html>