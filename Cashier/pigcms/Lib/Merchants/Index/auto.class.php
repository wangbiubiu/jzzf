<?php
bpBase::loadAppClass('base', '', 0);

class auto_controller extends base_controller
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
        session_start();
        $data = $_SESSION['jiesuanOrder'];
        $count = $_SESSION['jiesuanOrderCount'] ?  : 0; // 总计条数
        $sum = $_SESSION['jiesuanOrderSum'] ?  : 0; // 总计金额
        $j = $_SESSION['jiesuanOrderBool'] ?  : false;
        if (empty($data)) {
            // 查询出商家未对账的所有订单
            // 查询出商家未对账的所有订单
            $time = strtotime(date('Y-m-d 23:00:00', strtotime("-2 day")));
            $time2 = strtotime(date("Y-m-d 22:59:59", strtotime("-1 day")));
//             $order_sql = "SELECT sum(o.income),m.company,o.mid,m.commission
//           FROM `cqcjcm_cashier_order` as o
//           LEFT JOIN `cqcjcm_cashier_merchants` as m ON o.mid=m.mid
//           LEFT JOIN `cqcjcm_cashier_bank` as b ON b.mid=m.mid
//           WHERE m.mtype!=1 AND o.state = 1 AND m.sub_merchant = 1 AND o.paytime <= '$time2' AND o.refund <> 2 AND b.bank = 1
//           GROUP BY o.mid
//           ORDER BY o.paytime DESC";
            
            $order_sql = "SELECT o.pay_way,sum(o.income),m.company,o.mid,m.commission,m.alicommission,m.qqcommission
            FROM `cqcjcm_cashier_order` as o
            LEFT JOIN `cqcjcm_cashier_merchants` as m ON o.mid=m.mid
            LEFT JOIN `cqcjcm_cashier_bank` as b ON b.mid=m.mid
            WHERE m.mtype!=1 AND o.state = 1 AND m.sub_merchant = 1 AND o.paytime <= '$time2' AND o.refund <> 2 AND b.bank = 1
            GROUP BY o.mid
            ORDER BY o.paytime DESC";
            
            $order = M('cashier_order')->selectBySql($order_sql);
            foreach ($order as $key => $s) {
                $mid = $s['mid'];
                $money = round($s['sum(o.income)'], 2);
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
                    
                    $commission = $s['commission'];
                    $cha = round($money * $commission, 2);
                    if ($cha == 0) {
                        $cha = 0.01;
                    }
                    $money2 = $money - $cha;
                    $bank = M('cashier_bank')->get_one('mid=' . $mid, "*");
                    $data = array();
                    $data['commission'] = $commission; // 费率
                    $data['amount'] = $money2; // 需结算的金额
                    $data['phoneNo'] = $bank['phoneNo'];
                    $data['customerName'] = $bank['customerName'];
                    $data['cerdType'] = $bank['cerdType'];
                    $data['cerdId'] = $bank['cerdId'];
                    $data['settBankNo'] = $bank['settBankNo'];
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
                    $mset['money'] = $money2; // 提现金额（已扣除手续费）
                    $mset['money2'] = $money; // 收款金额
                    $mset['status'] = 0;
                    $result = M('cashier_msettlement')->get_one(array(
                        "mid" => $mid,
                        "status" => 0
                    ), "*");
                    if ($result) {
                        $mset['money'] = $money2 + $result['money']; // 提现金额（已扣除手续费）
                        $mset['money2'] = $money + $result['money2']; // 收款金额
                        $data['amount'] += $result['money'];
                        $mset['txt'] = json_encode($data, JSON_UNESCAPED_UNICODE);
                        $result = M('cashier_msettlement')->update($mset, array(
                            "mid" => $mid,
                            "status" => 0
                        ));
                    } else {
                        $mset['money'] = $money2; // 提现金额（已扣除手续费）
                        $mset['money2'] = $money; // 收款金额
                        $mset['txt'] = json_encode($data, JSON_UNESCAPED_UNICODE);
                        $result = M('cashier_msettlement')->insert($mset);
                        if (! empty($result)) {
                            $where2 = array(
                                'ispay' => 1,
                                'state' => 1,
                                'mid' => $mid,
                                'refund' => array(
                                    'neq',
                                    2
                                )
                            );
                            $re = M('cashier_order')->update(array(
                                'state' => 2
                            ), "ispay = '1' AND state = '1' AND mid = '$mid' AND refund <> 2 AND paytime <= '$time2'");
                        }
                    }
                }
            }
            $order = M('cashier_msettlement')->select(array(
                "status" => 0
            ), '*');
            $data = array();
            foreach ($order as $o) {
                $d = json_decode($o['txt'], true);
                $d['mid'] = $o['mid'];
                $data[] = $d;
            }
            $_SESSION['jiesuanOrderCount'] = count($data);
            if (empty($data) || $j) {
                $_SESSION['jiesuanOrder'] = array();
                $_SESSION['jiesuanOrderBool'] = false;
                echo "此次总共为" . $count . "个商家执行了代付！
                <br/>
                <a href='/merchants.php?m=Index&c=auto&a=bclear' style='margin-top:20px;display:block;color:#fff;background-color:#06f;border:none;text-decoration: none;font-size: 14px;border-radius: 3px;width: 100px;height: 30px;line-height: 30px;text-align: center;'>
                再执行一次
                </a>
                <!--<a href='/merchants.php?m=Index&c=auto&a=bclear'>清除记录</a>-->
                <br/>
                <span style='color:#888;font-size:12px;'>" . date("Y-m-d H:i:s", time()) . "</span>
                    <script type='text/javascript'>
                    setTimeout(to,60000);
                       function to(){
                         window.location.href='/merchants.php?m=Index&c=auto&a=bclear';
                       }
                    </script>
                ";
            } else {
                $_SESSION['jiesuanOrder'] = $data;
                $_SESSION['jiesuanOrderBool'] = true;
                echo '<script>window.location.href="/merchants.php?m=Index&c=auto&a=index"</script>';
            }
        } else {
            echo "已取消自动结算......<br/>";
            echo "<span style='color:#888;font-size:12px;'>" . date("Y-m-d H:i:s", time()) . "</span>
                    <script type='text/javascript'>
                    setTimeout(to,10000);
                       function to(){
                         window.location.href='/merchants.php?m=Index&c=auto&a=bclear';
                       }
                    </script>
                ";
            exit();
            $H = date("H", time());
            $week = date("w", time());
            if ($H < 11 || $H > 13 || $week == 0 || $week == 6) {
                echo "非结算时间" . date("Y-m-d H:i:s", time()) . "<script type='text/javascript'>
                        setTimeout(to,10000);
                       function to(){
                         window.location.href='/merchants.php?m=Index&c=auto&a=index'
                       }
                    </script>";
                die();
            }
            // require_once("/www/html/pay.yunjifu.net/MinShengBank.class.php");//Linux下
            require_once ("./MinShengBank.class.php"); // 本地
            $bank = new MinShengBank();
            $d = $data[0];
            $mid = $d['mid']; // 商家编号
            $amount = $d['amount']; // 代付金额
            $array = [
                'productId' => "0201", // 0201-普通代付；0203-额度代付；0205-信用代付；0211-广东省内代付；（较少使用）；0213-全国代付；（较少使用）
                'orderNo' => date('YmdHis') . SYS_TIME . mt_rand(11111111, 99999999), // 订单编号
                'notifyUrl' => "http://" . $_SERVER['SERVER_NAME'], // 异步地址
                'transAmt' => $amount * 100, // 订单金额
                'isCompay' => $d['isCompay'], // 对公对私标识
                'phoneNo' => $d['phoneNo'] ?  : "", // 手机号码，不必填
                'customerName' => $d['customerName'], // 账户名
                'cerdType' => $d['cerdType'] ?  : "", // 证件类型，不必填
                'cerdId' => $d['cerdId'] ?  : "", // 证件号，不必填
                'settBankNo' => $d['settBankNo'] ?  : "", // 清算行号 产品0211、0213时必须填写
                'accBankNo' => $d['accBankNo'] ?  : "", // 开户行号 产品 0213全国代付时必须填写
                'accBankName' => $d['accBankName'] ?  : "", // 开户行名称 产品0211、0213，如accBankNo、settBankNo无法填写时，则必须填写该字段
                'bankType' => $d['bankType'] ?  : "", // 银行类别 产品0211、0213，如accBankNo、settBankNo无法填写时，则必须填写该字段
                'addrName' => $d['addrName'] ?  : "", // 地区名称 产品0211、0213，如accBankNo、settBankNo无法填写时，则必须填写该字段
                'busiType' => $d['busiType'] ?  : "", // 业务类型 产品0211、0213时填写
                'acctNo' => $d['acctNo'], // 银行卡号
                'note' => $d['note'] ?  : ""
            ] // 备注，不必填
;
            $str = ($bank->daifu($array));
            // $str['respCode'] = "0000" ;
            // $str['respDesc'] = "交易成功";
            if ($str['respCode'] == "0000" && $str['respDesc'] == "交易成功") {
                $result = M('cashier_msettlement')->update(array(
                    "status" => 1,
                    "addtime" => time()
                ), array(
                    "mid" => $mid,
                    "status" => 0,
                    'money' => $amount
                )); // 修改提现状态
                unset($data[0]);
                sort($data);
                $_SESSION["jiesuanOrder"] = $data;
            } else {
                unset($data[0]);
                sort($data);
                $_SESSION["jiesuanOrder"] = $data;
                $_SESSION['jiesuanOrderCount'] --;
                if (empty($str['respDesc'])) {
                    $str['respDesc'] = "系统忙碌！";
                }
                echo "代付失败：" . $str['respDesc'];
            }
            echo '<script>window.location.href="/merchants.php?m=Index&c=auto&a=index"</script>';
        }
    }

    public function bclear()
    {
        session_start();
        unset($_SESSION['jiesuanOrder']);
        unset($_SESSION['jiesuanOrderCount']); // 总计条数
        unset($_SESSION['jiesuanOrderSum']); // 总计金额
        unset($_SESSION['jiesuanOrderBool']);
        echo '<script>window.location.href="/merchants.php?m=Index&c=auto&a=index"</script>';
    }

    public function query()
    {
        session_start();
        if ($_GET['clear'] == "1") {
            unset($_SESSION['isQuery']);
        }
        $isQuery = $_SESSION['isQuery'];
        $isQueryOrder = $_SESSION['isQueryOrder'];
        $isQueryOrderCount = $_SESSION['isQueryOrderCount'];
        if (empty($isQuery)) { // 未处理
            $start = strtotime(date("Y-m-01 00:00:00"));
            $end = strtotime(date("Y-m-30 23:59:59"));
            $where = "state = 0 AND add_time >= '$start' AND add_time <= '$end' AND query = '0'";
            $order = M("cashier_order")->select($where, "id,mid,pay_way,goods_price,income,order_id,transaction_id");
            $_SESSION['isQuery'] = 1;
            $_SESSION['isQueryOrder'] = $order;
            $_SESSION['isQueryOrderCount'] = count($order);
            echo '<script type="text/javascript">window.location.href=\'/merchants.php?m=Index&c=auto&a=query\';</script>';
        } else {
            // 订单查询状态，query 0未查询，1已核实，2核实失败
            $sum = $_SESSION['isQueryOrderCount'];
            $num = $sum - count($_SESSION['isQueryOrder']) + 1;
            echo "共计" . $sum . "条数据，正在执行第" . $num . "条数据！";
            $data = $_SESSION['isQueryOrder'];
            $data2 = $data[0];
            if ($data2["pay_way"] == "weixin") { // 向微信查件
                                               // https://api.mch.weixin.qq.com/pay/orderquery
                bpBase::loadOrg('WxPay/WxPay.Api');
                bpBase::loadOrg('WxPay/WxPay.Log');
                $input = new WxPayRefund();
                if (! empty($data2['transaction_id'])) {
                    $input->SetTransaction_id($data2['transaction_id']);
                } else {
                    $input->SetOut_trade_no($data2['order_id']);
                }
                $response = WxPayApi::orderQuery($input);
                // $response = WxPayApi::returnValue($input);
                dump($response);
                echo "wx";
            } else { // 向支付宝查件
                  // https://docs.open.alipay.com/api_1/alipay.trade.query
                echo "zfb";
            }
            dump($data[0]);
        }
    }
}