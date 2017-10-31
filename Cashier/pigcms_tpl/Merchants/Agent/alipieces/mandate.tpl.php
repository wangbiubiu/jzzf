<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>代理商|首页</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
    
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


ul li{ list-style: none;}
a{text-decoration: none;}
.diyi{ width: 400px; margin: 0px auto; text-align: center; padding: 60px 0;}
.diyi>p{ margin:30px 0;}
.diyi>p>select{ width: 70%; margin: 0 15%; height: 40px;}
.diyi>a{ display: block;width:70%; margin: 0 15%; background: #108EE9; color: #ffffff; height: 40px; line-height: 40px; border-radius: 10px; }
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
                    <div class="diyi">
                    	<h1>欢迎使用云极付支付宝进件</h1>
                    	<p>
                    		<select>
                    			<option>企业</option>
                    			<option>事业单位</option>
                    			<option>社会团队</option>
                    			<option>民办非企业组织</option>
                    			<option>和党政及国家机关</option>
                    			<option>个体工商户</option>
                    		</select>
                    	</p>
                    	<a href="#">下一步</a>
                    </div>
                </div>
                
           
                
            </div>
            </div>
        </div>
   <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
</body>
</html>