<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>会员卡领取</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
	<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/cardmain.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/swiper.min.css">

	<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>
    <script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/swiper.jquery.min.js"></script>
    <script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/iscroll.js"></script>
    <style></style>
    <body onselectstart="return true;" ondragstart="return false;">
	<div class="container">
    <section class="scroll pt50">
	{pg:if !empty($focusImg)}
        <!-- Swiper -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
			    {pg:section name=vv loop=$focusImg}
                <div class="swiper-slide">
				     {pg:if !empty($focusImg[vv].url)}
					 <a href="{pg:$focusImg[vv].url}">
                     <img src="{pg:$focusImg[vv].icon}" width="100%" alt="{pg:$focusImg[vv].name}">
					</a>
					{pg:else}
                    <img src="{pg:$focusImg[vv].icon}" width="100%" alt="{pg:$focusImg[vv].name}">
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
	
	<section class="body">
		<ul class="list_ul">
			<!-- 开卡活动-->
			<li class="li_b on">
				<label class="label show">
					<i>&nbsp;</i>
					领取会员卡
					<em class="pop {pg:if $cardsCount gt 0}yes{pg:else}no{pg:/if}">{pg:$cardsCount}</em>
				</label>
				{pg:if !empty($allCards)}
				{pg:foreach item=row from=$allCards}
					<ol class="bg">
						<a href="/merchants.php?m=Wap&c=vcard&a=mycard&mid={pg:$mid}&cdid={pg:$row.id}&openid={pg:$openid}">
							<img src="{pg:$row.mclogo}" class="img">
							<h6>{pg:$row.cardname}</h6>
							<p>{pg:$row.tipmsg}</p>
							{pg:if $row.applied eq 1}
		                        <em class="no">
		                            用卡
		                        </em>
							{pg:else}
		                        <em class="yes">
		                            领卡
		                        </em>
							{pg:/if}
	                	</a>

							{pg:if isset($giftsArr[$row.id])}
	                		<div class="gifts">
                                <a href="javascript:void(0);">
                                    点击查看开卡赠送活动
                                </a>
                            </div>
                            <div class="gifts_list clr">
                                <dl>
                                    
                                    <dt class="name">
                                        {pg:$giftsArr[$row.id].gtitle}
                                    </dt>
                                    <dt class="times">{pg:$giftsArr[$row.id].starttime|date_format:"%Y-%m-%d"} 开始
									{pg:if $giftsArr[$row.id].endtime gt 0}
									&nbsp; 到 &nbsp;{pg:$giftsArr[$row.id].endtime|date_format:"%Y-%m-%d"} 结束
									{pg:/if}
									</dt>
                                  
                                </dl>
                            </div>
							{pg:/if}

	                	<span class="clear"></span>
					</ol>
				{pg:/foreach} 
				{pg:/if}
			</li>


			<!-- 联系电话 -->
			<li class="li_i">
				<a class="label" href="tel:{pg:$merchants.phone}">
					<i>&nbsp;</i>
					{pg:if !empty($merchants.phone)}
						{pg:$merchants.phone}
					{pg:else}
						商家未设置电话
					{pg:/if}
					<span>&nbsp;</span>
				</a>
			</li>
			<!-- 门店-->
			<li class="li_k">
				<a href="/merchants.php?m=Wap&c=vcard&a=companyDetail&mid={pg:$mid}&cdid={pg:$cdid}&openid={pg:$openid}">
					<label class="label">
						<i>&nbsp;</i>
						{pg:if !empty($merchants.wxname)}
						  {pg:$merchants.wxname}
						  {pg:elseif !empty($merchants.weixin)}
						     {pg:$merchants.weixin}
						  {pg:else}
							商家未设置名称
						  {pg:/if}
						<span>&nbsp;</span>
					</label>
				</a>
			</li>
		</ul>
	</section>
  </div>

{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}
</body>
    <script type="text/JavaScript"> 
         $('.gifts').click(function(){
            if($(this).siblings('.gifts_list').css('display') == 'none'){
                $(this).addClass('hidd');
                $(this).siblings('.gifts_list').css('display','block')
            }else{
                $(this).removeClass('hidd');
                $(this).siblings('.gifts_list').css('display','none')
            }
        });
    </script> 
</html>