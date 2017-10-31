<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>代理商|首页</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
        <link   href="http://cashier.b0.upaiyun.com/pigcms_static/plugins/css/datapicker/datepicker3.css" rel="stylesheet">
<!--<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>-->
<!-- Data picker -->
<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
</head>
<style>
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
.fl{ float: left;}
ul li{ list-style: none;}
a{text-decoration: none;}
.qiye{ width: 1080px; margin: 0 auto;  padding:30px;}
.qiye>p>label{ color: #929292;}
.qiye>p>span{ display: inline-block; width: 150px; height: 2px; background: #f3f3f3;}
.qiye>p>label>i{ display: inline-block; font-style: inherit; margin-right: 10px; width: 30px; height: 30px; border-radius: 50%; border: 1px solid #f3f3f3; text-align: center; line-height: 30px;}
.qiye>p>label>i,.qiye>p>label>span{ background: #1483D8;color: #fff; }
.qiye>p>label{ color: #333333;}
</style>
<body>
    <div id="wrapper">
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>首页</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Agent</a>
                        </li>
                        <li>
                            <a>Index</a>
                        </li>
                        <li class="active">
                            <strong>首页</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight" >
                <div style="background: #FFFFFF; width: 100%; padding-bottom: 30px;">
                    <div class="qiye">
                    	<p>
                    		<label><i>1</i>填写商家信息</label>
                    		<span></span>
                    		<label><i>2</i>填写银行信息</label>
                    		<span></span>
                    		<label><i>3</i>填写经营信息</label>
                    		<span></span>
                    		<label><i>4</i>提交成功</label>
                    	</p>
                    	<p style="text-align: center; margin-top: 50px;"><img src="./Cashier/pigcms_static/image/wancheng.png"</p>
                    	<p style="text-align: center; font-size: 24px; color: #1E1B29;">提交成功</p>
                    	<div style="text-align: center;">商户资料已提交,将在<span style="color: #F89406; font-size: 18px;">3个</span>工作日内审核完成结果将发送到联系人的手机或邮箱</div>
                    	<p style="width: 120px; height: 35px; border: 1px solid #f3f3f3; border-radius: 5px; margin: 50px auto 0;">
                    		<a href="#" style="width: 100%; height: 100%; color: #333333; text-align: center; display: block; line-height: 35px;">我知道了</a>
                    	</p>
                    </div>
               	</div>
            </div>
        </div>
    </div>
   <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
   	
</body>
</html>