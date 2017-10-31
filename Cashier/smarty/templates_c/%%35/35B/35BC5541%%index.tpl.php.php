<?php /* Smarty version 2.6.18, created on 2017-10-27 10:21:39
         compiled from C:%5CUsers%5CAdministrator%5CDesktop%5Clll%5CCashier%5C./pigcms_tpl/Merchants/System/qrcode/index.tpl.php */ ?>
<!DOCTYPE html>
<html>
    <head>
        <title>二维码</title>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
wxCoupon/wxCoupon.css" rel="stylesheet">
        <link href="<?php echo @RlStaticResource; ?>
plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="<?php echo @RlStaticResource; ?>
plugins/css/iCheck/custom.css" rel="stylesheet">
        <link href="<?php echo @RL_PIGCMS_STATIC_PATH; ?>
plugins/css/footable/footable.core.css" rel="stylesheet">
        <style>
            .ibox-title h5 {
                margin: 10px 0 0px;
            }

            select.input-sm {
                height: 35px;
                line-height: 35px;
            }

            .float-e-margins .btn-info {
                margin-bottom: 0px;
            }

            .fa-paste {
                margin-right: 7px;
                padding: 0px;
            }

            .dz-preview {
                display: none;
            }

            .ibox-title ul {
                list-style: outside none none !important;
                margin: 0 0 0 10px;
                padding: 0;
            }

            .ibox-title li {
                float: left;
                width: 15%;
            }

            #commonpage {
                float: right;
                margin-bottom: 10px;
            }

            #table-list-body .btn-st {
                background-color: #337ab7;
                border-color: #2e6da4;
                cursor: auto;
            }

            #select_Cardtype .i-checks label {
                cursor: pointer;
            }

            #ewmPopDiv .modal-body {
                text-align: center;
            }

            .modal-footer {
                text-align: center;
            }

            .modal-footer .btn {
                padding: 7px 30px;
            }

            .js_modify_quantity .fa {
                margin-left: 10px;
            }

            #ewmPopDiv .downewm {
                font-size: 14px;
                padding: 15px;
                text-align: center;
            }

            .modal-body {
                padding: 20px 30px 15px;
            }

            #select_Cardtype p {
                margin-bottom: 8px;
            }

            .code{ padding: 30px; background: #FFFFFF; border-bottom: 1px solid #d9e6e9; border-top:3px solid #edfbfe;}
            .code>p{height: 30px; line-height: 30px; margin-bottom: 0px;}
            .code>p:first-child{ padding-top: 5px; margin-right: 30px;}
            .code>p:first-child label{ width: 60px;}
            .ewmgs{ width: 150px; height: 30px; margin-left: 10px; border-radius: 2px; margin-right: 20px; border: 1px solid #f4f5f5;}
            .scerm{ width: 95px; height: 35px; line-height: 35px; border: none; border-radius: 5px; text-align: center; color: #FFFFFF; background: #36a9e0; margin-left: 20px;}
            .code_nr{ background: #FFFFFF; padding: 20px 10px;}
            .code_nr input[type="text"]{ width: 150px; border: 1px solid #EEEEEE; border-radius: 2px; text-align: center; margin-left: 20px; margin-right: 20px;
                                         display: inline-block; height: 25px; line-height: 25px;
            }
            .code_nr input[type="submit"]{ padding: 0 10px; height: 25px; line-height: 25px; border-radius: 2px; color: #FFFFFF; background: #36a9e0; border: none;}
           
            .code_nr button{adding: 0 10px; height: 25px; line-height: 25px; border-radius: 2px; color: #FFFFFF; background: #36a9e0; margin-left: 10px; border: none;}
            .code_nr table{ margin-top: 40px;}
            .code_nr table>tbody>tr{ text-align: center;}
            .code_nr table>tbody>tr>th{background: #f2f2f2; height: 30px; line-height: 30px; text-align: center;}
            .code_nr table>tbody>tr>th>label>input{ margin-right: 5px; padding-top: 10px;}
            .code_nr table>tbody>tr>td{height: 40px; line-height: 40px;}
            .code_nr table>tbody>tr>td>img{ width: 30px; height: 30px;}
            .unbundl{ height: 30px; background: #2969B0; border: none; border-radius: 2px; color: #FFFFFF; margin-right: 10px; margin-top: 3px; padding: 0 10px;}
            .dow{     padding: 0 10px;
            height: 25px;
            line-height: 25px;
            border-radius: 2px;
            color: #FFFFFF;
            background: #36a9e0;
            margin-left: 10px;
            border: none;
            display: inline-block;
            }
            .dow:hover{color: #ffffff}
            .bundl{ height: 30px; background: #f2f2f2; border: none; border-radius: 2px; color: #202020;}
            .skewm{z-index: 999; display: none; width: 500px; height: 700px; padding: 50px; background: #FFFFFF; border: 1px solid #f2f2f2; position: fixed; top: 50%; margin-top: -350px; left: 50%; margin-left: -250px;}
            .tzewm{z-index: 999; display: none; width: 500px; height:300px; padding: 50px; background: #FFFFFF; border: 1px solid #f2f2f2; position: fixed; top: 50%; margin-top: -150px; left: 50%; margin-left: -250px;}
            .skewm>img{ width: 400px; height: 600px; display: inline-block;}
             .tzewm>img{ width: 400px; height: 200px; display: inline-block;}
            .receivables,.notice{ cursor: pointer;}
            .pl_dowlen{ float: left;}
        </style>
        <script src="<?php echo @RlStaticResource; ?>
plugins/js/footable/footable.all2.min.js"></script>
    </head>

    <body>
        <div id="wrapper">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/leftmenu.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div id="page-wrapper" class="gray-bg">
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/top.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>下载二维码</h2>
                        <ol class="breadcrumb">
                            <li><a>System</a></li>
                            <li><a>index</a></li>
                            <li class="active"><strong>下载二维码</strong></li>
                        </ol>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
         

                        <div class="code clearfix">
                            <p style="float: left;">
                                <label>支付通道</label>
                                <label>微信<input type="checkbox" name="payment" value="weixin"></label>
                                <label>支付宝<input type="checkbox" name="payment" value="ali"></label>
                                <label>QQ<input type="checkbox" name="payment" value="qq"></label>
                                <label>百付宝<input type="checkbox" name="payment" value="baifu"></label>
                                <label>易付宝<input type="checkbox" name="payment" value="yifu"></label>
                            </p>
                            <p style="float: left;"><label>生成二维码个数</label><input class="ewmgs" id="num" type="text" name="number" placeholder="1~1000" onkeyup="this.value = this.value.replace(/\D/g, '')"><input type="submit" value="生成二维码" class="scerm"></p>
                        </div>
                        <div class="code_nr">
                           
                                <div>
                                     <form action="/merchants.php?m=System&c=qrcode&a=index" method="get" id="form1" style="float:left">
                                        <input type="hidden" value="System" name="m" >
                                        <input type="hidden" value="qrcode" name="c" >
                                        <input type="hidden" value="index" name="a" >
                                        <label>二维码ID</label>
                                        <input type="text" name="ewmid" placeholder="输入二维码ID" />
                                        <label>序号</label>
                                        <input type="text" name="start" placeholder="开始序号" onkeyup="this.value = this.value.replace(/\D/g, '')"/>
                                        <span>到</span>
                                        <input type="text" name="end" placeholder="结束序号" onkeyup="this.value = this.value.replace(/\D/g, '')"/>
                                        <input class="sous" type="submit"  value="搜 索"/>
                                       </form>
                                    <form action="/merchants.php?m=System&c=qrcode&a=qrcodeDow" method="post" id="form2" style="float:left; margin-left: 10px;cursor: pointer; padding: 0 10px; height: 25px; line-height: 25px; border-radius: 2px; color: #FFFFFF; background: #36a9e0;border: none;">
                                        <input type="hidden" name="sk" value="" id="sk">
                                        <input type="hidden" name="tz" value="" id="tz">
                                        <span class="pl_dowlen" id="pl_dowlen">批量下载</span>
                                    </form>
                                </div>
                         
                            <table border="1" bordercolor="#e1e4e9" width="98%">
                                <tbody>
                                    <tr>
                                        <th><label><input type="checkbox" name="code_all" class="qx">全选</label></th>
                                        <th>序号</th>
                                        <th>二维码ID</th>
                                        <th>收款二维码</th>
                                        <th>通知二维码</th>
                                        <th>绑定商户</th>
                                        <th>操作</th>
                                    </tr>
                                    <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                    <tr>
                                        <td><input type="checkbox" name="code" id="code">
                                            <input class="sk" type="hidden" value="<?php echo $this->_tpl_vars['row']['sk_name']; ?>
">
                                            <input class="tz" type="hidden" value="<?php echo $this->_tpl_vars['row']['tz_name']; ?>
">
                                        </td>
                                        <td><?php echo $this->_tpl_vars['row']['id']; ?>
</td>
                                        <td><?php echo $this->_tpl_vars['row']['qrcode_id']; ?>
</td>
                                        <td><img class="receivables" src="<?php echo $this->_tpl_vars['row']['payment_qrcode']; ?>
" ></td>
                                        <td><img class="notice" src="<?php echo $this->_tpl_vars['row']['notice_qrcode']; ?>
" style=" width: 70px"></td>
                                        <td><?php echo $this->_tpl_vars['row']['username']['company']; ?>
</td>
                                        <td>
                                            <?php if ($this->_tpl_vars['row']['status'] == 1): ?>
                                            <button class="unbundl" data-id='<?php echo $this->_tpl_vars['row']['id']; ?>
'>解绑</button>
                                            <?php endif; ?>
                                            <!--<a class="dow" href="<?php echo $this->_tpl_vars['row']['payment_qrcode']; ?>
" download="<?php echo $this->_tpl_vars['row']['sk_name']; ?>
">下载1</a>
                                            <a class="dow" href="<?php echo $this->_tpl_vars['row']['notice_qrcode']; ?>
" download="<?php echo $this->_tpl_vars['row']['tz_name']; ?>
">下载2</a>-->
                                            <a href="/merchants.php?m=System&c=qrcode&a=onedown&sk=<?php echo $this->_tpl_vars['row']['sk_name']; ?>
&tz=<?php echo $this->_tpl_vars['row']['tz_name']; ?>
" class="dow">下载</a>
                                        </td>
                                    </tr>


                                    <?php endforeach; endif; unset($_from); ?>

                                </tbody>
                            </table>

                        </div>
                        <?php echo $this->_tpl_vars['pagebar']; ?>

                        <div class="skewm">
                            <img src="">
                        </div>
                        <div class="tzewm">
                            <img src="">
                        </div>
                       
                    </div>
                </div>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
        </div>

 <script>
    $(".receivables").click(function () {
          var src = $(this).attr("src");
         $(".skewm>img").attr("src",src);
    });
      $(".notice").click(function () {
          var src = $(this).attr("src");
         $(".tzewm>img").attr("src",src);
    });
   
    $('.unbundl').click(function(){
       var id = $(this).attr('data-id');
        swal({
            title: "您确定要解绑吗？",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if(isConfirm){
       $.post('/merchants.php?m=System&c=qrcode&a=Unbundling',{id:id},function(re){
           
           if(re.code=='1'){
               swal({
                    title: "解绑成功!",
                    text: '',
                    type: "success",
                    closeOnConfirm: false
                }, function () {
                    location.reload();
                });
               
            } else {
                swal("解绑失败!", '', 'error');
             
           }
       },'json');
   }
        });
    });
  $('#pl_dowlen').click(function(){

           var sk = [];
           var tz = [];
            $('input:checkbox:checked').each(function() {
               sk.push($(this).siblings(".sk").val());
               tz.push($(this).siblings(".tz").val());
            });
         $('#sk').val(sk);
         $('#tz').val(tz);
         if ($(":checkbox[name=code]:checked").size() == 0) {
            swal("请至少选择一个!", '', 'error');
            return false;
         }
         $('#form2').submit();
       
  });
  
</script>

        <script src="<?php echo @RlStaticResource; ?>
plugins/js/iCheck/icheck.min.js"></script>
        <script>
                            $(".qx").click(function () {
                                if ($(this).is(':checked')) {
                                    $('input[name="code"]').prop("checked", true);

                                } else {
                                    $('input[name="code"]').removeAttr("checked", true);

                                }
                            });
                            $('input[name="code"]').click(function () {
                                $(this).each(function () {
                                    $('input[name="code_all"]').removeAttr("checked", true);
                                });
                            });
                             
                             
                             
                            $(".scerm").click(function () {
                                // var val=$('input:radio[name="payment"]:checked').val();
                                var num = $('#num').val();

                                if (num == "" || num == "0") {
                                    swal("请填写生成个数!", '', 'error');
                                    return false;
                                } else {
                                    // alert(val);
                                    swal({
                                        title: "您确定要生成吗？",
                                        text: "",
                                        type: "warning",
                                        showCancelButton: true,
                                        confirmButtonText: "确定",
                                        cancelButtonText: "取消",
                                        closeOnConfirm: false,
                                        closeOnCancel: true
                                    }, function (isConfirm) {
                                        if(isConfirm){
                                            swal("二维码生成中....请等待!", '', 'success');
                                            setTimeout(function(){
                                                $.post('/merchants.php?m=System&c=qrcode&a=index', {num: num}, function (data) {
                                                if (data.errcode == 1) {
                                                    swal({
                                                        title: "生成二维码完成!",
                                                        text: '',
                                                        type: "success",
                                                        closeOnConfirm: false
                                                    }, function () {
                                                        location.reload();
                                                    });
                                                   // swal("生成二维码完成!", '', 'success');
                                                } else {
                                                    swal("生成二维码失败!", data.msg, 'error');
                                                }
                                            }, 'json'); 
                                            },3000);
                                           
                                        }
                                });
                                }
                            });
//                            $(".pl_dowlen").click(function () {
//                                if ($(":checkbox[name=code]:checked").size() == 0) {
//                                    alert("请至少选择一条");
//                                    return false;
//                                }
//                            });


                            $("body").click(function () {
                                $(".skewm").hide();
                                $(".tzewm").hide();
                            });
                            $(".receivables").click(function (e) {
                                e = e || window.event;
                                if (e.stopPropagation) {
                                    e.stopPropagation();
                                } else {
                                    e.cancelBubble = true;
                                }
                                $(".skewm").show();
                            });
                            $(".notice").click(function (e) {
                                e = e || window.event;
                                if (e.stopPropagation) {
                                    e.stopPropagation();
                                } else {
                                    e.cancelBubble = true;
                                }
                                $(".tzewm").show();
                            });

        </script>
</html>