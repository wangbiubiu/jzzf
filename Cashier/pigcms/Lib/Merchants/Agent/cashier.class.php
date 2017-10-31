<?php
bpBase::loadAppClass('common', 'User', 0);
class cashier_controller extends common_controller
{
	public $wx_user;

	public function __construct()
	{
		parent::__construct();
		bpBase::loadOrg('checkFunc');
		$checkFunc = new checkFunc();

		if (!function_exists('dsbig3joishdgfhg798rqw4fqnkhffq')) {
			exit('error-4');
		}


		$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		$this->authorityControl(array('getajaxOrder', 'getEwm', 'add_order', 'qrcode', 'weixinPay', 'sm_order', 'getSgin', 'pay', 'odetail'));
		$this->wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
	}

	public function index()
	{
		$SiteUrl = $this->SiteUrl;
		$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $this->tablepre . 'cashier_order as ordr LEFT JOIN ' . $this->tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid where ordr.mid=' . $this->mid . ' AND cf.mid=' . $this->mid . '  AND ordr.pay_way="weixin"';

		if (0 < $this->storeid) {
			$sqlStr = $sqlStr . ' AND ordr.storeid=' . $this->storeid;
		}


		$sqlStr = $sqlStr . ' AND ordr.ispay="1" ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT 0,20';
		$sqlObj = new model();
		$neworder = $sqlObj->selectBySql($sqlStr);
		$neworder = $this->ProcssOdata($neworder, $this->mid);
		include $this->showTpl();
	}

	public function odetail()
	{
		$orid = intval(trim($_GET['orid']));
		$orid = ((0 < $orid ? $orid : 0));
		$orderInfo = M('cashier_order')->getOneOrder(array('id' => $orid, 'mid' => $this->mid));

		if (!empty($orderInfo['refundtext'])) {
			$orderInfo['refundtext'] = unserialize($orderInfo['refundtext']);
		}


		$orderInfo['storename'] = '无';
		$orderInfo['optername'] = '商家自己';

		if (0 < $orderInfo['storeid']) {
			$tmpStore = $this->getStoreByid($orderInfo['storeid'], $this->mid);
			$orderInfo['storename'] = ((!empty($tmpStore) ? $tmpStore['business_name'] . $tmpStore['branch_name'] : '无'));
		}


		if (0 < $orderInfo['eid']) {
			$tmpEmployee = $this->getEmployeeByid($orderInfo['eid'], $this->mid);
			$orderInfo['optername'] = ((!empty($tmpEmployee) ? $tmpEmployee['username'] : '商家自己'));
		}


		ob_start();
		ob_implicit_flush(0);
		include $this->showTpl();
		$content = ob_get_clean();
		echo $content;
	}

	public function getajaxOrder()
	{
		$cf = trim($_GET['cf']);

		switch ($cf) {
		case 'index':
			$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $this->tablepre . 'cashier_order as ordr LEFT JOIN ' . $this->tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid where ordr.mid=' . $this->mid . '  AND cf.mid=' . $this->mid . '  AND ordr.pay_way="weixin"';

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
		$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $this->tablepre . 'cashier_order as ordr LEFT JOIN ' . $this->tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid where ordr.mid=' . $this->mid . '  AND cf.mid=' . $this->mid . '  AND ordr.pay_way="weixin"';

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
		$where = array('mid' => $this->mid, 'pay_way' => 'weixin');

		if (0 < $this->storeid) {
			$where['storeid'] = $this->storeid;
		}


		$_count = $orderDb->count($where);
		$p = new Page($_count, 15);
		$pagebar = $p->show(2);
		$neworder = $orderDb->getOrders($p->firstRow . ',' . $p->listRows, 'id DESC', $where);
		bpBase::loadAppClass('wxSaoMaPay', 'User', 0);
		$wxSaoMaPay = new wxSaoMaPay();
		$neworder = $this->ProcssOdata($neworder, $this->mid);

		foreach ($neworder as $kk => $vv ) {
			if ($vv['ispay'] == 1) {
				$neworder[$kk]['ewmurl'] = $this->SiteUrl . '/merchants.php?m=Index&c=pay&a=autopay&mid=' . $vv['mid'] . '&oid=' . $vv['id'];
			}
			 else {
				$product_id = $vv['mid'] . '_' . $vv['id'];

				if (isset($this->wx_user['submchinfo']) && ($this->mid == $this->wx_user['submchinfo']['mid']) && !empty($this->wx_user['sub_mch_id'])) {
					$neworder[$kk]['ewmurl'] = 'isproxy';
				}
				 else {
					$neworder[$kk]['ewmurl'] = $wxSaoMaPay->GetPrePayUrl($product_id);
				}
			}
		}

		include $this->showTpl();
	}

	public function proxySMewm()
	{
		$oid = ((isset($_POST['oid']) ? intval($_POST['oid']) : 0));

		if (0 < $oid) {
			$ordertmp = M('cashier_order')->get_one(array('id' => $oid, 'mid' => $this->mid), '*');

			if ($ordertmp) {
				bpBase::loadAppClass('wxSaoMaPay', 'User', 0);
				$wxSaoMaPay = new wxSaoMaPay();
				$ewmurl2Arr = $wxSaoMaPay->GetPayUrl($ordertmp);
				if ($ewmurl2Arr && isset($ewmurl2Arr['code_url']) && !empty($ewmurl2Arr['code_url'])) {
					$ewmurl2 = $ewmurl2Arr['code_url'];
					$this->dexit(array('error' => 0, 'msg' => '', 'ewmurl' => $ewmurl2));
				}
				 else {
					$msg = '二维码生成失败';
					isset($ewmurl2Arr['return_msg']) && !empty($ewmurl2Arr['return_msg']) && $msg = $ewmurl2Arr['return_msg'];
					isset($ewmurl2Arr['result_code']) && ($ewmurl2Arr['result_code'] != 'SUCCESS') && !empty($ewmurl2Arr['err_code_des']) && $msg = $ewmurl2Arr['err_code_des'];
					$this->dexit(array('error' => 1, 'msg' => $msg));
				}
			}

		}


		$this->dexit(array('error' => 1, 'msg' => '二维码生成失败！'));
	}

	public function delOrderByid()
	{
		$ordid = intval($_POST['ordid']);
		$mid = intval($_POST['mid']);
		$orderDb = M('cashier_order');
		$orderArr = $orderDb->get_one(array('id' => $ordid, 'mid' => $this->mid), '*');
		if (($orderArr['ispay'] != 1) || (($orderArr['ispay'] == 1) && ($orderArr['refund'] == 2))) {
			$return = $this->_del($orderDb, $ordid, 'mid=' . $this->mid);
			$this->dexit($return);
		}


		if (!empty($orderArr)) {
			$this->dexit(array('error' => 1, 'msg' => '已付款的订单不可以删除！'));
		}


		$this->dexit(array('error' => 1, 'msg' => '订单不存在！'));
	}

	public function wxRefund()
	{
		$ordid = intval($_POST['ordid']);
		$mid = intval($_POST['mid']);
		bpBase::loadAppClass('wxSaoMaPay', 'User', 0);
		$wxSaoMaPay = new wxSaoMaPay();
		$ret = $wxSaoMaPay->wxRefund($ordid, $this->wx_user, $this->mid);
		$this->dexit($ret);
	}

	public function getEwm()
	{
		$datas = $this->clear_html($_POST);
		$paytype = ((isset($datas['paytype']) ? $datas['paytype'] : ''));

		switch ($paytype) {
		case 'wxpay':
			$orderinfo = $this->add_order($datas);

			if ($orderinfo) {
				bpBase::loadAppClass('wxSaoMaPay', 'User', 0);
				$wxSaoMaPay = new wxSaoMaPay();
				$product_id = $orderinfo['mid'] . '_' . $orderinfo['orderid'];

				if (isset($this->wx_user['submchinfo']) && ($this->mid == $this->wx_user['submchinfo']['mid']) && !empty($this->wx_user['sub_mch_id'])) {
					$ewmurl2Arr = $wxSaoMaPay->GetPayUrl($orderinfo);
					if ($ewmurl2Arr && isset($ewmurl2Arr['code_url']) && !empty($ewmurl2Arr['code_url'])) {
						$ewmurl2 = $ewmurl2Arr['code_url'];
					}
					 else {
						$msg = '二维码生成失败';
						isset($ewmurl2Arr['return_msg']) && !empty($ewmurl2Arr['return_msg']) && $msg = $ewmurl2Arr['return_msg'];
						isset($ewmurl2Arr['result_code']) && ($ewmurl2Arr['result_code'] != 'SUCCESS') && !empty($ewmurl2Arr['err_code_des']) && $msg = $ewmurl2Arr['err_code_des'];
						$this->dexit(array('error' => 1, 'msg' => $msg));
					}
				}
				 else {
					$ewmurl2 = $wxSaoMaPay->GetPrePayUrl($product_id);
				}

				$erweimainfo = array('price' => $orderinfo['goods_price'], 'title' => $orderinfo['goods_name'], 'mid' => $orderinfo['mid'], 'eid' => $this->eid, 'storeid' => $this->storeid);
				$this->dexit(array('error' => 0, 'qrcode' => $ewmurl2, 'ewminfo' => base64_encode(json_encode($erweimainfo))));
			}
			 else {
				$this->dexit(array('error' => 1, 'msg' => '二维码生成失败'));
			}

			break;

		case 'alipay':
			break;

		}
	}

	public function add_order($datas)
	{
		$pmid = 0;
		$mchtype = 0;

		if (isset($this->wx_user['p_mid']) && isset($this->wx_user['submchinfo'])) {
			$pmid = $this->wx_user['p_mid'];
			$mchtype = 1;
		}


		if (isset($this->wx_user['mymid']) && ($this->wx_user['mymid'] == $this->mid) && isset($this->wx_user['pfpaymid'])) {
			$pmid = $this->wx_user['mid'];
			$mchtype = 2;
		}


		$data['mid'] = $this->mid;
		$data['pmid'] = $pmid;
		$data['mchtype'] = $mchtype;
		$data['goods_id'] = 1;
		$data['pay_way'] = 'weixin';
		$data['pay_type'] = 'wxsaoma2pay';
		$data['order_id'] = '22' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(SYS_TIME, 2);
		$data['goods_type'] = 'unlimit';
		$data['goods_name'] = $datas['tname'];
		$data['goods_describe'] = '收银台生成二维码扫码支付';
		$data['goods_price'] = $datas['tprice'];
		$data['add_time'] = SYS_TIME;
		!empty($this->extraInsertData) && ($data = array_merge($this->extraInsertData, $data));
		$orderid = M('cashier_order')->insert($data, true);

		if ($orderid) {
			$data['orderid'] = $orderid;
			return $data;
		}


		return false;
	}

	public function qrcode()
	{
		bpBase::loadOrg('phpqrcode');
		$type = trim($_GET['typ']);
		$isdwd = ((isset($_GET['dwd']) ? intval(trim($_GET['dwd'])) : 0));
		$url = urldecode($this->SiteUrl . '/merchants.php?m=Index&c=pay&a=autopay&mid=' . $this->mid . '&eid=' . $this->eid . '&storeid=' . $this->storeid);

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

	public function payment()
	{
		bpBase::loadOrg('wxCardPack');
		$wxCardPack = new wxCardPack($this->wx_user, $this->mid);
		$access_token = $wxCardPack->getToken();
		$signdata = $wxCardPack->getSgin($access_token);
		$type = ((isset($_GET['type']) ? intval($_GET['type']) : 1));
		$type = (($type == 2 ? $type : 1));
		include $this->showTpl();
	}

	public function wxSmRefund()
	{
		$orderid = $this->clear_html($_POST['auth_code']);
		bpBase::loadAppClass('wxSaoMaPay', 'User', 0);
		$wxSaoMaPay = new wxSaoMaPay();
		$ret = $wxSaoMaPay->wxRefund($orderid, $this->wx_user, $this->mid, 'micropay');
		$this->dexit($ret);
	}

	public function sm_order($datas)
	{
		$pmid = 0;
		$mchtype = 0;

		if (isset($this->wx_user['p_mid']) && isset($this->wx_user['submchinfo'])) {
			$pmid = $this->wx_user['p_mid'];
			$mchtype = 1;
		}


		if (isset($this->wx_user['mymid']) && ($this->wx_user['mymid'] == $this->mid) && isset($this->wx_user['pfpaymid'])) {
			$pmid = $this->wx_user['mid'];
			$mchtype = 2;
		}


		$data['mid'] = $this->mid;
		$data['pmid'] = $pmid;
		$data['mchtype'] = $mchtype;
		$data['goods_id'] = 1;
		$data['pay_way'] = 'weixin';
		$data['pay_type'] = 'micropay';
		$mtrandStr = time() . mt_rand(100111, 999999);
		$mtrandStr = substr($mtrandStr, 4, 10);
		$mtrandStr = str_shuffle($mtrandStr);
		$data['order_id'] = '22' . date('ymdHis') . $mtrandStr;
		$data['goods_type'] = 'ordinary';
		$data['goods_name'] = htmlspecialchars($datas['goods_name'], ENT_QUOTES);
		$data['goods_describe'] = '后台刷卡支付';
		$data['goods_price'] = trim($datas['goods_price']);
		$data['add_time'] = time();
		!empty($this->extraInsertData) && ($data = array_merge($this->extraInsertData, $data));
		$insertid = M('cashier_order')->insert($data, true);

		if (0 < $insertid) {
			$data['id'] = $insertid;
			return array_merge($datas, $data);
		}


		$this->dexit(array('error' => 1, 'msg' => '订单生成失败'));
	}

	public function pay()
	{
		if (IS_POST) {
			set_time_limit(70);
			$data = $this->clear_html($_POST);
			empty($data['goods_price']) && $this->dexit(array('error' => 1, 'msg' => '支付金额必须填写！'));
			empty($data['auth_code']) && $this->dexit(array('error' => 1, 'msg' => '支付auth_code为空'));
			empty($data['goods_name']) && ($data['goods_name'] = '商品微信刷卡支付');
			$this->weixinPay($data);
			$this->dexit(array('error' => 0, 'msg' => '支付成功！'));
		}

	}

	public function weixinPay($data)
	{
		if (IS_POST) {
			$data = $this->sm_order($data);
			bpBase::loadAppClass('wxSaoMaPay', 'User', 0);
			$wxSaoMaPay = new wxSaoMaPay();
			$response = $wxSaoMaPay->micropay($data);

			if (!empty($response)) {
				if ($response['return_code'] == 'SUCCESS') {
					if ($response['result_code'] == 'SUCCESS') {
						$order_id = trim($response['out_trade_no']);
						$appid = trim($response['appid']);
						$sub_appid = ((isset($response['sub_appid']) ? $response['sub_appid'] : ''));
						$sub_mch_id = ((isset($response['sub_mch_id']) ? $response['sub_mch_id'] : ''));
						$total_fee = trim($response['total_fee']);
						$openid = trim($response['openid']);
						$sub_openid = ((isset($response['sub_openid']) ? $response['sub_openid'] : ''));
						$transaction_id = trim($response['transaction_id']);
						$trade_type = trim($response['trade_type']);
						$is_subscribe = ((strtoupper(trim($response['is_subscribe'])) == 'Y' ? 1 : 0));
						$orderDb = M('cashier_order');
						$wherearr = array('order_id' => $order_id, 'pay_way' => 'weixin');

						if (!empty($data) && isset($data['id'])) {
							$wherearr['id'] = $data['id'];
						}


						if (!empty($sub_mch_id) && !empty($sub_openid)) {
						}
						 else {
						}

						$tmpopenid = $openid;
						$p_openid = ((!empty($sub_mch_id) ? $openid : ''));

						if (!empty($sub_mch_id) && !empty($sub_appid)) {
						}
						 else {
						}

						$tmpappid = $appid;
						$data = $orderDb->get_one($wherearr, '*');
						$wxuserinfo = array();
						bpBase::loadOrg('wxCardPack');

						if (!empty($sub_mch_id) && isset($this->wx_user['submchinfo']) && ($this->mid == $this->wx_user['submchinfo']['mid']) && !empty($this->wx_user['submchinfo']['appid']) && !empty($this->wx_user['submchinfo']['appSecret'])) {
							$wxCardPack = new wxCardPack($this->wx_user['submchinfo'], $this->mid);
						}
						 else {
							$wxCardPack = new wxCardPack($this->wx_user, $this->wx_user['mid']);
						}

						$access_token = $wxCardPack->getToken();
						$wxuserinfo = $wxCardPack->GetwxUserInfoByOpenid($access_token, $tmpopenid);
						$useridStr = $tmpopenid;

						if (!0 < $data['ispay']) {
							$updatedata = array('openid' => $tmpopenid, 'transaction_id' => $transaction_id, 'state' => 1, 'ispay' => 1, 'p_openid' => $p_openid, 'paytime' => time());
							isset($wxuserinfo['nickname']) && $updatedata['truename'] = $wxuserinfo['nickname'];
							$orderDb->update($updatedata, array('id' => $data['id']));
							$fansDb = M('cashier_fans');

							if (!empty($tmpopenid)) {
								$tmpfans = $fansDb->get_one(array('openid' => $tmpopenid, 'mid' => $this->mid), '*');
								$fansData = array('appid' => $tmpappid, 'totalfee' => $total_fee, 'is_subscribe' => 0);

								if (isset($wxuserinfo['nickname'])) {
									$fansData['nickname'] = $wxuserinfo['nickname'];
									$fansData['sex'] = $wxuserinfo['sex'];
									$fansData['province'] = $wxuserinfo['province'];
									$fansData['city'] = $wxuserinfo['city'];
									$fansData['country'] = $wxuserinfo['country'];
									$fansData['headimgurl'] = $wxuserinfo['headimgurl'];
									$fansData['groupid'] = $wxuserinfo['groupid'];
									$fansData['is_subscribe'] = 1;
								}


								if (!empty($tmpfans) && is_array($tmpfans)) {
									$fansData['totalfee'] = $fansData['totalfee'] + $tmpfans['totalfee'];
									$fansDb->update($fansData, array('id' => $tmpfans['id']));
								}
								 else {
									$fansData['mid'] = $this->mid;
									$fansData['openid'] = $tmpopenid;
									$fansDb->insert($fansData, true);
								}

								if (isset($fansData['nickname']) && !empty($fansData['nickname'])) {
								}
								 else {
								}

								$useridStr = $useridStr;
								unset($fansData);
								$yuanprice = $total_fee / 100;
								M('cashier_wxcoupon')->cardbonus(array('openid' => $tmpopenid, 'price' => $yuanprice, 'msg' => '微信支付', 'fromid' => 0));
							}


							if (!empty($p_openid) && isset($this->wx_user['p_mid']) && isset($this->wx_user['submchinfo'])) {
								$pwxCardPack = new wxCardPack($this->wx_user, $this->wx_user['p_mid']);
								$paccess_token = $pwxCardPack->getToken();
								$pwxuserinfo = $pwxCardPack->GetwxUserInfoByOpenid($paccess_token, $p_openid);
								$ptmpfans = $fansDb->get_one(array('openid' => $p_openid, 'mid' => $this->wx_user['p_mid']), '*');
								$fansData = array('appid' => $this->wx_user['appid'], 'totalfee' => $total_fee, 'is_subscribe' => 0);

								if (isset($pwxuserinfo['nickname'])) {
									$fansData['nickname'] = $pwxuserinfo['nickname'];
									$fansData['sex'] = $pwxuserinfo['sex'];
									$fansData['province'] = $pwxuserinfo['province'];
									$fansData['city'] = $pwxuserinfo['city'];
									$fansData['country'] = $pwxuserinfo['country'];
									$fansData['headimgurl'] = $pwxuserinfo['headimgurl'];
									$fansData['groupid'] = $pwxuserinfo['groupid'];
									$fansData['is_subscribe'] = 1;
								}


								if (!empty($ptmpfans) && is_array($ptmpfans)) {
									$fansData['totalfee'] = $fansData['totalfee'] + $ptmpfans['totalfee'];
									$fansDb->update($fansData, array('id' => $ptmpfans['id']));
								}
								 else {
									$fansData['mid'] = $this->wx_user['p_mid'];
									$fansData['openid'] = $p_openid;
									$fansDb->insert($fansData, true);
								}

								if (isset($fansData['nickname']) && !empty($fansData['nickname'])) {
								}
								 else {
								}

								$useridStr = $useridStr;
								$yuanprice = $total_fee / 100;
								M('cashier_wxcoupon')->cardbonus(array('openid' => $p_openid, 'price' => $yuanprice, 'msg' => '微信支付', 'fromid' => 0));
							}


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
							$printvars['paytype'] = '微信支付';
							$printvars['printtime'] = date('Y-m-d H:i:s');
							$pt->printit($printvars, $this->mid, $this->storeid);
						}


						$this->dexit(array('error' => 0, 'msg' => 'OK'));
					}


					$this->dexit(array('error' => 1, 'msg' => '错误码：' . $response['err_code'] . '<br/>错误描述：' . $response['err_code_des']));
				}


				$this->dexit(array('error' => 1, 'msg' => '错误描述：' . $response['return_msg']));
			}

		}

	}
}


?>