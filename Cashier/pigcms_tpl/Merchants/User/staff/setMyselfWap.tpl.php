<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>账户设置</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link href="<?php echo $this->RlStaticResource;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo RL_PIGCMS_STATIC_PATH;?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/animate_new.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/style.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/app.css" rel="stylesheet">
    <!-- Mainly scripts -->
    <script src="<?php echo $this->RlStaticResource;?>js/jquery-2.1.1.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/Cashier/pigcms_static/plugins/layer/layer.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>js/inspinia.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/pace/pace.min.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/jquery.qrcode.min.js"></script>
    <!----开放式头部，请在自己的页面加上--</head>-->
    <style type="text/css">
        body{padding: 0;margin: 0;font-size: 14px;background-color: #efefef;color:#333;}
        a{text-decoration: none;}
        input[type='text'],input[type='password']{width: 100%;height: 46px;border: none;text-indent: 10px;padding: 0;}
    </style>
</head>
<body>
<div style="width: 100%;height: 50px;line-height: 50px;background-color: #008fd3;">
    <a href="/merchants.php?m=User&c=staff&a=index" onclick="" style="color:#fff;padding:0 20px 0 10px;display: inline-block;">< 返回</a>
</div>
<div style="margin: 0;">
    <form class="form-horizontal" id="pwdform" action="/merchants.php?m=User&c=modify&a=doSetPwd" method="POST">
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                修改手机号：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" placeholder="修改手机号，以便以后使用短信验证功能" name="phone" value="<?php echo $user['phone'];?>"/>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                旧密码：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="password" placeholder="旧密码" name="oldpwd" value="<?php echo $user['oldpwd'];?>"/>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                新密码：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="password" placeholder="新密码" name="newpwd" value=""/>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                新密码：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="password" placeholder="再输入一次新密码" name="new2pwd" value=""/>
            </div>
        </div>
        <div style="width: 100%;padding: 20px 0;text-align: center;background-color: #fff;">
            <input type="submit" value="修改" id="pwdform" style="width: 50%;height: 30px;border: none;background-color: #008fd3;color:#fff;"/>
        </div>
    </form>
    <script type="text/javascript">
        //修改商户信息
        $("#pwdform").submit(function(){

            var oldpwd=$.trim($('input[name="oldpwd"]').val());
            var newpwd=$.trim($('input[name="newpwd"]').val());
            var new2pwd=$.trim($('input[name="new2pwd"]').val());

            if(!oldpwd){
                swal("温馨提醒", "您没有输入旧密码", "error");
                $('input[name="oldpwd"]').focus();
                return false;
            }
            if(!newpwd){
                swal("温馨提醒", "您没有输入新密码", "error");
                $('input[name="newpwd"]').focus();
                return false;
            }
            if(!new2pwd){
                swal("温馨提醒", "您没有再次输入新密码！", "error");
                $('input[name="new2pwd"]').focus();
                return false;
            }
            if(newpwd != new2pwd){
                swal("温馨提醒", "两次输入的新密码不一致", "error");
                $('input[name="new2pwd"]').focus();
                return false;
            }
            /*<?php if ($phone && isset($sms_config['sms_key']) && $sms_config['sms_key']) {?>
             var code = $.trim($('input[name="code"]').val());
             if(!code){
             swal("温馨提醒", "短信验证码不能为空", "error");
             $('input[name="code"]').focus();
             return false;
             }
            <?php } else {?>
             var phone = $.trim($('input[name="phone"]').val());
             if(!phone){
             swal("温馨提醒", "手机号不能为空", "error");
             $('input[name="phone"]').focus();
             return false;
             }
            <?php }?>*/
            return true;
        });
        var flag = false;
        $(document).ready(function(){
            $('.input-group-addon').click(function(){
                if (flag) return false;
                flag = true;
                $.ajax({
                    url:'?m=User&c=index&a=getCode',
                    type:"post",
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

    <script src="<?php echo $this -> RlStaticResource; ?>plugins/js/iCheck/icheck.min.js"></script>
</div>
</body>
</html>