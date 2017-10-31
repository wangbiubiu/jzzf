<!DOCTYPE html>
<html>
<head>
<title>会员卡绑定线下卡</title>
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
            绑定线下卡
        </label>
  </header>
  <div class="body">
    <div>
      <form name="myform" id="Js-myform" method="post">
        <table class="table_addr">
        <tr>
          <td>
            原始卡号
          </td>
          <td>
            <input type="text" value="{pg:$locmbnumber.numstr}" name="numstr" readonly="true"/>
          </td>
        </tr>
        <tr>
          <td>
            绑定卡号
          </td>
          <td>
            <input type="text" value="" name="offnumber"/>
          </td>
        </tr>
        <tr>
          <td>
            店员账号
          </td>
          <td>
            <input type="username" value="" name="username"/>
          </td>
        </tr>
        <tr>
          <td>
            店员密码
          </td>
          <td>
            <input type="password" value="" name="password"/>
          </td>
        </tr>
        </table>

        <div class="pt_10 pb_10 pl_10 pr_10">
          <input type="hidden" name="cdid" value="{pg:$cdid}">
          <input type="submit" class="button" value="确认绑定" style="width:100%;">
        </div>

      </form>
    </div>
  </div>

</div>
{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}
</body>
</html>