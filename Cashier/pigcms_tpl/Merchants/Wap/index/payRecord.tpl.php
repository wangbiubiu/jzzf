<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>消费列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/base.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/swiper.min.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/font-awesome.min.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/style.css">
    <script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>
	<style>
	.noRecord div{text-align: center;font-size: 18px;}
	</style>
<body style="zoom: 1; padding-bottom: 0px;">
<div class="userHeader">
    <a class="back" href="javascript:;" onclick="window.history.back();">返回</a>
    <h2>我的消费</h2>
</div>
<div class="purchaseHistory">

  <div class="row" id="footerpage">
    <p class="clickMore"><a href="javascript:;" id="mypageid" data-pageid="1">查看更多</a></p>
   </div>
</div>
</body>
<script type="text/JavaScript"> 
	function getPayRecord(pageid){
	  pageid=parseInt(pageid);
	  pageid=pageid >0 ? pageid :1;
	  var UrRL='?m=Wap&c=index&a=getPayRecord';
		$.ajax({
			url:UrRL,
			type:"GET",
			data:{page:pageid},
			dataType:"JSON",
			success:function(ret){
				if(ret.datas){
					ToAddPayRecord(ret.datas);
					if(ret.nextpage>0){
					   $('#mypageid').data('pageid',nextpage);
					}else{
					   $('#mypageid').parent('.clickMore').html('<a href="javascript:;">没有更多了</a>');
					}
					
				}else if(pageid==1){
					$('.purchaseHistory').html('<div class="row noRecord"><div>您还没有任何消费记录</div></div>');
			   }
			}
		});
	}

	function ToAddPayRecord(datas){
		htmlTpl='';
		 $.each(datas,function(nn,vv){
			 htmlTpl+='<div class="row"><em>'+vv.goods_price+'<s>元</s><i class="arrowThis"></i></em>';
			 if(vv.storeid >0){
			  htmlTpl+='<a href="/merchants.php?m=Wap&c=index&a=storedetail&id='+vv.storeid+'" class="titThis">'+
              '<h3>'+vv.shopname+'</h3><p>'+vv.paytimeStr+'</p></a>';
			 }else{
			   htmlTpl+='<a href="javascript:;">'+
               '<h3>'+vv.shopname+'</h3><p>'+vv.paytimeStr+'</p></a>';
			 }
			 
			 htmlTpl+='</div>';
		 });
		
	    $('#footerpage').before(htmlTpl);
	}
	getPayRecord(1);
	$("body").on("click", "#mypageid", function () {
	   var pageid=$('#mypageid').data('pageid');
	   pageid=parseInt(pageid);
	   pageid=pageid >0 ? pageid :1;
	   getPayRecord(pageid);
	});
	</script>
</html>