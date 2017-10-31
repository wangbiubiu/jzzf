<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>个人资料</title>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" />
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/cardfans.css" rel="stylesheet" type="text/css"> 
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/weui/weui.css" rel="stylesheet" type="text/css">

<style>
.footFix{width:100%;text-align:center;position:fixed;left:0;bottom:0;z-index:99;}
#footReturn a, #footReturn2 a {
	display: block;
	line-height: 41px;
	color: #fff;
	text-shadow: 1px 1px #282828;
	font-size: 14px;
	font-weight: bold;
}
#footReturn, #footReturn2 {
	z-index: 89;
	display: inline-block;
	text-align: center;
	text-decoration: none;
	vertical-align: middle;
	cursor: pointer;
	width: 100%;
	outline: 0 none;
	overflow: visible;
	Unknown property name.-moz-box-sizing: border-box;
	box-sizing: border-box;
	padding: 0;
	height: 41px;
	opacity: .95;
	border-top: 1px solid #181818;
	box-shadow: inset 0 1px 2px #b6b6b6;
	background-color: #515151;
	Invalid property value.background-image: -ms-linear-gradient(top,#838383,#202020);
	background-image: -webkit-linear-gradient(top,#838383,#202020);
	Invalid property value.background-image: -moz-linear-gradient(top,#838383,#202020);
	Invalid property value.background-image: -o-linear-gradient(top,#838383,#202020);
	background-image: -webkit-gradient(linear,0% 0,0% 100%,from(#838383),to(#202020));
	Invalid property value.filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#838383',endColorstr='#202020');
	Unknown property name.-ms-filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#838383',endColorstr='#202020');
}
.code{float:100%;float:left;margin:8px 10px 0 5px;padding:5px;width:120px;}

.is_check{float:left;margin:8px 0;padding:2px 10px;font-size:12px;border:1px solid #c1c1c1;background:#e6e6e6;border-radius:3px;}
.is_check:hover{background:#c1c1c1;}

#num{padding-right:5px;}
.window .title{background-image: linear-gradient(#179f00, #179f00);}

.ui-dialog .ui-dialog-titlebar {
    background-image: linear-gradient(#179f00, #179f00);
    color:#fff;
}

.por{width:65px;float:left;height:65px;}
.por img{width:60px;height:60px;cursor:pointer}
.por img.selected{border:2px solid #f60}

.kuang th {
  width: 84px;
}

#upload_list li{width:71px;height:71px;}
#portrait_src{width:70px;height:70px;}

.px {border-radius: 5px;border: #C6FAC2 1px solid;
box-shadow: 0 0 8px rgba(217,252,222,0.9);
-moz-box-shadow: 0 0 8px rgba(217,252,222,0.9);
-webkit-box-shadow: 0 0 8px rgba(217,252,222,0.9);}
</style>
</head>
<body id="fans" >
<div class="qiandaobanner"><img src="{pg:$locimgpath}/pigcms_static/image/cardbg/fans.jpg" ></div>
<div class="cardexplain">
	<li class="nob">
		<div class="beizhu">
			请先完善您的个人信息，红色*标志的为必填项
		</div>
	</li>
	<form name="myform" action="" method="POST">
	   <input type="hidden" value="{pg:$mid}"  name="mid"/>
	   <input type="hidden" value="{pg:$cdid}"  name="cdid"/>
	   <input type="hidden" value="{pg:if !empty($UserInfo)}{pg:$UserInfo.id}{pg:else}0{pg:/if}"  name="uid"/>
	   <input type="hidden" value="{pg:if !empty($UserInfo)}{pg:$UserInfo.province}{pg:/if}"  name="province"/>
	   <input type="hidden" value="{pg:if !empty($UserInfo)}{pg:$UserInfo.city}{pg:/if}"  name="city"/>
	<ul class="round">
		<div class="grxx"><span style="margin-left:10px">个人信息</span></div>
		<div class="nrxx">	
  <li> 
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
    <tbody>
     <tr>
      <th><font color="red">*</font>微信昵称</th>
      <td><input type="text" class="px" id="field1" name="field1" value="{pg:$UserInfo.nickname}" placeholder="请填写微信昵称" data-empty="1" /></td>
     </tr>
    </tbody>
   </table></li>
  <li>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
    <tbody>
     <tr>
      <th><font color="red">*</font>手机号</th>
      <td><input type="tel" class="px phonetel" id="field2" name="field2" value="{pg:$UserInfo.tel}" placeholder="请填写手机号" onkeyup="onlyNumber(this,11)" data-empty="1" /></td>
     </tr>
    </tbody>
   </table></li>
   {pg:if $isphonev gt 0}
   <li>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang"><tbody><tr><th><font color="red">短信验证</font></th><td><input name="smscode" class="code" id="smscode" value="" type="tel" placeholder="效验码"  onkeyup="onlyNumber(this,7)"><a class="is_check" href="javascript:void(0);"><em id="countdown"></em><b>点击获取效验码</b></a></td></tr></tbody></table>
   </li>
   {pg:/if}
  <ul class="round" id="ul_portrait">
   <li>
    <div style="padding:10px 10px 10px 0;">
     请设置头像
    </div>
	  <div class="weui_uploader_bd"> 
      <ul class="weui_uploader_files" id="upload_list"> 
       <li class="weui_uploader_file">
	   <img	src="{pg:$UserInfo.headimgurl}" id="portrait_src" />
	   <input type="hidden" value="{pg:$UserInfo.headimgurl}" id="portrait" name="portrait"/>
	   </li> 
      </ul> 
	   <div class="weui_uploader_input_wrp">
            <input class="weui_uploader_input" type="file" accept="image/jpg,image/jpeg,image/png,image/gif" id="fileImage"  multiple />
        </div>
     </div>

    <div style="clear:both"></div>
	或者选择下面头像
    <div style="margin:10px 0 20px 0" id="pors">
     <div class="por">
      <img onclick="selectpor(this)" src="{pg:$locimgpath}/pigcms_static/image/portrait/1.jpg" />
     </div>
     <div class="por">
      <img onclick="selectpor(this)" src="{pg:$locimgpath}/pigcms_static/image/portrait/2.jpg" />
     </div>
     <div class="por">
      <img onclick="selectpor(this)" src="{pg:$locimgpath}/pigcms_static/image/portrait/3.jpg" />
     </div>
     <div class="por">
      <img onclick="selectpor(this)" src="{pg:$locimgpath}/pigcms_static/image/portrait/4.jpg" />
     </div>
     <div class="por">
      <img onclick="selectpor(this)" src="{pg:$locimgpath}/pigcms_static/image/portrait/5.jpg" />
     </div>
     <div class="por">
      <img onclick="selectpor(this)" src="{pg:$locimgpath}/pigcms_static/image/portrait/6.jpg" />
     </div>
     <div class="por">
      <img onclick="selectpor(this)" src="{pg:$locimgpath}/pigcms_static/image/portrait/7.jpg" />
     </div>
     <div class="por">
      <img onclick="selectpor(this)" src="{pg:$locimgpath}/pigcms_static/image/portrait/8.jpg" />
     </div>
     <div class="por">
      <img onclick="selectpor(this)" src="{pg:$locimgpath}/pigcms_static/image/portrait/9.jpg" />
     </div>
     <div class="por">
      <img onclick="selectpor(this)" src="{pg:$locimgpath}/pigcms_static/image/portrait/10.jpg" />
     </div>
     <div style="clear:both"></div>
    </div></li>
  </ul>
  <li>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
    <tbody>
     <tr>
      <th>真实姓名</th>
      <td><input type="text" class="px" id="field3" name="field3" value="{pg:$UserInfo.truename}" data-empty="0" /></td>
     </tr>
    </tbody>
   </table></li>
  <li>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
    <tbody>
     <tr>
      <th>QQ号码</th>
      <td><input type="text" class="px" id="field4" name="field4" value="{pg:$UserInfo.qq}" onkeyup="value=value.replace(/[^1234567890]+/g,'')" data-empty="0" /></td>
     </tr>
    </tbody>
   </table></li>
  <li>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
    <tbody>
     <tr>
      <th>性别</th>
      <td><select name="field5" id="field5" class="dropdown-select"><option value="0">请选择..</option><option value="1" {pg:if $UserInfo AND $UserInfo.sex==1} selected="selected"{pg:/if}>男</option><option value="2" {pg:if $UserInfo AND $UserInfo.sex==2} selected="selected"{pg:/if}>女</option><option value="0">其他</option></select></td>
     </tr>
    </tbody>
   </table></li>
  <li>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
    <tbody>
     <tr>
      <th>出生年</th>
      <td><input type="tel" class="px" name="field6" id="field6" value="{pg:$UserInfo.bornyear}" onkeyup="onlyNumber(this,4)" data-empty="0" /></td>
     </tr>
    </tbody>
   </table></li>
  <li>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
    <tbody>
     <tr>
      <th>出生月</th>
      <td><input type="tel" class="px" id="field7" name="field7" value="{pg:$UserInfo.bornmonth}" onkeyup="onlyNumber(this,2)" data-empty="0" /></td>
     </tr>
    </tbody>
   </table></li>
  <li>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
    <tbody>
     <tr>
      <th>出生日</th>
      <td><input type="tel" class="px" id="field8" name="field8" value="{pg:$UserInfo.bornday}" onkeyup="onlyNumber(this,2)" data-empty="0" /></td>
      
     </tr>
    </tbody>
   </table></li>
  <li>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
    <tbody>
     <tr>
      <th>地址</th>
      <td><input type="text" class="px" id="field9" name="field9" value="{pg:$UserInfo.address}" data-empty="0" /></td>
     </tr>
    </tbody>
   </table></li>
  <li>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
    <tbody>
     <tr>
      <th>来源渠道</th>
      <td><input type="text" class="px" id="field10" name="field10" value="{pg:$UserInfo.comefrom}" data-empty="0" /></td>
     </tr>
    </tbody>
   </table></li>
   
   {pg:if !empty($cdid)}
	<li>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
			<tr>
				<th>支付密码</th>
				<td><input name="paypass" class="px" id="paypass" value="" type="password" placeholder="请设置您的会员卡支付密码" /></td>
			</tr>
		</table>
	</li>
	{pg:/if}
 <!---<li style="height:100px">
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
    <tbody>
     <tr>
      <th>其他信息</th>
      <td><textarea  id="otherinfo" name="otherinfo"  class="px" style="margin-top: 10px;height: 80px;" placeholder="其他信息写在这里" ></textarea></td>
     </tr>
    </tbody>
   </table>
   </li>---> 

		</div>
	</ul>
	</form>
	<div class="footReturn">
		<a id="showcard"  class="submit" >提交信息</a>
		<div class="window" id="windowcenter" >
			<div id="title" class="wtitle"><span class="close" id="alertclose"></span></div>
			<div class="content">
				<div id="txt"></div>
			</div>
		</div>
	</div>
	<div style="height:60px;" id="msg">&nbsp;</div>
</div>

{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}
<script type="text/javascript">
window.shareData = {  
            "moduleName":"Index",
            "moduleID":"0",
            "imgUrl": "", 
            "sendFriendLink": "{pigcms:$f_siteUrl}{pigcms::U('Index/index',array('token'=>$token))}",
            "tTitle": "",
            "tContent": ""
};
</script>

  <script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/uplodejs/exif.js"></script> 
  <script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/uplodejs/imgUpload.js"></script> 

<script type="text/javascript">
//var configs = {pigcms:$configs};

$(document).ready(function(){

	if ($("#upload_list").length) {
		var imgUpload = new ImgUpload({
			fileInput: "#fileImage",
			container: "#upload_list",
			countNum: null,
			url:"http://" + location.hostname + "/merchants.php?m=Wap&c=vcard&a=ajaxImgUpload&mid={pg:$mid}&cdid=1"
		})
	}

	$('.px').blur(function(){
		var isbt=$(this).attr('data-empty');
		isbt=parseInt(isbt);
		var vzhi=$.trim($(this).val());
		if ((isbt>0) &&  vzhi== '') {
			alert('请输入您的' + $(this).parent().prev('th').html().replace('<font color="red">*</font>', ''));
			//alert("请输入您的微信名称");
			$(this).css('border-color', 'red');
			return false;
			
		}
	}).focus(function(){
	  	$(this).css('background', 'white'); 
		$(this).css('border-color', '#C6FAC2');
	});
	var isposting=false;
	$("#showcard").bind("click",function(){
		if(isposting){
		   return false;
		}
		var field1=$.trim($('#field1').val());
		if(!field1){
		   $('#field1').focus();
		   return false;
		}
		var field2=$.trim($('#field2').val());
		if(!field2){
		   $('#field2').focus();
		   return false;
		}
		if($('#smscode').size()>0){
		  var smscode=$.trim($('#smscode').val());
		  if(!smscode){
		    $('#dialogalert .weui_dialog_bd').html('请填写验证码！');
			$('#dialogalert').show();
			 return false;
		  }
		}
		isposting=true;
		postData=$('form').serialize();
		$.post('/merchants.php?m=Wap&c=vcard&a=saveUserInfo&mid={pg:$mid}&cdid={pg:$cdid}', postData,
				function(ret) {
					isposting=false;
					if (ret.error == 0) {			 
						$('#toast .weui_toast_content').html(ret.msg);
						$('#toast').show();
						setTimeout(function () {
							$('#toast').hide();
							location.href = "/merchants.php?m=Wap&c=vcard&a=mycard&mid={pg:$mid}&cdid={pg:$cdid}&openid={pg:$openid}";
						}, 2000);
					} else if(ret.error) {
					  $('#dialogalert .weui_dialog_bd').html(ret.msg);
					  $('#dialogalert').show();
					}
				}, "json");
			});
	
});
function selectpor(el){
	$("#portrait").val(el.src);
	$('#pors img').removeClass('selected');
	$('#portrait_src').attr('src',el.src);
	el.className='selected';
}

$('.is_check').click(function(){
	if($('#countdown').html() != ''){
		return false;
	}
	var phone 	= $('.phonetel').val();
	//reg=/^0{0,1}(13[0-9]|145|15[0-9]|18[0-9])[0-9]{8}$/i;
	reg=/^\d{6,12}$/i;
	 if(!reg.test(phone) || phone.length >11){   
		$('#dialogalert .weui_dialog_bd').html("手机号错误,请输入11位的手机号！");
		$('#dialogalert').show();
		$('.phonetel').css('border-color','red');
		return false;
	 }
		var num = $.trim($('#countdown').html());
		if(num == ''){
			$.post('/merchants.php?m=Wap&c=vcard&a=sendsms&mid={pg:$mid}&cdid={pg:$cdid}', {phone:phone},function(ret) {
				if(ret.error == 0){
					$('#countdown').html('60');
					$('.is_check>b').html('后重新获取');
					count_down();
				}else{
					  $('#dialogalert .weui_dialog_bd').html(ret.msg);
					  $('#dialogalert').show();
				}
			},"json");
		}
	
});
function count_down(){
	var down = setInterval(function(){
		var num 	= $('#countdown').html();
		if(num > 0){
			$('#countdown').html(num-1);
		}else{
			$('#countdown').html('');
			$('.is_check>b').html('点击获取效验码');
			clearInterval(down);
		}
	},1000);
}

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
<div id="message" style="display:none;">
	<span id="spanmessage"></span>
</div>
</body>
</html>