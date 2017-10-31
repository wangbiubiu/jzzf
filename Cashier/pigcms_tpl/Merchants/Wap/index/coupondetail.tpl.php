<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{pg:$coupon.kqcontent.title}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no" />
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/base.css">
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/swiper.min.css">
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/font-awesome.min.css">
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/style.css">
<script src="http://apps.bdimg.com/libs/zepto/1.1.4/zepto.min.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/swiper.jquery.min.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/iscroll.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/common.js"></script>
</head>
<body>
	<div class="dCouponInfo">
		<!--a class="give" href="javascript:;">赠送</a-->
		<div class="who">
			<img src="{pg:$coupon.kqcontent.logo_url}" /><span>{pg:$coupon.kqcontent.brand_name}</span>
		</div>
		<div class="detail">
			<h2>{pg:$coupon.kqcontent.title}</h2>
			<p>{pg:$coupon.kqcontent.sub_title}</p>
			<small>有效期：{pg:$coupon.begin_timestamp}--{pg:$coupon.end_timestamp}</small>
		</div>
	</div>
	<div class="qrCode">
		<img class="qrImg" src="?m=Wap&c=index&a=qrcode&cardcode={pg:$receive.cardcode}" />
		<p>{pg:$receive.show_cardcode}</p>
		<small>{pg:$coupon.kqcontent.notice}</small>
	</div>
	<div class="dCouponItem setRow">
		<div class="row">
			<em><i class="arrowThis"></i></em> <a href="?m=Wap&c=index&a=couponinfo&id={pg:$coupon.id}" class="titThis">折扣券详情</a>
		</div>
		<!--div class="row">
			<em><i class="arrowThis"></i></em> <a href="javascript:;" class="titThis">关注公众号</a>
		</div-->
		<div class="row">
			<em><i class="arrowThis"></i></em> <a href="?m=Wap&c=index&a=storelist&mid={pg:$coupon.mid}" class="titThis">适用门店</a>
		</div>
		{pg:if $storeid > 0}
		<div class="row">
			<em><i class="arrowThis"></i></em> <a href="?m=Wap&c=index&a=storedetail&id={pg:$storeid}" class="titThis">返回此商家</a>
		</div>
		{pg:/if}
		{pg:if !(empty($coupon.kqcontent.custom_url_name))}
		<div class="row margin15 ">
			<em>{pg:$coupon.kqcontent.custom_url_name}<i class="arrowThis"></i></em> <a href="{pg:$coupon.kqcontent.custom_url}" class="titThis">{pg:$coupon.kqcontent.custom_url_sub_title}</a>
		</div>
		{pg:/if}
		{pg:if !(empty($coupon.kqcontent.promotion_url_name))}
		<div class="row margin15 ">
			<em>{pg:$coupon.kqcontent.promotion_url_name}<i class="arrowThis"></i></em> <a href="{pg:$coupon.kqcontent.promotion_url}" class="titThis">{pg:$coupon.kqcontent.promotion_url_sub_title}</a>
		</div>
		{pg:/if}
		{pg:if $receive.status == 0}
		<div class="row subBtn">
			<a class="abtn" href="?m=Wap&c=index&a=SimplePay&paramcode={pg:$receive.payparam}"> 快速买单</a>
		</div>
		{pg:else}
		<div class="row subBtn">
			<a class="abtn" href="javascript:;" style="opacity: 0.7;">已经使用过了</a>
		</div>
		{pg:/if}
	</div>
</body>
</html>