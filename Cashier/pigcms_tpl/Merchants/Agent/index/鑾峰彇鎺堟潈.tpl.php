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
.qiye{ width: 800px; margin: 0 auto;  padding:30px;}

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
                    	<h2 style="text-align: center;">获取授权</h2>
                    	<div>	
                    			<div class="clearfix" style="width: 600px; margin: 30px auto;">
                    				<div class="fl"><label><span style="color: red;">*</span>授权lingpai:</label><input type="text" name="" style="width: 200px; height: 30px;"></div>
                    				<div class="fl" style="margin-left: 10px;"><label><span style="color: red;">*</span>ISV返佣ID:</label><input type="text" name="" style="width: 200px; height: 30px;"></div>
                    			</div>
                    					
	                        	<div style="text-align: center; margin-top: 30px; margin-bottom: 30px;">
	                        		<p style="font-size: 14px;">商户扫二维码获取授权,已经授权的自己填写授权</p>
	                        		<p><img src="../Cashier/pigcms_static/image/ewm.png" style="width: 325px; height: 325px;"></p>
	                        		<!--<p style="font-size: 24px; color: #000;">ISV返佣ID授权</p>-->
	                        	</div>
	                        <div>
	                        	<button style="width: 100px; height: 35px; background: #108ee9; margin-left: 40%; border-radius: 5px;color: #ffffff; border: none;">下一步</button>
	                        </div>
                    	</div>
                    </div>
               		</div>
              
                
            </div>
            </div>
    </div>
   <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
   	
</body>
</html>