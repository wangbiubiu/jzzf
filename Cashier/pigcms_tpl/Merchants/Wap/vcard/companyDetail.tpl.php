<!DOCTYPE html>
<html>
<head>  
<title>商家门店</title> 
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" /> 
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" /> 
<!-- Mobile Devices Support @begin --> 
<meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type" /> 
<meta content="telephone=no, address=no" name="format-detection" /> 
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<!-- apple devices fullscreen --> 
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> 
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/cardmain.css" rel="stylesheet" type="text/css">
</head> 
<body onselectstart="return true;" ondragstart="return false;"> 
  <div class="container addr"> 
   <div class="body"> 
    <ul class="list_ul list_addr "> 
     <ol> 
        <li class="li_b header tbox"> 
           <dd> 
                <i>&nbsp;</i> 
           </dd> 
           <dd> 
                <label class="label">商家门店</label> 
           </dd> 
        </li> 
     </ol> 
	 {pg:if !empty($merstores)}
	  {pg:foreach item=row from=$merstores}
    
     <div> 
        <li class="li_name tbox"> 
            <dd class="pl_10"></dd> 
            <dd> 
                <label class="label">{pg:$row.business_name}{pg:$row.branch_name}</label> 
            </dd> 
        </li> 
        <li class="li_tel tbox"> 
           <dd> 
                <i>&nbsp;</i> 
           </dd> 
           <dd> 
                <a class="label" href="tel:{pg:$row.telephone}">电话：{pg:$row.telephone}</a> 
           </dd> 
        </li> 
        <li class="li_add tbox"> 
        <dd> 
            <i>&nbsp;</i> 
        </dd> 
        <dd> 
            <a href="http://apis.map.qq.com/tools/poimarker?type=0&marker=coord:{pg:$row.latitude},{pg:$row.longitude};title:{pg:$row.business_name}{pg:$row.branch_name};addr:{pg:$row.address}&key=S6PBZ-D7BRQ-BNB5S-G2LBZ-PYAIO-DJF4K&referer=Wapindex">
                <label class="label">地址：{pg:$row.address}</label>
            </a> 
        </dd> 
        </li> 
     </div>
	{pg:/foreach}
	{pg:/if}
    </ul> 
   </div> 
  </div> 

{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}
 </body>
</html>