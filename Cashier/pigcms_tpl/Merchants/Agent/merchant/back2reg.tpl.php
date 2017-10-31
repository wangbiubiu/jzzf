<!DOCTYPE html>
<html>
<head>
<title>进件管理 | 进件查看</title>
<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/wxCoupon.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
<link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
<style>

.tj{ width: 300px; margin: 0 auto;}
.tj>input{ width: 100px; text-align: center;height: 30px; line-height: 30px; border: none; border-radius: 2px; background: #2f9833; margin-right: 20px; color: #FFFFFF;}
.tj>button{ width: 100px; text-align: center;height: 32px; line-height: 32px; border-radius: 2px; background: #FFFFFF; margin-right: 20px; border: 1px solid #f2f2f2;}
.tj>button>a{ color: #202020;}
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

.role_permission{background: #FFFFFF;}
.role_permission>h1{ font-size: 18px; border-bottom:1px solid #f2f2f2 ; height: 40px; line-height: 40px; border-top: 3px solid #B5D6FD; margin: 0px; padding-left: 20px;}
.role_permission>div{ border: 1px solid #f2f2f2; margin:20px  auto; width: 98%;}
.role_permission>div>h2,.select_permissions>h2{ height: 40px; line-height: 40px; padding: 0 10px; background: #f2f2f2; margin: 0px; font-size: 16px; font-weight: normal;}
.role_permission>div>p,.select_permissions>p{ min-height: 40px; line-height: 40px; margin-bottom: 0px;}
.role_permission>div>p>label:first-child,.select_permissions>p>label:first-child{ width: 120px; text-align: right; margin-right: 20px; margin-bottom: 0px;}
.role_permission>div>p>input,.select_permissions>p>input{ width: 150px; height: 25px; margin-right: 30px;}
.role_permission>div>p>select,.select_permissions>p>select{ width: 150px; height: 25px; margin-right: 30px; margin-left: 10px;}
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
						<li><a>Agent</a></li>
						<li><a>商户中心</a></li>
						<li><a>进件管理</a></li>
						<li class="active"><strong>进件查看</strong></li>
					</ol>
				</div>
				<div class="col-lg-2"></div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row role_permission" style="position: relative; padding-bottom: 50px;">
					<div>


						<h2>联系信息 <a style="float: right; padding-right: 10px;" href="?m=Agent&c=merchant&a=go2Regeist&type=2&mid=<?php echo $_GET['mid'];?>">修改</a></h2>
						<p><label>联系人姓名：</label><span><?php echo $reg['contactor'];?></span></p>
						<p><label>手机号码：</label><span><?php echo $reg['tel'];?></span></p>
						<p><label>常用邮箱：</label><span><?php echo $reg['email'];?></span></p>
						
						
						<div class="select_permissions ">
    						<h2>经营信息<!--   <a style="float: right; padding-right: 10px;" href="?m=Agent&c=merchant&a=go2Regeist&mid=<?php echo $_GET['mid'];?>">修改</a>--></h2>
    						<p><label>商户简称：</label><span><?php echo $reg['shortname']?></span></p>
    						<p><label>经营类目：</label><span>
    						<?php echo $lvl['fir']?>>
    						<?php echo $lvl['sec']?>>
    						<?php echo $lvl['thr']?></span></p>
    						<p><label>特殊资质：</label>
    						<img style="width: 100px; height: 150px; margin-left: 50px; overflow: hidden;" src="<?php $str =  json_decode($reg['special']); echo $str[0];?>">
    							
    						</p>
    						<p><label>售卖商品描述：</label><span><?php echo $reg['dealdesc'];?></span></p>
    						<p><label>客服电话：</label><span><?php echo $reg['phone'];?></span></p>
    						<p><label>公司网站：</label><span><?php echo $reg['website'];?></span></p>
    						<p><label>补充材料：</label>
    						
    						<?php for ($i=0;$i<count($reg['annexs']);$i++) { ?>
    
    						<img style="width: 100px; height: 150px; margin-left: 50px; overflow: hidden;" src="<?php $arr = json_decode($reg['annexs']); echo $arr[$i]; ?>" >
    						<?php } ?>
    							
    						</p>
					</div>
	
					</div>
					<!-- 
                    	作者：2721190987@qq.com
                    	时间：2016-10-29
                    	描述：经营信息
                    
					<div class="select_permissions ">
						<h2>经营信息<!--   <a style="float: right; padding-right: 10px;" href="?m=Agent&c=merchant&a=go2Regeist&mid=<?php echo $_GET['mid'];?>">修改</a>--</h2>
						<p><label>商户简称：</label><span><?php echo $reg['shortname']?></span></p>
						<p><label>经营类目：</label><span>
						<?php echo $lvl['fir']?>>
						<?php echo $lvl['sec']?>>
						<?php echo $lvl['thr']?></span></p>
						<p><label>特殊资质：</label>
						<img style="width: 100px; height: 150px; margin-left: 50px; overflow: hidden;" src="<?php $str =  json_decode($reg['special']); echo $str[0];?>">
							
						</p>
						<p><label>售卖商品描述：</label><span><?php echo $reg['dealdesc'];?></span></p>
						<p><label>客服电话：</label><span><?php echo $reg['phone'];?></span></p>
						<p><label>公司网站：</label><span><?php echo $reg['website'];?></span></p>
						<p><label>补充材料：</label>
						
						<?php for ($i=0;$i<count($reg['annexs']);$i++) { ?>

						<img style="width: 100px; height: 150px; margin-left: 50px; overflow: hidden;" src="<?php $arr = json_decode($reg['annexs']); echo $arr[$i]; ?>" >
						<?php } ?>
							
						</p>
					</div>
					-->
					<!--
                    	作者：2721190987@qq.com
                    	时间：2016-10-29
                    	描述：商户信息
                    -->
					<div class="select_permissions ">
						<h2>商户信息 <a style="float: right; padding-right: 10px;" href="?m=Agent&c=merchant&a=regMerchantInfo&mid=<?php echo $_GET['mid'];?>">修改</a></h2>
						<div>
							<h3>基本信息</h3>
							<p><label>商户名称：</label><span><?php echo $reg['company'];?></span></p>
							<p><label>注册地址：</label><span><?php echo $reg['address'];?></span></p>
						</div>
						<div>
							<h3>营业执照</h3>
							<p><label>营业执照注册号：</label><span><?php echo $reg['icence'];?></span></p>
							<p><label>经营范围：</label>
							<span><?php echo $reg['mcarea'];?></span>
							</p>
							<p><label>营业期限：</label><span><?php echo $reg['starttime'];?>&nbsp&nbsp至&nbsp&nbsp<?php echo $reg['endtime'];?></span></p>
							<p><label>营业执照照片：</label><span><img style="width: 120px; height: 90px; overflow: hidden;" src="<?php $str =  json_decode($reg['licencephotoList']); echo $str[0];?>""></span></p>
						</div>
						<div>
							<h3>组织机构代码信息</h3>
							<p><label>组织机构代码：</label><span><?php echo $reg['occode'];?></span></p>
							<p><label>有效期：</label><span><?php echo $reg['validatestart'];?>&nbsp&nbsp至&nbsp&nbsp<?php echo $reg['validateend'];?></span></p>
							<p><label>组织机构代码证照片：</label><span><img style="width: 120px; height: 90px; overflow: hidden;" src="<?php $str =  json_decode($reg['occodephotoList']); echo $str[0];?>"></span></p>
						</div>
						
						<div>
							<h3>企业法人/经办人</h3>
							<p><label>证件持有人类型：</label><span><?php echo $reg['idtype'];?></span></p>
							<p><label>证件持有人姓名：</label><span><?php echo $reg['idname'];?></span></p>
							<p><label>证件类型：</label><span><?php echo $reg['idcard'];?></span></p>
							<p><label>身份证正面照：</label><span><img style="width: 150px; height: 80px; overflow: hidden;" src="<?php $str =  json_decode($reg['idphotoAList']); echo $str[0];?>"></span></p>
							<p><label>身份证反面照：</label><span><img style="width: 150px; height: 80px; overflow: hidden;" src="<?php $str =  json_decode($reg['idphotoBList']); echo $str[0];?>"></span></p>
							<p><label>有效时间：</label><span><?php echo $reg['idstart'];?>&nbsp&nbsp至&nbsp&nbsp<?php echo $reg['idend'];?></span></p>
							<p><label>证件号码：</label><span><?php echo $reg['idnum'];?></span></p>
						</div>
					</div>
					
					<!--
                    	作者：2721190987@qq.com
                    	时间：2016-10-29
                    	描述：结算信息
                    -->
					<div class="select_permissions ">
						<h2>结算信息 <a style="float: right; padding-right: 10px;" href="?m=Agent&c=merchant&a=examine&mid=<?php echo $_GET['mid'];?>">修改</a></h2>
						<p><label>账户类型：</label><span><?php echo $reg['accountType'];?></span></p>
						<p><label>开户名称：</label><span><?php echo $reg['account'];?></span></p>
						<p><label>开户银行：</label><span><?php echo $reg['bank'];?></span></p>
						<p><label>开户银行城市：</label><span><?php echo $reg['bankaddress'];?></span></p>
						<p><label>开户支行：</label><span><?php echo $reg['bank_branch'];?></span></p>
						<p><label>银行账户：</label><span><?php echo $reg['accountid'];?></span></p>
						
					</div>
					<input type="hidden" name="id" value='<?php if (!empty($reg['id'])) echo $reg['id']; ?>'> 
					
					<p class="tj">
						
						<button type='button'>
						<a  href="?m=Agent&c=merchant&a=showReg&mid=<?php echo $_GET['mid'];?>">完成</a>
						</button>
					</p>
					
					
	            </div>
					


			</div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
	</div>


<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>

</html>