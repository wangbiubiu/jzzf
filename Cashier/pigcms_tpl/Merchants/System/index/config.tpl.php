<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>短信配置</title>
    {pg:include file="$tplHome/System/public/header.tpl.php"}
	
</head>

<body>
    <div id="wrapper">
	{pg:include file="$tplHome/System/public/leftmenu.tpl.php"}
        <div id="page-wrapper" class="gray-bg">
       {pg:include file="$tplHome/System/public/top.tpl.php"}
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>收银台管理后台</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>System</a>
                        </li>
                        <li>
                            <a>index</a>
                        </li>
                        <li class="active">
                            <strong>短信配置</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
			   <div class="row">
				<div class="col-lg-6">
				<div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>短信配置</h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" id="pwdform" action="/merchants.php?m=System&c=index&a=saveconfig" method="POST">
                                <p>填写购买后获得的相关信息</p>
                                <div class="form-group"><label class="col-lg-2 control-label">短信秘钥</label>
                                    <div class="col-sm-9 input-group"><input type="text" class="form-control" name="sms_key" value="{pg:$sms.sms_key}"></div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">您的签名</label>
                                    <div class="col-sm-9 input-group"><input type="text" class="form-control" name="sms_sign" value="{pg:$sms.sms_sign}"></div>
                                </div>
								<div class="form-group"><label class="col-lg-2 control-label">绑定的顶级域名</label>
                                    <div class="col-sm-9 input-group"><input type="text" class="form-control" name="sms_topdomain" value="{pg:$sms.sms_topdomain}"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <button type="submit" class="btn btn-sm btn-primary"> 确定 </button>
                                    </div>
                                </div>
                            </form>
                        </div>
						</div>
                    </div>
					</div>
            </div>
            </div>
        </div>
   {pg:include file="$tplHome/System/public/footer.tpl.php"}
</body>

 <script>
    	 $("#pwdform").submit(function(){
			var sms_key=$.trim($('input[name="sms_key"]').val());
			var sms_sign=$.trim($('input[name="sms_sign"]').val());
			var sms_topdomain=$.trim($('input[name="sms_topdomain"]').val());
			if(!sms_key){
			     swal("温馨提醒", "您没有输入短信秘钥", "error");
				 $('input[name="sms_key"]').focus();
				 return false;
			}
			if(!sms_sign){
			     swal("温馨提醒", "您没有输入您的签名", "error");
				 $('input[name="sms_sign"]').focus();
				 return false;
			}
			if(!sms_topdomain){
			     swal("温馨提醒", "您没有输入绑定的顶级域名！", "error");
				 $('input[name="sms_topdomain"]').focus();
				 return false;
			}
		   return true;
		 });
</script>
</html>