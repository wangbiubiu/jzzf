<!DOCTYPE html>
<html>
<head>
    <title>代理商 | 广告列表</title>
    <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/header.tpl.php'; ?>
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>wxCoupon/wxCoupon.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource; ?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource; ?>plugins/css/iCheck/custom.css" rel="stylesheet">
    <link href="<?php echo RL_PIGCMS_STATIC_PATH; ?>plugins/css/footable/footable.core.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>css/cashier.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource; ?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
    <script src="<?php echo $this->RlStaticResource; ?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
    <script
            src="https://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
    <!-- Data picker -->
    <script src="https://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>

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

        .md_xinxi > label {
            margin-right: 30px;
        }

        .md_xinxi > label > select, .md_xinxi > label > input {
            width: 120px;
            height: 30px;
            line-height: 30px;
        }

        .md_xinxi > button {
            padding: 0 10px;
            background: #4EBE53;
            border: none;
            height: 30px;
            line-height: 30px;
            text-align: center;
            color: #FFFFFF;
            border-radius: 5px;
        }

        th {
            text-align: center;
        }
    </style>
    <script src="<?php echo $this->RlStaticResource; ?>plugins/js/footable/footable.all2.min.js"></script>
</head>

<body>
<div id="wrapper">
    <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/leftmenu.tpl.php'; ?>
    <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/top.tpl.php'; ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>广告列表</h2>
                <ol class="breadcrumb">
                    <li><a>Agent</a></li>
                    <li><a>广告中心</a></li>
                    <li class="active"><strong>广告列表</strong></li>
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
                                    <button class="btn btn-primary" id="pop_add_shop"><i class="fa fa-plus"></i>添加广告
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="ibox-content">
                            <nav class="ui-nav clearfix"></nav>
                            <div class="app__content js-app-main page-cashier">
                                <div>
                                    <form action="?m=Agent&c=adManage&a=search" method="post">
                                        <!-- 实时交易信息展示区域 -->
                                        <div class="cashier-realtime">
                                            <div id="dataselect" class="form-group" style="padding: 0 10px;">

                                                <div id="datepicker" class="input-daterange">
                                                    <label class="font-noraml">商户名称</label>
                                                    <input class="input form-control" type="text" placeholder="输入商户名称"
                                                           style="width: 20%;border-radius:5px;height: 40px; margin-bottom: 0px;"
                                                           name='data'>
                                                    <input class="btn btn-primary" type="submit" value="查 询"
                                                           style="width:70px;">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="js-real-time-region realtime-list-box loading">
                                        <div class="widget-list">
                                            <div class="js-list-filter-region clearfix ui-box"
                                                 style="position: relative;">
                                                <div class="widget-list-filter"></div>
                                            </div>
                                            <div class="ui-box">
                                                <table class="ui-table ui-table-list" data-page-size="20"
                                                       style="padding: 0px; text-align: center;">
                                                    <thead class="js-list-header-region tableFloatingHeaderOriginal">
                                                    <tr class="widget-list-header">
                                                        <th>商户名</th>
                                                        <th>投放地区</th>
                                                        <th>投放行业</th>
                                                        <th>投放时间段</th>
                                                        <th>有效时间段</th>
                                                        <th>支付页面广告</th>
                                                        <th>支付成功跳转广告</th>
                                                        <th>操作</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="js-list-body-region" id="table-list-body">
                                                    <?php
                                                    if (!empty($result)) {
                                                        foreach ($result as $ovv) {
                                                            ?>
                                                            <tr class="widget-list-item">
                                                                <td><?php echo $ovv['company']; ?></td>
                                                                <td><?php if($ovv['ad_shenaddress']=="") echo '全国'; else echo $ovv['ad_shenaddress'].$ovv['ad_shiaddress'].$ovv['ad_quaddress']; ?></td>
                                                                <td><?php if($ovv['ad_hangye']=="") echo '所有行业'; else echo $ovv['ad_hangye']; ?></td>
                                                                <td><p><?php echo $ovv['ad_tfstarttime']; ?></p><p><?php echo $ovv['ad_tfendtime']; ?></p></td>
                                                                <td><p><?php echo $ovv['ad_sxstarttime']; ?></p><p><?php echo $ovv['ad_sxendtime']; ?></td>
                                                                <td><a href="<?php echo $ovv['link1']; ?>" target="_blank"><img src="<?php echo $ovv['img1']; ?>" width="100px" height="40px"></a></td>
                                                                <td><a href="<?php echo $ovv['link2']; ?>" target="_blank">点击查看</a></td>
                                                                <td>
                                                                    <a class="btn btn-sm btn-info"
                                                                       href="?m=Agent&c=adManage&a=updateAd&id=<?php echo $ovv['ad_id']; ?>"
                                                                       style="vertical-align: top; background: #337ab7;">更新</a>
                                                                    <button class="btn btn-sm btn-danger delete"
                                                                            data-id="<?php echo $ovv['ad_id'] ?>"><strong>删&nbsp;&nbsp;除 </strong>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php }
                                                    } else {
                                                        ?>
                                                        <tr class="widget-list-item">
                                                            <td colspan="9">暂无广告</td>
                                                        </tr>
                                                    <?php } ?>
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
                <?php echo $p; ?>
            </div>
        </div>
        <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/footer.tpl.php'; ?>
    </div>
</div>

</body>
<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource; ?>plugins/js/iCheck/icheck.min.js"></script>
<script>
    $("#pop_add_shop").click(function () {
        window.location.href="?m=Agent&c=adManage&a=addAd";
    })
    $(".delete").click(function () {
        var id=$(this).data("id");
        swal({
            title: "温馨提示",
            type: "warning",
            text:"你确定要删除吗？",
            confirmButtonText:'确定',
            cancelButtonText:'取消',
            showCancelButton:true
        },function (isConfirm) {
            if(isConfirm){
                $.ajax({
                    url:"?m=Agent&c=adManage&a=del",
                    type:"POST",
                    data:{
                        id:id
                    }
                });
                window.location.reload();
            }
            else {
            }
        });
    })
</script>
</html>