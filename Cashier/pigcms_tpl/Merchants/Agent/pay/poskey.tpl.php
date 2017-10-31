
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>收银台 | POS机Key</title>
	 <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/basic.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
    <!-- iCheck -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
	<!-- DROPZONE -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/dropzone/dropzone.js"></script>
	<style>
		.ibox-title h5 {
  			margin: 10px 0 0px;
		}
		select.input-sm {
  			height: 35px;
  			line-height: 35px;
		}
		.float-e-margins .btn-info{
			margin-bottom:0px;
			padding:3px;
		}
		.fa-paste{
			margin-right:7px;
			padding: 0px;
		}
		.dz-preview{
			display:none;
		}
	</style>
</head>

<body>

    <div id="wrapper">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>在线支付配置</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>Pay</a>
                        </li>
                        <li class="active">
                            <strong>POS机Key</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	<div class="col-lg-6">
            	    <div class="ibox float-e-margins">
            	        <div class="ibox-title clearfix">
            	            <h5 style="margin: 10px 0 0px;">POS机Key</h5>

            	        </div>
            	        <div class="ibox-content">
						<div class="alert alert-warning">
							温馨提示：
							<strong style="color:green;">如果您有POS需要对接到本系统，请参考我们的POS对接文档来进行开发<br/>这里提供所需的对接 KEY</strong>
						 </div>
							<table class="table table-striped">

								<tr>
								 <td></td>
            	                    <td style="padding-top: 14px;">POS机对接Key</td>
									 <td><button class="btn btn-info " type="button"  data-toggle="modal" data-target="#wxApi_PosKey"><i class="fa fa-paste"></i>点击查看</button></td>
									<td></td>
									<td></td>
								</tr>

            	            </table>
            	        </div>
            	    </div>
            	</div>
            </div>
        </div>
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
    </div>

	<div class="modal inmodal" tabindex="-1"  id="wxApi_PosKey" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				
				<div class="modal-header">
                    <button type="button" class="close _close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">对接POS机Key</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="PosKeyBox">
							<div class="form-group">
								<label>POS机Key：</label>
								<input type="text" placeholder="对接POS机Key" value="<?php echo $keycode;?>" class="form-control wxtoken" readonly="readonly">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-primary _close" data-dismiss="modal">关闭</button>
                </div>
			</div>
		</div>
	</div>
	
    <script>
        $(document).ready(function(){

        });
    </script>

</body>

</html>