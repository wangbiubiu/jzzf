<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{pg:$store.business_name}{pg:$store.branch_name}</title>
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
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/layer/layer.js"></script>

<iframe id="geoPage" width="1px" height="1px" style="display:none;left:-999px" frameborder=0 scrolling="no" src="http://apis.map.qq.com/tools/geolocation?key=S6PBZ-D7BRQ-BNB5S-G2LBZ-PYAIO-DJF4K&referer=Wapindex"></iframe>
<body style="zoom: 1; padding-bottom: 0px;">
	<section class="discountImg">
		{pg:if $store.discount > 0 && $store.reduce_cost > 0}
		<img class="blur" src="{pg:$photo_list[0].local_img}" data-pics="{pg:$photo_list[0].local_img}">
		<div class="countThis">
			<span><b>{pg:$store.discount} <em class="ema">折</em></b> /<b>{pg:$store.reduce_cost}<i>元</i></b></span>
		</div>
		{pg:else}
		<img  src="{pg:$photo_list[0].local_img}" data-pics="{pg:$photo_list[0].local_img}">
		{pg:/if}
		{pg:if !empty($coupons)}
		<div class="btnThis">
			<a href="?m=Wap&c=index&a=couponlist&id={pg:$store.id}">领取折扣优惠</a>
		</div>
		{pg:/if}
	</section>
	<section class="infoBox">
		<div class="supInfo">
			<div class="brand mb5">
				{pg:$store.business_name}{pg:$store.branch_name} {pg:if $store.reduce_cost > 0}<em class="supTip cut">减</em>{pg:/if}<!--em class="supTip been">我去过</em-->
			</div>
			<div class="rating">
				<!--span class="rate"> 
					<span class="rate-inner" style="width: 64.8px"></span>
				</span--> 
				<em>人均{pg:$store.avg_price}元</em>
			</div>
			<div class="infoImg">
				{pg:if $photo_count > 0}
				<img {pg:if isset($photo_list[0].local_img)} src="{pg:$photo_list[0].local_img}" {pg:else} src="{pg:$photo_list[0].photo_url}"{pg:/if}> <i>{pg:$photo_count}</i>
				{pg:/if}
			</div>
		</div>

		<div class="subInfo">
			<a href="http://apis.map.qq.com/tools/poimarker?type=0&marker=coord:{pg:$store.latitude},{pg:$store.longitude};title:{pg:$store.business_name}{pg:$store.branch_name};addr:{pg:$store.address}&key=S6PBZ-D7BRQ-BNB5S-G2LBZ-PYAIO-DJF4K&referer=Wapindex">
			<i class="posImg  icon-map-marker"></i>
			<div class="addrThis">
				<p>{pg:$store.address}</p>
			</div>
			<em class="space" id="jiuli">0km</em>
			</a>
			<a class="phoneThis" href="tel:{pg:$store.telephone}"></a>
		</div>
	</section>
	<section class="moreInfo">
		<div class="row">
			<em>{pg:$store_count}家<i class="arrowThis"></i></em> <a href="?m=Wap&c=index&a=storelist&mid={pg:$store.mid}" class="titThis">商家其他门店</a>
		</div>
		{pg:if !empty($card)}
		<div class="row">
			<em>领取<i class="arrowThis"></i></em> <a href="?m=Wap&c=index&a=coupon&storeid={pg:$store.id}&id={pg:$card.id}" class="titThis">{pg:$card.card_title}</a>
		</div>
		{pg:/if}
		{pg:if !empty($coupons)}
		<div class="row">
			<em>领取<i class="arrowThis"></i></em> <a href="?m=Wap&c=index&a=couponlist&id={pg:$store.id}" class="titThis">优惠券</a>
		</div>
		{pg:/if}
		<div class="row">
			<em>打开<i class="arrowThis"></i></em> <a href="/merchants.php?m=Wap&c=index&a=payRecord" class="titThis">我的消费记录</a>
		</div>
		{pg:foreach item=item from=$menus}
		<div class="row">
			<em>打开<i class="arrowThis"></i></em> <a href="{pg:$item.url}" class="titThis">{pg:$item.name}</a>
		</div>
		{pg:/foreach}

		<div class="row">
			<h2>更多信息</h2>
			{pg:if !empty($store.introduction)}
			<p class="someTips">
				<span>{pg:$store.introduction}</span>
			</p>
			{pg:/if}
			<p>营业时间：{pg:$date_str}</p>
		</div>

		<!--div class="row">
			<em>298条<i class="arrowThis"></i></em>
			<div class="mod2">
				评价&nbsp;<span class="rate"> <span class="rate-inner"
					style="width: 64.8px"></span>
				</span>
			</div>
			<div class="rateWord">
				<em> 料子不错 </em>
				<em> 面里有屎面里有屎面里有屎面里有屎 </em>
				<em> 料子不错料子不错料子不错 </em>
				<em>面里有屎 </em>
			</div>
		</div-->
		<div class="row">
			<div class="mod2">商家说明</div>
			<div class="notes">
				{pg:if !empty($store.recommend)}
				<div class="par">
					<strong>推荐说明：</strong>
					<p>{pg:$store.recommend}</p>
				</div>
				{pg:/if}
				{pg:if !empty($store.special)}
				<div class="par">
					<strong>特色服务：</strong>
					<p>{pg:$store.special}</p>
				</div>
				{pg:/if}
			</div>
		</div>
	</section>

	<div class="positionDiv">
		{pg:if empty($attention)}
		<a class="ftGreenBtn attention" href="javascript:;"> 收藏商家</a> 
		{pg:else}
		<a class="ftGrayBtn attention" href="javascript:;"> 取消收藏</a> 
		{pg:/if}
		<a class="ftGreenBtn" href="?m=Wap&c=index&a=SimplePay&mid={pg:$store.mid}&storeid={pg:$store.id}&poi_id={pg:$store.poi_id}">快速买单</a>
	</div>
</body>
<script type="text/javascript"> 
var locat = null;
var mylat = 0, mylng = 0, locatNum = 0;
//监听定位组件的message事件
window.addEventListener('message', function(event) { 
	locat = event.data; // 接收位置信息
    //console.log('location', locat);
	mylat = locat ? locat.lat :0;
	mylng = locat ? locat.lng :0;
    if(locat) { //定位成功
		locatNum++;
    } else { //定位组件在定位失败后，也会触发message, event.data为null
        alert('定位失败'); 
    }
	if(locatNum == 1){
		getFlatternDistance(parseFloat(mylat), parseFloat(mylng), parseFloat('{pg:$store.latitude}'), parseFloat('{pg:$store.longitude}'));
	}
}, false);

var flag = false;
$(document).ready(function(){

	$('.attention').click(function(){
		if (flag) return false;
		flag = true;
		var obj = $(this), opt = 'add';
		if ($(this).attr('class') == 'ftGrayBtn attention') {
			opt = 'del';
		}
		$.get('?m=Wap&c=index&a=attention&storeid={pg:$store.id}&opt=' + opt, function(data){
			flag = false;
			layer.msg(data.errmsg);
			if (data.errcode == 0) {
				if (obj.attr('class') == 'ftGrayBtn attention') {
					obj.attr('class', 'ftGreenBtn attention').html('关注收藏');
				} else {
					$('.attention').removeClass('ftGreenBtn attention').addClass('ftGrayBtn attention').html('取消收藏');
				}
			}
		}, 'json');
	});
});

function getFlatternDistance(lat1,lng1,lat2,lng2){
	var EARTH_RADIUS = 6378137.0;    //单位M
	var PI = Math.PI;

	function getRad(d){
	    return d*PI/180.0;
	}

    var f = getRad((lat1 + lat2)/2);
    var g = getRad((lat1 - lat2)/2);
    var l = getRad((lng1 - lng2)/2);
    
    var sg = Math.sin(g);
    var sl = Math.sin(l);
    var sf = Math.sin(f);
    
    var s,c,w,r,d,h1,h2;
    var a = EARTH_RADIUS;
    var fl = 1/298.257;
    
    sg = sg*sg;
    sl = sl*sl;
    sf = sf*sf;
    
    s = sg*(1-sl) + (1-sf)*sl;
    c = (1-sg)*(1-sl) + sf*sl;
    
    w = Math.atan(Math.sqrt(s/c));
    r = Math.sqrt(s*c)/w;
    d = 2*w*a;
    h1 = (3*r -1)/2/c;
    h2 = (3*r +1)/2/s;
	var distjuli = d * (1 + fl * (h1 * sf * (1 - sg) - h2 * (1 - sf) * sg));
	var _distjuli = distjuli > 1000 ? ((distjuli/1000).toFixed(2) + ' KM') : (parseInt(distjuli) + " M");
    $('#jiuli').html(_distjuli);
    return false;
}
</script>
</html>