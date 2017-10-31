<!DOCTYPE html>
<html>
<head>
<title>会员卡设置</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/loccard.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
<script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
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
                        <li class="active"><strong>添加开卡即送</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row" style="background-color: #ffffff;">
				<div>
				<div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>添加开卡即送</h5>
                        </div>
                        <div class="ibox-content">
						    <div class="toleft">
                            <form method="POST" action="/merchants.php?m=User&c=memberLoc&a=savegift" id="savegift" class="form-horizontal">	
								<input type="hidden" name="cdid"  value="<?php echo $cardinfo['id'];?>">
								<div class="form-group">
									<label class="collabel control-label">活动名称</label>
                                    <div class="col-sm-4 input-group"><input type="text" name="gtitle" value="<?php echo $giftsTmp['gtitle'];?>" id="gtitle" class="form-control" placeholder="填写活动名称">
									</div>
                                </div>

								<div id="dataselect" class="form-group">
									<label class="collabel control-label">活动持续时间</label>
									<div id="datepicker2" class="input-daterange col-sm-8">
										<input type="text" value="<?php if(isset($giftsTmp['starttime'])){ echo date('Y-m-d',$giftsTmp['starttime']);}else{ echo date('Y-m-d');}?>" name="starttime" class="form-control" id="starttime" placeholder="开始时间">&nbsp; 到 &nbsp;
										<input type="text" value="<?php if(isset($giftsTmp['endtime'])) echo date('Y-m-d',$giftsTmp['endtime']);?>" name="endtime" class="form-control" id="endtime" placeholder="截止日期">
									</div>
								</div>

								  <div class="form-group"><label class="collabel control-label">赠送类型</label>
                                    <div class="col-sm-4 input-group">
									  <div class="i-checks">
									    <label> <input type="radio" value="0" name="gtype" checked="checked"> <i></i> 积分</label>
									  </div>
                                     <!--<div class="i-checks">
									   <label> <input type="radio"  value="1" name="gifttype"> <i></i> 优惠券 </label>
									 </div>--->
									<span class="help-block m-b-none"></span>
                                    </div>
                                </div>

								<div class="form-group">
									<label class="collabel control-label">赠送积分</label>
                                    <div class="col-sm-4 input-group"><input type="text" name="itemvalue" value="<?php echo $giftsTmp['itemvalue'];?>" id="itemvalue" class="form-control" placeholder="请填上一个整数" onkeyup="value=value.replace(/[^1234567890]+/g,'')">
									</div>
									<div class="input-group-r"><div class="formdiv">分</div></div>
                                </div>
								
								   <div class="form-group"><label class="collabel control-label">状态</label>
										<div class="col-sm-4 input-group">
										  <div class="i-checks">
										  <label> <input type="radio" value="1" name="isopen" <?php if(($giftsTmp['isopen']==1) || empty($giftsTmp)){echo 'checked="checked"';}?> > <i></i> 开启</label>
										  </div>
										 <div class="i-checks">
										 <label> <input type="radio"  value="0" name="isopen" <?php if(!empty($giftsTmp) && ($giftsTmp['isopen']==0)){echo 'checked="checked"';}?> > <i></i> 关闭 </label>
										 </div>
										<span class="help-block m-b-none"></span>
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
	$('#datepicker2 .form-control').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		format: "yyyy-mm-dd",
		autoclose: true
	});
	$('.i-checks').iCheck({
           checkboxClass: 'icheckbox_square-green',
           radioClass: 'iradio_square-green',
      });
});
var isSubmit=false;
/******AJAX会员通知********/
$('#savegift .asubmit').click(function(){
    if(isSubmit){
	   return false;
	}
   var gtitle=$.trim($('#gtitle').val());

   if(!gtitle){
       swal({title: "温馨提示",text: '活动名称必须填写',type: "error"});
	   return false;
   }
   
   var starttime=$.trim($('#starttime').val());
   if(!starttime){
       swal({title: "温馨提示",text: '开始时间必须选择填写',type: "error"});
	   return false;
   }
   var gscore=$.trim($('#itemvalue').val());
   if(!gscore){
       swal({title: "温馨提示",text: '赠送积分必须填写！',type: "error"});
	   return false;
   }
   var thisobj=$(this);
   thisobj.prop('disabled',true);
   isSubmit= true;
   		$.ajax({
			url:$('#savegift').attr('action'),
			type:"post",
			data:$('form').serialize(),
			dataType:"JSON",
			success:function(ret){
				if(!ret.error){
				   window.location.href="?m=User&c=memberLoc&a=index";
				}else{
					thisobj.prop('disabled',false);
					isSubmit= false;
					swal({
					  title: "保存失败！",
					  text: ret.msg,
					  type: "error"
					 }, function () {
					//window.location.reload();
					});
			   }
			}
		});
});
</script>
</body>
</html>