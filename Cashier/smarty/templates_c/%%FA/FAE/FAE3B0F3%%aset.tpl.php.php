<?php /* Smarty version 2.6.18, created on 2016-12-01 16:38:48
         compiled from D:%5Ctest%5Cpay%5Cpay%5CCashier%5C./pigcms_tpl/Merchants/System/settlement/aset.tpl.php */ ?>
<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>结算管理 | 代理结算</title>
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
        <link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
css/cashier.css" rel="stylesheet">
        <link href="<?php echo @RlStaticResource; ?>
plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="<?php echo @RlStaticResource; ?>
plugins/css/datapicker/datepicker3.css" rel="stylesheet">
        <script src="<?php echo @RlStaticResource; ?>
plugins/js/datapicker/bootstrap-datepicker.js"></script>
        <script
        src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
        <!-- Data picker -->
        <script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
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
            .ibox-content{
                    padding: 15px 20px 50px 20px;
            }
            .tit ul li{ float: left; list-style: none; color: #b1bac8; cursor: pointer; height: 40px; line-height: 40px; width: 110px; text-align: center;}
            .tit ul li:hover{ color: #8f99a7;}
            .tit ul li a{display: inline-block; width: 100%; height: 100%; color:#999999}
            .cont{ background: #FFFFFF; color: #000000 !important;}
            .bd_nr>td{ line-height: 30px !important; height:30px !important; padding: 10px 0px 0px !important;}
            .bd_nr>td>button{ padding: 0 10px; margin: 0 10px; border: none; border-radius: 5px; height:30px; color: #FFFFFF;}
            .yc{display: none;}
            .tit_h4{ background: #f2f2f2; height: 40px; line-height: 40px; padding: 0 20px; width: 100%;margin:0px !important;}
            .tit_h4 span{ color: #676a6c; font-weight: normal;}
            .tit_h4 a{ color: #44b549; font-weight: normal;}
            .jbxi_bg>div{border-top: 1px solid #f2f2f2; padding: 20px 0; margin: 0px !important;}
            .jbxi_bg>div label{ display: block; width: 100px; text-align: right;height: 30px; line-height: 30px; overflow: hidden; float: left;}
            .jbxi_bg>div>p{margin-left: 20px; width: 50%; height: 30px; line-height: 30px; overflow: hidden; text-overflow: ellipsis;float: left;}
            .form-control{
                width: 80%;
            }
            .footable-odd {
                background-color: #ffffff;
            }
            .sl{background: #ebebed; border-bottom: 1px solid #EEEEEE;border-top: 1px solid #EEEEEE; height: 40px; line-height: 40px; text-align: right;}
            .sl>span{margin-right: 40px;}
            .fl{float: left;}
            .fr{ float: right;}

            tbody>tr>td{ padding: 10px 0 !important;}
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
                        <h2>代理结算</h2>
                        <ol class="breadcrumb">
                            <li>
                                <a>System</a>
                            </li>
                            <li>
                                <a>结算中心</a>
                            </li>

                            <li class="active">
                                <strong>代理结算</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="tit">
                            <ul class="clearfix " style="margin-bottom: 0px; padding-left: 16px;">
                               <li <?php if ($this->_tpl_vars['type'] == 1): ?> class="cont" <?php endif; ?>> <a href="/merchants.php?m=System&c=settlement&a=aset">待划账</a></li>
                                <li <?php if ($this->_tpl_vars['type'] == 2): ?> class="cont" <?php endif; ?>><a href="/merchants.php?m=System&c=settlement&a=debit">已划账</a></li>


                            </ul>
                        </div>

                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">

                                <!--
                                        作者：2721190987@qq.com
                                        时间：2016-10-20
                                        描述：待划账
                                -->

                                <div class="ibox-content" style="border-top:none">
                                  <form action="/merchants.php?m=System&c=settlement&a=aset" method="get">
                                    <input type="hidden" value="System" name="m" >
                                    <input type="hidden" value="settlement" name="c" >
                                    <input type="hidden" value="aset" name="a" >
                                    <div id="dataselect" class="form-group" style="padding: 0 10px;">
                                        <div id="datepicker" class="input-daterange">
                                            <label class="font-noraml">代理名称</label>
                                            <input class="input form-control" type="text" name="name" value="<?php if (( isset ( $this->_tpl_vars['getdata']['name'] ) )): ?> <?php echo $this->_tpl_vars['getdata']['name']; ?>
<?php endif; ?>" placeholder="输入代理名称" style="width: 17%;border-radius: 3px;height: 30px; margin-bottom: 0px;">
                                            <label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
                                            <input type="text" value="<?php if (( isset ( $this->_tpl_vars['getdata']['start'] ) )): ?> <?php echo $this->_tpl_vars['getdata']['start']; ?>
<?php endif; ?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" margin-bottom: 0px; width:17%; height: 30px;border-radius:3px">
                                            &nbsp;<span> 到 </span>&nbsp; 
                                            <input type="text" value="<?php if (( isset ( $this->_tpl_vars['getdata']['end'] ) )): ?><?php echo $this->_tpl_vars['getdata']['end']; ?>
<?php endif; ?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" margin-bottom: 0px; width: 17%;height: 30px;border-radius:3px"> 
                                            &nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:100px;" href="?m=System&c=settlement&a=data2Excel&type=agent">导出excel</a>
                                        </div>
                                    </div>
                                 </form>
                                    <div class="employersDelAll" >
                                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter>
                                            <thead>
                                                <tr>
                                                <th style="text-align: center;"  data-hide="phone">代理商名称</th>
                                                    <th style="text-align: center;"  data-hide="phone">银行卡号</th>
                                                    <th style="text-align: center;"  data-hide="phone">开户姓名</th>
                                                    <th style="text-align: center;"  data-hide="phone">开户银行</th>
                                                    <th  style="text-align: center;">发起提现时间</th>
                                                    <th style="text-align: center;" data-hide="phone">提现金额</th>
                                                    <th style="text-align: center;" data-hide="phone">操作</th>
                                                </tr>
                                            </thead>
                                            <tbody class="js-list-body-region" id="table-list-body">
                                                <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                                                <tr class="widget-list-item bd_nr" style="text-align: center;">
                                                    <td><?php echo $this->_tpl_vars['v']['name']; ?>
</td>
                                                    <td><?php echo $this->_tpl_vars['v']['bankid']; ?>
</td>
                                                    <td><?php echo $this->_tpl_vars['v']['owner']; ?>
</td>
                                                    <td><?php echo $this->_tpl_vars['v']['bankname']; ?>
</td>
                                                    <td><?php echo $this->_tpl_vars['v']['addtime']; ?>
</td>
                                                    <td><?php echo $this->_tpl_vars['v']['money']; ?>
</td>
                                                    <td>
                                                        <p>
                                                            <button class="btn btn-sm btn-info debit" data-id="<?php echo $this->_tpl_vars['v']['id']; ?>
" style="background: #008fd3;">划账</button>
                                                        </p>
                                                    </td>

                                                </tr>
                                                <?php endforeach; endif; unset($_from); ?>
                                               
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                    <?php echo $this->_tpl_vars['pagebar']; ?>

                                </div>
                                
                                <!--
                                            作者：2721190987@qq.com
                                            时间：2016-10-20
                                            描述：已划账
                                -->
                                <div class="ibox-content yc" style="border-top:none">
                                   <form action="/merchants.php?m=System&c=settlement&a=debit" method="get">
                                    <input type="hidden" value="System" name="m" >
                                    <input type="hidden" value="settlement" name="c" >
                                    <input type="hidden" value="debit" name="a" >
                                    <div id="dataselect" class="form-group" style="padding: 0 10px;">
                                        <div id="datepicker" class="input-daterange">
                                            <label class="font-noraml">代理名称</label>
                                            <input class="input form-control" type="text" name="name" <?php if (( isset ( $this->_tpl_vars['data']['name'] ) )): ?><?php echo $this->_tpl_vars['data']['name']; ?>
<?php endif; ?> placeholder="输入代理名称名称" style="width: 17%;border-radius:3px;height: 30px; margin-bottom: 0px;">
                                            <label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
                                            <input type="text" value="<?php if (( isset ( $this->_tpl_vars['data']['start'] ) )): ?><?php echo $this->_tpl_vars['data']['start']; ?>
<?php endif; ?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" margin-bottom: 0px; width: 17%;border-radius:3px;height: 30px">
                                            &nbsp;<span> 到 </span>&nbsp; 
                                            <input type="text" value="<?php if (( isset ( $this->_tpl_vars['data']['end'] ) )): ?><?php echo $this->_tpl_vars['data']['end']; ?>
<?php endif; ?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" margin-bottom: 0px; width: 17%;border-radius:3px;height: 30px"> 
                                            &nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:100px;" href="?m=System&c=settlement&a=data2Excel&type=agentb"" >导出excel</a>
                                        </div>
                                    </div>
                                   </form>
                                    <div class="employersDelAll" >
                                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter style="margin-bottom: 0px;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;"  data-hide="phone">代理商名称</th>
                                                    <th style="text-align: center;"  data-hide="phone">银行卡号</th>
                                                    <th style="text-align: center;"  data-hide="phone">开户姓名</th>
                                                    <th style="text-align: center;"  data-hide="phone">开户银行</th>
                                                    <th  style="text-align: center;">发起提现时间</th>
                                                    <th style="text-align: center;" data-hide="phone">提现金额</th>
                                                </tr>
                                            </thead>
                                            <tbody class="js-list-body-region" id="table-list-body">
                                                <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vv']):
?>
                                                <tr class="widget-list-item bd_nr" style="text-align: center;">
                                                    <td><?php echo $this->_tpl_vars['vv']['name']; ?>
</td>
                                                    <td><?php echo $this->_tpl_vars['vv']['bankid']; ?>
</td>
                                                    <td><?php echo $this->_tpl_vars['vv']['owner']; ?>
</td>
                                                    <td><?php echo $this->_tpl_vars['vv']['bankname']; ?>
</td>
                                                    <td><?php echo $this->_tpl_vars['vv']['addtime']; ?>
</td>
                                                    <td><?php echo $this->_tpl_vars['vv']['money']; ?>
</td>
                                                </tr>
                                                <?php endforeach; endif; unset($_from); ?>
                                               

                                            </tbody>
                                        </table>
                                        <p style="text-align: right; padding-right: 150px; height: 50px; background: #f2f2f2; line-height: 50px;">合计金额:<?php echo $this->_tpl_vars['total']; ?>
元</p>
                                    </div>
                                    <?php echo $this->_tpl_vars['page']; ?>

                                </div>
                                
                                <!--
                                            作者：2721190987@qq.com
                                            时间：2016-10-20
                                            描述：打印机
                                -->

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
    <script>
        $(".tit>ul>li").click(function () {
            var index = $(this).index();
            var web = $(this).text();
            $(".active>strong").html(web)
            $(this).addClass("cont")
            $(this).siblings().removeClass("cont");
           
        });
        window.onload=function(){
            var index =  $(".cont").index();
           $(".ibox>div").eq(index).show();
            $(".ibox>div").eq(index).siblings().hide();
           
        }
    </script>


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


    <script type="text/javascript">
           if (mobilecheck()) {
               $("#side-menu li").click(function () {
                   $("#side-menu li").find('.nav-second-level').css('display', 'none');
                   $(this).find('.nav-second-level').css('display', 'block').css('min-width', '140px');
               });
           }
           if (navigator.userAgent.indexOf("AlipayClient") != -1) {
               $('#shou-kuan').attr('href', '/merchants.php?m=User&c=alicashier&a=alipayment&type=1');
               $('#tui-kuan').attr('href', '/merchants.php?m=User&c=alicashier&a=alipayment&type=2');
           }
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

            GetChartData('smcount', 'linecountChart', 'canvasdesc');
            $('#dataselect .btn-primary').click(function () {
                GetChartData('smcount', 'linecountChart', 'canvasdesc');
            });
        });
    </script>
    <script>
        
        $('.debit').click(function () {
            var id = $(this).attr('data-id');
            
            swal({
                title: "代理商划账",
                text: "您真的要划账吗？",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "?m=System&c=settlement&a=setdebit",
                        type: "POST",
                        data: {'id': id},
                        dataType: "JSON",
                        success: function (ret) {
                            if (ret.errcode==1) {
                                swal({
                                    title: "划账成功",
                                    text: '代理商划账成功',
                                    type: "success",
                                    closeOnConfirm: false
                                }, function () {
                                    location.reload();
                                });
                            } else {
                                swal("代理商划账失败", ret.errmsg, "error");
                            }
                        }
                    });
                }
            });
        });
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
</body>
</html>