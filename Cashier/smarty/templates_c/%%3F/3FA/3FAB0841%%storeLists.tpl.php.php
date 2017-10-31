<?php /* Smarty version 2.6.18, created on 2016-07-27 14:12:27
         compiled from D:%5Cxinban%5Cpay.haocangpin.net%5CCashier%5C./pigcms_tpl/Merchants/System/index/storeLists.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 | 店铺列表</title>
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
	#table-list-body .fa-edit{ color: #3DA142;font-size: 20px;}
	#table-list-body .tips{ color: #3DA142;cursor: pointer;}
	#table-list-body .tips span{ display: none;} 
	#table-list-body .prelative .form-control {
    display: none;
    vertical-align: middle;
    width: auto;
	height: 30px;
	padding: 3px 10px;
 }
 #table-list-body .btn-primary{padding:3px;margin-bottom:0px;margin-left:7px;}
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
                            <a href="#">System</a>
                        </li>
                        <li>
                            <a>index</a>
                        </li>
                        <li class="active">
                            <strong>所有店铺列表</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	<div class="col-lg-12">
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
            	    <div class="ibox float-e-margins">
            	        <div class="ibox-title clearfix">
						 <h1 class="realtime-title">店铺信息列表&nbsp;&nbsp;(共：<?php echo $this->_tpl_vars['totalnum']; ?>
 条)</h1>
            	     </div>
<div class="ibox-content"> 
   <nav class="ui-nav clearfix"> 
   </nav> 
   <div class="app__content js-app-main page-cashier">
    <div>
      <div class="cashier-realtime"> 
       <div class="realtime-title-block clearfix"> 
        
       </div> 
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
            <th data-hide="phone">店铺名称</th>
            <th data-hide="phone">店铺地址</th> 
            <th data-hide="phone">店铺电话</th>
			<th data-hide="phone">状态</th>
			<th data-hide="phone">wap显示状态</th>
           </tr>
          </thead>

          <tbody id="table-list-body" class="js-list-body-region">
			<?php if (! empty ( $this->_tpl_vars['storesInfo'] )): ?>
			 <?php unset($this->_sections['vv']);
$this->_sections['vv']['name'] = 'vv';
$this->_sections['vv']['loop'] = is_array($_loop=$this->_tpl_vars['storesInfo']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			   <td class="mid"><?php echo $this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['mid']; ?>
</td>
			   <td class="prelative"><span class="wxname"><?php echo $this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['wxname']; ?>
</span>
			 </td>
			   <td><?php echo $this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['username']; ?>
<?php if ($this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['isadmin'] == 1): ?><br/>(此后台关联收银平台账号)<?php endif; ?></td>
			   <td><?php echo $this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['business_name']; ?>
<?php echo $this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['branch_name']; ?>

			   </td>
			   <td><?php echo $this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['provincename']; ?>
<?php echo $this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['cityname']; ?>
<?php echo $this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['districtname']; ?>
<?php echo $this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['address']; ?>
</td>
			   <td><?php echo $this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['telephone']; ?>

			   </td>
			   <td><?php if ($this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['available_state'] == 3): ?><font color="green">已通过</font>
			   <?php elseif ($this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['available_state'] > 3 || $this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['available_state'] == 1): ?><font color="red">审核失败</font>
			   <?php elseif ($this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['available_state'] == 0 || $this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['available_state'] == 2): ?><font color="red">审核中</font>
			   <?php endif; ?>
			   </td>
			   <td><span><?php if ($this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['isshow'] == 0): ?><font color="red">不显示</font><?php elseif ($this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['isshow'] > 0): ?><font color="green">显&nbsp;&nbsp;示</font><?php endif; ?></span><button class="btn btn-primary" data-sid=<?php echo $this->_tpl_vars['storesInfo'][$this->_sections['vv']['index']]['id']; ?>
>更新状态</button> </td>
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
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
<script type="text/javascript">
 $('#table-list-body .btn-primary').click(function(){
	 var stoid=$(this).data("sid");
	  var __this= $(this);
	 if(stoid){
	   $.post('?m=System&c=index&a=mdfysShow',{sid:stoid},function(ret){
		  if(!ret.error){
			   if(ret.data==1){
			      __this.siblings('span').html('<font color="green">显&nbsp;&nbsp;示</font>');
			   }else{
			      __this.siblings('span').html('<font color="red">不显示</font>');
			   }
			 }else{
			    swal({title: "温馨提示",text:'修改失败！',type: "error"});
			 }

		 },'JSON');
	 }
 });
  function SelectByMid(vv,typ){
	var furl=window.location.href;
	if(furl.indexOf('mid=')>0){
	   furl=furl.replace(/mid=\d+/,'mid='+vv);
	   furl=furl.replace(/typ=\d+/,'typ='+typ);
	   window.location.href=furl;
	}else{
       window.location.href=furl+'&mid='+vv+'&typ='+typ;
	}
 }

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

   var furl='http://'+window.location.host+'/merchants.php?m=System&c=index&a=storeLists&mid='+mid+'&';
   window.location.href=furl+qyStr;
}
</script>
</html>