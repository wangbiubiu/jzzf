<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>门店统计</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
<link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
	

	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>merchant/store_mangecss.css" rel="stylesheet">
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>merchant/baseshop.css" rel="stylesheet">
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>merchant/widget_add_img.css" rel="stylesheet">
	
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/basic.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">

<style>
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
	<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
<!-- Data picker -->
	<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all2.min.js"></script>
</head>

<style>
.ibox-title h5 {
	margin: 10px 0 0px;
}

select.input-sm {
	height: 35px;
	line-height: 35px;
}

.float-e-margins .btn-info {
	margin-bottom: 0px;
}

.fa-paste {
	margin-right: 7px;
	padding: 0px;
}

.dz-preview {
	display: none;
}

.ibox-title ul {
	list-style: outside none none !important;
	margin: 0 0 0 10px;
	padding: 0;
}

.ibox-title li {
	float: left;
	width: 15%;
}

#commonpage {
	float: right;
	margin-bottom: 10px;
}

#table-list-body .btn-st {
	background-color: #337ab7;
	border-color: #2e6da4;
	cursor: auto;
}

#select_Cardtype .i-checks label {
	cursor: pointer;
}

#ewmPopDiv .modal-body {
	text-align: center;
}

.modal-footer {
	text-align: center;
}

.modal-footer .btn {
	padding: 7px 30px;
}

.js_modify_quantity .fa {
	margin-left: 10px;
}

#ewmPopDiv .downewm {
	font-size: 14px;
	padding: 15px;
	text-align: center;
}

.modal-body {
	padding: 20px 30px 15px;
}

#select_Cardtype p {
	margin-bottom: 8px;
}
.img_upload_preview_box p{margin:0px;}

.clearfix:after {
	height: 0;
	content: " ";
	display: block;
	overflow: hidden;
	clear: both;
}
.clearfix {
	zoom: 1;/*IE低版本浏览器不支持after伪类所以要加这一句*/
}
.bankCardInfor{
	 background: #FFFFFF;
}
.bankCardInfor>h2{
	font-size: 18px; font-weight: normal; padding: 10px 20px; border-top: 3px solid #6DBFFF;
	border-bottom: 1px solid #f3f3f3;
}
.bankCardInfor>form{
	 width: 90%;
	 border: 1px solid #f3f3f3;
	 margin: 40px 5%;
	
}
.bankCardInfor>form>div{
	padding: 20px 0;
	
}
.bankCardInfor>form>h2{ width: 100%; height: 30px; font-size: 16px; line-height: 30px; padding-left: 10px; background: #d9dadc; color: #FFFFFF; margin-top: 0px;}
.bankCardInfor>form>div>label{ display: inline-block; width: 200px;  text-align: right; margin-right: 10px;}
.bankCardInfor>form>div>label>i{ color: red; margin-right: 10px;}

.img_upload_wrp .img_upload_box {
    display: inline-block;
    width: 98px;
    height: 27px;
    margin: 0 10px 10px 0;
    vertical-align: top;
}
.img_upload_box{float: left;}
.js_pager{ float: left; }

.img_upload_box_oper {
    display: block;
    background: #d9dadc;
    border: 1px solid #d9dadc !important;
    width: 100%;
    height: 30px !important;
    text-align: center;
    line-height: 30px;
     color:#777777;
     border-radius: 5px;
}
.img_upload_box{ height: 40px !important }
.js_pager,.img_upload_box {float: none !important;}
.js_edit_pic_wrp{height: 98px !important;}
.img_upload_preview_box p{margin:0px;}

.bankCardInfor>form>p{width: 120px;margin: 20px auto;}
.bankCardInfor>form>p>button{ background: #0066CC; width: 120px; height: 30px; border: none; border-radius: 5px; color: #FFFFFF; margin: 0 auto;}

</style>
<body>
    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
	        <div class="row wrapper border-bottom white-bg page-heading">
	            <div class="col-lg-10">
	                <h2>代理商</h2>
	                <ol class="breadcrumb">
	                    <li>
	                        <a>Agent</a>
	                    </li>
	                    <li>
	                        <a>代理商信息</a>
	                    </li>
	                    <li class="active">
	                        <strong>代理身份和账户</strong>
	                    </li>
	                </ol>
	            </div>
			</div>
        <div class="row wrapper page-heading iconList" >
        	<div class="bankCardInfor">
        		<h2>上传银行卡信息</h2>
        		<form action="" method="post">
        			<h2>持卡人证件信息</h2>
        			<div>
        				<label><i>*</i>身份证号码：</label>
        				<input type="text" name="bankcardAndId[idcard]" value="<?php echo $bankandid['idcard'];?>">
        			</div>
        			<div class="clearfix">
							<label style="float: left;"><i>*</i>身份证正面照片：</label>
								<div style="float: left;">
									<p>必须为彩色图片且小于2M，文件格式为bmp、png、jpeg、jpg或gif</p>	
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url"  href="javascript:" id='idA'>上传文件</a> 
											</div>
											<div class="js_pager">
											<?php if (!empty($bankandid['idA'])) { ?>
												<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp">
												<img  src="<?php echo $bankandid['idA'];?>">
												<input  name="bankcardAndId[idA]" type="hidden" value="<?php echo $bankandid['idA'];?>">
													<p class="img_upload_edit_area js_edit_area">
													<a class="icon18_common del_gray js_delete" href="javascript:void(0);" onclick="DelthisImg($(this));" ></a>
													</p>
												</div>
											<?php } ?>

											</div> 
									   </div>
								</div>
								</div>
								
						</div>		
						
						<div class="clearfix">
							<label style="float: left;"><i>*</i>身份证反面照片：</label>
								<div style="float: left;">
									<p>必须为彩色图片且小于2M，文件格式为bmp、png、jpeg、jpg或gif</p>	
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url" href="javascript:" id='idB'>上传文件</a> 
											</div>
											<div class="js_pager">
												<?php if (!empty($bankandid['idB'])) { ?>
												<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="<?php echo $bankandid['idB'];?>"><input  name="bankcardAndId[idB]" type="hidden" value="<?php echo $bankandid['idB'];?>"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:void(0);" onclick="DelthisImg($(this));" ></a></p>
												</div>
												<?php } ?>

											</div> 
									   </div>
								  	</div>
								</div>
						</div>
        				
        				<div class="clearfix">
							<label style="float: left;"><i>*</i>上传手持身份证和银行卡：</label>
								<div style="float: left;">
									<p>必须为彩色图片且小于2M，文件格式为bmp、png、jpeg、jpg或gif</p>	
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url"  href="javascript:" id='bankAndID'>上传文件</a> 
											</div>
											<div class="js_pager">
											
												<?php if (!empty($bankandid['bankAndID'])) { ?>
												<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="<?php echo $bankandid['bankAndID'];?>"><input  name="bankcardAndId[bankAndID]" type="hidden" value="<?php echo $bankandid['bankAndID'];?>"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:void(0);" onclick="DelthisImg($(this));" ></a></p>
												</div>
												<?php } ?>
											</div> 
									   </div>
								  	</div>
								</div>
						</div>
 					<h2>银行账号</h2>	
        			<div>
        				<label><i>*</i>开户人：</label>
        				<input type="text" name="bankcardAndId[bankaccount]" value="<?php echo $bankandid['bankaccount'];?>">
        			</div>
        			
        			<div>
        				<label><i>*</i>开户银行：</label>
        				<input type="text" name="bankcardAndId[bankname]" value="<?php echo $bankandid['bankname'];?>">
        			</div>
        			
        			<div>
        				<label><i>*</i>银行账户：</label>
        				<input type="text" name="bankcardAndId[bankcard]" value="<?php echo $bankandid['bankcard'];?>">
        			</div>
        			
        			<div class="clearfix">
							<label style="float: left;"><i>*</i>上传银行卡正面照片：</label>
								<div style="float: left;">
									<p>必须为彩色图片且小于2M，文件格式为bmp、png、jpeg、jpg或gif</p>	
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												<a class="img_upload_box_oper js_upload js_pic_url"  href="javascript:" id='bankA'>上传文件</a> 
											</div>
											<div class="js_pager">
												
												<?php if (!empty($bankandid['bankA'])) { ?>
												<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="<?php echo $bankandid['bankA'];?>"><input  name="bankcardAndId[bankA]" type="hidden" value="<?php echo $bankandid['bankA'];?>"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:void(0);" onclick="DelthisImg($(this));" ></a></p></div>
												<?php } ?>
											</div> 
									   </div>
								  	</div>
								</div>
						</div>		
						
						<div class="clearfix">
							<label style="float: left;"><i>*</i>上传银行卡反面照片：</label>
								<div style="float: left;">
									<p>必须为彩色图片且小于2M，文件格式为bmp、png、jpeg、jpg或gif</p>	
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url"  href="javascript:" id='bankB'>上传文件</a> 
											</div>
											<div class="js_pager">
												

												<?php if (!empty($bankandid['bankB'])) { ?>
												<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="<?php echo $bankandid['bankA'];?>"><input  name="bankcardAndId[bankB]" type="hidden" value="<?php echo $bankandid['bankB'];?>"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:void(0);" onclick="DelthisImg($(this));" ></a></p></div>
												<?php } ?>
											</div> 
									   </div>
								  	</div>
								</div>
						</div>
        			
        			
        			
        			
        			
        			<p><button>提交</button></p>
        		</form>
        		
        	</div>
    	</div>
</div>

  
   <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
<script src="<?php echo $this->RlStaticResource;?>plugins/js/dropzone/dropzone.js"></script>
<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
<script>
$(document).ready(function() { 
$(".js_pic_url").dropzone({
				url: "?m=Salesman&c=settlement&a=upfile",
				addRemoveLinks: false,
				maxFilesize: 1,
				acceptedFiles: ".jpg,.png,.jif",
				uploadMultiple: false,
				init: function() {

					var objID = this.element.id;
					this.on("success", function(file,responseText) {
						var rept = $.parseJSON(responseText);
						console.log(rept.fileUrl);
						/***这里的this.element 是 $("#js_pic_url")****/
					if(!rept.error){
					var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'+rept.fileUrl+'"><input  name="bankcardAndId['+objID+']" type="hidden" value="'+rept.fileUrl+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:void(0);" onclick="DelthisImg($(this));" ></a></p></div>';
					
					$(this.element).parents(".img_upload_box").siblings().html(imgHtml);
					 $(this.element).find('div').remove();
						}else{
						  swal({
        					  title: "上传失败",
        					  text: rept.msg,
        					  type: "error"
    						}, function () {
        					
   						   });
						}
					});
				}
			});
});						
	

</script>
<script>	
$(document).on('mouseover mouseout','.img_upload_preview_box',function(event){
	   if(event.type == "mouseover"){
	     $(this).find('p').show();
	   }else if(event.type == "mouseout"){
		$(this).find('p').hide();
		}
	  });
  
function DelthisImg(obj){
  if(confirm('您确定删除图片！')){
    obj.parent('p').parent('.img_upload_preview_box').remove();
  }
}

</script>
    </body>
</html>