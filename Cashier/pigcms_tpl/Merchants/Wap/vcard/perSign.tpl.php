<!DOCTYPE html>
<html>
<head> 
<title>{pg:$thisCard.cardname}</title> 
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" /> 
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />  
<!-- Mobile Devices Support @begin --> 
<meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type" /> 
<meta content="telephone=no, address=no" name="format-detection" /> 
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<!-- apple devices fullscreen --> 
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> 
<!-- Mobile Devices Support @end --> 
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/cardmain.css" rel="stylesheet" type="text/css">
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>

</head> 
<body onselectstart="return true;" ondragstart="return false;"> 

<div class="container integral"> 
   <header> 
    <ul class="tbox tbox_1"> 
     <li> <p class="pre"> <label>{pg:$UserInfo.total_score}</label> 可用积分 </p> </li> 
     <li> 
     	<a href="javascript:void(0)" id="qiandao">
     		<label>
				{pg:if $todaySigned}
					已签到
				{pg:else}
					签到
				{pg:/if}
     		</label>
     	</a> 
     </li> 
     <li> <p class="pre"> <label>{pg:$UserInfo.sign_score}</label> 签到积分 </p> </li> 
    </ul> 
    <nav class="nav_integral"> 
     <ul class="box"> 
      <!--<li><a href=""> <span class="icons icons_prize">&nbsp;</span><label>兑换礼品</label></a></li>---> 
      <li><a href="/merchants.php?m=Wap&c=vcard&a=signdetail&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}"> <span class="icons icons_teach">&nbsp;</span><label>积分攻略</label></a></li> 
     </ul> 
    </nav> 
   </header> 
   <div class="body"> 
    <div> 
     <div class="Calendar"> 
      <header> 
       <div id="idCalendarPre">
        <a href="/merchants.php?m=Wap&c=vcard&a=perSign&mid={pg:$mid}&cdid={pg:$thisCard.id}&month={pg:$premonth}&year={pg:$pyear}&openid={pg:$openid}">
          <span class="icons icons_before">&nbsp;</span>
        </a>
       </div> 
       <div id="idCalendarNext">
        <a href="/merchants.php?m=Wap&c=vcard&a=perSign&mid={pg:$mid}&cdid={pg:$thisCard.id}&month={pg:$nextmonth}&year={pg:$nyear}&openid={pg:$openid}">
          <span class="icons icons_after">&nbsp;</span>
        </a>
       </div> 
       <span id="idCalendarYear">{pg:$nowdate}</span>
      </header> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="integral_table">
          <tr>
            <th>签到日期</th>
            <th>签到状况</th>
            <th>获得积分</th>
          </tr>
		 {pg:if !empty($signRecords)}
		 {pg:foreach item=row from=$signRecords}
          <tr>
            <td width="33%">{pg:$row.signtime|date_format:"%Y-%m-%d"}</td>
            <td width="33%"><span class="wqian">已签到</span></td>
            <td width="33%" style="color:green;">+{pg:$row.expense}</td>
          </tr>
		  {pg:/foreach}
		  {pg:/if}
        </table>
     </div> 
    </div> 
   </div> 
  </div>


{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}

<script type="text/javascript">
var ispost=false;
$(function(){
	$("#qiandao").click(function () { 
		if(ispost){
		   return false;
		}
		var btn = $(this);
		var submitData = {
			cdid:{pg:$cdid}
		};
		ispost=true;
		$.post('/merchants.php?m=Wap&c=vcard&a=qdsign&mid={pg:$mid}&cdid={pg:$thisCard.id}&openid={pg:$openid}', submitData,
		function(ret) {
			ispost=false;
			myalert(ret.msg);
			if (!ret.error) {
				$("#qiandao").html("已签到");
				 setTimeout(function(){
				 	window.location.reload();
				 },2000);
			} 
		},
		"json");
	});  
});
</script>


</body>
</html>