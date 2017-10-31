<?php
//总后台补单处理
bpBase::loadAppClass('common', 'System', 0);
class order_controller extends common_controller
{
	public function __construct()
	{
		parent::__construct();
	}
      
      //补单处理
      public function index(){
        if(IS_POST){  
            $order_id = $this->clear_html($_POST['order_id']);
            if($order_id){
                $order =  M('cashier_order')->get_one("order_id='".$order_id."'",'order_id,goods_price,ispay,add_time');
            if($order){
                $order['add_time'] = date('Y-m-d H:i:s',$order['add_time']);
                $this->assign('order',$order);
            }else{
                 $this->errorTip('订单号不存在!',$_SERVER['HTTP_REFERER']);
            }
            
            }else{
                $this->errorTip('请输入订单号!',$_SERVER['HTTP_REFERER']);
            }
        }
         
        $this->display();
      }
        
     public function ajaxispay(){
         $order_id = $this->clear_html($_POST['order_id']);
         $row = M('cashier_order')->get_one('order_id='.$order_id,'add_time');
         $re = M('cashier_order')->update(array('paytime'=>$row['add_time'],'ispay'=>1,'state'=>1),'order_id='.$order_id);
         if($re){
             $this->dexit(array('code'=>1,'msg'=>'补单成功'));
         }else{
             $this->dexit(array('code'=>0,'msg'=>'补单失败'));
         }
     }   
        
	
}


?>