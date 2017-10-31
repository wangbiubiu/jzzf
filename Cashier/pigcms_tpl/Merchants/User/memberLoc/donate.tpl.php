<!DOCTYPE html>
<html>
<head>
<title>充值赠送</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/loccard.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
<style type="text/css">

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
                        <li class="active"><strong>充值赠送</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row" style="background-color: #ffffff;">
				<div>
				<div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>充值赠送</h5>
                        </div>
                        <div class="ibox-content">
						<div class="alert alert-warning">
							注意：设置充值区间请不要重叠，以免出现赠送金额不准确。此赠送不会累加<br/>
							即客户充值金额在充值区间内即每次充值赠送一次设置的赠送金额
						 </div>
						    <div class="toleft">
                            <form method="POST" action="/merchants.php?m=User&c=memberLoc&a=donateSet" id="donateSet" class="form-horizontal">	
								<input type="hidden" name="cdid"  value="<?php echo $cardinfo['id'];?>">

								<div class="form-group">
									<label class="collabel control-label">充值赠送区间</label>
                                    <div class="input-group-r">
									最低充值&nbsp;&nbsp; <input type="text" name="minmoney" id="minmoney" value="<?php echo $donateinfo['minmoney'];?>" onkeyup="onlyNumber(this,1)" class="form-control" style="width:100px" > &nbsp;元
									</div>
									<div class="input-group-r" style="margin-left:20px;"><span>最高充值&nbsp;&nbsp; </span>
									<input type="text" name="maxmoney" id="maxmoney" value="<?php echo $donateinfo['maxmoney'];?>" class="form-control" onkeyup="onlyNumber(this)" style="width:100px"> &nbsp;元
									</div>
									<span class="help-block m-b-none" style="margin-left:145px;"> 充值区间不限制请全设置为“0”，如：充值100元及以上赠送10元，设置最低充值为“100”，最高充值为“0” </span>
                                </div>

								<div class="form-group">
									<label class="collabel control-label">赠送金额</label>
                                    <div class="col-sm-4 input-group"><input type="text" name="donatemoney" value="<?php echo $donateinfo['donatemoney'];?>" id="donatemoney" class="form-control" placeholder="设置达到赠送区间赠送的金额" onkeyup="onlyNumber(this)" style="float:none;width:90%"> &nbsp;&nbsp;元
									</div>
                                </div>

                                 <div class="form-group"><label class="collabel control-label">功能状态</label>
                                    <div class="col-sm-4 input-group">
									  <div class="i-checks">
									  <label> <input type="radio" value="0" name="isopen" <?php if($donateinfo['isopen']==0){echo 'checked="checked"';}?> > <i></i> 关闭充值赠送 </label>
									  </div>
                                     <div class="i-checks">
									 <label> <input type="radio"  value="1" name="isopen" <?php if($donateinfo['isopen']==1){echo 'checked="checked"';}?>> <i></i> 开启充值赠送 </label>
									 </div>
									<span class="help-block m-b-none">关闭充值赠送后，充值赠送将不起效果即不会有赠送</span>
                                    </div>
                                </div>

								<div class="form-group">
									<label class="collabel control-label">充值赠送说明</label>
                                    <div class="col-sm-4 input-group">
									<textarea  type="text" name="donateinfo"  class="form-control" style="width: 500px; height: 200px;" placeholder="充值赠送说明（选填）"><?php echo $donateinfo['donateinfo'];?></textarea>
									</div>
                                </div>

                                    <div class="form-group">
                                    <div class="col-lg-offset-2 ">
                                        <a class="btn btn-sm btn-primary asubmit" href="javascript:;"> 保 &nbsp;&nbsp; 存 </a>
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
});
var isSubmit=false;

</script>
<script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/loccard.js" type="text/javascript"></script>
</body>
</html>