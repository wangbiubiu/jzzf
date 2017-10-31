<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>适用门店</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/base.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/swiper.min.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/font-awesome.min.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/style.css">
	<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>
    <script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/swiper.jquery.min.js"></script>
    <script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/iscroll.js"></script>
    <script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/common.js?ver={pg:$smarty.const.SYS_TIME}"></script>
    <body>
  <iframe id="geoPage" width="1px" height="1px" style="display:none;left:-999px" frameborder=0 scrolling="no" src="http://apis.map.qq.com/tools/geolocation?key=S6PBZ-D7BRQ-BNB5S-G2LBZ-PYAIO-DJF4K&referer=Wapindex"></iframe>

    <section class="tabMod mt15">
        <div class="bd">
		  <p id="LocateTips" style="margin: 10px;text-align: center;"><img src="{pg:$loadbg}"></p>
            <ul class="product_list js-near-content" id="shoplist">
                <li class="pro_shop">
                    <div class="home-tuan-list js-store-list">
                        <p class="clickMore" style="display: none;"><a href="javascript:;" id="mypageid" data-pageid="1">查看更多</a></p>
                    </div>
                </li>
            </ul>
        </div>
    </section>
{pg:include file="$tplHome/Wap/public/footer.tpl.php"}
</body>
<script type="text/JavaScript"> 
    var locat=null;
	var flage=false;
	var mylat=31.806904;
	var mylng=117.231974;
	var locatNum=0;
    //监听定位组件的message事件
    window.addEventListener('message', function(event) { 
        locat = event.data; // 接收位置信息
        //console.log('location', locat);
         mylat=locat ? locat.lat :0;
		 mylng=locat ? locat.lng :0;
        if(locat) { //定位成功
			locatNum++;
        } else { //定位组件在定位失败后，也会触发message, event.data为null
			flage=true;
            alert('定位失败'); 
        }
		if(locatNum==1){
			$('#LocateTips').hide();
			GetShopByCon({mylat:mylat,mylng:mylng});
		}
	}, false);
     
    //设置6s超时，防止定位组件长时间获取位置信息未响应
    setTimeout(function() {
		if(!locat && flage) {
            //主动与前端定位组件通信（可选），获取粗糙的IP定位结果
			document.getElementById("geoPage").contentWindow.postMessage('getLocation', 'http://map.qq.com');
		}
    }, 7000); //7s为推荐值，业务调用方可根据自己的需求设置改时间，不建议太短
	

	function GetShopByCon(dataObj){
	  dataObj.page = 1;
	  dataObj.mid = '{pg:$mid}';
	  var aa = typeof(dataObj.kw)=='undefined' ? false :true;
	  var UrRL='?m=Wap&c=index&a=GetShops';
		$.ajax({
			url:UrRL,
			type:"post",
			data:dataObj,
			dataType:"JSON",
			success:function(ret){
				if(!ret.error){
					ToAddShopsData(ret.list,aa);
					if(ret.nextpage==2){
					   $('#mypageid').data('pageid',2);
					}else{
					   //$('#mypageid').parent('.clickMore').html('<a href="javascript:;">没有更多了</a>');
					}
					
				}else{

			   }
			}
		});
	}

	function ToAddShopsData(datas,aa){
		htmlTpl='';
		 $.each(datas,function(nn,vv){
			 htmlTpl+='<a href="?m=Wap&c=index&a=storedetail&id='+vv.id+'" class="item clearfix"><div class="cnt">'+ 
			 '<img class="pic" src="'+vv.shoplogo+'"><div class="wrap"><div class="wrap2"><div class="content">'+
				'<div class="shopname">'+vv.business_name+vv.branch_name
			    if(vv.reduce_cost>0){
					htmlTpl+='<em class="supTip cut">减</em>';
			     }
				if(vv.isBeen){
				   htmlTpl+='<em class="supTip been">我去过</em>';
				}
				htmlTpl+='</div><div class="rating"><!--<span class="rate"><span class="rate-inner" style="width:64.8px"></span></span>--><em>人均'+vv.avg_price+'元</em></div>'+
				'<div class="gift"><em>'+vv.category_name+'</em><em>'+vv.receivenum+'人已领</em></div><div class="discount">';
				if(vv.discount >0){
					htmlTpl+='<span>'+vv.discount+'<i>折</i></span>';
				}
				htmlTpl+='<span>'+vv.juli+'</span></div></div></div></div></div></a>';
		 });
		if(aa){
		  $('#shoplist li div a.item').remove();
		}
	    $('#shoplist .clickMore').before(htmlTpl);
		$('#LocateTips').hide();
	   $('#shoplist li').show();
	}
	
</script> 
</html>