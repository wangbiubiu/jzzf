<?php /* Smarty version 2.6.18, created on 2017-06-21 13:58:49
         compiled from E:%5CWWW%5C20170619%5CCashier%5C./pigcms_tpl/Merchants/System/settlement/mbank.tpl.php */ ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>结算管理 | 商家银行卡</title>
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
                <h2>商家结算</h2>
                <ol class="breadcrumb">
                    <li>
                        <a>System</a>
                    </li>
                    <li>
                        <a>结算中心</a>
                    </li>

                    <li class="active">
                        <strong>商家银行卡</strong>
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
                                    描述：已划账
                        -->
                        <div class="ibox-content yc" style="border-top:none">
                            <form action="/merchants.php?m=System&c=settlement&a=mbank" method="get">
                                <input type="hidden" value="System" name="m" >
                                <input type="hidden" value="settlement" name="c" >
                                <input type="hidden" value="mdebit" name="a" >
                                <div id="dataselect" class="form-group" style="padding: 0 10px;">
                                    <div id="datepicker" class="input-daterange">
                                        <label class="font-noraml">商户ID</label>
                                        <input class="input form-control" type="text" name="mid" <?php if (( isset ( $this->_tpl_vars['data']['mid'] ) )): ?><?php echo $this->_tpl_vars['data']['mid']; ?>
<?php endif; ?> placeholder="输入商户编号" style="width: 17%;border-radius:3px;height: 30px; margin-bottom: 0px;">
                                         &nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">
                                        &nbsp;&nbsp;&nbsp;
<!--                                        <a class="btn btn-primary"  style="width:100px;" href="" target="_blank">一键代付</a>-->
                                        <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:100px;" href="?m=System&c=settlement&a=data2Excel&type=mchb" >导出excel</a>-->
                                    </div>
                                </div>
                            </form>
                            <div class="employersDelAll" >
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter style="margin-bottom: 0px;">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;"  data-hide="phone">商户名称</th>
                                        <th style="text-align: center;"  data-hide="phone">类型</th>
                                        <th style="text-align: center;"  data-hide="phone">开户名称</th>
                                        <th style="text-align: center;"  data-hide="phone">证件类型</th>
                                        <th style="text-align: center;"  data-hide="phone">证件号码</th>
                                        <th style="text-align: center;"  data-hide="phone">开户银行</th>
                                        <th style="text-align: center;"  data-hide="phone">银行卡号</th>
                                        <th style="text-align: center;"  data-hide="phone">银行预留手机号</th>
                                        <th style="text-align: center;" data-hide="phone">状态</th>
                                        <th style="text-align: center;" data-hide="phone">备注</th>
                                        <th style="text-align: center;" data-hide="phone">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody class="js-list-body-region" id="table-list-body">
                                    <?php $_from = $this->_tpl_vars['bank']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vv']):
?>
                                    <tr class="widget-list-item bd_nr" style="text-align: center;height:50px;">
                                        <td><?php echo $this->_tpl_vars['vv']['company']; ?>
</td>
                                        <td><?php if (( $this->_tpl_vars['vv']['isCompay'] == 0 )): ?>个人<?php else: ?>公司<?php endif; ?></td>
                                        <td><?php echo $this->_tpl_vars['vv']['customerName']; ?>
</td>
                                        <td>
                                            <?php if (( $this->_tpl_vars['vv']['cerdType'] == '01' )): ?>身份证<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['cerdType'] == '02' )): ?>军官证<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['cerdType'] == '03' )): ?>护照<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['cerdType'] == '04' )): ?>回乡证<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['cerdType'] == '05' )): ?>台胞证<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['cerdType'] == '06' )): ?>警官证<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['cerdType'] == '07' )): ?>士兵证<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['cerdType'] == '99' )): ?>其它证件<?php endif; ?>
                                        </td>
                                        <td><?php echo $this->_tpl_vars['vv']['cerdId']; ?>
</td>
                                        <td>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'ICBC' )): ?>工商银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'ABC' )): ?>农业银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'BOC' )): ?>中国银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'CCB' )): ?>建设银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'CMB' )): ?>招商银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'BOCM' )): ?>交通银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'CMBC' )): ?>民生银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'CNCB' )): ?>中信银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'CEBB' )): ?>光大银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'CIB' )): ?>兴业银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'BOB' )): ?>北京银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'GDB' )): ?>广发银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'HXB' )): ?>华夏银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'PSBC' )): ?>邮储银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'SPDB' )): ?>浦发银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'PAB' )): ?>平安银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'BOS' )): ?>上海银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'BOHC' )): ?>渤海银行<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['settBankNo'] == 'BOJ' )): ?>江苏银行<?php endif; ?>
                                        </td>
                                        <td><?php echo $this->_tpl_vars['vv']['acctNo']; ?>
</td>
                                        <td><?php echo $this->_tpl_vars['vv']['phoneNo']; ?>
</td>
                                        <td>
                                            <?php if (( $this->_tpl_vars['vv']['bank'] == 0 )): ?>未审核<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['bank'] == 1 )): ?>审核通过<?php endif; ?>
                                            <?php if (( $this->_tpl_vars['vv']['bank'] == 2 )): ?>审核失败<?php endif; ?>
                                        </td>
                                        <td><?php echo $this->_tpl_vars['vv']['bankmsg']; ?>
</td>
                                        <td>
                                            <?php if (( $this->_tpl_vars['vv']['bank'] == 0 )): ?>
                                            <button class="btn btn-sm btn-info setmbank" data-id="<?php echo $this->_tpl_vars['vv']['id']; ?>
" style="background: #008fd3;">通过</button>
                                            <button class="btn btn-sm btn-danger" data-id="<?php echo $this->_tpl_vars['vv']['id']; ?>
" onclick="$('.bankmsg').fadeIn();$('.bankid').val('<?php echo $this->_tpl_vars['vv']['id']; ?>
')" style="background: #ed5565;">拒绝</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; endif; unset($_from); ?>


                                    </tbody>
                                </table>
                                <p style="text-align: right; padding-right: 150px; height: 50px; background: #f2f2f2; line-height: 50px;">合计数据：<?php echo $this->_tpl_vars['total']; ?>
 条</p>
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
<div class="bankmsg" style="width: 100%;height:1000px;position: fixed;background-color: rgba(0,0,0,0.5);top: 0;left: 0;z-index: 10000;display: none;">
    <div style="width: 500px;height: 300px;background-color: #fff;border-radius: 5px;margin: auto;top: 0;left: 0;right: 0;bottom: 0;position: fixed;overflow: hidden;">
        <div style="width: 100%;height: 50px;font-size: 16px;color:#fff;background-color: #ccc;line-height: 50px;;text-indent: 30px;">
            审核银行卡
            <div style="float:right;margin-right: 30px;">
                <a href="javascript:;" onclick="$('.bankmsg').fadeOut();" title="关闭窗口" style="font-size: 14px;color:#888;">关闭</a>
            </div>
        </div>
        <div style="width: 440px;margin: 50px auto 0;text-align: center;">
            <div>
                失败理由：
                <input type="text" name="bankmsg" value="" placeholder="必填" style="height: 40px;width: 300px;"/>
                <input type="hidden" name="bankid" class="bankid" value=""/>
            </div>
            <div style="margin-top: 30px;">
                <button class="btn btn-sm btn-info setmbank2" data-id="<?php echo $this->_tpl_vars['vv']['id']; ?>
" style="background: #008fd3;height: 40px;width: 200px;">失败提交</button>
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
    $('.setmbank').click(function () {
        var id = $(this).attr('data-id');
        swal({
            title: "您真的要通过银行卡信息吗？",
//            text: "确认提交",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "?m=System&c=settlement&a=setmbank",
                    type: "POST",
                    data: {'id': id},
                    dataType: "JSON",
                    success: function (ret) {
                        if (ret.errcode==1) {
                            swal({
                                title: "操作成功",
                                text: ret.msg,
                                type: "success",
                                closeOnConfirm: false
                            }, function () {
                                location.reload();
                            });
                        } else {
                            swal("操作失败", ret.msg, "error");
                        }
                    }
                });
            }
        });
    });
    $('.setmbank2').click(function () {
        var id = $(".bankid").val();
        var bankmsg = $("input[name='bankmsg']").val();
        swal({
            title: "您真的要拒绝银行卡信息吗？",
//            text: "确认提交",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "?m=System&c=settlement&a=setmbank2",
                    type: "POST",
                    data: {'id': id,'bankmsg':bankmsg},
                    dataType: "JSON",
                    success: function (ret) {
                        if (ret.errcode==1) {
                            swal({
                                title: "操作成功",
                                text: ret.msg,
                                type: "success",
                                closeOnConfirm: false
                            }, function () {
                                location.reload();
                            });
                        } else {
                            swal("操作失败", ret.msg, "error");
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