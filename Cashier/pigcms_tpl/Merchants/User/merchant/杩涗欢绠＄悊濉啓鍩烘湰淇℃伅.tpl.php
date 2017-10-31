<!DOCTYPE html>
<html>
<head>
<title>门店管理</title>
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
p{ margin-bottom: 0px;}
.role_permission{background: #FFFFFF;}
.role_permission>h1{ font-size: 18px; border-bottom:1px solid #f2f2f2 ; height: 40px; line-height: 40px; border-top: 3px solid #B5D6FD; margin: 0px; padding-left: 20px;}
.role_permission>div{ border: 1px solid #f2f2f2; margin:20px  auto; width: 98%;}
.role_permission>div>h2{ height: 40px; line-height: 40px; padding: 0 10px; background: #f2f2f2; margin: 0px; font-size: 16px; font-weight: normal;}
.role_permission>div>div{ min-height: 40px; margin: 10px 0;}
.role_permission>div>div>label{ width: 120px; text-align: right; margin-right: 20px; float: left;}
.role_permission>div>div>label>span{ color: red;}
.role_permission>div>div>div{ float: left;}
.role_permission>div>div>div>input{ width: 310px; height: 30px;}
.tj{ width: 300px; margin: 0 auto;}
.tj>input{ width: 100px; text-align: center;height: 30px; line-height: 30px; border: none; border-radius: 2px; background: #2f9833; margin-right: 20px; color: #FFFFFF;}
.tj>button{ width: 100px; text-align: center;height: 32px; line-height: 32px; border-radius: 2px; background: #FFFFFF; margin-right: 20px; border: 1px solid #f2f2f2;}
.tj>button>a{ color: #202020;}
.ts{ display: none; color: red;}
#Sup_material>div>div>label,#Realestate>div>div>label{ float: left;margin:10px; width: 100px; overflow: hidden;}
#Sup_material>div>div>label>p,#Realestate>div>div>label>p{ color: #2C82C9; cursor: pointer; }
.industry_type>select{ width: 150px; height: 30px;}
#classification_two,#classification_three{ display:none;}
#Realestate>div,#publicWelfare>div{ width: 100%;}
#Realestate>div>label,#publicWelfare>div>label{display: inline-block; width: 150px;}
#Realestate>div>label>span,#publicWelfare>div>label>span{color: red;}
</style>
<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all2.min.js"></script>
</head>

<body>
	<div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>商家信息管理</h2>
					<ol class="breadcrumb">
						<li><a>User</a></li>
						<li><a>商户中心</a></li>
						<li><a>进件管理</a></li>
						<li class="active"><strong>填写基本信息</strong></li>
					</ol>
				</div>
				<div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row role_permission" style="position: relative; padding-bottom: 50px;">
					<h1>填写基本信息 </h1>
					<!--
                    	作者：2721190987@qq.com
                    	时间：2016-10-29
                    	描述：联系信息
                    -->
					<div>
						<h2>联系信息</h2>
						<div class="clearfix">
							<label><span>*</span>联系人姓名：</label>
							<div>
								<input type="text" placeholder="" id="name">
								<p style="display: none; color: red;"></p>
								<p>请填写贵司微信支付业务联系人</p>
							</div>
						</div>
						<div class="clearfix">
							<label><span>*</span>手机号码：</label>
							<div>
								<input type="text" placeholder="" id="tel" onkeyup="this.value=this.value.replace(/\D/g,'')">
								<p style="display: none; color: red;"></p>
								<p>该号非常重要,将接收与微信支付管理相关的重要信息</p>
							</div>
							
						</div>
						<div class="clearfix">
							<label><span>*</span>常用邮箱：</label>
							<div>
								<input type="text" placeholder="" id="mailbox">
								<p style="display: none; color: red;"></p>
								<p>非常重要！用于接收微信支付的账号密码</p>
							</div>
						</div>
	
					</div>
					
					<div>
						<h2>经营信息</h2>
						<div class="clearfix">
							<label><span>*</span>商户简称：</label>
							<div>
								<input type="text" placeholder="" id="business_abbreviation">
								<p style="display: none; color: red;"></p>
								<p>非常重要！该名称将于在支付完成页面向消费者进行展示</p>
							</div>	
						</div>
						<div class="industry_type clearfix">
							<label><span>*</span>商户简称：</label>
							<select id="classification_one">
								<option>企业</option>
								<option>个体商户</option>
								<option>事业单位</option>
							</select>
							<select id="classification_two">
								<option>电商/团购</option>
								<option>电商/团购</option>
								<option>美容/健身类会所 </option>
							</select>
							<select id="classification_three">
								<option value="1">美容/健身类会所</option>
								<option value="2">美容/健身类会所</option>
								<option value="3">美容/健身类会所</option>
								<option value="4">美容/健身类会所</option>
								<option value="5">美容/健身类会所</option>
								<option value="4">美容/健身类会所</option>
							</select>
							<p style="padding-left: 140px;">请根据你的营业执照和实际售卖商品来选择主体和类目，审核通过后类目不可修改</p>
							<!--
	                        	作者：2721190987@qq.com
	                        	时间：2016-10-29
	                        	描述：在选择行业类目的提示
	                        -->
							<div id="newSettle" style="padding-left: 140px; display: none;">
								<p>交易资金将逐笔计费并结算入账至你的微信支付商户账户，你可自助提现。</p>
								<p>你选择的类目为实物类；结算周期为实时结算到基本户；手续需要缴纳的手续费率为0.6%，将从每笔交易中抽取。</p>
							</div>
						</div>
						<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-29
                        	描述：房地产
                        -->
						<div class="clearfix" id="Realestate" style="display: none;">
							<div class="clearfix">
								<label style="float:left ;"><span>*</span>《建设用地规划许可证》</label>
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload" id="js_pic_url" href="javascript:"> <i class="icon20_common add_gray"> 上传 </i> </a> 
											</div>
											<div class="js_pager"></div> 
									   </div>
								  	</div>
								</div>
							</div>
							<div class="clearfix" >
								<label style="float:left ;"><span>*</span>《建设工程规划许可证》</label>
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload" id="js_pic_url1" href="javascript:"> <i class="icon20_common add_gray"> 上传 </i> </a> 
											</div>
											<div class="js_pager1"></div> 
									   </div>
								  	</div>
								</div>
							</div>
							<div class="clearfix">
								<label style="float:left ;"><span>*</span>《建筑工程开工许可证》</label>
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload" id="js_pic_url2" href="javascript:"> <i class="icon20_common add_gray"> 上传 </i> </a> 
											</div>
											<div class="js_pager2"></div> 
									   </div>
								  	</div>
								</div>
							</div>
							<div class="clearfix">
								<label style="float:left ;"><span>*</span>《国有土地使用证》</label>
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload" id="js_pic_url3" href="javascript:"> <i class="icon20_common add_gray"> 上传 </i> </a> 
											</div>
											<div class="js_pager3"></div> 
									   </div>
								  	</div>
								</div>
							</div>
							<div class="clearfix">
								<label style="float:left ;"><span>*</span>《商品房预售许可证》</label>
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload" id="js_pic_url4" href="javascript:"> <i class="icon20_common add_gray"> 上传 </i> </a> 
											</div>
											<div class="js_pager4"></div> 
									   </div>
								  	</div>
								</div>
							</div>	
						</div>
						
						
						<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-29
                        	描述：公益
                        -->
						<div class="clearfix" id="publicWelfare" style="display: none;">
							<div class="clearfix">
								<label style="float:left ;"><span>*</span>《法人登记证书》</label>
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload" id="js_pic_url5" href="javascript:"> <i class="icon20_common add_gray"> 上传 </i> </a> 
											</div>
											<div class="js_pager5"></div> 
									   </div>
								  	</div>
								</div>
							</div>
							<div class="clearfix">
								<label style="float:left ;"><span>*</span>《组织机构代码证》</label>
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload" id="js_pic_url6" href="javascript:"> <i class="icon20_common add_gray"> 上传 </i> </a> 
											</div>
											<div class="js_pager6"></div> 
									   </div>
								  	</div>
								</div>
							</div>
							
						</div>
						
						
						<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-29
                        	描述：特殊资质
                        -->
						<div class="clearfix" id="special_qualificat" style="display: none;">
							<label style="float:left ;"><span>*</span>特殊资质</label>
							<div style="float:left ;">
								<p>图片大小不超过2M，格式为jpg、jpeg、png、bmp或gif</p>
								<p>须为彩色图片且小于2M，文件格式为bmp、png、jpeg、jpg或gif</p>
								<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload" id="js_pic_url7" href="javascript:"> <i class="icon20_common add_gray"> 上传 </i> </a> 
											</div>
											<div class="js_pager7"></div> 
									   </div>
								</div>
							</div>
						</div>
						
						<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-29
                        	描述：售卖商品简述
                        -->
						<div class="clearfix" id="comDescription" style="display: none;">
							<label style="float:left ;"><span>*</span>售卖商品简述</label>
							<div style="float:left ;">
								<div id="merchant_description" style=" width: 600px; height: 110px; border: 1px solid #f2f2f2;" contenteditable></div>
								<p style="color: red; display: none;"></p>
								<p>请简要描述售卖的商品或提供的服务，必须在营业执照经营范围内，且必须与所选类目对应一致。</p>
								<p>请勿直接照抄营业执照中的经营范围，否则将会导致您的申请资料被驳回</p>
							</div>
						</div>
						<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-29
                        	描述：客服电话
                        -->
						<div class="clearfix" id="customer_tel">
							<label style="float:left ;"><span>*</span>客服电话</label>
							<div style="float:left ;">
								<input type="text" id="phone">
								<p style="display: none; color: red;"></p>
								<p>审核人员会对电话进行回拨确认，无法接通将导致申请驳回；座机请注意填写区号</p>
							</div>
						</div>
						
						<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-29
                        	描述：公司网站
                        -->
						<div class="clearfix" id="company_web">
							<label style="float:left ;">公司网站</label>
							<div style="float:left ;">
								<input type="text">
								<p>非互联网公司可无需填写</p>
								<p>网站域名需以http或https开头, 且域名需ICP备案</p>
								<p>若备案主体与申请主体不同，请填写网站授权函并加盖公章，在下方‘补充材料’处上传</p>
							</div>
						</div>
						
						<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-29
                        	描述：补充材料
                        -->
						<div class="clearfix" id="Sup_material">
							<label style="float:left ;">补充材料</label>
							<div style="float:left ;">
								<p>图片大小不超过2M，格式为jpg、jpeg、png、bmp或gif</p>
								<p>须为彩色图片且小于2M，文件格式为bmp、png、jpeg、jpg或gif</p>
								<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload" id="js_pic_url8" href="javascript:"> <i class="icon20_common add_gray"> 上传 </i> </a> 
											</div>
											<div class="js_pager8"></div> 
									   </div>
								</div>
									
								
							</div>
						</div>
						
					</div>
	
					
					
					<p class="tj"><input type="submit"  value="保存下一步"/></p>
	            </div>
			</div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
	</div>

<script src="<?php echo $this->RlStaticResource;?>plugins/js/dropzone/dropzone.js"></script>
<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
<script>	
	$("#name").blur(function(){
    		if($(this).val()==""){
    			$(this).next("p").show();
    			$(this).next("p").text("请输入联系人姓名")
    		}else{
    			$(this).next("p").hide();
    		}
    	});
    $("#tel").blur(function(){
    	var phone = $(this).val();
    		var tel = /^1[3|4|5|8][0-9]\d{4,8}$/;
    		if($(this).val()==""){
    			$(this).next("p").show();
    			$(this).next("p").text("请输入手机号码")
    		}else if(!tel.exec(phone)){
    			$(this).next("p").show();
    			$(this).next("p").text("手机号码格式错误")	
    		}else{
    			$(this).next("p").hide();
    		}
    	});
    $("#mailbox").blur(function(){
    	var mailbox = $(this).val();
    	var email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    		if($(this).val()==""){
    			$(this).next("p").show();
    			$(this).next("p").text("请输入邮箱")
    		}else if(!email.exec(mailbox)){
    			$(this).next("p").text("邮箱格式错误")
    		}else{
    			$(this).next("p").hide();
    		}
    	});
    $("#business_abbreviation").blur(function(){
    		if($(this).val()==""){
    			$(this).next("p").show();
    			$(this).next("p").text("请输入商户简称")
    		}else{
    			$(this).next("p").hide();
    		}
    	});
    	
    	
    $("#merchant_description").blur(function(){
    		if($(this).text()==""){
    			$(this).next("p").show();
    			$(this).next("p").text("请输入商品的描述")
    		}else{
    			$(this).next("p").hide();
    		}
    	});
    $("#phone").blur(function(){
    		if($(this).val()==""){
    			$(this).next("p").show();
    			$(this).next("p").text("请输入客服电话")
    		}else{
    			$(this).next("p").hide();
    		}
    	});
    	
    $("#classification_one>option").click(function(){
    	if($(this).val){
    		 $("#classification_two").show();
    		  $("#classification_three").hide();
    		  $("#newSettle").hide();
    	}
    });
     $("#classification_two>option").click(function(){
    	if($(this).val){
    		  $("#classification_three").show();  
    		  $("#newSettle").hide();
    	}
    	
    })
     $("#classification_three>option").click(function(){
     	if($(this).val()=="0"){
    		  $("#Realestate").hide();
    		  $("#publicWelfare").hide();
    		   $("#special_qualificat").hide();
    		  $("#comDescription").hide();
    		   
    	}
     	
    	if($(this).val()=="1"){
    		$("#special_qualificat").show();
    		$("#comDescription").show();
    		$("#publicWelfare").hide();
    		$("#Realestate").hide();
    	}
    	
    	if($(this).val()=="2"){
    		  $("#special_qualificat").show();
    		  $("#publicWelfare").hide();
    		  $("#comDescription").hide();
    		   $("#Realestate").hide();
    		   
    	}
    	
    	if($(this).val()=="3"){
    		  $("#comDescription").show();
    		  $("#special_qualificat").hide();
    		  $("#publicWelfare").hide();
    		   $("#Realestate").hide();
    		   
    	}
    	
    	if($(this).val()=="4"){
    		  $("#Realestate").show();
    		  $("#comDescription").show();
    		  $("#special_qualificat").hide();
    		  $("#publicWelfare").hide();
    		   
    	}
    	
    	if($(this).val()=="5"){
    		  $("#publicWelfare").show();
    		  $("#comDescription").show();
    		  $("#special_qualificat").hide();
    		   $("#Realestate").hide();
    		   
    	}
    })
    
</script>
<script>
$(document).ready(function() { 
$("#js_pic_url,#js_pic_url .icon20_common").dropzone({
				url: "?m=User&c=wxCoupon&a=uploadImg",
				addRemoveLinks: false,
				maxFilesize: 1,
				acceptedFiles: ".jpg,.png",
				uploadMultiple: false,
				init: function() {
					this.on("success", function(file,responseText) {
						var rept = $.parseJSON(responseText);
						/***这里的this.element 是 $("#js_pic_url")****/
						if(!rept.error){
					var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'+rept.localimg+'"><input name="photo_list[]" class="imginput" type="hidden" value="'+rept.wxlogurl+'"><input name="photo_img[]" type="hidden" value="'+rept.localimg+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
					$('.js_pager').before(imgHtml)
					 $(this.element).find('div').remove();
						}else{
						  swal({
        					  title: "上传失败",
        					  text: rept.msg,
        					  type: "error"
    						}, function () {
        					//window.location.reload();
   						   });
						}
					});
				}
			});
});						
	

</script>
<script>
$(document).ready(function() { 
$("#js_pic_url1,#js_pic_url1 .icon20_common").dropzone({
				url: "?m=User&c=wxCoupon&a=uploadImg",
				addRemoveLinks: false,
				maxFilesize: 1,
				acceptedFiles: ".jpg,.png",
				uploadMultiple: false,
				init: function() {
					this.on("success", function(file,responseText) {
						var rept = $.parseJSON(responseText);
						/***这里的this.element 是 $("#js_pic_url")****/
						if(!rept.error){
					var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'+rept.localimg+'"><input name="photo_list[]" class="imginput" type="hidden" value="'+rept.wxlogurl+'"><input name="photo_img[]" type="hidden" value="'+rept.localimg+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
					$('.js_pager1').before(imgHtml)
					 $(this.element).find('div').remove();
						}else{
						  swal({
        					  title: "上传失败",
        					  text: rept.msg,
        					  type: "error"
    						}, function () {
        					//window.location.reload();
   						   });
						}
					});
				}
			});
});						
	

</script>

<script>
$(document).ready(function() { 
$("#js_pic_url2,#js_pic_url2 .icon20_common").dropzone({
				url: "?m=User&c=wxCoupon&a=uploadImg",
				addRemoveLinks: false,
				maxFilesize: 1,
				acceptedFiles: ".jpg,.png",
				uploadMultiple: false,
				init: function() {
					this.on("success", function(file,responseText) {
						var rept = $.parseJSON(responseText);
						/***这里的this.element 是 $("#js_pic_url")****/
						if(!rept.error){
					var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'+rept.localimg+'"><input name="photo_list[]" class="imginput" type="hidden" value="'+rept.wxlogurl+'"><input name="photo_img[]" type="hidden" value="'+rept.localimg+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
					$('.js_pager2').before(imgHtml)
					 $(this.element).find('div').remove();
						}else{
						  swal({
        					  title: "上传失败",
        					  text: rept.msg,
        					  type: "error"
    						}, function () {
        					//window.location.reload();
   						   });
						}
					});
				}
			});
});						
	

</script>

<script>
$(document).ready(function() { 
$("#js_pic_url3,#js_pic_url3 .icon20_common").dropzone({
				url: "?m=User&c=wxCoupon&a=uploadImg",
				addRemoveLinks: false,
				maxFilesize: 1,
				acceptedFiles: ".jpg,.png",
				uploadMultiple: false,
				init: function() {
					this.on("success", function(file,responseText) {
						var rept = $.parseJSON(responseText);
						/***这里的this.element 是 $("#js_pic_url")****/
						if(!rept.error){
					var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'+rept.localimg+'"><input name="photo_list[]" class="imginput" type="hidden" value="'+rept.wxlogurl+'"><input name="photo_img[]" type="hidden" value="'+rept.localimg+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
					$('.js_pager3').before(imgHtml)
					 $(this.element).find('div').remove();
						}else{
						  swal({
        					  title: "上传失败",
        					  text: rept.msg,
        					  type: "error"
    						}, function () {
        					//window.location.reload();
   						   });
						}
					});
				}
			});
});						
</script>

<script>
$(document).ready(function() { 
$("#js_pic_url4,#js_pic_url4 .icon20_common").dropzone({
				url: "?m=User&c=wxCoupon&a=uploadImg",
				addRemoveLinks: false,
				maxFilesize: 1,
				acceptedFiles: ".jpg,.png",
				uploadMultiple: false,
				init: function() {
					this.on("success", function(file,responseText) {
						var rept = $.parseJSON(responseText);
						/***这里的this.element 是 $("#js_pic_url")****/
						if(!rept.error){
					var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'+rept.localimg+'"><input name="photo_list[]" class="imginput" type="hidden" value="'+rept.wxlogurl+'"><input name="photo_img[]" type="hidden" value="'+rept.localimg+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
					$('.js_pager4').before(imgHtml)
					 $(this.element).find('div').remove();
						}else{
						  swal({
        					  title: "上传失败",
        					  text: rept.msg,
        					  type: "error"
    						}, function () {
        					//window.location.reload();
   						   });
						}
					});
				}
			});
});						
</script>

<script>
$(document).ready(function() { 
$("#js_pic_url5,#js_pic_url5 .icon20_common").dropzone({
				url: "?m=User&c=wxCoupon&a=uploadImg",
				addRemoveLinks: false,
				maxFilesize: 1,
				acceptedFiles: ".jpg,.png",
				uploadMultiple: false,
				init: function() {
					this.on("success", function(file,responseText) {
						var rept = $.parseJSON(responseText);
						/***这里的this.element 是 $("#js_pic_url")****/
						if(!rept.error){
					var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'+rept.localimg+'"><input name="photo_list[]" class="imginput" type="hidden" value="'+rept.wxlogurl+'"><input name="photo_img[]" type="hidden" value="'+rept.localimg+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
					$('.js_pager5').before(imgHtml)
					 $(this.element).find('div').remove();
						}else{
						  swal({
        					  title: "上传失败",
        					  text: rept.msg,
        					  type: "error"
    						}, function () {
        					//window.location.reload();
   						   });
						}
					});
				}
			});
});						
	

</script>

<script>
$(document).ready(function() { 
$("#js_pic_url6,#js_pic_url6 .icon20_common").dropzone({
				url: "?m=User&c=wxCoupon&a=uploadImg",
				addRemoveLinks: false,
				maxFilesize: 1,
				acceptedFiles: ".jpg,.png",
				uploadMultiple: false,
				init: function() {
					this.on("success", function(file,responseText) {
						var rept = $.parseJSON(responseText);
						/***这里的this.element 是 $("#js_pic_url")****/
						if(!rept.error){
					var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'+rept.localimg+'"><input name="photo_list[]" class="imginput" type="hidden" value="'+rept.wxlogurl+'"><input name="photo_img[]" type="hidden" value="'+rept.localimg+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
					$('.js_pager6').before(imgHtml)
					 $(this.element).find('div').remove();
						}else{
						  swal({
        					  title: "上传失败",
        					  text: rept.msg,
        					  type: "error"
    						}, function () {
        					//window.location.reload();
   						   });
						}
					});
				}
			});
});						
</script>

<script>
$(document).ready(function() { 
$("#js_pic_url7,#js_pic_url7 .icon20_common").dropzone({
				url: "?m=User&c=wxCoupon&a=uploadImg",
				addRemoveLinks: false,
				maxFilesize: 1,
				acceptedFiles: ".jpg,.png",
				uploadMultiple: false,
				init: function() {
					this.on("success", function(file,responseText) {
						var rept = $.parseJSON(responseText);
						/***这里的this.element 是 $("#js_pic_url")****/
						if(!rept.error){
					var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'+rept.localimg+'"><input name="photo_list[]" class="imginput" type="hidden" value="'+rept.wxlogurl+'"><input name="photo_img[]" type="hidden" value="'+rept.localimg+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
					$('.js_pager7').before(imgHtml)
					 $(this.element).find('div').remove();
						}else{
						  swal({
        					  title: "上传失败",
        					  text: rept.msg,
        					  type: "error"
    						}, function () {
        					//window.location.reload();
   						   });
						}
					});
				}
			});
});						
</script>

<script>
$(document).ready(function() { 
$("#js_pic_url8,#js_pic_url8 .icon20_common").dropzone({
				url: "?m=User&c=wxCoupon&a=uploadImg",
				addRemoveLinks: false,
				maxFilesize: 1,
				acceptedFiles: ".jpg,.png",
				uploadMultiple: false,
				init: function() {
					this.on("success", function(file,responseText) {
						var rept = $.parseJSON(responseText);
						/***这里的this.element 是 $("#js_pic_url")****/
						if(!rept.error){
					var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'+rept.localimg+'"><input name="photo_list[]" class="imginput" type="hidden" value="'+rept.wxlogurl+'"><input name="photo_img[]" type="hidden" value="'+rept.localimg+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
					$('.js_pager8').before(imgHtml)
					 $(this.element).find('div').remove();
						}else{
						  swal({
        					  title: "上传失败",
        					  text: rept.msg,
        					  type: "error"
    						}, function () {
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
</html>