<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>门店统计</title>
        <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/header.tpl.php'; ?>
        <link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>wxCoupon/wxCoupon.css" rel="stylesheet">
        <link href="<?php echo $this->RlStaticResource; ?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="<?php echo $this->RlStaticResource; ?>plugins/css/iCheck/custom.css" rel="stylesheet">
        <link href="<?php echo RL_PIGCMS_STATIC_PATH; ?>plugins/css/footable/footable.core.css" rel="stylesheet">
        <link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>merchant/store_mangecss.css" rel="stylesheet">
        <link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>merchant/baseshop.css" rel="stylesheet">
        <link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>merchant/widget_add_img.css" rel="stylesheet">
        <link href="<?php echo $this->RlStaticResource; ?>plugins/css/dropzone/basic.css" rel="stylesheet">
        <link href="<?php echo $this->RlStaticResource; ?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
        <link href="<?php echo $this->RlStaticResource; ?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">

        <style>
            <script src="<?php echo $this->RlStaticResource; ?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
            <script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
            <!-- Data picker -->
            <script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
            <script src="<?php echo $this->RlStaticResource; ?>plugins/js/footable/footable.all2.min.js"></script>
            </head>

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
            .img_upload_preview_box p{margin:0px;}

            .clearfix:after {
                height: 0;
                content: " ";
                display: block;
                overflow: hidden;
                clear: both;
            }
            .clearfix {
                zoom: 1;/*IE低版本浏览器不支持after伪类所以要加这一句*/
            }
            .bankCardInfor{
                background: #FFFFFF;
            }
            .bankCardInfor>h2{
                font-size: 18px; font-weight: normal; padding: 10px 20px; border-top: 3px solid #6DBFFF;
                border-bottom: 1px solid #f3f3f3;
            }
            .bankCardInfor>form{
                width: 90%;
                border: 1px solid #f3f3f3;
                margin: 40px 5%;

            }
            .bankCardInfor>form>div{
                padding: 20px 0;

            }
            .bankCardInfor>form>h2{ width: 100%; height: 30px; font-size: 16px; line-height: 30px; padding-left: 10px; background: #d9dadc; color: #FFFFFF; margin-top: 0px;}
            .bankCardInfor>form>div>label{ display: inline-block; width: 200px;  text-align: right; margin-right: 10px;}
            .bankCardInfor>form>div>label>i{ color: red; margin-right: 10px;}

            .img_upload_wrp .img_upload_box {
                display: inline-block;
                width: 98px;
                height: 27px;
                margin: 0 10px 10px 0;
                vertical-align: top;
            }
            .img_upload_box{float: left;}
            .js_pager{ float: left; }

            .img_upload_box_oper {
                display: block;
                background: #d9dadc;
                border: 1px solid #d9dadc !important;
                width: 100%;
                height: 30px !important;
                text-align: center;
                line-height: 30px;
                color:#777777;
                border-radius: 5px;
            }
            .img_upload_box{ height: 40px !important }
            .js_pager,.img_upload_box {float: none !important;}
            .js_edit_pic_wrp{height: 98px !important;}
            .img_upload_preview_box p{margin:0px;}

            .bankCardInfor>form>p{width: 120px;margin: 20px auto;}
            .bankCardInfor>form>p>button{ background: #0066CC; width: 120px; height: 30px; border: none; border-radius: 5px; color: #FFFFFF; margin: 0 auto;}
             input,select{border-radius: 3px;border: 1px solid #bbbbbb;height:30px;width:200px;text-indent: 5px;}
        </style>
    <body>
        <div id="wrapper">
            <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/setupleftmenu.tpl.php'; ?>
            <div id="page-wrapper" class="gray-bg dashbard-1">
                <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/top.tpl.php'; ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>银行卡管理</h2>
                        <ol class="breadcrumb">
                            <li>
                                <a>User</a>
                            </li>
                            <li>
                                <a>pay</a>
                            </li>
                            <li class="active">
                                <strong>银行卡信息</strong>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row wrapper page-heading iconList" >
                    <div class="bankCardInfor">
                        <h2>上传银行卡信息</h2>
                        <form id="form1">
                            <h2>持卡人证件信息</h2>
                            <div>
                                <label><i>*</i>类型：</label>
                                <select name="isCompay">
                                    <option value="0">个人</option>
                                    <option value="1">公司</option>
                                </select>
                            </div>
                            <div>
                                <label><i>*</i>银行预留手机号：</label>
                                <input type="text" name="phoneNo" value="<?php echo $bank['phoneNo'];?>" placeholder="选填">
                            </div>
                            <div>
                                <label><i>*</i>账户名称：</label>
                                <input type="text" name="customerName" value="<?php echo $bank['customerName'];?>">
                            </div>
                            <div>
                                <label><i>*</i>证件类型：</label>
                                <select name="cerdType">
                                    <option value="01">身份证</option>
                                    <option value="02">军官证</option>
                                    <option value="03">护照</option>
                                    <option value="04">回乡证</option>
                                    <option value="05">台胞证</option>
                                    <option value="06">警官证</option>
                                    <option value="07">士兵证</option>
                                    <option value="99">其它证件</option>
                                </select>
                            </div>
                            <div>
                                <label><i>*</i>证件号码：</label>
                                <input type="text" name="cerdId" value="<?php echo $bank['cerdId'];?>">
                            </div>
                            <div>
                                <label><i>*</i>开户银行：</label>
                                <select name="settBankNo">
                                    <option value="ICBC">工商银行</option>
                                    <option value="ABC">农业银行</option>
                                    <option value="BOC">中国银行</option>
                                    <option value="CCB">建设银行</option>
                                    <option value="CMB">招商银行</option>
                                    <option value="BOCM">交通银行</option>
                                    <option value="CMBC">民生银行</option>
                                    <option value="CNCB">中信银行</option>
                                    <option value="CEBB">光大银行</option>
                                    <option value="CIB">兴业银行</option>
                                    <option value="BOB">北京银行</option>
                                    <option value="GDB">广发银行</option>
                                    <option value="HXB">华夏银行</option>
                                    <option value="PSBC">邮储银行</option>
                                    <option value="SPDB">浦发银行</option>
                                    <option value="PAB">平安银行</option>
                                    <option value="BOS">上海银行</option>
                                    <option value="BOHC">渤海银行</option>
                                    <option value="BOJ">江苏银行</option>
                                </select>
                            </div>
                            <div>
                                <label><i>*</i>银行卡号：</label>
                                <input type="text" name="acctNo" value="<?php echo $bank['acctNo'];?>">
                            </div>
                            <p><button type="button" class="btn">提交</button></p>
                        </form>

                    </div>
                </div>
            </div>


            <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/footer.tpl.php'; ?>
            <script src="<?php echo $this->RlStaticResource; ?>plugins/js/dropzone/dropzone.js"></script>
            <!-- iCheck -->
            <script src="<?php echo $this->RlStaticResource; ?>plugins/js/iCheck/icheck.min.js"></script>
            <script>
                
      $('.btn').click(function () {
          if( $(':input[name="phoneNo"]').val()==''){
              swal('银行预留手机号不能为空!', "", 'error');
              return false;
          }else if( $(':input[name="customerName"]').val()==''){
              swal('账户名称不能为空!', "", 'error');
              return false;
          }else if( $(':input[name="cerdId"]').val()==''){
              swal('证件号码不能为空!', "", 'error');
              return false;
          }else if( $(':input[name="acctNo"]').val()==''){
              swal('银行卡号不能为空!', "", 'error');
              return false;
          }
        $.post('?m=User&c=pay&a=bank',$('form').serialize(), function (e) {
                    if (e.code == 1) {
                        swal({
                            title: "配置成功",
                            text: "",
                            type: "success"
                        }, function () {
                            window.location.reload();
                        });
                    } else {
                        swal('配置失败', "", 'error');
                    }
                }, 'json');
            });
            </script>
    </body>
</html>