<!DOCTYPE html>
<html>
<head>
<title>创建会员通知</title>
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
                        <li class="active"><strong>创建会员通知</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row" style="background-color: #ffffff;">
				<div>
				<div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>创建会员通知</h5>
                        </div>
                        <div class="ibox-content">
						    <div class="toleft">
                            <form method="POST" action="/merchants.php?m=User&c=memberLoc&a=noticeSet" id="noticeSet" class="form-horizontal">	
								<input type="hidden" name="cdid"  value="<?php echo $cardinfo['id'];?>">
								<input type="hidden" name="ntid"  value="<?php echo $noticeTmp['id'];?>">
								<div class="form-group">
									<label class="collabel control-label">通知标题</label>
                                    <div class="col-sm-4 input-group"><input type="text" name="ntitle" value="<?php echo $noticeTmp['ntitle'];?>" id="ntitle" class="form-control" placeholder="填写通知标题">
									</div>
                                </div>

								<div id="dataselect" class="form-group">
									<label class="collabel control-label">截止日期</label>
									<div id="datepicker" class="input-daterange col-sm-4 input-group">
										<input type="text" value="<?php if(isset($noticeTmp['endtime'])) echo date('Y-m-d',$noticeTmp['endtime']);?>" name="endtime" class="form-control" id="endtime" placeholder="截止日期">
									</div>
								</div>

								<div class="form-group">
									<label class="collabel control-label">通知内容</label>
                                    <div class="col-sm-4 input-group">
									<textarea  type="text" name="ncontent"  class="form-control" style="width: 500px; height: 200px;" placeholder="在这里写上通知内容"><?php echo $noticeTmp['ncontent'];?></textarea>
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
	$('#datepicker .form-control').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		format: "yyyy-mm-dd",
		autoclose: true
	});
});
var isSubmit=false;
/******AJAX会员通知********/
$('#noticeSet .asubmit').click(function(){
    if(isSubmit){
	   return false;
	}
   var ntitle=$.trim($('#ntitle').val());

   if(!ntitle){
       swal({title: "温馨提示",text: '通知标题必须填写',type: "error"});
	   return false;
   }
   var endtime=$.trim($('#endtime').val());
   if(!endtime){
       swal({title: "温馨提示",text: '截止日期必须选择填写',type: "error"});
	   return false;
   }

   var thisobj=$(this);
   thisobj.prop('disabled',true);
   isSubmit= true;
   		$.ajax({
			url:$('#noticeSet').attr('action'),
			type:"post",
			data:$('form').serialize(),
			dataType:"JSON",
			success:function(ret){
				if(!ret.error){
				   window.location.href="?m=User&c=memberLoc&a=notice&cdid=<?php echo $cardinfo['id'];?>";
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