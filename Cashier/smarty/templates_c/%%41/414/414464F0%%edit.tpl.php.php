<?php /* Smarty version 2.6.18, created on 2016-12-19 19:52:27
         compiled from D:%5Ctest%5Cpay%5Cpay%5CCashier%5C./pigcms_tpl/Merchants/System/agent/edit.tpl.php */ ?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>总后台 | 编辑代理商信息</title>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


    <!-- FooTable -->
    <link href="<?php echo @RL_PIGCMS_STATIC_PATH; ?>
plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="<?php echo @RlStaticResource; ?>
plugins/css/iCheck/custom.css" rel="stylesheet">
	<style>
		.ibox{
		 	border: 1px solid #e7eaec;
		}
		.part_item {
  			background: none repeat scroll 0 0 #fff;
  			border: 1px solid #ccc;
  			border-radius: 5px;
  			padding-bottom: 15px;
  			margin-bottom: 10px;
		}
		.form .part_item p {
  			display: inline-block;
  			font-size: 14px;
  			overflow: hidden;
  			padding: 10px 20px 0;
  			text-overflow: ellipsis;
  			white-space: nowrap;
		}
		.part_item_b {
  			border-top: 1px solid #ccc;
  			margin-top: 10px;
		}
		.form .part_item p.active {
  			color: #f87b00;
		}
		.part_item input {
  			font-size: 14px;
  			margin-bottom: 2px;
  			margin-right: 5px;
		}
		.pagination{
			margin:0px;
		}
		.mustInput {
  			color: red;
  			margin-right: 5px;
		}
		@media (min-width: 768px){
			.form .part_item p {
				width: 37%;
			}
		}
		@media (min-width: 992px){
			.form .part_item p {
				width: 24%;
			}
		}
	.form-control, .single-line{width: 50%;}
	
	.ibox {
    border: 1px solid #e7eaec;
    border-top: none;
}

	.tit_h4{ height: 40px; line-height: 40px; padding: 0 20px; width: 100%;margin:0px !important;}
	.tit_h4 span{ color: #676a6c; font-weight: normal;}
	.tit_h4 a{ color: #44b549; font-weight: normal;}
	.jbxi_bg>div{border-top: 1px solid #f2f2f2; padding: 20px 0; margin: 0px !important;float: left; width: 100%;}
	.jbxi_bg>div>label{ width: 120px; text-align: right; float: left; margin-right: 30px;}
	.jbxi_bg>div>div>label{padding-top: 5px;}
	.jbxi_bg>div>div>input{border: none;}
	.form-control{
    width: 80%;
}
.footable-odd {
    background-color: #ffffff;
}
.bc{position: absolute; bottom: -55px; left: 50%; width: 70px; height: 30px; margin-left: -35px; background: #4EBE53; border-radius: 5px; border: none; color: #FFFFFF;}
.shangjia_tit{border-bottom:2px solid #f2f2f2 ; margin-bottom: 0px; padding-left: 20px; background: #FFFFFF; width: 100%; height: 50px; line-height: 50px; text-align: left; border-top:3px solid #d9e6e9 ;font-size: 18px;}
label i{color:#f00;margin-right: 5px;font-style: normal;}
	</style>
</head>

<body>

    <div id="wrapper">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/leftmenu.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

        <div id="page-wrapper" class="gray-bg">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/top.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>代理商信息管理</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>代理中心</a>
                        </li>
                         <li>
                            <a>代理列表</a>
                        </li>
                        <li>
                            <a>代理商信息管理</a>
                        </li>
                        <li class="active">
                            <strong>编辑基本信息</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                    	<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：基本信息
                        -->
                        <p class="shangjia_tit">编辑基本信息</p>
                    	<div class="ibox-content" style="border-top:none;">
                    		
                    		  <div class="panel-body" style="padding: 0px; ">
                                      <form action="/merchants.php?m=System&c=agent&a=edit" id="form" method="post" class="form-horizontal form-border jbxi_bg clearfix" style="width: 95%; margin: 0 auto 60px; position: relative; border: 1px solid #EEEEEE;">
                                    
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>代理商名称</label>
                                        <div>
                                            <input type="hidden" name="aid" value="<?php echo $this->_tpl_vars['row']['aid']; ?>
"/>
                                            <input type="text" name="uname" class="form-control" value="<?php echo $this->_tpl_vars['row']['uname']; ?>
" placeholder="输入代理商名称">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>登陆账号</label>
                                        <div>
                                            <input type="email" name="account" class="form-control" value="<?php echo $this->_tpl_vars['row']['account']; ?>
" placeholder="输入用户名">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label">修改密码</label><input type="checkbox" name="checkbox"  value="1" id="xuanzhe" style="margin-top: 13px;"/>
                                        <div class="mima" style="display: none; margin-left: 50px;">
                                            <label style="width: 82px;  margin-right: 10px; margin-bottom: 10px; margin-top: 20px;"><i>*</i>新密码</label><input type="text" name="password" placeholder="输入新密码 6-16位" style="border:1px #f2f2f2 solid"><br />
                                            <label style="width: 82px; margin-right: 10px"><i>*</i>确认新密码</label><input type="text" name="repassword" placeholder="确认新密码" style="border:1px #f2f2f2 solid">
                                        </div>
                                    </div>
                                     <div class="form-group clearfix">
                                        <label class="control-label"><i>*</i>拥金率</label>
                                        <div>
                                            <input type="text" value="<?php echo $this->_tpl_vars['row']['commission']*100; ?>
" name="commission" class="form-control" placeholder="50%" style=" width: 10%;display:inline-block;"><span>%</span>
                                        </div>
                                    </div>
<!--                                     <div class="form-group clearfix">
                                        <label class="control-label"><i>*</i>一清支付宝佣金</label>
                                        <div>
                                            <input type="text" value="<?php echo $this->_tpl_vars['row']['alicommission']*100; ?>
" name="alicommission" class="form-control" placeholder="50%" style=" width: 10%;display:inline-block;"><span>%</span>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="control-label"><i>*</i>二清微信拥金</label>
                                        <div>
                                            <input type="text" value="<?php echo $this->_tpl_vars['row']['ancommission']*100; ?>
" name="ancommission" class="form-control" placeholder="50%" style=" width: 10%;display:inline-block;"><span>%</span>
                                        </div>
                                    </div>
                                     <div class="form-group clearfix">
                                        <label class="control-label"><i>*</i>二清支付宝佣金</label>
                                        <div>
                                            <input type="text" value="<?php echo $this->_tpl_vars['row']['analicommission']*100; ?>
" name="analicommission" class="form-control" placeholder="50%" style=" width: 10%;display:inline-block;"><span>%</span>
                                        </div>
                                    </div>-->
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>联系人</label>
                                        <div>
                                           <input type="text" value="<?php echo $this->_tpl_vars['row']['contacts']; ?>
" name="contacts" class="form-control" placeholder="联系人">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>联系电话</label>
                                        <div>
                                            <input type="text"  value="<?php echo $this->_tpl_vars['row']['phone']; ?>
" name="phone" class="form-control" placeholder="联系电话">
                                        </div>
                                    </div>
                                   
                                    <div class="form-group clearfix">
                                        <label class="control-label"><i>*</i>公司名称</label>
                                        <div>
                                           <input type="text" name="corporate" value="<?php echo $this->_tpl_vars['row']['corporate']; ?>
" class="form-control" placeholder="公司名称">
                                        </div>
                                    </div>
<!--                                    <div class="frm_controls menu_controls clearfix" style="margin-right:10px;"> 
                                        <label>地址</label>
                                        <select name="provinceid" id="provinceS" class="form-control province" onchange="GetCity();" >
                                            <option value="0">请选择</option>
                                            <?php $_from = $this->_tpl_vars['districts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['avv']):
?>
                                                <option value="<?php echo $this->_tpl_vars['avv']['id']; ?>
" data-fullname="<?php echo $this->_tpl_vars['avv']['fullname']; ?>
" data-lng="<?php echo $this->_tpl_vars['avv']['lng']; ?>
" data-lat="<?php echo $this->_tpl_vars['avv']['lat']; ?>
"><?php echo $this->_tpl_vars['avv']['fullname']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?> 
                                        </select>
                                        <span class="tishi" style="color: red; display: none;"></span>
                                        <br>
                                        <label  style="margin-top: 10px;">详细地址</label>
                                        <div style="margin-top: 10px;"><input style=" border:1px solid #f2f2f2"  name="address" class="form-control" type="text" placeholder="输入详细地址"><span style="color: red; display: none;"></span></div>

                                        <input name="provincename" id="provinceinfo" type="hidden" value=""/>
                                        <input name="cityname" id="cityinfo" type="hidden"  value=""/> 
                                        <input name="countyname" id="districtinfo" type="hidden"  value=""/> 
                                       
                                    </div>-->
                                </form>
                                <button class="bc">保存</button>

                            </div>
                    	</div>
                    	<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：end
                        -->
                        
                    </div>
                </div>
            </div>
        </div>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
     </div>
    </div>
  <script>
  	$("#xuanzhe").click(function(){
  		if($(this).is(':checked')){
                 $(this).val('1');
 		$(".mima").show();
 	}else{
            $(this).val('0');
            $(".mima").hide();
 	}
  	})
        $(".bc").click(function(){
            
            $('#form').submit();
        })
  </script>

    <!-- FooTable -->
    <script src="<?php echo @RlStaticResource; ?>
plugins/js/footable/footable.all.min.js"></script>
	
	<!-- iCheck -->
    <script src="<?php echo @RlStaticResource; ?>
plugins/js/iCheck/icheck.min.js"></script>
	
	<!-- Jquery Validate -->
    <script src="<?php echo @RlStaticResource; ?>
plugins/js/validate/jquery.validate.min.js"></script>

    <!-- Page-Level Scripts -->
<script>
  
         function GetCity(){
             
	 var obj= $('#provinceS');
     var provinceid=obj.val();
	 var provincename=obj.find("option:selected").data('fullname');
	 var lng=obj.find("option:selected").data('lng');
	 var lat=obj.find("option:selected").data('lat');
	 $('#provinceinfo').val(provincename);
	 
	 var cityHtml='&nbsp;&nbsp;&nbsp;<select name="cityid" id="cityS" class="form-control" onchange="GetDistrict();"><option value="0">请选择</option>'
	 $.post('?m=System&c=agent&a=GetDistrict',{districtid:provinceid},function(ret){
	   if(ret.data){
	      $.each(ret.data,function(nn,vv){
		     cityHtml+='<option value="'+vv.id+'" data-fullname="'+vv.fullname+'" data-lng="'+vv.lng+'" data-lat="'+vv.lat+'" >'+vv.fullname+'</option>';
		  });
		  cityHtml+='</select>';
		  $('#cityS').remove();
		  $('#districtS').remove();
		  $('#circleS').remove();
		  obj.after(cityHtml);
	   }
	 },'JSON');
  }

 function GetDistrict(){
 	 var obj= $('#cityS');
     var cityid=obj.val();
	 var cityname=obj.find("option:selected").data('fullname');
	 var lng=obj.find("option:selected").data('lng');
	 var lat=obj.find("option:selected").data('lat');
	 $('#cityinfo').val(cityname);
	
	 var cityHtml='&nbsp;&nbsp;&nbsp;<select name="countyid" id="districtS" class="form-control" onchange="GetCircle();"><option value="0">请选择</option>'
	 $.post('?m=System&c=agent&a=GetDistrict',{districtid:cityid},function(ret){
	   if(ret.data){
	      $.each(ret.data,function(nn,vv){
		     cityHtml+='<option value="'+vv.id+'" data-fullname="'+vv.fullname+'" data-lng="'+vv.lng+'" data-lat="'+vv.lat+'" >'+vv.fullname+'</option>';
		  });
		  cityHtml+='</select>';
		  $('#districtS').remove();
		  $('#circleS').remove();
		  obj.after(cityHtml);
	   }
		
	 },'JSON');
 }
 function GetCircle(){
	var obj= $('#districtS');
	var districtid=obj.val();
	var districtname=obj.find("option:selected").data('fullname');
	var lng=obj.find("option:selected").data('lng');
	var lat=obj.find("option:selected").data('lat');
   $('#districtinfo').val(districtname);
   //init(lat,lng,17);
    
 }
</script>
</body>
</html>