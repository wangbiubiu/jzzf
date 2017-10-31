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
  <div class="container coupon message "> 
   <header> 
    <nav class="p_10"> 
      <h3>系统消息</h3>
    </nav> 
   </header> 
   <div class="body"> 
    <ul class="list_message"> 
	 {pg:if !empty($noticeArr)}

	  {pg:foreach item=row from=$noticeArr}
      <li class="Js-read">
        <a href="javascript:;" onclick="readMsg(this, event,2166482);"> 
          <dl class="tbox"> 
            <dd> 
              <span class="icon_1"><img src="" /></span> 
            </dd> 
            <dd> 
              <h3> {pg:$row.ntitle} </h3> 
              <p> {pg:$row.addtimeStr} </p> 
            </dd> 
          </dl> 
        </a> 
        <ol> 
          <p> {pg:$row.ncontent} </p> 
		  {pg:if !empty($row.endtimeStr)}
		  <br/>
		  <p style="color:red">截止日期： {pg:$row.endtimeStr} </p>
		  {pg:/if}
        </ol> 
      </li> 
	  {pg:/foreach} 

      {pg:/if}
    </ul> 
   </div> 
{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}
  <script>
      function readMsg(thi, evt,id){
        var li = thi.parentNode;
        li.classList.toggle("on");
        li.removeAttribute("data-read");

        if ($(li).hasClass("Js-read"))
          return false;
        $(li).addClass("Js-read");

      }
    </script>



</body>
</html>