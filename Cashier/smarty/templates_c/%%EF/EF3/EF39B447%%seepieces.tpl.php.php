<?php /* Smarty version 2.6.18, created on 2017-06-06 15:32:19
         compiled from /www/html/pay.yunjifu.net/Cashier/./pigcms_tpl/Merchants/System/merchant/seepieces.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>
    <title>进件查看</title>
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

        .role_permission{background: #FFFFFF;}
        .role_permission>h1{ font-size: 18px; border-bottom:1px solid #f2f2f2 ; height: 40px; line-height: 40px; border-top: 3px solid #B5D6FD; margin: 0px; padding-left: 20px;}
        .role_permission>div{ border: 1px solid #f2f2f2; margin:20px  auto; width: 98%;}
        .role_permission>div>h2{ height: 40px; line-height: 40px; padding: 0 10px; background: #f2f2f2; margin: 0px; font-size: 16px; font-weight: normal;}
        .role_permission>div>p{ min-height: 40px; line-height: 40px; margin-bottom: 0px;}
        .role_permission>div>p>label:first-child,.role_permission form>p>label:first-child{ width: 120px; text-align: right; margin-right: 20px; margin-bottom: 0px;}
        .role_permission>div>p>input,.role_permission form>p>input{ width: 150px; height: 25px; margin-right: 30px;}
        .role_permission>div>p>select,.role_permission form>p>select{ width: 150px; height: 25px; margin-right: 30px;}
        .role_permission>label{ min-width:200px;margin-left: 20px;}
        .role_permission>label>select{ width: 150px; margin-left: 10px;}
        .role_permission>label>div{cursor: pointer; height: 60px; width: 400px; border: 1px  solid #f2f2f2; overflow: hidden; overflow-y: auto; float: right; margin-left: 10px;}

        .select_permissions>div{ min-height: 40px;  line-height: 40px; border-top:1px solid #f2f2f2 ; width: 95%; margin: 0 auto; padding: 10px 0; }

        #download{float:right;  padding: 0 10px; margin-top:5px; margin-right: 10px; display: inline-block; width: 60px; text-align: center; background: #008fd3;border-radius:2px; height: 25px; line-height: 25px; font-size: 16px; color: #FFFFFF;}

        .bc{ text-align: center; height: 30px; line-height: 30px; background: #008fd3; color: #FFFFFF; border: none; border-radius: 2px; margin: 0 auto; width: 66px; position: absolute; left: 50%; margin-left: -33px; bottom: 20px;}
        .select_permissions>div>h3{ border-left: 4px solid #37B737; padding-left: 20px; font-size: 16px; height: 30px; line-height: 30px; margin-bottom: 20px;}
        .select_permissions>div>p>label{display: inline-block; width: 150px; text-align: right; margin-right: 10px;}
        span{color: #AAAAAA;}
        .role_permission > div > p > label:first-child, .role_permission form > p > label:first-child{width: 180px;}
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
                <h2>商家信息管理</h2>
                <ol class="breadcrumb">
                    <li><a>User</a></li>
                    <li><a>商户中心</a></li>
                    <li><a>进件管理</a></li>
                    <li class="active"><strong>进件查看</strong></li>
                </ol>
            </div>
            <div class="col-lg-2"></div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row role_permission" style="position: relative; padding-bottom: 50px;">
                <h1><?php echo $this->_tpl_vars['regist']['merchants_company']; ?>
 商户<?php if ($this->_tpl_vars['regist']['wechat']): ?>微信<?php else: ?>支付宝<?php endif; ?>进件查看 <a id="download"  href="javascript:PiecesDownload();">下载</a></h1>
                <form id="form1" action="/merchants.php" style="padding: 10px 0" method="post">
                    <input type="hidden" value="System" name="m"/>
                    <input type="hidden" value="merchant" name="c"/>
                    <input type="hidden" value="seepieces" name="a"/>
                    <input type="hidden" value="<?php echo $this->_tpl_vars['regist']['id']; ?>
" name="id"/>
                    <p>
                        <label style="width:120px;">状态：</label>
                        <select name='status'>
                            <option value="0" <?php if ($this->_tpl_vars['regist']['status'] == '0'): ?><?php echo 'selected="selected"'; ?>
<?php endif; ?>>待初审</option>
                            <option value="4" <?php if ($this->_tpl_vars['regist']['status'] == '4'): ?><?php echo 'selected="selected"'; ?>
<?php endif; ?>>初审失败</option>
                            <option value="1" <?php if ($this->_tpl_vars['regist']['status'] == '1'): ?><?php echo 'selected="selected"'; ?>
<?php endif; ?>>初审成功并审核中</option>
                            <option value="2" <?php if ($this->_tpl_vars['regist']['status'] == '2'): ?><?php echo 'selected="selected"'; ?>
<?php endif; ?>>审核成功</option>
                            <option value="3" <?php if ($this->_tpl_vars['regist']['status'] == '3'): ?><?php echo 'selected="selected"'; ?>
<?php endif; ?>>审核失败</option>
                        </select>
                    </p>

                    <p>
                        <label style="width:120px;vertical-align: top">备注：</label>
                        <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['regist']['id']; ?>
">
                        <textarea rows="" cols="" name="comments"  style=" width: 400px; height:200px;resize: none;"><?php echo $this->_tpl_vars['regist']['comments']; ?>
</textarea>


                    </p>
<!--                    <p style=" margin-left: 140px"><button id="btnn" type="button" style=" background: #008fd3; border:none; width:100px; height:30px; color:#ffffff">提交</button></p>-->
                    <p style=" margin-left: 140px"><button id="" type="submit" style=" background: #008fd3; border:none; width:100px; height:30px; color:#ffffff">提交</button></p>

                </form>
                <?php if ($this->_tpl_vars['regist']['wechat'] == '' && $this->_tpl_vars['regist']['alipay'] == ''): ?><!--
                    作者：2721190987@qq.com
                    时间：2016-10-29
                    描述：联系信息
                -->
                <div>
                    <h2>联系信息</h2>
                    <p><label>联系人姓名：</label><span><?php echo $this->_tpl_vars['regist']['contactor']; ?>
</span></p>
                    <p><label>手机号码：</label><span><?php echo $this->_tpl_vars['regist']['tel']; ?>
</span></p>
                    <p><label>常用邮箱：</label><span><?php echo $this->_tpl_vars['regist']['email']; ?>
</span></p>

                </div>
                <!--
                    作者：2721190987@qq.com
                    时间：2016-10-29
                    描述：经营信息
                -->
                <div class="select_permissions ">
                    <h2>经营信息</h2>
                    <p><label>商户简称：</label><span><?php echo $this->_tpl_vars['regist']['shortname']; ?>
</span></p>
                    <p><label>经营类目：</label><span><?php echo $this->_tpl_vars['regist']['level1']; ?>
><?php echo $this->_tpl_vars['regist']['level2']; ?>
><?php echo $this->_tpl_vars['regist']['level3']; ?>
</span></p>
                    <p><label>特殊资质：</label><span>虚伪彩色图片且小于2M，文件格式为bmp、png、jpeg/jpe或gif</span><br />
                        <?php $_from = $this->_tpl_vars['regist']['special']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vo']):
?>
                        <img style="width: 100px; height: 150px; margin-left: 50px; overflow: hidden;" src="<?php echo $this->_tpl_vars['vo']; ?>
">
                        <?php endforeach; endif; unset($_from); ?>
                    </p>
                    <p><label>售卖商品描述：</label><span><?php echo $this->_tpl_vars['regist']['dealdesc']; ?>
</span></p>
                    <p><label>客服电话：</label><span><?php echo $this->_tpl_vars['regist']['tel']; ?>
</span></p>
                    <p><label>公司网站：</label><span><?php echo $this->_tpl_vars['regist']['website']; ?>
</span></p>
                    <p><label>补充材料：</label><br/>
					       <span>
    							 <?php $_from = $this->_tpl_vars['regist']['annexs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vo']):
?>
    							     <img style="width: 120px; height: 90px; overflow: hidden;" src="<?php echo $this->_tpl_vars['vo']; ?>
">
    							 <?php endforeach; endif; unset($_from); ?>
							</span>
                    </p>
                </div>

                <!--
                    作者：2721190987@qq.com
                    时间：2016-10-29
                    描述：商户信息
                -->
                <div class="select_permissions ">
                    <h2>商户信息</h2>
                    <div>
                        <h3>基本信息</h3>
                        <p><label>商户名称：</label><span><?php echo $this->_tpl_vars['regist']['company']; ?>
</span></p>
                        <p><label>注册地址：</label><span><?php echo $this->_tpl_vars['regist']['address']; ?>
</span></p>
                    </div>
                    <div>
                        <h3>营业执照</h3>
                        <p><label>营业执照注册号：</label><span><?php echo $this->_tpl_vars['regist']['icence']; ?>
</span></p>
                        <p><label>经营范围：</label><span><?php echo $this->_tpl_vars['regist']['mcarea']; ?>
</span></p>
                        <p><label>营业期限：</label><span><?php echo $this->_tpl_vars['regist']['starttime']; ?>
至<?php echo $this->_tpl_vars['regist']['endtime']; ?>
</span></p>
                        <p><label>营业执照照片：</label>
    							<span>

        							 <?php $_from = $this->_tpl_vars['regist']['licencephotoList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vo']):
?>
        							     <img style="width: 120px; height: 90px; overflow: hidden;" src="<?php echo $this->_tpl_vars['vo']; ?>
">
        							 <?php endforeach; endif; unset($_from); ?>
    							</span>
                        </p>
                    </div>
                    <div>
                        <h3>组织机构代码信息</h3>
                        <p><label>组织机构代码：</label><span><?php echo $this->_tpl_vars['regist']['occode']; ?>
</span></p>
                        <p><label>有效期：</label><span><?php echo $this->_tpl_vars['regist']['validatestart']; ?>
至<?php echo $this->_tpl_vars['regist']['validateend']; ?>
</span></p>
                        <p><label>组织机构代码证照片：</label>
							     <span>

							      <?php $_from = $this->_tpl_vars['regist']['occodephotoList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vo']):
?>
							          <img style="width: 120px; height: 90px; overflow: hidden;" src="<?php echo $this->_tpl_vars['vo']; ?>
">
							      <?php endforeach; endif; unset($_from); ?>
							     </span>
                        </p>
                    </div>

                    <div>
                        <h3>企业法人/经办人</h3>
                        <p><label>证件持有人类型：</label><span><?php echo $this->_tpl_vars['regist']['idtype']; ?>
</span></p>
                        <p><label>证件持有人姓名：</label><span><?php echo $this->_tpl_vars['regist']['idname']; ?>
</</span></p>
                        <p><label>证件类型：</label><span><?php echo $this->_tpl_vars['regist']['idcard']; ?>
</span></p>
                        <p><label>身份证正面照：</label><span><img style="width: 150px; height: 80px; overflow: hidden;" src="<?php echo $this->_tpl_vars['regist']['idphotoAList']['0']; ?>
"></span></p>
                        <p><label>身份证反面照：</label><span><img style="width: 150px; height: 80px; overflow: hidden;" src="<?php echo $this->_tpl_vars['regist']['idphotoBList']['0']; ?>
"></span></p>
                        <p><label>有效时间：</label><span><?php echo $this->_tpl_vars['regist']['idstart']; ?>
至<?php echo $this->_tpl_vars['regist']['idend']; ?>
</span></p>
                        <p><label>证件号码：</label><span><?php echo $this->_tpl_vars['regist']['idnum']; ?>
</span></p>
                    </div>
                </div>

                <!--
                    作者：2721190987@qq.com
                    时间：2016-10-29
                    描述：结算信息
                -->
                <div class="select_permissions ">
                    <h2>结算信息</h2>
                    <p><label>账户类型：</label><span><?php echo $this->_tpl_vars['regist']['accountType']; ?>
</span></p>
                    <p><label>开户名称：</label><span><?php echo $this->_tpl_vars['regist']['account']; ?>
</span></p>
                    <p><label>开户银行：</label><span><?php echo $this->_tpl_vars['regist']['bank']; ?>
</span></p>
                    <p><label>开户银行城市：</label><span><?php echo $this->_tpl_vars['regist']['bankaddress']; ?>
</span></p>
                    <p><label>开户支行：</label><span><?php echo $this->_tpl_vars['regist']['bank_branch']; ?>
</span></p>
                    <p><label>银行账户：</label><span><?php echo $this->_tpl_vars['regist']['accountid']; ?>
</span></p>

                </div>
                <?php endif; ?>
                <!--
                作者：2721190987@qq.com
                时间：2016-10-29
                描述：微信
                -->
                <?php if ($this->_tpl_vars['regist']['wechat'] != ''): ?>
                <div class="select_permissions ">
                    <h2>微信子商户<!--<a href="?m=System&c=merchant&a=editInfo&id=<? echo $_GET['id']; ?>" class="" style="float:right;color:#44b549;">编辑</a>--></h2>
                    <p><label>商户名称：</label><span><?php echo $this->_tpl_vars['regist']['wechat']['bankSpName']; ?>
</span></p>
                    <p><label>商户简称：</label><span><?php echo $this->_tpl_vars['regist']['wechat']['aliasName']; ?>
</span></p>
                    <p><label>渠道类型：</label><span><?php echo $this->_tpl_vars['regist']['wechat']['chnlType']; ?>
</span></p>
                    <p><label>使用民生公众号：</label><span><?php if ($this->_tpl_vars['regist']['wechat']['acceptFlag'] == 'Y'): ?>是<?php else: ?>否<?php endif; ?></span></p>
                    <p><label>受理公众号APPID：</label><span><?php echo $this->_tpl_vars['regist']['wechat']['bankAcceptAppid']; ?>
</span></p>
                    <p><label>客服电话：</label><span><?php echo $this->_tpl_vars['regist']['wechat']['servicePhone']; ?>
</span></p>
                    <p><label>经营类目：</label><span><?php echo $this->_tpl_vars['regist']['wechat']['categoryId']; ?>
</span></p>
                    <p><label>联系人：</label><span><?php echo $this->_tpl_vars['regist']['wechat']['contactName']; ?>
</span></p>
                    <p><label>联系电话：</label><span><?php echo $this->_tpl_vars['regist']['wechat']['contactPhone']; ?>
</span></p>
                    <p><label>联系手机：</label><span><?php echo $this->_tpl_vars['regist']['wechat']['contactMobile']; ?>
</span></p>
                    <p><label>联系邮箱：</label><span><?php echo $this->_tpl_vars['regist']['wechat']['contactEmail']; ?>
</span></p>
                    <p><label>商户备注：</label><span><?php echo $this->_tpl_vars['regist']['wechat']['remark']; ?>
</span></p>

                </div>
                <?php endif; ?>
                <!--
                作者：2721190987@qq.com
                时间：2016-10-29
                描述：支付宝
                -->
                <?php if ($this->_tpl_vars['regist']['alipay'] != ''): ?>
                <div class="select_permissions ">
                    <h2>支付宝子商户</h2>
                    <p><label>商户名称(M1)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['bankSpName']; ?>
</span></p>
                    <p><label>商户简称(M1)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['aliasName']; ?>
</span></p>
                    <p><label>客服电话(M1)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['servicePhone']; ?>
</span></p>
                    <p><label>经营类目(M1)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['categoryId']; ?>
</span></p>
                    <p><label>是否使用民生PID(M1)：</label><span><?php if ($this->_tpl_vars['regist']['alipay']['acceptFlag'] == 'Y'): ?>是<?php else: ?>否<?php endif; ?></span></p>
                    <p><label>商户机构标识PID(M1)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['bankAcceptAppid']; ?>
</span></p>
                    <p><label>联系人(M1)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['contactName']; ?>
</span></p>
                    <p><label>联系电话(M1)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['contactPhone']; ?>
</span></p>
                    <p><label>联系手机(M1)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['contactMobile']; ?>
</span></p>
                    <p><label>联系人类型(M1)：</label><span><?php if ($this->_tpl_vars['regist']['alipay']['contactType'] == 'AGENT'): ?>代理人<?php endif; ?><?php if ($this->_tpl_vars['regist']['alipay']['contactType'] == 'LEGAL_PERSON'): ?>法人<?php endif; ?><?php if ($this->_tpl_vars['regist']['alipay']['contactType'] == 'OTHER'): ?>其他<?php endif; ?><?php if ($this->_tpl_vars['regist']['alipay']['contactType'] == 'CONTROLLER'): ?>实际控制人<?php endif; ?></span></p>
                    <p><label>联系邮箱(M1)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['contactEmail']; ?>
</span></p>
                    <p><label>身份证号(M1)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['contactIdCardNo']; ?>
</span></p>
                    <p></p>
                    <p><label>省份(M2)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['provinceCode']; ?>
</span></p>
                    <p><label>城市(M2)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['cityCode']; ?>
</span></p>
                    <p><label>区县(M2)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['districtCode']; ?>
</span></p>
                    <p><label>地址类型(M2)：</label><span><?php if ($this->_tpl_vars['regist']['alipay']['addressType'] == 'BUSINESS_ADDRESS'): ?>经营地址<?php else: ?>注册地址<?php endif; ?></span></p>
                    <p><label>经营地址(M2)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['address']; ?>
</span></p>
                    <p></p>
                    <p><label>营业执照编号(M3)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['businessLicense']; ?>
</span></p>
                    <p><label>营业执照类型(M3)：</label><span><?php if ($this->_tpl_vars['regist']['alipay']['businessLicenseType'] == 'INST_RGST_CTF'): ?>事业单位法人证书<?php endif; ?><?php if ($this->_tpl_vars['regist']['alipay']['businessLicenseType'] == 'NATIONAL_LEGAL'): ?>营业执照<?php endif; ?><?php if ($this->_tpl_vars['regist']['alipay']['businessLicenseType'] == 'NATIONAL_LEGAL_MERGE'): ?>营业执照（多证合一）<?php endif; ?></span></p>
                    <p><label>银行卡号(M3)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['cardNo']; ?>
</span></p>
                    <p><label>银行卡持卡人姓名(M3)：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['cardName']; ?>
</span></p>
                    <p><label>支付宝账号：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['logonId']; ?>
</span></p>
                    <p><label>支付二维码信息：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['payCodeInfo']; ?>
</span></p>
                    <p></p>
                    <p><label>商户备注：</label><span><?php echo $this->_tpl_vars['regist']['alipay']['remark']; ?>
</span></p>
                </div>
                <?php endif; ?>
                <form action="/merchants.php?m=System&c=merchant&a=PiecesDownload" method="post" id="PiecesDownload">

                    <input name="id" value="<?php echo $this->_tpl_vars['data']['id']; ?>
" type="hidden">

                </form>

            </div>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
    </div>
</div>

<!-- iCheck -->
<script src="<?php echo @RlStaticResource; ?>
plugins/js/iCheck/icheck.min.js"></script>
<script>
    function PiecesDownload(){
        $('#PiecesDownload').submit();
    }

    $('#btnn').click(function(){
        $.post('?m=System&c=merchant&a=seepieces',$('#form1').serialize(),function(e){
            if(e.code==1){
                swal({
                    title: "提交成功!",
                    text: '',
                    type: "success"
                }, function () {
                    window.location.reload();
                });
            }else{
                swal("提交失败",'' , "error");
            }
        },'json');
    });




</script>
</body>
</html>