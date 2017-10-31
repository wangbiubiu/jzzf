<!DOCTYPE html>
<html>
<head>
    <title>进件查看</title>
    {pg:include file="$tplHome/System/public/header.tpl.php"}
    <link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
    <link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="{pg:$smarty.const.RlStaticResource}plugins/css/iCheck/custom.css" rel="stylesheet">
    <link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
    <style>
    </style>
    <script src="{pg:$smarty.const.RlStaticResource}plugins/js/footable/footable.all2.min.js"></script>
</head>
<body>
<div id="wrapper">
    {pg:include file="$tplHome/System/public/leftmenu.tpl.php"}
    <div id="page-wrapper" class="gray-bg">
        {pg:include file="$tplHome/System/public/top.tpl.php"}
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>商家信息管理</h2>
                <ol class="breadcrumb">
                    <li><a>User</a></li>
                    <li><a>商户中心</a></li>
                    <li><a>进件管理</a></li>
                    <li class="active"><strong>进件修改</strong></li>
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
        </style>
        <div class="role_permission">
            <h1>商户微信进件修改 <a href="?m=System&c=merchant&a=seepieces&id={pg: $regist.id}" style="float:right;color:#44b549;margin-right: 20px;font-size: 16px;">返回</a></h1>
            <form name='regist' action="?m=System&c=merchant&a=editInfo&id={pg: $regist.id}" method="post" enctype="multipart/form-data" class="wrapper wrapper-content animated fadeInRight">
                <table width="880px" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="180px">商户名称：</td>
                        <td width="260px"><input name="bankSpName" value="{pg: $wechat.bankSpName}" size="30" class="required textInput valid" type="text" placeholder=""><span>*</span></td>
                        <td width="180px">商户简称：</td>
                        <td><input name="aliasName" size="30" value="{pg: $wechat.aliasName}" class="required textInput valid" type="text" placeholder=""><span>*</span></td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>渠道类型：</td>
                        <td>
                            <select class="" name="chnlType">
                                <option value="WEIXIN" selected="selected">微信支付（普通）</option>
                                <option value="WEIXINAPP">微信支付（APP、H5）</option>
                                <option value="WEIXINPUB">微信支付（公共事业）</option>
                            </select>
                        </td>
                        <td style="display: none;">是否使用民生受理公众号：</td>
                        <td style="display: none;">
                            <select class="" name="acceptFlag">
                                <option value="Y" <?php if($wechat['acceptFlag'] == "Y" || empty($wechat['acceptFlag'])){echo 'selected="selected"';} ?>>是</option>
                                <option value="N" <?php if($wechat['acceptFlag'] == "N"){echo 'selected="selected"';} ?>>否</option>
                            </select>
                        </td>
                        <td>是否使用渠道商APPID：</td>
                        <td>
                            <select class="" name="" onchange="showBusinessAppid(this.value)">
                                <option value="Y" <?php if($wechat['bankAcceptAppid'] == $appid){echo 'selected="selected"';} ?>>是</option>
                                <option value="N" <?php if($wechat['bankAcceptAppid'] != $appid){echo 'selected="selected"';} ?>>否</option>
                            </select>
                        </td>
                    </tr>
                    <tr style="<?php if($wechat['bankAcceptAppid'] == $appid){echo 'display: none;';}?>" class="businessAppid">
                        <td>商家公众号APPID：</td>
                        <td><input name="bankAcceptAppid" value="" size="30" class="required textInput valid" type="text"></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>支付授权目录：</td>
                        <td><input name="authPaydir" value="{pg: $wechat.authPaydir}" size="30" class="textInput valid" type="text"></td>
                        <td>客服电话：</td>
                        <td><input name="servicePhone" value="{pg: $wechat.servicePhone}" size="30" class="required phoneNumber textInput valid" type="text" placeholder=""><span>*</span></td>
                    </tr>
                    <tr>
                        <td>经营类目：</td>
                        <td>
                            <select class="" name="categoryId">
                                <option value="">--请选择--</option>
                                {pg: foreach from=$regist.special item=vo}
                                    <?php
                                    if($c['id'] == $wechat['categoryId']){?>
                                        <option value="<?php echo $c['id'] ?>" selected="selected"><?php echo $c['name'] ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $c['id'] ?>"><?php echo $c['name'] ?></option>
                                    <?php } ?>
                                {pg: /foreach}
                            </select><span>*</span>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>联系人：</td>
                        <td><input name="contactName" value="{pg: $wechat.contactName}" size="30" class="required textInput valid" type="text"><span>*</span></td>
                        <td>联系电话：</td>
                        <td><input name="contactPhone" value="{pg: $wechat.contactPhone}" size="30" class="required phoneNumber textInput valid" type="text" placeholder="11位不含符号"><span>*</span></td>
                    </tr>
                    <tr>
                        <td>联系手机：</td>
                        <td><input name="contactMobile" value="{pg: $wechat.contactMobile}" size="30" class="required phoneNumber textInput valid" type="text" placeholder="11位不含符号"><span>*</span></td>
                        <td>联系邮箱：</td>
                        <td><input name="contactEmail" value="{pg: $wechat.contactEmail}" size="30" class="required email textInput valid" type="text"><span>*</span></td>
                    </tr>
                    <tr>
                        <td>联系人微信账号：</td>
                        <td><input name="contactWechatid" value="{pg: $wechat.contactWechatid}" size="30" class="textInput valid" type="text"></td>
                        <td>商户备注：</td>
                        <td><input name="remark" value="{pg: $wechat.remark}" size="30" class="required textInput valid" type="text"></td>
                    </tr>
                </table>


                <input  type="submit" style=" background: #008fd3; border:none; width:100px; height:30px; color:#ffffff;margin-top: 30px;margin-left: 190px;" value="提交"/>
            </form>

        </div>
    </div>
</div>
</body>
</html>