<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>用户中心</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/base.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/swiper.min.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/font-awesome.min.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/style.css">
    <script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>
<body style="zoom: 1;">
<div class="dDanInfo userCenterBg">
    <img src="{pg:$UserInfo.headimgurl}" alt="No Image">
    <h3>{pg:$UserInfo.nickname}</h3>
    <p>消费：{pg:$UserInfo.paymoney}元</p>
    <!--<small></small>-->
</div>
<div class="cell3">
    <div class="cell">
        <p>{pg:$UserInfo.paycount}</p>
        <p>已支付</p>
    </div>
    <div class="cell">
        <p>{pg:$couponCount}</p>
        <p>优惠券</p>
    </div>
    <div class="cell">
        <p>{pg:$memberCount}</p>
        <p>会员卡</p>
    </div>
</div>

<div class="itemList setRow">
    <div class="row past">
        <em>{pg:$tomerCount}个<i class="arrowThis"></i></em>
        <a href="/merchants.php?m=Wap&c=index&a=goneShops" class="titThis"><i></i>我去过的商家</a>
    </div>
    <div class="row pay">
        <em>{pg:$payCount}个<i class="arrowThis"></i></em>
        <a href="/merchants.php?m=Wap&c=index&a=payRecord" class="titThis"><i></i>我的付款记录</a>
    </div>
    <div class="row collection">
        <em>{pg:$attentionCount}个<i class="arrowThis"></i></em>
        <a href="/merchants.php?m=Wap&c=index&a=myattention" class="titThis"><i></i>我关注的商家</a>
    </div>
    <div class="row coupon">
        <em>{pg:$couponCount}个<i class="arrowThis"></i></em>
        <a href="/merchants.php?m=Wap&c=index&a=couponlist&fromtype=coupon" class="titThis"><i></i>我的优惠券</a>
    </div>
    <div class="row membership">
        <em>{pg:$memberCount}个<i class="arrowThis"></i></em>
        <a href="/merchants.php?m=Wap&c=index&a=couponlist&fromtype=card" class="titThis"><i></i>我的会员卡</a>
    </div>
    <!--<div class="row comment">
        <em>10个<i class="arrowThis"></i></em>
        <a href="##" class="titThis"><i></i>我的评论</a>
    </div>-->

</div>

{pg:include file="$tplHome/Wap/public/footer.tpl.php"}
</body>
</html>