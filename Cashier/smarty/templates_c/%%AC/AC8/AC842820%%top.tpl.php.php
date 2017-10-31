<?php /* Smarty version 2.6.18, created on 2016-12-23 20:55:07
         compiled from /phpstudy/www/pay.yunjifu.net/Cashier/./pigcms_tpl/Merchants/System/public/top.tpl.php */ ?>
       <style>.navbar-right{margin-right:0px}
	   .navbar-top-links .dropdown-messages{ width: 250px;height:230px}
	   #myLoginUrlDiv .modal-body{text-align: center;}
	   .navbar{ margin-bottom: 0;}
	   .dropdown-messages-box .media-body{text-align: center;color: #f8ac59; font-size: 15px;}
	   .navbar-header .bgcolor{background-color: #1cb295;border-color: #1cb295;}
	   .navbar-header>ul{ height: 90px; margin-bottom: 0px;}
	   .navbar-header>ul>dl{ float: left; padding: 20px 30px; margin: 0px 10px; text-align: center; height: 100%;}
	   .navbar-header>ul>dl a{ display: inline-block; width: 100%; height: 100%;}
	   .navbar-header>ul>dl a dt{color: #f7fcff;}
	    .navbar-static-top{ background: #008fd3; height: 90px;}
	    .navbar-right{ margin-top: 10px;}
	    .nav_selected{ background: #0082c5;}
	    .nav.navbar-right > li > a {
    color: #ffffff;
}
	   </style>
	   <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation">
        <div class="navbar-header">
            <!--<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>-->
            <ul class="clearfix ">
            
               <dl <?php if(ROUTE_CONTROL !='pay') echo 'class="nav_selected"'; ?>>	
                    <a href="/merchants.php?m=System&c=index&a=index">
	            		<dd><i><img src="./Cashier/pigcms_static/image/icon-cloud.png"></i></dd>
	            		<dt>云收单</dt>
	            	</a>
            	</dl>
            	<!-- <dl>
            		<a href="#">
	            		<dd><i><img src="./Cashier/pigcms_static/image/APP_generate.png"></i></dd>
	            		<dt>APP生成</dt>
	            	</a>
            	</dl> -->
            	
            	<dl <?php if(ROUTE_CONTROL=='pay') echo 'class="nav_selected"'; ?>>
                    <a href="/merchants.php?m=System&c=pay&a=ModifyPwd">
	            		<dd><i><img src="./Cashier/pigcms_static/image/icon-cog.png"></i></dd>
	            		<dt>设置</dt>
            		</a>
            	</dl>
            </ul>
       </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <a  href="?m=System&c=index&a=logout">
                        <i class="fa fa-sign-out"></i> 退出
                    </a>
                </li>
            </ul>
        </nav>
        </div>
		
		
	