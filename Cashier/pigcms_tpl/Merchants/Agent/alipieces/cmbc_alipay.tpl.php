<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/29
 * Time: 14:45
 */

?>


<!DOCTYPE html>
<html>
<head>
    <title>代理商|进件管理</title>
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
        .ibox-title h5 {
            margin: 10px 0 0px;
        }

        button > a {
            display: block;
            width: 100%;
            height: 100%;
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

        .img_upload_preview_box p {
            margin: 0px;
        }

        p {
            margin-bottom: 0px;
        }

        .role_permission {
            background: #FFFFFF;
        }

        .role_permission > h1 {
            font-size: 18px;
            border-bottom: 1px solid #f2f2f2;
            height: 40px;
            line-height: 40px;
            border-top: 3px solid #B5D6FD;
            margin: 0px;
            padding-left: 20px;
        }

        .role_permission > div {
            border: 1px solid #f2f2f2;
            margin: 20px auto;
            width: 98%;
        }

        .role_permission > div > h2 {
            height: 40px;
            line-height: 40px;
            padding: 0 10px;
            background: #f2f2f2;
            margin: 0px;
            font-size: 16px;
            font-weight: normal;
        }

        .role_permission > div > div {
            min-height: 40px;
            margin: 10px 0;
        }

        .role_permission > div > div > label {
            width: 120px;
            text-align: right;
            margin-right: 20px;
            float: left;
        }

        .role_permission > div > div > label > span {
            color: red;
        }

        .role_permission > div > div > div {
            float: left;
        }

        .role_permission > div > div > div > input {
            width: 310px;
            height: 30px;
        }

        .tj {
            width: 300px;
            margin: 0 auto;
        }

        .tj > input {
            width: 100px;
            text-align: center;
            height: 30px;
            line-height: 30px;
            border: none;
            border-radius: 2px;
            background: #2f9833;
            margin-right: 20px;
            color: #FFFFFF;
        }

        .tj > button {
            width: 100px;
            text-align: center;
            height: 32px;
            line-height: 32px;
            border-radius: 2px;
            background: #FFFFFF;
            margin-right: 20px;
            border: 1px solid #f2f2f2;
        }

        .tj > button > a {
            color: #202020;
        }

        .ts {
            display: none;
            color: red;
        }

        #Sup_material > div > div > label, #Realestate > div > div > label {
            float: left;
            margin: 10px;
            width: 100px;
            overflow: hidden;
        }

        #Sup_material > div > div > label > p, #Realestate > div > div > label > p {
            color: #2C82C9;
            cursor: pointer;
        }

        .industry_type > select {
            width: 150px;
            height: 30px;
        }

        #Realestate > div, #publicWelfare > div {
            width: 100%;
        }

        #Realestate > div > label, #publicWelfare > div > label {
            display: inline-block;
            width: 150px;
        }

        #Realestate > div > label > span, #publicWelfare > div > label > span {
            color: red;
        }

        .img_upload_box {
            float: left;
        }

        .js_pager {
            float: left;
        }

        .img_upload_box_oper {
            display: block;
            background: #d9dadc;
            border: 1px solid #d9dadc !important;
            width: 100%;
            height: 30px !important;
            text-align: center;
            line-height: 30px;
            color: #777777;
            border-radius: 5px
        }

        .img_upload_box {
            height: 40px !important
        }

        .js_pager, .img_upload_box {
            float: none !important;
        }

        .js_edit_pic_wrp {
            height: 98px !important;
        }
    </style>
    <script src="<?php echo $this->RlStaticResource; ?>plugins/js/footable/footable.all2.min.js"></script>
</head>

<body>
<div id="wrapper">
    <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/leftmenu.tpl.php'; ?>
    <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/top.tpl.php'; ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>商家信息管理</h2>
                <ol class="breadcrumb">
                    <li><a>Agent</a></li>
                    <li><a>商户中心</a></li>
                    <li><a>进件管理</a></li>
                    <li class="active"><strong>填写基本信息</strong></li>
                </ol>
            </div>
            <div class="col-lg-2"></div>
        </div>
        <style type="text/css">
            .role_permission{background: #FFFFFF;margin-top: 15px;}
            .role_permission>h1{ font-size: 18px; border-bottom:1px solid #f2f2f2 ; height: 40px; line-height: 40px; border-top: 3px solid #B5D6FD; margin: 0px; padding-left: 20px;}
            .role_permission table td{padding: 5px 10px;}
            .role_permission table tr td:nth-child(1),.role_permission table tr td:nth-child(3){text-align: right;}
            .role_permission table td input[type="text"]{width:200px;height:20px;padding: 2px;border: 1px solid #b8d0d6 ;}
            .role_permission table td select{max-width: 200px;border: 1px solid #b8d0d6 ;}
            .role_permission table td span{margin-left: 5px;color:#f00;}
            .select_permissions p{padding:10px;}
        </style>
        <div class="role_permission">
            <h1>商户支付宝进件 <a href="#" id="show" style="float: right;color: #44b549; margin-right: 20px; font-size: 16px;"><?php if($vo['status']==3 || $vo['status']==4){echo '编辑';} ?></a></h1>
            <div class="select_permissions" <?php if($alipay['bankSpName']==null){echo 'style=display:none';}else{ echo 'style=display:';}; ?>>
                <h2>支付宝子商户</h2>
                <p><label>商户名称（M1）：</label><span><?php echo $alipay['bankSpName']; ?></span></p>
                <p><label>商户备注：</label><span style="color: red;"><?php echo $vo['comments'];?></span></p>
                <p><label>商户简称（M1）：</label><span><?php echo $alipay['aliasName']; ?></span></p>
                <p><label>客服电话（M1）：</label><span><?php echo $alipay['servicePhone'];?></span></p>
                <p><label>经营类目（M1）：</label><span><?php foreach ($category as $key => $c): ?>
                            <?php
                            if($c['code'] == $alipay['categoryId']){?>
                                <?php echo $c['name'] ?>
                            <?php } ?>
                        <?php endforeach ?></span></p>
                <p><label>是否使用民生PID（M1）：</label><span><?php if($alipay['acceptFlag']=="Y"){echo "是";}else{echo "否";};?></span></p>
                <p><label>联系人名称（M1）：</label><span><?php echo $alipay['contactName'];?></span></p>
                <p><label>联系人电话（M1）：</label><span><?php echo $alipay['contactPhone'];?></span></p>
                <p><label>联系人手机（M1）：</label><span><?php echo $alipay['contactMobile'];?></span></p>
                <p><label>联系人邮箱（M1）：</label><span><?php echo $alipay['contactEmail'];?></span></p>
                <p><label>身份证号（M1）：</label><span><?php echo $alipay['contactIdCardNo'];?></span></p>
                <p><label>联系人类型（M1）：</label><span><?php if($alipay['contactType']=="AGENT") echo "代理人"; if($alipay['contactType']=="LEGAL_PERSON") echo "法人"; if($alipay['contactType']=="OTHER") echo "其他"; if($alipay['contactType']=="CONTROLLER") echo "实际控制人" ;?></span></p>
                <p><label>省份（M2）：</label><span><?php foreach ($area as $key => $a): ?>
                            <?php if($a['areaCode'] == $alipay['provinceCode']){ ?>
                               <?php echo $a['areaName']; ?>
                            <?php }?>
                                <?php endforeach ?></span></p>
                <p><label>城市（M2）：</label><span><?php foreach ($areaCity as $key => $c): ?>
                            <?php if($c['areaCode'] == $alipay['cityCode']){ ?>
                                <?php echo $c['areaName']; ?>
                            <?php }?>
                                <?php endforeach ?></span></p>
                <p><label>区县（M2）：</label><span><?php foreach ($districtCode as $key => $d): ?>
                            <?php if($d['areaCode'] == $alipay['districtCode']){ ?>
                                <?php echo $d['areaName']; ?>
                            <?php }?>
                                <?php endforeach ?></span></p>
                <p><label>地址类型（M2）：</label><span><?php if($alipay['addressType']=="BUSINESS_ADDRESS") echo "经营地址"; if($alipay['addressType']=="REGISTERED_ADDRESS") echo "注册地址"; ?></span></p>
                <p><label>经营地址（M2）：</label><span><?php echo $alipay['address'];?></span></p>
                <p><label>营业执照编号（M3）：</label><span><?php echo $alipay['businessLicense'];?></span></p>
                <p><label>营业执照类型（M3）：</label><span><?php if($alipay['businessLicenseType']=="INST_RGST_CTF") echo "事业单位法人证书"; if($alipay['businessLicenseType']=="NATIONAL_LEGAL") echo "营业执照"; if($alipay['businessLicenseType']=="NATIONAL_LEGAL_MERGE") echo "营业执照（多证合一）"; ;?></span></p>
                <p><label>银行卡号（M3）：</label><span><?php echo $alipay['logonId'];?></span></p>
                <p><label>银行卡持卡人姓名（M3）：</label><span><?php echo $alipay['cardName'];?></span></p>
                <p><label>支付宝账号：</label><span><?php echo $alipay['logonId'];?></span></p>
                <p><label>支付二维码信息：</label><span><?php echo $alipay['payCodeInfo'];?></span></p>
            </div>
            <form id="formid" name='regist' action="?m=Agent&c=merchant&a=cmbc_alipay&mid=<?php echo $merchant['mid'] ?>" method="post" enctype="multipart/form-data" class="wrapper wrapper-content animated fadeInRight" <?php if($alipay['bankSpName']!=null){echo 'style=display:none';}else{ echo 'style=display:';}; ?>>
                <table width="880px" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="180px">商户名称（M1）：</td>
                        <td width="260px"><input name="bankSpName" value="<?php echo $alipay['bankSpName']; ?>" size="30" class="required textInput valid" type="text" placeholder=""><span>*</span></td>
                        <td width="180px">商户简称（M1）：</td>
                        <td><input name="aliasName" size="30" value="<?php echo $alipay['aliasName']; ?>" class="required textInput valid" type="text" placeholder=""><span>*</span></td>
                    </tr>
                    <tr>
                        <td>客服电话（M1）：</td>
                        <td><input name="servicePhone" value="<?php echo $alipay['servicePhone']; ?>" size="30" class="required textInput valid" type="text"><span>*</span></td>
                        <td>经营类目（M1）：</td>
                        <td>
                            <select class="" name="categoryId">
                                <option value="">--请选择--</option>
                                <?php foreach ($category as $key => $c): ?>
                                    <?php
                                    if($c['code'] == $alipay['categoryId']){?>
                                        <option value="<?php echo $c['code'] ?>" selected="selected"><?php echo $c['name'] ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $c['code'] ?>"><?php echo $c['name'] ?></option>
                                    <?php } ?>
                                <?php endforeach ?>
                            </select><span>*</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>是否使用民生PID（M1）：</td>
                        <td>
                            <select class="" name="acceptFlag" onchange="showBusinessAppid(this.value)">
                                <option value="Y" <?php if($alipay['acceptFlag']=="Y"){echo 'selected="selected"';}?>>是</option>
                                <option value="N" <?php if($alipay['acceptFlag']=="N"){echo 'selected="selected"';}?>>否</option>
                            </select><span>*</span>
                        </td>
                        <td class="showBusinessAppid" style="<?php if($alipay['acceptFlag']=="Y"||empty($alipay['acceptFlag'])){echo 'display:none;';}?>">来源机构标识PID（M1）：</td>
                        <td class="showBusinessAppid" style="<?php if($alipay['acceptFlag']=="Y"||empty($alipay['acceptFlag'])){echo 'display:none;';}?>"><input name="bankAcceptAppid" value="<?php echo $alipay['bankAcceptAppid']; ?>" size="30" class="textInput valid" type="text" placeholder="当不选择民生PID时必填"></td>
                    </tr>
                    <tr>
                        <td>联系人名称（M1）：</td>
                        <td><input name="contactName" value="<?php echo $alipay['contactName']; ?>" size="30" class="required textInput valid" type="text"><span>*</span></td>
                        <td>联系人电话（M1）：</td>
                        <td><input name="contactPhone" value="<?php echo $alipay['contactPhone']; ?>" size="30" class="phoneNumber required textInput valid" type="text"><span>*</span></td>
                    </tr>
                    <tr>
                        <td>联系人手机（M1）：</td>
                        <td><input name="contactMobile" value="<?php echo $alipay['contactMobile']; ?>" size="30" class="phoneNumber required textInput valid" type="text"><span>*</span></td>
                        <td>联系人邮箱（M1）：</td>
                        <td><input name="contactEmail" value="<?php echo $alipay['contactEmail']; ?>" size="30" class="email required textInput valid" type="text"><span>*</span></td>
                    </tr>
                    <tr>
                        <td>身份证号（M1）：</td>
                        <td><input name="contactIdCardNo" value="<?php echo $alipay['contactIdCardNo']; ?>" size="30" class="textInput valid" type="text"><span>*</span></td>
                        <td>联系人类型（M1）：</td>
                        <td>
                            <select class=""  name="contactType">
                                <option value="AGENT" <?php if($alipay['contactType']=="AGENT"){echo 'selected="selected"';}?>>代理人</option>
                                <option value="LEGAL_PERSON" <?php if($alipay['contactType']=="LEGAL_PERSON"){echo 'selected="selected"';}?>>法人</option>
                                <option value="OTHER" <?php if($alipay['contactType']=="OTHER"){echo 'selected="selected"';}?>>其他</option>
                                <option value="CONTROLLER" <?php if($alipay['contactType']=="CONTROLLER"){echo 'selected="selected"';}?>>实际控制人</option>
                            </select><span>*</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>省份（M2）：</td>
                        <td>
                            <select name="provinceCode" id="registerprovinceCode" onchange="getAreaTreeInfo('registercityCode',this.value)" class="valid">
                                <option value="">----请选择----</option>
                                <?php foreach ($area as $key => $a): ?>
                                    <?php if($a['areaCode'] == $alipay['provinceCode']){ ?>
                                    <option value="<?php echo $a['areaCode']; ?>" selected="selected"><?php echo $a['areaName']; ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $a['areaCode']; ?>"><?php echo $a['areaName']; ?></option>
                                <?php } ?>
                                <?php endforeach ?>
                            </select><span>*</span>
                        </td>
                        <td>城市（M2）：</td>
                        <td>
                            <select name="cityCode" id="registercityCode" onchange="getAreaTreeInfo('registerdistrictCode',this.value)" class="valid">
                                <option value="" size="30" class="combox">----请选择----</option>
                                <?php foreach ($areaCity as $key => $c): ?>
                                    <?php if($c['areaCode'] == $alipay['cityCode']){ ?>
                                        <option value="<?php echo $c['areaCode']; ?>" selected="selected"><?php echo $c['areaName']; ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $c['areaCode']; ?>"><?php echo $c['areaName']; ?></option>
                                    <?php } ?>
                                <?php endforeach ?>
                            </select><span>*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>区县（M2）：</td>
                        <td>
                            <select name="districtCode" id="registerdistrictCode" class="valid">
                                <option value="" size="30" class="combox">----请选择----</option>
                                <?php foreach ($districtCode as $key => $d): ?>
                                    <?php if($d['areaCode'] == $alipay['districtCode']){ ?>
                                        <option value="<?php echo $d['areaCode']; ?>" selected="selected"><?php echo $d['areaName']; ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $d['areaCode']; ?>"><?php echo $d['areaName']; ?></option>
                                    <?php } ?>
                                <?php endforeach ?>
                            </select><span>*</span>
                        </td>
                        <td>地址类型（M2）：</td>
                        <td>
                            <select class="" name="addressType">
                                <option value="BUSINESS_ADDRESS" <?php if($alipay['addressType']=="BUSINESS_ADDRESS"){echo 'selected="selected"';}?>>经营地址</option>
                                <option value="REGISTERED_ADDRESS" <?php if($alipay['addressType']=="REGISTERED_ADDRESS"){echo 'selected="selected"';}?>>注册地址</option>
                            </select><span>*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>经营地址（M2）：</td>
                        <td><input name="address" value="<?php echo $alipay['address']; ?>" size="25" class="textInput valid" type="text"><span>*</span></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>营业执照编号（M3）：</td>
                        <td><input name="businessLicense" value="<?php echo $alipay['businessLicense']; ?>" size="30" class="textInput valid" type="text"></td>
                        <td>营业执照类型（M3）：</td>
                        <td>
                            <select class="" name="businessLicenseType">
                                <option value="INST_RGST_CTF" <?php if($alipay['businessLicenseType']=="INST_RGST_CTF"){echo 'selected="selected"';}?>>事业单位法人证书</option>
                                <option value="NATIONAL_LEGAL" <?php if($alipay['businessLicenseType']=="NATIONAL_LEGAL"){echo 'selected="selected"';}?>>营业执照</option>
                                <option value="NATIONAL_LEGAL_MERGE" <?php if($alipay['businessLicenseType']=="NATIONAL_LEGAL_MERGE"){echo 'selected="selected"';}?>>营业执照（多证合一）</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>银行卡号（M3）：</td>
                        <td><input name="cardNo" value="<?php echo $alipay['cardNo']; ?>" size="20" class="textInput valid" type="text"></td>
                        <td>银行卡持卡人姓名（M3）：</td>
                        <td><input name="cardName" value="<?php echo $alipay['cardName']; ?>" size="20" class="textInput valid" type="text"></td>
                    </tr>
                    <tr>
                        <td>支付宝账号：</td>
                        <td><input name="logonId" value="<?php echo $alipay['logonId']; ?>" size="20" class="textInput valid" type="text"></td>
                        <td>支付二维码信息：</td>
                        <td><input name="payCodeInfo" value="<?php echo $alipay['payCodeInfo']; ?>" size="20" class="textInput valid" type="text"></td>
                    </tr>
                </table>
                <input  type="submit" style=" background: #008fd3; border:none; width:100px; height:30px; color:#ffffff;margin-top: 30px;margin-left: 190px;" value="提交"/>
                <span style="margin-left: 30px;color:#f00;">注：M1、M2必填，填写M3支持使用信用卡及花呗</span>
            </form>
        </div>

    </div>
    <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/footer.tpl.php'; ?>
</div>
</div>

<script src="<?php echo $this->RlStaticResource; ?>plugins/js/dropzone/dropzone.js"></script>
<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource; ?>plugins/js/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        var state = "<?php echo $_GET['type'];?>";
        if (state) {
            var type = "<?php echo $reg_list['type'];?>";
            var rate = "<?php echo $reg_list['rate'];?>";
            var settlement = "<?php echo $reg_list['settlement'];?>";
            if (type) {
                $('#rate').html(rate + "%").css('color', 'red');
                $('#Tcycle').html(settlement).css('color', 'red');
                changeModel(type.toString());
            }
        }

    });


    $(".js_pic_url,.js_pic_url .icon20_common add_gray").dropzone({
        url: "?m=Agent&c=merchant&a=uploadImg",
        addRemoveLinks: false,
        maxFilesize: 1,
        acceptedFiles: ".jpg,.png",
        uploadMultiple: false,
        init: function () {
            this.on("success", function (file, responseText) {
                var imgtype = this.previewsContainer.id;


                var rept = $.parseJSON(responseText);
                var imgHtml = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="' + rept.fileUrl + '"><input name="' + imgtype + 'List[]" class="imginput" type="hidden" value="' + rept.fileUrl + '"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';

                // 如果是补充证书 有多张图
                if (imgtype == 'annuxes') {
                    imgHtml = $(this.element).parent().siblings().html() + imgHtml;
                }

                $(this.element).parents(".img_upload_box").siblings().html(imgHtml);
            });
        }
    });

    // $("#name").blur(function(){
    //    		if($(this).val()==""){
    //    			$(this).next("p").show();
    //    			$(this).next("p").text("请输入联系人姓名")
    //    		}else{
    //    			$(this).next("p").hide();
    //    		}
    //    	});
    //    $("#tel").blur(function(){
    //    	var phone = $(this).val();
    //    		var tel = /^1[3|4|5|8][0-9]\d{4,8}$/;
    //    		if($(this).val()==""){
    //    			$(this).next("p").show();
    //    			$(this).next("p").text("请输入手机号码")
    //    		}else if(!tel.exec(phone)){
    //    			$(this).next("p").show();
    //    			$(this).next("p").text("手机号码格式错误")
    //    		}else{
    //    			$(this).next("p").hide();
    //    		}
    //    	});
    //    $("#mailbox").blur(function(){
    //    	var mailbox = $(this).val();
    //    	var email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    //    		if($(this).val()==""){
    //    			$(this).next("p").show();
    //    			$(this).next("p").text("请输入邮箱")
    //    		}else if(!email.exec(mailbox)){
    //    			$(this).next("p").text("邮箱格式错误")
    //    		}else{
    //    			$(this).next("p").hide();
    //    		}
    //    	});
    //    $("#business_abbreviation").blur(function(){
    //    		if($(this).val()==""){
    //    			$(this).next("p").show();
    //    			$(this).next("p").text("请输入商户简称")
    //    		}else{
    //    			$(this).next("p").hide();
    //    		}
    //    	});


    //    $("#merchant_description").blur(function(){
    //    		if($(this).text()==""){
    //    			$(this).next("p").show();
    //    			$(this).next("p").text("请输入商品的描述")
    //    		}else{
    //    			$(this).next("p").hide();
    //    		}
    //    	});


    //    $("#phone").blur(function(){
    //    		if($(this).val()==""){
    //    			$(this).next("p").show();
    //    			$(this).next("p").text("请输入客服电话")
    //    		}else{
    //    			$(this).next("p").hide();
    //    		}
    //    	});


    $("#classification_three>option").click(function () {
        if ($(this).val() == "0") {
            $("#Realestate").hide();
            $("#publicWelfare").hide();
            $("#special_qualificat").hide();
            $("#comDescription").hide();

        }
    });

</script>

<script>
    $(document).on('mouseover mouseout', '.img_upload_preview_box', function (event) {
        if (event.type == "mouseover") {
            $(this).find('p').show();
        } else if (event.type == "mouseout") {
            $(this).find('p').hide();
        }
    });

    function DelthisImg(obj) {

        swal({
            title: "您确定删除图片！",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                obj.parent('p').parent('.img_upload_preview_box').remove();
            }
        });

    }
</script>

<script type="text/javascript">
    function getnextLevel() {
        var obj = $('#classification_one');
        var provinceid = obj.val();
        var cityHtml = '&nbsp;&nbsp;&nbsp;<select name="tradelevel2" id="cityS" style="width:126px;float: left;margin-left:10px;height: 30px" onchange="GetDistrict();"><option value="0">请选择</option>'
        $.post('?m=Agent&c=merchant&a=getSecondLevel', {id: provinceid}, function (ret) {
            if (ret.data) {
                $.each(ret.data, function (nn, vv) {
                    cityHtml += '<option value="' + vv.id + '" data-fullname="' + vv.name + '" >' + vv.name + '</option>';
                });
                cityHtml += '</select>';
                $('#districtS').remove();
                $('#cityS').remove();
                obj.after(cityHtml);
            }
        }, 'json');
    }

    function GetDistrict() {
        var obj = $('#cityS');
        var cityid = obj.val();
        var cityname = obj.find("option:selected").data('fullname');


        var cityHtml = '&nbsp;&nbsp;&nbsp;<select name="tradelevel3" id="districtS" style="width:126px;float: left; height: 30px;margin-left:10px" onchange="GetCircle();"><option value="0">请选择</option>'
        $.post('?m=Agent&c=merchant&a=getThirdLevel', {id: cityid}, function (ret) {
            if (ret.data) {
                $.each(ret.data, function (nn, vv) {
                    console.log(vv);
                    cityHtml += '<option value="' + vv.id + '" data-fullname="' + vv.name + '"  >' + vv.name + '</option>';
                });
                cityHtml += '</select>';
                $('#districtS').remove();
                $('#circleS').remove();
                obj.after(cityHtml);
            }
        }, 'JSON');
    }

    function GetCircle() {
        var obj = $('#districtS').val();

        $.ajax({
            type: 'post',
            url: '?m=Agent&c=merchant&a=getFourthlevel',
            dataType: 'json',
            data: {id: obj},
            success: function (ev) {
                $('#rate').html(ev[0].rate + "%").css('color', 'red');
                $('#Tcycle').html(ev[0].settlement).css('color', 'red');
                changeModel(ev[0].type);

            }
        });

    }
    //获取城市
    function getAreaTreeInfo(obj,id){
        if(id){
            $.ajax({
                type: 'post',
                url: '?m=Agent&c=alipieces&a=getAreaTreeInfo',
                dataType: 'json',
                data: {id: id},
                success: function (ev) {
                    var str = "";
                    var areaCode = "";
                    var areaName = "";
                    for(var i = 0;i< ev.length;i++){
                        areaCode = ev[i]['areaCode'];
                        areaName = ev[i]['areaName'];
                        str += '<option value="'+areaCode+'">'+areaName+'</option>';
                    }
                    str = '<option value="">----请选择----</option>'+str;
                    if(obj == "registercityCode"){
                        $("#registercityCode").html(str);
                        $("#registerdistrictCode").html('<option value="">----请选择----</option>');
                    }
                    else{
                        $("#registerdistrictCode").html(str);
                    }
                }
            });
        }
        else{

        }
    }
    //显示选项框
    function showBusinessAppid(obj){
        if(obj == "Y"){
            $(".showBusinessAppid").hide();
            $("input[name='bankAcceptAppid']").val("");
        }
        else{
            $(".showBusinessAppid").show();
            $("input[name='bankAcceptAppid']").val("");
        }
    }
    function changeModel(ev) {
        switch (ev) {
            case "1":
                $('#customer_tel').show();
                $('#company_web').show();
                $('#Sup_material').show();
                $("#special_qualificat").hide();
                $("#comDescription").hide();
                $("#publicWelfare").hide();
                $("#Realestate").hide();
                break;
            case "2":
                $('#customer_tel').show();
                $('#company_web').show();
                $('#Sup_material').show();
                $("#special_qualificat").show();
                $("#comDescription").show();
                $("#publicWelfare").hide();
                $("#Realestate").hide();
                break;
            case "3":
                $('#customer_tel').show();
                $('#company_web').show();
                $('#Sup_material').show();
                $("#comDescription").show();
                $("#special_qualificat").hide();
                $("#publicWelfare").hide();
                $("#Realestate").hide();
                break;
            case "4":
                $('#customer_tel').show();
                $('#company_web').show();
                $('#Sup_material').show();
                $("#comDescription").hide();
                $("#special_qualificat").show();
                $("#publicWelfare").hide();
                $("#Realestate").hide();
                break;
            case "5":
                $('#customer_tel').show();
                $('#company_web').show();
                $('#Sup_material').show();
                $("#comDescription").show();
                $("#Realestate").show();
                $("#special_qualificat").hide();
                $("#publicWelfare").hide();
                break;
            case "6":
                $('#customer_tel').show();
                $('#company_web').show();
                $('#Sup_material').show();
                $("#comDescription").show();
                $("#publicWelfare").show();
                $("#Realestate").hide();
                $("#special_qualificat").hide();
                break;
            default:
                break;
        }
    }
</script>
<script>
    $("#show").click(function () {
        $(".select_permissions").css("display","none");
        $("#formid").css("display","");
        $("#show").css("display","none");
    })
</script>
</body>
</html>