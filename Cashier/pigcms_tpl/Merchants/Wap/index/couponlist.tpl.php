<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{pg:$title}</title>
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
	<div class="userHeader">
		<a class="back" href="javascript:;" onclick="window.history.back();">返回</a>
		<h2>{pg:$title}</h2>
	</div>
	<div class="dCouponTab">
		<div class="hd">
			<div class="cell {pg:if $type == 0}on{pg:/if}" onClick="location.href='?m=Wap&c=index&a=couponlist&id={pg:$store.id}&fromtype={pg:$fromtype}'">全&nbsp;&nbsp;部</div>
			<div class="cell {pg:if $type == 2}on{pg:/if}" onClick="location.href='?m=Wap&c=index&a=couponlist&id={pg:$store.id}&type=2&fromtype={pg:$fromtype}'">已使用</div>
			<div class="cell {pg:if $type == 1}on{pg:/if}" onClick="location.href='?m=Wap&c=index&a=couponlist&id={pg:$store.id}&type=1&fromtype={pg:$fromtype}'">未使用</div>
		</div>
		<div class="bd">
			<ul>
				{pg:foreach item=item from=$coupons}
				<li>
					<a href="?m=Wap&c=index&a=coupon&storeid={pg:if isset($item.rvstoreid) AND !empty($item.rvstoreid)}{pg:$item.rvstoreid}{pg:else}{pg:$store.id}{pg:/if}&id={pg:$item.id}&rvid={pg:$item.rvid}">
					<div class="couponInfo clearfix" style="background-color:  {pg:$item.color}">
						<div class="whose">
							<img src="{pg:$item.kqcontent.logo_url}" alt="a">
						</div>
						<div class="desc">
							<h3>{pg:$item.card_title}</h3>
							<small><i class="icon-map-marker"></i>附近有门店可以使用</small>
						</div>
						{pg:if $item.discount > 0}
						<em>{pg:$item.discount}<i>折</i></em>
						{pg:elseif $item.reduce_cost > 0}
						<em><i>减</i>{pg:$item.reduce_cost}<i>元</i></em>
						{pg:/if}
					</div>
					<p class="time">有效期至 {pg:$item.end_timestamp}</p>
					<div class="status {pg:$item.show_status}"></div>
					</a>
				</li>
				{pg:/foreach}
				<!--li>
					<div class="couponInfo clearfix" style="background-color:palevioletred">
						<div class="whose">
							<img src="images/holder/home.png" alt="a">
						</div>
						<div class="desc">
							<h3>仟佶蛋糕</h3>
							<small><i class="icon-map-marker"></i>附近有门店可以使用</small>
						</div>
						<em>9.2<i>折</i></em>
					</div>
					<p class="time">有效期至 2015-10-19</p>
					<div class="status expire"></div>
				</li-->
			</ul>
		</div>
	</div>
</body>
</html>