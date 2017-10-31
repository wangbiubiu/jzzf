<!DOCTYPE html>
<html>
    <head>
        <title>编辑门店</title>
        <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/header.tpl.php'; ?>
        <link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>merchant/store_mangecss.css" rel="stylesheet">
        <link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>merchant/baseshop.css" rel="stylesheet">
        <link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>merchant/widget_add_img.css" rel="stylesheet">

        <link href="<?php echo $this->RlStaticResource; ?>plugins/css/dropzone/basic.css" rel="stylesheet">
        <link href="<?php echo $this->RlStaticResource; ?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
        <link href="<?php echo $this->RlStaticResource; ?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
        <style type="text/css">
            #dataselect .input-group-btn,#ym-select .input-group-btn{width: 12%;}
            #dataselect .input-sm ,#ym-select .input-sm{ border-radius: 7px; height:40px;}
            #dataselect .btn-primary ,#ym-select .btn-primary{ margin-left: 20px; border-radius:4px;margin-bottom: 0px;}
            #dataselect .input-group-addon,#ym-select .input-group-addon{border-radius: 7px;}
            .ibox-content{ min-height:800px;}
            #js_pic_url .dz-image-preview{display:none;}
            .img_upload_preview_box p{margin:0px;}
            .js_category_container select{width:200px;float: left;}
            #provinceS,#cityS,#districtS,#circleS{display:inline-block;width: auto;}
            #js_latitude,#js_longitude{width:250px;display: inline;}
            #js_store_build u{display:none;}
            #bside_left {
                width: 260px;
                height: 500px;
                padding: 10px 10px 10px 10px;
                float: left;
                overflow: auto;
            }
            #mapfrm_controls::after{
                content:" . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . "
            }
            #mapcontainer{width: 900px;}
            .search_c {
                float: right;
                
                width: 350px;
            }
            .search_c .form-control{width:70%;display:inline-block;}
            #no_value{
                color:red;
                position: relative;
                width:200px;
            }
            .info_list {
                cursor: pointer;
                margin-bottom: 5px;
            }
        </style>
        <!-- Data picker -->
        <script src="<?php echo $this->RlStaticResource; ?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
        <link href="<?php echo $this->RlStaticResource; ?>plugins/css/iCheck/custom.css" rel="stylesheet">
        <script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=S6PBZ-D7BRQ-BNB5S-G2LBZ-PYAIO-DJF4K&libraries=drawing,geometry,autocomplete,convertor"></script>
    </head>
    <body>
        <div id="wrapper">
            <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/leftmenu.tpl.php'; ?>
            <div id="page-wrapper" class="gray-bg">
                <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/top.tpl.php'; ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>普通门店</h2>
                        <ol class="breadcrumb">
                            <li>
                                <a>User</a>
                            </li>
                            <li>
                                <a>wxCoupon</a>
                            </li>
                            <li class="active">
                                <strong>修改普通门店</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeIn">

                    <div class="row" id="wrapper-content-list">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
<!--                                <div class="ibox-title">	-->
<!--                                    <div class="alert alert-warning" style="font-size: 16px;">-->
<!--                                        温馨提示：部分信息一但提交将不可修改，请如实填写-->
<!---->
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="ibox-content">
                                    <div class="group main_bd">
                                        <form novalidate="novalidate" class="store_build" id="js_store_build"> 
                                            <div class="frm_section"> 
                                                <h3 class="frm_title">基本信息<span class="frm_title_dec">基本信息提交后不可修改</span></h3> 
                                                <input name="sid" id="shopid" type="hidden" value="0"/> 
                                                <div class="frm_control_group">
                                                    <div class="frm_control_row"> 
                                                        <div class="frm_controls menu_controls" style="margin-right:10px;"> 
                                                         <label for="" class="frm_label">地址</label>
                                                            <select id="provinceS" class="form-control" onchange="GetCity();" style="margin-left: 5px">
                                                                <option value="0">请选择</option>
                                                                <?php foreach ($districts as $akk => $avv) { ?>
                                                                    <option value="<?php echo $avv['id'] ?>" data-fullname="<?php echo $avv['fullname'] ?>" data-lng="<?php echo $avv['lng'] ?>" data-lat="<?php echo $avv['lat'] ?>"><?php echo $avv['fullname'] ?></option>
                                                                <?php } ?>
                                                            </select>


                                                            <div class="search_c"><input autocomplete="off" class="form-control" onkeypress="if (event.keyCode == 13) {
                                                                        btnSearch.click();
                                                                        return false;
                                                                    }" type="text" placeholder="输入地址搜索定位"> &nbsp;&nbsp;&nbsp;<span id="btn_search" class="btn btn-primary">搜 索</span></div>

                                                            <input name="provinceinfo" id="provinceinfo" type="hidden" value=""/>
                                                            <input name="cityinfo" id="cityinfo" type="hidden"  value=""/> 
                                                            <input name="districtinfo" id="districtinfo" type="hidden"  value=""/> 
                                                            <input name="circleinfo" id="circleinfo" type="hidden"  value=""/>
                                                            <input name="pos_id" id="pos_id" type="hidden"  value=""/>
                                                        </div>



                                                        <div class="frm_controls input_controls" style="margin:15px 0 0 5px"> 
                                                            <div  class="frm_control_group"> 
                                                               <label for="" class="frm_label">详细地址</label>
                                                                <span class="frm_input_box"> <input placeholder="输入详细地址，请勿重复填写省市区信息" name="address" id="searchSubmit" value="<?php echo $store['address'];?>" class="frm_input" type="text" />
                                                                </span> 
                         
                                                           
                                                                经纬度：<input name="latitude" value="<?php echo $store['latitude'];?>" id="js_latitude" type="text" class="form-control" placeholder="纬度，点击地图获取"/>&nbsp;
                                                                <input name="longitude" value="<?php echo $store['longitude'];?>" id="js_longitude" type="text" class="form-control" placeholder="经度，点击地图获取"/>
                                                               <!--<a class="btn btn_default l dn" id="js_remark" href="javascript:;">修改</a>-->
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </div> 
                                                <div class="frm_control_group" id="js_mark_position" > 
                                                    <label for="" class="frm_label">定位</label> 
                                                    <div class="frm_controls" id="mapfrm_controls"> 

                                                        <div class="map_panel"> 

                                                            <div id="bside_left"><div> <p>在搜索框搜索关键词后，地图上会显示相应poi点，同时左侧显示对应该点的信息，点击某点或某信息，右上角会显示相应该点的坐标和地址。</p></div></div>

                                                            <div class="map crosspoint map_result" id="mapcontainer" style="width:740px;"> 
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </div> 
                                                   
                                                <div class="frm_control_group" style="margin-top: 30px;"> 
                                                    <label for="" class="frm_label">门店名称</label>
                                                    <div class="frm_controls"> 
                                                        <span class="frm_input_box"> <input class="frm_input ckinput" id="js_business_name" value="<?php echo $store['business_name'];?>" name="business_name" type="text" /><u>15</u></span>
                                                        <p class="frm_msg fail" style="display: none;"><span for="js_business_name" class="frm_msg_content" style="display: inline;">门店名不能为空且长度不超过15个汉字或30个英文字母</span></p>
                                                        <p class="frm_tips">门店名不得含有区域地址信息（如，北京市XXX公司），不超过15个汉字</p> 
                                                    </div> 
                                                </div>
<!--                                                <div class="frm_control_group"> -->
<!--                                                    <label for="" class="frm_label">分店名-->
<!--                                                     <br >-->
<!--                                                         <span style="font-weight:bold;color:red;">(选填)</span>-->
<!--                                                    </label> -->
<!--                                                    <div class="frm_controls"> -->
<!--                                                        <span class="frm_input_box"> <input id="js_branch_name" class="frm_input ckinput" name="branch_name" type="text" /> <u>10</u></span> -->
<!--                                                        <p class="frm_msg fail" style="display: none;"><span for="js_business_name" class="frm_msg_content" style="display: inline;">门店名不能为空且长度不超过10个汉字或20个英文字母</span></p>-->
<!--                                                        <p class="frm_tips">分店名不得含有区域地址信息（如，“北京国贸店”中的“北京”），不超过10个字</p> -->
<!--                                                    </div> -->
<!--                                                </div> -->
                                                <div class="frm_control_group"> 
                                                    <label for="" class="frm_label">类目
                                                     <br >
                                                    <span style="font-weight:bold;color:red;">(选填)</span>
                                                    </label> 
                                                    <div class="frm_controls"> 
                                                        <div id="js_category_dom"> 
                                                            <div class="js_category_container">
                                                                <select name="categoryid0" id="categoryid0" class="form-control" onchange="subCategory();">
                                                                    <?php foreach ($categorys as $ckk => $cvv) { ?>
                                                                        <option  value="<?php echo $cvv['id'] ?>" data-cname="<?php echo $cvv['name'] ?>"><?php echo $cvv['name'] ?></option>
                                                                    <?php } ?>
                                                                </select>

                                                            </div>
                                                            <input name="categoryid0info" id="categoryid0info" type="hidden" value="1-美食"/>
                                                            <input name="categoryid1info" id="categoryid1info" type="hidden" value="2-江浙菜"/>
                                                        </div> 
                                                    </div> 
                                                </div> 
                                            </div> 
                                            <div class="frm_control_group"> 
                                                    <label for="" class="frm_label">电话
                                                       
                                                    </label> 
                                                    <div class="frm_controls"> 
                                                        <span class="frm_input_box"> <input class="frm_input" value="<?php echo $store['telephone'];?>" name="telephone"  id="js_telephone" type="text" onkeyup="value = value.replace(/[^1234567890\-]+/g, '')" maxlength="25"/> </span>
                                                        <p class="frm_tips">固定电话需加区号；区号、分机号均用“-”连接</p> 
                                                    </div> 
                                            </div>
                                            <div class="frm_control_group"> 
                                                    <label for="" class="frm_label">营业时间
                                                     <br >
                                                         <span style="font-weight:bold;color:red;">(选填)</span></label> 
                                                    <div class="frm_controls"> 
                                                        <span class="frm_input_box"> <input class="frm_input" id="js_open_time" value="<?php echo $store['starttime']?$store['starttime']:'';?>" name="open_time" type="text" onkeyup="value = value.replace(/[^1234567890\:\-]+/g, '')" maxlength="12"/> </span>
                                                    </div> 
                                                    <p class="frm_tips">如果不填写则默认为08:00-08:00</p> 
                                            </div> 
                                            <div><input type="checkbox" id="check" value="1">更多信息</div>
                                            <div class="frm_section service_info fw" style="display:none;" > 
                                                <h3 class="frm_title">服务信息</h3> 
                                                <div class="frm_control_group"> 
                                                    <label for="" class="frm_label">门店图片</label> 
                                                    <div class="frm_controls"> 
                                                        <p class="frm_tips">像素要求必须为640*340像素，支持.jpg .jpeg .bmp .png格式，大小不超过5M</p> 
                                                        <div id="js_upload_wrp">
                                                            <div class="img_upload_wrp group"> 
                                                                <div class="img_upload_box"> 
                                                                    <a class="img_upload_box_oper js_upload" id="js_pic_url" href="javascript:"> <i class="icon20_common add_gray"> 上传 </i> </a> 
                                                                </div>
                                                                <div class="js_pager"></div> 
                                                            </div>
                                                        </div> 
                                                    </div> 
                                                </div> 
                                                
                                                <div class="frm_control_group"> 
                                                    <label for="" class="frm_label">人均价格</label> 
                                                    <div class="frm_controls with_hint"> 
                                                        <span class="frm_input_box"> <input id="js_avg_price" class="frm_input" name="avg_price" value="<?php echo $store['avg_price'];?>"  type="text" onkeyup="value = value.replace(/[^1234567890]+/g, '')" maxlength="7"/> </span>
                                                        <span class="frm_hint">元</span> 
                                                        <p class="frm_tips">大于零的整数，须如实填写，默认单位为人民币</p> 
                                                    </div> 
                                                </div> 
                                                
                                                <div class="frm_control_group"> 
                                                    <label for="" class="frm_label">推荐<br /><span class="frm_label_dec">(选填)</span></label> 
                                                    <div class="frm_controls"> 
                                                        <div class="frm_textarea_box"> 
                                                            <textarea class="frm_textarea ckinput" name="recommend" id="js_recommend" placeholder=""><?php echo $store['recommend'];?></textarea><u>100</u>
                                                        </div> 
                                                        <p class="frm_msg fail" style="display: none;"><span for="js_business_name" class="frm_msg_content" style="display: inline;">推荐长度不超过100个汉字或200个英文字母</span></p>
                                                        <p class="frm_tips">如，推荐菜，推荐景点，推荐房间，不超过100个字</p> 
                                                    </div> 
                                                </div> 
                                                <div class="frm_control_group"> 
                                                    <label for="" class="frm_label">特色服务</label> 
                                                    <div class="frm_controls"> 
                                                        <div class="frm_textarea_box"> 
                                                            <textarea class="frm_textarea ckinput" name="special" id="js_special"><?php echo $store['special'];?></textarea><u>100</u>
                                                        </div> 
                                                        <p class="frm_msg fail" style="display: none;"><span for="js_business_name" class="frm_msg_content" style="display: inline;">特色服务不能为空且长度不超过100个汉字或200个英文字母</span></p>
                                                        <p class="frm_tips">如，免费停车，WiFi，不超过100个字</p> 
                                                    </div> 
                                                </div> 
                                                <div class="frm_control_group"> 
                                                    <label for="" class="frm_label">简介<br /><span class="frm_label_dec">(选填)</span></label> 
                                                    <div class="frm_controls"> 
                                                        <div class="frm_textarea_box"> 
                                                            <textarea class="frm_textarea ckinput" name="desc" id="js_desc"><?php echo $store['special'];?></textarea><u>100</u>
                                                        </div>
                                                        <p class="frm_msg fail" style="display: none;"><span for="js_business_name" class="frm_msg_content" style="display: inline;">简介长度不超过100个汉字或200个英文字母</span></p>
                                                        <p class="frm_tips">对品牌或门店的简要介绍，不超过100个字</p> 
                                                    </div> 
                                                </div> 
                                                <!--<div class="frm_control_group"> 
                                                 <label for="" class="frm_label">门店签名<br /><span class="frm_label_dec">(选填)</span></label> 
                                                 <div class="frm_controls"> 
                                                  <span class="frm_input_box"> <input class="frm_input" id="js_signature" name="signature" type="text" /> </span> 
                                                  <p class="frm_tips">在“附近的人”展示，不超过6个字，如上方截图示例中的“满99送咖啡”字样。</p> 
                                                 </div> 
                                                </div>---> 
                                            </div> 
                                                
                                        </form> 

                                    </div> 
                                    <div class="tool_bar border tc">
                                        <button id="sub_add_shop" class="btn btn-primary" style="height: 36px;"> 提交 </button>
                                         <!--<span  class="btn btn_input btn_default" id="js_preview"><button>预览</button></span>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/footer.tpl.php'; ?>
            </div>
        </div>
        <!-- DROPZONE -->
        <script src="<?php echo $this->RlStaticResource; ?>plugins/js/dropzone/dropzone.js"></script>

        <script src="<?php echo $this->RlStaticResource; ?>plugins/js/iCheck/icheck.min.js"></script>
        <script type="text/javascript">
            
               //判断是否选择更多信息
    $('#check').click(function(){
        if($('#check').is(':checked')){
            $('.fw').css('display','block');
        }else{
             $('.fw').css('display','none');
        }
            
    });
    
            
var wxCouponType = '<?php echo $typeid; ?>';
/***计算字符串长度(英文占1个字符，中文汉字占2个字符)*****/
String.prototype.gbLen = function () {
    var len = 0;
    for (var i = 0; i < this.length; i++) {
        if (this.charCodeAt(i) > 127 || this.charCodeAt(i) == 94) {
            len += 2;
        } else {
            len++;
        }
    }
    return len;
}
wxCouponType = parseInt(wxCouponType);
$(document).ready(function () {
    /*$('#ymdatepicker input').datepicker({
     keyboardNavigation: false,
     forceParse: false,
     format: "yyyy-mm-dd",
     autoclose: true
     });*/
    $("#js_pic_url,#js_pic_url .icon20_common").dropzone({
        url: "?m=User&c=wxCoupon&a=uploadImg&cf=1",
        addRemoveLinks: false,
        maxFilesize: 1,
        acceptedFiles: ".jpg,.png",
        uploadMultiple: false,
        init: function () {
            this.on("success", function (file, responseText) {
                var rept = $.parseJSON(responseText);

                /***这里的this.element 是 $("#js_pic_url")****/
                if (!rept.error) {
                    var imgHtml = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="' + rept.localimg + '"><input name="photo_list[]" class="imginput" type="hidden" value="' + rept.wxlogurl + '"><input name="photo_img[]" type="hidden" value="' + rept.localimg + '"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
                    $('#js_upload_wrp .img_upload_wrp .js_pager').before(imgHtml);
                    $(this.element).find('div').remove();
                } else {
                    swal({
                        title: "上传失败",
                        text: rept.msg,
                        type: "error"
                    }, function () {
                        //window.location.reload();
                    });
                }
            });
        }
    });
 
    


    $(document).on('mouseover mouseout', '.img_upload_preview_box', function (event) {
        if (event.type == "mouseover") {
            $(this).find('p').show();
        } else if (event.type == "mouseout") {
            $(this).find('p').hide();
        }
    });

    $('#sub_add_shop').click(function () {
        var thisObj = $(this);
        if (checkInPut()) {
            thisObj.prop('disabled', true);
            $.ajax({
                url: '?m=User&c=merchant&a=addordinaryShop',
                type: "post",
                data: $('form').serialize(),
                dataType: "JSON",
                success: function (ret) {
                    if (!ret.error) {
                        swal({
                            title: "保存成功！",
                            text: ret.msg,
                            type: "success"
                        }, function () {
                            window.location.href = "?m=User&c=merchant&a=storefront";
                        });
                    } else {
                        swal({
                            title: "保存失败！",
                            text: ret.msg,
                            type: "error"
                        }, function () {
                            //window.location.reload();
                        });
                    }
                    thisObj.prop('disabled', false);
                }
            });
        }
        return false;
        //document.js_editform.submit();
    });

    $('#js_store_build .ckinput').each(function () {
        $(this).keyup(function () {
            var inputstr = $(this).val();
            var strleng = inputstr.gbLen();
            var limitnum = $(this).siblings('u').text();
            limitnum = parseInt(limitnum);
            var tmplen = 0;
            var tipsObj = $(this).parent().siblings('.frm_msg');
            if (limitnum > 0) {
                limitnum = limitnum * 2;
                if (strleng > limitnum) {
                    tipsObj.show();
                } else {
                    tipsObj.hide();
                }
            }
        });

    });

});

function checkInPut() {
    var daddress = $('#searchSubmit').val();
    daddress = $.trim(daddress);
    if (!daddress || (daddress.gbLen() > 100)) {
        swal({
            title: "温馨提示！",
            text: '详细地址不能为空且不要超过50汉字',
            type: "error"
        });
        $('#searchSubmit').focus();
        return false;
    }

    var late = $.trim($('#js_latitude').val());
    var lnge = $.trim($('#js_longitude').val());
    
    /* if (!late || !lnge) {
        swal({
            title: "温馨提示！",
            text: '请点击地图选择经纬度值！',
            type: "error"
        });
        return false;
    } */

    var businessname = $.trim($('#js_business_name').val());
    if (!businessname || (businessname.gbLen() > 15)) {
        swal({
            title: "温馨提示！",
            text: '门店名必须填写且不得超过15个汉字',
            type: "error"
        });
        return false;
    }

    var shopowner_name = $.trim($('#shopowner_name').val());
    if (!shopowner_name || (shopowner_name.gbLen() > 15)) {
        swal({
            title: "温馨提示！",
            text: '店长姓名必须填写，且不能超过15个字',
            type: "error"
        });
        return false;
    }
    var shopowner_username = $.trim($('#shopowner_username').val());
    if (!shopowner_username) {
        swal({
            title: "温馨提示！",
            text: '店长登录帐号必须填写，建议使用邮箱',
            type: "error"
        });
        return false;
    }

    var shopowner_password = $.trim($('#shopowner_password').val());
    if (!shopowner_password) {
        swal({
            title: "温馨提示！",
            text: '店长登录密码必须填写',
            type: "error"
        });
        return false;
    }

/*    var branchname = $.trim($('#js_branch_name').val());
    if (!branchname || (branchname.gbLen() > 15)) {
        swal({
            title: "温馨提示！",
            text: '分店名必须填写且不得超过10个汉字',
            type: "error"
        });
        return false;
    }
    var telephone = $.trim($('#js_telephone').val());
    if (!telephone) {
        swal({
            title: "温馨提示！",
            text: '电话号码没填写！',
            type: "error"
        });
        return false;
    }
    var opentime = $.trim($('#js_open_time').val());
    if (!opentime) {
        swal({
            title: "温馨提示！",
            text: '营业时间没填写！',
            type: "error"
        });
        return false;
    }
    if($('#check').is(':checked')){
        if (!($('#js_upload_wrp .imginput').size() > 0)) {
            swal({
                title: "温馨提示！",
                text: '请至少上传一张和店面相关的照片！',
                type: "error"
            });
            return false;
        }

        var avgprice = $.trim($('#js_avg_price').val());
        if (!avgprice) {
            swal({
                title: "温馨提示！",
                text: '人均价格没填写！',
                type: "error"
            });
            return false;
        }

        var jsspecial = $.trim($('#js_special').val());
        if (!jsspecial || (jsspecial.gbLen() > 200)) {
            swal({
                title: "温馨提示！",
                text: '特色服务没填写！',
                type: "error"
            });
            return false;
        }
    }
        */
    return true;
}

function DelthisImg(obj) {
    if (confirm('您确定删除图片！')) {
        obj.parent('p').parent('.img_upload_preview_box').remove();
    }
}

//直接加载地图
//初始化地图函数  自定义函数名init
var map = null, label = null;
function init(lat, lng, tozoom) {
    //定义map变量 调用 qq.maps.Map() 构造函数   获取地图显示容器
    map = new qq.maps.Map(document.getElementById("mapcontainer"), {
        center: new qq.maps.LatLng(lat, lng), // 地图的中心地理坐标。
        zoom: tozoom                               // 地图的中心地理坐标。
    });
    //给map绑定mousemove事件
    label = new qq.maps.Label({
        map: map,
        offset: new qq.maps.Size(15, -10),
        draggable: false,
        clickable: false
    });
    map.setOptions({
        draggableCursor: "crosshair"
    });
    //添加监听事件    监听鼠标移动 添加 当前鼠标的经纬度信息
    qq.maps.event.addListener(map, "mousemove", function (e) {
        var latlng = e.latLng;
        //label.setContent(e.latLng.toString());
        label.setPosition(e.latLng);
        label.setContent(latlng.getLat().toFixed(10) + "," + latlng.getLng().toFixed(10));
    });
    //添加监听事件  当鼠标移到图层上面显示图层
    qq.maps.event.addListener(map, "mouseover", function (e) {
        label.setMap(map);
    });
    //添加监听事件  当鼠标离开的时候 设置图层为空
    qq.maps.event.addListener(map, "mouseout", function (e) {
        label.setMap(null);
    });
    var url3;
    qq.maps.event.addListener(map, "click", function (e) {
        document.getElementById("js_latitude").value = e.latLng.getLat().toFixed(10);
        document.getElementById("js_longitude").value = e.latLng.getLng().toFixed(10);
        url3 = encodeURI("https://apis.map.qq.com/ws/geocoder/v1/?location=" + e.latLng.getLat() + "," + e.latLng.getLng() + "&key=S6PBZ-D7BRQ-BNB5S-G2LBZ-PYAIO-DJF4K&output=jsonp&&callback=?");
        $.getJSON(url3, function (result) {
            console.log(result);
            if (result.result != undefined) {
                //document.getElementById("searchSubmit").value = result.result.address;
                var addressComponent = result.result.address_component;
                document.getElementById("searchSubmit").value = addressComponent.street + addressComponent.street_number;
                $('#pos_id').val(result.result.ad_info.adcode);
            } else {
                document.getElementById("searchSubmit").value = "";
            }

        })
    });
}

//调用初始化函数地图
init(39.904690, 116.407170, 12); /***北京市*****/

var listener_arr = [];
var isNoValue = false;
var btnSearch = document.getElementById("btn_search");
var bside = document.getElementById("bside_left");
var query_city = '', havecity = 0;
var markerArray = [];
function each(obj, fn) {
    for (var n = 0, l = obj.length; n < l; n++) {
        fn.call(obj[n], n, obj[n]);
    }
}
qq.maps.event.addDomListener(btnSearch, 'click', function () {
    var value = this.parentNode.getElementsByTagName("input")[0].value;
    
    var latlngBounds = new qq.maps.LatLngBounds();
    for (var i = 0, l = listener_arr.length; i < l; i++) {
        qq.maps.event.removeListener(listener_arr[i]);
    }
    listener_arr.length = 0;
    havecity = $('#cityS').size();
    if (havecity > 0) {
        havecity = $.trim($('#cityS').val());
        havecity = parseInt(havecity);
        if (havecity > 0) {
            query_city = $('#cityS').find("option:selected").data('fullname');
        } else {
            alert('请选择一个城市');
            return false;
        }
    } else {
        alert('请选择省份和城市！');
        return false;
    }
    prov = $('#provinceS').find("option:selected").data('fullname');
    var add = prov+query_city;
    
    url = encodeURI("https://apis.map.qq.com/ws/place/v1/search?keyword=" + value + "&boundary=region(" + add + ",0)&page_size=9&page_index=1&key=S6PBZ-D7BRQ-BNB5S-G2LBZ-PYAIO-DJF4K&output=jsonp&&callback=?");
        $.getJSON(url, function (result) {

        if (result.count) {
            isNoValue = false;
            bside.innerHTML = "";
            each(markerArray, function (n, ele) {
                ele.setMap(null);
            });
            markerArray.length = 0;
            each(result.data, function (n, ele) {
                var latlng = new qq.maps.LatLng(ele.location.lat, ele.location.lng);
                latlngBounds.extend(latlng);
                var left = n * 27;
                var marker = new qq.maps.Marker({
                    map: map,
                    position: latlng,
                    adcode: ele.ad_info.adcode,
                    district: ele.ad_info.district,
                    province: ele.ad_info.province,
                    city: ele.ad_info.city,
                    title: ele.title,
                    address: ele.address,
                    zIndex: 10
                });
                marker.index = n;
                marker.isClicked = false;
                setAnchor(marker, true);
                markerArray.push(marker);
                var listener1 = qq.maps.event.addDomListener(marker, "mouseover", function () {
                    var n = this.index;
                    setCurrent(markerArray, n, false);
                    setCurrent(markerArray, n, true);
                    label.setContent(this.position.getLat().toFixed(10) + "," + this.position.getLng().toFixed(10));
                    label.setPosition(this.position);
                    label.setOptions({
                        offset: new qq.maps.Size(15, -20)
                    })

                });
                listener_arr.push(listener1);
                var listener2 = qq.maps.event.addDomListener(marker, "mouseout", function () {
                    var n = this.index;
                    setCurrent(markerArray, n, false);
                    setCurrent(markerArray, n, true);
                    label.setOptions({
                        offset: new qq.maps.Size(15, -12)
                    })
                });
                listener_arr.push(listener2);
                var listener3 = qq.maps.event.addDomListener(marker, "click", function () {
                    var n = this.index;
                    setFlagClicked(markerArray, n);
                    setCurrent(markerArray, n, false);
                    setCurrent(markerArray, n, true);
                });
                listener_arr.push(listener3);
                map.fitBounds(latlngBounds);
                var div = document.createElement("div");
                div.className = "info_list";
                var order = document.createElement("div");
                var leftn = -54 - 17 * n;
                order.style.cssText = "width:17px;height:17px;margin:3px 3px 0px 0px;float:left;background:url(<?php echo $this->pigcms_static; ?>marker_n.png) " + leftn + "px 0px";
                div.appendChild(order);
                var pannel = document.createElement("div");
                pannel.style.cssText = "width:200px;float:left;";
                div.appendChild(pannel);
                var name = document.createElement("p");
                name.style.cssText = "margin:0px;color:#0000CC";
                name.innerHTML = ele.title;
                pannel.appendChild(name);
                var address = document.createElement("p");
                address.style.cssText = "margin:0px;";
                address.innerHTML = "地址：" + ele.address;
                pannel.appendChild(address);
                if (ele.tel != undefined) {
                    var phone = document.createElement("p");
                    phone.style.cssText = "margin:0px;";
                    phone.innerHTML = "电话：" + ele.tel;
                    pannel.appendChild(phone);
                }
                var position = document.createElement("p");
                position.style.cssText = "margin:0px;";
                position.innerHTML = "坐标：" + ele.location.lat.toFixed(6) + "，" + ele.location.lng.toFixed(6);
                pannel.appendChild(position);
                bside.appendChild(div);
                div.style.height = pannel.offsetHeight + "px";
                div.isClicked = false;
                div.index = n;
                marker.div = div;
                div.marker = marker;
            });
            $("#bside_left").delegate(".info_list", "mouseover", function (e) {

                var n = this.index;

                setCurrent(markerArray, n, false);
                setCurrent(markerArray, n, true);
            });
            $("#bside_left").delegate(".info_list", "mouseout", function () {
                each(markerArray, function (n, ele) {
                    if (!ele.isClicked) {
                        setAnchor(ele, true);
                        ele.div.style.background = "#fff";
                    }
                })
            });
            $("#bside_left").delegate(".info_list", "click", function (e) {
                var n = this.index;
                setFlagClicked(markerArray, n);
                setCurrent(markerArray, n, false);
                setCurrent(markerArray, n, true);
                map.setCenter(markerArray[n].position);
            });
        } else {

            bside.innerHTML = "";
            each(markerArray, function (n, ele) {
                ele.setMap(null);
            });
            markerArray.length = 0;
            var novalue = document.createElement('div');
            novalue.id = "no_value";
            novalue.innerHTML = "对不起，没有搜索到你要找的结果!";
            bside.appendChild(novalue);
            isNoValue = true;
        }
    });
});

function setAnchor(marker, flag) {
    var left = marker.index * 27;
    if (flag == true) {
        var anchor = new qq.maps.Point(10, 30),
                origin = new qq.maps.Point(left, 0),
                size = new qq.maps.Size(27, 33),
                icon = new qq.maps.MarkerImage("<?php echo $this->pigcms_static; ?>marker10.png", size, origin, anchor);
        marker.setIcon(icon);
    } else {
        var anchor = new qq.maps.Point(10, 30),
                origin = new qq.maps.Point(left, 35),
                size = new qq.maps.Size(27, 33),
                icon = new qq.maps.MarkerImage("<?php echo $this->pigcms_static; ?>marker10.png", size, origin, anchor);
        marker.setIcon(icon);
    }
}
function setCurrent(arr, index, isMarker) {
    if (isMarker) {
        each(markerArray, function (n, ele) {
            if (n == index) {
                setAnchor(ele, false);
                ele.setZIndex(10);
            } else {
                if (!ele.isClicked) {
                    setAnchor(ele, true);
                    ele.setZIndex(9);
                }
            }
        });
    } else {
        each(markerArray, function (n, ele) {
            if (n == index) {
                ele.div.style.background = "#DBE4F2";
            } else {
                if (!ele.div.isClicked) {
                    ele.div.style.background = "#fff";
                }
            }
        });
    }
}
function setFlagClicked(arr, index) {
    each(markerArray, function (n, ele) {
        if (n == index) {
            ele.isClicked = true;
            ele.div.isClicked = true;
            var str = '<div style="width:250px;">' + ele.div.children[1].innerHTML.toString() + '</div>';
            var latLng = ele.getPosition();
            document.getElementById("js_latitude").value = latLng.getLat().toFixed(10);
            document.getElementById("js_longitude").value = latLng.getLng().toFixed(10);
            $('#pos_id').val(ele.adcode);
            var d_address = ele.address + ele.title;
            d_address = d_address.replace(ele.province, '').replace(ele.city, '').replace(ele.district, '');
            $('#searchSubmit').val(d_address);
            var optfullname = '', optdistrict = $.trim(ele.district), optv = 0;
            $('#districtS option').each(function (mm) {
                optfullname = $(this).data('fullname');
                optfullname = $.trim(optfullname);
                if (optfullname == optdistrict) {
                    $(this).attr("selected", true);
                    optv = $(this).attr('value');
                    $('#districtS').val(optv);
                    $('#districtinfo').val(optv + '-' + optfullname);
                }
            });
        } else {
            ele.isClicked = false;
            ele.div.isClicked = false;
        }
    });
}
/*var url4;
 $(".search_t").autocomplete({
 source:function(request,response){
 url4 = encodeURI("https://apis.map.qq.com/ws/place/v1/suggestion/?keyword=" + request.term + "&region=" + curCity.children[0].innerHTML + "&key=K76BZ-W3O2Q-RFL5S-GXOPR-3ARIT-6KFE5&output=jsonp&&callback=?");
 $.getJSON(url4,function(result){

 response($.map(result.data,function(item){
 return({
 label:item.title

 })
 }));
 });
 }
 });*/

function GetCity() {
    var obj = $('#provinceS');
    var provinceid = obj.val();
    var provincename = obj.find("option:selected").data('fullname');
    var lng = obj.find("option:selected").data('lng');
    var lat = obj.find("option:selected").data('lat');
    $('#provinceinfo').val(provinceid + '-' + provincename);
    init(lat, lng, 13);
    var cityHtml = '&nbsp;&nbsp;&nbsp;<select name="city" id="cityS" class="form-control" onchange="GetDistrict();"><option value="0">请选择</option>'
    $.post('?m=User&c=merchant&a=GetDistrict', {districtid: provinceid}, function (ret) {
        if (ret.data) {
            $.each(ret.data, function (nn, vv) {
                cityHtml += '<option value="' + vv.id + '" data-fullname="' + vv.fullname + '" data-lng="' + vv.lng + '" data-lat="' + vv.lat + '" >' + vv.fullname + '</option>';
            });
            cityHtml += '</select>';
            $('#cityS').remove();
            $('#districtS').remove();
            $('#circleS').remove();
            obj.after(cityHtml);
        }
    }, 'JSON');
}

function GetDistrict() {
    var obj = $('#cityS');
    var cityid = obj.val();
    var cityname = obj.find("option:selected").data('fullname');
    var lng = obj.find("option:selected").data('lng');
    var lat = obj.find("option:selected").data('lat');
    $('#cityinfo').val(cityid + '-' + cityname);
    init(lat, lng, 15);
    var cityHtml = '&nbsp;&nbsp;&nbsp;<select name="district" id="districtS" class="form-control" onchange="GetCircle();"><option value="0">请选择</option>'
    $.post('?m=User&c=merchant&a=GetDistrict', {districtid: cityid}, function (ret) {
        if (ret.data) {
            $.each(ret.data, function (nn, vv) {
                cityHtml += '<option value="' + vv.id + '" data-fullname="' + vv.fullname + '" data-lng="' + vv.lng + '" data-lat="' + vv.lat + '" >' + vv.fullname + '</option>';
            });
            cityHtml += '</select>';
            $('#districtS').remove();
            $('#circleS').remove();
            obj.after(cityHtml);
        }

    }, 'JSON');
}
function GetCircle() {
    var obj = $('#districtS');
    var districtid = obj.val();
    var districtname = obj.find("option:selected").data('fullname');
    var lng = obj.find("option:selected").data('lng');
    var lat = obj.find("option:selected").data('lat');
    $('#districtinfo').val(districtid + '-' + districtname);
    init(lat, lng, 17);

}

function subCategory() {
    var Cobj = $('#categoryid0');
    var cid = Cobj.val();
    var cname = Cobj.find("option:selected").data('cname');
    $('#categoryid0info').val(cid + '-' + cname);
    var Chtml = '<select name="categoryid1" id="categoryid1" class="form-control" onchange="GetSubCy();" style=" margin-left: 20px;">';
    $.post('?m=User&c=merchant&a=GetCategory', {cid: cid}, function (ret) {
        if (ret.data) {
            $.each(ret.data, function (nn, vv) {
                if (nn == 0) {
                    $('#categoryid1info').val(vv.id + '-' + vv.name);
                }
                Chtml += '<option value="' + vv.id + '" data-scname="' + vv.name + '" >' + vv.name + '</option>';
            });
            Chtml += '</select>';
            $('#categoryid1').remove();
            Cobj.after(Chtml);
        }

    }, 'JSON');

}
subCategory();

function GetSubCy() {
    var Cobj = $('#categoryid1');
    var scid = Cobj.val();
    var scname = Cobj.find("option:selected").data('scname');
    $('#categoryid1info').val(scid + '-' + scname);
}

        </script>
    </body>

</html>