<!DOCTYPE html>
<html>
<head>
<title>门店管理</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
<link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
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

.role_permission{background: #FFFFFF;}
.role_permission>h1{ font-size: 18px; border-bottom:1px solid #f2f2f2 ; height: 40px; line-height: 40px; border-top: 3px solid #B5D6FD; margin: 0px; padding-left: 20px;}
.role_permission>div{ border: 1px solid #f2f2f2; margin:20px  auto; width: 98%;}
.role_permission>div>h2{ height: 40px; line-height: 40px; padding: 0 10px; background: #f2f2f2; margin: 0px; font-size: 16px; font-weight: normal;}
.role_permission>div>p{ min-height: 40px; line-height: 40px; margin-bottom: 0px;}
.role_permission>div>p>label:first-child{ width: 120px; text-align: right; margin-right: 20px; margin-bottom: 0px;}
.role_permission>div>p>input{ width: 150px; height: 25px; margin-right: 30px;}
.role_permission>div>p>select{ width: 150px; height: 25px; margin-right: 30px; margin-left: 10px;}
.role_permission>label{ min-width:200px;margin-left: 20px;}
.role_permission>label>select{ width: 150px; margin-left: 10px;}
.role_permission>label>div{cursor: pointer; height: 60px; width: 400px; border: 1px  solid #f2f2f2; overflow: hidden; overflow-y: auto; float: right; margin-left: 10px;}

.select_permissions>div{ min-height: 40px;  line-height: 40px; border-top:1px solid #f2f2f2 ; width: 95%; margin: 0 auto; padding: 10px 0; }

#download{float:right;  padding: 0 10px; margin-top:5px; margin-right: 10px; display: inline-block; width: 60px; text-align: center; background: #008fd3;border-radius:2px; height: 25px; line-height: 25px; font-size: 16px; color: #FFFFFF;}

.bc{ text-align: center; height: 30px; line-height: 30px; background: #008fd3; color: #FFFFFF; border: none; border-radius: 2px; margin: 0 auto; width: 66px; position: absolute; left: 50%; margin-left: -33px; bottom: 20px;}
.select_permissions>div>h3{ border-left: 4px solid #37B737; padding-left: 20px; font-style: 16px; height: 30px; line-height: 30px; margin-bottom: 20px;}
.select_permissions>div>p>label{display: inline-block; width: 150px; text-align: right; margin-right: 10px;}
span{color: #AAAAAA;}
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
						<li class="active"><strong>进件查看</strong></li>
					</ol>
				</div>
				<div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row role_permission" style="position: relative; padding-bottom: 50px;">
					<h1>某某商户进件查看 <a id="download"  href="#">下载</a></h1>
					<label>状态：<select>
						<option>已驳回</option>
					</select></label>
					<br />	
					<label>备注：
						<div contenteditable>
						
						</div>
					</label>
					<!--
                    	作者：2721190987@qq.com
                    	时间：2016-10-29
                    	描述：联系信息
                    -->
					<div>
						<h2>联系信息</h2>
						<p><label>联系人姓名：</label><span>胡小姐</span></p>
						<p><label>手机号码：</label><span>13333333333</span></p>
						<p><label>常用邮箱：</label><span>1542554625@qq.com</span></p>
	
					</div>
					<!--
                    	作者：2721190987@qq.com
                    	时间：2016-10-29
                    	描述：经营信息
                    -->
					<div class="select_permissions ">
						<h2>经营信息</h2>
						<p><label>商户简称：</label><span>胡小姐</span></p>
						<p><label>经营类目：</label><span>企业>医疗>保健器械/医疗器械/非处方药</span></p>
						<p><label>特殊资质：</label><span>虚伪彩色图片且小于2M，文件格式为bmp、png、jpeg/jpe或gif</span><br />
						<img style="width: 100px; height: 150px; margin-left: 50px; overflow: hidden;" src="./Cashier/pigcms_static/image/alibiao.png">
							
						</p>
						<p><label>售卖商品描述：</label><span>零售：中成药、中药材、</span></p>
						<p><label>客服电话：</label><span>1542554625</span></p>
						<p><label>公司网站：</label><span></span></p>
						<p><label>补充材料：</label><span></span></p>
					</div>
					
					<!--
                    	作者：2721190987@qq.com
                    	时间：2016-10-29
                    	描述：商户信息
                    -->
					<div class="select_permissions ">
						<h2>商户信息</h2>
						<div>
							<h3>基本信息</h3>
							<p><label>商户名称：</label><span>重庆市万和药方连锁有限公司</span></p>
							<p><label>注册地址：</label><span>重庆市南岸区江桥路11号A号厂房3 楼</span></p>
						</div>
						<div>
							<h3>营业执照</h3>
							<p><label>营业执照注册号：</label><span>500246545662</span></p>
							<p><label>经营范围：</label><span>零售化学药制剂、抗什么、生化药品、中成药、中成药材、中药饮片。（以上经营内容涉及行政许可的，在许可核定的范围和期限经营，未取得许可证和超过许可证期限的不得经营）</span></p>
							<p><label>营业期限：</label><span>2013-12-08至长期</span></p>
							<p><label>营业执照照片：</label><span><img style="width: 120px; height: 90px; overflow: hidden;" src="./Cashier/pigcms_static/image/alibiao.png"></span></p>
						</div>
						<div>
							<h3>组织机构代码信息</h3>
							<p><label>组织机构代码：</label><span>124563548-5</span></p>
							<p><label>有效期：</label><span>2013-11-15至2024-11-15</span></p>
							<p><label>组织机构代码证照片：</label><span><img style="width: 120px; height: 90px; overflow: hidden;" src="./Cashier/pigcms_static/image/alibiao.png"></span></p>
						</div>
						
						<div>
							<h3>企业法人/经办人</h3>
							<p><label>证件持有人类型：</label><span>法人</span></p>
							<p><label>证件持有人姓名：</label><span>康有为</span></p>
							<p><label>证件类型：</label><span>身份证</span></p>
							<p><label>身份证正面照：</label><span><img style="width: 150px; height: 80px; overflow: hidden;" src="./Cashier/pigcms_static/image/alibiao.png"></span></p>
							<p><label>身份证反面照：</label><span><img style="width: 150px; height: 80px; overflow: hidden;" src="./Cashier/pigcms_static/image/alibiao.png"></span></p>
							<p><label>有效时间：</label><span>2013-11-15至2024-11-15</span></p>
							<p><label>证件号码：</label><span>544554879987521158</span></p>
						</div>
					</div>
					
					<!--
                    	作者：2721190987@qq.com
                    	时间：2016-10-29
                    	描述：结算信息
                    -->
					<div class="select_permissions ">
						<h2>结算信息</h2>
						<p><label>账户类型：</label><span>对公账户</span></p>
						<p><label>开户名称：</label><span>重庆万和药方邮箱公司</span></p>
						<p><label>开户银行：</label><span>中国银行</span></p>
						<p><label>开户银行城市：</label><span>重庆重庆市</span></p>
						<p><label>开户支行：</label><span>中国银行重庆解放碑支行</span></p>
						<p><label>银行账户：</label><span>51515151515545454</span></p>
						
					</div>
					
					
	            </div>
			</div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
	</div>


<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>

</html>