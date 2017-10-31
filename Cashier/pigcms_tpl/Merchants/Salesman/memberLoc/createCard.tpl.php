<!DOCTYPE html>
<html>
<head>
<title>创建会员卡</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/loccard.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/basic.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
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
                        <li class="active"><strong>创建会员卡</strong></li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row" style="background-color: #ffffff;">
				<div>
				<div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>会员卡版面设置</h5>
                        </div>
                        <div class="ibox-content">
						    <div class="toleft">
                            <form method="POST" action="/merchants.php?m=User&c=memberLoc&a=createCarding" id="createCardform" class="form-horizontal">	
								<input type="hidden" name="cdid"  value="<?php echo $cardinfo['id'];?>">
								<div class="form-group">
									<label class="collabel control-label">会员卡的名称</label>
                                    <div class="col-sm-4 input-group"><input type="text" name="cardname" value="<?php echo $cardinfo['cardname'];?>" id="cardname" class="form-control" placeholder="会员卡的名称（必填）" onkeyup="DivFollowingText(this)">
									</div>

									<div class="input-group-r"><span>颜色：</span>
									<input type="text" name="vipnamecolor" id="vipnamecolor" value="<?php echo $cardinfo['vipnamecolor'];?>" class="form-control color" style="width: 90px;  color: rgb(255, 255, 255);" onblur="changeCardColor('vipnamecolor','vipname')">
									</div>
                                </div>
                                 <div class="form-group"><label class="collabel control-label">最低积分要求</label>
                                    <div class="col-sm-4 input-group"><input  type="text" name="miniscore" id="miniscore" value="<?php echo $cardinfo['miniscore'];?>" class="form-control" onkeyup="onlyNumber(this)"> <span class="help-block m-b-none">只有到达(含)这个积分后才可以申领此卡（0或者不填即无领取门槛）</span>
                                    </div>
                                </div>
                                <div class="form-group"><label class="collabel control-label">会员卡LOGO</label>
                                    <div class="col-sm-4 input-group">
									<input type="text" name="mclogo" id="membercardlogo" value="<?php echo $cardinfo['mclogo'];?>" class="form-control">
									</div>
									<div onclick="showImgXg('membercardlogo','cardlogo');" value="显示效果" class="input-group-r dbutton">显示效果</div>&nbsp;&nbsp;
									<div class="dropz1 input-group-r dbutton">上传LOGO</div>
                                </div>
								<div class="form-group">
									<label class="collabel control-label">会员卡面风格</label>
                                    <div class="col-sm-4 input-group">
									<select name="bgstyle" class="form-control valid" onchange="changebgStyle(this.value)" aria-invalid="false">
										 <option value='<?php echo $locimgpath; ?>/pigcms_static/image/cardbg/nocardbg.png'>请选择会员卡背景图</option>
										<?php 
										for($i=1;$i<=23;$i++){
											$istr=$i<10 ? '0'.$i:$i;
											$str=$locimgpath.'/pigcms_static/image/cardbg/card_bg'.$istr.'.png';
											if($cardinfo['bgstyle']==$str){
												echo $str='<option value="'.$str.'" selected="selected" >'.$istr.'</option>';
											}elseif($i==5){
											    echo $str='<option value="'.$str.'" selected="selected">'.$istr.'</option>';
											}else{
												echo $str='<option value="'.$str.'">'.$istr.'</option>';
											}
										}
									?>
								  	</select>
									</div>
									<div class="input-group-r"><span>卡号文字颜色：</span>
									<input type="text" name="numbercolor" id="numbercolor" value="<?php echo $cardinfo['numbercolor'];?>" class="form-control color" style="width: 90px;  color: rgb(255, 255, 255);" onblur="changeCardColor('numbercolor','number')" >
									</div>

                                </div>

								<div class="form-group"><label class="collabel control-label">自己设计卡面背景</label>
                                    <div class="col-sm-4 input-group">
									<input type="text" name="diybg" id="membercardbg" value="<?php echo $cardinfo['diybg'];?>" class="form-control">
									<input type="hidden" name="isdiybg" id="isdiybg" value="0">
									</div>
									<div onclick="showImgXg('membercardbg','cardbg');" value="显示效果" class="input-group-r dbutton">显示效果</div>&nbsp;&nbsp;
									<div class="dropz2 input-group-r dbutton" style="width: 100px;">上传卡面背景</div>
                                </div>
								<div class="form-group">
									<label class="collabel control-label">首页提示文字</label>
                                    <div class="col-sm-4 input-group"><input type="text" name="tipmsg" value="<?php echo $cardinfo['tipmsg'];?>" id="tipmsg" class="form-control" placeholder="首页提示文字">
									<span class="help-block m-b-none">请不要超过20个字</span>
									</div>
                                </div>

                                 <div class="form-group"><label class="collabel control-label">开启充值赠送</label>
                                    <div class="col-sm-4 input-group">
									  <div class="i-checks">
									  <label> <input type="radio" value="0" name="isdonate" <?php if($cardinfo['isdonate']==0){echo 'checked="checked"';}?> > <i></i> 关 闭 </label>
									  </div>
                                     <div class="i-checks">
									 <label> <input type="radio"  value="1" name="isdonate" <?php if($cardinfo['isdonate']==1){echo 'checked="checked"';}?>> <i></i> 开 启 </label>
									 </div>
									<span class="help-block m-b-none">开启充值赠送后，可设置充值赠送选项</span>
                                    </div>
                                </div>

                                 <div class="form-group"><label class="collabel control-label">是否短信验证</label>
                                    <div class="col-sm-4 input-group">
									  <div class="i-checks">
									  <label> <input type="radio" value="0" name="ischeck" <?php if(empty($cardinfo) || $cardinfo['ischeck']==0){echo 'checked="checked"';}?> > <i></i> 不验证</label>
									  </div>
									 <?php if($issms_config){?>
                                     <div class="i-checks">
									 <label> <input type="radio"  value="1" name="ischeck" <?php if($cardinfo['ischeck']==1){echo 'checked="checked"';}?> > <i></i> 需验证 </label>
									 </div>
									<span class="help-block m-b-none">选择后，用户领取会员卡时则必须验证，注：使用此功能必须购买短信服务</span>
									 <?php }else{?>
									<span class="help-block m-b-none" style="color:#F9652F">您还没有购买短信服务，或者还没有在总后台配置短信服务相关配置，暂时不能使用短信验证功能</span>
									 <?php }?>
                                    </div>
                                </div>
								<div class="form-group">
									<label class="collabel control-label">会员卡使用说明</label>
                                    <div class="col-sm-4 input-group">
									<textarea  type="text" name="cardinfo"  class="form-control" style="width: 500px; height: 200px;" placeholder="会员卡使用说明"><?php echo $cardinfo['cardinfo'];?></textarea>
									</div>
                                </div>

								<label class="control-label" style="color:#0A700F;">积分设置：</label>
								<hr/>
								<div class="form-group">
									<label class="collabel control-label">积分设置</label>
                                    <div class="input-group-r">
									每天签到奖励&nbsp; <input type="text" name="everyday" value="<?php echo $cardinfo['everyday'];?>" onkeyup="onlyNumber(this)" class="form-control" style="width:70px" > &nbsp;积分
									</div>
									<div class="input-group-r" style="margin-left: 30px"><span>消费1元奖励&nbsp; </span>
									<input type="text" name="xreward" value="<?php echo $cardinfo['xreward'];?>" class="form-control" onkeyup="onlyNumber(this)" style="width:70px"> &nbsp;积分
									</div>

                                </div>

								<div class="form-group">
									<label class="collabel control-label">积分规则简要说明</label>
                                    <div class="col-sm-4 input-group">
									<textarea  type="text" name="integralrule"  class="form-control" style="width: 500px; height: 200px;" placeholder="填写上简要的积分规则说明"><?php echo $cardinfo['integralrule'];?></textarea>
									</div>
                                </div>
								<hr/>
								<label class="control-label" style="color:#0A700F;">会员额外特殊福利说明：</label>
								<hr/>
								<div class="form-group">
									<label class="collabel control-label">会员特殊福利标题</label>
                                    <div class="col-sm-4 input-group">
										<input type="text" name="welfaretitle"  value="<?php echo $cardinfo['welfaretitle'];?>" class="form-control" placeholder="会员特殊福利标题（选填）">
									</div>
                                </div>
								<div class="form-group">
									<label class="collabel control-label">会员特殊福利说明</label>
                                    <div class="col-sm-4 input-group">
									<textarea  type="text" name="welfareinfo"  class="form-control" style="width: 500px; height: 200px;" placeholder="会员特殊福利说明（选填）"><?php echo $cardinfo['welfareinfo'];?></textarea>
									</div>
                                </div>
								<hr/>
                                    <div class="form-group">
                                    <div class="col-lg-offset-2 ">
                                        <a class="btn btn-sm btn-primary asubmit" href="javascript:;"><?php if($cardinfo['id']>0){?> 修 &nbsp;&nbsp; 改 <?php }else{?> 保 &nbsp;&nbsp; 存 <?php }?></a>
                                    </div>
                                </div>
                            </form>
							</div>
							
							<div class="toright">
							   	<div class="vipcard">
								<img id="cardbg" src="<?php echo $cardinfo['diybg'];?>">
								<img id="cardlogo" class="logo" src="<?php echo $cardinfo['mclogo'];?>">
								<h1 id="vipname" style="color:<?php echo $cardinfo['vipnamecolor'];?>"><?php echo $cardinfo['cardname'];?>会员卡</h1>
								<strong class="pdo verify" id="number" style="color:<?php echo $cardinfo['numbercolor'];?>"><span><em>会员卡号</em>6537 1998</span></strong>
							</div>
							<span class="red">Logo宽370px高170px，背景图宽534px高318px，<br/>图片类型png。<a href="<?php echo $this->ResourceUrl.'/upload/memcard/template.rar'?>" class="green">请下载模板</a></span>
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
<script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>js/scolor/jscolor.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() { 

	$(".dropz1").dropzone({
		url: "?m=User&c=wxCoupon&a=uploadImg&cf=1",
		addRemoveLinks: false,
		maxFilesize: 1,
		acceptedFiles: ".jpg,.png",
		uploadMultiple: false,
		init: function() {
			this.on("success", function(file,responseText) {
				var rept = $.parseJSON(responseText);
								/***这里的this.element 是 $(".dropz")****/
				if (!rept.error) {
					$('.dropz1 .dz-image-preview').remove();
					if(rept.localimg.charAt(0)=='.'){
					   rept.localimg=rept.localimg.substring(1);
					}
					$('#cardlogo').attr('src',rept.localimg);
					$('#membercardlogo').val(rept.localimg);
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

	$(".dropz2").dropzone({
		url: "?m=User&c=wxCoupon&a=uploadImg&cf=2",
		addRemoveLinks: false,
		maxFilesize: 1,
		acceptedFiles: ".jpg,.png",
		uploadMultiple: false,
		init: function() {
			this.on("success", function(file,responseText) {
				var rept = $.parseJSON(responseText);
								/***这里的this.element 是 $(".dropz")****/
				if (!rept.error) {
					$('.dropz1 .dz-image-preview').remove();
					if(rept.localimg.charAt(0)=='.'){
					   rept.localimg=rept.localimg.substring(1);
					}
					$('#cardbg').attr('src',rept.localimg);
					$('#membercardbg').val(rept.localimg);
					$('#isdiybg').val('1');
					
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