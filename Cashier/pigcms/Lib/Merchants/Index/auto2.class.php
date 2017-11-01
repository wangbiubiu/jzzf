<?php
bpBase::loadAppClass('base', '', 0);

class auto2_controller extends base_controller
{
    // 用户浏览器
    public function __construct()
    {
        $this->model = M('cashier_order');
        $this->shopmodel = M("cashier_merchants");
        $this->bankmodel = M("cashier_bank");
    }

    public function index()
    {
        //查询出商家未对账的所有订单
        $time = strtotime(date('Y-m-d 23:00:00',strtotime("-2 day")));
        $time2 = strtotime(date("Y-m-d 22:59:59",strtotime("-1 day")));
        echo "截止至".date("Y-m-d 22:59:59",strtotime("-1 day"))."<br/>";
        
        // 查出昨天未对账的成功订单
        $order_sql = "SELECT o.pay_way,sum(o.income),m.company,o.mid,m.commission,m.alicommission,m.qqcommission,m.mtype
          FROM `cqcjcm_cashier_order` as o
          LEFT JOIN `cqcjcm_cashier_merchants` as m ON o.mid=m.mid
          LEFT JOIN `cqcjcm_cashier_bank` as b ON b.mid=m.mid
          WHERE m.mtype!=1 AND o.state = 1 AND m.sub_merchant = 1 AND o.paytime <= '$time2' AND o.refund <> 2 AND b.bank = 1
          GROUP BY o.mid
          ORDER BY o.paytime DESC";

          // 执行sql语句
        $order = M('cashier_order')->selectBySql($order_sql);
        $num = 0;
        foreach($order as $key => $s) {
            $mid = $s['mid'];
            $mtype=$s['mtype'];

            // 昨天未对账的总金额
            $money = round($s['sum(o.income)'], 2);

            // 判断总金额>=1元
            if ($money >= 1) {

                // 费率
                switch($s['pay_way'])
                {
                    case 'weixin':
                        $commission = $s['commission'];break;
                    case 'ali':
                        $commission = $s['alicommission'];break;
                    case 'qq':
                        $commission = $s['qqcommission'];break;
                }
                

                // 手续费
                $cha = round($money * $commission, 2);

                // 判断收续费，如果收续费为0，则默认收取0.01元的手续费
                if ($cha == 0) {
                    $cha = 0.01;
                }

                // 提现金额
                $money2 = $money - $cha;

                // 通过mid查询商户的银行信息
                $bank = M('cashier_bank')->get_one('mid=' . $mid, "*");
                $data = array();
                $data['commission'] = $commission;//费率
                $data['amount'] = $money2;//需结算的金额
                $data['phoneNo'] = $bank['phoneNo'];
                $data['customerName'] = $bank['customerName'];
                $data['cerdType'] = $bank['cerdType'];
                $data['cerdId'] = $bank['cerdId'];
                $data['settBankNo'] = $bank['settBankNo2'];
                $data['accBankNo'] = $bank['accBankNo'];
                $data['accBankName'] = $bank['accBankName'];
                $data['bankType'] = $bank['bankType'];
                $data['addrName'] = $bank['addrName'];
                $data['busiType'] = $bank['busiType'];
                $data['acctNo'] = $bank['acctNo'];
                $data['isCompay'] = $bank['isCompay'];
                $mset = array();
                $mset['mid'] = $mid;
                $mset['addtime'] = time();
                $mset['username'] = $s['company'];
                $mset['money'] = $money2;//提现金额（已扣除手续费）
                $mset['money2'] = $money;//收款金额
                $mset['status'] = 0;
                // $mset['money'] = $money2;//提现金额（已扣除手续费）
                // $mset['money2'] = $money;//收款金额
                $mset['txt'] = json_encode($data, JSON_UNESCAPED_UNICODE);
                $result = 1;
                if($mtype==2)
                {
                    $result = M('cashier_msettlement')->insert($mset);
                }else if($mtype==3)
                {
                    $data=M('cashier_another_astrict')->get_one(array('mid'=>$mid));
                    if($data)
                    {
                        $result=M('cashier_another_astrict')->update(array('balance'=>$money2+$data['balance'],'balance_start'=>$money+$data['balance_start'],'balance_end'=>$money2+$data['balance_end']),array('mid'=>$mid));
                    }else 
                    {
                        $result=M('cashier_another_astrict')->insert(array('balance'=>$money2,'balance_start'=>$money,'balance_end'=>$money2,'mid'=>$mid));
                    }
                    
                }
                
                if (!empty($result)) {
                    $where2 = array(
                        'ispay' => 1,
                        'state' => 1,
                        'mid' => $mid,
                        'refund' => array('neq', 2),
                    );
                    $re = M('cashier_order')->update(array('state' => 2), "ispay = '1' AND state = '1' AND mid = '$mid' AND refund <> 2 AND paytime <= '$time2'");
                }
                $num++;
            }
        }
        echo "已处理".$num."条记录！";
    }
}