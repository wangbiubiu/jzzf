<?php /* Smarty version 2.6.18, created on 2017-11-01 09:37:33
         compiled from F:%5Cgit%5Cjzzf%5CCashier%5C./pigcms_tpl/Merchants/System/settlement/cash.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>
    <title>平台提现</title>
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

        .payment_allocation h1 {
            font-size: 18px;
            border-bottom: 1px solid #d9e6e9;
            border-top: 3px solid #edfbfe;
            background: #FFFFFF;
            height: 40px;
            line-height: 40px;
            padding: 0px 20px;
            margin-bottom: 0px;
        }
        #or{width: 200px;}
        .payment_allocation>div{ background: #FFFFFF;padding: 10px;}
        .payment_allocation>div>form{
            border: 1px solid #f2f2f2;
            position: relative;
        }
        .payment_allocation>div>form{ padding-bottom: 20px;}
        .payment_allocation>div>form:nth-child(2){ margin-bottom: 60px;}
        .payment_allocation>div>form>h2{ height: 40px; line-height: 40px; font-size: 16px; font-weight: normal; background: #f2f2f2; margin-top: 0px; margin-bottom: 0px; padding-left: 20px;}
        .payment_allocation>div>form>div{border-top: 1px solid #f2f2f2; height: 50px; line-height: 50px;}
        .payment_allocation>div>form>div>input{ height: 25px; line-height: 25px;}
        .payment_allocation>div>form>div>input:nth-child(3){margin-top: 3px; border: none; border-radius: 2px; color: #FFFFFF; background: #3E94DB;}
        .payment_allocation>div>form>input{height: 30px; line-height: 30px; position: absolute; left: 50%; margin-left: -35px;border: none; border-radius: 2px; color: #FFFFFF; background: #3E94DB;}
        .payment_allocation>div>form>div>label{ display: inline-block; width: 100px; text-align: right; margin-right: 10px;}
        .bankCardInfor{
            background: #FFFFFF;
            padding-bottom: 20px;;
        }
        .bankCardInfor>h2{
            font-size: 18px; font-weight: normal; padding: 10px 20px; border-top: 3px solid #6DBFFF;
            border-bottom: 1px solid #f3f3f3;
        }
        .bankCardInfor>form{
            width: 90%;
            border: 1px solid #f3f3f3;
            margin: 40px 5%;
            padding-bottom: 40px;;

        }
        .bankCardInfor>form>div{
            padding: 20px 0;

        }
        .bankCardInfor>form input{height: 33px;padding:0 10px;width: 180px;}
        .bankCardInfor>form select{height: 33px;}
        .bankCardInfor>form>h2{ width: 100%; height: 30px; font-size: 16px; line-height: 30px; padding-left: 10px; background: #d9dadc; color: #FFFFFF; margin-top: 0px;}
        .bankCardInfor>form>div>label{ display: inline-block; width: 200px;  text-align: right; margin-right: 10px;}
        .bankCardInfor>form>div>label>i{ color: red; margin-right: 10px;}
        .bankCardInfor>form>p{width: 120px;margin: 20px auto;}
        .bankCardInfor>form>p>button{ background: #0066CC; width: 120px; height: 38px; border: none; border-radius: 5px; color: #FFFFFF; margin: 0 auto;}
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
                <h2>平台提现</h2>
                <ol class="breadcrumb">
                    <li>
                        <a>System</a>
                    </li>
                    <li>
                        <a>结算中心</a>
                    </li>
                    <li class="active">
                        <strong>平台提现</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row wrapper page-heading iconList" >
            <div class="bankCardInfor">
                <h2>平台提现<a href="/merchants.php?m=System&c=settlement&a=cashlist" style="margin-left: 10px;">提现列表</a> </h2>
                <form id="form1" method="post">
                    <h2>持卡人证件信息</h2>
                    <div>
                        <label><i>*</i>类型：</label>
                        <select name="isCompay">
                            <option value="0" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['isCompay'] == '0' )): ?>selected="selected"<?php endif; ?>>个人</option>
                            <option value="1"  <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['isCompay'] == '1' )): ?>selected="selected"<?php endif; ?>>公司</option>
                        </select>
                    </div>
                    <div>
                        <label>银行预留手机号：</label>
                        <input type="text" name="phoneNo" value="<?php echo $this->_tpl_vars['bank']['phoneNo']; ?>
" placeholder="选填">
                    </div>
                    <div>
                        <label><i>*</i>开户名称：</label>
                        <input type="text" name="customerName" required="" value="<?php echo $this->_tpl_vars['bank']['customerName']; ?>
">
                    </div>
                    <div>
                        <label><i>*</i>证件类型：</label>
                        <select name="cerdType">
                            <option value="01" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['cerdType'] == '01' )): ?>selected="selected"<?php endif; ?>>身份证</option>
                            <option value="02" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['cerdType'] == '02' )): ?>selected="selected"<?php endif; ?>>军官证</option>
                            <option value="03" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['cerdType'] == '03' )): ?>selected="selected"<?php endif; ?>>护照</option>
                            <option value="04" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['cerdType'] == '04' )): ?>selected="selected"<?php endif; ?>>回乡证</option>
                            <option value="05" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['cerdType'] == '05' )): ?>selected="selected"<?php endif; ?>>台胞证</option>
                            <option value="06" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['cerdType'] == '06' )): ?>selected="selected"<?php endif; ?>>警官证</option>
                            <option value="07" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['cerdType'] == '07' )): ?>selected="selected"<?php endif; ?>>士兵证</option>
                            <option value="99" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['cerdType'] == '99' )): ?>selected="selected"<?php endif; ?>>其它证件</option>
                        </select>
                    </div>
                    <div>
                        <label><i>*</i>证件号码：</label>
                        <input type="text" name="cerdId" required="" value="<?php echo $this->_tpl_vars['bank']['cerdId']; ?>
">
                    </div>
                    <div>
                        <label><i>*</i>开户银行：</label>
                        <select name="settBankNo">
                            <option value="ICBC" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'ICBC' )): ?>selected="selected"<?php endif; ?>>工商银行</option>
                            <option value="ABC" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'ABC' )): ?>selected="selected"<?php endif; ?>>农业银行</option>
                            <option value="BOC" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'BOC' )): ?>selected="selected"<?php endif; ?>>中国银行</option>
                            <option value="CCB" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'CCB' )): ?>selected="selected"<?php endif; ?>>建设银行</option>
                            <option value="CMB" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'CMB' )): ?>selected="selected"<?php endif; ?>>招商银行</option>
                            <option value="BOCM" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'BOCM' )): ?>selected="selected"<?php endif; ?>>交通银行</option>
                            <option value="CMBC" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'CMBC' )): ?>selected="selected"<?php endif; ?>>民生银行</option>
                            <option value="CNCB" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'CNCB' )): ?>selected="selected"<?php endif; ?>>中信银行</option>
                            <option value="CEBB" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'CEBB' )): ?>selected="selected"<?php endif; ?>>光大银行</option>
                            <option value="CIB" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'CIB' )): ?>selected="selected"<?php endif; ?>>兴业银行</option>
                            <option value="BOB" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'BOB' )): ?>selected="selected"<?php endif; ?>>北京银行</option>
                            <option value="GDB" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'GDB' )): ?>selected="selected"<?php endif; ?>>广发银行</option>
                            <option value="HXB" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'HXB' )): ?>selected="selected"<?php endif; ?>>华夏银行</option>
                            <option value="PSBC" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'PSBC' )): ?>selected="selected"<?php endif; ?>>邮储银行</option>
                            <option value="SPDB" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'SPDB' )): ?>selected="selected"<?php endif; ?>>浦发银行</option>
                            <option value="PAB" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'PAB' )): ?>selected="selected"<?php endif; ?>>平安银行</option>
                            <option value="BOS" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'BOS' )): ?>selected="selected"<?php endif; ?>>上海银行</option>
                            <option value="BOHC" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'BOHC' )): ?>selected="selected"<?php endif; ?>>渤海银行</option>
                            <option value="BOJ" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == 'BOJ' )): ?>selected="selected"<?php endif; ?>>江苏银行</option>
                            <option value="" <?php if (( ! empty ( $this->_tpl_vars['bank'] ) && $this->_tpl_vars['bank']['settBankNo'] == "" )): ?>selected="selected"<?php endif; ?>>其他银行</option>
                        </select>
                    </div>
                    <div>
                        <label><i>*</i>银行卡号：</label>
                        <input type="text" name="acctNo" required="" onkeyup="this.value  = this.value.replace(/\D/g,'');" value="<?php echo $this->_tpl_vars['bank']['acctNo']; ?>
"/>
                    </div>
                    <div>
                        <label><i>*</i>提现金额：</label>
                        <input type="text" name="transAmt" placeholder="" required="" onkeyup="clearNoNum(this);" value="请输入金额" onclick="$(this).val('')" style="border:2px solid #ccc;width:150px;height: 40px;color:#f00;text-align: center;font-size: 25px;font-weight: bold;">
                    </div>
                    <p style="margin:20px 0 0 212px;"><button type="submit" class="btn">提交</button></p>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    function clearNoNum(obj){
        obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符
        obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的
        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
        obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');//只能输入两个小数
        if(obj.value.indexOf(".")< 0 && obj.value !=""){//以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额
            obj.value= parseFloat(obj.value);
        }
    }
</script>
</body>
<!-- iCheck -->
<script src="<?php echo @RlStaticResource; ?>
plugins/js/iCheck/icheck.min.js"></script>
</html>