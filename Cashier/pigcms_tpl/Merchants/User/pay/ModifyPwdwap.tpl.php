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
        input[type='text']{width: 100%;height: 48px;border: none;text-indent: 10px;padding: 0;}
    </style>
</head>
<body>
<div style="width: 100%;height: 50px;line-height: 50px;background-color: #008fd3;">
    <a href="/merchants.php?m=User&c=index&a=sindex" onclick="" style="color:#fff;padding:0 20px 0 10px;display: inline-block;">< 返回</a>
</div>
<div style="margin: 0;">
    <form method="post">
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                商户ID：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" placeholder="参数有误"  readonly="readonly" value="<?php echo $merchants['mid'];?>"/>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                登录账号：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" placeholder="参数有误" readonly="readonly" value="<?php echo $merchants['username'];?>"/>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                商户名：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" placeholder="请输入商户名称" name="company" value="<?php echo $merchants['company'];?>"/>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                联系人：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" placeholder="请输入联系人" name="realname" value="<?php echo $merchants['realname'];?>"/>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                联系电话：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" placeholder="请输入联系电话" name="phone" value="<?php echo $merchants['phone'];?>"/>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                地址：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" placeholder="请输入地址" name="address" value="<?php echo $merchants['address'];?>"/>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                新密码：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" name="password" placeholder="留空为不修改"/>
            </div>
        </div>
        <div style="width: 100%;padding: 20px 0;text-align: center;background-color: #fff;">
            <input type="button" value="修改" class="bc" style="width: 50%;height: 30px;border: none;background-color: #008fd3;color:#fff;"/>
        </div>
    </form>
    <div style="line-height: 60px;text-align: center;">
        <a href="" style="color:#888;display: block;">
            取消微信绑定
        </a>
    </div>
    <script type="text/javascript">
        //修改商户信息
        $('.bc').click(function(){
            if($(":input[name='company']").val()==""){
                swal("商户名不能为空",'','error');
                return false;
            }else if($(":input[name='realname']").val()==""){
                swal("联系人不能为空",'','error');
                return false;
            }else if($(":input[name='phone']").val()==""){
                swal("电话不能为空",'','error');
                return false;
            }else if($(":input[name='address']").val()==""){
                swal("地址不能为空",'','error');
                return false;
            }
            var company = $(":input[name='company']").val();
            var realname = $(":input[name='realname']").val();
            var phone = $(":input[name='phone']").val();
            var address = $(":input[name='address']").val();
            var password = $(":input[name='password']").val();

            $.post('?m=User&c=pay&a=ModifyPwd',{company:company,realname:realname,phone:phone,address:address,password:password},function(e){
                if(e.code==1){
                    swal({
                        title:'修改成功!',
                        text:'',
                        type:'success',
                        closeOnConfirm:false
                    },function(){
                        location.reload();
                    });

                }else{
                    swal("修改失败!",'','error');
                }
            },'json');
        });
    </script>
    <script src="<?php echo $this -> RlStaticResource; ?>plugins/js/iCheck/icheck.min.js"></script>
</div>
</body>
</html>