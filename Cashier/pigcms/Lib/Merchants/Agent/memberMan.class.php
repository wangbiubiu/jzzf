<?php

bpBase::loadAppClass('common', 'User', 0);
class memberMan_controller extends common_controller
{
	private $wxCardPack;
	private $access_token;
	private $card_type;
	private $appid = '';

	public function __construct()
	{
		parent::__construct();
		bpBase::loadOrg('checkFunc');
		$checkFunc = new checkFunc();

		if (!function_exists('dsbig3joishdgfhg798rqw4fqnkhffq')) {
			exit('error-4');
		}


		$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		$this->authorityControl(array('cardetail', 'wxCardQrCodeTicket', 'qrcode', 'FiltrationData', 'updateMname', 'testUpdateCard', 'setActivateUserForm', 'cardactive', 'setPayCell', 'membercardinfo'));
		bpBase::loadOrg('wxCardPack');
		$wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);

		if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $this->mid)) {
			$wx_user = $wx_user['submchinfo'];
		}


		$this->appid = $wx_user['appid'];
		$this->wxCardPack = new wxCardPack($wx_user, $this->mid);
		$this->access_token = $this->wxCardPack->getToken();
		$this->card_type = array(
			array('enname' => 'GENERAL_COUPON', 'zhname' => '优惠券'),
			array('enname' => 'GROUPON', 'zhname' => '团购券'),
			array('enname' => 'DISCOUNT', 'zhname' => '折扣券'),
			array('enname' => 'GIFT', 'zhname' => '礼品券'),
			array('enname' => 'CASH', 'zhname' => '代金券'),
			array('enname' => 'MEMBER_CARD', 'zhname' => '会员卡')
			);
	}

	public function cardetail()
	{
		$id = intval(trim($_GET['id']));
		$cardinfo = M('cashier_wxcoupon')->get_one(array('id' => $id, 'mid' => $this->mid), '*');

		if (empty($cardinfo)) {
			$this->errorTip('您所查看的卡券不存在', $_SERVER['HTTP_REFERER']);
			exit();
		}


		$kqcontent = unserialize($cardinfo['kqcontent']);
		unset($cardinfo['kqcontent']);
		!empty($cardinfo['kqexpand']) && ($cardinfo['kqexpand'] = unserialize($cardinfo['kqexpand']));
		$mset = M('cashier_wxcoupon_common')->get_one(array('mid' => $this->mid), '*');
		$kqcontent['location_id_list'] = str_replace('Jsarray[', '', str_replace(']', '', $kqcontent['location_id_list']));
		if (empty($kqcontent['location_id_list']) || ($kqcontent['location_id_list'] == '0')) {
			$kqcontent['shop_id_count'] = 0;
		}
		 else {
			$kqcontent['location_id_list'] = explode(',', $kqcontent['location_id_list']);
			$kqcontent['shop_id_count'] = count($kqcontent['location_id_list']);
		}

		$wxCardColor = $this->wxCardPack->wxCardColor($this->access_token);

		foreach ($wxCardColor as $cvv ) {
			if (!($kqcontent['color'] == $cvv['name'])) {
				continue;
			}
			$kqcontent['colorV'] = $cvv['value'];
			break;
		}

		$istowxFlage = ((0 < $cardinfo['istowx'] ? 3 : 'nogo'));
		if (!is_array($shoplist) || empty($shoplist)) {
			if (0 < $this->storeid) {
				$wherearr = array('id' => $this->storeid, 'mid' => $this->mid, 'appid' => $this->appid);
			}
			 else {
				$wherearr = array('mid' => $this->mid, 'appid' => $this->appid);
			}

			$wxShoplist = M('cashier_stores')->GetStores($wherearr, $istowxFlage);
			$shoplist = $location_id_list = array();

			if (!empty($wxShoplist)) {
				foreach ($wxShoplist as $kk => $vv ) {
					if ((0 < $cardinfo['istowx']) && empty($vv['poi_id'])) {
						continue;
					}


					if (!empty($kqcontent['location_id_list']) && in_array($vv['poi_id'], $kqcontent['location_id_list'])) {
						$location_id_list[] = $vv['id'];
					}


					$shoplist[$vv['id']] = array('id' => $vv['id'], 'sid' => $vv['sid'], 'business_name' => $vv['business_name'], 'branch_name' => $vv['branch_name'], 'poi_id' => $vv['poi_id'], 'address' => $vv['address']);
				}
			}


			if (!0 < $cardinfo['istowx']) {
				$locaArrShop = explode(',', $cardinfo['store_ids']);
				$location_id_list = array_merge($location_id_list, $locaArrShop);
			}


			$kqcontent['location_id_list'] = array_unique($location_id_list);
			unset($location_id_list);
			unset($locaArrShop);

			if (!empty($wxShoplist)) {
				$_SESSION['wxshoplist'] = serialize($shoplist);
			}

		}


		include $this->showTpl();
	}

	public function delCardByid()
	{
		$id = intval(trim($_POST['cdid']));
		$wxcouponDb = M('cashier_wxcoupon');
		$cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');

		if (!empty($cardinfo) && !empty($cardinfo['card_id'])) {
			if ($cardinfo['card_id'] == 'localCard_id') {
				$wxcouponDb->delete(array('id' => $id, 'mid' => $this->mid));
				$this->dexit(array('error' => 0, 'msg' => '卡券删除成功！'));
			}


			$rets = $this->wxCardPack->wxCardDelete($this->access_token, '{"card_id":"' . $cardinfo['card_id'] . '"}');

			if (isset($rets['errcode']) && ($rets['errcode'] == 0)) {
				$wxcouponDb->update(array('isdel' => 1), array('id' => $id, 'mid' => $this->mid));
				$this->dexit(array('error' => 0, 'msg' => '卡券删除成功！'));
			}
			 else {
				$tmpmsg = ((isset($rets['errcode']) ? $rets['errcode'] : ''));
				isset($rets['errmsg']) && ($tmpmsg = $tmpmsg . '：' . $rets['errmsg']);

				if (!empty($tmpmsg)) {
					$this->dexit(array('error' => 1, 'msg' => $tmpmsg));
				}


				$this->dexit(array('error' => 1, 'msg' => '删除失败！'));
			}
		}


		$this->dexit(array('error' => 1, 'msg' => '卡券不存在，不可删除！'));
	}

	public function membercardinfo()
	{
		$id = ((isset($_POST['id']) ? intval($_POST['id']) : 0));

		if ($id) {
			$card = M('cashier_wxcoupon_receive')->get_one(array('outerid' => $this->mid, 'id' => $id, 'cardtype' => 5), '*');
		}


		if (empty($card)) {
			$this->dexit(array('errcode' => 1, 'errmsg' => '不存在的会员卡信息'));
		}


		$res = $this->wxCardPack->MemberCardUserInfo($this->access_token, json_encode(array('card_id' => $card['cardid'], 'code' => $card['cardcode'])));

		if ($res['errcode']) {
			$this->dexit($res);
		}


		$key_val['USER_FORM_INFO_FLAG_MOBILE'] = '手机号';
		$key_val['USER_FORM_INFO_FLAG_NAME'] = '姓名';
		$key_val['USER_FORM_INFO_FLAG_BIRTHDAY'] = '生日';
		$key_val['USER_FORM_INFO_FLAG_IDCARD'] = '身份证';
		$key_val['USER_FORM_INFO_FLAG_EMAIL'] = '邮箱';
		$key_val['USER_FORM_INFO_FLAG_DETAIL_LOCATION'] = '详细地址';
		$key_val['USER_FORM_INFO_FLAG_EDUCATION_BACKGROUND'] = '教育背景';
		$key_val['USER_FORM_INFO_FLAG_CAREER'] = '职业';
		$key_val['USER_FORM_INFO_FLAG_INDUSTRY'] = '行业';
		$key_val['USER_FORM_INFO_FLAG_INCOME'] = '收入';
		$key_val['USER_FORM_INFO_FLAG_HABIT'] = '兴趣爱好';
		$data = array();
		$data[] = array('title' => '昵称', 'value' => $res['nickname']);
		$data[] = array('title' => '卡号', 'value' => $res['membership_number']);
		$data[] = array('title' => '积分', 'value' => $res['bonus']);
		$data[] = array('title' => '性别', 'value' => ($res['sex'] == 'MALE' ? '男' : '女'));

		if (isset($res['user_info']['common_field_list']) && $res['user_info']['common_field_list']) {
			foreach ($res['user_info']['common_field_list'] as $row ) {
				$data[] = array('title' => $key_val[$row['name']], 'value' => $row['value']);
			}
		}


		if (isset($res['user_info']['custom_field_list']) && $res['user_info']['custom_field_list']) {
			foreach ($res['user_info']['custom_field_list'] as $row ) {
				$data[] = array('title' => $row['name'], 'value' => $row['value']);
			}
		}


		$status = array('NORMAL' => '正常', 'EXPIRE' => '已过期', 'GIFTING' => '转赠中', 'GIFT_SUCC' => '转赠成功', 'GIFT_TIMEOUT' => '转赠超时', 'DELETE' => '已删除', 'UNAVAILABLE' => '已失效');
		$data[] = array('title' => '状态', 'value' => $status[$res['user_card_status']]);
		$this->dexit(array('errcode' => 0, 'data' => $data));
	}

	public function cardindex()
	{
		bpBase::loadOrg('common_page');
		$wxcouponDb = M('cashier_wxcoupon');
		$where = array('mid' => $this->mid, 'isdel' => '0', 'card_type' => '5');

		if (0 < $this->storeid) {
			$where['storeid'] = $this->storeid;
		}


		$_count = $wxcouponDb->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$wxcoupons = $wxcouponDb->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');

		foreach ($wxcoupons as $kk => $vv ) {
			unset($wxcoupons[$kk]['kqcontent']);
			unset($wxcoupons[$kk]['kqexpand']);

			if ($vv['status'] == 0) {
				$wxcoupons[$kk]['statusstr'] = '<font>审核中</font>';
			}
			 else if ($vv['status'] == 1) {
				$wxcoupons[$kk]['statusstr'] = '<font color=\'green\'>已审核</font>';
			}
			 else if ($vv['status'] == 2) {
				$wxcoupons[$kk]['statusstr'] = '<font color=\'red\'>未通过</font>';
			}
			 else {
				$wxcoupons[$kk]['statusstr'] = '待定';
			}
		}

		include $this->showTpl();
	}

	public function card()
	{
		$wxcouponDb = M('cashier_wxcoupon');
		$where = array('mid' => $this->mid, 'isdel' => '0', 'card_type' => '5');
		$_count = $wxcouponDb->count($where);
		$datestart = date('Y-m-d');
		$dateend = date('Y-m-d', strtotime('+1 month'));
		$typeid = 5;
		$wxcouponSet = M('cashier_wxcoupon_common')->get_one(array('mid' => $this->mid), '*');
		$shoplist = unserialize($_SESSION['wxshoplist']);
		if (!is_array($shoplist) || empty($shoplist)) {
			if (0 < $this->storeid) {
				$wherearr = array('id' => $this->storeid, 'mid' => $this->mid, 'appid' => $this->appid);
			}
			 else {
				$wherearr = array('mid' => $this->mid, 'appid' => $this->appid);
			}

			$wxShoplist = M('cashier_stores')->GetStores($wherearr);
			$shoplist = array();

			if (!empty($wxShoplist)) {
				foreach ($wxShoplist as $kk => $vv ) {
					$shoplist[$vv['poi_id']] = array('sid' => $this->mid, 'business_name' => $vv['business_name'], 'branch_name' => $vv['branch_name'], 'poi_id' => $vv['poi_id'], 'address' => $vv['address']);
				}
			}


			if (!empty($wxShoplist)) {
				$_SESSION['wxshoplist'] = serialize($shoplist);
			}

		}


		$wxCardColor = $this->wxCardPack->wxCardColor($this->access_token);
		include $this->showTpl();
	}

	public function wxCardList()
	{
		bpBase::loadOrg('common_page');
		$cardid = ((isset($_GET['id']) ? intval($_GET['id']) : 0));
		$card = NULL;

		if ($cardid) {
			$card = M('cashier_wxcoupon')->get_one(array('mid' => $this->mid, 'id' => $cardid, 'card_type' => 5), '*');
		}


		$where = 'outerid=' . $this->mid . ' AND cardtype=5';
		$where_sql = 'wxr.outerid=' . $this->mid . ' AND wxr.cardtype=5';

		if ($card) {
			$where = 'outerid=' . $this->mid . ' AND cardtype=5 AND cardid=\'' . $card['card_id'] . '\'';
			$where_sql = 'wxr.outerid=' . $this->mid . ' AND wxr.cardtype=5 AND wxr.cardid=\'' . $card['card_id'] . '\'';
		}


		$wxcouponReceiveDb = M('cashier_wxcoupon_receive');
		$_count = $wxcouponReceiveDb->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$db_config = loadConfig('db');
		$tablepre = $db_config['default']['tablepre'];
		$sqlStr = 'SELECT DISTINCT wxr.id, wxr.*, cf.nickname, cf.headimgurl FROM ' . $tablepre . 'cashier_wxcoupon_receive as wxr LEFT JOIN ' . $tablepre . 'cashier_fans AS cf ON wxr.openid=cf.openid AND cf.mid=wxr.outerid where ' . $where_sql . ' ORDER BY id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
		$sqlObj = new model();
		$wxReceiveUser = $sqlObj->selectBySql($sqlStr);
		include $this->showTpl();
	}

	public function setPayCell()
	{
		$id = intval(trim($_POST['id']));
		$wxcouponDb = M('cashier_wxcoupon');
		$cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');

		if (empty($cardinfo)) {
			$this->dexit(array('errcode' => 1, 'errmsg' => '不存在的会员卡'));
		}


		$is_open = (($cardinfo['is_open_cell'] ? false : true));
		$data = array('is_open' => $is_open, 'card_id' => $cardinfo['card_id']);
		$wxCardColor = $this->wxCardPack->PayCell($this->access_token, json_encode($data));

		if (empty($wxCardColor['errcode'])) {
			$wxcouponDb->update(array('is_open_cell' => ($is_open ? 1 : 0)), array('id' => $id, 'mid' => $this->mid));
		}


		$this->dexit($wxCardColor);
	}

	public function cardactive()
	{
		$key_val = array();
		$key_val['USER_FORM_INFO_FLAG_NAME'] = '姓名';
		$key_val['USER_FORM_INFO_FLAG_BIRTHDAY'] = '生日';
		$key_val['USER_FORM_INFO_FLAG_IDCARD'] = '身份证';
		$key_val['USER_FORM_INFO_FLAG_EMAIL'] = '邮箱';
		$key_val['USER_FORM_INFO_FLAG_DETAIL_LOCATION'] = '详细地址';
		$key_val['USER_FORM_INFO_FLAG_EDUCATION_BACKGROUND'] = '教育背景';
		$key_val['USER_FORM_INFO_FLAG_CAREER'] = '职业';
		$key_val['USER_FORM_INFO_FLAG_INDUSTRY'] = '行业';
		$key_val['USER_FORM_INFO_FLAG_INCOME'] = '收入';
		$key_val['USER_FORM_INFO_FLAG_HABIT'] = '兴趣爱好';
		$id = intval(trim($_GET['id']));
		$cardinfo = M('cashier_wxcoupon')->get_one(array('id' => $id, 'mid' => $this->mid), '*');

		if (empty($cardinfo)) {
			$this->errorTip('您所查看的卡券不存在', $_SERVER['HTTP_REFERER']);
			exit();
		}


		$activate_user_form = unserialize($cardinfo['activate_user_form']);

		if (isset($activate_user_form['required_form']['common_field_id_list']) && $activate_user_form['required_form']['common_field_id_list']) {
		}
		 else {
		}

		$required_form_id_list = array();

		if (isset($activate_user_form['optional_form']['common_field_id_list']) && $activate_user_form['optional_form']['common_field_id_list']) {
		}
		 else {
		}

		$optional_form_id_list = array();

		if (isset($activate_user_form['required_form']['custom_field_list']) && $activate_user_form['required_form']['custom_field_list']) {
		}
		 else {
		}

		$required_form_custom_field_list = '';

		if (isset($activate_user_form['optional_form']['custom_field_list']) && $activate_user_form['optional_form']['custom_field_list']) {
		}
		 else {
		}

		$optional_form_custom_field_list = '';
		include $this->showTpl();
	}

	public function setActivateUserForm()
	{
		$id = intval(trim($_POST['id']));
		$wxcouponDb = M('cashier_wxcoupon');
		$cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');

		if (empty($cardinfo)) {
			$this->dexit(array('errcode' => 1, 'errmsg' => '不存在的会员卡'));
		}


		$data = array('card_id' => $cardinfo['card_id']);

		if ($_POST['field_list']) {
			$data['required_form']['common_field_id_list'] = $_POST['field_list'];
		}


		if ($_POST['custom']) {
			$custom_field_list = str_replace('，', ',', $_POST['custom']);
			$custom_field_list = explode(',', $custom_field_list);
			$data['required_form']['custom_field_list'] = $custom_field_list;
		}


		if ($_POST['sel_field_list']) {
			$data['optional_form']['common_field_id_list'] = $_POST['sel_field_list'];
		}


		if ($_POST['custom_sel']) {
			$custom_field_list = str_replace('，', ',', $_POST['custom_sel']);
			$custom_field_list = explode(',', $custom_field_list);
			$data['optional_form']['custom_field_list'] = $custom_field_list;
		}


		$jsondata = '{"card_id":"' . $data['card_id'] . '"';

		if (isset($data['required_form'])) {
			$jsondata .= ', "required_form":{';
			$required_form_common_field_id_list = false;

			if (isset($data['required_form']['common_field_id_list'])) {
				$required_form_common_field_id_list = true;
				$jsondata .= '"common_field_id_list":["USER_FORM_INFO_FLAG_MOBILE"';

				foreach ($data['required_form']['common_field_id_list'] as $v ) {
					$jsondata .= ',"' . $v . '"';
				}

				$jsondata .= ']';
			}


			if (isset($data['required_form']['custom_field_list'])) {
				if ($required_form_common_field_id_list) {
					$jsondata .= ', "custom_field_list":[';
				}
				 else {
					$jsondata .= '"custom_field_list":[';
				}

				$pre = '';

				foreach ($data['required_form']['custom_field_list'] as $v ) {
					$jsondata .= $pre . '"' . $v . '"';
					$pre = ',';
				}

				$jsondata .= ']';
			}


			$jsondata .= '}';
		}


		if (isset($data['optional_form'])) {
			$jsondata .= ', "optional_form":{';
			$optional_form_common_field_id_list = false;

			if (isset($data['optional_form']['common_field_id_list'])) {
				$optional_form_common_field_id_list = true;
				$jsondata .= '"common_field_id_list":[';
				$pre = '';

				foreach ($data['optional_form']['common_field_id_list'] as $v ) {
					$jsondata .= $pre . '"' . $v . '"';
					$pre = ',';
				}

				$jsondata .= ']';
			}


			if (isset($data['optional_form']['custom_field_list'])) {
				if ($optional_form_common_field_id_list) {
					$jsondata .= ', "custom_field_list":[';
				}
				 else {
					$jsondata .= '"custom_field_list":[';
				}

				$pre = '';

				foreach ($data['optional_form']['custom_field_list'] as $v ) {
					$jsondata .= $pre . '"' . $v . '"';
					$pre = ',';
				}

				$jsondata .= ']';
			}


			$jsondata .= '}';
		}


		$jsondata .= '}';
		$wxCardColor = $this->wxCardPack->ActivateUserForm($this->access_token, $jsondata);

		if (empty($wxCardColor['errcode'])) {
			$wxcouponDb->update(array('activate_user_form' => serialize($data)), array('id' => $id, 'mid' => $this->mid));
		}


		$this->dexit($wxCardColor);
	}

	public function ModifyStock()
	{
		$cdid = trim($_POST['cdid']);
		$id = intval(trim($_POST['id']));
		$qtype = intval(trim($_POST['qtype']));
		$qmun = intval(trim($_POST['qmun']));
		$opt = '+';
		$wxcouponDb = M('cashier_wxcoupon');
		$cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');

		if (isset($cardinfo['quantity'])) {
			if ($qtype == 1) {
				$postwxJsonstr = '{"card_id":"' . $cdid . '","increase_stock_value":' . $qmun . '}';
				$newquantity = $cardinfo['quantity'] + $qmun;
			}
			 else {
				if ($cardinfo['quantity'] < $qmun) {
					$this->dexit(array('error' => 1, 'msg' => '减少库存的值不能大于现在的库存值'));
				}


				$postwxJsonstr = '{"card_id":"' . $cdid . '","reduce_stock_value":' . $qmun . '}';
				$opt = '-';
				$newquantity = $cardinfo['quantity'] - $qmun;
			}

			if (!0 < $cardinfo['istowx']) {
				$wxcouponDb->update(array('quantity' => $opt . '=' . $qmun), array('id' => $id, 'mid' => $this->mid));
				$this->dexit(array('error' => 0, 'msg' => $newquantity));
			}


			$rets = $this->wxCardPack->wxCardModifyStock($this->access_token, $postwxJsonstr);

			if (isset($rets['errcode'])) {
				if ($rets['errcode'] == 0) {
					$wxcouponDb->update(array('quantity' => $opt . '=' . $qmun), array('id' => $id, 'mid' => $this->mid));
					$this->dexit(array('error' => 0, 'msg' => $newquantity));
				}
				 else {
					$this->dexit(array('error' => 1, 'msg' => $rets['errcode'] . '：' . $rets['errmsg']));
				}
			}

		}


		$this->dexit(array('error' => 1, 'msg' => '更改库存失败！'));
	}

	public function wxCardQrCodeTicket()
	{
		$id = intval(trim($_POST['cdid']));
		$wxcouponDb = M('cashier_wxcoupon');
		$cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');

		if (!empty($cardinfo) && !empty($cardinfo['cardurl'])) {
			$this->dexit(array('error' => 0, 'msg' => $id));
		}
		 else if (!empty($cardinfo)) {
			$postwxJsonstr = '{"action_name":"QR_CARD","action_info":{"card": {"card_id":"' . $cardinfo['card_id'] . '","is_unique_code": false ,"outer_id" : ' . $this->storeid . '}}}';
			$rets = $this->wxCardPack->wxCardQrCodeTicket($this->access_token, $postwxJsonstr);

			if (isset($rets['errcode']) && ($rets['errcode'] == 0)) {
				$wxcouponDb->update(array('cardticket' => $rets['ticket'], 'cardurl' => $rets['url']), array('id' => $cardinfo['id'], 'mid' => $this->mid));
				$this->dexit(array('error' => 0, 'msg' => $id));
			}
			 else {
				$tmpmsg = ((isset($rets['errcode']) ? $rets['errcode'] : ''));
				isset($rets['errmsg']) && ($tmpmsg = $tmpmsg . '：' . $rets['errmsg']);

				if (!empty($tmpmsg)) {
					$this->dexit(array('error' => 1, 'msg' => $tmpmsg));
				}


				$this->dexit(array('error' => 1, 'msg' => '二维码生成失败！'));
			}
		}


		$this->dexit(array('error' => 1, 'msg' => '卡券不存在，不可删除！'));
	}

	public function bonus()
	{
		$id = ((isset($_GET['id']) ? intval($_GET['id']) : 0));
		$receive = M('cashier_wxcoupon_receive')->get_one(array('outerid' => $this->mid, 'id' => $id, 'cardtype' => 5), '*');

		if (empty($receive)) {
			$this->errorTip('不存在的会员记录');
		}


		bpBase::loadOrg('common_page');
		$where = array('code' => $receive['cardcode'], 'card_id' => $receive['cardid']);
		$cardbonusDB = M('cashier_card_bonus');
		$_count = $cardbonusDB->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$bonus_list = $cardbonusDB->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');
		include $this->showTpl();
	}

	public function paycell()
	{
		$id = ((isset($_GET['id']) ? intval($_GET['id']) : 0));
		$receive = M('cashier_wxcoupon_receive')->get_one(array('outerid' => $this->mid, 'id' => $id, 'cardtype' => 5), '*');

		if (empty($receive)) {
			$this->errorTip('不存在的会员记录');
		}


		bpBase::loadOrg('common_page');
		$where = array('code' => $receive['cardcode'], 'card_id' => $receive['cardid']);
		$paycellDB = M('cashier_pay_cell');
		$_count = $paycellDB->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$paycell_list = $paycellDB->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');
		include $this->showTpl();
	}
}


?>