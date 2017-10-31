<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>收银台 | 门店</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/base.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/swiper.min.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/font-awesome.min.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/style.css">
	<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>
    <script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/swiper.jquery.min.js"></script>
    <script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/iscroll.js"></script>
	<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/drop.js"></script>
	<style>
	  .pageSliderHide{margin-top: 53px;}
	</style>
    <body style="min-height:520px;">
<header class="index-head" style="position: absolute">
    <a class="logo" href="##"><img src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/images/logo.png"></a>
    <div class="search J_search">
        <span class="js_product_search"></span><input placeholder="输入商家名" type="text" class="search_input">
    </div>
    <a href="/merchants.php?m=Wap&c=index&a=myCenter" class="me"></a>
</header>
  <iframe id="geoPage" width="1px" height="1px" style="display:none;left:-999px" frameborder=0 scrolling="no"
    src="http://apis.map.qq.com/tools/geolocation?key=S6PBZ-D7BRQ-BNB5S-G2LBZ-PYAIO-DJF4K&referer=Wapindex"></iframe>
	<section class="navBox pageSliderHide">
  <ul id="navcategory">
    <li class="dropdown-toggle caret category" data-nav="category"> <span class="nav-head-name">{pg:if $cid gt 0}{pg:$selectName}{pg:else}全部分类{pg:/if}</span> </li>
    <li class="dropdown-toggle caret biz subway" data-nav="biz"> <span class="nav-head-name">全城</span> </li>
    <li class="dropdown-toggle caret sort" data-nav="sort"> <span class="nav-head-name">默认排序</span> </li>
  </ul>
  <div class="dropdown-wrapper">
    <div class="dropdown-module">
      <div class="scroller-wrapper">
        <div id="dropdown_scroller" class="dropdown-scroller" style="overflow:hidden;">
          <div>
            <ul>
			 
              <li class="category-wrapper">
                <ul class="dropdown-list">
                  <li data-category-id="-1" class="active" onClick="list_location($(this),0,0,1);return false;">
				  <span data-name="全部分类">全部分类</span>
				  </li>
				  {pg:foreach item=row from=$category}
                  <li data-category-id="cy_{pg:$row.id}" {pg:if !empty($row.subcategory)} data-has-sub="true" class="right-arrow-point-right" {pg:else}onClick="list_location($(this),0,{pg:$row.id},1);return false;"{pg:/if}> <span data-name="{pg:$row.name}">{pg:$row.name}</span> {pg:if !empty($row.subcategory)}<span class="quantity"><b></b></span>{pg:/if}
                    <div class="sub_cat hide" style="display:none;">
					{pg:if !empty($row.subcategory)}
                      <ul class="dropdown-list sub-list">
                        <li data-category-id="subcy_{pg:$row.id}" onClick="list_location($(this),0,{pg:$row.id},1);return false;">
                          <div><span class="sub-name" data-name="{pg:$row.name}">全部</span></div>
                        </li>
						
						{pg:foreach item=subrow from=$row.subcategory}
                        <li data-category-id="subcy_{pg:$subrow.id}" onClick="list_location($(this),{pg:$subrow.fid},{pg:$subrow.id},1);return false;">
                          <div><span class="sub-name" data-name="{pg:$subrow.name}">{pg:$subrow.name}</span></div>
                        </li>
						{pg:/foreach}
                      </ul>
					  {pg:/if}
                    </div>
                  </li>
				  {pg:/foreach}
                </ul>
              </li>
			  
              <li class="biz-wrapper">
                <ul class="dropdown-list">
                  <li data-area-id="-1" class="active" onClick="list_location($(this),0,0,2);return false;">
				  <span data-name="全部">全部</span>
				  </li>
				  {pg:if isset($areaInfo.city)}
				   <li data-area-id="city_{pg:$areaInfo.city.id}" onClick="list_location($(this),0,{pg:$areaInfo.city.id},2);return false;">
				    <span data-name="{pg:$areaInfo.city.fullname}">{pg:$areaInfo.city.fullname}</span>
				  </li>
				  {pg:/if}
				  {pg:if isset($areaInfo.district)}
				  {pg:foreach item=drow from=$areaInfo.district}
                  <li data-area-id="area_{pg:$drow.id}" {pg:if isset($drow.circle) AND !empty($drow.circle)}data-has-sub="true" class="right-arrow-point-right" {pg:else} onClick="list_location($(this),0,{pg:$drow.id},2);return false;"{pg:/if}> <span  data-name="{pg:$drow.fullname}">{pg:$drow.fullname}</span> {pg:if isset($drow.circle) AND !empty($drow.circle)}<span class="quantity"><b></b></span>{pg:/if}
                    <div class="sub_cat hide" style="display:none;">
					 {pg:if isset($drow.circle) AND !empty($drow.circle)}
                      <ul class="dropdown-list sub-list">
					   
                        <li data-area-id="subarea_{pg:$drow.id}" onClick="list_location($(this),0,{pg:$drow.id},2);return false;">
                          <div><span class="sub-name" data-name="{pg:$drow.fullname}">全部</span></div>
                        </li>
						{pg:foreach item=subdrow from=$drow.circle}
                        <li data-area-id="subarea_{pg:$subdrow.id}" onClick="list_location($(this),{pg:$subdrow.fid},{pg:$subdrow.id},2);return false;">
                          <div><span class="sub-name" data-name="{pg:$subdrow.fullname}">{pg:$subdrow.fullname}</span></div>
                        </li>
						{pg:/foreach}
                      </ul>
					  {pg:/if}
                    </div>
                  </li>
				  {pg:/foreach}
				  {pg:/if}
                </ul>
              </li>
              <li class="sort-wrapper">
                <ul class="dropdown-list">
                  <li data-sort-id="order_1" class="active" onClick="list_location($(this),0,1,3);return false;"><span data-name="距离最近">距离最近</span></li>
                  <li data-sort-id="rating"  onclick="list_location($(this),0,2,3);return false;"><span data-name="优惠最大">优惠最大</span></li>
                  <li data-sort-id="start"  onclick="list_location($(this),0,3,3);return false;"><span data-name="折扣最大">折扣最大</span></li>
				 <li data-sort-id="start"  onclick="list_location($(this),0,4,3);return false;"><span data-name="均价最低">均价最低</span></li>
				  <li data-sort-id="start"  onclick="list_location($(this),0,5,3);return false;"><span data-name="均价最高">均价最高</span></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <div id="dropdown_sub_scroller" class="dropdown-sub-scroller">
          <div></div>
        </div>
      </div>
    </div>
  </div>
</section>

    <section class="tabMod mt15" style="margin-bottom: 70px;">
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
	var sortType=0;
	var extdata={
	   s1:{
	     fid:0,
		  id:0
	   },
	  s2:{
	     fid:0,
		  id:0
	   },
	 s3:{
	     fid:0,
		  id:0
	   },
	};
  
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
	

	function GetShopByCon(dataObj,topage){
	  var pageid=$('#mypageid').data('pageid');
	  pageid=parseInt(pageid);
	  pageid=pageid >0 ? pageid :1;
	  nextpageid=pageid+1;

	  var aa = typeof(dataObj.kw)=='undefined' ? false :true;
	  var kwaa=aa;
	  	if(!aa && typeof(dataObj.sortType)!='undefined' && typeof(topage)=='undefined'){
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
     var postData={mylat:mylat,mylng:mylng,listType:listType};
	 $('#shoplist').on('click','#mypageid',function(){
         postData.extdata=extdata;
		 postData.sortType=sortType;
	     GetShopByCon(postData,1);
	  });

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
	  function  getShop(type,obj){
	       $('#navShopli li').removeClass('on');
		   obj.parent('li').addClass('on');
		   listType=type;
		   $('#mypageid').data('pageid',1);
		   $('#LocateTips').show();
		   GetShopByCon({mylat:mylat,mylng:mylng,listType:listType},1);
	  }

	 function SaveArea(cityStr,provinceStr){
	     $.get('?m=Wap&c=index&a=SaveArea',{city:cityStr,province:provinceStr,cf:1},function(ret){
		    if(ret.error==3){
			    window.location.reload();
			}
		 });
	  }

    </script> 
    <script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/common.js?ver={pg:$smarty.const.SYS_TIME}"></script>

	{pg:if $cid gt 0}
	   <script type="text/JavaScript"> 
			   extdata={
			   s1:{
				 fid:{pg:$fcid},
				  id:{pg:$cid}
			   },
			  s2:{
				 fid:0,
				  id:0
			   },
			 s3:{
				 fid:0,
				  id:0
			   },
			};
		postData.extdata=extdata;
		postData.sortType=1;
		GetShopByCon(postData);
	   </script> 
	{pg:/if}
</html>