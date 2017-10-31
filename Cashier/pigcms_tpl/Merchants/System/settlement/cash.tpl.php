<!DOCTYPE html>
<html>
<head>
    <title>平台提现</title>
    {pg:include file="$tplHome/System/public/header.tpl.php"}

    <link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
    <link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="{pg:$smarty.const.RlStaticResource}plugins/css/iCheck/custom.css" rel="stylesheet">
    <link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
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
    <script src="{pg:$smarty.const.RlStaticResource}plugins/js/footable/footable.all2.min.js"></script>
</head>

<body>
<div id="wrapper">
    {pg:include file="$tplHome/System/public/leftmenu.tpl.php"}

    <div id="page-wrapper" class="gray-bg">
        {pg:include file="$tplHome/System/public/top.tpl.php"}

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
                            <option value="0" {pg: if (!empty($bank) && $bank.isCompay == "0")}selected="selected"{pg: /if}>个人</option>
                            <option value="1"  {pg: if (!empty($bank) && $bank.isCompay == "1")}selected="selected"{pg: /if}>公司</option>
                        </select>
                    </div>
                    <div>
                        <label>银行预留手机号：</label>
                        <input type="text" name="phoneNo" value="{pg: $bank.phoneNo}" placeholder="选填">
                    </div>
                    <div>
                        <label><i>*</i>开户名称：</label>
                        <input type="text" name="customerName" required="" value="{pg: $bank.customerName}">
                    </div>
                    <div>
                        <label><i>*</i>证件类型：</label>
                        <select name="cerdType">
                            <option value="01" {pg: if (!empty($bank) && $bank.cerdType == "01")}selected="selected"{pg: /if}>身份证</option>
                            <option value="02" {pg: if (!empty($bank) && $bank.cerdType == "02")}selected="selected"{pg: /if}>军官证</option>
                            <option value="03" {pg: if (!empty($bank) && $bank.cerdType == "03")}selected="selected"{pg: /if}>护照</option>
                            <option value="04" {pg: if (!empty($bank) && $bank.cerdType == "04")}selected="selected"{pg: /if}>回乡证</option>
                            <option value="05" {pg: if (!empty($bank) && $bank.cerdType == "05")}selected="selected"{pg: /if}>台胞证</option>
                            <option value="06" {pg: if (!empty($bank) && $bank.cerdType == "06")}selected="selected"{pg: /if}>警官证</option>
                            <option value="07" {pg: if (!empty($bank) && $bank.cerdType == "07")}selected="selected"{pg: /if}>士兵证</option>
                            <option value="99" {pg: if (!empty($bank) && $bank.cerdType == "99")}selected="selected"{pg: /if}>其它证件</option>
                        </select>
                    </div>
                    <div>
                        <label><i>*</i>证件号码：</label>
                        <input type="text" name="cerdId" required="" value="{pg: $bank.cerdId}">
                    </div>
                    <div>
                        <label><i>*</i>开户银行：</label>
                        <select name="settBankNo">
                            <option value="ICBC" {pg: if (!empty($bank) && $bank.settBankNo == "ICBC")}selected="selected"{pg: /if}>工商银行</option>
                            <option value="ABC" {pg: if (!empty($bank) && $bank.settBankNo == "ABC")}selected="selected"{pg: /if}>农业银行</option>
                            <option value="BOC" {pg: if (!empty($bank) && $bank.settBankNo == "BOC")}selected="selected"{pg: /if}>中国银行</option>
                            <option value="CCB" {pg: if (!empty($bank) && $bank.settBankNo == "CCB")}selected="selected"{pg: /if}>建设银行</option>
                            <option value="CMB" {pg: if (!empty($bank) && $bank.settBankNo == "CMB")}selected="selected"{pg: /if}>招商银行</option>
                            <option value="BOCM" {pg: if (!empty($bank) && $bank.settBankNo == "BOCM")}selected="selected"{pg: /if}>交通银行</option>
                            <option value="CMBC" {pg: if (!empty($bank) && $bank.settBankNo == "CMBC")}selected="selected"{pg: /if}>民生银行</option>
                            <option value="CNCB" {pg: if (!empty($bank) && $bank.settBankNo == "CNCB")}selected="selected"{pg: /if}>中信银行</option>
                            <option value="CEBB" {pg: if (!empty($bank) && $bank.settBankNo == "CEBB")}selected="selected"{pg: /if}>光大银行</option>
                            <option value="CIB" {pg: if (!empty($bank) && $bank.settBankNo == "CIB")}selected="selected"{pg: /if}>兴业银行</option>
                            <option value="BOB" {pg: if (!empty($bank) && $bank.settBankNo == "BOB")}selected="selected"{pg: /if}>北京银行</option>
                            <option value="GDB" {pg: if (!empty($bank) && $bank.settBankNo == "GDB")}selected="selected"{pg: /if}>广发银行</option>
                            <option value="HXB" {pg: if (!empty($bank) && $bank.settBankNo == "HXB")}selected="selected"{pg: /if}>华夏银行</option>
                            <option value="PSBC" {pg: if (!empty($bank) && $bank.settBankNo == "PSBC")}selected="selected"{pg: /if}>邮储银行</option>
                            <option value="SPDB" {pg: if (!empty($bank) && $bank.settBankNo == "SPDB")}selected="selected"{pg: /if}>浦发银行</option>
                            <option value="PAB" {pg: if (!empty($bank) && $bank.settBankNo == "PAB")}selected="selected"{pg: /if}>平安银行</option>
                            <option value="BOS" {pg: if (!empty($bank) && $bank.settBankNo == "BOS")}selected="selected"{pg: /if}>上海银行</option>
                            <option value="BOHC" {pg: if (!empty($bank) && $bank.settBankNo == "BOHC")}selected="selected"{pg: /if}>渤海银行</option>
                            <option value="BOJ" {pg: if (!empty($bank) && $bank.settBankNo == "BOJ")}selected="selected"{pg: /if}>江苏银行</option>
                            <option value="" {pg: if (!empty($bank) && $bank.settBankNo == "")}selected="selected"{pg: /if}>其他银行</option>
                        </select>
                    </div>
                    <div>
                        <label><i>*</i>银行卡号：</label>
                        <input type="text" name="acctNo" required="" onkeyup="this.value  = this.value.replace(/\D/g,'');" value="{pg: $bank.acctNo}"/>
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
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/iCheck/icheck.min.js"></script>
</html>