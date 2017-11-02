<?php /* Smarty version 2.6.18, created on 2017-11-01 16:06:26
         compiled from F:%5Cgit%5Cjzzf%5CCashier%5C./pigcms_tpl/Merchants/System/pay/TemplateImage.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>下载模版图片上传</title>
   	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <link href="<?php echo @RlStaticResource; ?>
plugins/css/iCheck/custom.css" rel="stylesheet">
	<link href="<?php echo @RlStaticResource; ?>
plugins/css/dropzone/basic.css" rel="stylesheet">
    <link href="<?php echo @RlStaticResource; ?>
plugins/css/dropzone/dropzone.css" rel="stylesheet">
    <!-- iCheck -->
    <script src="<?php echo @RlStaticResource; ?>
plugins/js/iCheck/icheck.min.js"></script>
	<!-- DROPZONE -->
    <script src="<?php echo @RlStaticResource; ?>
plugins/js/dropzone/dropzone.js"></script>
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
.bankCardInfor>form>div>label{ display: inline-block; width: 160px;  text-align: right; margin-right: 10px;}
.bankCardInfor>form>div>label>i{ color: red; margin-right: 10px;}

.img_upload_wrp .img_upload_box {
    display: inline-block;
    width: 98px;
    height: auto;
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
     border-radius: 5px
}
.img_upload_box{ height: auto !important }
.js_pager,.img_upload_box {float: none !important;}
.js_edit_pic_wrp{height: auto !important;}
.img_upload_preview_box p{margin:0px;}

.bankCardInfor>form>p{width: 120px;margin: 20px auto;}
.bankCardInfor>form>p>button{ background: #0066CC; width: 120px; height: 30px; border: none; border-radius: 5px; color: #FFFFFF; margin: 0 auto;}

.yjf1>img{ width:400px;height:600px}
.yjf2>img{ width:400px;height:200px}
</style>
<body>
    <div id="wrapper">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/leftmenu.tpl2.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/top.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	        <div class="row wrapper border-bottom white-bg page-heading">
	            <div class="col-lg-10">
	                <h2>模版图片上传</h2>
	                <ol class="breadcrumb">
	                    <li>
	                        <a>图片上传</a>
	                    </li>
	                    <li class="active">
	                        <strong>模版图片上传</strong>
	                    </li>
	                </ol>
	            </div>
			</div>
        <div class="row wrapper page-heading iconList" >
        	<div class="bankCardInfor">
        		<h2>模版图片上传</h2>
        		<form>
        			
        			
        			<div class="clearfix">
							<label style="float: left;"><i>*</i>支付二维码模版：</label>
								<div style="float: left;">
									<p style="font-size:14px;color:red">图片大小为1200 X 1800且小于2M，文件格式为png、jpg 或 gif;</p>	
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url"  href="javascript:">上传文件
												    <input type="hidden" name="tu1" valu="1">
												 </a> 
											</div>
											<div class="js_pager">
											     <div class="img_upload_box img_upload_preview_box js_edit_pic_wrp yjf1">
											         <img style="width:400px; height:600px"   src="<?php echo $this->_tpl_vars['pay_img_url']; ?>
">
											         <input name="photo_list[]" class="imginput" type="hidden" value="'+rept.wxlogurl+'">
											         <input name="photo_img[]" type="hidden" value="<?php echo $this->_tpl_vars['pay_img_url']; ?>
">
											         <p class="img_upload_edit_area js_edit_area">
											             <a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a>
											         </p>
											      </div>
											
											</div> 
									   </div>
								</div>
								</div>
								<div style="float: right; margin-right:20px; width:300px;">
								    <p style="color:red ;width:300px;">描述：图片大小为1200 X 1800,中间二维码为660 X 660 上下间隔为90px,60px 左右间隔270,270px</p>
								    <img style="width:100%" alt="" src="<?php echo $this->_tpl_vars['url']; ?>
/Cashier/upload/img/pay_test.jpg"  >
								</div>
					</div>		
					<div class="clearfix">
							<label style="float: left;"><i>*</i>通知二维码模版：</label>
								<div style="float: left;">
									<p style="font-size:14px;color:red">图片大小为1200 X 600且小于2M，文件格式为png、jpg 或 gif;</p>	
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url1" href="javascript:">上传文件
												    
												 </a> 
											</div>
											<div class="js_pager">
											     <div class="img_upload_box img_upload_preview_box js_edit_pic_wrp yjf2">
											         <img style="width:400px; height:200px"  src="<?php echo $this->_tpl_vars['notice_img_url']; ?>
">
											             <input name="photo_list[]" class="imginput" type="hidden" value="'+rept.wxlogurl+'">
											             <input name="photo_img[]" type="hidden" value="<?php echo $this->_tpl_vars['notice_img_url']; ?>
">
											             <p class="img_upload_edit_area js_edit_area">
											                 <a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a>
											             </p>
											     </div>
											
											</div> 
									   </div>
								  	</div>
								</div>
								
							<div style="float: right; margin-right:20px;width:300px;">
								    <p style="color:red;width:300px;">描述：图片大小为1200 X 600,中间二维码为210 X 210 ,左边关注二维码为固定，右边通知二维码预留210 X 210 的空位</p>
								    <img alt="" src="<?php echo $this->_tpl_vars['url']; ?>
/Cashier/upload/img/notice_test.jpg" style="width:100%;">
							</div>
					</div>
        		</form>
        		
        	</div>
    	</div>
</div>

  
   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script src="<?php echo @RlStaticResource; ?>
plugins/js/dropzone/dropzone.js"></script>
<script>
$(document).ready(function() { 
    $(".js_pic_url").dropzone({
        url: "?m=System&c=pay&a=TemplateImage",
        addRemoveLinks: false,
        maxFilesize: 1,
        acceptedFiles: ".jpg,.png,.gif",
        uploadMultiple: false,
        init: function() {
        	this.on("success", function(file,responseText) {
        		var rept = $.parseJSON(responseText);
        		/***这里的this.element 是 $("#js_pic_url")****/
                if(!rept.error){
                    var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img style="width:400px; height:600px"  src="'+rept.localimg+'"><input name="photo_list[]" class="imginput" type="hidden" value="'+rept.wxlogurl+'"><input name="photo_img[]" type="hidden" value="'+rept.localimg+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
                    $(this.element).parents(".img_upload_box").siblings().html(imgHtml);
                    $(this.element).find('div').remove();
                }else{
                  
                  swal({title: "上传失败", text: rept.msg,type: "error"}, function () {
                	//window.location.reload();
                   });
                }
        	});
        }
    });


    $(".js_pic_url1").dropzone({
        url: "?m=System&c=pay&a=TemplateImage1",
        addRemoveLinks: false,
        maxFilesize: 1,
        acceptedFiles: ".jpg,.png,.gif",
        uploadMultiple: false,
        init: function() {
        	this.on("success", function(file,responseText) {
        		var rept = $.parseJSON(responseText);
        		/***这里的this.element 是 $("#js_pic_url")****/
                if(!rept.error){
                    var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img style="width:400px; height:200px"  src="'+rept.localimg+'"><input name="photo_list[]" class="imginput" type="hidden" value="'+rept.wxlogurl+'"><input name="photo_img[]" type="hidden" value="'+rept.localimg+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
                    $(this.element).parents(".img_upload_box").siblings().html(imgHtml);
                    $(this.element).find('div').remove();
                }else{
                  
                  swal({title: "上传失败", text: rept.msg,type: "error"}, function () {
                	//window.location.reload();
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