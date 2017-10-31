<?php /* Smarty version 2.6.18, created on 2016-03-15 11:31:17
         compiled from D:%5Cvirtualhost%5Cxxzckj%5CCashier%5C./pigcms_tpl/Merchants/System/index/affiliate.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 | 特约商户管理</title>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
wxCoupon/wxCoupon.css" rel="stylesheet">
	<link href="<?php echo @RlStaticResource; ?>
plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="<?php echo @RL_PIGCMS_STATIC_PATH; ?>
plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="<?php echo @RlStaticResource; ?>
plugins/css/iCheck/custom.css" rel="stylesheet">
	<script src="<?php echo @RlStaticResource; ?>
plugins/js/footable/footable.all2.min.js"></script>
	<script src="<?php echo @RlStaticResource; ?>
plugins/js/iCheck/icheck.min.js"></script>
	<style type="text/css">
	#listfootable .fa-edit{ color: #3DA142;font-size: 20px;}
	#listfootable .tips{ color: #3DA142;cursor: pointer;}
	#listfootable .tips span{ display: none;} 
	#listfootable .prelative .form-control {
    display: none;
    vertical-align: middle;
    width: auto;
	height: 30px;
	padding: 3px 10px;
 }
 #usertoname {border-radius: 7px;height: 35px;display: inline-block;width:220px;margin-bottom:1px; float: none;}
	</style>
</head>
<body>
    <div id="wrapper">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/leftmenu.tpl.php", 'smarty_include_vars' => array()));
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
                    <h2>管理后台</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>System</a>
                        </li>
                        <li>
                            <a>index</a>
                        </li>
                        <li class="active">
                            <strong>设置微信特约商户</strong>
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
                        <div class="ibox-title">
                            <h5>设置微信特约商户</h5>
							<span style="float:right;">商家信息列表&nbsp;&nbsp;(共：<?php echo $this->_tpl_vars['totalnum']; ?>
 条)</span>
                        </div>
                        <div class="ibox-content">
						<div class="alert alert-warning">
						温馨提示：如果你对微信商户平台的 服务商功能=》特约商户管理 功能不够了解，请慎用此功能。<br/>
						<?php if (empty ( $this->_tpl_vars['sub_mchidarr'] )): ?>
						  <div>必须配置特约子商户号才能使用此功能，请到到 支付配置中配置.</div>
						<?php endif; ?>
						<div>使用此功能请配置好支付配置相关项。</div>
						 </div>

						 	<div class="form-group input-group"  id="myFormAct">
							 <form method="get" action="">
								<span><label class="font-noraml">商户名称筛选：</label>
									<select class="form-control m-b" style="width:200px;display:inline-block;float:none;height:auto;" onchange="qyChaXun(this.value)" id="mid">
									<?php if (! empty ( $this->_tpl_vars['merInfos'] )): ?>
									<option value="0">请选择</option>
									<?php unset($this->_sections['mvv']);
$this->_sections['mvv']['name'] = 'mvv';
$this->_sections['mvv']['loop'] = is_array($_loop=$this->_tpl_vars['merInfos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mvv']['show'] = true;
$this->_sections['mvv']['max'] = $this->_sections['mvv']['loop'];
$this->_sections['mvv']['step'] = 1;
$this->_sections['mvv']['start'] = $this->_sections['mvv']['step'] > 0 ? 0 : $this->_sections['mvv']['loop']-1;
if ($this->_sections['mvv']['show']) {
    $this->_sections['mvv']['total'] = $this->_sections['mvv']['loop'];
    if ($this->_sections['mvv']['total'] == 0)
        $this->_sections['mvv']['show'] = false;
} else
    $this->_sections['mvv']['total'] = 0;
if ($this->_sections['mvv']['show']):

            for ($this->_sections['mvv']['index'] = $this->_sections['mvv']['start'], $this->_sections['mvv']['iteration'] = 1;
                 $this->_sections['mvv']['iteration'] <= $this->_sections['mvv']['total'];
                 $this->_sections['mvv']['index'] += $this->_sections['mvv']['step'], $this->_sections['mvv']['iteration']++):
$this->_sections['mvv']['rownum'] = $this->_sections['mvv']['iteration'];
$this->_sections['mvv']['index_prev'] = $this->_sections['mvv']['index'] - $this->_sections['mvv']['step'];
$this->_sections['mvv']['index_next'] = $this->_sections['mvv']['index'] + $this->_sections['mvv']['step'];
$this->_sections['mvv']['first']      = ($this->_sections['mvv']['iteration'] == 1);
$this->_sections['mvv']['last']       = ($this->_sections['mvv']['iteration'] == $this->_sections['mvv']['total']);
?>
									<option value="<?php echo $this->_tpl_vars['merInfos'][$this->_sections['mvv']['index']]['mid']; ?>
" <?php if (( $this->_tpl_vars['mid'] == $this->_tpl_vars['merInfos'][$this->_sections['mvv']['index']]['mid'] )): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['merInfos'][$this->_sections['mvv']['index']]['wxname']; ?>
</option>
									<?php endfor; endif; ?>
									<?php endif; ?>
									</select></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span><label class="font-noraml">商户账号筛选：</label>
								<select class="form-control m-b" style="width:200px;display:inline-block;float:none;height:auto;" onchange="qyChaXun(this.value)" id="midd">
									<?php if (! empty ( $this->_tpl_vars['merInfos'] )): ?>
									<option value="0">请选择</option>
									<?php unset($this->_sections['mvv']);
$this->_sections['mvv']['name'] = 'mvv';
$this->_sections['mvv']['loop'] = is_array($_loop=$this->_tpl_vars['merInfos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mvv']['show'] = true;
$this->_sections['mvv']['max'] = $this->_sections['mvv']['loop'];
$this->_sections['mvv']['step'] = 1;
$this->_sections['mvv']['start'] = $this->_sections['mvv']['step'] > 0 ? 0 : $this->_sections['mvv']['loop']-1;
if ($this->_sections['mvv']['show']) {
    $this->_sections['mvv']['total'] = $this->_sections['mvv']['loop'];
    if ($this->_sections['mvv']['total'] == 0)
        $this->_sections['mvv']['show'] = false;
} else
    $this->_sections['mvv']['total'] = 0;
if ($this->_sections['mvv']['show']):

            for ($this->_sections['mvv']['index'] = $this->_sections['mvv']['start'], $this->_sections['mvv']['iteration'] = 1;
                 $this->_sections['mvv']['iteration'] <= $this->_sections['mvv']['total'];
                 $this->_sections['mvv']['index'] += $this->_sections['mvv']['step'], $this->_sections['mvv']['iteration']++):
$this->_sections['mvv']['rownum'] = $this->_sections['mvv']['iteration'];
$this->_sections['mvv']['index_prev'] = $this->_sections['mvv']['index'] - $this->_sections['mvv']['step'];
$this->_sections['mvv']['index_next'] = $this->_sections['mvv']['index'] + $this->_sections['mvv']['step'];
$this->_sections['mvv']['first']      = ($this->_sections['mvv']['iteration'] == 1);
$this->_sections['mvv']['last']       = ($this->_sections['mvv']['iteration'] == $this->_sections['mvv']['total']);
?>
									<option value="<?php echo $this->_tpl_vars['merInfos'][$this->_sections['mvv']['index']]['mid']; ?>
" <?php if (( $this->_tpl_vars['mid'] == $this->_tpl_vars['merInfos'][$this->_sections['mvv']['index']]['mid'] )): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['merInfos'][$this->_sections['mvv']['index']]['username']; ?>
</option>
									<?php endfor; endif; ?>
									<?php endif; ?>
									</select></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<span><label class="font-noraml">商户账号：</label>
									<input type="text" value="<?php echo $this->_tpl_vars['uname']; ?>
" name="uname" class="input form-control"   placeholder="输入商户账号筛选" id="usertoname">
									</span>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<a class="btn btn-primary" style="width:70px;" onclick="qyChaXun()">查 询</a>
						
									</form>
							</div>

                            <table class="footable table table-stripped" data-page-size="30" id="listfootable">
                                <thead>
                                <tr>
									<th style="width: 120px;">选为特约商家</th>
									<th>Mid号</th>
									<th>特约子商户号</th>
									<th>商户名称</th>
									<th data-hide="phone">商户账号</th> 
									<th data-hide="phone">Appid</th>
									<th data-hide="phone">Mchid</th>
									<th data-hide="phone">银行卡</th>
								   </tr>
                                </thead>
								  <tbody>
									<?php if (! empty ( $this->_tpl_vars['merInfo'] )): ?>
									 <?php unset($this->_sections['vv']);
$this->_sections['vv']['name'] = 'vv';
$this->_sections['vv']['loop'] = is_array($_loop=$this->_tpl_vars['merInfo']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['vv']['show'] = true;
$this->_sections['vv']['max'] = $this->_sections['vv']['loop'];
$this->_sections['vv']['step'] = 1;
$this->_sections['vv']['start'] = $this->_sections['vv']['step'] > 0 ? 0 : $this->_sections['vv']['loop']-1;
if ($this->_sections['vv']['show']) {
    $this->_sections['vv']['total'] = $this->_sections['vv']['loop'];
    if ($this->_sections['vv']['total'] == 0)
        $this->_sections['vv']['show'] = false;
} else
    $this->_sections['vv']['total'] = 0;
if ($this->_sections['vv']['show']):

            for ($this->_sections['vv']['index'] = $this->_sections['vv']['start'], $this->_sections['vv']['iteration'] = 1;
                 $this->_sections['vv']['iteration'] <= $this->_sections['vv']['total'];
                 $this->_sections['vv']['index'] += $this->_sections['vv']['step'], $this->_sections['vv']['iteration']++):
$this->_sections['vv']['rownum'] = $this->_sections['vv']['iteration'];
$this->_sections['vv']['index_prev'] = $this->_sections['vv']['index'] - $this->_sections['vv']['step'];
$this->_sections['vv']['index_next'] = $this->_sections['vv']['index'] + $this->_sections['vv']['step'];
$this->_sections['vv']['first']      = ($this->_sections['vv']['iteration'] == 1);
$this->_sections['vv']['last']       = ($this->_sections['vv']['iteration'] == $this->_sections['vv']['total']);
?>
									  <tr>
									    <td style="padding-top:12px;" class="ptd"><input type="checkbox" <?php if ($this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['proxymid'] == $this->_tpl_vars['_mid']): ?> checked="checked" <?php endif; ?> data-type='weixin' class="i-checks"></td>
									   <td class="midnum"><?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['mid']; ?>
</td>
									   <td class="wxsubmchid"><?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['wxsubmchid']; ?>
</td>
									      <td class="prelative"><span class="wxname"><?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['wxname']; ?>
</span><input type="text" class="form-control" placeholder="请输入商户名称">&nbsp;&nbsp;&nbsp;<span class="tips"><i class="fa fa-edit"></i><span>保存修改</span></span>
										</td>
									   
									   <td><?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['username']; ?>
</td>
									   <td><?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['wx_appid']; ?>
</td>
									   <td><?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['wx_mchid']; ?>

									   </td>
									   <td><a class="btn btn-primary"  onclick="lookBanck(<?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['mid']; ?>
)">查看信息</a></td>
									  </tr>
									 <?php endfor; endif; ?>
									<?php else: ?>
										   <tr class="widget-list-item"><td colspan="8">暂无商家信息</td></tr>
									<?php endif; ?>
								   </tbody> 
                            </table>

							<div id="editable_paginate" class="dataTables_paginate paging_simple_numbers">
                                <ul class="pagination pull-right"></ul>
							</div>

                        </div>
                    </div>
					<?php echo $this->_tpl_vars['pagebar']; ?>

                </div>
            </div>
        </div>

			
            </div>
        </div>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		<div class="modal inmodal" tabindex="-1"  id="submhid_Setting">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
                    <button type="button" class="close _close"><span>×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">选择子商户</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="wxActionBox" class="wxpay_box">
							<div class="form-group">
								<label>选择子商户：</label>
								<select class="form-control" id="submhid" style="width:80%">
								 	<?php if (! empty ( $this->_tpl_vars['sub_mchidarr'] )): ?>
									 <?php unset($this->_sections['vv']);
$this->_sections['vv']['name'] = 'vv';
$this->_sections['vv']['loop'] = is_array($_loop=$this->_tpl_vars['sub_mchidarr']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['vv']['show'] = true;
$this->_sections['vv']['max'] = $this->_sections['vv']['loop'];
$this->_sections['vv']['step'] = 1;
$this->_sections['vv']['start'] = $this->_sections['vv']['step'] > 0 ? 0 : $this->_sections['vv']['loop']-1;
if ($this->_sections['vv']['show']) {
    $this->_sections['vv']['total'] = $this->_sections['vv']['loop'];
    if ($this->_sections['vv']['total'] == 0)
        $this->_sections['vv']['show'] = false;
} else
    $this->_sections['vv']['total'] = 0;
if ($this->_sections['vv']['show']):

            for ($this->_sections['vv']['index'] = $this->_sections['vv']['start'], $this->_sections['vv']['iteration'] = 1;
                 $this->_sections['vv']['iteration'] <= $this->_sections['vv']['total'];
                 $this->_sections['vv']['index'] += $this->_sections['vv']['step'], $this->_sections['vv']['iteration']++):
$this->_sections['vv']['rownum'] = $this->_sections['vv']['iteration'];
$this->_sections['vv']['index_prev'] = $this->_sections['vv']['index'] - $this->_sections['vv']['step'];
$this->_sections['vv']['index_next'] = $this->_sections['vv']['index'] + $this->_sections['vv']['step'];
$this->_sections['vv']['first']      = ($this->_sections['vv']['iteration'] == 1);
$this->_sections['vv']['last']       = ($this->_sections['vv']['iteration'] == $this->_sections['vv']['total']);
?>
									 <option value="<?php echo $this->_tpl_vars['sub_mchidarr'][$this->_sections['vv']['index']]; ?>
"><?php echo $this->_tpl_vars['sub_mchidarr'][$this->_sections['vv']['index']]; ?>
</option>
									 <?php endfor; endif; ?>
									 <?php endif; ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="button" class="btn btn-primary btn-confirm" onclick="ProxyedMe();">确定</button>
                    <button type="button" class="btn btn-white _close">关闭</button>
                </div>
			</div>
		</div>
	</div>

	<div class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true" id="hkbankset">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<form action="" method="post" enctype="multipart/form-data">
				<div class="modal-header">
                    <button type="button" class="close _close"><span>×</span><span class="sr-only">Close</span></button>
                    
                    <h4 class="modal-title">汇款银行卡 信息配置</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="new_bank_box" class="wxpay_box">
							<div class="form-group">
								<label>银行名称：</label>
								<p id="banckname"></p>
							</div>
							<div class="form-group">
								<label>银行卡号：</label>
								<p id="bankcardnumm"></p>
							</div>
							<div class="form-group">
								<label>开卡人姓名：</label>
								 <p id="banktruename"></p>
							</div>
							<div class="form-group">
								<label>开卡人手机号：</label>
								<p id="phone"></p>
							</div>

							<div class="form-group">
								<label>开卡人身份证号：</label>
								<p id="identitycode"></p>
							</div>

						</div>
					</div>
				</div>
				<div class="modal-footer">   
                    <button type="button" class="btn btn-primary _close">关闭</button>
                </div>
				</form>
			</div>
		</div>
	</div>

</body>
<script  type="text/javascript">
var sdata={};
var nosub_mchid=false;
var obj=null
<?php if (empty ( $this->_tpl_vars['sub_mchidarr'] )): ?>
var nosub_mchid=true;
<?php endif; ?>

 $(document).ready(function(){
	$('#listfootable').footable();
	 $('.i-checks').iCheck({
           checkboxClass: 'icheckbox_square-green',
           radioClass: 'iradio_square-green',
        });

		$('.i-checks').on('ifChanged', function(){
			var isselect=0;
			if($(this).is(':checked')){
				 isselect = 1;
			}else{
				 isselect = 0;
			}
			var s_mid=0;
			s_mid=$(this).parents('.ptd').siblings('.midnum').text();
			obj=$(this).parents('.ptd').siblings('.wxsubmchid');
			s_mid=$.trim(s_mid);
			sdata={ischeck:isselect,mid:s_mid,submhid:''};
			if(isselect==0){
			    $.post('?m=System&c=pay&a=isproxyed',sdata,function(ret){
					obj.text('');
					sdata={};
					$('#submhid_Setting').hide();
					$('.modal-backdrop').remove();
				 },'JSON');
			}else{
                if(nosub_mchid){
				   $(this).prop("checked", false);
				   swal({title: "温馨提示",text:'您没有配置特约子商户号',type: "error"});
				}else{
				 $('body').append('<div class="modal-backdrop in"></div>');
				 $('#submhid_Setting').show();
				}
			}
			return false;
		});
	});

	 $('#listfootable .prelative .tips').click(function(){
	if($(this).hasClass('fedit')){
	   var mid= $(this).parent().siblings('.midnum').text();
	   mid=parseInt($.trim(mid));
	   var vv=$(this).siblings('.form-control').val();
	   vv=$.trim(vv);
	   if(!vv){
	      swal({title: "温馨提示",text:'没填写内容！',type: "error"});
		  return false;
	   }else{
		  var _this= $(this);
	     $.post('?m=System&c=index&a=mdfyName',{mid:mid,wxname:vv},function(ret){
		    if(!ret.error){
			 _this.siblings('.wxname').text(vv);
			 }else{
			    swal({title: "温馨提示",text:'修改失败！',type: "error"});
			 }
	   _this.siblings('.wxname').show();
	   _this.siblings('.form-control').hide();
	   _this.find('span').hide();
	   _this.removeClass('fedit');
		 },'JSON');
	   }
	}else{
	   $(this).siblings('.wxname').hide();
	   var wxname=$(this).siblings('.wxname').text();
	   $(this).siblings('.form-control').val(wxname).show();
	   $(this).find('span').show();
	   $(this).addClass('fedit');
	}
 });
   
 function ProxyedMe(){
	 var submhid=$.trim($('#submhid').val());
	 sdata.submhid=submhid;
	 $.post('?m=System&c=pay&a=isproxyed',sdata,function(ret){
		sdata={};
		swal({title: "温馨提示",text:'设置成功',type: "success"});
		obj.text(submhid);
		obj=null;
		$('#submhid_Setting').hide();
		$('.modal-backdrop').remove();
	 },'JSON');
    
 }
 	$("#submhid_Setting ._close").click(function(){
		sdata={};
	  $('#submhid_Setting').hide();
	  $('.modal-backdrop').remove();
	});

function qyChaXun(middd){
   if(typeof(middd)!='undefined'){
	 $('#usertoname').val('');
	 var qyStr=$('form').serialize();
     mid=parseInt(middd);
   }else{
	   var qyStr=$('form').serialize();
	   var mid=$('#mid').val();
	   mid=parseInt(mid);
	   var midd=$('#midd').val();
	   midd=parseInt(midd);
	   if(midd>0){
		 mid=midd;
	   }
   }
   mid=mid >0 ? mid :0;

   var furl='http://'+window.location.host+'/merchants.php?m=System&c=index&a=affiliate&mid='+mid+'&';
   window.location.href=furl+qyStr;
}

function lookBanck(mid){
  $.post('/merchants.php?m=System&c=index&a=getCashierBank',{midd:mid},function(rets){
	  rets.error=parseInt(rets.error);
     if(!rets.error){
	    $('#new_bank_box #banckname').text(rets.data.bankname);
		$('#new_bank_box #bankcardnumm').text(rets.data.bankcardnum);
		$('#new_bank_box #banktruename').text(rets.data.banktruename);
		$('#new_bank_box #phone').text(rets.data.phone);
		$('#new_bank_box #identitycode').text(rets.data.identitycode);
		$('#hkbankset').show();
		$('body').append('<div class="modal-backdrop in"></div>');
	 }else{
	    swal("温馨提示",'此商家没有配置线下汇款银行卡信息' , "error");
	 }
  },'JSON');
}
	 $('#hkbankset ._close').click(function(){
		$('#hkbankset').hide();
		$('.modal-backdrop').remove();;
		$('#new_bank_box p').html('');
	 });
</script>
</html>