<?php

bpBase::loadAppClass('common', 'User', 0);

class wxCoupon_controller extends common_controller {

    private $wxCardPack;
    private $access_token;
    private $card_type;
    private $appid = '';

    public function __construct() {
        parent::__construct();
        bpBase::loadOrg('checkFunc');
        $checkFunc = new checkFunc();
        if (!function_exists('dsbig3joishdgfhg798rqw4fqnkhffq')) {
            exit('error-4');
        }
        $checkFunc->cfdwdgfds3skgfds3szsd3idsj();
        $this->authorityControl(array('cardetail', 'wxCardQrCodeTicket', 'qrcode', 'uploadImg', 'ArrayToJsonstr', 'FiltrationData', 'updateMname', 'testUpdateCard','setActivateUserForm','cardactive','setPayCell','membercardinfo'));
        bpBase::loadOrg('wxCardPack');
        $wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
        if (isset($wx_user['submchinfo']) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret']) &&($wx_user['submchinfo']['mid'] == $this->mid)) {
			
            $wx_user = $wx_user['submchinfo'];
        }
        $this->appid = $wx_user['appid'];
        $this->wxCardPack = new wxCardPack($wx_user, $this->mid);
        $this->access_token = $this->wxCardPack->getToken();
        $this->card_type = array(0 => array('enname' => 'GENERAL_COUPON', 'zhname' => '优惠券'), 1 => array('enname' => 'GROUPON', 'zhname' => '团购券'), 2 => array('enname' => 'DISCOUNT', 'zhname' => '折扣券'), 3 => array('enname' => 'GIFT', 'zhname' => '礼品券'), 4 => array('enname' => 'CASH', 'zhname' => '代金券'), 5 => array('enname' => 'MEMBER_CARD', 'zhname' => '会员卡'));
    }

    public function index() {
        bpBase::loadOrg('common_page');
        $wxcouponDb = M('cashier_wxcoupon');
        $where = " mid={$this->mid} AND isdel=0 AND card_type<5"; //array('mid' => $this->mid, 'isdel' => '0', 'card_type' =>);
        if ($this->storeid > 0) {
            $where = $where . ' AND storeid=' . $this->storeid;
        }
        $_count = $wxcouponDb->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $wxcoupons = $wxcouponDb->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');
        foreach ($wxcoupons as $kk => $vv) {
            unset($wxcoupons[$kk]['kqcontent'], $wxcoupons[$kk]['kqexpand']);
            if (!($vv['istowx'] > 0)) {
                $wxcoupons[$kk]['statusstr'] = "<font color='#FC5702'>不需审核</font>";
            } elseif ($vv['status'] == 0) {
                $wxcoupons[$kk]['statusstr'] = "<font>审核中</font>";
            } elseif ($vv['status'] == 1) {
                $wxcoupons[$kk]['statusstr'] = "<font color='green'>已审核</font>";
            } elseif ($vv['status'] == 2) {
                $wxcoupons[$kk]['statusstr'] = "<font color='red'>未通过</font>";
            } else {
                $wxcoupons[$kk]['statusstr'] = "待定";
            }
        }
        include $this->showTpl();
    }

    /*     * **卡券领取列表**** */

    public function wxReceiveList() {
        bpBase::loadOrg('common_page');
        $wxcouponReceiveDb = M('cashier_wxcoupon_receive');
        //$where = array('outerid' => $this->mid);
        $cardid = trim($_GET['cardid']);
        $where = 'outerid=' . $this->mid . ' AND cardtype<5';
        if (!empty($cardid)) {
            $where = $where . ' AND cardid="' . $cardid . '"';
        }
        if ($this->storeid > 0) {
            $where = $where . ' AND storeid=' . $this->storeid;
        }
        $_count = $wxcouponReceiveDb->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $db_config = loadConfig('db');
        $tablepre = $db_config['default']['tablepre'];
        $sqlStr = 'SELECT DISTINCT wxr.id,wxr.*,cf.nickname FROM ' . $tablepre . 'cashier_wxcoupon_receive as wxr LEFT JOIN ' . $tablepre . 'cashier_fans AS cf ON wxr.openid=cf.openid where wxr.outerid=' . $this->mid . ' AND cf.mid=' . $this->mid;
        if (!empty($cardid)) {
            $sqlStr = $sqlStr . ' AND wxr.cardid="' . $cardid . '"';
        }
        if ($this->storeid > 0) {
            $sqlStr = $sqlStr . ' AND wxr.storeid=' . $this->storeid . ' AND wxr.status=1';
        }
        $sqlStr = $sqlStr . ' AND wxr.cardtype < 5 ORDER BY wxr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
        $sqlObj = new model();
        $wxReceiveUser = $sqlObj->selectBySql($sqlStr);
        include $this->showTpl();
    }

    public function createKq() {
        //if ($this->merchant['apply'] != 0 && $this->merchant['apply'] != 3) $this->errorTip("您暂时还能创建卡券");
        $datestart = date('Y-m-d');
        $dateend = date('Y-m-d', strtotime('+1 month'));
        $typeid = intval($_GET['typeid']);
        $istowx = intval($_GET['iswx']);
        $istowxFlage = $istowx > 0 ? 3 : 'nogo';
        $wxcouponSet = M('cashier_wxcoupon_common')->get_one(array('mid' => $this->mid), '*');
        //$shoplist = unserialize($_SESSION['wxshoplist']);
        if (!is_array($shoplist) || empty($shoplist)) {
            //$wxShoplist = $this->wxCardPack->wxGetPoiList($this->access_token);
            if ($this->storeid > 0) {
                $wherearr = array('id' => $this->storeid, 'mid' => $this->mid, 'appid' => $this->appid);
            } else {
                $wherearr = array('mid' => $this->mid, 'appid' => $this->appid);
            }
            $wxShoplist = M('cashier_stores')->GetStores($wherearr, $istowxFlage);
            $shoplist = $tmpstore = array();
            if (!empty($wxShoplist)) {
                foreach ($wxShoplist as $kk => $vv) {
                    if (($istowx > 0) && empty($vv['poi_id'])) {
                        continue;
                    }
                    $shoplist[$vv['id']] = array(
                        'id' => $vv['id'],
                        'sid' => $this->mid,
                        'business_name' => $vv['business_name'],
                        'branch_name' => $vv['branch_name'],
                        'poi_id' => $vv['poi_id'],
                        'address' => $vv['address']
                    );
                }
            }
            if (!empty($wxShoplist)) {
                $_SESSION['wxshoplist'] = serialize($shoplist);
            }
        }
        $wxCardColor = $this->wxCardPack->wxCardColor($this->access_token);
        include $this->showTpl();
    }

    public function docreateKq() {
        //if ($this->merchant['apply'] != 0 && $this->merchant['apply'] != 0) $this->dexit(array('error' => 1, 'msg' => '您暂时还能创建卡券'));
        $localArr = array();
        $card_type = array(0 => 'GENERAL_COUPON', 1 => 'GROUPON', 2 => 'DISCOUNT', 3 => 'GIFT', 4 => 'CASH', 5 => 'MEMBER_CARD');
        $datas = $this->clear_html($_POST);
        $type = intval($_POST['ctype']);
        $istowx = isset($_POST['istowx']) ? intval($_POST['istowx']) : 1; /*         * 1同步微信0不同步*** */
        $card_typestr = $card_type[$type];
        $keycard_type = strtolower($card_typestr);
        $wxJsonstr['card'] = array('card_type' => $card_typestr, $keycard_type => array());
        $base_info = $datas['base_info'];
        unset($datas['base_info']);
        $base_info['code_type'] = 'CODE_TYPE_QRCODE';
        $base_info['get_limit'] = intval($base_info['get_limit']);
        !($base_info['get_limit'] > 0) && $base_info['get_limit'] = 1;
        $begin_timestamp = empty($datas['datestart']) ? strtotime(date('Y-m-d')) : strtotime($datas['datestart']);
        $end_timestamp = empty($datas['dateend']) ? (strtotime(date('Y-m-d')) + 30 * 24 * 3600) : strtotime($datas['dateend']);
        $base_info['date_info'] = array("type" => "DATE_TYPE_FIX_TIME_RANGE", 'begin_timestamp' => $begin_timestamp, 'end_timestamp' => $end_timestamp);

        $base_info['sku'] = array('quantity' => intval($datas['quantity']));
        $base_info['use_custom_code'] = false;
        $base_info['bind_openid'] = false;
        $base_info['can_share'] = isset($base_info['can_share']) && !empty($base_info['can_share']) ? true : false;
        $base_info['can_give_friend'] = isset($base_info['can_give_friend']) && !empty($base_info['can_give_friend']) ? true : false;
        $base_info['location_id_list'] = !empty($datas['inputpoiid']) ? 'Jsarray[' . implode(',', array_filter($datas['inputpoiid'])) . ']' : 'Jsarray[0]';
        /* $base_info['source'] = '小猪科技'; */
        $this->FiltrationData($base_info);
        if (empty($datas['inputpoiid'])) {
            $this->dexit(array('error' => 1, 'msg' => '您还没有选择适用门店！'));
        }

		$localArr = array('mid' => $this->mid, 'card_type' => $type, 'card_title' => $base_info['title'], 'begin_timestamp' => $begin_timestamp, 'end_timestamp' => $end_timestamp, 'poi_ids' => !empty($datas['inputpoiid']) ? implode(',', array_filter($datas['inputpoiid'])) : '');
        $store_ids = is_array($datas['inputpoiid']) ? array_keys($datas['inputpoiid']):false;
        $localArr['store_ids'] = is_array($store_ids) ? implode(',', $store_ids) : '';
        if (!($istowx > 0)) {
            $localArr['istowx'] = 0;
        }

        if (!empty($base_info['custom_url']) && strpos($base_info['custom_url'], "http:") === false && strpos($base_info['custom_url'], "https:") === false) {
            $base_info['custom_url'] = 'http://' . $base_info['custom_url'];
        }
        if (!empty($base_info['promotion_url']) && strpos($base_info['promotion_url'], "http:") === false && strpos($base_info['promotion_url'], "https:") === false) {
            $base_info['promotion_url'] = 'http://' . $base_info['promotion_url'];
        }
        //if ($this->merchant['apply']) {
        //$sub_merchant = M('cashier_sub_merchant')->get_one(array('mid' => $this->mid), '*');
        //$base_info['sub_merchant_info'] = array('merchant_id' => $sub_merchant['merchant_id']);
        //}
        $postwxJsonstr = '';
        $store_update = array();
        switch ($type) {
            case '0':
                if (empty($datas['default_detail'])) {
                    $this->dexit(array('error' => 1, 'msg' => '优惠详情须填写'));
                }
                $localArr['quantity'] = $base_info['sku']['quantity'];
                $localArr['get_limit'] = $base_info['get_limit'];
                $localArr['kqcontent'] = serialize($base_info);
                $localArr['kqexpand'] = serialize(array('content' => $datas['default_detail']));
                $wxJsonstr['card'][$keycard_type]['base_info'] = $base_info;
                $wxJsonstr['card'][$keycard_type]['default_detail'] = $datas['default_detail'];
                $postwxJsonstr = $this->ArrayToJsonstr($wxJsonstr);
                break;
            case '1':
                if (empty($datas['deal_detail'])) {
                    $this->dexit(array('error' => 1, 'msg' => '优惠详情须填写'));
                }
                $localArr['quantity'] = $base_info['sku']['quantity'];
                $localArr['get_limit'] = $base_info['get_limit'];
                $localArr['kqcontent'] = serialize($base_info);
                $localArr['kqexpand'] = serialize(array('content' => $datas['deal_detail']));
                $wxJsonstr['card'][$keycard_type]['base_info'] = $base_info;
                $wxJsonstr['card'][$keycard_type]['deal_detail'] = $datas['deal_detail'];
                $postwxJsonstr = $this->ArrayToJsonstr($wxJsonstr);
                break;
            case '2':
                if (empty($datas['discount']) || ($datas['discount'] < 1) || ($datas['discount'] >= 10)) {
                    $this->dexit(array('error' => 1, 'msg' => '折扣额度只能是大于1且小于10的数字'));
                }
                $store_update['discount'] = $datas['discount'];
                $localArr['quantity'] = $base_info['sku']['quantity'];
                $localArr['get_limit'] = $base_info['get_limit'];
                $localArr['kqcontent'] = serialize($base_info);
                $localArr['kqexpand'] = serialize(array('discount' => $datas['discount']));
                $wxJsonstr['card'][$keycard_type]['base_info'] = $base_info;
                $wxJsonstr['card'][$keycard_type]['discount'] = 100 - ($datas['discount'] * 10);
                $postwxJsonstr = $this->ArrayToJsonstr($wxJsonstr);
                break;
            case '3':
                if (empty($datas['gift'])) {
                    $this->dexit(array('error' => 1, 'msg' => '优惠详情须填写'));
                }
                $localArr['quantity'] = $base_info['sku']['quantity'];
                $localArr['get_limit'] = $base_info['get_limit'];
                $localArr['kqcontent'] = serialize($base_info);
                $localArr['kqexpand'] = serialize(array('content' => $datas['gift']));
                $wxJsonstr['card'][$keycard_type]['base_info'] = $base_info;
                $wxJsonstr['card'][$keycard_type]['gift'] = $datas['gift'];
                $postwxJsonstr = $this->ArrayToJsonstr($wxJsonstr);
                break;
            case '4':
                if (empty($datas['reduce_cost']) || !($datas['reduce_cost'] > 0.01)) {
                    $this->dexit(array('error' => 1, 'msg' => '减免金额必须填写一个大于0.01的数字'));
                }
                $wxJsonstr['card'][$keycard_type]['reduce_cost'] = intval($datas['reduce_cost'] * 100);
                if (empty($datas['least_cost']) || !($datas['least_cost'] > 0.01)) {
                    $wxJsonstr['card'][$keycard_type]['least_cost'] = 0;
                    $datas['least_cost'] = 0;
                } else {
                    $wxJsonstr['card'][$keycard_type]['least_cost'] = intval($datas['least_cost'] * 100);
                }
                $store_update['reduce_cost'] = $datas['reduce_cost'];
                $store_update['least_cost'] = $datas['least_cost'];

                $localArr['quantity'] = $base_info['sku']['quantity'];
                $localArr['get_limit'] = $base_info['get_limit'];
                $localArr['kqcontent'] = serialize($base_info);
                $localArr['kqexpand'] = serialize(array('reduce_cost' => $datas['reduce_cost'], 'least_cost' => $datas['least_cost']));
                $wxJsonstr['card'][$keycard_type]['base_info'] = $base_info;
                $postwxJsonstr = $this->ArrayToJsonstr($wxJsonstr);
                break;
            case '5':
                if (empty($datas['prerogative'])) {
                    $this->dexit(array('error' => 1, 'msg' => '特权说明须填写'));
                }
                $discount = intval($datas['discount']);
                if ($discount < 0 || $discount > 100)
                    $this->dexit(array('error' => 1, 'msg' => '折扣应该在0~100之间的整数'));
                $discount && $wxJsonstr['card'][$keycard_type]['discount'] = $discount;
                $store_update['discount'] = (100 - $discount) / 10;
//                 $wxJsonstr['card'][$keycard_type]['custom_field1'] = array("name_type" => "FIELD_NAME_TYPE_LEVEL");
//                 $wxJsonstr['card'][$keycard_type]['custom_field2'] = array("name_type" => "FIELD_NAME_TYPE_COUPON");

                if ($datas['date_type'] == 'DATE_TYPE_PERMANENT') {
                    $base_info['date_info'] = array("type" => "DATE_TYPE_PERMANENT");
                    $localArr['begin_timestamp'] = $localArr['end_timestamp'] = 0;
                }
                $wxJsonstr['card'][$keycard_type]['prerogative'] = $datas['prerogative'];

                $localArr['activate'] = $datas['activate'];
                if ($datas['activate'] == 0) {
                    $wxJsonstr['card'][$keycard_type]['auto_activate'] = true; //自动激活
                } elseif ($datas['activate'] == 1) {
                    $wxJsonstr['card'][$keycard_type]['wx_activate'] = true; //一键激活
                } else {
                    $wxJsonstr['card'][$keycard_type]['auto_activate'] = true; //自动激活  其他情况也设置成自动激活 实际是手动激活
                    //$wxJsonstr['card'][$keycard_type]['activate_url'] = true;//手动激活
                }


                //储值显示
                $wxJsonstr['card'][$keycard_type]['supply_balance'] = false;
                if ($datas['supply_balance']) {
                    if (!empty($datas['balance_url']) && strpos($datas['balance_url'], "http:") === false && strpos($datas['balance_url'], "https:") === false) {
                        $datas['balance_url'] = 'http://' . $datas['balance_url'];
                    }
                    $wxJsonstr['card'][$keycard_type]['supply_balance'] = true;
                    $wxJsonstr['card'][$keycard_type]['balance_url'] = $datas['balance_url'];
                    $wxJsonstr['card'][$keycard_type]['balance_rules'] = $datas['balance_rules'];
                }

                //积分显示
                $wxJsonstr['card'][$keycard_type]['supply_bonus'] = false;
                if ($datas['supply_bonus']) {
                    if (!empty($datas['bonus_url']) && strpos($datas['bonus_url'], "http:") === false && strpos($datas['bonus_url'], "https:") === false) {
                        $datas['bonus_url'] = 'http://' . $datas['bonus_url'];
                    }
                    $wxJsonstr['card'][$keycard_type]['supply_bonus'] = true;
                    $wxJsonstr['card'][$keycard_type]['bonus_url'] = $datas['bonus_url'];
                    $wxJsonstr['card'][$keycard_type]['bonus_rules'] = $datas['bonus_rules'];
                    //$wxJsonstr['card'][$keycard_type]['bonus_cleared'] = $datas['bonus_cleared'];
                    if (empty($datas['bonus_rule']['cost_money_unit']) || $datas['bonus_rule']['cost_money_unit'] < 1) {
                        $this->dexit(array('error' => 1, 'msg' => '消费金额必须大于等于1的整数'));
                    }
                    if (empty($datas['bonus_rule']['increase_bonus']) || $datas['bonus_rule']['increase_bonus'] < 1) {
                        $this->dexit(array('error' => 1, 'msg' => '增加的积分必须大于等于1的整数'));
                    }
                    if (empty($datas['bonus_rule']['max_increase_bonus']) || $datas['bonus_rule']['max_increase_bonus'] < 1) {
                        $this->dexit(array('error' => 1, 'msg' => '积分上限必须大于等于1的整数'));
                    }
                    if ($datas['bonus_rule']['init_increase_bonus'] < 0) {
                        $this->dexit(array('error' => 1, 'msg' => '初始积分必须大于等于0的整数'));
                    }
                    if (empty($datas['bonus_rule']['cost_bonus_unit']) || $datas['bonus_rule']['cost_bonus_unit'] < 1) {
                        $this->dexit(array('error' => 1, 'msg' => '积分抵扣中的积分应该是大于等于一的整数'));
                    }

                    if (empty($datas['bonus_rule']['reduce_money']) || $datas['bonus_rule']['reduce_money'] < 0) {
                        $this->dexit(array('error' => 1, 'msg' => '积分抵扣中的金额大于0且只能是两位小数的数字'));
                    }
                    $wxJsonstr['card'][$keycard_type]['bonus_rule'] = array('cost_money_unit' => intval($datas['bonus_rule']['cost_money_unit']),
                        'increase_bonus' => intval($datas['bonus_rule']['increase_bonus']),
                        'max_increase_bonus' => intval($datas['bonus_rule']['max_increase_bonus']),
                        'init_increase_bonus' => intval($datas['bonus_rule']['init_increase_bonus']),
                        'cost_bonus_unit' => intval($datas['bonus_rule']['cost_bonus_unit']),
                        'reduce_money' => $datas['bonus_rule']['reduce_money'],
// 					'least_money_to_use_bonus' => $datas['bonus_rule']['least_money_to_use_bonus'], 
// 					'max_reduce_bonus' => intval($datas['bonus_rule']['max_reduce_bonus'])
                    );

                    if ($datas['bonus_rule']['least_money_to_use_bonus'] && intval($datas['bonus_rule']['max_reduce_bonus'])) {
                        $wxJsonstr['card'][$keycard_type]['bonus_rule']['least_money_to_use_bonus'] = $datas['bonus_rule']['least_money_to_use_bonus'];
                        $wxJsonstr['card'][$keycard_type]['bonus_rule']['max_reduce_bonus'] = intval($datas['bonus_rule']['max_reduce_bonus']);
                    }
                }

                if (!empty($datas['custom_cell1']['url']) && strpos($datas['custom_cell1']['url'], "http:") === false && strpos($datas['custom_cell1']['url'], "https:") === false) {
                    $datas['custom_cell1']['url'] = 'http://' . $datas['custom_cell1']['url'];
                }
                $wxJsonstr['card'][$keycard_type]['custom_cell1'] = $datas['custom_cell1'];

                $localArr['quantity'] = $base_info['sku']['quantity'];
                $localArr['get_limit'] = $base_info['get_limit'];
                $localArr['kqcontent'] = serialize($base_info);
                $localArr['kqexpand'] = serialize($wxJsonstr['card'][$keycard_type]);
                $localArr['appid'] = $this->appid;
                $wxJsonstr['card'][$keycard_type]['base_info'] = $base_info;
                $postwxJsonstr = $this->ArrayToJsonstr($wxJsonstr);
                break;
            default:
                break;
        }
        if (!($istowx > 0) && ($localArr['card_type'] != 5)) {
            $wxcouponDb = M('cashier_wxcoupon');
            $localArr['card_id'] = 'localCard_id';
            $localArr['addtime'] = time();
			if(!empty($store_update) && !empty($localArr['store_ids'])){ 
				M('cashier_stores')->updateDiscount($store_update, $localArr['store_ids'], $this->mid,true);
				}
            !empty($this->extraInsertData) && $localArr = array_merge($this->extraInsertData, $localArr);
            $wxcoupon_id = $wxcouponDb->insert($localArr, True);
            $this->updateMname($base_info['brand_name'], $base_info['logo_url']);
            $this->dexit(array('error' => 0, 'msg' => 'OK'));
            exit();
        }
        $rets = $this->wxCardPack->wxCardCreated($this->access_token, $postwxJsonstr);
        if (isset($rets['card_id']) && !empty($rets['card_id'])) {
            //$store_update && M('cashier_stores')->updateDiscount($store_update, explode(',', $localArr['poi_ids']), $this->mid);
            $wxcouponDb = M('cashier_wxcoupon');
            $localArr['card_id'] = trim($rets['card_id']);
            $localArr['addtime'] = time();
            !empty($this->extraInsertData) && $localArr = array_merge($this->extraInsertData, $localArr);
            $wxcoupon_id = $wxcouponDb->insert($localArr, True);
            if ($localArr['card_type'] == 5 && $wxcoupon_id) {
                $list = $wxcouponDb->select('isdel=0 and card_type=5 and id<>' . $wxcoupon_id);
                foreach ($list as $l) {
                    $rets = $this->wxCardPack->wxCardDelete($this->access_token, '{"card_id":"' . $l['card_id'] . '"}');
                    if (isset($rets['errcode']) && ($rets['errcode'] == 0)) {
                        $wxcouponDb->update(array('isdel' => 1), array('id' => $l['id'], 'mid' => $this->mid));
                        //$this->dexit(array('error' => 0, 'msg' => '卡券删除成功！'));
                    }
                }
            }
            $this->updateMname($base_info['brand_name'], $base_info['logo_url']);
            $this->dexit(array('error' => 0, 'msg' => 'OK'));
        } else {
            $tmpmsg = isset($rets['errcode']) ? $rets['errcode'] : '';
            isset($rets['errmsg']) && $tmpmsg = $tmpmsg . "：" . $rets['errmsg'];
            if (!empty($tmpmsg)) {
                $this->dexit(array('error' => 1, 'msg' => $tmpmsg));
            }
        }
        $this->dexit(array('error' => 1, 'msg' => '数据保存失败！'));
    }

    /*     * **详情页**** */

    public function cardetail() {
        $id = intval(trim($_GET['id']));
        $cardinfo = M('cashier_wxcoupon')->get_one(array('id' => $id, 'mid' => $this->mid), '*');
        if (empty($cardinfo)) {
            $this->errorTip('您所查看的卡券不存在', $_SERVER['HTTP_REFERER']);
            exit;
        }
        $kqcontent = unserialize($cardinfo['kqcontent']);
        unset($cardinfo['kqcontent']);
        !empty($cardinfo['kqexpand']) && $cardinfo['kqexpand'] = unserialize($cardinfo['kqexpand']);
//        echo "<pre/>";
//        print_r($kqcontent);
//        print_r($cardinfo);
//        die;
        $mset = M('cashier_wxcoupon_common')->get_one(array('mid' => $this->mid), '*');
        $kqcontent['location_id_list'] = str_replace('Jsarray[', '', str_replace(']', '', $kqcontent['location_id_list']));
        if (empty($kqcontent['location_id_list']) || $kqcontent['location_id_list'] == '0') {
            $kqcontent['shop_id_count'] = 0;
        } else {
            $kqcontent['location_id_list'] = explode(',', $kqcontent['location_id_list']);
            $kqcontent['shop_id_count'] = count($kqcontent['location_id_list']);
        }
        $wxCardColor = $this->wxCardPack->wxCardColor($this->access_token);
        foreach ($wxCardColor as $cvv) {
            if ($kqcontent['color'] == $cvv['name']) {
                $kqcontent['colorV'] = $cvv['value'];
                break;
            }
        }
        //$shoplist=unserialize($_SESSION['wxshoplist']);
        $istowxFlage = $cardinfo['istowx'] > 0 ? 3 : 'nogo';
        if (!is_array($shoplist) || empty($shoplist)) {
            if ($this->storeid > 0) {
                $wherearr = array('id' => $this->storeid, 'mid' => $this->mid, 'appid' => $this->appid);
            } else {
                $wherearr = array('mid' => $this->mid, 'appid' => $this->appid);
            }
            $wxShoplist = M('cashier_stores')->GetStores($wherearr, $istowxFlage);

            $shoplist = $location_id_list = array();
            if (!empty($wxShoplist)) {
                foreach ($wxShoplist as $kk => $vv) {
                    if (($cardinfo['istowx'] > 0) && empty($vv['poi_id'])) {
                        continue;
                    }
                    if (!empty($kqcontent['location_id_list']) && in_array($vv['poi_id'], $kqcontent['location_id_list'])) {
                        $location_id_list[] = $vv['id'];
                    }
                    $shoplist[$vv['id']] = array(
                        'id' => $vv['id'],
                        'sid' => $vv['sid'],
                        'business_name' => $vv['business_name'],
                        'branch_name' => $vv['branch_name'],
                        'poi_id' => $vv['poi_id'],
                        'address' => $vv['address']
                    );
                }
            }
            if (!($cardinfo['istowx'] > 0)) {
                $locaArrShop = explode(',', $cardinfo['store_ids']);
                $location_id_list = array_merge($location_id_list, $locaArrShop);
            }
            $kqcontent['location_id_list'] = array_unique($location_id_list);
            unset($location_id_list, $locaArrShop);
            if (!empty($wxShoplist)) {
                $_SESSION['wxshoplist'] = serialize($shoplist);
            }
        }
        include $this->showTpl();
    }

    /*     * **删除卡券*** */

    public function delCardByid() {
        $id = intval(trim($_POST['cdid']));
        $wxcouponDb = M('cashier_wxcoupon');
        $cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');
        if (!empty($cardinfo) && !empty($cardinfo['card_id'])) {
			if($cardinfo['card_id']=='localCard_id'){
			   $wxcouponDb->delete(array('id'=>$id,'mid'=>$this->mid));
			   $this->dexit(array('error' => 0, 'msg' => '卡券删除成功！'));
			}
            $rets = $this->wxCardPack->wxCardDelete($this->access_token, '{"card_id":"' . $cardinfo['card_id'] . '"}');
            if (isset($rets['errcode']) && ($rets['errcode'] == 0)) {
                //$wxcouponDb->delete(array('id'=>$id,'mid'=>$this->mid));
                $wxcouponDb->update(array('isdel' => 1), array('id' => $id, 'mid' => $this->mid));
                $this->dexit(array('error' => 0, 'msg' => '卡券删除成功！'));
            } else {
                $tmpmsg = isset($rets['errcode']) ? $rets['errcode'] : '';
                isset($rets['errmsg']) && $tmpmsg = $tmpmsg . "：" . $rets['errmsg'];
                if (!empty($tmpmsg)) {
                    $this->dexit(array('error' => 1, 'msg' => $tmpmsg));
                }
                $this->dexit(array('error' => 1, 'msg' => '删除失败！'));
            }
        }
        $this->dexit(array('error' => 1, 'msg' => '卡券不存在，不可删除！'));
    }

    public function membercardinfo() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if ($id) {
            $card = M('cashier_wxcoupon_receive')->get_one(array('outerid' => $this->mid, 'id' => $id, 'cardtype' => 5), '*');
        }
        if (empty($card))
            $this->dexit(array('errcode' => 1, 'errmsg' => '不存在的会员卡信息'));
        $res = $this->wxCardPack->MemberCardUserInfo($this->access_token, json_encode(array('card_id' => $card['cardid'], 'code' => $card['cardcode'])));
        if ($res['errcode'])
            $this->dexit($res);
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
        $data[] = array('title' => '性别', 'value' => $res['sex'] == 'MALE' ? '男' : '女');

        if (isset($res['user_info']['common_field_list']) && $res['user_info']['common_field_list']) {
            foreach ($res['user_info']['common_field_list'] as $row) {
                $data[] = array('title' => $key_val[$row['name']], 'value' => $row['value']);
            }
        }

        if (isset($res['user_info']['custom_field_list']) && $res['user_info']['custom_field_list']) {
            foreach ($res['user_info']['custom_field_list'] as $row) {
                $data[] = array('title' => $row['name'], 'value' => $row['value']);
            }
        }
        $status = array('NORMAL' => '正常', 'EXPIRE' => '已过期', 'GIFTING' => '转赠中', 'GIFT_SUCC' => '转赠成功', 'GIFT_TIMEOUT' => '转赠超时', 'DELETE' => '已删除', 'UNAVAILABLE' => '已失效');
        $data[] = array('title' => '状态', 'value' => $status[$res['user_card_status']]);
        $this->dexit(array('errcode' => 0, 'data' => $data));
    }

    //会员卡列表页
    public function cardindex() {
        bpBase::loadOrg('common_page');
// 		$res = $this->wxCardPack->GetApplyProtocol($this->access_token);
// 		echo "<pre/>";
// 		print_r($res);die;

        $wxcouponDb = M('cashier_wxcoupon');
        $where = array('mid' => $this->mid, 'isdel' => '0', 'card_type' => '5');
        if ($this->storeid > 0) {
            $where['storeid'] = $this->storeid;
        }
        $_count = $wxcouponDb->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $wxcoupons = $wxcouponDb->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');
        foreach ($wxcoupons as $kk => $vv) {
            unset($wxcoupons[$kk]['kqcontent'], $wxcoupons[$kk]['kqexpand']);
            if ($vv['status'] == 0) {
                $wxcoupons[$kk]['statusstr'] = "<font>审核中</font>";
            } elseif ($vv['status'] == 1) {
                $wxcoupons[$kk]['statusstr'] = "<font color='green'>已审核</font>";
            } elseif ($vv['status'] == 2) {
                $wxcoupons[$kk]['statusstr'] = "<font color='red'>未通过</font>";
            } else {
                $wxcoupons[$kk]['statusstr'] = "待定";
            }
        }
        include $this->showTpl();
    }

    public function card() {
        //if ($this->merchant['apply'] != 0) $this->errorTip("您没有创建会员卡的权限");

        $wxcouponDb = M('cashier_wxcoupon');
        $where = array('mid' => $this->mid, 'isdel' => '0', 'card_type' => '5');
        $_count = $wxcouponDb->count($where);

        $datestart = date('Y-m-d');
        $dateend = date('Y-m-d', strtotime('+1 month'));
        $typeid = 5;
        $wxcouponSet = M('cashier_wxcoupon_common')->get_one(array('mid' => $this->mid), '*');
        $shoplist = unserialize($_SESSION['wxshoplist']);
        if (!is_array($shoplist) || empty($shoplist)) {
            if ($this->storeid > 0) {
                $wherearr = array('id' => $this->storeid, 'mid' => $this->mid, 'appid' => $this->appid);
            } else {
                $wherearr = array('mid' => $this->mid, 'appid' => $this->appid);
            }
            $wxShoplist = M('cashier_stores')->GetStores($wherearr);

            $shoplist = array();
            if (!empty($wxShoplist)) {
                foreach ($wxShoplist as $kk => $vv) {

                    $shoplist[$vv['poi_id']] = array(
                        'sid' => $this->mid,
                        'business_name' => $vv['business_name'],
                        'branch_name' => $vv['branch_name'],
                        'poi_id' => $vv['poi_id'],
                        'address' => $vv['address']
                    );
                }
            }
            if (!empty($wxShoplist)) {
                $_SESSION['wxshoplist'] = serialize($shoplist);
            }
        }
        $wxCardColor = $this->wxCardPack->wxCardColor($this->access_token);
        include $this->showTpl();
    }

    /*     * **卡券领取列表**** */

    public function wxCardList() {
        bpBase::loadOrg('common_page');

        $cardid = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $card = null;
        if ($cardid) {
            $card = M('cashier_wxcoupon')->get_one(array('mid' => $this->mid, 'id' => $cardid, 'card_type' => 5), '*');
        }

        $where = "outerid={$this->mid} AND cardtype=5";
        $where_sql = "wxr.outerid={$this->mid} AND wxr.cardtype=5";
        if ($card) {
            $where = "outerid={$this->mid} AND cardtype=5 AND cardid='{$card['card_id']}'";
            $where_sql = "wxr.outerid={$this->mid} AND wxr.cardtype=5 AND wxr.cardid='{$card['card_id']}'";
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

    /**
     * 设置会员卡是否支持买单
     */
    public function setPayCell() {
        $id = intval(trim($_POST['id']));
        $wxcouponDb = M('cashier_wxcoupon');
        $cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');
        if (empty($cardinfo))
            $this->dexit(array('errcode' => 1, 'errmsg' => '不存在的会员卡'));
        $is_open = $cardinfo['is_open_cell'] ? false : true;
        $data = array('is_open' => $is_open, 'card_id' => $cardinfo['card_id']);
        $wxCardColor = $this->wxCardPack->PayCell($this->access_token, json_encode($data));
        if (empty($wxCardColor['errcode'])) {
            $wxcouponDb->update(array('is_open_cell' => $is_open ? 1 : 0), array('id' => $id, 'mid' => $this->mid));
        }
        $this->dexit($wxCardColor);
    }

    public function cardactive() {
        $key_val = array();
        //$key_val['USER_FORM_INFO_FLAG_MOBILE'] = '手机号';
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
            exit;
        }

        $activate_user_form = unserialize($cardinfo['activate_user_form']);

        $required_form_id_list = isset($activate_user_form['required_form']['common_field_id_list']) && $activate_user_form['required_form']['common_field_id_list'] ? $activate_user_form['required_form']['common_field_id_list'] : array();
        $optional_form_id_list = isset($activate_user_form['optional_form']['common_field_id_list']) && $activate_user_form['optional_form']['common_field_id_list'] ? $activate_user_form['optional_form']['common_field_id_list'] : array();


        $required_form_custom_field_list = isset($activate_user_form['required_form']['custom_field_list']) && $activate_user_form['required_form']['custom_field_list'] ? implode(',', $activate_user_form['required_form']['custom_field_list']) : '';
        $optional_form_custom_field_list = isset($activate_user_form['optional_form']['custom_field_list']) && $activate_user_form['optional_form']['custom_field_list'] ? implode(',', $activate_user_form['optional_form']['custom_field_list']) : '';
        include $this->showTpl();
    }

    public function setActivateUserForm() {
        $id = intval(trim($_POST['id']));

        $wxcouponDb = M('cashier_wxcoupon');
        $cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');
        if (empty($cardinfo))
            $this->dexit(array('errcode' => 1, 'errmsg' => '不存在的会员卡'));

        $data = array('card_id' => $cardinfo['card_id']);

        if ($_POST['field_list'])
            $data['required_form']['common_field_id_list'] = $_POST['field_list'];
        if ($_POST['custom']) {
            $custom_field_list = str_replace("，", ",", $_POST['custom']);
            $custom_field_list = explode(",", $custom_field_list);
            $data['required_form']['custom_field_list'] = $custom_field_list;
        }

        if ($_POST['sel_field_list'])
            $data['optional_form']['common_field_id_list'] = $_POST['sel_field_list'];
        if ($_POST['custom_sel']) {
            $custom_field_list = str_replace("，", ",", $_POST['custom_sel']);
            $custom_field_list = explode(",", $custom_field_list);
            $data['optional_form']['custom_field_list'] = $custom_field_list;
        }
        $jsondata = '{"card_id":"' . $data['card_id'] . '"';
        if (isset($data['required_form'])) {
            $jsondata .= ', "required_form":{';
            $required_form_common_field_id_list = false;
            if (isset($data['required_form']['common_field_id_list'])) {
                $required_form_common_field_id_list = true;
                $jsondata .= '"common_field_id_list":["USER_FORM_INFO_FLAG_MOBILE"';
                foreach ($data['required_form']['common_field_id_list'] as $v) {
                    $jsondata .= ',"' . $v . '"';
                }
                $jsondata .= ']';
            }

            if (isset($data['required_form']['custom_field_list'])) {
                if ($required_form_common_field_id_list) {
                    $jsondata .= ', "custom_field_list":[';
                } else {
                    $jsondata .= '"custom_field_list":[';
                }

                $pre = '';
                foreach ($data['required_form']['custom_field_list'] as $v) {
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
                foreach ($data['optional_form']['common_field_id_list'] as $v) {
                    $jsondata .= $pre . '"' . $v . '"';
                    $pre = ',';
                }
                $jsondata .= ']';
            }

            if (isset($data['optional_form']['custom_field_list'])) {
                if ($optional_form_common_field_id_list) {
                    $jsondata .= ', "custom_field_list":[';
                } else {
                    $jsondata .= '"custom_field_list":[';
                }

                $pre = '';
                foreach ($data['optional_form']['custom_field_list'] as $v) {
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

    /*     * *******修改库存******* */

    public function ModifyStock() {
        $cdid = trim($_POST['cdid']);
        $id = intval(trim($_POST['id']));
        $qtype = intval(trim($_POST['qtype']));
        $qmun = intval(trim($_POST['qmun']));
        $opt = "+";
        $wxcouponDb = M('cashier_wxcoupon');
        $cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');
        if (isset($cardinfo['quantity'])) {
            if ($qtype == 1) {
                $postwxJsonstr = '{"card_id":"' . $cdid . '","increase_stock_value":' . $qmun . '}';
                $newquantity = $cardinfo['quantity'] + $qmun;
            } else {
                if ($qmun > $cardinfo['quantity'])
                    $this->dexit(array('error' => 1, 'msg' => '减少库存的值不能大于现在的库存值'));
                $postwxJsonstr = '{"card_id":"' . $cdid . '","reduce_stock_value":' . $qmun . '}';
                $opt = "-";
                $newquantity = $cardinfo['quantity'] - $qmun;
            }
            if (!($cardinfo['istowx'] > 0)) {
                $wxcouponDb->update(array('quantity' => $opt . '=' . $qmun), array('id' => $id, 'mid' => $this->mid));
                $this->dexit(array('error' => 0, 'msg' => $newquantity));
            }
            $rets = $this->wxCardPack->wxCardModifyStock($this->access_token, $postwxJsonstr);
            if (isset($rets['errcode'])) {
                if ($rets['errcode'] == 0) {
                    $wxcouponDb->update(array('quantity' => $opt . '=' . $qmun), array('id' => $id, 'mid' => $this->mid));

                    $this->dexit(array('error' => 0, 'msg' => $newquantity));
                } else {
                    $this->dexit(array('error' => 1, 'msg' => $rets['errcode'] . '：' . $rets['errmsg']));
                }
            }
        }
        $this->dexit(array('error' => 1, 'msg' => '更改库存失败！'));
    }

    /*     * ******核销卡券页面******** */

    public function consumeCard() {
        if (IS_POST) {
            $vcode = trim($_POST['auth_code']);
            if (!empty($vcode)) {
                $vcode = str_replace('-', '', $vcode);
                $wxcoupon_receiveDb = M('cashier_wxcoupon_receive');
                $receiveinfo = $wxcoupon_receiveDb->get_one(array('cardcode' => $vcode, 'outerid' => $this->mid, 'consumesource' => 'LOCAL'), '*');
                $wxcouponDb = M('cashier_wxcoupon');
                if (!empty($receiveinfo) && strpos($receiveinfo['cardid'], 'ocalCardid_')) {
                    $tempcardid = explode('_', $receiveinfo['cardid']);
                    $wxcouponID = $tempcardid['1'];
                    if ($this->storeid > 0) {
                        $tmpstore = M('cashier_stores')->get_one(array('mid' => $this->mid, 'id' => $this->storeid), 'id,mid,poi_id,business_name,branch_name,address');
                        if (!empty($tmpstore)) {
                            $db_config = loadConfig('db');
                            $tablepre = $db_config['default']['tablepre'];
                            $sqlStr = 'SELECT id,mid,poi_ids,card_type FROM ' . $tablepre . 'cashier_wxcoupon where id=' . $wxcouponID . ' AND mid=' . $this->mid . ' AND (poi_ids like "%' . $tmpstore['poi_id'] . '%"  OR  store_ids like "%' . $this->storeid . '%")';
                            $sqlObj = new model();
                            $tmps = $sqlObj->selectBySql($sqlStr);
                            if (empty($tmps)) {
                                $this->dexit(array('error' => 1, 'msg' => '此卡券不属于你的门店，你没权限核销'));
                                exit();
                            }
                        }
                    }
                    $updateData = array('status' => 1, 'outerid' => $this->mid, 'consumetime' => time());
                    if ($this->storeid > 0) {
                        $updateData['storeid'] = $this->storeid;
                        $updateData['eid'] = $this->eid;
                    }
                    $wxcoupon_receiveDb->update($updateData, array('id' => $receiveinfo['id'], 'cardcode' => $vcode));
                    $wxcouponTmp = $wxcouponDb->get_one(array('id' => $wxcouponID, 'mid' => $this->mid, 'card_id' => 'localCard_id'), '*');
                    $consumenum = $wxcouponTmp['consumenum'] + 1;
                    $wxcouponDb->update(array('consumenum' => $consumenum), array('id' => $wxcouponTmp['id']));
                    $this->dexit(array('error' => 0, 'msg' => '核销成功！'));
                    exit();
                }
				unset($receiveinfo);
                $rets = $this->wxCardPack->wxCardQueryCode($this->access_token, '{"code":"' . $vcode . '"}');
                if (isset($rets['card'])) {

                    $card_id = trim($rets['card']['card_id']);
                    $begin_time = trim($rets['card']['begin_time']);
                    $end_time = trim($rets['card']['end_time']);
                    $receiveinfo = $wxcoupon_receiveDb->get_one(array('openid' => $rets['openid'], 'cardcode' => $vcode, 'cardid' => $card_id), '*');
                    if ($this->storeid > 0) {
                        $tmpstore = M('cashier_stores')->get_one(array('mid' => $this->mid, 'id' => $this->storeid), 'id,mid,poi_id,business_name,branch_name,address');
                        if ($tmpstore && $tmpstore['poi_id']) {
                            $db_config = loadConfig('db');
                            $tablepre = $db_config['default']['tablepre'];
                            $sqlStr = 'SELECT id,mid,poi_ids,card_type FROM ' . $tablepre . 'cashier_wxcoupon where mid=' . $this->mid . ' AND poi_ids like "%' . $tmpstore['poi_id'] . '%" AND card_id="' . $card_id . '"';
                            $sqlObj = new model();
                            $tmps = $sqlObj->selectBySql($sqlStr);
                            if (empty($tmps)) {
                                $this->dexit(array('error' => 1, 'msg' => '此卡券不属于你的门店，你没权限核销'));
                                exit();
                            }
                        }
                    }
                    if (($rets['can_consume'] == 1) && ($receiveinfo['status'] == 0) && ($receiveinfo['isdel'] == 0)) {
                        $vrets = $this->wxCardPack->wxCardConsume($this->access_token, '{"code":"' . $vcode . '","card_id":"' . $card_id . '"}');
                        if (!empty($vrets) && isset($vrets['card']) && ($vrets['errcode'] == 0)) {
                            $updateData = array('status' => 1, 'outerid' => $this->mid, 'consumetime' => time());
                            if ($this->storeid > 0) {
                                $updateData['storeid'] = $this->storeid;
                                $updateData['eid'] = $this->eid;
                            }
                            $wxcoupon_receiveDb->update($updateData, array('id' => $receiveinfo['id'], 'cardcode' => $vcode));
                            $wxcouponTmp = $wxcouponDb->get_one(array('card_id' => $card_id, 'mid' => $this->mid), '*');
                            $consumenum = $wxcouponTmp['consumenum'] + 1;
                            $wxcouponDb->update(array('consumenum' => $consumenum), array('id' => $wxcouponTmp['id']));
                            $this->dexit(array('error' => 0, 'msg' => '核销成功！'));
                        } elseif (isset($vrets['errmsg'])) {
                            $this->dexit(array('error' => 1, 'msg' => $vrets['errcode'] . '：' . $vrets['errmsg']));
                        }
                    } else {
                        $this->dexit(array('error' => 1, 'msg' => '此核销码不可以再核销！'));
                    }
                } elseif ($rets['errcode'] > 0) {
                    $this->dexit(array('error' => 1, 'msg' => $rets['errcode'] . '：' . $rets['errmsg']));
                }
            }
        } else {
            $signdata = $this->wxCardPack->getSgin($this->access_token);
            include $this->showTpl();
        }
    }

    /*     * ******二维码******** */

    public function wxCardQrCodeTicket() {
        $id = intval(trim($_POST['cdid']));
        $wxcouponDb = M('cashier_wxcoupon');
        $cardinfo = $wxcouponDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');
        if (!empty($cardinfo) && !empty($cardinfo['cardurl'])) {
            $this->dexit(array('error' => 0, 'msg' => $id));
        } elseif (!empty($cardinfo)) {
            $postwxJsonstr = '{"action_name":"QR_CARD","action_info":{"card": {"card_id":"' . $cardinfo['card_id'] . '","is_unique_code": false ,"outer_id" : ' . $this->storeid . '}}}';
            $rets = $this->wxCardPack->wxCardQrCodeTicket($this->access_token, $postwxJsonstr);
            if (isset($rets['errcode']) && ($rets['errcode'] == 0)) {
                $wxcouponDb->update(array('cardticket' => $rets['ticket'], 'cardurl' => $rets['url']), array('id' => $cardinfo['id'], 'mid' => $this->mid));
                $this->dexit(array('error' => 0, 'msg' => $id));
            } else {
                $tmpmsg = isset($rets['errcode']) ? $rets['errcode'] : '';
                isset($rets['errmsg']) && $tmpmsg = $tmpmsg . "：" . $rets['errmsg'];
                if (!empty($tmpmsg)) {
                    $this->dexit(array('error' => 1, 'msg' => $tmpmsg));
                }
                $this->dexit(array('error' => 1, 'msg' => '二维码生成失败！'));
            }
        }
        $this->dexit(array('error' => 1, 'msg' => '卡券不存在，不可删除！'));
    }

    private function updateMname($brand_name, $logo_url) {

        $wxcouponCDb = M('cashier_wxcoupon_common');
        $mset = $wxcouponCDb->get_one(array('mid' => $this->mid), '*');
        $inserData = array('mname' => $brand_name);
        if (!empty($mset)) {
            if (empty($mset['mname']) || $mset['mname'] != $brand_name) {
                $wxcouponCDb->update($inserData, array('id' => $mset['id']));
            }
        } else {
            $inserData['mid'] = $this->mid;
            $inserData['wxlogurl'] = $logo_url;
            $wxcouponCDb->insert($inserData, True);
        }
    }

    private function FiltrationData($array) {
        if (empty($array['logo_url'])) {
            $this->dexit(array('error' => 1, 'msg' => 'LOGO图片必须上传'));
        }

        if (empty($array['brand_name'])) {
            $this->dexit(array('error' => 1, 'msg' => '商户名称必须填写'));
        }

        if (empty($array['title'])) {
            $this->dexit(array('error' => 1, 'msg' => '卡券标题必须填写'));
        }

        if (empty($array['color'])) {
            $this->dexit(array('error' => 1, 'msg' => '卡券颜色必须填写'));
        }
        if (empty($array['notice'])) {
            $this->dexit(array('error' => 1, 'msg' => '卡券操作提示必须填写'));
        }
        if (empty($array['description'])) {
            $this->dexit(array('error' => 1, 'msg' => '卡券详情使用须知必须填写'));
        }
        if (!($array['sku']['quantity'] > 0)) {
            $this->dexit(array('error' => 1, 'msg' => '卡券库存必须填写一个大于0的正数'));
        }
        if (!($array['date_info']['begin_timestamp'] > 0)) {
            $this->dexit(array('error' => 1, 'msg' => '卡券有效期开始时间没有填写'));
        }
        if (!($array['date_info']['end_timestamp'] > 0)) {
            $this->dexit(array('error' => 1, 'msg' => '卡券有效期结束时间没有填写'));
        }
        return TRUE;
    }

    private function ArrayToJsonstr($array) {
        $tmpJosnStr = '{';
        foreach ($array as $key => $val) {
            $tmpJosnStr.='"' . $key . '":';
            if (is_array($val)) {
                $tmpJosnStr.=$this->ArrayToJsonstr($val) . ',';
            } else {
                if (is_numeric($val) && ($key != 'service_phone')) {
                    $tmpJosnStr.=$val . ',';
                } elseif (is_bool($val)) {
                    $tmpJosnStr.=$val ? 'true,' : 'false,';
                } elseif (empty($val)) {
                    $tmpJosnStr.='"",';
                } elseif (stripos($val, 'sarray[')) {
                    $tmpJosnStr.= str_replace('Jsarray', '', $val) . ',';
                } else {
                    $tmpJosnStr.='"' . $val . '",';
                }
            }
        }
        $tmpJosnStr = rtrim($tmpJosnStr, ',');
        $tmpJosnStr.='}';
        return $tmpJosnStr;
    }

    public function uploadImg() {
		$cf=intval($_GET['cf']);
        if (!empty($_FILES)) {
				$pathname='wxcoupon';
			if($cf==1 || $cf==2){
				$pathname='loccard';
			}
            $return = $this->oldUploadFile($pathname, $this->mid);
            if (isset($return['data']) && !empty($return['data'])) {
                $imgpath = $return['data']['0']['savepath'] . $return['data']['0']['savename'];
				if($cf==1 || $cf==2){
				    $this->dexit(array('error' => 0,  'localimg' => $imgpath));
				}
                $trimstr = DIRECTORY_SEPARATOR . 'Cashier' . DIRECTORY_SEPARATOR;
                //$wximgpath = rtrim(ABS_PATH, $trimstr) . ltrim($imgpath,'.');
                $wximgpath = str_replace($trimstr, '', ABS_PATH) . ltrim($imgpath, '.');
                $wxlogimg = $this->wxCardPack->wxCardUpdateImg($this->access_token, $wximgpath);
                //dump($wxlogimg);die;
                if (isset($wxlogimg['url']) && !empty($wxlogimg['url'])) {
                    $wxcouponCDb = M('cashier_wxcoupon_common');
                    $mset = $wxcouponCDb->get_one(array('mid' => $this->mid), '*');
                    $inserData = array('logurl' => $imgpath, 'wxlogurl' => $wxlogimg['url']);
                    if (!empty($mset)) {
                        $wxcouponCDb->update($inserData, array('id' => $mset['id']));
                    } else {
                        $inserData['mid'] = $this->mid;
                        $wxcouponCDb->insert($inserData, True);
                    }
                    $this->dexit(array('error' => 0, 'wxlogurl' => $wxlogimg['url'], 'localimg' => $imgpath));
                } else {
                    $tmpmsg = isset($wxlogimg['errcode']) ? $wxlogimg['errcode'] : '';
                    isset($wxlogimg['errmsg']) && $tmpmsg = $tmpmsg . ":" . $wxlogimg['errmsg'];
                    if (!empty($tmpmsg)) {
                        $this->dexit(array('error' => 1, 'msg' => $tmpmsg));
                    }
                }
            }
        }
        $this->dexit(array('error' => 1, 'msg' => ''));
    }

    public function qrcode() {
        $id = intval(trim($_GET['cdid']));
		bpBase::loadOrg('phpqrcode');
        new QRimage(350, 350);
		if($id=='wapindex'){
			$url =$this->SiteUrl.'/merchants.php?m=Wap&c=index&a=index';
		    Header("Content-type: image/jpeg");
            QRcode::png($url);
			exit();
		}
        $isdwd = isset($_GET['dwd']) ? intval(trim($_GET['dwd'])) : 0;
        $tmpdata = M('cashier_wxcoupon')->get_one(array('id' => $id, 'mid' => $this->mid), 'cardurl,cardticket');

        $url = urldecode($tmpdata['cardurl']);
        if ($isdwd > 0) {
            $fname = "Your-Card-code-image-" . $this->mid . ".png";
            header("Pragma: public"); // required 
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header('Content-type: image/png');
            header("Content-Type:application/download");
            header("Content-Disposition: attachment; filename={$fname}");
            header("Content-Transfer-Encoding: binary");
            QRcode::png($url, false, 'H', 10, 1);
        } else {
            Header("Content-type: image/jpeg");
            QRcode::png($url);
        }
    }

    public function bonus() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $receive = M('cashier_wxcoupon_receive')->get_one(array('outerid' => $this->mid, 'id' => $id, 'cardtype' => 5), '*');
        if (empty($receive))
            $this->errorTip('不存在的会员记录');
        bpBase::loadOrg('common_page');
        $where = array('code' => $receive['cardcode'], 'card_id' => $receive['cardid']);
        $cardbonusDB = M('cashier_card_bonus');
        $_count = $cardbonusDB->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $bonus_list = $cardbonusDB->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');
        include $this->showTpl();
    }

    public function paycell() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $receive = M('cashier_wxcoupon_receive')->get_one(array('outerid' => $this->mid, 'id' => $id, 'cardtype' => 5), '*');
        if (empty($receive))
            $this->errorTip('不存在的会员记录');
        bpBase::loadOrg('common_page');
        $where = array('code' => $receive['cardcode'], 'card_id' => $receive['cardid']);
        $paycellDB = M('cashier_pay_cell');
        $_count = $paycellDB->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $paycell_list = $paycellDB->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');
        include $this->showTpl();
    }

    public function testUpdateCard() {
        /*$result = M('cashier_wxcoupon')->cardbonus(array('openid' => 'oZrMms0Em_h17445dSccyK-ZdQmI', 'price' => 100, 'msg' => '测试支付增加积分', 'fromid' => 0));
        echo "<pre/>";
        print_r($result);
        die;*/

		$jsonData = '{"code": "876080499803","card_id":"pZrMms44qVn5TmK70iTkIBa1VGAQ","record_bonus": "充值增加积分","add_bonus": 102}';
		bpBase::loadOrg('wxCardPack');
		$wx_user = M('cashier_payconfig')->get_wx_info(10);
		$wxCardPack = new wxCardPack($wx_user, 10);
		$access_token = $wxCardPack->getToken();
		$res = $wxCardPack->UpdateUserCard($access_token, $jsonData);
		print_r($res);
		/**Array ( [errcode] => 0 [errmsg] => ok [result_bonus] => 217 [result_balance] => 0 [openid] => oZrMms12QuDmt_mCJOam85yNF0DI ) ***/

        
    }

    public function addtoWxTestWhiteList() {
        $openid = trim($_GET['wecha_id']);
        if ($openid) {
            $tmpx = $this->wxCardPack->TestWhiteList($this->access_token, '{"openid":["' . $openid . '"]}');
            echo "<pre>";
            print_r($tmpx);
            echo "</pre>";
        }
    }

}

?>