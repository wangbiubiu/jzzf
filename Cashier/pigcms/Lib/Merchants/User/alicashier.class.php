<?php

bpBase::loadAppClass('common', 'User', 0);
class alicashier_controller extends common_controller
{
	public $alipayConf;
	public $payConfTips = '';
	public $payConfMsg = '';
	public $pf_mid = 0;

	public function __construct()
	{
		parent::__construct();
		bpBase::loadOrg('checkFunc');
		$checkFunc = new checkFunc();

		if (!function_exists('dsbig3joishdgfhg798rqw4fqnkhffq')) {
			exit('error-4');
		}


		$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		$this->authorityControl(array('getajaxOrder', 'getAliEwm', 'add_order', 'qrcode', 'alipay', 'sm_order', 'getAliEwmByid'));
		//$this->alipayConf = M('cashier_payconfig')->getalipayConf($this->mid);
		
	    $payconfig_admin = M('cashier_payconfig')->get_one(array('mid'=>1),'*');
	    $payconfig_data = unserialize(htmlspecialchars_decode($payconfig_admin['configData'], ENT_QUOTES));
	    $this->alipayConf = $payconfig_data['alipay'];
		if (empty($this->alipayConf)) {
			$this->payConfMsg = $this->payConfTips = '您还没有配置支付宝支付信息，将不能使用下面的功能！';
		}
		 else if (empty($this->alipayConf['appid'])) {
			$this->payConfMsg = $this->payConfTips = '您还没有配置支付宝appid，将不能使用下面的功能！';
		}
		 else if (empty($this->alipayConf['pid'])) {
			$this->payConfTips = '您还没有配置支付宝PID';
		}


		if (isset($this->alipayConf['pf_mid']) && (0 < $this->alipayConf['pf_mid'])) {
			$this->pf_mid = $this->alipayConf['pf_mid'];
		}

	}

	public function index()
	{
		$SiteUrl = $this->SiteUrl;
		$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $this->tablepre . 'cashier_order as ordr LEFT JOIN ' . $this->tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid where ordr.mid=' . $this->mid . ' AND cf.mid=' . $this->mid . ' AND ordr.pay_way="alipay"';

		if (0 < $this->storeid) {
			$sqlStr = $sqlStr . ' AND ordr.storeid=' . $this->storeid;
		}


		$sqlStr = $sqlStr . ' AND ordr.ispay="1" ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT 0,20';
		$sqlObj = new model();
		$neworder = $sqlObj->selectBySql($sqlStr);
		$neworder = $this->ProcssOdata($neworder, $this->mid);
		include $this->showTpl();
	}

	public function getajaxOrder()
	{
		$cf = trim($_GET['cf']);

		switch ($cf) {
		case 'index':
			$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $this->tablepre . 'cashier_order as ordr LEFT JOIN ' . $this->tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid where ordr.mid=' . $this->mid . '  AND cf.mid=' . $this->mid . ' AND ordr.pay_way="alipay"';

			if (0 < $this->storeid) {
				$sqlStr = $sqlStr . ' AND ordr.storeid=' . $this->storeid;
			}


			$sqlStr = $sqlStr . ' AND ordr.ispay="1" ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT 0,20';
			$sqlObj = new model();
			$neworder = $sqlObj->selectBySql($sqlStr);
			$neworder = $this->ProcssOdata($neworder, $this->mid);

			if (!empty($neworder)) {
				$tmpdata = array();

				foreach ($neworder as $okk => $ovv ) {
					$tmpdata[$okk]['id'] = $ovv['id'];
					$tmpdata[$okk]['mid'] = $ovv['mid'];

					if (!empty($ovv['nickname'])) {
						$tmpdata[$okk]['truename'] = $ovv['nickname'];
					}
					 else if (!empty($ovv['truename'])) {
						$tmpdata[$okk]['truename'] = htmlspecialchars_decode($ovv['truename'], ENT_QUOTES);
					}
					 else if (!empty($ovv['openid'])) {
						$tmpdata[$okk]['truename'] = $ovv['openid'];
					}
					 else {
						$tmpdata[$okk]['truename'] = '未知客户';
					}

					$paytime = ((0 < $ovv['paytime'] ? $ovv['paytime'] : $ovv['add_time']));
					$tmpdata[$okk]['paytimestr'] = date('Y-m-d H:i:s', $paytime);
					$tmpdata[$okk]['goods_name'] = htmlspecialchars_decode($ovv['goods_name'], ENT_QUOTES);
					$tmpdata[$okk]['goods_price'] = $ovv['goods_price'];

					if ($ovv['refund'] == 1) {
						$tmpdata[$okk]['refundstr'] = '退款中...';
					}
					 else if ($ovv['refund'] == 2) {
						$tmpdata[$okk]['refundstr'] = '已退款';
					}
					 else if ($ovv['refund'] == 3) {
						$tmpdata[$okk]['refundstr'] = '退款失败';
					}
					 else {
						$tmpdata[$okk]['refundstr'] = '已支付';
					}

					$tmpdata[$okk]['refund'] = $ovv['refund'];
					$tmpdata[$okk]['comefrom'] = $ovv['comefrom'];
					$tmpdata[$okk]['storename'] = $ovv['storename'];
					$tmpdata[$okk]['optername'] = $ovv['optername'];
				}

				$this->dexit(array('error' => 0, 'datas' => $tmpdata));
			}
			 else {
				$this->dexit(array('error' => 1));
			}

			break;

			break;
		}
	}

	public function payRecord()
	{
		bpBase::loadOrg('common_page');
		$orderDb = M('cashier_order');
		$where = array('ispay' => 1, 'mid' => $this->mid);

		if (0 < $this->storeid) {
			$where['storeid'] = $this->storeid;
		}


		$_count = $orderDb->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $this->tablepre . 'cashier_order as ordr LEFT JOIN ' . $this->tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid where ordr.mid=' . $this->mid . '  AND cf.mid=' . $this->mid . ' AND ordr.pay_way="alipay"';

		if (0 < $this->storeid) {
			$sqlStr = $sqlStr . ' AND ordr.storeid=' . $this->storeid;
		}


		$sqlStr = $sqlStr . ' AND ordr.ispay="1" ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
		$sqlObj = new model();
		$neworder = $sqlObj->selectBySql($sqlStr);
		$neworder = $this->ProcssOdata($neworder, $this->mid);
		include $this->showTpl();
	}

	public function ewmRecord()
	{
		bpBase::loadOrg('common_page');
		$orderDb = M('cashier_order');
		$where = array('mid' => $this->mid, 'pay_way' => 'alipay');

		if (0 < $this->storeid) {
			$where['storeid'] = $this->storeid;
		}


		$_count = $orderDb->count($where);
		$p = new Page($_count, 15);
		$pagebar = $p->show(2);
		$neworder = $orderDb->getOrders($p->firstRow . ',' . $p->listRows, 'id DESC', $where);
		$neworder = $this->ProcssOdata($neworder, $this->mid);
		include $this->showTpl();
	}
	
	/**
	 * 支付宝退款
	 */

	public function aliRefund()
	{
		$ordid = intval($_POST['ordid']);
		$mid = intval($_POST['mid']);
		$price = $_POST['price'];
		bpBase::loadAppClass('AliPayClass', 'User', 0);
		$AliPayClass = new AliPayClass($this->alipayConf);
		$orderDb = M('cashier_order');
		$orderArr = $orderDb->get_one(array('id' => $ordid, 'mid' => $this->mid), '*');
		$configAdmin=M('cashier_payconfig')->get_one(array('mid'=>$this->mid),'*');
		$configData=unserialize(htmlspecialchars_decode($configAdmin['configData'], ENT_QUOTES));
        $configAlipay = $configData['alipay'];
		if (empty($orderArr)) {
            $orderArr = $orderDb->get_one(array('order_id' => $ordid, 'mid' => $this->mid), '*');
            if(empty($orderArr)){
                $this->dexit(array('error' => 1, 'msg' => '订单不存在！'));
            }
		}


		if (($orderArr['state'] == 2) && (0 < $orderArr['mchtype'])) {
			$this->dexit(array('error' => 1, 'msg' => '已对过账的订单不可以退款哦！'));
		}

        if(empty($price)){
            $price=$ordertmp['goods_price'];
        }
		$ret = $AliPayClass->aliRefund($orderArr['transaction_id'], $price, $orderArr['order_id'],$configAlipay['appauthtoken']);

		if (0 < $ret['error']) {
			$this->dexit($ret);
		}
		 else {
            $income=$orderArr['goods_price']-$price;
            $RefundUpdata = array('refund' => 2,'income'=>$income, 'refundtext' => serialize($ret['data']));
			$orderDb->update($RefundUpdata, array('id' => $orderArr['id']));
			$fansDb = M('cashier_fans');
			$Refundprice = array('refund' => $orderArr['goods_price'] * 100);
			$fansDb->update($Refundprice, array('mid' => $this->mid, 'openid' => $ret['data']['open_id'], 'buyeraccount' => $ret['data']['buyer_logon_id']));
			$this->dexit(array('error' => 0, 'msg' => '退款成功！'));
		}
	}

	public function getAliEwmByid()
	{
		$datas = $this->clear_html($_POST);
		$ooid = $datas['ooid'];
		$orderDb = M('cashier_order');
		$orderinfo = $orderDb->get_one(array('id' => $ooid, 'mid' => $this->mid, 'ispay' => '0'), '*');

		if ($orderinfo) {
			$md5str = md5('ali@pay2w#8m' . $orderinfo['mid'] . $orderinfo['id']);
			$codeStr = $orderinfo['mid'] . '-' . $orderinfo['id'] . '-' . $md5str;
			$codeStr = Encryptioncode($codeStr, 'ENCODE');
			$codeStr = str_replace('+', '_', $codeStr);
			$codeStr = str_replace('/', '-', $codeStr);

			if (defined('ABS_UPLOAD_PATH')) {
				$bsSiteUrl = ABS_UPLOAD_PATH . '/pay/alipay/smnotify.php?myparam=' . $codeStr;
			}
			 else {
				$bsSiteUrl = '/pay/alipay/smnotify.php?myparam=' . $codeStr;
			}

			$notify_url = $this->SiteUrl . $bsSiteUrl;
			bpBase::loadAppClass('AliPayClass', 'User', 0);
			$AliPayClass = new AliPayClass($this->alipayConf);
			$neworder_id = '11' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(SYS_TIME, 2);
			$datas = array('order_id' => $neworder_id, 'price' => $orderinfo['goods_price'], 'tname' => $orderinfo['goods_name']);
			$orderDb->update(array('order_id' => $neworder_id), array('id' => $orderinfo['id']));
			$ret = $AliPayClass->f2fqrpay($datas, $notify_url);
			$this->dexit($ret);
		}
		 else {
			$this->dexit(array('error' => 1, 'msg' => '二维码生成失败'));
		}
	}

	public function getAliEwm()
	{
		$datas = $this->clear_html($_POST);
		$paytype = ((isset($datas['paytype']) ? $datas['paytype'] : 'alipay'));
		$paytype = 'alipay';

		switch ($paytype) {
		case 'alipay':
			$orderinfo = $this->add_order($datas);

			if ($orderinfo) {
				$md5str = md5('ali@pay2w#8m' . $orderinfo['mid'] . $orderinfo['id']);
				$codeStr = $orderinfo['mid'] . '-' . $orderinfo['id'] . '-' . $md5str;
				$codeStr = Encryptioncode($codeStr, 'ENCODE');
				$codeStr = str_replace('+', '_', $codeStr);
				$codeStr = str_replace('/', '-', $codeStr);

				if (defined('ABS_UPLOAD_PATH')) {
					$bsSiteUrl = ABS_UPLOAD_PATH . '/pay/alipay/smnotify.php?myparam=' . $codeStr;
				}
				 else {
					$bsSiteUrl = '/pay/alipay/smnotify.php?myparam=' . $codeStr;
				}

				$notify_url = $this->SiteUrl . $bsSiteUrl;
				bpBase::loadAppClass('AliPayClass', 'User', 0);
				$AliPayClass = new AliPayClass($this->alipayConf);
				$datas = array('order_id' => $orderinfo['order_id'], 'price' => $orderinfo['goods_price'], 'tname' => $orderinfo['goods_name']);
				$ret = $AliPayClass->f2fqrpay($datas, $notify_url);
				$erweimainfo = array('price' => $orderinfo['goods_price'], 'title' => $orderinfo['goods_name'], 'mid' => $orderinfo['mid'], 'eid' => $this->eid, 'storeid' => $this->storeid);
				$erweimainfo = base64_encode(json_encode($erweimainfo));
				$ret['ewminfo'] = $erweimainfo;
				$this->dexit($ret);
			}
			 else {
				$this->dexit(array('error' => 1, 'msg' => '二维码生成失败'));
			}

			break;

		case 'wxpay':
			break;

		}
	}

	public function add_order($datas)
	{
		$data['mid'] = $this->mid;
		$data['goods_id'] = 1;
		$data['pay_way'] = 'alipay';
		$data['pay_type'] = 'qrpay';
		$data['order_id'] = '11' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(SYS_TIME, 2);
		$data['goods_type'] = 'unlimit';
		$data['goods_name'] = htmlspecialchars($datas['tname'], ENT_QUOTES);
		$data['goods_describe'] = '支付宝二维码支付';
		$data['goods_price'] = $datas['tprice'];
		$data['add_time'] = time();

		if (0 < $this->pf_mid) {
			$data['pmid'] = $this->pf_mid;
			$data['mchtype'] = 2;
		}


		!empty($this->extraInsertData) && ($data = array_merge($this->extraInsertData, $data));
		$orderid = M('cashier_order')->insert($data, true);

		if ($orderid) {
			$data['id'] = $orderid;
			return $data;
		}


		return false;
	}

	public function qrcode()
	{
		bpBase::loadOrg('phpqrcode');
		$type = trim($_GET['typ']);
		$isdwd = ((isset($_GET['dwd']) ? intval(trim($_GET['dwd'])) : 0));
		$url = urldecode($this->SiteUrl . '/merchants.php?m=Index&c=pay&a=aliautopay&mid=' . $this->mid . '&eid=' . $this->eid . '&storeid=' . $this->storeid);

		if (0 < $isdwd) {
			new QRimage(400, 400);
			$fname = 'Your-autopay-code-image-' . $this->mid . '.png';
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Type:application/force-download');
			header('Content-type: image/png');
			header('Content-Type:application/download');
			header('Content-Disposition: attachment; filename=' . $fname);
			header('Content-Transfer-Encoding: binary');
			QRcode::png($url, false, 'H', 10, 4);
		}
		 else {
			Header('Content-type: image/jpeg');
			QRcode::png($url);
		}
	}

	public function alipayment()
	{
		$type = ((isset($_GET['type']) ? intval($_GET['type']) : 1));
		$type = (($type == 2 ? $type : 1));
		include $this->showTpl();
	}

	public function aliSmRefund()
	{
		$orderid = $this->clear_html($_POST['auth_code']);

		if (empty($orderid)) {
			$this->dexit(array('error' => 1, 'msg' => '订单号不能为空！'));
		}


		bpBase::loadAppClass('AliPayClass', 'User', 0);
		$AliPayClass = new AliPayClass($this->alipayConf);
		$orderDb = M('cashier_order');
		$orderArr = $orderDb->get_one(array('order_id' => $orderid, 'mid' => $this->mid), '*');

		if (empty($orderArr)) {
			$this->dexit(array('error' => 1, 'msg' => '订单不存在！'));
		}


		if (($orderArr['state'] == 2) && (0 < $orderArr['mchtype'])) {
			$this->dexit(array('error' => 1, 'msg' => '已对过账的订单不可以退款哦！'));
		}


		$ret = $AliPayClass->aliRefund($orderArr['transaction_id'], $orderArr['goods_price'], $orderid);

		if (0 < $ret['error']) {
			$this->dexit($ret);
		}
		 else {
			$RefundUpdata = array('refund' => 2, 'refundtext' => serialize($ret['data']));
			$orderDb->update($RefundUpdata, array('id' => $orderArr['id']));
			$fansDb = M('cashier_fans');
			$Refundprice = array('refund' => $orderArr['goods_price'] * 100);
			$fansDb->update($Refundprice, array('mid' => $this->mid, 'openid' => $ret['data']['open_id'], 'buyeraccount' => $ret['data']['buyer_logon_id']));
			$this->dexit(array('error' => 0, 'msg' => '退款成功！'));
		}
	}

	public function sm_order($datas, $type = 'alipay')
	{
	    
	    //判断是否为二清商户
	    $merchants = M('cashier_merchants')->get_One(array('mid'=>$this->mid),'*');
	    $wxrebate = M('cashier_wxrebate')->select(array('is_pay'=>1,'type'=>2),'rebate');
	    if($merchants['mtype'] == '1'){
	        $data['pmid'] = $this->mid;
	        $data['mchtype'] = 1;
	        $wx_pay = $wxrebate[0]['rebate'] / 100;//微信费率配置
	    }else if ($merchants['mtype'] == '2'){
	        $data['pmid'] = 1;
	        $data['mchtype'] = 2;
	        $wx_pay = $wxrebate[1]['rebate'] / 100;//微信费率配置
	    }
	     
	    //计算利率
	    //商家实收金额
	    $merchants_income = $datas['goods_price'] - $datas['goods_price'] * $merchants['alicommission'];
	     
	    //计算业务员佣金
	    $salesmans = M('cashier_salesmans')->get_One(array('id'=>$merchants['sid']),'*');
	    $agent = M('cashier_agent')->get_One(array('aid'=>$merchants['aid']),'*');
	    $wxrebate = M('cashier_wxrebate')->get_one(array('type'=>2));
	    
	    
	    
	    //$salesmans_income = $datas['goods_price'] * ($merchants['alicommission'] - $wxrebate['rebate']) * $agent['commission'] * $salesmans['commission'];
	    $salesmans_income = $datas['goods_price'] * $wx_pay * $agent['commission'] * $salesmans['commission'];
	    $salesmans_income_is_null = $this->sctonum($salesmans_income);//将科学计算法转为实体
	    if($salesmans_income_is_null){
	        $salesmans_income = $salesmans_income_is_null;
	    }
	    
	     
	     
	    //计算代理商佣金
	   
	    //$agent_income = $datas['goods_price'] * ($merchants['alicommission'] - $wxrebate['rebate']) * $agent['commission'];
	    $agent_income = $datas['goods_price'] * $wx_pay * $agent['commission'];
	    $agent_income_is_null = $this->sctonum($agent_income);//将科学计算法转为实体
	    if($agent_income_is_null){
	        $agent_income = $agent_income_is_null;
	    }
	    
		$data['mid'] = $this->mid;
		$data['goods_id'] = 1;
		$data['pay_way'] = 'alipay';
		$data['pay_type'] = $type;
		$mtrandStr = time() . mt_rand(100111, 999999);
		$mtrandStr = substr($mtrandStr, 4, 10);
		$mtrandStr = str_shuffle($mtrandStr);
		$data['order_id'] = '11' . date('ymdHis') . $mtrandStr;
		$data['goods_type'] = 'ordinary';
		$data['goods_name'] = htmlspecialchars($datas['goods_name'], ENT_QUOTES);
		$data['goods_describe'] = '支付宝条码支付';
		$data['goods_price'] = trim($datas['goods_price']);
		$data['add_time'] = time();

		/* if (0 < $this->pf_mid) {
			$data['pmid'] = $this->pf_mid;
			$data['mchtype'] = 2;
		}
         */
		//收入
		$data['income'] = round($merchants_income ,2);
		$data['salesmans_price'] = round($salesmans_income ,2);
		$data['agent_price'] = round($agent_income ,2);
		

		!empty($this->extraInsertData) && ($data = array_merge($this->extraInsertData, $data));
		$insertid = M('cashier_order')->insert($data, true);

		if (0 < $insertid) {
			$data['id'] = $insertid;
			return array_merge($datas, $data);
		}
        

		$this->dexit(array('error' => 1, 'msg' => '订单生成失败'));
	}
    /**
     * 支付宝刷卡支付
     */
	public function alipay()
	{
		if (IS_POST) {
			if (!empty($this->payConfMsg)) {
				$this->dexit(array('error' => 1, 'msg' => $this->payConfMsg));
			}
			$data = $this->clear_html($_POST);
			empty($data['goods_price']) && $this->dexit(array('error' => 1, 'msg' => '支付金额必须填写！'));
			empty($data['auth_code']) && $this->dexit(array('error' => 1, 'msg' => '支付付款码为空'));
			empty($data['goods_name']) && ($data['goods_name'] = '商品支付宝刷卡支付');
			bpBase::loadAppClass('AliPayClass', 'User', 0);
			$AliPayClass = new AliPayClass($this->alipayConf);
			$data = $this->sm_order($data, 'bar_code');
			$response = $AliPayClass->f2fBarPay($data);

			if ($response) {
				if (0 < $response['error']) {
					$this->dexit(array('error' => 1, 'msg' => $response['msg']));
				}

                //支付成功修改订单状态
				$orderDb = M('cashier_order');
				$paytime = time();
				$updatedata = array('paytime' => $paytime, 'ispay' => $response['ispay'], 'state' => 1, 'truename' => $response['buyer_logon_id'], 'openid' => $response['open_id'], 'transaction_id' => $response['trade_no'], 'extrainfo' => serialize($response));
				$updateorder = $orderDb->update($updatedata, array('id' => $data['id']));
				//模版消息
                if($updateorder){
                    $employee_openid = M('cashier_employee')->get_one(array('eid'=>$data['eid']),'openid');
                    bpBase::loadOrg('WxAuth');
                    $wx_values = M('cashier_key_values')->get_one(array('name'=>'wxconfig'));
                    $wx_values = json_decode($wx_values['value'],true);
                    $WxAuth = new WxAuth($wx_values['appid'],$wx_values['appSecret']);
                    $dataMessage = array(
                        'first' => array('value' => '账单支付成功'),
                        'keyword1' => array('value' => $data['order_id'],'color' => '#173177'),
                        'keyword2' => array('value' => date("Y-m-d H:i:s",$paytime),'color' => '#173177'),
                        'keyword3' => array('value' => $data['goods_price'],'color' => '#173177'),
                        'keyword4' => array('value' => $data['goods_describe'],'color' => '#173177'),
                        'remark' => array('value' => '你好，顾客已支付成功。','color' => '#173177')
                    );
                    $WxAuth->sendTemplateMessage($employee_openid['openid'],WX_MESSAGE_PAY_ID,$dataMessage);
                }
				
				
				
				$fansDb = M('cashier_fans');
				$tmpfans = $fansDb->get_one(array('openid' => $response['open_id'], 'mid' => $this->mid, 'buyeraccount' => $response['buyer_logon_id']), '*');
				$total_fee = $data['goods_price'] * 100;
				$fansData = array('appid' => $this->alipayConf['appid'], 'totalfee' => $total_fee, 'is_subscribe' => 0, 'cf' => 'alipay', 'nickname' => $response['buyer_logon_id'], 'buyeraccount' => $response['buyer_logon_id']);
				$useridStr = $response['buyer_logon_id'];

				if (!empty($tmpfans) && is_array($tmpfans)) {
					$fansData['totalfee'] = $fansData['totalfee'] + $tmpfans['totalfee'];
					$fansDb->update($fansData, array('id' => $tmpfans['id']));
				}
				 else {
					$fansData['mid'] = $this->mid;
					$fansData['openid'] = $response['open_id'];
					$fansDb->insert($fansData, true);
				}

				if (0 < $response['ispay']) {
					bpBase::loadOrg('orderPrint');
					$pt = new orderPrint();
					$printvars = array('mername' => $this->merchant['wxname']);
					empty($printvars['mername']) && !empty($this->merchant['weixin']) && $printvars['mername'] = $this->merchant['weixin'];

					if (0 < $this->storeid) {
						$tmpStore = $this->getStoreByid($this->storeid, $this->mid);
						$printvars['storename'] = ((!empty($tmpStore) ? $tmpStore['business_name'] . $tmpStore['branch_name'] : ''));
					}
					 else {
						$printvars['storename'] = '';
					}

					$printvars['user'] = $useridStr;
					$printvars['paydesc'] = $data['goods_name'];
					$printvars['buytime'] = date('Y-m-d H:i:s', $data['add_time']);
					$printvars['mprice'] = $data['goods_price'];
					$printvars['orderid'] = $data['order_id'];
					$printvars['paytype'] = '支付宝支付';
					$printvars['printtime'] = date('Y-m-d H:i:s');
					$pt->printit($printvars, $this->mid, $this->storeid);
					unset($fansData);
					$this->dexit(array('error' => 0, 'msg' => '支付成功！'));
				}
				 else {
					$this->dexit(array('error' => 1, 'msg' => '顾客未支付！'));
				}
			}


			$this->dexit(array('error' => 1, 'msg' => '支付失败！'));
		}

	}
	
	/**
	 * @param $num         科学计数法字符串  如 2.1E-5
	 * @param int $double 小数点保留位数 默认5位
	 * @return string
	 */
	
	public function sctonum($num, $double = 5){
	    if(false !== stripos($num, "e")){
	        $a = explode("e",strtolower($num));
	        return bcmul($a[0], bcpow(10, $a[1], $double), $double);
	    }
	}
	
	
	
}


?>