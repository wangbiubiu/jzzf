<?php /* Smarty version 2.6.18, created on 2016-07-27 14:03:59
         compiled from D:%5Cxinban%5Cpay.haocangpin.net%5CCashier%5C./pigcms_tpl/Merchants/System/index/merLists.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 | 商家列表</title>
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
	<style type="text/css">
   #table-list-body .fa-edit{ color: #13611A;font-size: 20px;}
	#table-list-body .tips{ color: #3DA142;cursor: pointer;}
	#table-list-body .tips span{ display: none;} 
	#table-list-body .prelative .form-control {
    display: none;
    vertical-align: middle;
    width: auto;
	height: 30px;
	padding: 3px 10px;
 }
    #usertoname {border-radius: 7px;height: 35px;display: inline-block;width:220px;margin-bottom:1px; float: none;}
	.icon_edit .fa-pencil{ font-size: 25px; margin-left: 7px;}
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
                            <a href="#">System</a>
                        </li>
                        <li>
                            <a>index</a>
                        </li>
                        <li class="active">
                            <strong>商家列表</strong>
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
            	        <div class="ibox-title clearfix">
						 <h1 class="realtime-title">商家信息列表&nbsp;&nbsp;(共：<?php echo $this->_tpl_vars['totalnum']; ?>
 条)</h1>
            	     </div>
			<div class="alert alert-warning">
			 这里可以更改商户账户的状态，审核不通过我们将禁止客户登陆。提供重置商户账户密码等功能。<br/>
			 注册商户需审核功能 请先到 系统配置 =》 系统配置 来设置开启注册审核和关闭注册审核
			 <br/>
			 注意：<font color="red">这些操作不影响从微信营销系统登录</font>

			</div>

<div class="ibox-content"> 
   <div class="app__content js-app-main page-cashier">
    <div>
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
      <div class="js-real-time-region realtime-list-box loading">
       <div class="widget-list">
        <div style="position: relative;" class="js-list-filter-region clearfix ui-box">
         <div class="widget-list-filter"></div>
        </div> 
        <div class="ui-box"> 
         <table style="padding: 0px;" data-page-size="20" class="ui-table ui-table-list default no-paging footable-loaded footable"> 
          <thead class="js-list-header-region tableFloatingHeaderOriginal">
           <tr class="widget-list-header">
		    <th>Mid号</th>
			<th>商户名称</th>
            <th data-hide="phone">商户账号</th>
			<th data-hide="phone" width="180px">账号状态</th> 
            <th data-hide="phone">微信配置</th>
            <th data-hide="phone" width="180px">第三方对接ID</th> 
            <th data-hide="phone">来源</th>
			<th data-hide="phone">银行卡</th>
			<th data-hide="phone"></th>
           </tr>
          </thead>

          <tbody id="table-list-body" class="js-list-body-region">
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
			  <tr class="widget-list-item">
			   <td class="mid"><?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['mid']; ?>
</td>
			   <td class="prelative"><span class="wxname"><?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['wxname']; ?>
</span><input type="text" class="form-control" placeholder="请输入商户名称">&nbsp;&nbsp;&nbsp;<span class="tips"><i class="fa fa-edit"></i><span>保存修改</span></span>
			 </td>
			   <td><?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['username']; ?>
<?php if ($this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['isadmin'] == 1): ?><br/>(此后台关联收银平台账号)<?php endif; ?></td>
			   <td>
			   <span>
			   <?php if ($this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['status'] == 0): ?>
			       <font color="red">未审核</font>
				   <?php elseif ($this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['status'] == 2): ?>
				     <font color="red">禁止登录</font>
				   <?php elseif ($this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['status'] == 1): ?>
				     <font color="green">正常</font>
				   <?php endif; ?>
				   </span>

				   <?php if ($this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['source'] == 0): ?>
				   <a data-actionid="<?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['mid']; ?>
" href="javascript:;" class="icon_edit js_modify_status" title="状态修改"><i class="fa fa-pencil"></i></a>
				   <?php endif; ?>

			   </td>
			   <td><?php if ($this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['configData'] && $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['configData']['weixin'] && $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['configData']['weixin']['mchid'] && $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['configData']['weixin']['appid']): ?>
					已配置
				   <?php else: ?>
				   未配置
				   <?php endif; ?>
			   </td>
			   <td><?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['thirduserid']; ?>
<?php if ($this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['isadmin'] == 1): ?>此账号登陆收银系统，其支付配置和此后台支付配置公用<?php endif; ?></td>
			   <td><?php if ($this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['source'] == 1): ?>
			       微信营销系统
				   <?php elseif ($this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['source'] == 2): ?>
				   微店系统
				   <?php elseif ($this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['source'] == 3): ?>
				   o2o系统
				   <?php else: ?>
				   本站注册<?php if ($this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['isadmin'] == 1): ?><br/>(此后台关联收银平台账号)<?php endif; ?>
				   <?php endif; ?>
			   </td>

			   <td><a class="btn btn-primary"  onclick="lookBanck(<?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['mid']; ?>
)">查看信息</a></td>
			   <td><a class="btn btn-primary"  onclick="resetPwd(<?php echo $this->_tpl_vars['merInfo'][$this->_sections['vv']['index']]['mid']; ?>
)">重置密码</a></td>
			  </tr>
			 <?php endfor; endif; ?>
			<?php else: ?>
		   		   <tr class="widget-list-item"><td colspan="8">暂无商家信息</td></tr>
			<?php endif; ?>
		   </tbody> 
         </table> 
         <div class="js-list-empty-region"></div> 
        </div> 
        <div class="js-list-footer-region ui-box">
         <div class="widget-list-footer"></div>
        </div> 
       </div>
      </div> 
     </div>
    </div>
   </div> 
  </div>
  <?php echo $this->_tpl_vars['pagebar']; ?>

  </div>
	</div>
    </div>

            </div>
        </div>


		<div class="modal inmodal" tabindex="-1"  id="resetPwdMer">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
                    <button type="button" class="close _close"><span>×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">修改商家密码</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="wxActionBox" class="wxpay_box">
							<div class="form-group">
								<label>填上一个新密码：</label>
								<input type="text" value="m123456" name="resetPwd" id="resetPwd" class="input form-control"   placeholder="输入新密码">
								<input type="hidden" value="" name="merid" id="merid">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="button" class="btn btn-primary btn-confirm" onclick="mdyMerpwd();">确定</button>
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

<div class="popover" id="changeStatus">
    <div class="popover_inner">
		<div class="popover_content">
		<p style="font-weight: bold;color: #22911B;text-align: center;">账号审核</p>
		<div class="pop_store">
		
			<div class="frm_control_group">
				<div class="frm_controls">
					<label class="frm_radio_label selected">
						<input type="radio"  value="1" checked="checked" name="status">
						<span class="lbl_content">通过</span>
					</label>
					<label class="frm_radio_label">
						<input type="radio"  value="2" name="status">
						<span class="lbl_content">不通过</span>
					</label>

				</div>
			</div>
		
		</div>
		</div>

		<div class="popover_bar">
			<button type="button" class="btn btn-primary btn_confirm">确 定</button>&nbsp;&nbsp;&nbsp;
			<button type="button" class="btn btn-white c-close">取 消</button>
		</div>

    </div>
    <i class="popover_arrow popover_arrow_out"></i>
    <i class="popover_arrow popover_arrow_in"></i>
</div>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
<script type="text/javascript">
 $('#table-list-body .prelative .tips').click(function(){
	if($(this).hasClass('fedit')){
	   var mid= $(this).parent().siblings('.mid').text();
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

   var furl='http://'+window.location.host+'/merchants.php?m=System&c=index&a=merLists&mid='+mid+'&';
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

    function mdyMerpwd(){
		var rpwd=$.trim($('#resetPwd').val());
		if(!rpwd){
			swal("温馨提示",'请设置一个新密码！' , "error");
			return false;
		}
		var merid=$.trim($('#merid').val());
		if(!merid){
			swal("温馨提示",'没有选择商家出错！' , "error");
			return false;
		}
	    $.post('/merchants.php?m=System&c=index&a=mdyMerpwd',{rpwdStr:rpwd,mid:merid},function(rets){
		rets.error=parseInt(rets.error);
		 if(!rets.error){
				$('#resetPwdMer').hide();
				$('.modal-backdrop').remove();
				$('#merid').val('0');
				swal("温馨提示",'修改成功！' , "success");
		 }else{
			swal("温馨提示",rets.msg , "error");
		 }
	  },'JSON');
	}

	function resetPwd(mid){
        $('#merid').val(mid);
		$('#resetPwdMer').show();
		$('body').append('<div class="modal-backdrop in"></div>');
	}

	 $('#resetPwdMer ._close').click(function(){
		$('#resetPwdMer').hide();
		$('.modal-backdrop').remove();
		$('#merid').val('0');
	 });

	 $('#hkbankset ._close').click(function(){
		$('#hkbankset').hide();
		$('.modal-backdrop').remove();
		$('#new_bank_box p').html('');
	 });

   var actid=0,numObj='';
	$(document).on('click',function(e){
		   var target = $(e.target);
		   var statusobj=target.closest(".js_modify_status");
		   if(statusobj.size()!=0){
			   actid=statusobj.data('actionid');
			   numObj=statusobj.siblings('span');
			   var offsetpx=statusobj.offset();
			   $('#changeStatus').css('position','absolute').css('left',offsetpx.left-141).css('top',offsetpx.top+5).css('zIndex','100').show();
		     }else if(target.closest("#changeStatus").size()==0){
			    actid=0;numObj='';
		        $("#changeStatus").hide();
		   }
		});

		$("#changeStatus .c-close").click(function(){
			  actid=0;numObj='';
		     $("#changeStatus").hide();
		});

		$("#changeStatus .btn_confirm").click(function(){
			var datas = {mid:actid};
			var stype = $('#changeStatus .frm_control_group input:checked').val();
			datas.stype=stype; 
		    if(actid>0){
		     $("#changeStatus").hide();
				actid=0;
				$.ajax({
				url: "?m=System&c=index&a=changeStatus",
				type: "POST",
				dataType: "json",
				data:datas,
				success: function(res){
					if(!res.error){
						if(numObj){
						     numObj.html(res.data);
						}
						numObj='';
						swal({
							title: "修改成功",
								text: "修改成功",
								type: "success"
							});
					}else{
						swal({
								title: "修改失败",
								text: res.msg,
								type: "error"
							}, function () {
								//window.location.reload();
							});
					}
				}
				});
			}
		});
</script>
</html>