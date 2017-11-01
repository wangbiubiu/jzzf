<?php /* Smarty version 2.6.18, created on 2017-11-01 09:36:12
         compiled from F:%5Cgit%5Cjzzf%5CCashier%5C./pigcms_tpl/Merchants/System/count/agent.tpl.php */ ?>
<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>统计管理 | 代理统计</title>
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
        <link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
css/cashier.css" rel="stylesheet">
        <link href="<?php echo @RlStaticResource; ?>
plugins/css/datapicker/datepicker3.css" rel="stylesheet">
        <script src="<?php echo @RlStaticResource; ?>
plugins/js/datapicker/bootstrap-datepicker.js"></script>
        <script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
        <!-- Data picker -->
        <script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>

        <style>
button{ color:#ffffff}
            .clearfix:after {
                height: 0;
                content: " ";
                display: block;
                overflow: hidden;
                clear: both;
            }
            .clearfix {
                zoom: 1;/*IE低版本浏览器不支持after伪类所以要加这一句*/
            }
            .tit ul li{ float:left; font-size: 12px; padding: 0 20px; height: 40px; line-height: 40px;}
            .tit ul li a{color: #BDBDBD ; display: inline-block;}
            .tit ul li:hover{ background: #FFFFFF;}
            .tit ul li:hover a{ color: #000000 !important;}

            .content{background: #FFFFFF;}
            .content a{color:#000000 !important;}

            #dataselect .input-group-btn, #ym-select .input-group-btn {
                width: 12%;
            }

            #dataselect .input-sm, #ym-select .input-sm {
                border-radius: 7px;
                height: 40px;
            }

            #dataselect .btn-primary, #ym-select .btn-primary {
                margin-left: 20px;
                border-radius: 4px;
                margin-bottom: 0px;
            }

            #dataselect .input-group-addon, #ym-select .input-group-addon {
                border-radius: 7px;
            }

            .ibox-content {
                min-height: 550px;
            }

            .input-group .form-control {
                width: 45%;
                float: none;
            }
            #cibox-content{ min-height:550px;}
            #dataselect .input-group-btn,#ym-select .input-group-btn{width: 12%;}
            #dataselect .input-sm ,#ym-select .input-sm{ border-radius: 7px; height:40px;}
            #dataselect .btn-primary ,#ym-select .btn-primary{ margin-left: 20px; border-radius:4px;margin-bottom: 0px;}
            #dataselect .input-group-addon,#ym-select .input-group-addon{border-radius: 7px;}
            .input-group .form-control {
                width: 45%;
                float: none;
            }

            .store tbody tr th{ background: #f2f2f2; height: 40px; text-align: center;}
            .store tbody tr td{height: 40px; line-break: 40px; text-align: center;}
            .store tbody tr td p{ width: 100%; height: 40px; line-height: 40px; border-top: 1px solid #f2f2f2; margin-bottom: 0px;}
            .store tbody tr td button{border: none; width: 62px; height: 32px; background: #44b549; text-align: center; line-height: 32px; margin: 0px auto; border-radius: 5px;}
            .store tbody tr td button a{ color: #FFFFFF;}
            .bg_hide{display: none;}

            .hz{background: #f2f2f2; width: 98%; margin-left: 1%;height: 60px; line-height: 60px;}
            .hz p{ float: right; margin-left: 100px; margin-right: 50px; margin-bottom: 0px; }
            #commonpage{ margin-top: 10px; width:60%}
            .wrapper-content { padding: 20px 10px 60px 10px;}
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
                        <h2>代理统计</h2>
                        <ol class="breadcrumb">
                            <li>
                                <a>System</a>
                            </li>  
                            <li class="active">
                                <strong>代理统计</strong>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row wrapper page-heading iconList">


                    <!--
                            作者：2721190987@qq.com
                            时间：2016-10-19
                            描述：微信支付数据
                    -->
                    <div class="store_nr">
                        <div class="wrapper wrapper-content animated fadeInRight" style="width: 100%; background: #FFFFFF;">
                            <div class="row">
                                <form action="/merchants.php?m=System&c=count&a=agent" method="get">
                                    <input type="hidden" value="System" name="m" >
                                    <input type="hidden" value="count" name="c" >
                                    <input type="hidden" value="agent" name="a" >
                                    <div id="dataselect" class="form-group" style="padding: 0 10px;">
                                        <div id="datepicker" class="input-daterange">
                                            <label class="font-noraml">代理商名称</label>
                                            <input class="input form-control" type="text" placeholder="输入代理商名称" value="<?php if (isset($_POST['uname'])) echo $_POST['uname']; ?>" name="uname" style="width: 17%;border-radius: 7px;height: 30px; margin-bottom: 0px;">
                                            <label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
                                            <input type="text" value="<?php if (isset($getdata['start'])){ echo $getdata['start'];}else{echo date('Y-m-d');} ?>"  name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" margin-bottom: 0px; width: 20%; height: 30px;">
                                            &nbsp;<span> 到 </span>&nbsp; 
                                            <input type="text" value="<?php if (isset($getdata['end'])){ echo $getdata['end'];}else{echo date('Y-m-d');} ?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" margin-bottom: 0px; width: 20%;height: 30px;">
                                            &nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:100px;" href="?m=System&c=count&a=data2Excel&type=a" >导出excel</a>
                                        </div>
                                    </div>
                                </form>
                                <table class="store" border="1" bordercolor="#f2f2f2" width="98%" style="margin-left:1%;">
                                    <tbody>
                                        <tr>
                                            <th>代理名称</th>
                                            <th>支付方式</th>
                                            <th>支付金额(元)</th>
                                            <th>交易笔数</th>
<!--                                             <th>佣金率</th> -->
                                            <th>收入(元)</th>
                                            <th>详情</th>
                                        </tr>
                                        
                                        <?php $_from = $this->_tpl_vars['agents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                        <tr>
                                            <td><?php echo $this->_tpl_vars['row']['uname']; ?>
</td>
                                            <td>
                                                <p>微信</p>
                                                <p>支付宝</p>
                                                <p>qq</p>
                                            </td>
                                            <td>
                                                <p><?php echo $this->_tpl_vars['row']['wxsum']; ?>
</p>
                                                <p><?php echo $this->_tpl_vars['row']['alisum']; ?>
</p>
                                                <p><?php echo $this->_tpl_vars['row']['qqsum']; ?>
</p>
                                            </td>
                                            <td>
                                                <p><?php echo $this->_tpl_vars['row']['wxnum']; ?>
</p>
                                                <p><?php echo $this->_tpl_vars['row']['alinum']; ?>
</p>
                                                <p><?php echo $this->_tpl_vars['row']['qqnum']; ?>
</p>
                                            </td>
<!--                                            <td> -->
<!--                                                 <p><?php echo $this->_tpl_vars['row']['commission']*100; ?>
%</p> -->
<!--                                                 <p><?php echo $this->_tpl_vars['row']['commission']*100; ?>
%</p> -->
<!--                                                 <p><?php echo $this->_tpl_vars['row']['commission']*100; ?>
%</p> -->
<!--                                             </td> -->
                                            <td>
                                                <p><?php echo $this->_tpl_vars['row']['wxincome']; ?>
</p>
                                                <p><?php echo $this->_tpl_vars['row']['aliincome']; ?>
</p>
                                                <p><?php echo $this->_tpl_vars['row']['qqincome']; ?>
</p>
                                            </td>

                                            <td><a href="/merchants.php?m=System&c=count&a=agentdetail&aid=<?php echo $this->_tpl_vars['row']['aid']; ?>
"><button>查看</button></a></td>
                                        </tr>
                                       <?php endforeach; endif; unset($_from); ?> 
                                        
                                    </tbody>
                                </table>
                                <div class="hz clearfix">                                  
                                    <p>总收入：<?php echo $this->_tpl_vars['data']['income']; ?>
元</p>
                                    <p>总金额：<?php echo $this->_tpl_vars['data']['sum']; ?>
元</p>
                                    <p>总笔数：<?php echo $this->_tpl_vars['data']['count']; ?>
笔</p>
                                </div>
                               
                            </div>
                            <?php echo $this->_tpl_vars['pagebar']; ?>

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
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <script>
        $(".tit>ul>li").click(function () {
            var index = $(this).index();
            $(this).siblings().removeClass("content");
            $(this).addClass("content");
            $(".store_nr>div").hide();
            $(".store_nr>div").eq(index).show();


        });
    </script>

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