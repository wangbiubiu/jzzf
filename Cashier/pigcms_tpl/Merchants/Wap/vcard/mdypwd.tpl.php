<!DOCTYPE html>
<html>
<head>
<title>会员卡密码</title>
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
            支付密码
        </label>
  </header>
  <div class="body">
    <div>
      <form name="myform" id="Js-myform" method="post">
        <table class="table_addr">
        <tr>
          <td>
            原始密码
          </td>
          <td>
            <input type="password" value="" name="oldpassword"/>
          </td>
        </tr>
        <tr>
          <td>
            新密码
          </td>
          <td>
            <input type="password" value="" name="password"/>
          </td>
        </tr>
        <tr>
          <td>
            确认密码
          </td>
          <td>
            <input type="password" value="" name="repassword"/>
          </td>
        </tr>
        </table>

        <div class="pt_10 pb_10 pl_10 pr_10">
          <input type="submit" class="button" value="保存修改" style="width:100%;">
        </div>

      </form>
    </div>
  </div>

</div>
{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}

</body>
</html>