<?php /* Smarty version 2.6.18, created on 2016-12-23 20:55:11
         compiled from /phpstudy/www/pay.yunjifu.net/Cashier/./pigcms_tpl/Merchants/System/index/addNotice.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>总后台 | 添加公告</title>
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
        <script src="/Cashier/vendor/ueditor/ueditor.config.js"></script>
        <script src="/Cashier/vendor/ueditor/ueditor.all.js"></script>
<style>


td>textarea,td>input{margin: 10px 0;}
#edui1{
width:100% !important;
}

#edui1_iframeholder{
width:100% !important;
height:350px;
}

table{
	width:100% !important;
}

.edui-defualt{
	width:100% !important;
}
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
                            <strong>首页</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight" >
                <form action="/merchants.php?m=System&c=index&a=addNotice" method="post" id="form1">
                <table border="0" cellpadding="1" cellspacing="1">
                    <tr>
                        <td style="width: 45px;">标题:</td>
                        <td><input type="text" id="title" name="title" style="width:600px; height:30px;float: left; "></td>
                    </tr>
                    <tr>
                        <td style="width: 45px;">来源:</td>
                        <td><input type="text" id="source" name="source" style="width:250px; height: 30px;" type="text"></td>
                    </tr>
                    <tr>
                        <td style="width: 45px;">内容:</td>
                        <td>
                           <textarea name="content" id="content" cols="50" rows="10">
                                        
                            </textarea>
                        </td>
                    </tr>

           	</table>
                    <p style=" width: 62px; margin-left: 300px; margin-top: 20px"><input class="btn" type="button" value="提交"  style="width: 60px; height: 30px;display: inline-block; border: none; background:#2C82C9; color: #FFFFFF; border-radius: 2px;"/></p>
                    </form>
                   
                
            </div>
            </div>
        </div>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>

</html>
<script type="text/javascript">
 
</script>
<script>
     $(function(){
        ue = UE.getEditor('content',{
            initialFrameWidth :600,
            initialFrameHeight: 150
     });
  
 
  });
    $('.btn').click(function(){
       // var data = $('#form1').serializeArray();
        var title = $('#title').val();
        var source = $('#source').val();
        var content = ue.getContent();
        if(title==""){
            swal("标题不能为空",'', "error");
            return false;
        }
        if(source==''){
            swal("来源不能为空",'', "error");
            return false;
        }
        if(content==''){
            swal("内容不能为空",'', "error");
            return false;
        }
        $.post('?m=System&c=index&a=addNotice',{title:title,source:source,content:content},function(reg){
            if(reg.errcode==1){
               
                 swal({
                    title: "成功",
                    text: reg.msg,
                    type: "success"
            }, function () {
                    window.location.reload();
                    });
            }else{
                swal("添加失败", reg.msg , "error");
            }
        },'json');
        
    })

</script>