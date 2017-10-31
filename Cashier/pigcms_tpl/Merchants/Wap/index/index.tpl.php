<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>卡券平台</title>
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
	<script type="text/javascript">
	  function getRTime(time, id)
	  {
	      var d = Math.floor(time/60/60/24);
	      var h = Math.floor(time/60/60%24);
	      var m = Math.floor(time/60%60);
	      var s = Math.floor(time%60);
	  	if (d > 0) {
	  		$("#day_" + id).html(d);
	  	} else {
	  		$("#day_" + id).next('em').remove();
	  		$("#day_" + id).remove();
	  	}
	  	$("#hour_" + id).html(h);
	  	$("#minute_" + id).html(m);
	  	$("#second_" + id).html(s);
	  	setTimeout(getRTime, 1000, time - 1, id);
	  }
	</script>
    <body>
<header class="index-head" style="position: absolute">
    <a class="logo" href="##"><img src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/images/logo.png"></a>
    <div class="search J_search">
        <span class="js_product_search"></span><input placeholder="输入商家名" type="text" class="search_input">
    </div>
    <a href="/merchants.php?m=Wap&c=index&a=myCenter" class="me"></a>
</header>
  <iframe id="geoPage" width="1px" height="1px" style="display:none;left:-999px" frameborder=0 scrolling="no"
    src="http://apis.map.qq.com/tools/geolocation?key=S6PBZ-D7BRQ-BNB5S-G2LBZ-PYAIO-DJF4K&referer=Wapindex"></iframe>
	
    <section class="scroll pt50">
	{pg:if !empty($bannerArr)}
        <!-- Swiper -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
			    {pg:section name=vv loop=$bannerArr}
                <div class="swiper-slide">
				     {pg:if !empty($bannerArr[vv].url)}
					 <a href="{pg:$bannerArr[vv].url}">
                    <img src="{pg:$bannerArr[vv].pic}" width="100%" alt="{pg:$bannerArr[vv].title}">
					</a>
					{pg:else}
                    <img src="{pg:$bannerArr[vv].pic}" width="100%" alt="{pg:$bannerArr[vv].title}">
					{pg:/if}
                </div>
				{pg:/section}
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <script>
            var swiper = new Swiper('.swiper-container', {
                loop:true,
                autoplay: 5000,//可选选项，自动滑动
                // 如果需要分页器
                pagination: '.swiper-pagination'
            });
        </script>
		{pg:/if}
    </section>

{pg:if !empty($categoryS)}
<div class="index-category mb15 clearfix" style="margin-top:15px;padding-bottom: 20px;">
<div class="page icon_list">
  {pg:php}$mmm=0;{pg:/php}
  {pg:section name=vv loop=$categoryS}
  {pg:php}$mmm++;{pg:/php}
  <a href="/merchants.php?m=Wap&c=index&a=allStores&fcid={pg:$categoryS[vv].fid}&cid={pg:$categoryS[vv].id}" class="item">
    <div class="icon fadeInLeft yanchi{pg:php} echo $mmm; {pg:/php}" style="background:url({pg:if $categoryS[vv].icon}{pg:$categoryS[vv].icon}{pg:else}{pg:$noimg}{pg:/if}); background-size:44px 44px; background-repeat:no-repeat;"></div>
    {pg:$categoryS[vv].name}</a>
	{pg:/section}
</div>
</div>
{pg:/if}
    <section class="newFun mt15 clearfix">
        <ul>
            <li>
                <a href="/merchants.php?m=Wap&c=index&a=activity&table_name=unitary">
                <div class="d-icon">
                    <img src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/images/i8.png">
                </div>
                <div class="desc">
                    <h2>一元夺宝</h2>
                    <small>新用户专享</small>
                </div>
                </a>
            </li>
            <li>
                <a href="/merchants.php?m=Wap&c=index&a=activity&table_name=seckill_action">
                <div class="d-icon">
                    <img src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/images/i1.png">
                </div>
                <div class="desc">
                    <h2>秒杀</h2>
                    <small>新用户专享</small>
                </div>
                    </a>
            </li>
            <li>
                <a href="/merchants.php?m=Wap&c=index&a=activity&table_name=crowdfunding">

                <div class="d-icon">
                    <img src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/images/i2.png">
                </div>
                <div class="desc">
                    <h2>众筹</h2>
                    <small>新用户专享</small>
                </div>
                    </a>
            </li>
            <li>
                <a href="/merchants.php?m=Wap&c=index&a=activity&table_name=bargain">

                <div class="d-icon">
                    <img src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/images/i3.png">
                </div>
                <div class="desc">
                    <h2>砍价</h2>
                    <small>新用户专享</small>
                </div>
                    </a>
            </li>
            <li>
                <a href="/merchants.php?m=Wap&c=index&a=activity&table_name=cutprice">

                <div class="d-icon">
                    <img src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/images/i5.png">
                </div>
                <div class="desc">
                    <h2>降价拍</h2>
                    <small>新用户专享</small>
                </div>
                    </a>
            </li>
            <li>
                <a href="/merchants.php?m=Wap&c=index&a=activity&table_name=lottery">

                <div class="d-icon">
                    <img src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/images/i4.png">
                </div>
                <div class="desc">
                    <h2>抽奖专场</h2>
                    <small>新用户专享</small>
                </div>
                    </a>
            </li>
            <!--li>
                <a href="##">

                <div class="d-icon">
                    <img src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/images/i6.png">
                </div>
                <div class="desc">
                    <h2>优惠团</h2>
                    <small>新用户专享</small>
                </div>
                    </a>
            </li>
            <li>
                <a href="/merchants.php?m=Wap&c=index&a=activity&table_name=auction">

                <div class="d-icon">
                    <img src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/images/i7.png">
                </div>
                <div class="desc">
                    <h2>微拍卖</h2>
                    <small>新用户专享</small>
                </div>
                </a>
            </li-->
        </ul>
    </section>

<script type="text/javascript">
    var myScroll;
    function loaded () {
        myScroll = new IScroll('#scrollThis', { scrollX: true, scrollY: false, mouseWheel: true,preventDefault: false});
    }
    window.onload=function(){
        var li=$("#scrollThis .scroller li");
        var liW=li.width()+20;
        var liLen=li.length;
        $("#scrollThis .scroller").width(liW*liLen);
        loaded ();
    }
</script>
    <section class="scrollGoods mt15">
        <h2>今日活动</h2>
        <div class="scrollBox">
            <div id="scrollThis">
                <div class="scroller">
                    <ul id="act_content1">
						{pg:foreach item=arow from=$activity_list}
						<li>
						<a href="{pg:$arow.joinurl}">
						<img src="{pg:$arow.pic}"/>
						<h3>{pg:$arow.title} </h3>
						
						{pg:if $arow.table_name == 'crowdfunding' || $arow.table_name == 'unitary'}
						<p class="zcPrice"><span>价值：{pg:$arow.price}元</span></p>
						<div class="progressBar">
							<span>
								<i style="width:{pg:$arow.percent}"></i>
							</span>
							<small>已完成{pg:$arow.percent}</small>
						</div>
						{pg:else}       
							<p> 
							{pg:if $arow.type > 0}
								<span><i>最高奖：</i>{pg:$arow.price}</span>
							{pg:else}
								{pg:if $arow.price > 0}
									<span>{pg:$arow.price}<i>元</i></span>
								{pg:/if}
								{pg:if $arow.original_price > 0}
									<span>原价{pg:$arow.original_price}元</span>
								{pg:/if}
							{pg:/if}
							</p>
							{pg:if $arow.table_name == 'cutprice' || $arow.table_name == 'bargain'}
								<small><em><i>{pg:$arow.joincount}</i>已参与</em></small>
							{pg:/if}
							<div class="time">
							{pg:if $arow.endtime > 0}
							<script type="text/javascript">getRTime('{pg:$arow.endtime}', '{pg:$arow.id}');</script>
							<span id="day_{pg:$arow.id}">0</span><em>:</em>
							<span id="hour_{pg:$arow.id}">0</span><em>:</em><span id="minute_{pg:$arow.id}">0</span><em>:</em><span id="second_{pg:$arow.id}">0</span>
							{pg:/if}
							</div>
						{pg:/if}
						</a>
						<i class="tipOn {pg:$arow.table_name}">{pg:$arow.actname}</i>
						</li>
						{pg:/foreach}
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="tabMod mt15" style="margin-bottom: 70px;">
        <div class="hd">
            <ul id="navShopli">
                <li class="on"><a href="javascript:;" onclick="getShop(1,$(this));">附近店铺</a></li>
                <li><a href="javascript:;" onclick="getShop(2,$(this));">最大优惠</a> </li>
                <li><a href="javascript:;" onclick="getShop(3,$(this));">最大折扣</a></li>
            </ul>
        </div>
        <div class="bd">
		  <p id="LocateTips" style="margin: 10px;text-align: center;"><img src="{pg:$loadbg}"></p>
            <ul class="product_list js-near-content" id="shoplist">
                <li class="pro_shop">
                    <div class="home-tuan-list js-store-list">
                        <p class="clickMore"><a href="javascript:;" id="mypageid" data-pageid="1">查看更多</a></p>
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
	var listType=1;
	var mylat=31.806904;
	var mylng=117.231974;
	var provinceStr='';
	var cityStr='';
	var locatNum=0;
    //监听定位组件的message事件
    window.addEventListener('message', function(event) { 
        locat = event.data; // 接收位置信息
        //console.log('location', locat);
        mylat=locat ? locat.lat :0;
		mylng=locat ? locat.lng :0;
		provinceStr=locat ? locat.province :'';
		cityStr=locat ? locat.city :'';
        if(locat) { //定位成功
			locatNum++;
        } else { //定位组件在定位失败后，也会触发message, event.data为null
			flage=true;
            alert('定位失败'); 
        }
		if(cityStr){
		   SaveArea(cityStr,provinceStr);
		}
		if(locatNum==1){
		$('#LocateTips').hide();
		 GetShopByCon({mylat:mylat,mylng:mylng,listType:listType});
		}
    }, false);
     
    //设置6s超时，防止定位组件长时间获取位置信息未响应
    setTimeout(function() {
        if(!locat && flage) {
            //主动与前端定位组件通信（可选），获取粗糙的IP定位结果
        document.getElementById("geoPage")
            .contentWindow.postMessage('getLocation', 'http://map.qq.com');
		
        }
    }, 7000); //7s为推荐值，业务调用方可根据自己的需求设置改时间，不建议太短
	
    //getAjaxList();
	function GetShopByCon(dataObj,changeType){
	  var pageid=$('#mypageid').data('pageid');
	  pageid=parseInt(pageid);
	  pageid=pageid >0 ? pageid :1;
	  var nextpageid=pageid+1;
	  var aa = typeof(dataObj.kw)=='undefined' ? false :true;
	   var kwaa=aa;
		  if(!aa && typeof(changeType)!='undefined' && changeType==1){
			  aa = true;
		  	 $('#shoplist .clickMore').html('<a href="javascript:;" id="mypageid" data-pageid="1">查看更多</a>');
			 pageid=1;
			 nextpageid=2;
		  }
	  dataObj.page=pageid;
	  var UrRL='?m=Wap&c=index&a=GetShops';
		$.ajax({
			url:UrRL,
			type:"post",
			data:dataObj,
			dataType:"JSON",
			success:function(ret){
				if(!ret.error){
					ToAddShopsData(ret.list,aa);
					if(ret.nextpage==nextpageid){
					   $('#mypageid').data('pageid',nextpageid);
					}else{
					   $('#mypageid').parent('.clickMore').html('<a href="javascript:;">没有更多了</a>');
					   	if(pageid==1){
							$('#shoplist .home-tuan-list .clickMore a').remove();
						}
					}
					
				}else{
					$('#LocateTips').hide();
					if(pageid==1){
					 $('#mypageid').parent('.clickMore').html('<a href="javascript:;">没有数据！</a>');
					 $('#shoplist li').show();
					}
					if(kwaa){
						$('#shoplist li div a.item').remove();
					   $('.clickMore').html('<a href="javascript:;">没有搜索到数据！</a>');
					}
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
				'<div class="gift"><em>'+vv.category_name+'</em><em>'+vv.receivenum+'人已领</em></div>'+
				 '<div class="discount">';
				if(vv.discount >0){
					htmlTpl+='<span>'+vv.discount+'<i>折</i></span>';
				}
				htmlTpl+='<span>'+vv.juli+'</span></div>'+
						'</div></div></div></div></a>';
		 });
		 if(aa){
		 $('#shoplist li div a.item').remove();
		 }
	     $('#shoplist .clickMore').before(htmlTpl);
		 $('#LocateTips').hide();
	    $('#shoplist li').show();
	}
	   $('.js_product_search').click(function(){
	     var keywstr=$(this).siblings('.search_input').val();
		 if(keywstr){
		     GetShopByCon({mylat:mylat,mylng:mylng,listType:listType,kw:keywstr});
		 }
	   });
		$(".search_input").keyup(function(e){
			var curKey = e.keyCode ||e.charCode || e.which;
			if(curKey == 13){
			   $(".js_product_search").click();
			   return false;
			}
		}); 
	  $('#shoplist').on('click','#mypageid',function(){
	     GetShopByCon({mylat:mylat,mylng:mylng,listType:listType});
	  });

	  function  getShop(type,obj){
	       $('#navShopli li').removeClass('on');
		   obj.parent('li').addClass('on');
		   $('#shoplist li div a.item').remove();
		   $('#mypageid').data('pageid',1);
		   $('#LocateTips').show();
		   listType=type;
		   GetShopByCon({mylat:mylat,mylng:mylng,listType:listType},1);
	  }

	  function SaveArea(cityStr,provinceStr){
	     $.get('?m=Wap&c=index&a=SaveArea',{city:cityStr,province:provinceStr},function(ret){});
	  }

	  function getAjaxList() {
	  	$.post('/merchants.php?m=Wap&c=index&a=ajaxactivity', {'table_name':'all', 'pagesize':6, 'order':'DESC'}, function(response){
	  		var html = ''
	  		$.each(response.data, function(i, row){

	  			html += '<li><a href="' + row.joinurl + '">';
	  			html += '<img src="' + row.pic + '"/>';
	  			html += '<h3>' + row.title + ' </h3>';
	  			if (row.price > 0) {
	  				html += '<p><span>' + row.price + '<i>元</i></span></p>';//<span>原价 20元</span>
	  			}
				html += '<div class="time">';
	  			if (row.endtime > 0) {
	  				getRTime(row.endtime, row.id);
	  				html += '<span id="day_' + row.id + '">0</span><em>天</em>';
	  				html += '<span id="hour_' + row.id + '">0</span><em>:</em><span id="minute_' + row.id + '">0</span><em>:</em><span id="second_' + row.id + '">0</span>';
	  			}
				html += '</div>';
				html += '</a>';
				html += '<i class="tipOn ' + row.table_name + '">' + row.actname + '</i>';
				html += '</li>';
	  		});
	  		$('#act_content').html(html);
	  	}, 'json');
	  }
    </script> 
</html>