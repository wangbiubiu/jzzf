<?php

bpBase::loadAppClass('common', 'Salesman', 0);

class merchant_controller extends common_controller {

    private $employeeDb;
    private $specialArea = array();
    public $pigcms_static = '';
    public $payConfigDb;

    public function __construct() {
        parent::__construct();
        bpBase::loadOrg('checkFunc');
        $checkFunc = new checkFunc();
        if (!function_exists('dsbig3joishdgfhg798rqw4fqnkhffq')) {
            exit('error-4');
        }
        $checkFunc->cfdwdgfds3skgfds3szsd3idsj();
        if ($this->eid > 0) {
            $this->errorTip('员工账号没有权限访问！');
        }
        $this->pigcms_static = PIGCMS_STATIC_PATH_FOLDER . 'image/';
        /* $this->authorityControl(array('employersEdit', 'checkAccount')); */
        $this->employeeDb = M('cashier_employee');
        //$this->specialArea=array(1,2,22,32,33);
        $this->payConfigDb = M('cashier_payconfig');
    }

    public function employers() {
        $authority = $this->authorityList('Merchants/User');

        $employees = $this->employeeDb->select(array('mid' => $this->mid));
        $StoreInfo = $this->getStoreInfo(false);
        include $this->showTpl();
    }

    public function employersAdd() {
        if (IS_POST) {

            $data = $this->clear_html($_POST);

            if ($data['password'] != $data['confirm']) {
                $this->errorTip('两次输入密码不一致！', $_SERVER['HTTP_REFERER']);
                exit;
            }

            $data['mid'] = $this->mid;
            $data['salt'] = mt_rand(111111, 999999);
            $data['password'] = md5(md5($data['password'] . '_' . $data['salt']) . $data['salt']);
            $data['authority'] = !empty($data['authority']) ? implode(',', $data['authority']) : '';
            unset($data['confirm']);
            if ($this->employeeDb->insert($data, 1)) {
                $this->successTip('添加员工账号成功！', $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $this->errorTip('添加员工账号失败！', $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }

    public function checkAccount() {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            if ($this->employeeDb->get_one(array('account' => $data['account']), 'eid,account')) {
                echo json_encode(array('status' => 0, 'msg' => '登录账号已存在'));
            } else {
                echo json_encode(array('status' => 1, 'msg' => '验证成功'));
            }
        }
    }

    public function field() {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $return = $this->_setField($this->employeeDb, $data);
            echo json_encode($return);
            exit;
        }
    }

    public function employersDelAll() {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $return = $this->_delAll($this->employeeDb, $data['id']);
            if ($return['status'] == '1') {
                $this->successTip($return['msg'], $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $this->errorTip($return['msg'], $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }

    public function employersDel() {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $return = $this->_del($this->employeeDb, $data['eid']);
            exit(json_encode($return));
        }
    }

    public function employersEdit() {
        if (IS_GET) {
            $data = $this->clear_html($_GET);
            $authority = $this->authorityList('Merchants/User');
            $employee = $this->employeeDb->get_one(array('eid' => $data['eid']));
            $employee['authority'] = explode(',', $employee['authority']);
            $StoreInfo = $this->getStoreInfo(false);
            include $this->showTpl();
        }
    }

    public function employersAppemd() {
        if (IS_POST) {

            $data = $this->clear_html($_POST);

            $employee = $this->employeeDb->get_one(array('eid' => $data['eid']), 'eid,account,salt');

            if ($data['account'] != $employee['account']) {
                if ($this->employeeDb->get_one(array('account' => $data['account']), 'eid,account')) {
                    $this->errorTip('登录账号已存在！', $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }
            if ($data['password'] == '') {
                unset($data['password']);
            } elseif ($data['password'] != $data['confirm']) {
                $this->errorTip('两次输入密码不一致！', $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $data['password'] = md5(md5($data['password'] . '_' . $employee['salt']) . $employee['salt']);
            }
            unset($data['confirm']);

            $data['authority'] = !empty($data['authority']) ? implode(',', $data['authority']) : '';

            if ($this->_save($this->employeeDb, $data)) {

                $this->successTip('修改员工账号成功！', $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $this->errorTip('修改员工账号失败！', $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }

    public function config() {


        if (!empty($_GET['mid'])) {
            $getdata = $this->clear_html($_GET);
        }

        $payConfig = $this->payConfigDb->get_one(array('mid' => $getdata['mid']), '*');

        if ($payConfig) {
            if ($payConfig['configData']) {
                $payConfig['configData'] = unserialize(htmlspecialchars_decode($payConfig['configData'], ENT_QUOTES));

                if (!isset($payConfig['configData']['weixin']))
                    $payConfig['configData']['weixin'] = array();
                if (!isset($payConfig['configData']['alipay']))
                    $payConfig['configData']['alipay'] = array();
            }else {
                $payConfig['configData'] = array('weixin' => array(), 'alipay' => array());
            }
        }



        if (IS_POST) {

            $data = $this->clear_html($_POST['data']);
            $dataType = array_keys($data);
            $dataType = $dataType[0];
            $pmid = $data[$dataType]['mid'];
            unset($data[$dataType]['mid']);
            $payConfig = M('cashier_payconfig')->get_one(array('mid' => $pmid), '*');

            if ($payConfig) {
                if ($payConfig['configData']) {
                    $payConfig['configData'] = unserialize(htmlspecialchars_decode($payConfig['configData'], ENT_QUOTES));
                    if (!isset($payConfig['configData']['weixin']))
                        $payConfig['configData']['weixin'] = array();
                    if (!isset($payConfig['configData']['alipay']))
                        $payConfig['configData']['alipay'] = array();
                }else {
                    $payConfig['configData'] = array('weixin' => array(), 'alipay' => array());
                }
            }

            if ($payConfig) {

                // $dataType = array_keys($data);
                // $dataType = $dataType[0];

                if (isset($payConfig['configData'][$dataType])) {
                    $configData = array_merge($payConfig['configData'][$dataType], $data[$dataType]);
                } else {
                    $configData = $data[$dataType];
                }

                $payConfig['configData'][$dataType] = $configData;



                $tmppayConfig = array();
                isset($payConfig['configData']['weixin']) && $tmppayConfig['weixin'] = $payConfig['configData']['weixin'];
                isset($payConfig['configData']['alipay']) && $tmppayConfig['alipay'] = $payConfig['configData']['alipay'];
                $payConfig['configData'] = $tmppayConfig;
                unset($tmppayConfig);
                $payConfig['configData'] = serialize($payConfig['configData']);
                $payConfig['wxsubmchid'] = $data['weixin']['mchid'];
                $vo = M('cashier_payconfig')->update($payConfig, "mid=" . $pmid);
            } else {
                $payConfig = array('mid' => $pmid, 'isOpen' => 1, 'configData' => serialize($data), 'wxsubmchid' => $data['weixin']['mchid']);
                $vo = M('cashier_payconfig')->insert($payConfig, 1);
            }
            if ($vo) {

                // 修改商户表 是否开启
                if ($dataType == 'weixin') {
                    M('cashier_merchants')->update(array('isopenwxpay' => 1), 'mid=' . $pmid);
                } elseif ($dataType == 'alipay') {
                    M('cashier_merchants')->update(array('isopenalipay' => 1), 'mid=' . $pmid);
                }

                $return['status'] = 1;
                $return['msg'] = '支付配置修改成功';
            } else {
                $return['status'] = 0;
                $return['msg'] = '支付配置修改失败';
            }
            delCacheByMid($pmid);
            echo json_encode($return);
            exit;
        }

        include $this->showTpl();
    }

    public function pem_upload() {
        if (IS_POST) {
            if (!empty($_FILES)) {


                $return = $this->oldUploadFile('pem', $_GET['mid']);

                if ($return['error'] > 0) {
                    $this->dexit(array('error' => 1, 'msg' => $return['data']));
                } else {
                    $filesinfo = $return['data']['0'];
                    $this->dexit(array('error' => 0, 'msg' => 'OK', 'fileUrl' => $return['imgurl'] . $filesinfo['savename'], 'originalfilename' => $filesinfo['name'], 'fileSize' => $filesinfo['size']));
                }
            }
            $this->dexit(array('error' => 1, 'msg' => '没有上传文件！'));
        }
    }

    /*     * ***门店管理***** */

    public function storefront() {
        $cashier_storesDb = M('cashier_stores');
        bpBase::loadOrg('common_page');
        $wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
        if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $this->mid) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret'])) {
            $wx_user = $wx_user['submchinfo'];
        }

        $where = array('mid' => $this->mid, 'appid' => $wx_user['appid']);
        unset($wx_user);
        $_count = $cashier_storesDb->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $stores = $cashier_storesDb->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');

        foreach ($stores as $kk => $vv) {
            if ($vv['available_state'] == 2) {
                $stores[$kk]['statusstr'] = "<font>审核中</font>";
            } elseif ($vv['available_state'] == 3) {
                $stores[$kk]['statusstr'] = "<font color='green'>已审核</font>";
            } elseif ($vv['available_state'] == 4) {
                $stores[$kk]['statusstr'] = "<font color='red'>未通过</font>";
            } elseif ($vv['available_state'] == 1) {
                $stores[$kk]['statusstr'] = "系统错误";
            } else {
                $stores[$kk]['statusstr'] = "等待微信审核";
            }
        }
        $wx_user = M('cashier_payconfig')->get_wx_info($this->mid);
        $getWxStore = true;
        if (!empty($wx_user) && (($wx_user['pfpaymid'] > 0) || ($wx_user['proxymid'] > 0))) {
            $getWxStore = false;
        }
        include $this->showTpl();
    }

    /*     * ***门店管理***** */

    public function getWxStore() {
        bpBase::loadOrg('wxCardPack');
        $wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
        if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $this->mid) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret'])) {
            $wx_user = $wx_user['submchinfo'];
        }
        $wxCardPack = new wxCardPack($wx_user, $this->mid);
        $access_token = $wxCardPack->getToken();
        $wxShoplist = $wxCardPack->wxGetPoiList($access_token);
        $shopnum = 0;
        $nodata = true;
        if ($wxShoplist && !empty($wxShoplist['business_list'])) {
            $shopnum = $wxShoplist['total_count'];
            $nodata = $this->execinsertData($wxShoplist['business_list'], $wx_user['appid']);
            if ($shopnum > 49) {
                for ($i = 50; $i <= $shopnum;) {
                    $limitStr = '{"begin":' . $i . ',"limit":50}';
                    $wxShoplist = $wxCardPack->wxGetPoiList($access_token, $limitStr);
                    $nodata = $this->execinsertData($wxShoplist['business_list'], $wx_user['appid']);
                    $i = $i + 50;
                }
            }
            if (!$nodata) {
                $this->dexit(array('error' => 0));
            }
        }
        $this->dexit(array('error' => 1));
    }

    /*     * **创建门店** */

    public function createStore() {
        $categorys = M('cashier_category')->select(array('fid' => '0', 'is_hide' => '0'), '*', '', 'id ASC');
        $districts = M('cashier_district')->select(array('fid' => '0'), '*', '', 'id ASC');
        include $this->showTpl();
    }

    /*     * ******获取城市或区域信息******* */

    public function GetDistrict() {
        $districtid = isset($_POST['districtid']) ? trim($_POST['districtid']) : 0;
        if ($districtid > 0) {
            $districts = M('cashier_district')->select(array('fid' => $districtid), '*', '', 'id ASC');
            $this->dexit(array('error' => 0, 'data' => !empty($districts) ? $districts : ''));
        }
        $this->dexit(array('error' => 1, 'data' => ''));
    }

    /*     * ******获取子目录信息******* */

    public function GetCategory() {
        $cid = isset($_POST['cid']) ? trim($_POST['cid']) : 0;
        if ($cid > 0) {
            $categorys = M('cashier_category')->select(array('fid' => $cid, 'is_hide' => '0'), '*', '', 'id ASC');
            $this->dexit(array('error' => 0, 'data' => !empty($categorys) ? $categorys : ''));
        }
        $this->dexit(array('error' => 1, 'data' => ''));
    }

    /*     * ******添加门店******* */

    public function addShop() {

        $datas = $this->clear_html($_POST);
        $datas = $this->FiltrationData($datas);
        $toJsonsarr = array('business' => array());
        $baseInfo = array();
        $baseInfo['sid'] = $this->mid;
        $baseInfo['business_name'] = $datas['business_name'];
        $baseInfo['branch_name'] = $datas['branch_name'];
        $tmpArea = $this->GetAreaInfo($datas['pos_id']);
        $baseInfo['province'] = $tmpArea['province']['fullname'];
        $baseInfo['city'] = $tmpArea['city']['fullname'];
        $baseInfo['district'] = $tmpArea['district']['fullname'];
        $baseInfo['address'] = $datas['address'];
        $baseInfo['telephone'] = $datas['telephone'];
        $baseInfo['categories'] = $datas['categories'];
        $baseInfo['offset_type'] = 1;
        $baseInfo['longitude'] = $datas['longitude'];
        $baseInfo['latitude'] = $datas['latitude'];
        $baseInfo['photo_list'] = $datas['photo_list'];
        $baseInfo['special'] = $datas['special'];
        $baseInfo['open_time'] = $datas['open_time'];
        $baseInfo['avg_price'] = $datas['avg_price'];
        $baseInfo['recommend'] = $datas['recommend'];
        $baseInfo['introduction'] = $datas['desc'];

        foreach ($datas['photo_list'] as $ikk => $ivv) {
            $datas['photo_list'][$ikk]['local_img'] = $datas['photo_img'][$ikk];
        }
        $wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
        if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $this->mid) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret'])) {
            $wx_user = $wx_user['submchinfo'];
        }
        $localArr = array('mid' => $this->mid, 'business_name' => $datas['business_name'],
            'branch_name' => $datas['branch_name'], 'telephone' => $datas['telephone'],
            'longitude' => $datas['longitude'], 'latitude' => $datas['latitude'],
            'starttime' => $datas['starttime'], 'endtime' => $datas['endtime'],
            'avg_price' => $datas['avg_price'], 'address' => $datas['address'],
            'photo_list' => !empty($datas['photo_list']) ? serialize($datas['photo_list']) : '',
            'fsortid' => $datas['categoryid0'], 'sortid' => $datas['categoryid1'],
            'circleid' => 0, 'cityid' => $tmpArea['city']['id'],
            'provinceid' => $tmpArea['province']['id'], 'cityname' => $tmpArea['city']['fullname'],
            'provincename' => $tmpArea['province']['fullname'], 'introduction' => $datas['desc'],
            'recommend' => $datas['recommend'], 'special' => $datas['special'],
            'districtid' => $tmpArea['district']['id'], 'districtname' => $tmpArea['district']['fullname'],
            'available_state' => 0, 'offset_type' => 1, 'comefrom' => 0, 'addtime' => SYS_TIME,
            'appid' => $wx_user['appid']
        );
        $storesDb = M('cashier_stores');
        $insertid = $storesDb->insert($localArr, True);
        if ($insertid > 0) {
            $baseInfo['sid'] = $this->mid . '_' . $insertid;
            $toJsonsarr['business']['base_info'] = $baseInfo;
            $postwxJsonstr = $this->ArrayToJsonstr($toJsonsarr);
            unset($baseInfo);
            bpBase::loadOrg('wxCardPack');
            $wxCardPack = new wxCardPack($wx_user, $this->mid);
            $access_token = $wxCardPack->getToken();
            $rets = $wxCardPack->wxCardShop($access_token, $postwxJsonstr);
            if (!$rets['errcode']) {
                $this->dexit(array('error' => 0, 'msg' => '数据提交成功，请静待审核'));
            } else {
                $storesDb->delete(array('id' => $insertid, 'mid' => $this->mid));
                $this->dexit(array('error' => 1, 'msg' => $rets['errcode'] . '：' . $rets['errmsg']));
            }
        }
        $this->dexit(array('error' => 1, 'msg' => '数据保存失败！'));
    }

    public function storedetail() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $store = M('cashier_stores')->get_one(array('id' => $id, 'mid' => $this->mid));
        if (empty($store))
            $this->errorTip('不存在的门店', '/merchants.php?m=User&c=merchant&a=storefront');
        $photo_list = unserialize($store['photo_list']);
        $photo_list = $photo_list ? $photo_list : array();
        $date_str = date('H:i', $store['starttime']) . '-' . date('H:i', $store['endtime']);
//     	echo "<pre/>";
//     	print_r($photo_list);die;
        $categorys = M('cashier_category')->select("id IN ({$store['fsortid']}, {$store['sortid']})");
        $catestr = '';
        foreach ($categorys as $category) {
            if ($category['fid']) {
                $catestr .= ',' . $category['name'];
            } else {
                $catestr = $category['name'] . $catestr;
            }
        }
        include $this->showTpl();
    }

    //门店管理
    public function detail() {

        include $this->showTpl();
    }

    //员工管理
    public function assistant() {
        include $this->showTpl();
    }

    //员工设置
    public function assistantedito() {
        include $this->showTpl();
    }

    public function information() {
        include $this->showTpl();
    }

    //打印机设置
    public function printerset() {
        include $this->showTpl();
    }

    public function storedel() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $employee = M('cashier_employee')->select(array('storeid' => $id, 'mid' => $this->mid));
        if ($employee)
            $this->dexit(array('errcode' => 1, 'errmsg' => '给门店已经分配给' . $employee[0]['username'] . '管理，如要删除，先取消' . $employee[0]['username'] . '的管理！'));
        $storeDB = M('cashier_stores');
        $store = $storeDB->get_one(array('id' => $id, 'mid' => $this->mid));
        if (empty($store))
            $this->dexit(array('errcode' => 1, 'errmsg' => '不存在的门店'));
        $wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
        if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $this->mid) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret'])) {
            $wx_user = $wx_user['submchinfo'];
        }
        bpBase::loadOrg('wxCardPack');
        $wxCardPack = new wxCardPack($wx_user, $this->mid);
        $access_token = $wxCardPack->getToken();
        $res = $wxCardPack->delShop($access_token, json_encode(array('poi_id' => $store['poi_id'])));
        if (empty($res['errcode'])) {
            $storeDB->delete(array('id' => $id, 'mid' => $this->mid));
        }
        $this->dexit($res);
    }

    /*     * **门店本地删除**** */

    public function store2del() {

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $employee = M('cashier_employee')->select(array('storeid' => $id, 'mid' => $this->mid));
        if ($employee)
            $this->dexit(array('errcode' => 1, 'errmsg' => '给门店已经分配给' . $employee[0]['username'] . '管理，如要删除，先取消' . $employee[0]['username'] . '的管理！'));
        $storeDB = M('cashier_stores');
        $store = $storeDB->get_one(array('id' => $id, 'mid' => $this->mid));
        if (empty($store))
            $this->dexit(array('errcode' => 1, 'errmsg' => '不存在的门店'));
        if ($storeDB->delete(array('id' => $id, 'mid' => $this->mid))) {
            $this->dexit(array('errcode' => 0, 'errmsg' => '删除成功'));
        }
        $this->dexit(array('errcode' => 1, 'errmsg' => '删除成功'));
    }

    private function ArrayToJsonstr($array) {
        $tmpJosnStr = '{';
        foreach ($array as $key => $val) {
            $tmpJosnStr.='"' . $key . '":';
            if ($key == 'categories') {
                $tmpJosnStr.=$val . ',';
            } elseif ($key == 'photo_list') {
                $tmpJosnStr.=json_encode($val) . ',';
            } elseif (is_array($val)) {
                $tmpJosnStr.=$this->ArrayToJsonstr($val) . ',';
            } else {
                if (is_numeric($val) && ($key != 'telephone')) {
                    $tmpJosnStr.=$val . ',';
                } elseif (is_bool($val)) {
                    $tmpJosnStr.=$val ? 'true,' : 'false,';
                } elseif (empty($val)) {
                    $tmpJosnStr.='"",';
                } else {
                    $tmpJosnStr.='"' . $val . '",';
                }
            }
        }
        $tmpJosnStr = rtrim($tmpJosnStr, ',');
        $tmpJosnStr.='}';
        return $tmpJosnStr;
    }

    private function FiltrationData($datas) {
        if (empty($datas['business_name'])) {
            $this->dexit(array('error' => 1, 'msg' => '门店名称必须填写'));
        }
        if (empty($datas['branch_name'])) {
            $this->dexit(array('error' => 1, 'msg' => '门店名称必须填写'));
        }
        if (empty($datas['latitude']) || empty($datas['longitude'])) {
            $this->dexit(array('error' => 1, 'msg' => '地理位置经纬度为空，请点击地图定位获取！'));
        }
        if (empty($datas['pos_id'])) {
            $this->dexit(array('error' => 1, 'msg' => '没有定位，请点击地图定位！'));
        }
        if (empty($datas['address'])) {
            $this->dexit(array('error' => 1, 'msg' => '详细地址没有填写，你可以点击地图定位获取！'));
        }
        if (empty($datas['telephone'])) {
            $this->dexit(array('error' => 1, 'msg' => '联系电话没有填写！'));
        }
        if (empty($datas['categoryid0info']) || empty($datas['categoryid1info'])) {
            $this->dexit(array('error' => 1, 'msg' => '请重新选择类目！'));
        } else {
            $categoryidname = explode('-', $datas['categoryid0info']);
            $datas['categoryid0name'] = $categoryidname['1'];
            $datas['categories'] = array($categoryidname['1']);
            $categoryidname = explode('-', $datas['categoryid1info']);
            $datas['categoryid1name'] = $categoryidname['1'];
            $datas['categories'][] = $categoryidname['1'];
            $datas['categories'] = '["' . implode(',', $datas['categories']) . '"]';
        }

        if (empty($datas['photo_list'])) {
            $this->dexit(array('error' => 1, 'msg' => '门店图片至少请上传一张！'));
        } else {
            foreach ($datas['photo_list'] as $kk => $vv) {
                $datas['photo_list'][$kk] = array('photo_url' => $vv);
            }
        }

        if (empty($datas['open_time']) || !strpos($datas['open_time'], ':') || !strpos($datas['open_time'], '-')) {
            $this->dexit(array('error' => 1, 'msg' => '营业时间必须按格式填写上！'));
        } else {
            $nowTimeStr = date('Y-m-d');
            $open_time = explode('-', $datas['open_time']);
            $datas['starttime'] = !empty($open_time['0']) ? strtotime($nowTimeStr . ' ' . $open_time['0']) : 0;
            $datas['endtime'] = !empty($open_time['1']) ? strtotime($nowTimeStr . ' ' . $open_time['1']) : 0;
        }
        $avg_price = intval($datas['avg_price']);
        if (!($avg_price > 0)) {
            $this->dexit(array('error' => 1, 'msg' => '人均价格必须按要求填写！'));
        }
        $datas['avg_price'] = $avg_price;

        if (empty($datas['special'])) {
            $this->dexit(array('error' => 1, 'msg' => '特色服务必须填写！'));
        }
        return $datas;
    }

    private function GetAreaInfo($sid = '') {
        $tmpInfo = false;
        if (!empty($sid)) {
            $districtDb = M('cashier_district');
            $tmpdistrict = $districtDb->get_one(array('sid' => $sid), '*');
            if (!empty($tmpdistrict)) {
                $tmpInfo = array('district' => array('id' => $tmpdistrict['id'], 'fullname' => $tmpdistrict['fullname']));
                $tmpdistrict = $districtDb->get_one(array('id' => $tmpdistrict['fid']), '*');
                $tmpInfo['city'] = array('id' => $tmpdistrict['id'], 'fullname' => $tmpdistrict['fullname']);
                if ($tmpdistrict['fid'] > 0) {
                    $tmpdistrict = $districtDb->get_one(array('id' => $tmpdistrict['fid']), '*');
                    $tmpInfo['province'] = array('id' => $tmpdistrict['id'], 'fullname' => $tmpdistrict['fullname']);
                } else {
                    $tmpInfo['province'] = array('id' => $tmpdistrict['id'], 'fullname' => $tmpdistrict['fullname']);
                }
            }
        }
        return $tmpInfo;
    }

    private function execinsertData($datas, $appid = '') {
        $mid = $this->mid;
        $nodata = true;
        $cashier_storesDb = M('cashier_stores');
        foreach ($datas as $svv) {
            $svv['sid'] > 0 && $mid = $svv['base_info']['sid'];
            $poi_id = isset($svv['base_info']['poi_id']) ? $svv['base_info']['poi_id'] : '';
            $available_state = $svv['base_info']['available_state'];
            if (!empty($poi_id) && $available_state == 3) {
                $nodata = false;
                $timeStr = $svv['base_info']['open_time'];
                $starttime = $endtime = 0;
                $nowStr = date('Y-m-d');
                if (!empty($timeStr)) {
                    $timeStr = explode('-', $timeStr);
                    !empty($timeStr['0']) && $starttime = strtotime($nowStr . ' ' . $timeStr['0']);
                    !empty($timeStr['1']) && $endtime = strtotime($nowStr . ' ' . $timeStr['1']);
                }
                $categories = $svv['base_info']['categories']['0'];
                $categories = explode(',', $categories); /*                 * *待处理** */

                $fid = 0;
                $fsortid = $sortid = 0;
                foreach ($categories as $name) {
                    if ($category = M('cashier_category')->get_one(array('fid' => $fid, 'name' => $name))) {
                        $fid = $category['id'];
                        if (empty($fsortid)) {
                            $fsortid = $fid;
                        } else {
                            $sortid = $fid;
                        }
                    }
                }
                $provinceid = $cityid = $districtid = 0;

                $province = M('cashier_district')->get_one(array('fullname' => $svv['base_info']['province']));
                $provinceid = isset($province['id']) ? $province['id'] : 0;
                $city = M('cashier_district')->get_one(array('fullname' => $svv['base_info']['city']));
                $cityid = isset($city['id']) ? $city['id'] : 0;
                $district = M('cashier_district')->get_one(array('fullname' => $svv['base_info']['district'], 'fid' => $cityid));
                $districtid = isset($district['id']) ? $district['id'] : 0;
                $getupload_dir = "/upload/merchant/" . $this->mid . "/" . date('Ymd') . '/';
                if (defined('ABS_UPLOAD_PATH'))
                    $getupload_dir = ABS_UPLOAD_PATH . $getupload_dir;
                $upload_dir = "." . $getupload_dir;
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                if (!empty($svv['base_info']['photo_list'])) {
                    foreach ($svv['base_info']['photo_list'] as $ikk => $ivv) {
                        $imgpath = $getupload_dir . 's' . $poi_id . substr($ivv['photo_url'], -30, 10) . $ikk . '.jpg';
                        $imgarr = $this->httpRequest($ivv['photo_url'], 'GET');
                        if (isset($imgarr['1']) && !empty($imgarr['1'])) {
                            file_put_contents('.' . $imgpath, $imgarr['1']);
                            $svv['base_info']['photo_list'][$ikk]['local_img'] = $imgpath;
                        }
                    }
                }
                $inserDatas = array('mid' => $this->mid, 'poi_id' => $poi_id,
                    'business_name' => $svv['base_info']['business_name'],
                    'branch_name' => $svv['base_info']['branch_name'],
                    'telephone' => $svv['base_info']['telephone'],
                    'longitude' => $svv['base_info']['longitude'],
                    'latitude' => $svv['base_info']['latitude'],
                    'starttime' => $starttime,
                    'endtime' => $endtime,
                    'fsortid' => $fsortid,
                    'sortid' => $sortid,
                    'provinceid' => $provinceid,
                    'cityid' => $cityid,
                    'districtid' => $districtid,
                    'avg_price' => $svv['base_info']['avg_price'],
                    'address' => $svv['base_info']['address'],
                    'photo_list' => !empty($svv['base_info']['photo_list']) ? serialize($svv['base_info']['photo_list']) : '',
                    'cityname' => $svv['base_info']['city'],
                    'provincename' => $svv['base_info']['province'],
                    'offset_type' => $svv['base_info']['offset_type'],
                    'introduction' => $svv['base_info']['introduction'],
                    'recommend' => $svv['base_info']['recommend'],
                    'special' => $svv['base_info']['special'],
                    'districtname' => $svv['base_info']['district'],
                    'available_state' => $available_state,
                    'comefrom' => 1,
                    'addtime' => SYS_TIME,
                    'appid' => $appid
                );
                $tmpstore = $cashier_storesDb->get_one(array('mid' => $this->mid, 'poi_id' => $poi_id), 'id,mid,poi_id');
                if (!empty($tmpstore)) {
                    $cashier_storesDb->update($inserDatas, array('id' => $tmpstore['id']));
                } else {
                    $cashier_storesDb->insert($inserDatas, True);
                }
            }
        }

        return $nodata;
    }

    private function authorityList($data = '') {
        $authority = loadConfig('authority');
        $info = explode('/', $data);
        $result = $this->dataOut($authority, $info);
        unset($result['Des']);
        return $result;
    }

    private function dataOut($data, $goal) {
        foreach ($goal as $key => $val) {
            $data = $data[$goal[$key]];
        }
        return $data;
    }

    public function applyMerchant() {
        $wxCardPack = $this->wxHandle();
        $access_token = $wxCardPack->getToken();
        $res = $wxCardPack->GetSubCategroy($access_token);
        $data = array();
        foreach ($res['category'] as $rowset) {
            $temp = array('key' => $rowset['primary_category_id'], 'value' => $rowset['category_name']);

            foreach ($rowset['secondary_category'] as $row) {
                $temp['list'][$row['secondary_category_id']] = array('key' => $row['secondary_category_id'], 'value' => $row['category_name']);
            }
            $data[$rowset['primary_category_id']] = $temp;
        }
        $merchantDB = M('cashier_sub_merchant');
        $submerchant = $merchantDB->get_one(array('mid' => $this->mid), '*');

        $readonly = ($submerchant && $submerchant['status'] == 1 ) ? 'readonly' : '';
        if (isset($submerchant['end_time']) && $submerchant['end_time']) {
            $submerchant['end_time'] = date('Y-m-d', $submerchant['end_time']);
        }

        include $this->showTpl();
    }

    public function apply() {
        $data = $this->clear_html($_POST);
        if (empty($data['brand_name']))
            $this->dexit(array('errcode' => 1, 'errmsg' => '商家名称不能为空'));
        if (empty($data['logo_url']) && empty($data['logo_url_local']))
            $this->dexit(array('errcode' => 1, 'errmsg' => '商家LOGO不能为空'));
        if (empty($data['primary_category_id']))
            $this->dexit(array('errcode' => 1, 'errmsg' => '请选所属类目'));
        if (empty($data['secondary_category_id']))
            $this->dexit(array('errcode' => 1, 'errmsg' => '请选子类目'));
        if (empty($data['end_time']))
            $this->dexit(array('errcode' => 1, 'errmsg' => '截止时间不能为空'));
        if (empty($data['protocol']) && empty($data['protocol_local']))
            $this->dexit(array('errcode' => 1, 'errmsg' => '请上传授权函'));

        $wxCardPack = $this->wxHandle();

        $access_token = $wxCardPack->getToken();
        $trimstr = DIRECTORY_SEPARATOR . 'Cashier' . DIRECTORY_SEPARATOR;

        //提交logo
        if (empty($data['logo_url']) && $data['logo_url_local']) {
            $wximgpath = str_replace($trimstr, '', ABS_PATH) . ltrim($data['logo_url_local'], '.');
            $wxlogimg = $wxCardPack->wxCardUpdateImg($access_token, $wximgpath);
            if (isset($wxlogimg['url']) && !empty($wxlogimg['url'])) {
                $data['logo_url'] = $wxlogimg['url'];
            } else {
                $this->dexit($wxlogimg);
            }
        }
        //提交授权书
        if (empty($data['protocol']) && $data['protocol_local']) {
            $wximgpath = str_replace($trimstr, '', ABS_PATH) . ltrim($data['protocol_local'], '.');
            $wxlogimg = $wxCardPack->wxUploadFile($access_token, array('media' => '@' . $wximgpath, 'type' => 'image'));
            if (isset($wxlogimg['media_id']) && !empty($wxlogimg['media_id'])) {
                $data['protocol'] = $wxlogimg['media_id'];
            } else {
                $this->dexit($wxlogimg);
            }
        }

//     	$submitData['info'] = array('brand_name' => $data['brand_name'], 'logo_url' => $data['logo_url'], 'primary_category_id' => $data['primary_category_id'], 'secondary_category_id' => $data['secondary_category_id'], 'protocol' => $data['protocol'], 'end_time' => strtotime($data['end_time']));

        $merchantDB = M('cashier_sub_merchant');
        $subMerchant = $merchantDB->get_one(array('mid' => $this->mid), '*');
//     	if ($subMerchant && $subMerchant['merchant_id']) {
//     		$submitData['info']['merchant_id'] = $subMerchant['merchant_id'];
//     	}
        $jsonData = '{"info":{';
        if ($subMerchant && $subMerchant['merchant_id']) {
            $jsonData .= '"merchant_id":' . $subMerchant['merchant_id'] . ',';
        }
        $jsonData .= '"brand_name":"' . $data['brand_name'] . '", "logo_url":"' . $data['logo_url'] . '", "protocol":"' . $data['protocol'] . '", "end_time":' . strtotime($data['end_time']) . ', "primary_category_id":' . $data['primary_category_id'] . ', "secondary_category_id":' . $data['secondary_category_id'] . '}}';

        $apply = $wxCardPack->CreateSubMerchant($access_token, $jsonData);
        if (empty($apply['errcode'])) {
            $saveData = $apply['info'];
            $saveData['status'] = $saveData['status'] == 'CHECKING' ? 0 : ($saveData['status'] == 'APPROVED' ? 1 : ($saveData['status'] == 'REJECTED' ? 2 : 3));
            $saveData['logo_url'] = $data['logo_url_local'];
            $saveData['protocol'] = $data['protocol_local'];
            $saveData['brand_name'] = $data['brand_name'];
            $saveData['mid'] = $this->mid;
            $info_config = loadConfig('info');
            $saveData['fmid'] = $info_config['SYSTEM_WEIXIN_CONFIG_ID'];
            //更改申请状态
            M('cashier_merchants')->update(array('apply' => 2), array('mid' => $this->mid));
            if ($subMerchant) {
                $merchantDB->update($saveData, array('mid' => $this->mid));
            } else {
                $merchantDB->insert($saveData, array('mid' => $this->mid));
            }
        }
        $this->dexit($apply);
    }

    public function cancelapply() {
        if (M('cashier_merchants')->update(array('apply' => 2), array('mid' => $this->mid))) {
            $this->dexit(array('errcode' => 0, 'errmsg' => '取消成功'));
        } else {
            $this->dexit(array('errcode' => 1, 'errmsg' => '取消失败，稍后重试'));
        }
    }

    public function selectapply() {
        $merchantDB = M('cashier_sub_merchant');
        if ($submerchant = $merchantDB->get_one(array('mid' => $this->mid), '*')) {
            $wxCardPack = $this->wxHandle();
            $access_token = $wxCardPack->getToken();
            $info = $wxCardPack->GetSubMerchant($access_token, json_encode(array('merchant_id' => $submerchant['merchant_id'])));
            if (empty($info['errcode'])) {
                $return = array('errcode' => 0);
                $apply = -1;
                $status = -1;
                switch ($info['info']['status']) {
                    case 'CHECKING'://审核中
                        $apply = 2;
                        $status = 0;
                        $return['errmsg'] = '审核中';
                        break;
                    case 'APPROVED'://审核通过
                        $apply = 3;
                        $status = 1;
                        $return['errmsg'] = '审核通过';
                        break;
                    case 'REJECTED'://被驳回
                        $apply = 4;
                        $status = 2;
                        $return['errmsg'] = '审核被驳回';
                        break;
                    case 'EXPIRED'://协议已过期
                        $apply = 5;
                        $status = 3;
                        $return['errmsg'] = '协议已过期';
                        break;
                }
                if ($apply != -1 && $status != -1) {
                    $merchantDB->update(array('status' => $status), array('mid' => $this->mid));
                    M('cashier_merchants')->update(array('apply' => $apply), array('mid' => $this->mid));
                }
                $this->dexit($return);
            } else {
                $this->dexit($info);
            }
        }
        $this->dexit(array('errcode' => 1, 'errmsg' => '您还没有申请子商户'));
    }

    public function uploadIcon() {
        if (!empty($_FILES)) {
            $return = $this->oldUploadFile('mercahnt', $this->mid);
            if (isset($return['data']) && !empty($return['data'])) {
                $imgpath = $return['data']['0']['savepath'] . $return['data']['0']['savename'];
                $this->dexit(array('error' => 0, 'icon' => $imgpath));
            }
        }
        $this->dexit(array('error' => 1, 'msg' => ''));
    }

    public function upLoadCert() {
        if (IS_POST) {
            if (!empty($_FILES)) {

                $return = $this->oldUploadFile('png', $_GET['mid']);

                if ($return['error'] > 0) {
                    $this->dexit(array('error' => 1, 'msg' => $return['data']));
                } else {
                    $filesinfo = $return['data']['0'];
                    $this->dexit(array('error' => 0, 'msg' => 'OK', 'fileUrl' => $return['imgurl'] . $filesinfo['savename'], 'originalfilename' => $filesinfo['name'], 'fileSize' => $filesinfo['size']));
                }
            }
            $this->dexit(array('error' => 1, 'msg' => '没有上传文件！'));
        }
    }

    public function uploadImg() {
        if (!empty($_FILES)) {
            $return = $this->oldUploadFile('mercahnt', $this->mid);
            if (isset($return['data']) && !empty($return['data'])) {
                $imgpath = $return['data']['0']['savepath'] . $return['data']['0']['savename'];
                $trimstr = DIRECTORY_SEPARATOR . 'Cashier' . DIRECTORY_SEPARATOR;
                $wximgpath = str_replace($trimstr, '', ABS_PATH) . ltrim($imgpath, '.');

                $wxCardPack = $this->wxHandle();
                $access_token = $wxCardPack->getToken();

                $wxlogimg = $wxCardPack->wxCardUpdateImg($access_token, $wximgpath);

                if (isset($wxlogimg['url']) && !empty($wxlogimg['url'])) {
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

    public function upcert() {

        if (IS_POST) {
            if (!empty($_FILES)) {

                $return = $this->oldUploadFile('png', $_GET['mid']);

                if ($return['error'] > 0) {
                    $this->dexit(array('error' => 1, 'msg' => $return['data']));
                } else {
                    $filesinfo = $return['data']['0'];
                    $this->dexit(array('error' => 0, 'msg' => 'OK', 'fileUrl' => $return['imgurl'] . $filesinfo['savename'], 'originalfilename' => $filesinfo['name'], 'fileSize' => $filesinfo['size']));
                }
            }
            $this->dexit(array('error' => 1, 'msg' => '没有上传文件！'));
        }
    }

    public function uploadFile() {
        if (!empty($_FILES)) {
            $return = $this->oldUploadFile('mercahnt', $this->mid);
            if (isset($return['data']) && !empty($return['data'])) {
                $imgpath = $return['data']['0']['savepath'] . $return['data']['0']['savename'];
                $trimstr = DIRECTORY_SEPARATOR . 'Cashier' . DIRECTORY_SEPARATOR;
                $wximgpath = str_replace($trimstr, '', ABS_PATH) . ltrim($imgpath, '.');
                $wxCardPack = $this->wxHandle();
                $access_token = $wxCardPack->getToken();
                $wxlogimg = $wxCardPack->wxUploadFile($access_token, array('media' => '@' . $wximgpath, 'type' => 'image'));
                if (isset($wxlogimg['media_id']) && !empty($wxlogimg['media_id'])) {
                    $this->dexit(array('error' => 0, 'media_id' => $wxlogimg['media_id'], 'localimg' => $imgpath));
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

    private function wxHandle() {
        bpBase::loadOrg('wxCardPack');
        $wx_user = M('cashier_payconfig')->get_wx_info($this->mid);
        $wxCardPack = new wxCardPack($wx_user, $this->mid);
        return $wxCardPack;
    }

    private function returnname($data, &$sourceData) {
        if (!empty($data['fid'])) {
            $sourceData[$data['fid']]['isdel'] = 1;
            $data = array('name' => $sourceData[$data['fid']]['name'] . ',' . $data['name'], 'fid' => $sourceData[$data['fid']]['fid']);
            return $this->returnname($data, $sourceData);
        } else {
            return $data['name'];
        }
    }

    public function refreshCategroy() {

        $lists = M('cashier_category')->select();
        $id_key_list = array();
        foreach ($lists as $row) {
            $row['isdel'] = 0;
            $id_key_list[$row['id']] = $row;
        }

        $categroy_all = array();
        foreach ($lists as $l) {
            $categroy_all[$l['id']] = $this->returnname($l, $id_key_list);
        }

        $category_list = array();
        foreach ($id_key_list as $r) {
            if (empty($r['isdel']))
                $category_list[] = $categroy_all[$r['id']];
        }
        $wxCardPack = $this->wxHandle();
        $access_token = $wxCardPack->getToken();
        $res = $wxCardPack->GetApplyProtocol($access_token);
        $old = array();
        foreach ($res['category_list'] as $row) {
            if (in_array($row, $category_list))
                continue;
            $temp = explode(',', $row);
            $index = '';
            foreach ($temp as $k => $val) {
                $lastindex = $index;
                $index .= $val;
                if (!isset($old[$index])) {
                    $fid = isset($old[$lastindex]) && $old[$lastindex] ? $old[$lastindex] : 0;
                    $id = M('cashier_category')->insert(array('fid' => $fid, 'name' => $val), true);
                    $old[$index] = $id;
                }
            }
        }
    }

    public function menu() {
        $cf = isset($_GET['cf']) ? trim($_GET['cf']) : '';
        $whereArr = array('mid' => $this->mid, 'ishd' => 0);
        if ($cf == 'card') {
            $whereArr['ishd'] = 1;
        }
        $lists = M('cashier_menu')->select($whereArr);
        include $this->showTpl();
    }

    public function addmenu() {
        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $cf = isset($_GET['cf']) ? trim($_GET['cf']) : '';
        $where = array('id' => $id, 'mid' => $this->mid);
        $cashier_menu_db = M('cashier_menu');
        $menu = $cashier_menu_db->get_one($where);
        if (IS_POST) {
            $data = array('mid' => $this->mid);
            $data['sort'] = isset($_POST['sort']) ? intval($_POST['sort']) : 0;
            $data['is_hide'] = isset($_POST['is_hide']) ? intval($_POST['is_hide']) : 0;
            $data['name'] = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
            $data['icon'] = isset($_POST['icon']) ? htmlspecialchars($_POST['icon']) : '';
            $data['url'] = isset($_POST['url']) ? htmlspecialchars($_POST['url']) : '';
            $ishd = isset($_POST['cf']) ? trim($_POST['cf']) : '';
            if ($ishd == 'card') {
                $data['ishd'] = 1;
            }
            if (empty($data['name']))
                $this->dexit(array('errcode' => 1, 'errmsg' => '菜单名称不能为空'));
            if ($menu) {
                $cashier_menu_db->update($data, $where);
            } else {
                $cashier_menu_db->insert($data);
            }
            $this->dexit(array('errcode' => 0, 'errmsg' => 'ok'));
        } else {
            $url_array = parse_url($_SERVER['HTTP_REFERER']);
            $host_url = $url_array['scheme'] . '://' . $url_array['host'];
            include $this->showTpl();
        }
    }

    public function delmenu() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        M('cashier_menu')->delete(array('id' => $id, 'mid' => $this->mid));
        $this->dexit(array('errcode' => 1, 'errmsg' => 'ok'));
    }

    public function chnagehide() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $is_hide = isset($_POST['is_hide']) ? intval($_POST['is_hide']) : 0;
        M('cashier_menu')->update(array('is_hide' => $is_hide), array('id' => $id, 'mid' => $this->mid));
        exit();
    }

    /*     * *****支付优惠***收银台里最没意思的功能-_-***** */

    public function payreduce() {
        $payreduceDb = M('cashier_payreduce');
        bpBase::loadOrg('common_page');
        $where = array('mid' => $this->mid);
        $_count = $payreduceDb->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $payreduce = $payreduceDb->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');
        include $this->showTpl();
    }

    public function dopayreduce() {
        $data = $this->clear_html($_POST);
        $idd = 0;
        if (isset($data['idd'])) {
            $idd = !empty($data['idd']) ? intval($data['idd']) : 0;
            unset($data['idd']);
        }
        if (empty($data['ntitle'])) {
            $this->dexit(array('error' => 1, 'errmsg' => '标题必须填写！'));
        }

        if (empty($data['fullprice']) || !is_numeric($data['fullprice'])) {
            $this->dexit(array('error' => 1, 'errmsg' => '使用门槛金额必须要填写！'));
        }

        if (empty($data['minprice']) || !is_numeric($data['minprice'])) {
            $this->dexit(array('error' => 1, 'errmsg' => '减价金额区间最低金额必须要填写！'));
        }

        if (!empty($data['maxprice']) && is_numeric($data['maxprice']) && ($data['maxprice'] <= $data['minprice'])) {
            $this->dexit(array('error' => 1, 'errmsg' => '减价金额区间最高金额必须大于最低金额，或者可以不填写'));
        }

        $data['starttime'] = !empty($data['starttime']) ? strtotime($data['starttime']) : 0;
        $data['starttime'] = $data['starttime'] > 0 ? $data['starttime'] : 0;

        $data['endtime'] = !empty($data['endtime']) ? strtotime($data['endtime']) : 0;
        $data['endtime'] = $data['endtime'] > 0 ? $data['endtime'] + 86399 : 0;
        $data['ptypewx'] = !empty($data['ptypewx']) ? intval($data['ptypewx']) : 0;
        $data['ptypeali'] = !empty($data['ptypeali']) ? intval($data['ptypeali']) : 0;
        $payreduceDb = M('cashier_payreduce');
        if ($idd > 0) {
            if ($payreduceDb->update($data, array('id' => $idd, 'mid' => $this->mid))) {
                $this->dexit(array('error' => 0, 'errmsg' => '修改成功！'));
            } else {
                $this->dexit(array('error' => 1, 'errmsg' => '修改失败！'));
            }
        } else {
            $data['mid'] = $this->mid;
            $data['addtime'] = SYS_TIME;
            if ($payreduceDb->insert($data, true)) {
                $this->dexit(array('error' => 0, 'errmsg' => '添加成功！'));
            } else {
                $this->dexit(array('error' => 1, 'errmsg' => '添加失败！'));
            }
        }
    }

    public function delReduce() {
        $idd = intval($_POST['iid']);
        $payreduceDb = M('cashier_payreduce');
        if ($idd > 0) {
            if ($payreduceDb->delete(array('id' => $idd, 'mid' => $this->mid))) {
                $this->dexit(array('error' => 0, 'errmsg' => '删除成功！'));
            }
        }
        $this->dexit(array('error' => 1, 'errmsg' => '删除失败！'));
    }

    /*     * ***获取一条数据**** */

    public function getonereduce() {
        $idd = intval($_POST['iid']);
        if ($idd > 0) {
            $payreduceDb = M('cashier_payreduce');
            $payreduce = $payreduceDb->get_one(array('id' => $idd, 'mid' => $this->mid), '*');
            if (!empty($payreduce)) {
                $payreduce['starttimeStr'] = $payreduce['starttime'] > 0 ? date('Y-m-d', $payreduce['starttime']) : '';
                $payreduce['endtimeStr'] = $payreduce['endtime'] > 0 ? date('Y-m-d', $payreduce['endtime']) : '';
                $this->dexit(array('error' => 0, 'errmsg' => 'OK', 'data' => $payreduce));
            }
        }
        $this->dexit(array('error' => 1, 'errmsg' => '获取数据失败！'));
    }

    /*     * *****支付优惠**收银台里最没意思的功能-_-****** */

    /**
     * 商户列表
     */
    public function merchantList() {
        $sqlObj = new model();
        $getdata = $this->clear_html($_GET);
        if ($getdata['company']) {
            $where = " AND company LIKE '%" . $getdata['company'] . "%'";
        }
        //分页
        $count_merchants_sql = "SELECT count(*) as count FROM " . $this->tablepre . "cashier_merchants a  WHERE sid =" . $this->salesmans['id'] . $where . $limit;
        $count_merchants = $sqlObj->selectBySql($count_merchants_sql);
        bpBase::loadOrg('common_page');

        $p = new Page($count_merchants[0]['count'], 15);
        $pagebar = $p->show(2);
        $limit = ' ORDER BY a.mid ASC LIMIT ' . $p->firstRow . ',' . $p->listRows;


        //查询商家
        $cashier_merchants_sql = "SELECT a.mid as merchants_id,a.isopenwxpay,a.isopenalipay,a.username,a.company,a.regTime,a.mtype FROM " . $this->tablepre . "cashier_merchants a  WHERE sid =" . $this->salesmans['id']." AND mid <> 1 " . $where . $limit;
        $cashier_merchants = $sqlObj->selectBySql($cashier_merchants_sql);
        //重组数组
        $data = array();
        foreach ($cashier_merchants as $k => $v) {
            $data[$k] = $v;
            if ($v['configData']) {
                $data[$k]['pay'] = unserialize(htmlspecialchars_decode($v['configData'], ENT_QUOTES)); //反序列化
            } else {
                $data[$k]['pay'] = null;
            }
            unset($data[$k]['configData']);
        }
        include $this->showTpl();
    }

    
    /**
     * 添加商户
     */
    public function createMerchant() {

        if (IS_POST) {
            $salesmans = $this->salesmans;
            $data = $this->clear_html($_POST);
            //判断是否为修改 
            $pwd = $data['password'];
            if (empty($data['mid'])) {
                if (M('cashier_merchants')->get_one(array('username' => $data['username']), 'mid')) {
                    $this->errorTip('账户名称已存在', $_SERVER['HTTP_REFERER']);
                    exit;
                }
                $makeMerchant['regIp'] = ip();
                $makeMerchant['regTime'] = time();
            }
            $makeMerchant['username'] = $data['username'];
            //验证手机号
            if (!isMobile($data['phone'])) {
                $this->errorTip('不是有效的手机号码', $_SERVER['HTTP_REFERER']);
                exit;
            }
            $makeMerchant['phone'] = $data['phone'];
            if (!empty($data['tel']) && !empty($data['telPrefix'])) {
                $makeMerchant['tel'] = $data['telPrefix'] . '-' . $data['tel'];
            }
            //验证密码
            if (!empty($data['password'])) {
                if ($data['password'] != $data['password2']) {
                    $this->errorTip('两次密码不相同', $_SERVER['HTTP_REFERER']);
                    exit;
                }
                $makeMerchant['salt'] = mt_rand(111111, 999999);
                $makeMerchant['password'] = $this->toPassword($data['password'], $makeMerchant['salt']);
            } else {
                if (!empty($data['changePwd']) || empty($data['mid'])) {
                    $this->errorTip('请填写密码', $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }
            $makeMerchant['sid'] = $salesmans['id'];
            $makeMerchant['aid'] = $this->salesmans['aid'];

            if (empty($data['realname'])) {
                $this->errorTip('请填写联系人', $_SERVER['HTTP_REFERER']);
            }

            $makeMerchant['address'] = $data['detailAddress'];//详细地址填写值


            if ($data['provinceinfo']) {
                $makeMerchant['fulladdress'].= $data['provinceinfo'];
                if ($data['cityinfo']) {
                    $makeMerchant['fulladdress'].= $data['cityinfo'];
                    if ($data['cityinfo']) {
                        $makeMerchant['fulladdress'].= $data['districtinfo'];
                    }
                }
            }

            $makeMerchant['fulladdress'] = $data['detailAddress'];


            if (!empty($data['mtype'])){
                 $makeMerchant['mtype'] = $data['mtype'];
            }
           
            //微信费率判断
            $makeMerchant['commission'] = $data['commission']/100;
            $makeMerchant['alicommission'] = $data['alicommission']/100;
            $makeMerchant['realname'] = $data['realname'];
            $makeMerchant['company'] = $data['company'];
            $makeMerchant['city'] = $_POST['city'];
            $makeMerchant['province'] = $_POST['province'];
            $makeMerchant['area'] = $_POST['area'];
            if (empty($data['mid'])) {
                $vo = M('cashier_merchants')->insert($makeMerchant,1);
                if ($vo) {
                    $url = $this->SiteUrl . '/index.php';
                    bpBase::loadOrg('Email');
                    $email = new Email();
                    $subject = "重庆云极付有限公司平台商户注册成功通知"; //设置邮箱标题
                    $address = $_POST['username']; //需要发送的邮箱地址
                    $content = <<<ETC
                 <div style="width: 80%; background: #FFFFFF;">
        			<h1 style="font-weight: normal; text-align: center; width: 100%; border-bottom: 1px solid #F3F3F3;">欢迎注册云极付商户平台</h1>
        			<div style="padding: 0 30px;">账号注册成功<a style="text-decoration: none; margin-left:150px; display: inline-block; width: 80px; height: 30px; background: #007AFF; color: #FFFFFF; border-radius: 5px; text-align: center; line-height: 30px; margin-top: 10px;" href=" $url ">立即登录</a></div>
        			<p style="padding: 0 30px;">我们已向你的邮箱 $address 发送邮件,登录密码: $pwd </p>
        		</div>
ETC;
                    $res = $email->send_email($address, $subject, $content);
                    // 给商户配置添加信息
                    $payconfigDb = M('cashier_payconfig');
                    $configData = serialize(array( 'weixin' => array('appid' => '', 'appSecret' => '' )));
                    if($makeMerchant['mtype'] == '1'){
                        $inserData = array('mid' => $vo, 'isOpen' => 1, 'configData' => $configData, 'pfpaymid' => '0','proxymid'=>1);
                    }else if($makeMerchant['mtype'] == '2'){
                        $inserData = array('mid' => $vo, 'isOpen' => 1, 'configData' => $configData, 'pfpaymid' => '1');
                    }
                    $payconfigDb->insert($inserData, 1);

                    $this->successTip('添加商户账号成功', '?m=Salesman&c=merchant&a=merchantList');
                    exit();
                } else {
                    $this->errorTip('添加商户账号失败', '?m=Salesman&c=merchant&a=merchantList');
                    exit();
                }
            } else {
                if (M('cashier_merchants')->update($makeMerchant, array('mid' => $data['mid']))) {
                    $this->successTip('账户保存成功', '?m=Salesman&c=merchant&a=merchantList');
                    exit();
                } else {
                    $this->errorTip('账户保存失败', '?m=Salesman&c=merchant&a=merchantList');
                    exit();
                }
            }
        } else {
            //省
            $districts = M('cashier_district')->select(array('fid' => '0'), '*', '', 'id ASC');
            //查询微信费率配置
            $cashier_wxrebate_wx = M('cashier_wxrebate')->get_one(array('type'=>1,'is_pay'=>2),'rebate');
            $cashier_wxrebate_wx = explode(',',$cashier_wxrebate_wx['rebate']);
            //查询支付宝费率配置
            $cashier_wxrebate_ali = M('cashier_wxrebate')->get_one(array('type'=>2,'is_pay'=>2),'rebate');
            $cashier_wxrebate_ali = explode(',',$cashier_wxrebate_ali['rebate']);
            if ($_GET['mid']) {
                $mid = $_GET['mid'];
                $merchants_data = M('cashier_merchants')->get_one(array('mid' => $mid), '*');
                $merchants_data['commission'] *= 100;
                $merchants_data['alicommission'] *= 100;
                $merchants_data['alicommission'] = strval($merchants_data['alicommission']);
                $merchants_data['commission'] = strval($merchants_data['commission']);
                $merchants_data['fullprovince'] = $this->getFullName($merchants_data['province']);
                $merchants_data['fullcity'] = $this->getFullName($merchants_data['city']);
                $merchants_data['fullarea'] = $this->getFullName($merchants_data['fullarea']);
                //市
                $districts_city = M('cashier_district')->select(array('fid' => intval($merchants_data['province'])), '*', '', 'id ASC');
                //区
                $districts_area = M('cashier_district')->select(array('fid' => $merchants_data['city']), '*', '', 'id ASC');

                $merchants_data['telPrefix'] = explode('-', $merchants_data['tel']);
            }
            include $this->showTpl();
        }
    }

    // 进件
    public function regist() {
        if (IS_POST) {
            $postdata = $this->clear_html($_POST);
            if (!$postdata['mid']) {
                $this->errorTip('不存在的商户');
            }
            $saveData['mid'] = $postdata['mid'];

            if (trim($postdata['contactor']) == '') {

                $this->errorTip('联系人不能为空');
            }
            $saveData['contactor'] = $postdata['contactor'];

            if (!preg_match("/^1[345678]\d{9}$/", $postdata['tel'])) {

                $this->errorTip('不是有效的手机号');
            }
            $saveData['tel'] = $postdata['tel'];

            if (!preg_match('/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/', $postdata['email'])) {
                $this->errorTip('邮箱格式不对');
            }
            $saveData['email'] = $postdata['email'];

            if ($postdata['shortname'] == '') {

                $this->errorTip('公司简称不能为空');
            }
            $saveData['shortname'] = $postdata['shortname'];

            if (empty($postdata['tradelevel1'])) {
                $this->errorTip('请选择行业');
            }
            $saveData['mclevel1'] = $postdata['tradelevel1'];
            $arr1 = $this->getRegData($saveData['mclevel1']);
            $saveData['level1'] = $arr1['name'];

            if (empty($postdata['tradelevel2'])) {
                $this->errorTip('请选择主体');
            }
            $saveData['mclevel2'] = $postdata['tradelevel2'];
            $arr2 = $this->getRegData($saveData['mclevel2']);
            $saveData['level2'] = $arr2['name'];
            $saveData['mclevel3'] = $postdata['tradelevel3'];
            $arr3 = $this->getRegData($saveData['mclevel3']);


            $saveData['level3'] = $arr3['name'];
            $saveData['rates'] = $arr3['rate'];
            $saveData['cycle'] = $arr3['settlement'];

            if (!empty($postdata['website'])) {
                $saveData['website'] = $postdata['website'];
            }


            if (!empty($postdata['phone'])) {
                $saveData['phone'] = $postdata['phone'];
            }



            //《建设用地规划许可证》
            if ($postdata['constructLeanIDList']) {

                $saveData['constructLeanID'] = json_encode($postdata['constructLeanIDList']);
            }
            // 《建设工程规划许可证》
            if ($postdata['constructLeanList']) {
                $saveData['constructLean'] = json_encode($postdata['constructLeanList']);
            }

            // 《建筑工程开工许可证》
            if ($postdata['cunstructIDList']) {
                $saveData['cunstructID'] = json_encode($postdata['cunstructIDList']);
            }

            // 《国有土地使用证》
            if ($postdata['landUseIdList']) {
                $saveData['landUseId'] = json_encode($postdata['landUseIdList']);
            }

            // 《商品房预售许可证》
            if ($postdata['allowIDList']) {
                $saveData['allowID'] = json_encode($postdata['allowIDList']);
            }

            // 《法人登记证书》
            if ($postdata['contactList']) {

                $saveData['contact'] = json_encode($postdata['contactList']);
            }


            // 《组织机构代码证》
            if ($postdata['groupIDList']) {
                $saveData['groupID'] = json_encode($postdata['groupIDList']);
            }

            // 特殊资质
            if ($postdata['specialList']) {
                $saveData['special'] = json_encode($postdata['specialList']);
            }


            // 售卖
            if ($postdata['dealdesc']) {
                $saveData['dealdesc'] = $postdata['dealdesc'];
            }

            // 补充材料
            if ($postdata['annuxesList']) {
                $saveData['annexs'] = json_encode($postdata['annuxesList']);
            }
         
            // 判断是不是提交过
            $check = M('cashier_regist')->get_one(array('mid' => $postdata['mid']), '*');
            if ($check) {
                //修改
                $result = M('cashier_regist')->update($saveData, array('id' => $postdata['id']));
                
                //修改过后跳转
                if($result){
                    $res = M('cashier_regist')->get_one(array('mid'=>$saveData['mid']),'*');
               
                   if ( empty($res['company']) || empty($res['bank']) ){
                    
                        header('location:?m=Salesman&c=merchant&a=regMerchantInfo&mid='.$saveData['mid']);
                   }else{

                        header('location:?m=Salesman&c=merchant&a=showReg&mid='.$saveData['mid']);exit();
                   }

                    // header('location:?m=Salesman&c=merchant&a=showReg&mid='.$saveData['mid']);exit();

                }
            } else {//添加
                $result = M('cashier_regist')->insert($saveData, ture);
            }

            if ($result) {
                header('location:?m=Salesman&c=merchant&a=regMerchantInfo&mid=' . $saveData['mid']);
            }
            $this->successTip('数据保存成功');
    }
    if (!empty($_GET['mid'])){
            $getdata = $this->clear_html($_GET);
            $list =  M('cashier_pieces')->get_all('name,id','',array('fid'=>0));
            $status =  M('cashier_regist')->get_var(array('mid'=>$getdata['mid']),'status');
            if($status){
                $status = isset($status) ? $status : 0;
            }
            
            //判断是否为修改
            if(isset($getdata['type'])){
                $reg =  M('cashier_regist')->get_one(array('mid'=>$getdata['mid']),'*');
                //补充材料图片
                if($reg['annexs']){
                    $reg['annexs'] = json_decode($reg['annexs'],true);
                }
                //特殊资质
                if($reg['special']){
                    $reg['special'] = json_decode($reg['special'],true);
                }
                //组织机构代码证
                if($reg['groupID']){
                    $reg['groupID'] = json_decode($reg['groupID'],true);
                }
                //法人登记证书
                if($reg['contact']){
                    $reg['contact'] = json_decode($reg['contact'],true);
                }
                //商品房预售许可证
                if($reg['allowID']){
                    $reg['allowID'] = json_decode($reg['allowID'],true);
                }
                //国有土地使用证
                if($reg['landUseId']){
                    $reg['landUseId'] = json_decode($reg['landUseId'],true);
                }
                //建筑工程开工许可证
                if($reg['cunstructID']){
                    $reg['cunstructID'] = json_decode($reg['cunstructID'],true);
                }
                //建设工程规划许可证
                if($reg['constructLean']){
                    $reg['constructLean'] = json_decode($reg['constructLean'],true);
                }
                //建设用地规划许可证
                if($reg['constructLeanID']){
                    $reg['constructLeanID'] = json_decode($reg['constructLeanID'],true);
                }
                //查询行政表
                $pieces_one = M('cashier_pieces')->select(array('fid'=>0),'*');//查询一级
                $pieces_two = M('cashier_pieces')->select(array('fid'=>$reg['mclevel1']),'*');//查询二级
                $pieces_three = M('cashier_pieces')->select(array('fid'=>$reg['mclevel2']),'*');//查询三级
                //查询显示内容
                $reg_list = M('cashier_pieces')->get_one(array('id'=>$reg['mclevel3']),'*');
            }else{
                
                if (($status == '1' || $status == '2' || $status == 0 || $status == '3' || $status == '4') && (isset($status))){
                    header('location:?m=Salesman&c=merchant&a=showReg&mid='.$getdata['mid']);exit;
                }
                
            }
            include $this->showTpl();
        }
        
    }

    public function getRegData($id) {

        $arr = M('cashier_pieces')->get_one(array('id' => $id), '*');
        return $arr;
    }

    // 获取第二级
    public function getSecondLevel() {

        $postdata = $this->clear_html($_POST);

        $list = M('cashier_pieces')
                ->select(array('fid' => $postdata['id']), 'name,id');
        exit(json_encode(array('data' => $list)));
    }

    // 获取第三级
    public function getThirdLevel() {

        $postdata = $this->clear_html($_POST);

        $list = M('cashier_pieces')
                ->select(array('fid' => $postdata['id']), 'name,id');
        exit(json_encode(array('data' => $list)));
    }

    public function getFourthlevel() {
        if (!IS_POST)
            return false;
        $postdata = $this->clear_html($_POST);

        $list = M('cashier_pieces')
                ->select(array('id' => $postdata['id']), 'type,rate,settlement');

        $this->dexit($list);
        exit;
    }

    /*     * ******获取城市或区域信息******* */

    public function GetDistricts() {
        $districtid = isset($_POST['districtid']) ? trim($_POST['districtid']) : 0;
        if ($districtid > 0) {
            $districts = M('cashier_district')->select(array('fid' => $districtid), '*', '', 'id ASC');
            $this->dexit(array('error' => 0, 'data' => !empty($districts) ? $districts : ''));
        }
        $this->dexit(array('error' => 1, 'data' => ''));
    }

    /**
     *  商户信息
     */
    public function mngMerchant() {
        if (empty($_GET['mid'])) {
            $this->errorTip('账号异常出错');
        }

        $status = M('cashier_regist')->get_var(array('mid'=>$_GET['mid']),'status');
        //$status = $status ? $status : 0;//不存在的时候


        $where['mid'] = $_GET['mid'];
        $merchant = M('cashier_merchants')->get_one($where, 'username,mid,wxname,phone,company,realname,commission,phone,tel,aid,mtype,sid,address,alicommission');
        include $this->showTpl();
    }

    public function getFullName($id = 0) {
        if (!isset($id))
            $id = 0;
        $name = M('cashier_district')->get_one(array('id' => $id), 'fullname');
        return $name['fullname'];
    }

    /**
     * 导出excel
     */
    public function MerchantsExcel() {
        //查询数据
        $merchants = M('cashier_merchants')->select(array('sid' => $this->salesmans['id']));
        //组装数据Excel导出数据
        $data = array();
        foreach ($merchants as $key => $val) {
            $data[$key]['mid'] = ' ' . $val['mid'] . ' '; //商户id
            $data[$key]['username'] = $val['username']; //登录帐号
            $data[$key]['company'] = $val['company']; //商户名称
            $data[$key]['regTime'] = date('Y-m-d H:i:s', $val['regTime']); //添加时间
            //判断支付类型
            if ($val['mtype'] == '2') {
                $data[$key]['ispay'] = '平台二清商户 ';
                continue;
            }
            //判断微信是否开通
            if ($val['isopenwxpay'] == '1') {
                $data[$key]['ispay'] = '微信支付(已开通) ';
            } else {
                $data[$key]['ispay'] = '微信支付(未开通) ';
            }
            //判断支付宝是否开通
            if ($val['isopenalipay'] == '1') {
                $data[$key]['ispay'] .= '支付宝支付(已开通) ';
            } else {
                $data[$key]['ispay'] .= '支付宝支付(未开通) ';
            }
        }
        $title = array('商户ID', '登录帐号', '商户名', '添加时间', '支付配置');
        $filename = '业务员:【' . $this->salesmans['username'] . '】下的所有商户.xls';
        $this->ExportTable($data, $title, $filename);
    }

    // 检测是否直接等过去
    public function check($mid) {

        $exist = M('cashier_regist')->get_one(array('mid' => $mid));

        if (!$exist) {
            $this->errorTip('', '?m=Salesman&c=merchant&a=go2Regeist&mid=' . $mid);
        }
    }

// 填写商户
    public function regMerchantInfo() {

        if (IS_POST) {


            $postdata = $this->clear_html($_POST);
            if (empty($postdata['mid'])) {
                $this->errorTip('不存在的商户');
            }

            $saveData['mid'] = $postdata['mid'];
            if (empty($postdata['company'])) {
                $this->errorTip('请填写商户名称');
            }
            $saveData['company'] = $postdata['company'];

            if (empty($postdata['address'])) {
                $this->errorTip('请填写注册地址');
            }
            $saveData['address'] = $postdata['address'];

            if (empty($postdata['icence'])) {
                $this->errorTip('请填写营业执照注册号');
            }
            $saveData['icence'] = $postdata['icence'];

            if (empty($postdata['mcarea'])) {
                $this->errorTip('请填写经营范围');
            }
            $saveData['mcarea'] = $postdata['mcarea'];

            if (empty($postdata['starttime'])) {
                $this->errorTip('缺少营业期限开始时间');
            }


            $saveData['starttime'] = $postdata['starttime'];

           if (empty($postdata['perd'])) {
                if (empty($postdata['endtime'])) {
                    $this->errorTip('缺少营业期限结束时间');
                }
                $saveData['endtime'] =  $postdata['endtime'];  
            }else{
                $saveData['endtime'] =  '长期';  
            }
            



            if (empty($postdata['licencephotoList'])) {
                $this->errorTip('请上传营业执照');
            }
            $saveData['licencephotoList'] = json_encode($postdata['licencephotoList']);


            if (empty($postdata['occode'])) {
                $this->errorTip('请填写组织机构代码');
            }
            $saveData['occode'] = $postdata['occode'];


            if (empty($postdata['validatestart'])) {
                $this->errorTip('请填写开始时间');
            }
            $saveData['validatestart'] = $postdata['validatestart'];



            if (empty($postdata['validate'])) {
                if (empty($postdata['validateend'])) {
                    $this->errorTip('请填写结束时间');
                }
                $saveData['validateend'] = $postdata['validateend'];
            }else{
                $saveData['validateend'] = '长期';
            }




            if (empty($postdata['occodephotoList'])) {
                $this->errorTip('组织机构代码证照');
            }
            $saveData['occodephotoList'] = json_encode($postdata['occodephotoList']);



            if (empty($postdata['idtype'])) {
                $this->errorTip('请填写经办人');
            }
            $saveData['idtype'] = $postdata['idtype'];


            if (empty($postdata['idname'])) {
                $this->errorTip('请填写证件持有人姓名');
            }
            $saveData['idname'] = $postdata['idname'];


            if (empty($postdata['idcard'])) {
                $this->errorTip('请填写身份证');
            }
            $saveData['idcard'] = $postdata['idcard'];

            if (empty($postdata['idphotoAList'])) {
                $this->errorTip('请上传身份证正面');
            }
            $saveData['idphotoAList'] = json_encode($postdata['idphotoAList']);

            if (empty($postdata['idphotoBList'])) {
                $this->errorTip('请上传身份证反面');
            }
            $saveData['idphotoBList'] = json_encode($postdata['idphotoBList']);


            if (empty($postdata['idstart'])) {
                $this->errorTip('身份证号码有效期不完整');
            }
            $saveData['idstart'] = $postdata['idstart'];


           if (empty($postdata['idlong'])) {
            if (empty($postdata['idend'])) {
                $this->errorTip('身份证号码有效期不完整');
            }
            $saveData['idend'] = $postdata['idend'];

            }else{
                 $saveData['idend'] = '长期';
            }


            if (empty($postdata['idnum'])) {
                $this->errorTip('请填写身份证');
            }

            $saveData['idnum'] = $postdata['idnum'];
            
          
            $result = M('cashier_regist')->update($saveData, array('mid' => $postdata['mid']));

            if ($result) {
                if($postdata['type']){
                    header('location:?m=Salesman&c=merchant&a=showReg&mid='.$saveData['mid']);exit();
                }else{
                    header('location:?m=Salesman&c=merchant&a=examine&mid=' . $saveData['mid']);
                }

            }
        } else if (!empty($_GET['mid'])) {
        $getdata = $this->clear_html($_GET);
            $this->check($getdata['mid']);
            if($getdata['type']){
                $reg = M('cashier_regist')->get_one(array('mid'=>$getdata['mid']),'*');
                if($reg['annexs']){
                    $reg['annexs'] = json_decode($reg['annexs'],true);
                }
                //特殊资质
                if($reg['special']){
                    $reg['special'] = json_decode($reg['special'],true);
                }
                //组织机构代码证
                if($reg['groupID']){
                    $reg['groupID'] = json_decode($reg['groupID'],true);
                }
                //法人登记证书
                if($reg['contact']){
                    $reg['contact'] = json_decode($reg['contact'],true);
                }
                //商品房预售许可证
                if($reg['allowID']){
                    $reg['allowID'] = json_decode($reg['allowID'],true);
                }
                //国有土地使用证
                if($reg['landUseId']){
                    $reg['landUseId'] = json_decode($reg['landUseId'],true);
                }
                //建筑工程开工许可证
                if($reg['cunstructID']){
                    $reg['cunstructID'] = json_decode($reg['cunstructID'],true);
                }
                //建设工程规划许可证
                if($reg['constructLean']){
                    $reg['constructLean'] = json_decode($reg['constructLean'],true);
                }
                //建设用地规划许可证
                if($reg['constructLeanID']){
                    $reg['constructLeanID'] = json_decode($reg['constructLeanID'],true);
                }
                
                if($reg['licencephotoList']){
                    $reg['licencephotoList'] = json_decode($reg['licencephotoList'],true);
                }
                if($reg['occodephotoList']){
                    $reg['occodephotoList'] = json_decode($reg['occodephotoList'],true);
                }
                
                if($reg['idphotoAList']){
                    $reg['idphotoAList'] = json_decode($reg['idphotoAList'],true);
                }
                if($reg['idphotoBList']){
                    $reg['idphotoBList'] = json_decode($reg['idphotoBList'],true);
                }
            }
            include $this->showTpl();
        }
    }

    public function examine() {

        if (IS_POST) {

            $postdata = $this->clear_html($_POST);
            $saveData['mid'] = $postdata['mid'];

            // 账户类型

            if (empty($postdata['accountType'])) {

                $this->errorTip('请填写银行账户类型');
            }
            $saveData['accountType'] = $postdata['accountType'];

            // 账户名

            if (empty($postdata['account'])) {

                $this->errorTip('请填写账户名称');
            }
            $saveData['account'] = $postdata['account'];

            // 开户银行
            if (empty($postdata['bank'])) {
                $this->errorTip('请填写开户银行');
            }
            $saveData['bank'] = $postdata['bank'];

            //  账户城市
            if (empty($postdata['bankaddress'])) {
                $this->errorTip('请填写账户名称');
            }

            $saveData['bankaddress'] = $postdata['bankaddress'];
            //  银行账号
            if (empty($postdata['accountid'])) {

                $this->errorTip('请填写银行账号');
            }
            $saveData['accountid'] = $postdata['accountid'];

            //  银行开户支行
            if (empty($postdata['bank_branch'])) {

                $this->errorTip('请填写银行开户支行');
            }
            $saveData['bank_branch'] = $postdata['bank_branch'];


            $result = M('cashier_regist')->update($saveData, array('mid' => $postdata['mid']));


            if ($result) {
                
                if($postdata['type']){
                    header('location:?m=Salesman&c=merchant&a=showReg&mid='.$saveData['mid']);exit();
                }else{
                    header('location:?m=Salesman&c=merchant&a=showReg&mid=' . $saveData['mid']);exit();
                }
            }
        }

        if (!empty($_GET['mid'])) {

           $getdata = $this->clear_html($_GET);
            $rinfo = M('cashier_regist')->get_one(array('mid'=>$getdata['mid']),'mclevel1,company,contactor');
            $accountType = $rinfo['mclevel1']==2 ? '个人账户':'对公账户';
            $account = $rinfo['mclevel1']== 2 ? $rinfo['contactor'] : $rinfo['company'];
            
            if($_GET['type']){
                $reg = M('cashier_regist')->get_one(array('mid'=>$getdata['mid']),'*');
            }
            
            $this->check($getdata['mid']);
        }

        include $this->showTpl();
    }
    // 显示信息
    public function showReg() {
        if (!empty($_GET['mid'])) {
            $getdata = $this->clear_html($_GET);
            $this->check($getdata['mid']);
            $merchant = M('cashier_merchants')->get_var(array('mid' => $getdata['mid']), 'company');
            $reg = M('cashier_regist')->get_one(array('mid' => $getdata['mid']));
            $type = M('cashier_pieces')->get_var(array('id' => $reg['mclevel3']), 'type');
            $lvl['fir'] = M('cashier_pieces')->get_var(array('id' => $reg['mclevel1']), 'name');
            $lvl['sec'] = M('cashier_pieces')->get_var(array('id' => $reg['mclevel2']), 'name');
            $lvl['thr'] = M('cashier_pieces')->get_var(array('id' => $reg['mclevel3']), 'name');
        }
        include $this->showTpl();
    }
    
    
    /**
     * 重新提交进件
     */
    public function again(){
        $postdata = $this->clear_html($_GET);
    
        $regist = M('cashier_regist')->update(array('status'=>0,'comments'=>''),array('mid'=>$postdata['mid']));
        if($regist){
            $this->successTip('提交成功');
        }else{
            $this->errorTip('重新提交失败');
        }
    
    }
    

}

?>