<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>代理商|更新广告</title>
    <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/header.tpl.php'; ?>


    <!-- FooTable -->
    <link href="<?php echo RL_PIGCMS_STATIC_PATH; ?>plugins/css/footable/footable.core.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource; ?>plugins/css/iCheck/custom.css" rel="stylesheet">
    <link href="<?php echo RL_PIGCMS_STATIC_PATH; ?>plugins/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Cashier/pigcms_static/plugins/css/alert.css">
    <script src="<?php echo RL_PIGCMS_STATIC_PATH; ?>plugins/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo RL_PIGCMS_STATIC_PATH; ?>plugins/js/dropzone.js"></script>
    <script src='/Cashier/pigcms_static/plugins/js/alert.js'></script>

    <style>
        label i {
            color: #f00;
            margin-right: 10px;
            font-style: normal;
        }

        .ibox {
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

        .pagination {
            margin: 0px;
        }

        select {
            border: 1px solid #ccc;
            border-radius: 3px;
            height: 25px;
            width: 150px;
        }

        .mustInput {
            color: red;
            margin-right: 5px;
        }

        @media (min-width: 768px) {
            .form .part_item p {
                width: 37%;
            }
        }

        @media (min-width: 992px) {
            .form .part_item p {
                width: 24%;
            }
        }

        .form-control, .single-line {
            width: 50%;
        }

        .ibox {
            border: 1px solid #e7eaec;
            border-top: none;
        }

        .tit_h4 {
            height: 40px;
            line-height: 40px;
            padding: 0 20px;
            width: 100%;
            margin: 0px !important;
        }

        .tit_h4 span {
            color: #676a6c;
            font-weight: normal;
        }

        .tit_h4 a {
            color: #44b549;
            font-weight: normal;
        }

        .jbxi_bg > div {
            border-top: 1px solid #f2f2f2;
            padding: 20px 0;
            margin: 0px !important;
            float: left;
            width: 100%;
        }

        .jbxi_bg > div > label {
            width: 100px;
            text-align: right;
            float: left;
            margin-right: 30px;
        }

        .jbxi_bg > div > div > label {
            padding-top: 5px;
        }

        .jbxi_bg > div > div > input {
            border: none;
        }

        .form-control {
            width: 80%;
        }

        .footable-odd {
            background-color: #ffffff;
        }

        .bc {
            position: absolute;
            bottom: -55px;
            left: 50%;
            width: 70px;
            height: 30px;
            margin-left: -35px;
            background: #4EBE53;
            border-radius: 5px;
            border: none;
            color: #FFFFFF;
        }

        .shangjia_tit {
            border-bottom: 2px solid #f2f2f2;
            margin-bottom: 0px;
            padding-left: 20px;
            background: #FFFFFF;
            width: 100%;
            height: 50px;
            line-height: 50px;
            text-align: left;
            border-top: 3px solid #d9e6e9;
            font-size: 18px;
        }

        .form-control {
            display: inline-block;
        }
    </style>
</head>

<body>

<div id="wrapper">
    <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/leftmenu.tpl.php'; ?>

    <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/top.tpl.php'; ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>商户列表</h2>
                <ol class="breadcrumb">
                    <li>
                        <a>Agent</a>
                    </li>
                    <li>
                        <a>广告中心</a>
                    </li>
                    <li>
                        <a>广告列表</a>
                    </li>
                    <li class="active">
                        <strong>添加广告</strong>
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
                        <p class="shangjia_tit">添加广告</p>
                        <div class="ibox-content" style="border-top:none;">

                            <div class="panel-body" style="padding: 0px; ">
                                <form enctype="multipart/form-data" action="merchants.php?m=Agent&c=adManage&a=updateAd"
                                      method="post" class="form-horizontal form-border jbxi_bg clearfix"
                                      style="width: 95%; margin: 0 auto 60px; position: relative; border: 1px solid #EEEEEE;">
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>商户名</label>
                                        <div>
                                            <select name="shanghu" value='' id="mtype" style="margin-top: 5px;">
                                                <?php if ($result[0]['company'] != "") { ?>
                                                    <option value="<?php echo $result[0]['mid'] ?>"><?php echo $result[0]['company'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>投放地区</label>
                                        <div>
                                            <select id="provinceS" onchange="GetCity();"
                                                    style="float: left; height: 30px" name="province">
                                                <option value="0">全国</option>
                                                <?php foreach ($districts as $akk => $avv) { ?>

                                                    <option value="<?php echo $avv['id'] ?>"
                                                            data-fullname="<?php echo $avv['fullname'] ?>" <?php if ($result[0]['ad_shenaddress'] == $avv['fullname']) {
                                                        echo 'selected = "selected"';
                                                    } ?> ><?php echo $avv['fullname'] ?></option>

                                                <?php } ?>
                                            </select>
                                            <?php if ($result[0]['ad_shenaddress']) { ?>

                                                <select name="city" id="cityS"
                                                        style="width:126px;float: left;margin-left:10px;height: 30px"
                                                        onchange="GetDistrict();">
                                                    <option value="0">全省</option>
                                                    <?php foreach ($districts_city as $k => $v) { ?>
                                                        <option value="<?php echo $v['id'] ?>"
                                                                data-fullname="<?php echo $v['fullname'] ?>" <?php if ($result[0]['ad_shiaddress'] == $v['fullname']) {
                                                            echo 'selected = "selected"';
                                                        } ?> ><?php echo $v['fullname']; ?></option>
                                                    <?php } ?>
                                                </select>

                                            <?php } ?>
                                            <?php if ($result[0]['ad_shiaddress']) { ?>
                                                <select name="area" id="districtS"
                                                        style="width:126px;float: left; height: 30px;margin-left:10px"
                                                        onchange="GetCircle();">
                                                    <option value="0">全市</option>
                                                    <?php foreach ($districts_area as $key => $val) { ?>
                                                        <option value="<?php echo $val['id'] ?>"
                                                                data-fullname="<?php echo $val['fullname'] ?>" <?php if ($result[0]['quaddress'] == $val['fullname']) {
                                                            echo 'selected = "selected"';
                                                        } ?> ><?php echo $val['fullname']; ?></option>
                                                    <?php } ?>
                                                </select>

                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>投放行业</label>
                                        <div>
                                            <select style="height: 30px;width: 300px;" name="categoryId">
                                                <option value="">所有行业</option>
                                                <?php foreach ($category as $key => $c): ?>
                                                    <option value="<?php echo $c['name'] ?>" <?php if ($result[0]['ad_hangye']) echo 'selected' ?>><?php echo $c['name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>投放时间段</label>
                                        <div>
                                            <input name="startTime" size="16" type="time" id="startTime"
                                                   value="<?php echo $result[0]['ad_tfstarttime'] ?>"
                                                   class="form_time form-control" placeholder="请选择开始投放时间"
                                                   style="width: 200px;">
                                            <label>至</label>
                                            <input name="endTime" size="16" type="time" id="endTime"
                                                   value="<?php echo $result[0]['ad_tfendtime'] ?>"
                                                   class="form_time form-control" placeholder="请选择结束投放时间"
                                                   style="width: 200px;">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>有效时间段</label>
                                        <div>
                                            <input name="startTime1" size="16" id="startTime1"
                                                   value="<?php echo $result[0]['ad_sxstarttime'] ?>" type="text"
                                                   readonly class="form_datetime form-control" placeholder="请选择开始投放时间"
                                                   style="width: 200px;">
                                            <label>至</label>
                                            <input name="endTime1" size="16" id="endTime1"
                                                   value="<?php echo $result[0]['ad_sxendtime'] ?>" type="text" readonly
                                                   class="form_datetime form-control" placeholder="请选择结束投放时间"
                                                   style="width: 200px;">
                                        </div>

                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>支付页面广告图片</label>
                                        <div>
                                            <a id="dropzone">选择图片</a>
                                            <div id="img1" class="dz-preview dz-processing dz-image-preview dz-success dz-complete"
                                                 style="width:200px; float:left">
                                                <div class="dz-image"><img data-dz-thumbnail="" src="<?php echo $result[0]['img1'] ?>"></div>
                                            </div>
                                            <input name="file1" type="hidden" id="file1" value="<?php echo $result[0]['img1'] ?>">
                                            <input name="link1" type="text" value="<?php echo $result[0]['link1'] ?>"
                                                   placeholder="请输入支付页面广告图片链接"
                                                   style="border:1px solid #ccc; height: 30px; width: 300px;">

                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>支付成功页面广告图片</label>
                                        <div>
<!--                                            <a id="dropzone1">选择图片</a>-->
<!--                                            <div id="img2" class="dz-preview dz-processing dz-image-preview dz-success dz-complete"-->
<!--                                                 style="width:200px; float:left">-->
<!--                                                <div class="dz-image"><img data-dz-thumbnail="" src="--><?php //echo $result[0]['img2'] ?><!--"></div>-->
<!--                                            </div>-->
<!--                                            <input name="file2" type="hidden" id="file2" value="--><?php //echo $result[0]['img2'] ?><!--">-->
                                            <input name="link2" type="text" value="<?php echo $result[0]['link2'] ?>"
                                                   placeholder="请输入支付成功页面广告图片链接"
                                                   style="border:1px solid #ccc; height: 30px; width: 300px;">
                                        </div>
                                    </div>
                                    <div id="errmsg"></div>
                                    <input id="shenaddress" type="hidden" name="shenaddress"></input>
                                    <input id="shiaddress" type="hidden" name="shiaddress"></input>
                                    <input id="quaddress" type="hidden" name="quaddress"></input>
                                    <input id="adid" type="hidden" name="adid" value="<?php echo $result[0]['ad_id'] ?>">
                                    <button id="submit" class="bc">提交</button>
                                </form>


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

<!-- FooTable -->
<script src="<?php echo $this->RlStaticResource; ?>plugins/js/footable/footable.all.min.js"></script>

<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource; ?>plugins/js/iCheck/icheck.min.js"></script>

<!-- Jquery Validate -->
<script src="<?php echo $this->RlStaticResource; ?>plugins/js/validate/jquery.validate.min.js"></script>

<!-- Page-Level Scripts -->
<script>
    function GetCity() {
        var obj = $('#provinceS');
        var provincename1 = obj.find("option:selected").val();
        var provincename = obj.find("option:selected").data('fullname');
        if (provincename1 == '0') {
            $("#cityS").remove();
            $("#districtS").remove();
        }
        else {
            if (provincename == '北京市' || provincename == '天津市' || provincename == '重庆市' || provincename == '上海市') {
                var shengname = '全市';
            }
            else {
                var shengname = '全省';
            }
            var provinceid = obj.val();

            $('#provinceinfo').val(provincename);
            var cityHtml = '&nbsp;&nbsp;&nbsp;<select name="city" id="cityS" style="width:126px;float: left;margin-left:10px;height: 30px" onchange="GetDistrict();"><option value="0">' + shengname + '</option>'

            $.post('?m=Agent&c=merchant&a=GetDistrict', {districtid: provinceid}, function (ret) {

                if (ret.data) {
                    $.each(ret.data, function (nn, vv) {
                        cityHtml += '<option value="' + vv.id + '" data-fullname="' + vv.fullname + '" data-lng="' + vv.lng + '" data-lat="' + vv.lat + '">' + vv.fullname + '</option>';
                    });
                    cityHtml += '</select>';
                    $('#cityS').remove();
                    $('#districtS').remove();
                    $('#circleS').remove();
                    obj.after(cityHtml);
                }
            }, 'JSON');
        }

    }

    function GetDistrict() {
        var obj = $('#cityS');
        var cityid = obj.val();
        var cityname = obj.find("option:selected").data('fullname');
        $('#cityinfo').val(cityname);
        var cityname1 = obj.find("option:selected").val();
        if (cityname1 == 0) {
            $("#districtS").remove();
        }
        else {
            var cityHtml = '&nbsp;&nbsp;&nbsp;<select name="area" id="districtS" style="width:126px;float: left; height: 30px;margin-left:10px" onchange="GetCircle();"><option value="0">全市</option>'
            $.post('?m=Agent&c=merchant&a=GetDistrict', {districtid: cityid}, function (ret) {
                if (ret.data) {
                    $.each(ret.data, function (nn, vv) {
                        cityHtml += '<option value="' + vv.id + '" data-fullname="' + vv.fullname + '"  >' + vv.fullname + '</option>';
                    });
                    cityHtml += '</select>';
                    $('#districtS').remove();
                    $('#circleS').remove();
                    obj.after(cityHtml);
                }
            }, 'JSON');
        }

    }

    function GetCircle() {
        var obj = $('#districtS');
        var districtid = obj.val();
        var districtname = obj.find("option:selected").data('fullname');
        var lng = obj.find("option:selected").data('lng');
        var lat = obj.find("option:selected").data('lat');
        $('#districtinfo').val(districtname);

    }
</script>
<script type="text/javascript">
    $.fn.datetimepicker.dates['zh'] = {
        days: ['周日', '周一', '周二', '周三', '周四', '周五', '周六', '周日'],
        daysShort: ['日', '一', '二', '三', '四', '五', '六', '日'],
        daysMin: ['日', '一', '二', '三', '四', '五', '六', '日'],
        months: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
        monthsShort: ['一', '二', '三', '四', '五', '六', '七', '八', '九', '十', '十一', '十二'],
        meridiem: ['上午', '下午'],
        suffix: ['st', 'nd', 'rd', 'th'],
        today: '今天',
        clear: '清除'
    };
    $(".form_datetime").datetimepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        language: 'zh',
        minView:'month'
    });
</script>
<script>
    $("#dropzone").dropzone({
        url: "?m=Agent&c=adManage&a=uploadImg",
        autoProcessQueue: true,
        maxFiles: 1,
        addRemoveLinks: true,
        dictRemoveFile: "删除",
        acceptedFiles: ".jpg,.png,.gif",
        previewTemplate: "<div class=\"dz-preview dz-file-preview\" style=\"width:200px; float:left\">\n  <div class=\"dz-image\"><img data-dz-thumbnail /></div></div>",
        init: function () {
            this.on("success", function (file, responseText) {
                var rept = $.parseJSON(responseText);
                console.log(rept);
                var sss = $("#file1").val(rept.fileUrl);
                if($("#file1").val()!=""){
                    $("#img1").remove();
                }
            })
        }
    });
    $("#dropzone1").dropzone({
        url: "?m=Agent&c=adManage&a=uploadImg",
        autoProcessQueue: true,
        maxFiles: 1,
        addRemoveLinks: true,
        dictRemoveFile: "删除",
        acceptedFiles: ".jpg,.png,.gif",
        previewTemplate: "<div class=\"dz-preview dz-file-preview\" style=\"width:200px; float:left\">\n  <div class=\"dz-image\"><img data-dz-thumbnail /></div></div>",
        init: function () {
            this.on("success", function (file, responseText) {
                var rept = $.parseJSON(responseText);
                var sss = $("#file2").val(rept.fileUrl);
                if($("#file2").val()!=""){
                    $("#img2").remove();
                }
            })
        }
    })

    $("#submit").click(function () {
        var startTime = $("#startTime").val();
        var endTime = $("#endTime").val();
        var startTime1 = $("#startTime1").val();
        var endTime1 = $("#endTime1").val();
        var pic1 = $("#file1").val();
        var pic2 = $("#file2").val();
        if (startTime == "" || endTime == "") {
            swal({
                title: "温馨提示",
                type: "error",
                text: "请输入广告投放时间段",
                closeOnConfirm: false
            });
            return false;
        }
        if (startTime1 > endTime1) {
            swal({
                title: "温馨提示",
                type: "error",
                text: "广告开始生效时间不能大于结束时间",
                closeOnConfirm: false
            });
            return false;
        }
        if (startTime1 == "" || endTime1 == "") {
            swal({
                title: "温馨提示",
                type: "error",
                text: "请选择广告生效时间",
                closeOnConfirm: false
            });
            return false;
        }
        if (pic1 == "" && pic2 == "") {
            swal({
                title: "温馨提示",
                type: "error",
                text: "请上传广告图片",
                closeOnConfirm: false
            });
            return false;
        }
        var provincename = $("#provinceS").find("option:selected").data("fullname");
        if (provincename != undefined) {
            var province = provincename;
        }
        else {
            var province = "";
        }
        var cityname = $("#cityS").find("option:selected").data("fullname");
        if (cityname != undefined) {
            var city = cityname;
        }
        else {
            var city = "";
        }
        var districtname = $("#districtS").find("option:selected").data("fullname");
        if (districtname != undefined) {
            var district = districtname;
        }
        else {
            var district = "";
        }
        $("#shenaddress").val(province);
        $("#shiaddress").val(city);
        $("#quaddress").val(district);

    });



</script>
</body>
</html>