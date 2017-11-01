<?php /* Smarty version 2.6.18, created on 2017-11-01 09:36:53
         compiled from F:%5Cgit%5Cjzzf%5CCashier%5C./pigcms_tpl/Merchants/System/agent/index.tpl.php */ ?>
<!DOCTYPE html>
<html>
    <head>
        <title>代理中心 | 代理列表</title>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
wxCoupon/wxCoupon.css" rel="stylesheet">
        <link href="<?php echo @RlStaticResource; ?>
plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="<?php echo @RlStaticResource; ?>
plugins/css/iCheck/custom.css" rel="stylesheet">
        <link href="<?php echo @RL_PIGCMS_STATIC_PATH; ?>
plugins/css/footable/footable.core.css" rel="stylesheet">
        <link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
css/cashier.css" rel="stylesheet">
        <link href="<?php echo @RlStaticResource; ?>
plugins/css/datapicker/datepicker3.css" rel="stylesheet">
        <script src="<?php echo @RlStaticResource; ?>
plugins/js/datapicker/bootstrap-datepicker.js"></script>
        <script	src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
        <!-- Data picker -->
        <script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>

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
            .sh{ width:100px; height: 30px;padding: 0px !important;  color:#ffffff !important;line-height: 30px;}
            .sh:hover{ background:#4EBE53 !important }
            .md_xinxi>label{margin-right: 30px;}
            .md_xinxi>label>select,.md_xinxi>label>input{ width: 120px; height: 30px; line-height: 30px;}
            .md_xinxi>button{ padding: 0 10px; background: #4EBE53; border: none; height: 30px; line-height: 30px; text-align: center; color: #FFFFFF; border-radius: 5px;}
            th{ text-align: center;}

        </style>
        <script src="<?php echo @RlStaticResource; ?>
plugins/js/footable/footable.all2.min.js"></script>
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
                            <li><a>User</a></li>
                            <li><a>代理中心</a></li>
                            <li class="active"><strong>代理列表</strong></li>
                        </ol>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title clearfix">
                                    <ul class="nav">
                                        <li>
                                            <a  class="sh btn btn-primary" id="pop_add_shop" href="/merchants.php?m=System&c=agent&a=add"><i class="fa fa-plus"></i> 添加代理商</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="ibox-content">
                                    <nav class="ui-nav clearfix"></nav>
                                    <div class="app__content js-app-main page-cashier">
                                        <div>
                                            <!-- 实时交易信息展示区域 -->
                                            <div class="cashier-realtime">
                                                <form action="/merchants.php?m=System&c=agent&a=index" method="get">
                                                    <input type="hidden" value="System" name="m" >
                                                    <input type="hidden" value="agent" name="c" >
                                                    <input type="hidden" value="index" name="a" >
                                                    <div id="dataselect" class="form-group" style="padding: 0 10px;">
                                                        <div id="datepicker" class="input-daterange">
                                                            <label class="font-noraml">代理名称</label>
                                                            <input class=" form-control" type="text" name="uname" value="<?php if (( isset ( $this->_tpl_vars['data']['uname'] ) )): ?><?php echo $this->_tpl_vars['data']['uname']; ?>
<?php endif; ?>" placeholder="输入代理名称" style="width: 20%;border-radius:5px;height: 40px; margin-bottom: 0px;">
                                                            &nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="搜 索" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:100px;" href="?m=System&c=agent&a=data2Excel">导出excel</a>
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
                                                            <thead class="js-list-header-region tableFloatingHeaderOriginal" >
                                                                <tr class="widget-list-header">
                                                                    <th>序号</th>
                                                                    <th>登录账号</th>
                                                                    <th data-hide="phone">代理商名</th>
                                                                    <th>商户类型</th>
                                                                    <th data-hide="phone" >微  信</th>
                                                                    <th data-hide="phone" >支付宝</th>

<!--                                                                    <th data-hide="phone">支付宝佣金返点</th>-->
                                                                    <th data-hide="phone">添加时间</th>
                                                                    <th data-hide="phone">银行卡信息</th>
                                                                    <th data-hide="phone">操作</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="js-list-body-region" id="table-list-body">
                                                                <?php if (( ! empty ( $this->_tpl_vars['rows'] ) )): ?>
                                                                
                                                               <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                                                               
                                                                <tr class="widget-list-item">
                                                                    <td><?php echo $this->_tpl_vars['v']['aid']; ?>
</td>
                                                                    <td><?php echo $this->_tpl_vars['v']['account']; ?>
</td>
                                                                    <td><?php echo $this->_tpl_vars['v']['uname']; ?>
</td>
                                                                    <td class="bor" style="padding-top: 20px">
                                                                    <?php if ($this->_tpl_vars['v']['commission'] > 0): ?> <p style="padding-bottom: 2.5px">特约商户</p> <?php endif; ?>
                                                                    <?php if ($this->_tpl_vars['v']['ancommission'] > 0): ?><p style="padding-top: 2.5px">银行直连</p><?php endif; ?>            
                                                                     <?php if ($this->_tpl_vars['v']['wxcommission'] > 0): ?><p style="padding-top: 2.5px">金海泽</p><?php endif; ?>   
                                                                    </td>
                                                                  <td class="bor" style="padding-top: 20px">
                                                                      <?php if ($this->_tpl_vars['v']['commission'] > 0): ?><p style="padding-bottom: 2.5px"><?php echo $this->_tpl_vars['v']['commission']*100; ?>
%</p><?php endif; ?>
                                                                      <?php if ($this->_tpl_vars['v']['ancommission'] > 0): ?><p style="padding-top: 2.5px"><?php echo $this->_tpl_vars['v']['ancommission']*100; ?>
%</p><?php endif; ?>
                                                                      <?php if ($this->_tpl_vars['v']['wxcommission'] > 0): ?><p style="padding-top: 2.5px"><?php echo $this->_tpl_vars['v']['wxcommission']*100; ?>
%</p><?php endif; ?> 
                                                                  </td>
                                                                <!--                                                                    <td><?php echo $this->_tpl_vars['v']['alicommission']*100; ?>
%</td>-->
                                                                  <td class="bor" style="padding-top: 20px">
                                                                      <?php if ($this->_tpl_vars['v']['commission'] > 0): ?><p style="padding-bottom: 2.5px"><?php echo $this->_tpl_vars['v']['alicommission']*100; ?>
%</p><?php endif; ?>
                                                                      <?php if ($this->_tpl_vars['v']['ancommission'] > 0): ?><p style="padding-top: 2.5px"><?php echo $this->_tpl_vars['v']['analicommission']*100; ?>
%</p><?php endif; ?>
                                                                      <?php if ($this->_tpl_vars['v']['wxcommission'] > 0): ?><p style="padding-top: 2.5px"><?php echo $this->_tpl_vars['v']['qqcommission']*100; ?>
%</p><?php endif; ?>
                                                                  </td>

                                                                    <td><?php echo $this->_tpl_vars['v']['add_time']; ?>
</td>
                                                                    <td>
                                                                        <a class="btn btn-primary"  onclick="lookBanck(<?php echo $this->_tpl_vars['v']['aid']; ?>
)">查看信息</a>
                                                                    </td>
                                                                    <td>
                                                                        <a class="btn btn-sm btn-info" href="/merchants.php?m=System&c=agent&a=see&aid=<?php echo $this->_tpl_vars['v']['aid']; ?>
" style="vertical-align: top; background: #337ab7;"> 管理 </a>
                                                                        <a class="btn btn-sm btn-info" href="/merchants.php?m=Agent&c=index&a=index&agent_aid=<?php echo $this->_tpl_vars['v']['aid']; ?>
" style="vertical-align: top;" target="_blank">一键登录 </a>
                                                                        <button class="btn btn-sm btn-danger delete" data-id="<?php echo $this->_tpl_vars['v']['aid']; ?>
"><strong>删&nbsp;&nbsp;除 </strong></button>
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; endif; unset($_from); ?>
                                                                <?php else: ?>
                                                                <tr class="widget-list-item">
                                                                    <td colspan="9">暂无商户</td>
                                                                </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>

                                                        <div class="js-list-empty-region">
                                                            
                                                        </div>
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
                        <h6 class="modal-title">请耐心等待完成...</h6>
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
  
        $('.delete').click(function () {
           
            var id = $(this).attr('data-id');
            swal({
                title: "删除代理商",
                text: "您真的要删除该代理商吗？",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "删除",
                cancelButtonText: "取消",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function (isConfirm) {
                
                if (isConfirm) {
                    $.ajax({
                        url: "/merchants.php?m=System&c=agent&a=agentdel",
                        type: "POST",
                        data: {'id': id},
                        dataType: "JSON",
                        success: function (ret) {
                            
                            if (ret.errcode==1) {
                                swal({
                                    title: "删除成功",
                                    text: '代理商删除成功',
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

//查看银行卡
 function lookBanck(aid) {

    $.post('/merchants.php?m=System&c=agent&a=getAgentBank', {aidd: aid}, function (rets) {
        rets.error = parseInt(rets.error);
        
        if (!rets.error) {
            $('#new_bank_box #banckname').text(rets.data.bankcard.bankname);
            $('#new_bank_box #bankcardnumm').text(rets.data.bankcard.bankid);
            $('#new_bank_box #banktruename').text(rets.data.bankcard.owner);
            
            $('#new_bank_box #identitycode').text(rets.data.idcard.idcard);
            $('#new_bank_box #bankA').attr('src', rets.data.bankcard.cardA);
            $('#new_bank_box #bankB').attr('src', rets.data.bankcard.cardB);
            $('#new_bank_box #identitycodeA').attr('src', rets.data.idcard.cardA);
            $('#new_bank_box #identitycodeB').attr('src', rets.data.idcard.cardB);
            $('#new_bank_box #in_bank').attr('src', rets.data.idcard.idAndBankcard);
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