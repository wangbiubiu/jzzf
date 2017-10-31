<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no" />
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/base.css">
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/swiper.min.css">
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/font-awesome.min.css">
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/style.css">
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/swiper.jquery.min.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/iscroll.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/common.js"></script>
</head>
<body>

	<div class="dCouponInfo">
		<div class="who">
			<img src="{pg:$coupon.kqcontent.logo_url}" /><span>{pg:$coupon.kqcontent.brand_name}</span>
		</div>
		<div class="detail">
			<h2>{pg:$coupon.kqcontent.title}</h2>
			<p>{pg:$coupon.kqcontent.sub_title}</p>
			<small>有效期：{pg:$coupon.begin_timestamp}--{pg:$coupon.end_timestamp}</small>
		</div>
	</div>

	<div class="dCouponItem setRow">
		<div class="row">
			<em><i class="arrowThis"></i></em> <a href="?m=Wap&c=index&a=couponinfo&id={pg:$coupon.id}" class="titThis">折扣券详情</a>
		</div>
		<!--div class="row">
			<em><i class="arrowThis"></i></em> <a href="javascript:void(0);" class="titThis">关注公众号</a>
		</div-->
		<div class="row">
			<em><i class="arrowThis"></i></em> <a href="?m=Wap&c=index&a=storelist&mid={pg:$coupon.mid}" class="titThis">适用门店</a>
		</div>
		<div class="row">
			 <a href="javascript:;"  class="titThis">每人限领 <font color="#EA7708">{pg:$coupon.get_limit}</font> 张{pg:if $ucount > 0}，您已经领了 <font color="#EA7708">{pg:$ucount}</font> 张{pg:/if}</a>
		</div>

		{pg:if !empty($kqtimestr) AND $kqtimestr eq 'expire'}
		 <div class="row">
			 <a href="javascript:;"  class="titThis"> <font color="#EA7708">已过期了</font> </a>
		 </div>
		{pg:elseif !empty($kqtimestr) AND $kqtimestr eq 'nostart'}
			<div class="row">
			 <a href="javascript:;"  class="titThis"> <font color="#EA7708">尚未开始</font> </a>
		  </div>
		{pg:/if}

		{pg:if $storeid > 0}
		<div class="row">
			<em><i class="arrowThis"></i></em> <a href="?m=Wap&c=index&a=storedetail&id={pg:$storeid}" class="titThis">返回此商家</a>
		</div>
		{pg:/if}
		{pg:if $coupon.show_status != 'expire' AND $coupon.receivenum lt $coupon.quantity}
		<div class="row subBtn">
		 {pg:if $ucount gte $coupon.get_limit OR !empty($kqtimestr)}
		 <a class="abtn" href="javascript:;" style="opacity: 0.7;">不可再领</a>
		 {pg:else}
		    <form id="receiveForm" name="receiveForm" action="?m=Wap&c=index&a=receiveCard" method="post" style="display:none;">
			    <input name="mid" value="{pg:$coupon.mid}" type="hidden">
			    <input name="cdid" value="{pg:$coupon.id}" type="hidden">
				<input name="storeid" value="{pg:$storeid}" type="hidden">
			</form>
			<a class="abtn" href="javascript:document.receiveForm.submit();">立即领取</a>
			{pg:/if}
		</div>
	
		{pg:elseif $coupon.receivenum gte $coupon.quantity}
		<div class="row subBtn">
			<a class="abtn" href="javascript:;" style="opacity: 0.7;">已领完了</a>
		</div>
		{pg:/if}
	</div>
</body>
</html>