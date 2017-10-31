<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>收银台 | 员工列表</title>
        <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/header.tpl.php'; ?>


        <!-- FooTable -->
        <link href="<?php echo RL_PIGCMS_STATIC_PATH; ?>plugins/css/footable/footable.core.css" rel="stylesheet">
        <link href="<?php echo $this->RlStaticResource; ?>plugins/css/iCheck/custom.css" rel="stylesheet">
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

            .tit ul li{ float: left; padding: 0 3%; list-style: none; color: #b1bac8; cursor: pointer; height: 30px; line-height: 30px;}
            .tit ul li:hover{ color: #8f99a7;}
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
            .ibox-content>h2{ width: 100%; height: 40px; line-height: 20px; margin: 0 20px; border-bottom: 1px solid #f3f3f3; margin-bottom: 10px;}
            .ibox-content>h2>a{color: #FFFFFF; background: #0066CC; display: inline-block; border-radius: 3px; padding: 5px 10px; height: 30px;font-size: 14px;}
        </style>
    </head>

    <body>

        <div id="wrapper">
            <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/leftmenu.tpl.php'; ?>

            <div id="page-wrapper" class="gray-bg">
                <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/top.tpl.php'; ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>员工列表</h2>
                        <ol class="breadcrumb">
                            <li>
                                <a>User</a>
                            </li>
                            <li>
                                <a>门店列表</a>
                            </li>
                            <li>
                                <a>门店信息管理</a>
                            </li>
                            <li class="active">
                                <strong>店员列表</strong>
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
                                <li>基本信息</li>
                                <li class="cont">店员</li>

                                <li >打印机</li>
                            </ul>
                        </div>

                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <!--
                                        作者：2721190987@qq.com
                                        时间：2016-10-20
                                        描述：基本信息
                                -->
                                <div class="ibox-content yc" style="border-top:none;">

                                    <div class="panel-body" style="padding: 0px; ">
                                        <div class="form-horizontal form-border jbxi_bg" style="width: 100%; margin: 0 auto; border: 1px solid #EEEEEE;">
                                            <h4 class="tit_h4"><span>基本信息</span><a style="float: right;" href="/merchants.php?m=User&c=merchant&a=information&id=<?php echo $store['id']; ?>">编辑</a></h4>
                                            <div class="form-group clearfix">
                                                <label>名称</label>
                                                <p><?php echo $store['business_name']; ?></p>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label>地址</label>
                                                <p><?php echo $store['provincename'].$store['cityname'].$store['districtname'].$store['address']; ?></p>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label >电话</label>
                                                <p><?php echo $store['telephone']; ?></p>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label >银行卡号</label>
                                                <p><?php echo $store['bank']; ?></p>
                                            </div>

                                           <div class="form-group clearfix">
                                                <label>备注</label>
                                                <p><?php  echo $store['fsortname']."  ".$store['sortname'];?></p>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <!--
                                        作者：2721190987@qq.com
                                        时间：2016-10-20
                                        描述：店员列表
                                -->

                                <div class="ibox-content" style="border-top:none">
                                    <?php if (empty($emp) or $mtype!=3) { ?>
                                    <h2><a href="?m=User&c=merchant&a=addstore&sid=<?php echo $sid ;?>">+添加店员</a></h2>
                                    <?php } ?>
                                    <form action="?m=User&c=merchant&a=detail" method="get">
                                        <input type="hidden" name="m" value="User">
                                        <input type="hidden" name="c" value="merchant">
                                        <input type="hidden" name="a" value="detail">
                                        <input type="hidden" name="id" value="<?php echo $sid ?>">
                                        <label>
                                            店员名称
                                            <input type="text"  name="username" id="filter" placeholder="输入店员名称" style="width: 160px; height: 30px;">
                                            <button style=" background: #44b549; border: none; padding: 0 10px; border-radius: 5px; height: 30px; color: #FFFFFF;">搜索</button>
                                        </label>
                                    </form>
                                    <div class="employersDelAll" >
                                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter>
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;"  data-hide="phone">序号</th>
                                                    <th  style="text-align: center;">店员昵称</th>
                                                    <th style="text-align: center;" data-hide="phone">用户名</th>
                                                    <th style="text-align: center;" data-hide="phone">级别</th>
                                                    <th style="text-align: center;" data-hide="phone">操作</th>
                                                </tr>
                                            </thead>
                                            <tbody class="js-list-body-region" id="table-list-body">
                                                <?php $i=-1;?>
                                                <?php foreach ($emp as $v){ ?>
                                                    <?php $i++;?>
                                                <tr class="widget-list-item bd_nr" style="text-align: center;">
                                                    <td><?php echo $v['eid']; ?></td>
                                                    <td><?php echo $v['username']; ?></td>
                                                    <td><?php echo $v['account']; ?></td>
                                                    <td><?php if($v['level']==1){echo "店长";}else{echo "店员";} ?></td>
                                                    <td>
                                                        <p>
                                                            <a href="/merchants.php?m=User&c=merchant&a=assistant&eid=<?php echo $v['eid'];?>"><button class="btn btn-sm btn-info" style="background: #337ab7;">管理</button></a>
                                                            <a href="javascript:void(0);"><button class="btn btn-sm btn-danger employersDel" data-id="<?php echo $v['eid'];?>" style="background: #ed5565;">删除</button></a>
                                                        </p>
                                                    </td>

                                                </tr>
                                                <?php } ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                             
                                <div class="ibox-content yc" style="border-top:none;">

                                    <div class="panel-body" style="padding: 0px; ">
                                        <div class="form-horizontal form-border jbxi_bg" style="width: 100%; margin: 0 auto; border: 1px solid #EEEEEE;">
                                            <h4 class="tit_h4"><span>打印机信息</span></h4>
                                            <?php if($printer) {?>
                                                <div class="employersDelAll" >
                                                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter>
                                                        <thead>
                                                        <tr>
                                                            <th style="text-align: center;"  data-hide="phone">序号</th>
                                                            <th  style="text-align: center;">店员昵称</th>
                                                            <th style="text-align: center;" data-hide="phone">打印机编号</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="js-list-body-region" id="table-list-body">
                                                        <?php foreach ($print_arr as $v){  ?>

                                                                <tr class="widget-list-item bd_nr" style="text-align: center;">
                                                                    <td><?php echo $v['eid']; ?></td>
                                                                    <td><?php echo $v['username'] ?> </td>
                                                                    <td><?php echo empty($v['print_id'])?"还没有打印机":$v['print_id']; ?></td>
                                                                </tr>

                                                        <?php } ?>

                                                        </tbody>
                                                    </table>
                                                </div>

                                            <?php }else{?>
                                            <div class="form-group clearfix">
                                                
                                                <p>当前没有打印机</p>
                                            </div>
                                            <?php }?>
                                        </div>


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
                <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/footer.tpl.php'; ?>
            </div>
        </div>
        <script>
            $(".tit>ul>li").click(function () {
                var index = $(this).index();
                var web = $(this).text();
                $(".active>strong").html("门店" + web)
                $(this).addClass("cont")
                $(this).siblings().removeClass("cont");
                $(".ibox>div").eq(index).show();
                $(".ibox>div").eq(index).siblings().hide();
            });
        </script>



        <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">添加员工</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <form id="employersForm" class="form" action="?m=User&c=merchant&a=employersAdd" method="post">
                            <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h5>账户信息</h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="form-group">
                                            <label><span class="mustInput">*</span>员工名称:<span class="f999">(20字以内)</span></label>
                                            <input type="text"  id="username" placeholder="请输入员工名称" name="username" class="form-control required" aria-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label><span class="mustInput">*</span>登录账号:</label>
                                            <input type="text" id="account" placeholder="请输入登录账号" name="account" class="form-control required"aria-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label><span class="mustInput">*</span>手机号:</label>
                                            <input type="tel" id="phone" placeholder="请输入员工的手机号" name="phone" class="form-control required" aria-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label><span class="mustInput">*</span>邮箱:</label>
                                            <input type="email" id="email" placeholder="请输入邮箱" name="email" class="form-control required" aria-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label><span class="mustInput">*</span>密码:</label>
                                            <input type="password" id="password" placeholder="请输入密码(6到20个字符)" name="password" class="form-control required" aria-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label><span class="mustInput">*</span>确认密码:<span class="f999"></span></label>
                                            <input type="password" id="confirm" placeholder="" name="confirm" class="form-control required" aria-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label><span class="mustInput"></span>门店选择：<span class="f999"></span></label>
                                            <?php if (empty($StoreInfo)) { ?>
                                                <div style="margin-top:10px">您还没有门店，请去门店管理里去创建吧。<br/>如果您不选门店，员工账号登录进来将可以看见所有的支付订单和卡券，会员卡<div>
                                                    <?php } else { ?>
                                                        <select name="storeid" class="form-control" style="z-index:999">
                                                            <option value="0">不选择门店</option>
                                                            <?php foreach ($StoreInfo as $svv) { ?>
                                                                <option  value="<?php echo $svv['id']; ?>" ><?php echo $svv['business_name'] . $svv['branch_name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div style="margin-top:10px">如果您不选门店，员工账号登录进来将可以看见所有的支付订单和卡券，会员卡<div>
                                                            <?php } ?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="ibox">
                                                    <div class="ibox-title">
                                                        <h5>权限设置</h5>
                                                    </div>
                                                    <div class="ibox-content">
                                                        <div id="permission_list">
                                                            <?php foreach ($authority as $key => $val) { ?>
                                                                <div class="part_item">
                                                                    <div class="part_item_t">
                                                                        <p><b><input type="checkbox" class="checkAll"><?php echo $val['Des'];
                                                            unset($val['Des']); ?></b></p>
                                                                    </div>
                                                                    <div class="part_item_b">
                                                                        <?php foreach ($val as $k => $v) { ?>
                                                                            <p><input type="checkbox" name="authority[]" value="<?php echo 'Merchants/User/' . $key . '/' . $k; ?>"><?php echo $v; ?></p>
    <?php } ?>
                                                                    </div>
                                                                </div>
<?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                                            <button type="button" class="btn btn-primary formSubmit">保存</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="employersEditJump"  data-toggle="modal" data-target="#myModal6" data-toggle="tooltip" data-placement="left" title="" data-original-title="员工信息编辑" style="display: none;">员工信息编辑</a>
                            <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">员工信息编辑</h4>
                                        </div>
                                        <div class="modal-body clearfix">
                                            <div class="col-lg-12">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script type="text/html" id="employersEditTpl">
                                <figure>
                                    <iframe width="425" height="349" src="?m=User&c=merchant&a=employersEdit&eid={($eid)}" frameborder="0"></iframe>
                                </figure>
                                </script>

                                <!-- FooTable -->
                                <script src="<?php echo $this->RlStaticResource; ?>plugins/js/footable/footable.all.min.js"></script>

                                <!-- iCheck -->
                                <script src="<?php echo $this->RlStaticResource; ?>plugins/js/iCheck/icheck.min.js"></script>

                                <!-- Jquery Validate -->
                                <script src="<?php echo $this->RlStaticResource; ?>plugins/js/validate/jquery.validate.min.js"></script>

                                <!-- Page-Level Scripts -->
                                <script>
            $(document).ready(function () {
                employers.init();
            });
            !function (a, b) {
                var employers = employers || {};
                employers.init = function () {
                    var c = employers;
                    b('.footable').footable();
                    b('.i-checks').iCheck({
                        checkboxClass: 'icheckbox_square-green',
                        radioClass: 'iradio_square-green',
                    });
                    b('#check_box').on('ifChanged', function () {
                        c.selectall('id[]', 'check_box');
                    });
                    b('.info_del_all').click(function () {
                        c.delAll();
                    });
                    b('.part_item .checkAll').click(function () {
                        var checkItems = b(this).parents('.part_item_t').siblings('.part_item_b').find('p').find('input[name="authority[]"]');
                        if (b(this).is(':checked') == false) {
                            checkItems.each(function (ke, el) {
                                $(el).iCheck('uncheck');
                            });
                        } else {
                            checkItems.each(function (ke, el) {
                                $(el).iCheck('check');
                            });
                        }
                    });
                    jQuery.extend(jQuery.validator.messages, {
                        required: "必填字段",
                        remote: "请修正该字段",
                        email: "请输入正确格式的电子邮件",
                        equalTo: "请再次输入相同的值",
                        maxlength: jQuery.validator.format("请输入一个长度最多是 {0} 的字符串"),
                        minlength: jQuery.validator.format("请输入一个长度最少是 {0} 的字符串"),
                    });
                    b('#employersForm').validate({
                        errorPlacement: function (error, element) {
                            element.before(error);
                        },
                        rules: {
                            confirm: {
                                equalTo: "#password"
                            },
                            account: {
                                minlength: 4
                            },
                            password: {
                                minlength: 4
                            }
                        }
                    });
                    b('.formSubmit').click(function () {
                        if (b('#account').val() != '') {
                            $.post('?m=User&c=merchant&a=checkAccount', {account: b('#account').val()}, function (re) {
                                if (re.status == 0) {
                                    b('#account').addClass('error');
                                    swal("错误", re.msg + " :)", "error");
                                } else if (re.status == 1) {
                                    b('#employersForm').submit();
                                }
                            }, 'json');
                        } else {
                            b('#employersForm').submit();
                        }
                    });
                    b('.status-checkbox').change(function () {
                        var i = b(this).attr('data-id'), s = b(this).is(':checked') ? 1 : 0;
                        $.post('?m=User&c=merchant&a=field', {eid: i, status: s}, function (re) {
                            if (re.status == 0) {
                                swal("错误", re.msg + " :)", "error");
                            }
                        }, 'json');
                    });
                    b('.employersDel').click(function () {
                        var c = b(this);
                        swal({
                            title: "是否删除这条数据?",
                            text: "删除数据后将无法恢复，确认要删除吗！",
                            type: "warning",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "删除",
                            cancelButtonText: "取消",
                            closeOnConfirm: false,
                            showCancelButton: true,
                        }, function () {
                            $.post('?m=User&c=merchant&a=employersDel', {eid: c.attr('data-id')}, function (re) {
                                if (re.status == 0) {
                                    swal("错误", re.errmsg + , "error");
                                } else {
                                    swal("成功", re.errmsg + , "success");
                                    c.parents('tr').remove();
                                    b('.footable').footable();
                                }
                            }, 'json');
                        });
                    });
                    b('.employersEdit').click(function () {
                        c.edit(b(this).attr('data-id'));
                    });
                };
                employers.selectall = function (name, id) {
                    var checkItems = b('input[name="' + name + '"]');
                    if ($("#" + id).is(':checked') == false) {
                        checkItems.each(function (ke, el) {
                            $(el).iCheck('uncheck');
                        });
                    } else {
                        checkItems.each(function (ke, el) {
                            $(el).iCheck('check');
                        });
                    }
                }
                employers.delAll = function () {
                    swal({
                        title: "是否删除选中?",
                        text: "删除数据后将无法恢复，确认要删除吗！",
                        type: "warning",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "删除",
                        cancelButtonText: "取消",
                        closeOnConfirm: false,
                        showCancelButton: true,
                    }, function () {
                        var checkItems = b('input[name="id[]"]'), c = false;

                        checkItems.each(function (ke, el) {
                            if ($(el).is(':checked') == true) {
                                c = true;
                            }
                        });
                        if (c == false) {
                            swal("错误", "你至少需要选中一项 :)", "error");
                            return false;
                        }
                        $('.employersDelAll').submit();
                    });
                }
                employers.edit = function (data) {
                    var $data = b('#employersEditTpl').html().replace('{($eid)}', data);
                    b('#myModal6').find('.modal-content .modal-body').find('.col-lg-12').html($data);
                    b('.employersEditJump').click();
                    employers.iframeRresponsible();
                    var index = window.setTimeout(function () {
                        $(window).resize();
                    }, 200);
                }
                employers.iframeRresponsible = function () {
                    var $allObjects = $("iframe, object, embed"),
                            $fluidEl = $("figure");

                    $allObjects.each(function () {
                        $(this)
                                // jQuery .data does not work on object/embed elements
                                .attr('data-aspectRatio', this.height / this.width)
                                .removeAttr('height')
                                .removeAttr('width');
                    });
                    $(window).resize(function () {
                        var newWidth = $fluidEl.width();
                        $allObjects.each(function () {
                            var $el = $(this);
                            $el
                                    .width(newWidth)
                                    .height(newWidth * $el.attr('data-aspectRatio'));
                        });
                    }).resize();
                }
                a.employers = employers;
            }(window, jQuery);
                                </script>
                                </body>
                                </html>