<?php /* Smarty version 2.6.18, created on 2017-10-27 16:27:38
         compiled from C:%5CUsers%5CAdministrator%5CDesktop%5Clll%5CCashier%5C./pigcms_tpl/Merchants/System/agent/add.tpl.php */ ?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>收银台 | 员工列表</title>
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
.form-control{ display: inline-block !important; width: 22% !important;}
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
                    <h2>代理列表</h2>
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
                        <li class="active">
                            <strong>添加代理</strong>
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
                        <p class="shangjia_tit">添加代理</p>
                    	<div class="ibox-content" style="border-top:none;">
                    		
                    		  <div class="panel-body" style="padding: 0px; ">
                                      <form action="/merchants.php?m=System&c=agent&a=add" method="post" id="form1" class="form-horizontal form-border jbxi_bg clearfix" style="width: 95%; margin: 0 auto 60px; position: relative; border: 1px solid #EEEEEE;">
                                    
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>代理商名称</label>
                                        <div>
                                            <input type="text" name="uname" class="form-control" placeholder="公司填公司名称个人填个人名称"><span style="color: red; display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>登录账号</label>
                                        <div>
                                            <input type="email" class="form-control" name="account" placeholder="请使用邮箱名"><span style="color: red; display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">

                                            <label><i>*</i>新密码</label><input id="nowPwd" class="form-control" type="password" name="password" placeholder="请输入新密码 6-16位" style="border: none;"><span style="color: red; display: none;"></span><br /><br />
                                            <label><i>*</i>确认新密码</label><input id="confirmPwd" class="form-control" type="password" name="repassword" placeholder="确认新密码" style="border: none;"><span style="color: red; display: none;"></span>
                 
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>联系人</label>
                                        <div>
                                           <input type="text" class="form-control" name="contacts" placeholder="公司填公司法人名|个人填个人名"><span style="color: red; display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
					<label class=" control-label"><i>*</i>联系电话</label>
                                        <div>
                                        
                                            <input type="text" id="tel" class="form-control" name="phone" placeholder="手机号"onkeyup="this.value=this.value.replace(/\D/g,'')"  ><span style="color: red; display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>公司名称</label>
                                        <div>
                                            <input type="text" class="form-control" name="corporate" placeholder="公司名称"><span style="color: red; display: none;"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="frm_controls menu_controls clearfix" style="margin-right:10px;"> 
                                        <label><i>*</i>地址</label>
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
                                        <label  style="margin-top: 10px;"><i>*</i>详细地址</label>
                                        <div style="margin-top: 10px;"><input style=" border:1px solid #f2f2f2"  name="address" class="form-control" type="text" placeholder="输入详细地址"><span style="color: red; display: none;"></span></div>

                                        <input name="provincename" id="provinceinfo" type="hidden" value=""/>
                                        <input name="cityname" id="cityinfo" type="hidden"  value=""/> 
                                        <input name="countyname" id="districtinfo" type="hidden"  value=""/>

                                    </div>

                                          <div class="form-group clearfix ">
                                          <label class="control-label"><i >*</i>佣金商户类型</label>
<!--                                          <i style="color: red ;padding-right: 10px">*</i><b>特约通道</b> <input type="radio"  name="mtype" value="1" id="tei">&ensp;&ensp;&ensp;<i style="color: red ;padding-right: 10px">*</i><b>银行通道</b><input type="radio"  name="mtype" id="yin" value="2" >-->
                                          <div>
                                              特约通道<input type="checkbox" name="mtype[]" value="1" id="mtypes"  style="margin-top: 5px;"> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                                              银行直连<input type="checkbox" value="2" id="mtype" name="mtype[]">&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                                              金海哲<input type="checkbox" value="3" id="jhzz" name="mtype[]">
                                          </div>

                                      </div>
                                    <div class="form-group clearfix " id="teiyue">
                                        <label class="control-label"><i>*</i>特约通道</label>
                                        <div  >
<!--                                        <b>支付宝:</b><input type="text" class="form-control" name="commission" placeholder="请输入特约通道支付宝佣金返点">%  <span style="color: red; display: none;"></span>-->
                                            <b>支付宝结算率:</b>
                                            <select style="width: 150px;margin-top: 5px;" name="alicommission" >
                                                <option value="0" selected="selected">请选择佣金费率</option>
                                                <?php $_from = $this->_tpl_vars['teAli']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['teAli']):
?>
                                                <option value="<?php echo $this->_tpl_vars['teAli']; ?>
"><?php echo $this->_tpl_vars['teAli']; ?>
</option>
                                                <?php endforeach; endif; unset($_from); ?>

                                            </select>
                                            &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                                            <b>微信结算率:</b>
                                            <select style="width: 150px;margin-top: 5px;" name="commission">
                                                <option value="0" selected="selected">请选择佣金费率</option>
                                                <?php $_from = $this->_tpl_vars['teWx']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['teWx']):
?>
                                                <option value="<?php echo $this->_tpl_vars['teWx']; ?>
"><?php echo $this->_tpl_vars['teWx']; ?>
</option>
                                                <?php endforeach; endif; unset($_from); ?>
                                            </select>
                                        </div>
                                    </div>
                                  <div class="form-group clearfix" id="yinhang">
                                      <label class="control-label"><i>*</i>银行通道</label>
                                      <div>

                                          <b>支付宝结算率:</b>
                                          <select style="width: 150px;margin-top: 5px;" name="analicommission" >
                                              <option value="0" selected="selected">请选择佣金费率</option>
                                              <?php $_from = $this->_tpl_vars['yinAlis']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['yinAli']):
?>
                                              <option value="<?php echo $this->_tpl_vars['yinAli']; ?>
"><?php echo $this->_tpl_vars['yinAli']; ?>
</option>
                                              <?php endforeach; endif; unset($_from); ?>
                                          </select>
                                          &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                                          <b>微信结算率:</b>
                                          <select style="width: 150px;margin-top: 5px;" name="ancommission">
                                              <option value="0" selected="selected">请选择佣金费率</option>
                                              <?php $_from = $this->_tpl_vars['yinWx']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['yinWx']):
?>
                                              <option value="<?php echo $this->_tpl_vars['yinWx']; ?>
"><?php echo $this->_tpl_vars['yinWx']; ?>
</option>
                                              <?php endforeach; endif; unset($_from); ?>
                                          </select>
                                      </div>
                                  </div>
                                  
                                    <div class="form-group clearfix " id="jhz">
                                        <label class="control-label"><i>*</i>金海哲通道</label>
                                        <div  >
<!--                                        <b>支付宝:</b><input type="text" class="form-control" name="commission" placeholder="请输入特约通道支付宝佣金返点">%  <span style="color: red; display: none;"></span>-->
                                            <b>qq结算率:</b>
                                            <select style="width: 150px;margin-top: 5px;" name="qqcommission" >
                                                <option value="0" selected="selected">请选择佣金费率</option>
                                                <?php $_from = $this->_tpl_vars['jhzqqs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['jhzqq']):
?>
                                                <option value="<?php echo $this->_tpl_vars['teAli']; ?>
"><?php echo $this->_tpl_vars['jhzqq']; ?>
</option>
                                                <?php endforeach; endif; unset($_from); ?>

                                            </select>
                                            &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                                            <b>微信结算率:</b>
                                            <select style="width: 150px;margin-top: 5px;" name="wxcommission">
                                                <option value="0" selected="selected">请选择佣金费率</option>
                                                <?php $_from = $this->_tpl_vars['jhzwxs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['jhzwx']):
?>
                                                <option value="<?php echo $this->_tpl_vars['jhzwx']; ?>
"><?php echo $this->_tpl_vars['jhzwx']; ?>
</option>
                                                <?php endforeach; endif; unset($_from); ?>
                                            </select>
                                        </div>
                                    </div>
                                    
<!--                                    <div class="form-group clearfix">
                                        <label class="control-label"><i>*</i>一清支付宝佣金</label>
                                        <div>
                                          <input type="text" class="form-control" name="alicommission" placeholder="请输入支付宝佣金返点">%  <span style="color: red; display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="control-label"><i>*</i>二清微信佣金</label>
                                        <div>
                                          <input type="text" class="form-control" name="ancommission" placeholder="请输入微信佣金返点">%  <span style="color: red; display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="control-label"><i>*</i>二清支付宝佣金</label>
                                        <div>
                                          <input type="text" class="form-control" name="analicommission" placeholder="请输入支付宝佣金返点">%  <span style="color: red; display: none;"></span>
                                        </div>
                                    </div>-->
                                </form>
                                <button class="bc">提交</button>

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
   
	
	<script type="text/html" id="employersEditTpl">
		<figure>
              <iframe width="425" height="349" src="?m=User&c=merchant&a=employersEdit&eid={($eid)}" frameborder="0"></iframe>
        </figure>
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
<!--    通道-->
    <script>
        $(function () {
            $('#teiyue').hide();
            $('#yinhang').hide();
            $('#jhz').hide();
            $("#mtypes").click(function () {
                if ($(this).prop('checked')==true) {
                    $('#teiyue').show();
                }else {
                    $('#teiyue').hide();
                }
            });
            $('#mtype').click(function () {
                if ($(this).prop('checked')==true) {
                    $('#yinhang').show();
                }else {
                    $('#yinhang').hide();
                }
            })
             $('#jhzz').click(function () {
                if ($(this).prop('checked')==true) {
                    $('#jhz').show();
                }else {
                    $('#jhz').hide();
                }
            })
        });
    </script>
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
    <!-- Page-Level Scripts -->
    <script>
        input = false;
        pass = false;
        tel = false;
    	$("input").blur(function(){
    		if($(this).val()==""){
    			$(this).next("span").show();
    			$(this).next("span").text("此项为必填项");
                        input = false;
    		}else{
                     input = true;
    			$(this).next("span").hide();
    		}
    	});
        
      
        
    	$("#confirmPwd").blur(function(){
    		var nowPwd = $("#nowPwd").val();
    		if($(this).val()!=nowPwd){
    			$(this).next("span").show();
    			$(this).next("span").text("密码不一致请重新输入");
    			$(this).val("");
                         pass = false;
    		}else{
    			$(this).next("span").hide();
                         pass = true;
    		}
    	});
    	
    	$("#tel").blur(function(){
    	var phone = $(this).val();
    		var tel = /^1[3|4|5|7|8]\d{9}$/;
    		if($(this).val()==""){
    			$(this).next("span").show();
    			$(this).next("span").text("请输入手机号码")
                        tel = false;
    		}else if(!tel.exec(phone)){
    			$(this).next("span").show();
    			$(this).next("span").text("电话号码格式错误")	
                        tel = false;
                        
    		}else{
    			$(this).next("span").hide();
                        tel = true;
    		}
    	});
//    	$("select").blur(function(){
//            if($(this).children("option").val()!="0"){
//                $(this).next("span").hide();
//        }
//        })
        
    	
    	$(".bc").click(function(){
    	var tel = /^1[3|4|5|7|8]\d{9}$/;
    	var phone = $("input[name='phone']").val();
         if($("input[name='uname']").val()==""){
         	$("input[name='uname']").next("span").show();
    			$("input[name='uname']").next("span").text("此项为必填项");
                    return false;
    		}else{
                  
    			$("input[name='uname']").next("span").hide();
    		}
    		
    	 if($("input[name='account']").val()==""){
         	$("input[name='account']").next("span").show();
    			$("input[name='account']").next("span").text("此项为必填项");
                    return false;
    		}else{
                  
    			$("input[name='account']").next("span").hide();
    		}
    	
    	 if($("input[name='password']").val()==""){
         	$("input[name='password']").next("span").show();
    			$("input[name='password']").next("span").text("此项为必填项");
                    return false;
    		}else{
                  
    			$("input[name='password']").next("span").hide();
    		}
    		
    	if($("input[name='repassword']").val()==""){
         	$("input[name='repassword']").next("span").show();
    			$("input[name='repassword']").next("span").text("此项为必填项");
                    return false;
    		}else{
                  
    			$("input[name='repassword']").next("span").hide();
    		}	
    	
    	
    	
    	
    	 if($("input[name='contacts']").val()==""){
         	$("input[name='contacts']").next("span").show();
    			$("input[name='contacts']").next("span").text("此项为必填项");
                    return false;
    		}else{
                  
    			$("input[name='contacts']").next("span").hide();
    		}
    	
    	 if($("input[name='phone']").val()==""){
         	$("input[name='phone']").next("span").show();
    			$("input[name='phone']").next("span").text("请输入手机号码");
                    return false;
    		}else if(!tel.exec(phone)){
    			$("input[name='phone']").next("span").show();
    			$("input[name='phone']").next("span").text("电话号码格式错误")	
                   return false;      
    		}else{
                $("input[name='phone']").next("span").hide();
    		}  
    		
    	if($("input[name='corporate']").val()==""){
         	$("input[name='corporate']").next("span").show();
    			$("input[name='corporate']").next("span").text("此项为必填项");
                    return false;
    		}else{
                  
    			$("input[name='corporate']").next("span").hide();
    		}  
        
        if($("select").length<3 ){
                if($("#provinceinfo").val()==""){
                    alert('请选择省份');
                    return false;
                }else if($("#cityinfo").val()==""){
                    alert('请选择城市');
                    return false;
                }
                
                }else{
                  if($("#provinceinfo").val()==""){
                        alert('请选择省份');
                        return false;
                  }else if($("#cityinfo").val()==""){
                        alert('请选择城市');
                        return false;
                  }
				  
				  //else if($("#districtinfo").val()==""){
                   //     alert('请选择地区');
                  //      return false;
                 // }
                  }
                  
                  
        if($("input[name='address']").val()==""){
	         	$("input[name='address']").next("span").show();
	    			$("input[name='address']").next("span").text("此项为必填项");
	                    return false;
	    		}else{
	                  
	    			$("input[name='address']").next("span").hide();
	    		} 
          
         if($("input[name='commission']").val()==""){
	         	$("input[name='commission']").next("span").show();
	    			$("input[name='commission']").next("span").text("此项为必填项");
	                    return false;
	    		}else{
	                $("input[name='commission']").next("span").hide();
	              
	    		} 
         
          if($("input[name='alicommission']").val()==""){
	         	$("input[name='alicommission']").next("span").show();
	    			$("input[name='alicommission']").next("span").text("此项为必填项");
	                    return false;
	    		}else{
	                $("input[name='alicommission']").next("span").hide();
	              $('#form1').submit();    
	    		}    
            
            
            
            
         
            
 
    	});
    </script>

</body>
</html>