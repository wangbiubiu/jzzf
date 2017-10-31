<!DOCTYPE html>
<html>
<head>
<title>会员详细地址</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<meta name="Keywords" content=""/>
<meta name="Description" content=""/>
<!-- Mobile Devices Support @begin -->
<meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
<meta content="telephone=no, address=no" name="format-detection">
<meta name="apple-mobile-web-app-capable" content="yes"/>
<!-- apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
<!-- Mobile Devices Support @end -->
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/cardmain.css" rel="stylesheet" type="text/css">
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>

</head>
<body onselectstart="return true;" ondragstart="return false;">
<div class="container addr_add">
  <header class="center">
        <label style="display:inline-block;">
            <span>&nbsp;</span>
            收货地址
        </label>
  </header>
  <div class="body">
    <div>
      <form name="myform" id="Js-myform" method="post">
        <table class="table_addr">
        <tr>
          <td>
            收货人
          </td>
          <td>
            <input type="text" value="{pg:$UserInfo.truename}" name="truename" placeholder="请输入收货人"/>
          </td>
        </tr>
        <tr>
          <td>
            手机号码
          </td>
          <td>
            <input type="text" value="{pg:$UserInfo.tel}" name="tel" placeholder="请输入联系电话" onkeyup="onlyNumber(this,11)"/>
          </td>
        </tr>
        <tr>
          <td>
            详细地址
          </td>
          <td>
            <input type="text" value="{pg:$UserInfo.address}" name="address" placeholder="请输入详细地址" />
          </td>
        </tr>
        </table>

        <div class="pt_10 pb_10 pl_10 pr_10">
          <input type="submit" class="button" value="保存收货地址" style="width:100%;">
        </div>

      </form>
    </div>
  </div>

</div>
{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}

</body>
<script type="text/javascript">
function onlyNumber(obj,len){
	var thisv=$.trim($(obj).val());
	if(len>0){
	  thisv=thisv.replace(/[^1234567890]*/g,'');
	  if(thisv.length>len){
	     thisv=thisv.substring(0,len);
	  }
	}else{
	  thisv=thisv.replace(/[^1234567890]*/g,'');
	}
	$(obj).val(thisv);
}
</script>
</html>