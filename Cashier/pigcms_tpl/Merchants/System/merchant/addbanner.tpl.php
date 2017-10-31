<!DOCTYPE html>
<html>
<head>
<title>管理后台 | 首页幻灯片</title> 
{pg:include file="$tplHome/System/public/header.tpl.php"}
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">

<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/card_control.css" rel="stylesheet">
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/section_card_notification.css" rel="stylesheet">
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dropzone/basic.css" rel="stylesheet">
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dropzone/dropzone.css" rel="stylesheet">
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/datapicker/datepicker3.css" rel="stylesheet">
<style type="text/css">
#dataselect .input-group-btn,#ym-select .input-group-btn{width: 12%;}
#dataselect .input-sm ,#ym-select .input-sm{ border-radius: 7px; height:40px;}
#dataselect .btn-primary ,#ym-select .btn-primary{ margin-left: 20px; border-radius:4px;margin-bottom: 0px;}
#dataselect .input-group-addon,#ym-select .input-group-addon{border-radius: 7px;}
.ibox-content{ min-height:800px;}
.dropz .dz-image-preview{display:none;}
</style>
<!-- Data picker -->
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/datapicker/bootstrap-datepicker.js"></script>
<link href="{pg:$smarty.const.RlStaticResource}plugins/css/iCheck/custom.css" rel="stylesheet">
</head>
<body>
	<div id="wrapper">
		{pg:include file="$tplHome/System/public/leftmenu.tpl.php"}
		<div id="page-wrapper" class="gray-bg">
		{pg:include file="$tplHome/System/public/top.tpl.php"}
			<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>首页幻灯片管理</h2>
                    <ol class="breadcrumb">
                        <li><a>管理后台</a></li>
                        <li><a>首页幻灯片管理</a></li>
                        <li class="active"><strong>首页幻灯片操作</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeIn">
				<div class="row" id="wrapper-content-list">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="row">
				                <div class="col-lg-12">
				                    <div class="ibox float-e-margins">
				                        <div class="ibox-content">
				                        	<h3 class="title">首页幻灯片信息 </h3> 
				                        	<div class="hr-line-dashed"></div>
				                            <form class="form-horizontal" method="POST" novalidate="novalidate" action="?m=System&c=merchant&a=savebanner" id="js_editform">
	 											<input type="hidden" name="id" value="{pg:$banner.id}" />
				                                <div class="form-group">
				                                	<label class="col-sm-1 control-label">首页幻灯片标题</label>
				                                    <div class="col-sm-2"><input type="text" class="form-control" name="title" id="title" value="{pg:$banner.title}" /></div>
				                                </div>
				                                <div class="hr-line-dashed"></div>
				                                
				                                <div class="form-group">
				                                	<label class="col-sm-1 control-label">首页幻灯片外链</label>
				                                	 <span class="tips">以 <strong style="color: red">http://</strong> 开头</span>
													<div class="col-sm-4">
													<input type="text" class="form-control externalLink" name="url" id="url" value="{pg:$banner.url}"> 
														<!--div class="input-group">
															<input type="text" class="form-control externalLink" name="url" id="url" value="{pg:$banner.url}"> 
															<span class="input-group-btn"> 
																<button type="button" class="btn btn-primary" onClick="addLink();">从功能库添加</button> 
															</span>
														</div-->
													</div>
												</div>
				                                <div class="hr-line-dashed"></div>
				                                
												<div class="form-group"> 
													<label class="col-sm-1 control-label">首页幻灯片图标</label>
													<div class="col-sm-2 ">
														<div class="dropz" id="pic" style="height: 34px;line-height: 34px;border: 1px solid #e5e6e7;width: 80px;text-align: center;cursor: pointer; display: inline-block; background-color: #fff;">上传</div>
														<p class="text-muted" style="padding-top: 10px;">建议上传图片(宽640高380)</p>
													</div>
													<input type="hidden" id="js_pic_url" name="pic" value="{pg:$banner.pic}"/> 
													<div class="col-sm-2">
														<img src="{pg:$banner.pic}" id="js_pic_preview" {pg:if !empty($banner.pic)}style="height: 100px; width:200px;"{pg:/if}/>
													</div>
												</div>
				                                <div class="hr-line-dashed"></div>
				                                
				                                <div class="form-group">
				                                	<label class="col-sm-1 control-label">显示顺序</label>
				                                    <div class="col-sm-1"><input type="text" class="form-control" name="sort" id="sort" value="{pg:$banner.sort}" /></div>
				                                    <span class="tips">小于10000的正整数，数字越大排列越前</span>
				                                </div>
				                                <div class="hr-line-dashed"></div>
				                                
				                                <div class="form-group">
				                                    <div class="col-sm-2 col-sm-offset-2">
				                                    	<button id="submit_apply" class="btn btn-primary" style="height: 36px;">确定 </button>
				                                    </div>
				                                </div>
				                            </form>
				                        </div>
				                    </div>
				                </div>
				            </div>
						</div>
                    </div>
                </div>
        	</div>
			{pg:include file="$tplHome/System/public/footer.tpl.php"}
        </div>
	</div>
	<!-- DROPZONE -->
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/dropzone/dropzone.js"></script>
<script src="{pg:$smarty.const.RlStaticResource}plugins/js/iCheck/icheck.min.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
	$("#pic").dropzone({
		url: "?m=System&c=merchant&a=uploadImg",
		addRemoveLinks: false,
		maxFilesize: 1,
		acceptedFiles: ".jpg,.png",
		uploadMultiple: false,
		init: function() {
			this.on("success", function(file,responseText) {
				var rept = $.parseJSON(responseText);
				if (!rept.error) {
					$('#js_pic_preview').attr('src', rept.image_url).css({"height": "100px", "width":"200px"});
					$('#js_pic_url').val(rept.image_url);
				}else{
					swal({
						title: "上传失败",
						text: rept.msg,
						type: "error"
					});
				}
			});
		}
	});
	
	
	var flag = false;
	$('#submit_apply').click(function(){
		if (flag) return false;
		flag = true;
		$.ajax({
			url:$('#js_editform').attr('action'),
			type:"post",
			data:$('form').serialize(),
			dataType:"JSON",
			success:function(ret){
				flag = false;
				if(!ret.errcode){
					swal({
						  title: "幻灯片操作",
						  text: '保存成功',
						  type: "success",
						  closeOnConfirm: false
						 },function(){
							location.href='?m=System&c=merchant&a=banner';
						});
				} else {
					swal("保存失败！", ret.errmsg, "error");
			   }
			}
		});
		return false;
	});
	
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});
});
</script>
</body>
</html>