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
<script src="http://apps.bdimg.com/libs/zepto/1.1.4/zepto.min.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/swiper.jquery.min.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/iscroll.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/common.js"></script>
</head>
<body>
	<!--div class="dCouponTop">
		<div class="avatar">
			<img src="images/holder/1.jpeg" />
		</div>
		<div class="desc">
			<h2>大雪纷飞</h2>
			<p>赠送了一张折扣券</p>
		</div>
	</div-->

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
		{pg:if $storeid > 0}
		<div class="row">
			<em><i class="arrowThis"></i></em> <a href="?m=Wap&c=index&a=storedetail&id={pg:$storeid}" class="titThis">返回此商家</a>
		</div>
		{pg:/if}
		{pg:if $coupon.show_status != 'expire'}
		<div class="row subBtn">
			<a class="abtn" href="javascript:void(0);">立即领取</a>
		</div>
		{pg:/if}
	</div>
</body>
{pg:if empty($issub)}
<link rel="stylesheet" type="text/css" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}Plugin/fans.css" />
<link rel="stylesheet" type="text/css" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}Plugin/guanz.css" />
<a href="javascript:();" style="display:block" class="closed">
	<div class="_fly" id="fly_page" style="overflow:hidden"></div>
</a>
<div class="_flys" id="fly_pages" style="overflow:hidden">
	<div class="pwpage" style="z-index: 9999;">
		<div class="pwd">
			<h1>长按二维码并识别</h1>
			<p class="title" style="margin:0px">请长按下图并选择识别图中二维码领取卡券</p>
			<img class="erweima" src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={pg:$ticket}">
		</div>
	</div>
</div>
<script type="text/javascript" src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}Plugin/topNotice.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}Plugin/jquery.leanModal.min.js"></script>
<link rel="stylesheet" type="text/css" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}Plugin/leanModal.css" />
<script type="text/javascript">
$(function(){
	$("a.closed").click(function(){
		$(".closed").hide();
		$("._flys").hide();
	});
	$('#modaltrigger_notice').leanModal({
		top:110,
		overlay:0.45,
		closeButton:".hidemodal"
	});
});
</script>
{pg:/if}	
	
{pg:if $coupon.show_status != 'expire'}
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  wx.config({
      debug: false,
      appId: 	'{pg:$sign_data.appId}',
	  timestamp: '{pg:$sign_data.timestamp}',
	  nonceStr: '{pg:$sign_data.nonceStr}',
	  signature: '{pg:$sign_data.signature}',
      jsApiList: [
        'addCard',
        'chooseCard',
        'openCard'
      ]
  });
document.querySelector('.abtn').onclick = function () {
	{pg:if !empty($issub)}
	$(".closed").show();
	$("._flys").show();
	return false;
	{pg:else}
	wx.addCard({
	    cardList: [{
	        cardId: '{pg:$coupon.card_id}',
	        cardExt: '{pg:$cardext}'
	    }], // 需要添加的卡券列表
	    success: function (res) {
	        var cardList = res.cardList; // 添加的卡券列表信息
	    }
	});
	{pg:/if}
}
</script>
{pg:/if}
</html>