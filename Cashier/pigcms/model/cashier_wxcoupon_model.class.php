<?php

bpBase::loadSysClass('model', '', 0);
class cashier_wxcoupon_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_wxcoupon';
		parent::__construct();
	}

	public function cardbonus($data)
	{
		if (!isset($data['openid']) || !isset($data['price']) || !isset($data['msg']) || empty($data['openid'])) {
			return array('errcode' => 1, 'errmsg' => '参数有误');
		}


		$openid = $data['openid'];
		$price = $data['price'];
		$msg = $data['msg'];
		$fromid = $data['fromid'];

		if ($result = M('cashier_wxcoupon_receive')->get_one(array('openid' => $openid, 'cardtype' => 5), '*')) {
			if ($wxcoupon = $this->get_one(array('card_id' => $result['cardid'], 'card_type' => 5, 'isdel' => 0), '*')) {
				$expand = unserialize($wxcoupon['kqexpand']);

				if (isset($expand['bonus_rule']['cost_money_unit']) && $expand['bonus_rule']['cost_money_unit'] && isset($expand['bonus_rule']['increase_bonus']) && $expand['bonus_rule']['increase_bonus']) {
					$cost_money_unit = $expand['bonus_rule']['cost_money_unit'];
					$increase_bonus = $expand['bonus_rule']['increase_bonus'];
					$add_bonus = floor(($price * 100) / $cost_money_unit) * $increase_bonus;
					$jsonData = '{"code": "' . $result['cardcode'] . '","card_id":"' . $result['cardid'] . '","record_bonus": "' . $msg . '","add_bonus": ' . $add_bonus . '}';
					bpBase::loadOrg('wxCardPack');
					$wx_user = M('cashier_payconfig')->get_wx_info($wxcoupon['mid']);
					$wxCardPack = new wxCardPack($wx_user, $wxcoupon['mid']);
					$access_token = $wxCardPack->getToken();
					$res = $wxCardPack->UpdateUserCard($access_token, $jsonData);

					if (empty($res['errcode'])) {
						M('cashier_card_bonus')->insert(array('code' => $result['cardcode'], 'card_id' => $result['cardid'], 'fromid' => $fromid, 'openid' => $openid, 'record_bonus' => $msg, 'add_bonus' => $add_bonus, 'create_time' => time()));
					}


					return $res;
				}


				return array('errcode' => 1, 'errmsg' => '该粉丝领取商家的会员卡不支持积分');
			}


			return array('errcode' => 1, 'errmsg' => '该粉丝领取商家的会员卡不是商家在本平台创建的会员卡');
		}


		return array('errcode' => 1, 'errmsg' => '该粉丝还没有领取商家的会员卡');
	}
}


?>