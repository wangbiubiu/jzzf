<!DOCTYPE html>
<html>
<head>
<title>会员卡设置</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/loccard.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
<style type="text/css">
.green{color:green}
.red{color:red}
</style>
</head>
<body>
	<div id="wrapper">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
		<div id="page-wrapper" class="gray-bg">
			<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
			<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>本站会员卡</h2>
                    <ol class="breadcrumb">
                        <li><a>User</a></li>
                        <li><a>memberLoc</a></li>
                        <li class="active"><strong>本地会员卡和微信会员卡积分同步设置</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row" style="background-color: #ffffff;">
				<div>
				<div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>本地会员卡和微信会员卡积分同步设置</h5>
                        </div>
                        <div class="ibox-content">
						<!--<div class="alert alert-warning" style="margin-left:45px;">

						 </div>--->
					
						    <div class="toleft">
							<?php if(!empty($msgtip)){?>
								<div class="alert alert-danger" style="margin-left:45px;">
								   <?php echo $msgtip;?>
								 </div>
						    <?php }?>
                            <form method="POST" action="" id="wxCardSync" class="form-horizontal" name="syncform">	
								<div class="form-group">
                                    <div style="margin-left:20px;">
										<label class="control-label" style="margin-left:5px;">您当前微信会员卡状态：<span >标题：<span class="green"><?php echo $wxvipCard['card_title'];?></span>&nbsp;&nbsp;&nbsp;&nbsp;
										<span >状态：<?php if($wxvipCard['status']==1){?>
													<span class="green">已审核</span>
													<?php }elseif($wxvipCard['status']==2){?>
													<span class="red">审核不通过</span>
													<?php }else{?>
													<span>审核中</span>
													<?php }?>

										</span>
										</label>
									</div>
                                </div>

                                 <div class="form-group">
								 <label class="collabel control-label">是否开启本站会员卡与微信会员卡</label>
                                    <div class="col-sm-4 input-group" style="margin-left:20px;">
									  <div class="i-checks">
									  <label> <input type="radio" value="1" name="issync" <?php if($locmbsync['issync']==1){echo 'checked="checked"';}?> > <i></i> 开启积分同步 </label>
									  </div>
                                     <div class="i-checks">
									 <label> <input type="radio"  value="0" name="issync" <?php if($locmbsync['issync']==0){echo 'checked="checked"';}?>> <i></i> 关闭积分同步 </label>
									 </div>
									<div class="alert alert-warning">开启后：如果客户既领取本站会员卡又领取了本站创建的微信会员卡，系统将根据客户的openid来同步两张卡上的积分，原则上按最多积分原则来同步积分，<font color="red">但是在后台可以不按原则随意更改</font></div>
                                    </div>
                                </div>

                                    <div class="form-group">
                                    <div class="col-lg-offset-2 ">
                                        <a class="btn btn-sm btn-primary asubmit" href="javascript:;"> 保 &nbsp; 存 &nbsp; 设 &nbsp; 置  </a>
                                    </div>
                                </div>
                            </form>
							</div>
							
                        </div>
						</div>
                    </div>
					</div>
				
        	</div>
			<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
	</div>
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
	$('.i-checks').iCheck({
               checkboxClass: 'icheckbox_square-green',
               radioClass: 'iradio_square-green',
         });
    $('#wxCardSync .asubmit').click(function(){
	    document.syncform.submit();
	});
	
});
</script>
<script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/loccard.js" type="text/javascript"></script>
</body>
</html>