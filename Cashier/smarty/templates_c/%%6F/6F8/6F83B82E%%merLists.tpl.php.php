<?php /* Smarty version 2.6.18, created on 2017-06-19 15:46:45
         compiled from E:%5CWWW%5C20170619%5CCashier%5C./pigcms_tpl/Merchants/System/merchant/merLists.tpl.php */ ?>
<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>商户中心 | 商家列表</title>
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
        <link href="<?php echo @RL_PIGCMS_STATIC_PATH; ?>
css/cashier.css" rel="stylesheet">
        <link href="<?php echo @RlStaticResource; ?>
plugins/css/datapicker/datepicker3.css" rel="stylesheet">
        <script src="<?php echo @RlStaticResource; ?>
plugins/js/datapicker/bootstrap-datepicker.js"></script>
        <script	src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
        <!-- Data picker -->
        <script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
        <script src="<?php echo @RlStaticResource; ?>
plugins/js/footable/footable.all2.min.js"></script>
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
            .form-control {
                display:inline-block;

            }
            .sh{ width:100px; height: 30px;padding: 0px !important;  color:#ffffff !important;line-height: 30px;}
            .sh:hover{ background:#4EBE53 !important }
            .md_xinxi>label{margin-right: 30px;}
            .md_xinxi>label>select,.md_xinxi>label>input{ width: 120px; height: 30px; line-height: 30px;}
            .md_xinxi>button{ padding: 0 10px; background: #4EBE53; border: none; height: 30px; line-height: 30px; text-align: center; color: #FFFFFF; border-radius: 5px;}
            th{ text-align: center;}
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
                                <a>商户中心</a>
                            </li>
                            <li class="active">
                                <strong>商户列表</strong>
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
                                    <ul class="nav">
                                        <li>
                                            商户列表
                                        </li>
                                    </ul>
                                </div>
                                <div class="ibox-content">
                                    <nav class="ui-nav clearfix"></nav>
                                    <div class="app__content js-app-main page-cashier">
                                        <div>
                                            <!-- 实时交易信息展示区域 -->
                                            <div class="cashier-realtime">
                                                <form action="" method="get" >
                                                    <div id="dataselect" class="form-group" style="padding: 0 10px;">
                                                        <input type="hidden" name='m' value='System'>
                                                        <input type="hidden" name='c' value='merchant'>
                                                        <input type="hidden" name='a' value='merLists'>
                                                        <div id="datepicker" class="input-daterange">
                                                            <label class="font-noraml">商户名称</label>
                                                            <input class="form-control" type="text" name="company" value="<?php if (( isset ( $this->_tpl_vars['getdata']['company'] ) )): ?><?php echo $this->_tpl_vars['getdata']['company']; ?>
<?php endif; ?>"  placeholder="输入商户名称" style="width: 20%;border-radius:5px;height: 40px; margin-bottom: 0px;">
                                                            <label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
                                                            <input type="text" value="<?php if (( isset ( $this->_tpl_vars['getdata']['start'] ) )): ?><?php echo $this->_tpl_vars['getdata']['start']; ?>
<?php endif; ?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" height: 40px; margin-bottom: 0px; width: 20%;">
                                                            &nbsp;<span> 到 </span>&nbsp; 
                                                            <input type="text" value="<?php if (( isset ( $this->_tpl_vars['getdata']['end'] ) )): ?><?php echo $this->_tpl_vars['getdata']['end']; ?>
<?php endif; ?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" height: 40px; margin-bottom: 0px; width: 20%;"> 
                                                            &nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:100px;" href="?m=System&c=merchant&a=data2Excel" >导出excel</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="js-real-time-region realtime-list-box loading">
                                                <div class="widget-list">
                                                    <div class="js-list-filter-region clearfix ui-box"
                                                         style="position: relative;">
                                                        <div class="widget-list-filter"></div>
                                                    </div>
                                                    <div class="ui-box">
                                                        <table class="ui-table ui-table-list" data-page-size="20" style="padding: 0px; text-align: center;">
                                                            <thead class="js-list-header-region tableFloatingHeaderOriginal">
                                                                <tr class="widget-list-header">
                                                                    <th>商户ID</th>
                                                                    <th>账号</th>
                                                                    <th data-hide="phone">商户名</th>
                                                                    <th data-hide="phone">注册时间</th>
                                                                    <th data-hide="phone">代理商来源</th>
                                                                    <th data-hide="phone">支付配置</th>
                                                                    <th data-hide="phone">操作</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="js-list-body-region" id="table-list-body">

                                                                <?php if (( ! empty ( $this->_tpl_vars['merInfo'] ) )): ?>
                                                                <?php $_from = $this->_tpl_vars['merInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>

                                                                <tr class="widget-list-item">
                                                                    <td><?php echo $this->_tpl_vars['v']['mid']; ?>
</td>
                                                                    <td><?php echo $this->_tpl_vars['v']['username']; ?>
</td>
                                                                    <td><?php echo $this->_tpl_vars['v']['company']; ?>
</td>
                                                                    <td><?php echo $this->_tpl_vars['v']['regTime']; ?>
</td>
                                                                    <td><?php echo $this->_tpl_vars['v']['uname']; ?>
</td>
                                                                    <td>
                                                                        <?php if ($this->_tpl_vars['v']['isopenwxpay'] == 1): ?>
                                                                        <a href="/merchants.php?m=System&c=merchant&a=config&mid=<?php echo $this->_tpl_vars['v']['mid']; ?>
&type=1">
                                                                            <img src="./Cashier/pigcms_static/image/wechat_pay_yes.png">
                                                                        </a>     
                                                                        <?php else: ?>
                                                                        <a href="/merchants.php?m=System&c=merchant&a=config&mid=<?php echo $this->_tpl_vars['v']['mid']; ?>
&type=1">
                                                                            <img src="./Cashier/pigcms_static/image/wechat_pay_no.png">
                                                                        </a>    
                                                                        <?php endif; ?>

                                                                        <?php if ($this->_tpl_vars['v']['isopenalipay'] == 1): ?>
                                                                        <a href="/merchants.php?m=System&c=merchant&a=config&mid=<?php echo $this->_tpl_vars['v']['mid']; ?>
&type=2">
                                                                            <img src="./Cashier/pigcms_static/image/alipay_pay_yes.png">
                                                                        </a>    
                                                                        <?php else: ?>
                                                                        <a href="/merchants.php?m=System&c=merchant&a=config&mid=<?php echo $this->_tpl_vars['v']['mid']; ?>
&type=2">
                                                                            <img src="./Cashier/pigcms_static/image/alipay_pay_no.png">
                                                                        </a>
                                                                        <?php endif; ?>

                                                                    </td>
                                                                    <td>
                                                                        <a class="btn btn-sm btn-info" href="/merchants.php?m=System&c=merchant&a=distribution&mid=<?php echo $this->_tpl_vars['v']['mid']; ?>
" style="vertical-align: top; background: #337ab7;"> 分配 </a>

                                                                        <a class="btn btn-sm btn-info" href="/merchants.php?m=User&c=index&a=index&m_mid=<?php echo $this->_tpl_vars['v']['mid']; ?>
" style="vertical-align: top; background: #36a9e0;" target="_blank">一键登录 </a>

                                                                        <button class="btn btn-sm btn-danger delete" data-id="<?php echo $this->_tpl_vars['v']['mid']; ?>
"><strong>删&nbsp;&nbsp;除 </strong></button>

                                                                    </td>
                                                                </tr>

                                                                <?php endforeach; endif; unset($_from); ?>
                                                                <?php else: ?>
                                                                <tr class="widget-list-item">
                                                                    <td colspan="7">暂无商户</td>
                                                                </tr>
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
                        </div>
                        <?php echo $this->_tpl_vars['pagebar']; ?>

                    </div>
                    <div class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true" id="hkbankset" style=" overflow-y: auto;">
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
                                                <!--							<div class="form-group">
                                                                                                                <label>开卡人手机号：</label>
                                                                                                                <p id="phone"></p>
                                                                                                        </div>-->

                                                <div class="form-group">
                                                    <label>开卡人身份证号：</label>
                                                    <p id="identitycode"></p>
                                                </div>
                                                <div class="form-group">
                                                    <label>开卡人身份证图片：</label>
                                                    <p id=""><img id="identitycodeA" style="width:45%; height: 200px ;" src='' ><img style="width:45%; margin-left: 40px;height: 200px ;" id="identitycodeB" src='' ></p>
                                                </div>
                                                <div class="form-group">
                                                    <label>开卡人银行卡图片：</label>
                                                    <p id=""><img id="bankA" style="width:45%;height: 200px ; " src='' ><img id="bankB" style="width:45%;  margin-left: 40px;height: 200px ;" src='' ></p>
                                                </div>
                                                <div class="form-group">
                                                    <label>开卡人手持银行卡和身份证：</label>
                                                    <p id=""><img id="in_bank" style="width:45%;height: 200px ;" src='' ></p>
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
                </div>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
        </div>

        <div class="modal inmodal" tabindex="-1" role="dialog" id="popgetshop">
            <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <h4 class="modal-title">正在获取微信商户数据....</h4>
                    </div>
                    <div class="modal-body">
                        <div class="spiner-example" style="padding-top: 30px;">
                            <div class="sk-spinner sk-spinner-circle" style="height: 100px; width: 100px;">
                                <div class="sk-circle1 sk-circle"></div>
                                <div class="sk-circle2 sk-circle"></div>
                                <div class="sk-circle3 sk-circle"></div>
                                <div class="sk-circle4 sk-circle"></div>
                                <div class="sk-circle5 sk-circle"></div>
                                <div class="sk-circle6 sk-circle"></div>
                                <div class="sk-circle7 sk-circle"></div>
                                <div class="sk-circle8 sk-circle"></div>
                                <div class="sk-circle9 sk-circle"></div>
                                <div class="sk-circle10 sk-circle"></div>
                                <div class="sk-circle11 sk-circle"></div>
                                <div class="sk-circle12 sk-circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal inmodal" tabindex="-1" role="dialog"  id="Export_excel_pop">
            <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <h6 class="modal-title">请耐心等待导出完成...</h6>
                        <span>数据比较多请耐心等待导出完成，不要点取消！</span>
                    </div>
                    <div class="modal-body">
                        <ul></ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" onclick="$('#Export_excel_pop').hide();$('.modal-backdrop').remove();"> 取 消 </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- iCheck -->
<script src="<?php echo @RlStaticResource; ?>
plugins/js/iCheck/icheck.min.js"></script>
<script type="text/javascript">
    

        function lookBanck(mid) {


        $.post('/merchants.php?m=System&c=index&a=getCashierBank', {midd: mid}, function (rets) {
            rets.error = parseInt(rets.error);
            if (!rets.error) {
                $('#new_bank_box #banckname').text(rets.data.bankname);
                $('#new_bank_box #bankcardnumm').text(rets.data.bankcardnum);
                $('#new_bank_box #banktruename').text(rets.data.banktruename);
                $('#new_bank_box #phone').text(rets.data.phone);
                $('#new_bank_box #identitycode').text(rets.data.identitycode);
                $('#new_bank_box #bankA').attr('src', rets.data.bank_img.bankA);
                $('#new_bank_box #bankB').attr('src', rets.data.bank_img.bankB);
                $('#new_bank_box #identitycodeA').attr('src', rets.data.bank_img.identitycodeA);
                $('#new_bank_box #identitycodeB').attr('src', rets.data.bank_img.identitycodeB);
                $('#new_bank_box #in_bank').attr('src', rets.data.bank_img.in_bank);
                $('#hkbankset').show();
                $('body').append('<div class="modal-backdrop in"></div>');
            } else {
                swal("温馨提示", '此商家没有配置线下汇款银行卡信息', "error");
            }
        }, 'JSON');
    }

    
    $('#hkbankset ._close').click(function () {
        $('#hkbankset').hide();
        $('.modal-backdrop').remove();
        //$('#new_bank_box p').html('');
    });


</script>
<script type="text/javascript">
$(document).ready(function () {
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


});
</script>
<script>
    $(document).ready(function () {
        $('.ui-table-list').footable();
        $('#select_Cardtype .i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        $("#pop_get_shop").click(function () {
            $('body').append('<div class="modal-backdrop in"></div>');
            $('#popgetshop').show();
            $.post('?m=User&c=merchant&a=getWxStore', function (rets) {
                $('#popgetshop').hide();
                $('.modal-backdrop').remove();
                if (rets.error) {
                    swal({
                        title: "温馨提示",
                        text: "没有已审核的商户可同步！",
                        type: "error"
                    });
                } else {
                    swal({
                        title: "温馨提示",
                        text: "已经同步完微信商户数据！",
                        type: "success"
                    }, function () {
                        window.location.reload();
                    });
                }
            }, 'JSON');
        });

        $("#pop_add_shop").click(function () {
            window.location.href = "?m=User&c=merchant&a=createStore";
        });

        $('.delete').click(function () {
            var id = $(this).attr('data-id');
            swal({
                title: "删除商户",
                text: "您真的要删除该商户吗？",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "取消",
                confirmButtonText: "确定",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "?m=System&c=merchant&a=merdel",
                        type: "POST",
                        data: {'id': id},
                        dataType: "JSON",
                        success: function (ret) {
                            if (ret.errcode == 1) {
                                swal({
                                    title: "删除成功",
                                    text: '商户删除成功',
                                    type: "success",
                                    closeOnConfirm: false
                                }, function () {
                                    location.reload();
                                });
                            } else {
                                swal("删除商户失败", ret.errmsg, "error");
                            }
                        }
                    });
                }
            });
        });
    });



</script>
<script>
    /******导出处理********/
    var tipshtm = '';
    var excellock = false;
    function exportExcel() {
        if (excellock) {
            $('#Export_excel_pop').show();
            $('body').append('<div class="modal-backdrop in"></div>');
            return false;
        }
        excellock = true;
        $('#Export_excel_pop ul').html('<li style="padding-top:20px;">正在导出您的数据，请稍等......</li>');
        $('#Export_excel_pop').show();
        $('body').append('<div class="modal-backdrop in"></div>');
        var fromData = $('form').serialize();
        $.post('/merchants.php?m=User&c=statistics&a=exportExcel', fromData, function (resp) {
            if (resp.error) {
                alert(resp.msg);
                return false;
            } else {
                if (resp.tt > 0) {
                    tipshtm = "<li>已经导出1到5000数据......." +
                            "<li id='extpage_1'>正在为您导出5001到10000条数据......</li>";
                    $('#Export_excel_pop ul').append(tipshtm);
                    Run_Export_excel(2);
                } else {
                    tipshtm = "<li>数据导出完成&nbsp;&nbsp;&nbsp;<a href='" + resp.fileurl + "'>下载<a></li>"
                    $('#Export_excel_pop ul').append(tipshtm);
                    excellock = false;
                }
            }
        }, 'json');

        return false;
    }



    function Run_Export_excel(page) {
        var fromData = $('form').serialize();
        fromData = fromData + '&page=' + page;
        $.post('/merchants.php?m=User&c=statistics&a=exportExcel', fromData, function (resp) {
            if (resp.error) {
                alert(resp.msg);
                return false;
            } else {
                var tmp = resp.p + 1;
                var idxs = (page - 1);
                if (!resp.flag && (tmp <= resp.tt)) {
                    var mc1 = 5000 * idxs + 1;
                    var mc2 = 5000 * page;
                    var mc3 = 5000 * tmp;
                    $('#extpage_' + idxs).html('已经导出' + mc1 + '到' + mc2 + '数据.......');
                    mc2 = mc2 + 1;
                    tipshtm = "<li id='extpage_" + page + "'>正在为您导出" + mc2 + "到" + mc3 + "条数据......</li>";
                    $('#Export_excel_pop ul').append(tipshtm);
                    Run_Export_excel(tmp);
                } else {
                    tipshtm = "<li id='extpage_end'>完成导出,正在为你打包导出的文件......</li>";
                    $('#Export_excel_pop ul').append(tipshtm);
                    if (true) {
                        $.post('/merchants.php?m=User&c=statistics&a=export_excel_zip', {page: resp.p}, function (rest) {
                            if (rest.error) {
                                alert(resp.msg);
                                return false;
                            } else {
                                tipshtm = "<li>打包完成。&nbsp;&nbsp;&nbsp;<a href='" + rest.fileurl + "'>下 载<a></li>";
                                $('#Export_excel_pop ul').append(tipshtm);
                                excellock = false;
                            }
                        }, 'json');
                    }
                }
                //window.location.reload();
            }
        }, 'json');

    }

</script>
</html>