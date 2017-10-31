<!DOCTYPE html>
<html>
<head>
<title><?php if($cf=='card'){ ?>幻灯片设置<?php }else{ ?>导航设置<?php } ?></title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/card_control.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/basic.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<script src="<?php echo $this->RlStaticResource;?>js/layer/layer.min.js" type="text/javascript"></script>
<style type="text/css">
#dataselect .input-group-btn,#ym-select .input-group-btn{width: 12%;}
#dataselect .input-sm ,#ym-select .input-sm{ border-radius: 7px; height:40px;}
#dataselect .btn-primary ,#ym-select .btn-primary{ margin-left: 20px; border-radius:4px;margin-bottom: 0px;}
#dataselect .input-group-addon,#ym-select .input-group-addon{border-radius: 7px;}
.ibox-content{ min-height:800px;}
.dropz .dz-image-preview{display:none;}
#js_icon_preview{width: 100%;}
</style>
<!-- Data picker -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
</head>
<body>
	<div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
		<div id="page-wrapper" class="gray-bg">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
			<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2><?php if($cf=='card'){ ?>幻灯片设置<?php }else{ ?>导航设置<?php } ?></h2>
                    <ol class="breadcrumb">
                        <li><a>User</a></li>
                        <li><a>merchant</a></li>
                        <li class="active"><strong>addmenu</strong></li>
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
				                        	<h3 class="title"><?php if($cf=='card'){ ?>幻灯片信息<?php }else{ ?>导航信息<?php }?> </h3> 
				                        	<div class="hr-line-dashed"></div>
				                            <form class="form-horizontal" method="POST" novalidate="novalidate" action="?m=User&c=merchant&a=addmenu" id="js_editform">
				                            <input type="hidden" name="id" value="<?php echo $menu['id']; ?>" />
											<input type="hidden" name="cf" value="<?php echo $cf; ?>" />
				                                <div class="form-group">
				                                	<label class="col-sm-1 control-label"><?php if($cf=='card'){?>幻灯片标题<?php }else{?>菜单名称<?php }?></label>
				                                    <div class="col-sm-2"><input type="text" class="form-control" name="name" id="name" value="<?php echo $menu['name']; ?>" /></div>
				                                </div>
				                                <div class="hr-line-dashed"></div>
				                                
				                                <div class="form-group">
				                                	<label class="col-sm-1 control-label">外链</label>
													<div class="col-sm-4">
														<div class="input-group">
															<input type="text" class="form-control externalLink" name="url" id="url" value="<?php echo htmlspecialchars_decode($menu['url']); ?>">
															<?php if($this->merchant['source']==1){?>
															<span class="input-group-btn"> 
																<button type="button" class="btn btn-primary" onClick="addLink();">从功能库添加</button> 
															</span>
															<?php }?>
														</div>
													</div>
												</div>
				                                <div class="hr-line-dashed"></div>
				                                
												<div class="form-group"> 
													<label class="col-sm-1 control-label"><?php if($cf=='card'){?>图片<?php }else{?>图标<?php }?></label>
													<div class="col-sm-2 ">
														<div class="dropz" id="icon" style="height: 34px;line-height: 34px;border: 1px solid #e5e6e7;width: 80px;text-align: center;cursor: pointer; display: inline-block; background-color: #fff;">上传</div>
														<p class="text-muted" style="padding-top: 10px;">
														<?php if($cf=='card'){ ?>
														建议上传在450*280图片
														<?php }else{?>
														建议上传在80*80以内的透明png图标
														<?php }?>
														</p>
													</div>
													<input type="hidden" id="js_icon_url" name="icon" value="<?php echo $menu['icon']; ?>"/> 
													<div class="col-sm-2" id="show-img" <?php if(empty($menu) || empty($menu['icon'])) echo 'style="display:none;"'?>>
														<img src="<?php echo $menu['icon']; ?>" id="js_icon_preview" />
													</div>
												</div>
				                                <div class="hr-line-dashed"></div>
				                                
												<div class="form-group"> 
													<label class="col-sm-1 control-label">显示状态</label>
													<div class="col-sm-4">
													<div class="radio radio-info radio-inline">
			                                            <input type="radio" id="show" value="0" name="is_hide" <?php if ($menu['is_hide'] == 0) echo 'checked'; ?>>
			                                            <label for="show">显示</label>
			                                        </div>
													<div class="radio radio-info radio-inline">
			                                            <input type="radio" id="hide" value="1" name="is_hide" <?php if ($menu['is_hide'] == 1) echo 'checked'; ?>>
			                                            <label for="hide">隐藏</label>
			                                        </div>
			                                        </div>
												</div>
				                                <div class="hr-line-dashed"></div>
				                                
				                                <div class="form-group">
				                                	<label class="col-sm-1 control-label">显示顺序</label>
				                                    <div class="col-sm-1"><input type="text" class="form-control" name="sort" id="sort" value="<?php echo $menu['sort']; ?>" /></div>
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
			<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
	</div>
	<!-- DROPZONE -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/dropzone/dropzone.js"></script>
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
	$("#icon").dropzone({
		url: "?m=User&c=merchant&a=uploadIcon",
		addRemoveLinks: false,
		maxFilesize: 1,
		acceptedFiles: ".jpg,.png",
		uploadMultiple: false,
		init: function() {
			this.on("success", function(file,responseText) {
				var rept = $.parseJSON(responseText);
				if (!rept.error) {
					$('#js_icon_preview').attr('src', rept.icon);
					$('#js_icon_url').val(rept.icon);
					$('#show-img').show();
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
	
	$('#submit_apply').click(function(){
		var sort = parseInt($('#sort').val());
		if (sort > 10000) {
			swal("提示", '请将排序值填写为小于10000的正整数', "error");
			return false;
		}
		$.ajax({
			url:$('#js_editform').attr('action'),
			type:"post",
			data:$('form').serialize(),
			dataType:"JSON",
			success:function(ret){
				if(!ret.errcode){
					swal({
						  title: "<?php if($cf=='card'){ ?>幻灯片设置<?php }else{ ?>导航设置<?php }?>",
						  text: "<?php if($cf=='card'){ ?>幻灯片设置成功<?php }else{ ?>导航设置成功<?php }?>",
						  type: "success",
						  closeOnConfirm: false
						 },function(){
							location.href = '?m=User&c=merchant&a=menu&cf=<?php echo $cf;?>';
						});
				} else {
					swal("<?php if($cf=='card'){ ?>幻灯片设置失败！<?php }else{ ?>导航设置失败！<?php }?>", ret.errmsg, "error");
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

var user_host = '<?php echo $host_url;?>', token = '<?php echo $this->merchant['thirduserid'];?>';
function addLink(){
	$.layer({
        type : 2,
        title: '插入功能库链接',
        shadeClose: true,
        maxmin: true,
        fix : false,  
        area: ['600px','450px'],
       	iframe: {
            src : '?m=User&c=link&a=index&url='+encodeURIComponent(user_host)+'&token='+token
        }
    });
}

</script>
</body>
</html>