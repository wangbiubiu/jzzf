<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>业务员</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	
</head>

<style>
.account_set{ background: #FFFFFF; width: 98%; padding-bottom: 20px;}
.account_set h1{ width: 100%; height: 40px; line-height: 40px; padding:0 20px;
 border-bottom: 1px solid #d9e6e9;
 border-top: 3px solid #edfbfe;
 font-size: 16px;
 margin-bottom: 0px;
 margin-top: 0px;
 }
 .account_set h1 a{ float: right; color: #44b549;}
 .account_set>div{ border: 1px solid #f3f3f3; width: 98%; margin: 20px auto 0;}
 .account_set>div h2{ padding:0 10px; font-size: 12px; margin: 0px; height: 35px; line-height: 35px; background: #f5f5f6;}
 .account_set>div>div>div{height: 50px; line-height: 50px; border-top: 1px solid #f2f2f2; padding-left: 10px; margin-bottom: 0px;}
.account_set>div>div>div>label{ margin-bottom: 0px; width: 60px; margin-left: 20px; text-align: right; margin-right: 10px;}
.account_set>div>div>div>input{ height: 25px;}
.account_set>div>div>div>p>label{margin-bottom: 0px;}
.account_set>div>div>div>p>label input{ height: 25px; margin-left: 10px; margin-right: 10px;}
.account_set>div>div>div>label>input{ height: 25px; margin: 10px;}
</style>
<body>
    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/setupleftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>收银台</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>Pay</a>
                        </li>
                        <li class="active">
                            <strong>账户设置</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
			   <div class="row">
			   	
            </div>
        </div>
    </div>
</div>
   <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
</body>

 <script>
 
</script>
</html>