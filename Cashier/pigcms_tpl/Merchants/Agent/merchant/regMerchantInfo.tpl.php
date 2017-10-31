<!DOCTYPE html>
<html>
<head>
<title>门店管理</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
<link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">

	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/cashier.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	
	

<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>merchant/store_mangecss.css" rel="stylesheet">
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>merchant/baseshop.css" rel="stylesheet">
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>merchant/widget_add_img.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/basic.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dropzone/dropzone.css" rel="stylesheet">


<script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
<script
src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
<!-- Data picker -->
<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
<style>
.ibox-title h5 {
margin: 10px 0 0px;
}
button>a{display: block; width: 100%; height: 100%;}
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

p{ margin-bottom: 0px;}
.role_permission{background: #FFFFFF;}
.role_permission>h1{ font-size: 18px; border-bottom:1px solid #f2f2f2 ; height: 40px; line-height: 40px; border-top: 3px solid #B5D6FD; margin: 0px; padding-left: 20px;}
.role_permission>div{ border: 1px solid #f2f2f2; margin:20px  auto; width: 98%;}
.role_permission>div>h2{ height: 40px; line-height: 40px; padding: 0 10px; margin: 0px; font-size: 16px; font-weight: normal; background: #f2f2f2;}
.role_permission>div>div{ min-height: 40px; margin: 10px 0;}
.role_permission>div>div>label{ width: 120px; text-align: right; margin-right: 20px; float: left;}
.role_permission>div>div>label>span{ color: red;}
.role_permission>div>div>div{ float: left;}
.role_permission>div>div>div>input{ width: 310px; height: 30px;}
.tj{ width: 380px; margin: 0 auto;}
.tj>input{ width: 100px; text-align: center;height: 30px; line-height: 30px; border: none; border-radius: 2px; background: #2f9833; margin-right: 20px; color: #FFFFFF;}
.tj>button{ width: 100px; text-align: center;height: 32px; line-height: 32px; border-radius: 2px; background: #FFFFFF; margin-right: 20px; border: 1px solid #f2f2f2;}
.img_upload_box{ height: 40px !important }
.js_pager,.img_upload_box {float: none !important;}
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
.tj>button>a{ color: #202020;}
.ts{ display: none; color: red;}
input{ margin-bottom: 0px !important; }
select{ height: 30px;}
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
					<li><a>代理商</a></li>
					<li><a>商户中心</a></li>
					<li><a>进件管理</a></li>
					<li class="active"><strong>填写商户信息</strong></li>
				</ol>
			</div>
			<div class="col-lg-2"></div>
		</div>
		<div class="wrapper wrapper-content animated fadeInRight">
		<form method="post" action="" enctype="multipart/form-data">
			<div class="row role_permission" style="position: relative; padding-bottom: 50px;">
				<h1>填写商户信息 </h1>
				<!--
              	作者：2721190987@qq.com
              	时间：2016-10-29
              	描述：联系信息
              -->
				<div>
					<h2>商户信息</h2>
					<div class="clearfix">
						<label><span>*</span>商户名称：</label>
						<div>

						<input type="hidden" name="mid" value="<?php echo $getdata['mid'];?>">
							<input type="text" id="name" name='company' value="<?php echo $reg['company'];?>">
							<p style="display: none; color: red;"></p>
							<p>商户名称需与营业执照登记公司名称一致</p>
						</div>
					</div>
					<div class="clearfix">
						<label><span>*</span>注册地址：</label>
						<div>
							<input type="text"  id="registered_address" name="address" value="<?php echo $reg['address'];?>">
							<p style="display: none; color: red;"></p>
							<p>注册地址需与营业执照登记住所一致</p>
						</div>
						
					</div>
					
				</div>
				
				<div>
					<h2>营业执照</h2>
					<div class="clearfix">
						<label><span>*</span>营业执照注册号：</label>
						<div>
							<input type="text" placeholder="" id="registered_account" name="icence" value="<?php echo $reg['icence'];?>">
								<p style="display: none; color: red;"></p>
						</div>	
					</div>
					<div class="clearfix">
						<label><span>*</span>经营范围：</label>
							<div>
								<div id="business_scope" style="width: 350px; height: 100px; border: 1px solid #d0d0d0; overflow: hidden; overflow-y: auto;">
									<textarea name='mcarea' style='width: 100%;height: 100%;'> <?php echo $reg['mcarea'];?></textarea>

								</div>
								<p style="display: none; color: red;"></p>
								<p>与企业工商营业执照上一致</p>	
							</div>
					</div>
					<div class="clearfix">
						<label><span>*</span>营业期限：</label>
						<div>
							<div id="datepicker" class="input-daterange">
								<input type="text"  name="starttime" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" margin-bottom: 0px; width: 35%; height: 30px;" name='shophours' value="<?php echo $reg['starttime'];?>">
								&nbsp;<span> 到 </span>&nbsp; 
						 		<input type="text"  name="endtime" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" margin-bottom: 0px; width: 35%;height: 30px;" value="<?php echo $reg['endtime'];?>"> 
						 		<label><input type="checkbox" id="long_term" name='perd' value='long'>长期</label>
							
							</div>
							<p style="display: none; color: red;"></p>
						</div>
				</div>
					<div class="clearfix">
						<label><span>*</span>营业执照照片：</label>
							<div>
								<p>需年检章齐全（当年成立公司除外）;</p>
								<p>必须为彩色图片且小于2M，文件格式为bmp、png、jpeg、jpg或gif</p>	
								<div id="js_upload_wrp">
								   <div class="img_upload_wrp group"> 
										<div class="img_upload_box"> 
											 <a class="img_upload_box_oper js_upload js_pic_url" id='licencephoto' href="javascript:">上传文件</a> 
										</div>
										<div class="js_pager">
											<?php if (!empty($reg['licencephotoList'])){ for ($i=0; $i <count($reg['licencephotoList']); $i++) { 
											
											echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['licencephotoList'][$i].'"/><input name="licencephotoList[]" class="imginput" type="hidden" value="'.$reg['licencephotoList'][$i].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
										} }?>
										</div> 
								   </div>
							  	</div>
							</div>
					</div>						
            </div>
            	
			<div>
					<h2>组织机构代码信息</h2>
					<div class="clearfix">
						<label><span>*</span>组织机构代码：</label>
						<div>
							<input type="text" placeholder="" id="organization_code" name='occode' value="<?php echo $reg['occode'];?>">
							<p style="display: none; color: red;"></p>
						</div>	
					</div>
					
					<div class="clearfix">
						<label><span>*</span>有效期：</label>
						<div>
							<div id="datepicker" class="input-daterange">
								<input type="text"  name="validatestart" value="<?php echo $reg['validatestart'];?>" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" margin-bottom: 0px; width: 35%; height: 30px;">
								&nbsp;<span> 到 </span>&nbsp; 
						 		<input type="text"  name="validateend" value="<?php echo $reg['validateend'];?>" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" margin-bottom: 0px; width: 35%; height: 30px;"> 
							<label><input type="checkbox" id="long_term2" name='validate' >长期</label>
								
							</div>
							<p style="display: none; color: red;"></p>
						</div>
				</div>
					<div class="clearfix">
						<label><span>*</span>组织机构代码证照片：</label>
							<div>
								<p>需年检章齐全（当年成立公司除外）;</p>
								<p>必须为彩色图片且小于2M，文件格式为bmp、png、jpeg、jpg或gif</p>	
								<div id="js_upload_wrp">
								   <div class="img_upload_wrp group"> 
										<div class="img_upload_box"> 
											 <a class="img_upload_box_oper js_upload js_pic_url" id='occodephoto' href="javascript:">上传文件</a> 
										</div>
										<div class="js_pager">
											<?php if (!empty($reg['occodephotoList'])){ for ($i=0; $i <count($reg['occodephotoList']); $i++) { 
											
											echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['occodephotoList'][$i].'"/><input name="occodephotoList[]" class="imginput" type="hidden" value="'.$reg['occodephotoList'][$i].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
										} }?>
										</div> 
								   </div>
							  	</div>
							</div>
					</div>						
            </div>
            
            <div>
					<h2>企业法人/经办人</h2>
					<div class="clearfix">
						<label><span>*</span>证件持有人类型：</label>
						<div>
							<select name='idtype'>
							     
								<option value="经办人" <?php if($reg['idtype'] == '经办人'){echo "selected='selected'";}?>>经办人</option>
								<option value="法人" <?php if($reg['idtype'] == '法人'){echo "selected='selected'";}?>>法人</option>
							</select>
						</div>	
					</div>
					
					<div class="clearfix">
						<label><span>*</span>证件持有人姓名：</label>
						<div>
							<input type="text" placeholder="" id="document_name" name='idname' value="<?php echo $reg['idname'];?>">
							<p style="display: none; color: red;"></p>
						</div>	
					</div>
					
					<div class="clearfix">
						<label><span>*</span>证件类型：</label>
						<div>
							<select name='idcard'>
								<option>身份证</option>
							</select>
						</div>	
					</div>
					
					<div class="clearfix">
						<label><span>*</span>身份证正面照片：</label>
							<div>
								<p>必须为彩色图片且小于2M，文件格式为bmp、png、jpeg、jpg或gif</p>	
								<div id="js_upload_wrp">
								   <div class="img_upload_wrp group"> 
										<div class="img_upload_box"> 
											 <a class="img_upload_box_oper js_upload js_pic_url" id='idphotoA' href="javascript:">上传文件</a> 
										</div>
										<div class="js_pager">
											<?php if (!empty($reg['idphotoAList'])){ for ($i=0; $i <count($reg['idphotoAList']); $i++) { 
											
											echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['idphotoAList'][$i].'"/><input name="idphotoAList[]" class="imginput" type="hidden" value="'.$reg['idphotoAList'][$i].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
										} }?>
										</div> 
								   </div>
							  	</div>
							</div>
					</div>		
					
					<div class="clearfix">
						<label><span>*</span>身份证反面照片：</label>
							<div>
								<p>必须为彩色图片且小于2M，文件格式为bmp、png、jpeg、jpg或gif</p>	
								<div id="js_upload_wrp">
								   <div class="img_upload_wrp group"> 
										<div class="img_upload_box"> 
											 <a class="img_upload_box_oper js_upload js_pic_url" id='idphotoB' href="javascript:">上传文件</a> 
										</div>
										<div class="js_pager">
											<?php if (!empty($reg['idphotoBList'])){ for ($i=0; $i <count($reg['idphotoBList']); $i++) { 
											
											echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['idphotoBList'][$i].'"/><input name="idphotoBList[]" class="imginput" type="hidden" value="'.$reg['idphotoBList'][$i].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
										} }?>
										</div> 
								   </div>
							  	</div>
							</div>
					</div>		
					
					
					<div class="clearfix">
						<label><span>*</span>证件有效期：</label>
						<div>
							<div id="datepicker" class="input-daterange">
								<input type="text"  name="idstart" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" margin-bottom: 0px; width: 35%; height: 30px;" name='idstart' value="<?php echo $reg['idstart'];?>">
								&nbsp;<span> 到 </span>&nbsp; 
						 		<input type="text" class="input-sm form-control" id="idend" placeholder="结束时间" value="<?php echo $reg['idend'];?>" style=" margin-bottom: 0px; width: 35%;height: 30px;" name='idend'> 
						 		<label><input type="checkbox" id="long_term3" name='idlong'>长期</label>
								
							</div>
							<p style="display: none; color: red;"></p>
						</div>
					</div>
					
					<div class="clearfix">
						<label><span>*</span>证件号码：</label>
						<div>
							<input type="text" placeholder="" id="id_number" name='idnum' value="<?php echo $reg['idnum'];?>">
							<p style="display: none; color: red;"></p>
						</div>	
					</div>					
            </div>
                <input name="type" type="hidden" value="<?php echo $_GET['type'];?>"/>
           		<p class="tj">
                <?php if($_GET['type']){?>
                    <input type="submit"  value="保存"/>
                <?php }else{?>
                    <input type="submit"  value="保存进入下一步"/>
                <?php }?>
           		
           		
           		</p>


           </form>
		</div>
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
  </div>
</div>


<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/dropzone/dropzone.js"></script>
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
<script type="text/javascript">
	        $(document).ready(function() {
				$('#datepicker .input-sm').datepicker({
	                keyboardNavigation: false,
	                forceParse: false,
					format: "yyyy-mm-dd",
	                autoclose: true
	            });
				$('#ymdatepicker .input-sm').datepicker({
	                keyboardNavigation: false,
	                forceParse: false,
					format: "yyyy-mm",
	                autoclose: true
	            });
	           
		
			$('#dataselect .btn-primary').click(function(){
				GetChartData('smcount','linecountChart','canvasdesc');
			});
	});
</script>

<script>
//商户名称
	$("#name").blur(function(){
		if($(this).val()==""){
			$(this).next("p").show();
			$(this).next("p").text("请输入商户名称")
		}else{
			$(this).next("p").hide();
		}
	});
	//注册地址
	$("#registered_address").blur(function(){
		if($(this).val()==""){
			$(this).next("p").show();
			$(this).next("p").text("请输入注册地址")
		}else{
			$(this).next("p").hide();
		}
	});
	//营业执照注册号
	$("#registered_account").blur(function(){
		if($(this).val()==""){
			$(this).next("p").show();
			$(this).next("p").text("请输入营业执照注册号")
		}else{
			$(this).next("p").hide();
		}
	});
	//经营范围
	$("#business_scope").blur(function(){
		if($(this).text()==""){
			$(this).next("p").show();
			$(this).next("p").text("请输入经营范围")
		}else{
			$(this).next("p").hide();
		}
	});
//开始
		$("input[name=start]").blur(function(){
			if($(this).val()==""){
			
		}else{
			$(this).parent().next("p").hide();
		}
		});
			
	//结束
$("input[name=end]").blur(function(){
			if($(this).val()==""){
			
		}else{
			$(this).parent().next("p").hide();
		}
		});
	
	//长期

	$("#long_term,#long_term2,#long_term3").click(function(){
		if($(this).is(":checked")){
			$(this).parent().prev("input").hide();
			$(this).parent().prev("input").prev("span").hide()
		}else{
			$(this).parent().prev("input").show();
			$(this).parent().prev("input").prev("span").show()
		}
	});
	//组织机构代码
	$("#organization_code").blur(function(){
		if($(this).val()==""){
			$(this).next("p").show();
			$(this).next("p").text("请输入组织机构代码")
		}else{
			$(this).next("p").hide();
		}
	});
	//证件持有人姓名
	$("#document_name").blur(function(){
		
		if($(this).val()==""){
			$(this).next("p").show();
			$(this).next("p").text("请输入证件持有人姓名")
		}else{
			$(this).next("p").hide();
		}
	});
	//证件号码
	$("#id_number").blur(function(){
		if($(this).val()==""){
			$(this).next("p").show();
			$(this).next("p").text("请输入证件号码")
		}else{
			$(this).next("p").hide();
		}
	});
	//保存下一步
	$(".tj>input").click(function(){
		//商户名称
		if($("#name").val()==""){
			$("#name").next("p").show();
			$("#name").next("p").text("请输入商户名称")
		}else{
			$("#name").next("p").hide();
		}
	注册地址

		if($("#registered_address").val()==""){
			$("#registered_address").next("p").show();
			$("#registered_address").next("p").text("请输入注册地址")
		}else{
			$("#registered_address").next("p").hide();
		}

	//营业执照注册号
		if($("#registered_account").val()==""){
			$("#registered_account").next("p").show();
			$("#registered_account").next("p").text("请输入营业执照注册号")
		}else{
			$(this).next("p").hide();
		}

	//经营范围

		if($("#business_scope").text()==""){
			$("#business_scope").next("p").show();
			$("#business_scope").next("p").text("请输入经营范围")
		}else{
			$("#business_scope").next("p").hide();
		}
	//开始时间

		if($("input[name=start]").val()==""){
			
			alert("请输入开始时间");
			return false
		}

	//组织机构代码
		if($("#organization_code").val()==""){
			$("#organization_code").next("p").show();
			$("#organization_code").next("p").text("请输入组织机构代码")
		}else{
			$("#organization_code").next("p").hide();
		}
	//证件持有人姓名
		if($("#document_name").val()==""){
			$("#document_name").next("p").show();
			$("#document_name").next("p").text("请输入证件持有人姓名")
		}else{
			$("#document_name").next("p").hide();
		}

	//证件号码
	
		if($("#id_number").val()==""){
			$("#id_number").next("p").show();
			$("#id_number").next("p").text("请输入证件号码")
		}else{
			$("#id_number").next("p").hide();
		}
	return false;
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


//图片上传


$(".js_pic_url,.js_pic_url .icon20_common add_gray").dropzone({
	url: "?m=Agent&c=merchant&a=uploadImg",
	addRemoveLinks: false,
	maxFilesize: 1,
	acceptedFiles: ".jpg,.png",
	uploadMultiple: false,
	init: function() {
		this.on("success", function(file,responseText) {
			var imgtype = this.previewsContainer.id;
			

			var rept = $.parseJSON(responseText);
			var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'+rept.fileUrl+'"><input name="'+imgtype+'List[]" class="imginput" type="hidden" value="'+rept.fileUrl+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';

			// 如果是补充证书 有多张图
			if (imgtype=='annuxes') {
				imgHtml =$(this.element).parent().siblings().html() + imgHtml;
			}

			$(this.element).parents(".img_upload_box").siblings().html(imgHtml);
		});
	}
});
</script>



</body>
</html>