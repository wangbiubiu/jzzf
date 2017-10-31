<?php

/**
 * Created by PhpStorm.
 * User: zp
 * Date: 17-3-19
 * Time: 下午10:36
 */

bpBase::loadAppClass('base', '', 0);

class timingCheckOrder_controller extends base_controller
{
    function index(){
        $where="ispay = 0 and pay_way = 'alipay' and add_time < ".(time()-60)." and add_time > ".(time() - 10*60);
        $order = M('cashier_order')->select($where,"order_id");
        $order = array_column($order, 'order_id');
//        var_dump($_GET);
//        var_dump(new pay_controller());
//        var_dump($_SERVER['SERVER_NAME']);
        foreach($order as $oId){
            file_get_contents('https://'.$_SERVER['SERVER_NAME'].'/merchants.php?m=Index&c=pay&a=alitraderesult&orderid='.$oId);
        }
    }

    function semih(){
        $where="ispay = 0 and pay_way = 'alipay' and add_time < ".(time()-60*10)." and add_time > ".(time() - 30*60);
        $order = M('cashier_order')->select($where,"order_id");
        $order = array_column($order, 'order_id');
        //file_put_contents('./ttt.txt','aaaaaaaaaaaaa');
        foreach($order as $oId){
            file_get_contents('https://'.$_SERVER['SERVER_NAME'].'/merchants.php?m=Index&c=pay&a=alitraderesult&orderid='.$oId);
        }
    }
}
