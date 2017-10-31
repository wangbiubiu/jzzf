<!DOCTYPE html>
<html>
<head>
<title>创建会员卡卡号</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/loccard.css" rel="stylesheet">
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
                        <li class="active"><strong>创建会员卡卡号</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row" style="background-color: #ffffff;">
				<div>
				<div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>创建会员卡卡号</h5>
                        </div>
                        <div class="ibox-content">
						<?php if(!empty($lastnum)){?>
						<div class="alert alert-warning" style="margin-left:45px;">
						   您上次生成的卡号最后一条是 <?php echo $lastnum['numstr'];?> 再次生成时请注意卡号取值范围的起始卡号的取值<br/><span style="color:red;">如果保持前缀 <font color="green"><?php echo preg_replace('/\d+/','',$lastnum['numstr']);?> </font>不变,那么 这次的起始卡号值应为 <font color="green"><?php $lastnum=preg_replace('/[a-zA-Z]+/','',$lastnum['numstr']); echo $lastnum+1;?></font></span>

						 </div>
						 <?php }?>
						    <div class="toleft">
                            <form method="POST" action="/merchants.php?m=User&c=memberLoc&a=createCnumSet&cdid=<?php echo $cardinfo['id'];?>" id="createCnumSet" class="form-horizontal" name="numform">	
								<input type="hidden" name="cdid"  value="<?php echo $cardinfo['id'];?>">
								<div class="form-group">
									<label class="collabel control-label">会员卡英文前缀</label>
                                    <div class="col-sm-4 input-group"><input type="text" name="numprefix" value="" id="numprefix" class="form-control" placeholder="VIP" onkeyup="onlyLetter(this,7)"> <span class="help-block m-b-none" style="margin-top:38px;">例：VIP100000001  &nbsp;VIP就是英文编号，7个字符以内</span>
									</div>
                                </div>

								<div class="form-group">
									<label class="collabel control-label">卡号取值范围</label>
                                    <div class="input-group-r">
									起始卡号&nbsp; <input type="text" name="numstart" value="" onkeyup="onlyNumber(this)" class="form-control" style="width:200px" id="numstart" placeholder="例如 100000001"> &nbsp;到
									</div>
									<div class="input-group-r" style="margin-left: 30px">
									<input type="text" name="numend" id="numend" value="" class="form-control" onkeyup="onlyNumber(this)" style="width:200px" placeholder="例如 100000300"> &nbsp;结束卡号
									</div>
								     <span class="help-block m-b-none" style="margin-left:143px;"><font color="red">最小起始卡为:1,最大结束卡号为:999999999,例如输入100000001到100000300那么就会创建300张会员卡<font></span>
                                </div>

								<div class="form-group">
									 <div class="alert alert-warning" style="margin-left:45px;">会员卡生成说明  ： <font color="red">每次最多生成300张</font></div>
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
	
<script type="text/javascript">
$(document).ready(function() { 

});
</script>
<script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/loccard.js" type="text/javascript"></script>
</body>
</html>