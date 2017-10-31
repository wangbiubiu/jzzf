function wxRefundBtn(dom,orderid,mid){
    var refundprice=Number($(dom).attr('data-val'));
    if(refundprice==undefined){refundprice=0;}
    var content='<div style="padding:20px;">' +'<p>友情提示：退款成功后不可逆向操作，请慎重操作！</p>' +
    '<p>退款操作不超过<span style="color:red;">'+refundprice+'</span>元</p>' +
    '<div style="height: 30px;line-height: 30px;"><div style="float:left;">请输入退款金额：</div><input class="refund_price" style="height: 100%;" value="'+refundprice+'" type="text"value=""></div>' +
    '</div>';
    /*****退款处理******/
    //自定页
    layer.open({
        type: 1,
        skin: 'layui-layer-demo', //样式类名
        closeBtn: 2, //不显示关闭按钮
        btn: ['确认', '取消'],
        anim: 2,
        shadeClose: true, //开启遮罩关闭
        content: content,
        yes: function(index, layero){
            var refund_price=$(".refund_price").val();
            if(isNaN(refund_price)){
                layer.alert("请输入正确的金额！");
            }else if(refund_price<=0){
                layer.alert("退款金额不能等于小于0！");
            }else if(refund_price>refundprice){
                layer.alert("退款金额不能大于"+refundprice+"元");
            }else if(refund_price.toString().split(".")[1]!=undefined && (refund_price.toString().split(".")[1].length)>2){
                layer.alert("小数点后面最多两位！");
            }else{
                layer.close(index);
                $.ajax({
                    url: "?m=User&c=cashier&a=wxRefund",
                    type: "POST",
                    dataType: "json",
                    data:{ordid:orderid,mid:mid,price:refund_price},
                    success: function(res){
                        if(!res.error){
                            layer.alert(res.msg, {
                                title:'退款成功',
                                icon: 1,
                                skin: 'layer-ext-moon', //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                                cancel: function(){
                                    window.location.reload();
                                },
                                yes: function(){
                                    window.location.reload();
                                }
                            })
                        }else{
                            layer.alert(res.msg, {
                                title:'退款失败',
                                icon: 2,
                                skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                            })
                        }
                    }
                });

            }
            return false;
        }
    });

}

function aliRefundBtn(dom,orderid,mid){
    var refundprice=Number($(dom).attr('data-val'));
    if(refundprice==undefined){refundprice=0;}
    var content='<div style="padding:20px;">' +'<p>友情提示：退款成功后不可逆向操作，请慎重操作！</p>' +
        '<p>退款操作不超过<span style="color:red;">'+refundprice+'</span>元</p>' +
        '<div style="height: 30px;line-height: 30px;"><div style="float:left;">请输入退款金额：</div><input class="refund_price" style="height: 100%;" value="'+refundprice+'" type="text"value=""></div>' +
        '</div>';
    //自定页
    layer.open({
        type: 1,
        skin: 'layui-layer-demo', //样式类名
        closeBtn: 2, //不显示关闭按钮
        btn: ['确认', '取消'],
        anim: 2,
        shadeClose: true, //开启遮罩关闭
        content: content,
        yes: function(index, layero){
            var refund_price=$(".refund_price").val();
            if(isNaN(refund_price)){
                layer.alert("请输入正确的金额！");
            }else if(refund_price<=0){
                layer.alert("退款金额不能等于小于0！");
            }else if(refund_price>refundprice){
                layer.alert("退款金额不能大于"+refundprice+"元");
            }else if(refund_price.toString().split(".")[1]!=undefined && (refund_price.toString().split(".")[1].length)>2){
                layer.alert("小数点后面最多两位！");
            }else{
                layer.close(index);
                $.ajax({
                    url: "?m=User&c=alicashier&a=aliRefund",
                    type: "POST",
                    dataType: "json",
                    data:{ordid:orderid,mid:mid,price:refund_price},
                    success: function(res){
                        if(!res.error){
                            layer.alert(res.msg, {
                                title:'退款成功',
                                icon: 1,
                                skin: 'layer-ext-moon', //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                                cancel: function(){
                                    window.location.reload();
                                },
                                yes: function(){
                                    window.location.reload();
                                }
                            })
                        }else{
                            layer.alert(res.msg, {
                                title:'退款失败',
                                icon: 2,
                                skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                            })
                        }
                    }
                });

            }
            return false;
        }
    });

}
/*****删除处理******/
function deltheOrder(dom,orderid,mid){
    if(confirm('您确定要删除此项？')){
        $.ajax({
            url: "?m=User&c=cashier&a=delOrderByid",
            type: "POST",
            dataType: "json",
            data:{ordid:orderid,mid:mid},
            success: function(res){
                if(res.status){
                    swal({
                        title: "删除成功",
                        text: res.msg,
                        type: "success"
                    }, function () {
                        $(dom).parent().parent('tr').remove();
                    });

                }else{
                    swal({
                        title: "删除失败",
                        text: res.msg,
                        type: "error"
                    }, function () {
                        //window.location.reload();
                    });
                }

                /*setTimeout(function(){
                 window.location.reload();
                 }, 1000);*/
            }
        });
    }
}

/*****订单状态查询处理******/
function wxOrderQuery(dom,orderid,mid){
    $(dom).attr('disabled', true);
    $.ajax({
        url: "?m=User&c=cashier&a=wxOrderQuery",
        type: "POST",
        dataType: "json",
        data:{ordid:orderid,mid:mid},
        success: function(res){
            $(dom).attr('disabled', false);
            if(!res.error){
                swal({
                    title: "温馨提示",
                    text: '订单已支付成功了',
                    type: "success"
                }, function () {
                    window.location.reload();
                });

            }else{
                swal({
                    title: "温馨提示",
                    text: res.msg,
                    type: "error"
                }, function () {
                    //window.location.reload();
                });
            }

        }
    });
}

/*****订单状态查询处理******/
function aliOrderQuery(dom,orderid,mid){
    $(dom).attr('disabled', true);
    $.ajax({
        url: "?m=User&c=alicashier&a=aliOrderQuery",
        type: "POST",
        dataType: "json",
        data:{ordid:orderid,mid:mid},
        success: function(res){
            $(dom).attr('disabled', false);
            if(!res.error){
                swal({
                    title: "温馨提示",
                    text: '订单已支付成功了',
                    type: "success"
                }, function () {
                    window.location.reload();
                });

            }else{
                swal({
                    title: "温馨提示",
                    text: res.msg,
                    type: "error"
                }, function () {
                    //window.location.reload();
                });
            }

        }
    });
}

function is_mobile(){
    var ua = navigator.userAgent.toLowerCase();
    if ((ua.match(/(iphone|ipod|android|ios|ipad|mobile)/i))){
        return true;
    }else{
        return false;
    }
}