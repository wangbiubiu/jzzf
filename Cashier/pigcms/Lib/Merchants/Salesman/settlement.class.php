<?php

bpBase::loadAppClass('common', 'Salesman', 0);
bpBase::loadOrg('common_page');
class settlement_controller extends common_controller {

    private $SalesmanDb;
    protected $sid;

    public function __construct() {
        parent::__construct();
        $this->sid = $_SESSION['my_Cashier_Salesman']['sid'];

    }


    
    /**
     * 业务员我的结算
     */
    
    public function SalesmanForMe(){

        $obj = new model();


        $where24 = 'AND paytime < ' .strtotime(date('Ymd',time()));
        $sqlNow = 'SELECT SUM(salesmans_price) AS sum from '.$this->tablepre.'cashier_order WHERE  mid IN (SELECT mid FROM '.$this->tablepre.'cashier_merchants WHERE sid ='.$this->sid.') AND ispay = 1 AND saler_stm = 0 ';

        $sql24 = $sqlNow.$where24;

        $stmNow = $obj->selectBySql($sqlNow);
        $stm24 = $obj->selectBySql($sql24);
        $where = array(
            'settleid'=>$this->sid,
            'type'=>2,  
            );
       $count = M('cashier_apply')->count($where);
       $Sum = M('cashier_apply')->select($where,'sum(money) as sum');
       $Sum = $Sum[0]['sum'];
       $page = new Page($count,10);
       $p = $page->show();
       $limit= $page->firstRow.','.$page->listRows;
       $order = 'addtime desc';


       $settle = M('cashier_apply')->get_all('settleid,addtime,money,status',$this->tablepre.'cashier_apply',$where,$order,$limit);



        include $this->showTpl(); 
    }

    // 申请提现
    public function applyS() {

        if (!IS_POST) return false;

        $postdata = $this->clear_html($_POST);

        $obj = new model();
        // 判断接收数据是否与实际相符
        $sqlNow = 'SELECT SUM(salesmans_price) AS sum from '.$this->tablepre.'cashier_order WHERE  mid IN (SELECT mid FROM '.$this->tablepre.'cashier_merchants WHERE sid ='.$this->sid.') AND ispay = 1 AND paytime <'.$postdata['time'] . ' AND  saler_stm=0';

        $check = $obj->selectBySql($sqlNow);


        if ($check[0]['sum']==$postdata['money']){

            $whereSet = 'mid IN (select  mid from '.$this->tablepre.'cashier_merchants where sid ='.$this->sid.') AND ispay = 1';

            $sql = 'UPDATE '.$this->tablepre.'cashier_order set `saler_stm` = 1 WHERE '.$whereSet; 

            if ($obj->selectBySql($sql)) {

                $getName = $obj->selectBySql('select username from '.$this->tablepre.'cashier_salesmans where id ='.$this->sid);

                $data = array(
                    'settleid'=>$this->sid,
                    'money'=>$postdata['money'],
                    'name'=>  $getName[0]['username'],
                    'addtime'=>time(),
                    'type'=>2,
                    'status'=>0
                    );


               $result = M('cashier_apply')->insert($data,1);


                if ($result>0) {
                     $respose['status']=1;
                     $respose['msg']='申请成功, 提现记录生成,请刷新页面查看';

                }else{
                     $respose['status']=2;
                     $respose['msg']='申请成功, 提现记录生成出错';
                }
            }
      
        }else{
            $respose['status']=0;
            $respose['msg']='服务器忙....';
        }
    $this->dexit($respose);
    }

/*------------------------------------------------------------------------------*/ 
    public function test () {
       $this->fan =  M('cashier_fans');

       $authority = $this->authorityList('Merchants/User');
       $testemp =  $this->fan->select(array('mid'=>22,'sex'=>1));
       print_r($testemp);die;

       $this->select();

       include $this->showTpl();
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


    /* 填写银行卡信息 */
    public function yourInfo () {


            if (IS_POST) {


            $postdata = $this->clear_html($_POST['bankcardAndId']);
            // p($postdata);die;


            if  (!$this->isIDcardNumber($postdata['idcard'])){
                    $this->errorTip('不是有效的身份证!!');
            }
           

            if  (!$postdata['idA']){
                    $this->errorTip('请上传身份证正面图');
            }
            
            if  (!$postdata['idB']){
                    $this->errorTip('请上传身份证反面图');
            }  

            if  (!$postdata['bankAndID']){
                    $this->errorTip('请上传手拿身份证和银行卡正面图');
            }

            if  (!$postdata['bankaccount']){
                    $this->errorTip('请填写持卡人');
            }
            

            if  (!$postdata['bankname']){
                    $this->errorTip('请填写开户银行名称详细到开户支行');
            }
           

            if  (!$postdata['bankcard']){
                    $this->errorTip('请填写银行卡账号');
            }

            

            if  (!$postdata['bankA']){
                    $this->errorTip('请上传银行卡正面图');
            }
           

            if  (!$postdata['bankB']){
                    $this->errorTip('请上传银行卡反面图');
            }
          

            $savedata['bankandid'] = json_encode($postdata,JSON_UNESCAPED_UNICODE);
        
            $res = M('cashier_salesmans')->update($savedata,array('id'=>$this->sid));
            if ( $res ) {
             $this->successTip('数据保存成功');
            } 
        }else{

            $bankandid = json_decode(M('cashier_salesmans')->get_var(array('id'=>$this->sid),'bankandid'),true);
            include $this->showTpl();
        }
       
    }
    

    public function upfile () {

        if (IS_POST) {
            if (!empty($_FILES)) {

                $return = $this->oldUploadFile('card', $_GET['mid']);

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
    //是否是身份证
    public function isIDcardNumber ($idCardNumber='') {

        $patten ="/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/";

        return preg_match($patten, $idCardNumber);
    }    

    
}

?>