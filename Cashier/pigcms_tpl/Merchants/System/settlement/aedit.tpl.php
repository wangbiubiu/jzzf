<!DOCTYPE html>
<html>
<head>
    <title>补单处理</title>
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
        .payment_allocation>div>form{ margin-bottom: 20px;}
        .payment_allocation>div>form:nth-child(2){ margin-bottom: 60px;}
        .payment_allocation>div>form>h2{ height: 40px; line-height: 40px; font-size: 16px; font-weight: normal; background: #f2f2f2; margin-top: 0px; margin-bottom: 0px; padding-left: 20px;}
        .payment_allocation>div>form>div{border-top: 1px solid #f2f2f2; height: 50px; line-height: 50px;}
        .payment_allocation>div>form>div>input{ height: 25px; line-height: 25px;}
        .payment_allocation>div>form>div>input:nth-child(3){margin-top: 3px; border: none; border-radius: 2px; color: #FFFFFF; background: #3E94DB;}
        .payment_allocation>div>form>input{height: 30px; line-height: 30px; position: absolute; bottom: -50px; left: 50%; margin-left: -35px;border: none; border-radius: 2px; color: #FFFFFF; background: #3E94DB;}
        .payment_allocation>div>form>div>label{ display: inline-block; width: 100px; text-align: right; margin-right: 10px;}
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
                <h2>结算处理</h2>
                <ol class="breadcrumb">
                    <li>
                        <a>
                            User
                        </a>
                    </li>

                    <li class="active">
                        <strong>结算处理</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2"></div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight" >
            <div class="row payment_allocation">
                <h1>结算处理 </h1>
                <div>
                    <form action="merchants.php?m=System&c=settlement&a=aettx" method="post">
                        <input type="hidden" value="{pg:$bank.id}" name="id"/>
                        <h2>记录冲正</h2>
                        <div>
                            <label>代理商ID</label>
                            <input type="text" id="or"  placeholder="" value="{pg:$bank.aid}" readonly="readonly"/>
                        </div>
                        <div>
                            <label>代理商名称</label>
                            <input type="text" id="or"  placeholder="" value="{pg:$bank.name}" readonly="readonly"/>
                        </div>
                        <div>
                            <label>收款流水</label>
                            <input type="text" id="or"  placeholder="" value="{pg:$bank.count_turnover}" readonly="readonly"/>
                        </div>
                        <div>
                            <label>提现佣金</label>
                            <input type="text" id="or"  placeholder="" value="{pg:$bank.count_deposit}" name="money"/>
                            <input type="submit" value="确认修改">
                        </div>
                    </form>

                </div>
            </div>

            <!--
                作者：2721190987@qq.com
                时间：2016-10-25
                描述：二维码弹出框
            -->


        </div>
    </div>
</div>
</div>


</body>
<!-- iCheck -->
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/iCheck/icheck.min.js"></script>
</html>