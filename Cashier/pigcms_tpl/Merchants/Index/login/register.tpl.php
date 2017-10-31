
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
	<meta name="format-detection" content="telephone=no">
    <title>收银台注册</title>
    <link href="<?php echo $this->RlStaticResource;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/sweetalert/sweetalert.css" rel="stylesheet">
	<!-- Sweet Alert -->
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/animate.css" rel="stylesheet">
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/style.css" rel="stylesheet">
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <form class="m-t" id="form" role="form" method="post" action="?m=Index&c=login&a=signed">
                <div class="form-group">
                    <input type="email" class="form-control" name="username" placeholder="登录账号请使用邮箱" required="">
                </div>
				<div class="form-group">
                    <input type="text" class="form-control" name="company" placeholder="商户名称" required="">
                </div>
<!--                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="邮箱地址" required="">
                </div>-->
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="登录密码" required="">
					<input type="hidden" name="agree" value="1">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="phone" placeholder="手机号" required="">
                </div>

                <?php if (isset($sms_config['sms_key']) && $sms_config['sms_key']) {?>
                <div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="输入您获取的短信验证码" name="code">
						<input type="hidden" value="-1" id="codetime">
						<a class="input-group-addon">获取验证码</a>
					</div>
                </div>
                <?php }?>
                <!--<div class="form-group">
                     <div class="checkbox i-checks"><label> <input type="checkbox" name="agree" checked="checked" value="1"><i></i> 同意条款和政策 </label></div>
                </div>-->
                <button type="submit" class="btn btn-primary block full-width m-b">注册</button>

                <!--<p class="text-muted text-center"><small>已经有一个帐户?</small></p>-->
                <a class="btn btn-sm btn-white btn-block" href="?m=Index&c=login&a=index">立即登录</a>
            </form>
			<p class="m-t"> <small>Copyright：<?php echo str_replace('http://','',$_SERVER['HTTP_HOST'])?> &copy; <?php echo date('Y');?></small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo $this->RlStaticResource;?>js/jquery-2.1.1.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
	<!-- Jquery Validate -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/validate/jquery.validate.min.js"></script>
	<!-- Sweet alert -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $("#form").validate({
                 rules: {
                     password: {
                         required: true,
                         minlength: 6
                     },
                     username: {
                         required: true,
                       	 minlength: 4
                     }
                 }
             });
			 $("#form").submit(function(){
				 /*if($(this).find('input[type="checkbox"]').is(':checked') == false){
					 swal("提示！", "请先同意条款 :)", "error");
					 return false;
				 }*/
			 });
        });


        var flag = false;
        $(document).ready(function(){
        	$('.input-group-addon').click(function(){
            	var phone = $.trim($('input[name="phone"]').val());
            	if (phone == '') {
            		swal({
  					  title: "获取短信验证码",
  					  text: '先填写您的手机号',
  					  type: "error"
  					 });
 					 return false;
            	}
        		if (flag) return false;
        		flag = true;
        		$.ajax({
        			url:'?m=Index&c=login&a=getCode',
        			type:"post",
        			data:{'phone':phone, 'type':'register'},
        			dataType:"JSON",
        			success:function(ret){
        				if(!ret.error){
        					$('#codetime').val(60);
        					count_down();
        				} else {
        					flag = false;
        					swal({
        					  title: "获取短信验证码",
        					  text: ret.info,
        					  type: "error"
        					 });
        			   }
        			}
        		});
        	});
        });

        function count_down(){
        	var down = setInterval(function(){
        		var num = $('#codetime').val();
        		if(num > 0){
        			$('#codetime').val(num - 1);
        			$('.input-group-addon').html('(' + parseInt(num - 1) + ')秒后重新获取');
        		}else{
        			flag = false;
        			$('#codetime').val(-1);
        			$('.input-group-addon').html('获取验证码');
        			clearInterval(down);
        		}
        	},1000);
        }
    </script>
</body>

</html>
