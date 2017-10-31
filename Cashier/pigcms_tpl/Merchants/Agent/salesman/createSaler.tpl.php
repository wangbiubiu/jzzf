
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>收银台|创建业务员</title>
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>


    <!-- FooTable -->
    <link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
	<style>
		.ibox{
		 	border: 1px solid #e7eaec;
		}
		.part_item {
  			background: none repeat scroll 0 0 #fff;
  			border: 1px solid #ccc;
  			border-radius: 5px;
  			padding-bottom: 15px;
  			margin-bottom: 10px;
		}
		.form .part_item p {
  			display: inline-block;
  			font-size: 14px;
  			overflow: hidden;
  			padding: 10px 20px 0;
  			text-overflow: ellipsis;
  			white-space: nowrap;
		}
		.part_item_b {
  			border-top: 1px solid #ccc;
  			margin-top: 10px;
		}
		.form .part_item p.active {
  			color: #f87b00;
		}
		.part_item input {
  			font-size: 14px;
  			margin-bottom: 2px;
  			margin-right: 5px;
		}
		.pagination{
			margin:0px;
		}
		.mustInput {
  			color: red;
  			margin-right: 5px;
		}
		@media (min-width: 768px){
			.form .part_item p {
				width: 37%;
			}
		}
		@media (min-width: 992px){
			.form .part_item p {
				width: 24%;
			}
		}
	.form-control, .single-line{width: 50%;}
	
	.ibox {
    border: 1px solid #e7eaec;
    border-top: none;
}

	.tit_h4{ height: 40px; line-height: 40px; padding: 0 20px; width: 100%;margin:0px !important;}
	.tit_h4 span{ color: #676a6c; font-weight: normal;}
	.tit_h4 a{ color: #44b549; font-weight: normal;}
	.jbxi_bg>div{border-top: 1px solid #f2f2f2; padding: 20px 0; margin: 0px !important;float: left; width: 100%;}
	.jbxi_bg>div>label{ width: 100px; text-align: right; float: left; margin-right: 30px;}
	.jbxi_bg>div>div>label{padding-top: 5px;}
	.jbxi_bg>div>div>input{border: none;}
	.form-control{
    width: 80%;
}
.footable-odd {
    background-color: #ffffff;
}
.bc{position: absolute; bottom: -55px; left: 50%; width: 70px; height: 30px; margin-left: -35px; background: #4EBE53; border-radius: 5px; border: none; color: #FFFFFF;}
.shangjia_tit{border-bottom:2px solid #f2f2f2 ; margin-bottom: 0px; padding-left: 20px; background: #FFFFFF; width: 100%; height: 50px; line-height: 50px; text-align: left; border-top:3px solid #d9e6e9 ;font-size: 18px;}

	</style>
</head>

<body>

    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>

        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>业务员列表</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Agent</a>
                        </li>
                        <li>
                            <a>业务员中心</a>
                        </li>
                        <li>
                            <a>业务员列表</a>
                        </li>
                        <li class="active">
                            <strong>添加业务员</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                    	<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：基本信息
                        -->
                        <p class="shangjia_tit">添加业务员</p>
                    	<div class="ibox-content" style="border-top:none;">
                    		
                    		  <div class="panel-body" style="padding: 0px; ">
                                <form class="form-horizontal form-border jbxi_bg clearfix" style="width: 95%; margin: 0 auto 60px; position: relative; border: 1px solid #EEEEEE;" action='?m=Agent&c=salesman&a=createSaler' method="post" >
                                    <div class="form-group clearfix">
                                        <label class="control-label">姓名</label>
                                        <div >
                                            <input type="text" name= 'username' class="form-control" placeholder="输入业务员姓名">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label">用户名</label>
                                        <div>
                                            <input type="text" name= 'account' class="form-control" placeholder="输入用户名">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label">业务员密码</label>
                                        <div>
                                            <input type="password" name= 'password' class="form-control" placeholder="输入业务员密码">                                           
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label">佣金费率%</label>
                                        <div>
                                           <input type="text" name= 'commission' class="form-control" placeholder="分润比">
                                        </div>
                                    </div>
                                  <!--    <div class="form-group clearfix">
                                        <label class=" control-label">微信二清费率%</label>
                                        <div>
                                           <input type="text" name= 'cms_two' class="form-control" placeholder="分润比">
                                        </div>
                                    </div> 
                                     <div class="form-group clearfix">
                                        <label class=" control-label">支付宝费率%</label>
                                        <div>
                                           <input type="text" name= 'alicommission' class="form-control" placeholder="分润比">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label">支付宝二清费率%</label>
                                        <div>
                                           <input type="text" name= 'alicms_two' class="form-control" placeholder="分润比">
                                        </div>
                                    </div> -->
                                    <div class="form-group clearfix">
                                        <label class=" control-label">联系电话</label>
                                        <div>
                                            <input type="text" name= 'phone' class="form-control" placeholder="电话号码">
                                        </div>
                                    </div>
                                    <button class="bc">保存</button>
                                </form>


                            </div>
                    	</div>

                    	<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：end
                        -->
                        
                    </div>
                </div>
            </div>
        </div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
     </div>
    </div>
  
  
	
	<script type="text/html" id="employersEditTpl">
		<figure>
            <iframe width="425" height="349" src="?m=Agent&c=salesman&a=editeSaler&sid=<?php echo $sid;?>" frameborder="0"></iframe>
    </figure>
	</script>

    <!-- FooTable -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all.min.js"></script>
	
	<!-- iCheck -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
	
	<!-- Jquery Validate -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/validate/jquery.validate.min.js"></script>

    <!-- Page-Level Scripts -->

</body>
</html>