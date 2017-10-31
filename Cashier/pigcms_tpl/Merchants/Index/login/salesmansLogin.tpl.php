
<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">

<title>业务员登录</title>

<link href="<?php echo $this->RlStaticResource;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/sweetalert/sweetalert.css" rel="stylesheet">
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/animate.css" rel="stylesheet">
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/style.css" rel="stylesheet">
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/login.css" rel="stylesheet">
</head>

<body class="gray-bg" style="background: url(./Cashier/pigcms_static/image/dlbg.jpg) repeat-x;">
<div class="addBg">
    <div class="addBgArea">
        <img class="balloon" src="./Cashier/pigcms_static/image/balloon.png" alt="balloon" style="top: 127px; left: 5px;">
        <img class="mountain0" src="./Cashier/pigcms_static/image/mountain0.png" alt="mountain0" style="z-index: 33; top: 483px;">
        <img class="mountain1" src="./Cashier/pigcms_static/image/people.png" alt="mountain1" style="top: 255px; left: 148px;">
        <img class="mountain2" src="./Cashier/pigcms_static/image/mountain2.png" alt="mountain2" style="z-index: 33; top: 463px;">
        <img class="tree tree0" src="./Cashier/pigcms_static/image/tree.png" alt="tree" style="z-index: 35; top: 512px;width: 40px; left: 430px;">
        <img class="tree tree1" src="./Cashier/pigcms_static/image/tree.png" alt="tree" style="z-index: 35; top: 525px; width: 30px; left: 193px;">
        <img class="tree tree2" src="./Cashier/pigcms_static/image/tree.png" alt="tree" style="z-index: 35; top: 482px; ">
        <img class="footprint0" src="./Cashier/pigcms_static/image/footprint.png" alt="footprint" style="top: 570px;">
        <img class="footprint1" src="./Cashier/pigcms_static/image/footprint.png" alt="footprint" style="top: 590px;">
        <img class="footprint2" src="./Cashier/pigcms_static/image/footprint.png" alt="footprint" style="top: 618px;">
        <img class="footprint3" src="./Cashier/pigcms_static/image/footprint.png" alt="footprint" style="top: 645px;">
    </div>
    <div class="middle-box text-center loginscreen animated fadeInDown" style="margin-top: 180px;">
<div>
<form class="m-t" role="form" id="form" method="post" action="?m=Index&c=login&a=signin">
<div class="form-group">
<input type="test" name="username" class="form-control" placeholder="账号" required="">
</div>
<div class="form-group">
<input type="password" name="password" class="form-control" placeholder="密码" required="">
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
				<div class="form-group">
                    <div class="radio radio-info radio-inline">
						<input type="hidden" value="employee" name="type"  id="inlineRadio1">
						
					</div>
				
                </div>
				
                <input type="hidden" name="flag" value='1'>
                <button type="submit" class="btn btn-primary block full-width m-b">登录</button>
				
                <!--<a href="#"><small>忘记密码?</small></a>
                <p class="text-muted text-center"><small>没有账号?</small></p>-->
               <!--  <a class="btn btn-sm btn-white btn-block" href="?m=Index&c=login&a=register">创建一个账号</a> -->
            </form>
			  <p class="m-t"> <small>重庆云极付科技有限公司版权所有渝ICP备13007293号渝ICP备13015917号 @2011-2016</small> </p>
        </div>
    </div>
</div>
    <!-- Mainly scripts -->
    <script src="<?php echo $this->RlStaticResource;?>js/jquery-2.1.1.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/sweetalert/sweetalert.min.js"></script>
	<!-- Jquery Validate -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/validate/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#form").validate({
                 rules: {
                     password: {
                         required: true,
                         minlength: 2
                     },
                     username: {
                         required: true,
                       	 minlength: 2
                     }
                 }
             });
		$(".addBg,.addBgArea").height($(window).height());
            $(window).resize(function(){
                $(".addBg,.addBgArea").height($(window).height());
          })
        });

        var flag = false;
        $(document).ready(function(){
        	$('.input-group-addon').click(function(){
            	var username = $.trim($('input[name="username"]').val());
            	var atype = $('input[name="type"]:checked').val();
            	if (username == '') {
            		swal({
  					  title: "获取短信验证码",
  					  text: '先填写您的账号',
  					  type: "error"
  					 });
 					 return false;
            	}
        		if (flag) return false;
        		flag = true;
        		$.ajax({
        			url:'?m=Index&c=login&a=getCode',
        			type:"post",
        			data:{'username':username, 'type':'login', 'atype':atype},
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
