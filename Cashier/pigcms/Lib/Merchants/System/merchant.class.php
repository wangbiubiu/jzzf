<?php

bpBase::loadAppClass('common', 'System', 0);
class merchant_controller extends common_controller
{
    private $payConfigDb;
    public function __construct()
    {
        parent::__construct();
        bpBase::loadOrg('common_page');
        $this->payConfigDb = M('cashier_payconfig');
    }

    public function index()
    {
        $fid = ((isset($_GET['fid']) ? intval($_GET['fid']) : 0));
        $caregoryDB = M('cashier_category');
        $where = array('fid' => $fid);

        if ($fid) {
            $caregory = $caregoryDB->get_one(array('id' => $fid));
            $this->assign('category', $caregory);
        }


        $lists = $caregoryDB->select($where);
        $this->assign('lists', $lists);
        $this->assign('total', count($lists));
        $this->display();
    }


    //商户列表
    public function merLists()
    {
        bpBase::loadOrg('common_page');
        $data = $this->clear_html($_GET);
        $start = ((isset($data['start']) ? strtotime($data['start']) : 0));
        $end = ((isset($data['end']) ? strtotime($data['end']) : 0));

        $where = " status='1'";
        $wherestr = " m.status='1'";
        if($data['start']){
            $where .= ' AND regTime>=' . $start;
            $wherestr .= ' AND m.regTime>=' . $start;
        }
        if($data['end']){
            $where .= ' AND regTime<=' . $end;
            $wherestr .= ' AND m.regTime<=' . $end;
        }
        if($data['company']){
            $where .= " AND company like '%".$data['company']."%'";
            $wherestr .= " AND m.company like '%".$data['company']."%'";
        }
        $_count = M('cashier_merchants')->count($where);
        $p = new Page($_count, 15);
        $pagebar = $p->show(2);

        $sql = "SELECT m.mid,m.sub_merchant,m.username,m.company,m.mtype,m.regTime,m.isopenwxpay,m.isopenalipay,a.uname FROM ".$this->tablepre . "cashier_merchants as m LEFT JOIN ".$this->tablepre . "cashier_agent AS a ON a.aid=m.aid where ".$wherestr ." ORDER BY m.mid DESC LIMIT " .$p->firstRow . ',' . $p->listRows;
        $sqlObj = new model();
        $merInfo = $sqlObj->selectBySql($sql);
        foreach($merInfo as $k => &$v){
            $v['regTime'] = date('Y-m-d',$v['regTime']);
            $payconfig = M("cashier_payconfig") -> get_one(array("mid"=>$v['mid']),"*");
            if ($payconfig['configData']) {
                $payConfig = unserialize(htmlspecialchars_decode($payconfig['configData'], ENT_QUOTES));
//                dump($payConfig);
//                $v['fromSaler'] = M('cashier_salesmans')->get_one('id=' . $v['sid'], 'username')['username'];
                if ($v['mtype'] == "1") {
                    $state1 = M('cashier_regist')->get_one("mid='" . $v['mid'] . "' AND contactor <> ''", 'status');//微信状态
                    $state2 = $state1;//支付宝状态
                    if ($state1['status'] != 2 || empty($state1)) {
                        $merInfo[$k]['isopenwxpay'] = 0;
                        $merInfo[$k]['isopenalipay'] = 0;
                    }
                    else{
                        if(empty($payConfig['weixin']['mchid'])){
                            $merInfo[$k]['isopenwxpay'] = 0;
                        }
                        else{
                            $merInfo[$k]['isopenwxpay'] = 1;
                        }
                        if(empty($payConfig['alipay']['appauthtoken'])){
                            $merInfo[$k]['isopenalipay'] = 0;
                        }
                        else{
                            $merInfo[$k]['isopenalipay'] = 1;
                        }
                    }
                } else {
                    $state1 = M('cashier_regist')->get_one("mid='" . $v['mid'] . "' AND wechat <> ''", 'status');//微信状态
                    $state2 = M('cashier_regist')->get_one("mid='" . $v['mid'] . "' AND alipay <> ''", 'status');//支付宝状态
                    if ($state1['status'] != 2 || empty($state1)) {
                        $merInfo[$k]['isopenwxpay'] = 0;
                    }
                    else{
                        if(empty($payConfig['weixin']['mchid'])){
                            $merInfo[$k]['isopenwxpay'] = 0;
                        }
                        else{
                            $merInfo[$k]['isopenwxpay'] = 1;
                        }
                    }
                    if ($state2['status'] != 2 || empty($state2)) {
                        $merInfo[$k]['isopenalipay'] = 0;
                    }
                    else{
                        if(empty($payConfig['alipay']['appID'])){
                            $merInfo[$k]['isopenalipay'] = 0;
                        }
                        else{
                            $merInfo[$k]['isopenalipay'] = 1;
                        }
                    }
                }
            }
            else{
                $merInfo[$k]['isopenwxpay'] = 0;
                $merInfo[$k]['isopenalipay'] = 0;
            }
        }
        $this->assign('getdata',$data);
        $this->assign('pagebar', $pagebar);
        $this->assign('merInfo', $merInfo);


        $this->display();
    }

    //进件管理
    public function pieces(){
        $data = $this->clear_html($_POST);
        $where = "1=1";
        $wherestr = "1=1";
        if($data['name']){
            $where .= " AND company like '%".$data['name']."%'";
            $wherestr .= " AND m.company like '%".$data['name']."%'";
        }
        bpBase::loadOrg('common_page');

        //$sql_count = "SELECT count(*) as num FROM ".$this->tablepre."cashier_regist as r LEFT JOIN ".$this->tablepre."cashier_merchants as m ON m.mid=r.mid where ".$wherestr." ORDER BY r.id desc";
        $sql_count = "SELECT count(*) as num FROM ".$this->tablepre."cashier_merchants as m JOIN ".$this->tablepre."cashier_regist as r ON m.mid=r.mid where ".$wherestr." AND r.status > -1 ORDER BY m.mid desc, r.id desc";


        $obj = new model();
        //查询条数
        $_count= $obj->get_varBySql($sql_count, 'num');
        $p = new Page($_count, 15);
        $pagebar = $p->show(2);
        //查询进件内容
        $sql = "SELECT r.id,r.status,m.mid,m.company,m.mtype,m.realname,m.phone,r.wechat,r.alipay FROM ".$this->tablepre."cashier_merchants as m JOIN ".$this->tablepre."cashier_regist as r ON m.mid=r.mid where ".$wherestr." AND r.status > -1 ORDER BY m.mid desc, r.id desc LIMIT ".$p->firstRow.",".$p->listRows;
        $rows = M('cashier_regist')->selectBySql($sql);
        $array = array();
        foreach($rows as $key => $r){
            $array[$r['mid']]['id'] = $r['id'];
            $array[$r['mid']]['status'] = $r['status'];
            $array[$r['mid']]['mid'] = $r['mid'];
            $array[$r['mid']]['company'] = $r['company'];
            $array[$r['mid']]['mtype'] = $r['mtype'];
            $array[$r['mid']]['realname'] = $r['realname'];
            $array[$r['mid']]['phone'] = $r['phone'];
            if(!empty($r['wechat'])){
                $array[$r['mid']]['wechat'] = $r['id'];
                $array[$r['mid']]['wechatstatus'] = $r['status'];
            }
            elseif(empty($array[$r['mid']]['wechat'])){
                $array[$r['mid']]['wechat'] = 0;
            }
            if(!empty($r['alipay'])){
                $array[$r['mid']]['alipay'] = $r['id'];
                $array[$r['mid']]['alipaystatus'] = $r['status'];
            }
            elseif(empty($array[$r['mid']]['alipay'])){
                $array[$r['mid']]['alipay'] = 0;
            }
        }
        $this->assign('rows',$array);
        $this->assign('pagebar',$pagebar);
        $this->display();
    }

    //删除进件
    public function piecesdel(){
        $id = $this->clear_html($_POST['id']);
        $re = M('cashier_regist')->delete('id='.$id);
        if($re){
            $this->dexit(array('code'=>1));
        }else{
            $this->dexit(array('code'=>0));
        }
    }
    //分配代理商
    public function distribution(){
        if(IS_POST){
            $data = $this->clear_html($_POST);
            $da['aid'] = $data['aid'];
            $re = M('cashier_merchants')->update($da,'mid='.$data['mid']);
            if($re){
                $this->successTip('修改成功！', "/merchants.php?m=System&c=merchant&a=merLists");
                exit;
            }else{
                $this->errorTip('修改失败！', $_SERVER['HTTP_REFERER']);
                exit;
            }
        }else{
            $mid = $this->clear_html($_GET['mid']);
            $mer = M('cashier_merchants')->get_one('mid='.$mid,'mid,company,aid');
            $agent = M('cashier_agent')->select("",'aid,uname');
            $this->assign('mer',$mer);
            $this->assign('agent',$agent);
            $this->display();
        }

    }
    //参数配置
    public function config(){

        $mid = $_GET['mid'];
        $payConfig = $this->payConfigDb->get_one(array('mid' => $mid), '*');
        $appnickname=rawurldecode(unserialize($payConfig['configData'])['alipay']['appNickname']);
        $nickname=rawurldecode(unserialize($payConfig['configData'])['weixin']['nickname']);
        $this->assign('aliname',$appnickname);
        $this->assign('wxname',$nickname);
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
        //查询进件状态
        $state = M('cashier_regist')->get_one(array('mid' => $mid),'status');

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

                $payConfig['proxymid'] =1;

                $vo = M('cashier_payconfig')->update($payConfig,"mid=".$pmid);

                if($dataType=='weixin'){
                    M('cashier_merchants')->update(array('isopenwxpay'=>1),'mid='.$pmid);
                }elseif($dataType=='alipay'){
                    M('cashier_merchants')->update(array('isopenalipay'=>1),'mid='.$pmid);
                }
            } else {

                $payConfig = array('mid'=>$pmid,'isOpen' => 1, 'configData' => serialize($data),'wxsubmchid'=>$data['weixin']['mchid'],'proxymid'=>1);
                $vo = M('cashier_payconfig')->insert($payConfig,1);
                if($dataType=='weixin'){
                    M('cashier_merchants')->update(array('isopenwxpay'=>1),'mid='.$pmid);
                }elseif($dataType=='alipay'){
                    M('cashier_merchants')->update(array('isopenalipay'=>1),'mid='.$pmid);
                }

            }
            if ($vo) {
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
        else {
            $mer = M('cashier_merchants')->get_one('mid='.$mid,'mtype');
            $mtype = $mer['mtype'];
            if($mtype == 1){
                $state1 = M('cashier_regist')->get_one(array('mid' => $mid,"accountid"=>array("neq","")),'status');
                $state2 = M('cashier_regist')->get_one(array('mid' => $mid,"accountid"=>array("neq","")),'status');
            }
            else{
                $state1 = M('cashier_regist')->get_one("mid='$mid' AND wechat<> ''",'status');//微信状态
                $state2 = M('cashier_regist')->get_one("mid='$mid' AND alipay<> ''",'status');//支付宝状态
            }
            $type = $_GET['type'];
            $this->assign('type',$type);
            $this->assign('mid',$mid);
            $this->assign('state',$state['status']);
            $this->assign('state1',$state1['status']);
            $this->assign('state2',$state2['status']);
            $this->assign('mtype',$mtype);

            $this->assign('payConfig',$payConfig);
            $this->display();
        }



    }
    //上传文件
    public function pem_upload() {
        if (IS_POST) {

            if (!empty($_FILES)) {

                //$return = $this->_uplode('pem',1024);
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
    //添加商家
    public function addmerchant(){
        $this->display();
    }




    //删除商户
    public function merdel(){
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        $mer = M('cashier_merchants')->get_one(array('mid' => $id));

        //查询该商户是否存在已支付订单
        $order = M('cashier_order')->select(array('mid'=>$id,'ispay'=>1));
        if(!empty($order)){
            $this->dexit(array('errcode' => 0, 'errmsg' => '该商户下存在订单，删除失败!'));
        }



        if (empty($mer)){
            $this->dexit(array('errcode' => 0, 'errmsg' => '商户不存在!'));
        }






        if (M('cashier_merchants')->delete(array('mid' => $id))) {
            //删除商户下所有店铺
            $stores = M('cashier_stores')->delete(array('mid' => $id));
            //删除商户下所有员工
            $employee = M('cashier_employee')->delete(array('mid' => $id));
            //删除商户下所有进件信息
            $regist = M('cashier_regist')->delete(array('mid' => $id));
            //解除该商户下绑定二维码
            $data['mid'] = 0;
            $data['storesid'] = 0;
            $data['eid'] = 0;
            $data['status'] = 0;
            $qrcode = M('cashier_qrcode')->update($data,array('mid'=>$id));
            $this->dexit(array('errcode' => 1, 'errmsg' => '删除商户成功!'));
        }  else {
            $this->dexit(array('errcode' => 0, 'errmsg' => '删除商户失败!'));
        }
    }



    private function wxHandle()
    {
        bpBase::loadOrg('wxCardPack');
        $wx_user = M('cashier_payconfig')->get_wx_info($this->_mid);
        $wxCardPack = new wxCardPack($wx_user, $this->_mid);
        return $wxCardPack;
    }

    private function returnname($data, &$sourceData)
    {
        if (!empty($data['fid'])) {
            $sourceData[$data['fid']]['isdel'] = 1;
            $data = array('name' => $sourceData[$data['fid']]['name'] . ',' . $data['name'], 'fid' => $sourceData[$data['fid']]['fid']);
            return $this->returnname($data, $sourceData);
        }


        return $data['name'];
    }

    public function refreshCategroy()
    {
        $lists = M('cashier_category')->select();
        $id_key_list = array();

        foreach ($lists as $row ) {
            $row['isdel'] = 0;
            $id_key_list[$row['id']] = $row;
        }

        $categroy_all = array();

        foreach ($lists as $l ) {
            $categroy_all[$l['id']] = $this->returnname($l, $id_key_list);
        }

        $category_list = array();

        foreach ($id_key_list as $r ) {
            if (empty($r['isdel'])) {
                $category_list[] = $categroy_all[$r['id']];
            }

        }

        $wxCardPack = $this->wxHandle();
        $access_token = $wxCardPack->getToken();
        $res = $wxCardPack->GetApplyProtocol($access_token);
        $old = array();

        if (isset($res['category_list']) && !empty($res['category_list'])) {
            foreach ($res['category_list'] as $row ) {
                if (in_array($row, $category_list)) {
                    continue;
                }


                $temp = explode(',', $row);
                $index = '';

                foreach ($temp as $k => $val ) {
                    $lastindex = $index;
                    $index .= $val;

                    if (!isset($old[$index])) {
                        if (isset($old[$lastindex]) && $old[$lastindex]) {
                        }
                        else {
                        }

                        $fid = 0;
                        $id = M('cashier_category')->insert(array('fid' => $fid, 'name' => $val, 'level' => intval($k + 1)), true);
                        $old[$index] = $id;
                    }

                }
            }
        }


        $this->dexit(array('errcode' => 0, 'errmsg' => '同步完成'));
    }

//	public function config()
//	{
//		$sms_config = loadConfig('sms');
//		$this->assign('sms', $sms_config);
//		$this->display();
//	}

    public function saveconfig()
    {
        $data = array();
        $data['sms_sign'] = trim($_POST['sms_sign']);
        $data['sms_key'] = trim($_POST['sms_key']);
        $data['sms_topdomain'] = trim($_POST['sms_topdomain']);
        $config_file = ABS_PATH . 'config' . DIRECTORY_SEPARATOR . 'sms.config.php';
        $fp = fopen($config_file, 'w+');
        fwrite($fp, '<?php ' . "\n" . 'return ' . stripslashes(var_export($data, true)) . ';');
        fclose($fp);
        $this->successTip('配置成功！', '/merchants.php?m=System&c=merchant&a=config');
    }

    public function chnagehide()
    {
        $id = ((isset($_POST['id']) ? intval($_POST['id']) : 0));
        $type = ((isset($_POST['type']) ? $_POST['type'] : 'is_hide'));
        $is_hide = ((isset($_POST['is_hide']) ? intval($_POST['is_hide']) : 0));

        if (($type != 'is_hide') && ($type != 'is_home_show')) {
            exit();
        }


        M('cashier_category')->update(array($type => $is_hide), array('id' => $id));
        exit();
    }

    public function area()
    {
        $fid = ((isset($_GET['fid']) ? intval($_GET['fid']) : 0));
        $areaDB = M('cashier_area');
        $where = array('fid' => $fid);

        if ($fid) {
            $caregory = $caregoryDB->get_one(array('id' => $fid));
            $this->assign('category', $caregory);
        }


        $lists = $caregoryDB->select($where);
        $this->assign('lists', $lists);
        $this->display();
    }

    public function district()
    {
        $districtDB = M('cashier_district');
        $fid = ((isset($_GET['fid']) ? intval($_GET['fid']) : 0));
        $areaDB = M('cashier_area');
        $where = array('fid' => $fid);

        if ($fid) {
            $area = $districtDB->get_one(array('id' => $fid));
            $this->assign('area', $area);
        }


        $lists = $districtDB->select($where);
        $this->assign('total', count($lists));
        $this->assign('lists', $lists);
        $this->display();
    }

    public function addcircle()
    {
        $districtDB = M('cashier_district');
        $data = $this->clear_html($_POST);
        $id = ((isset($data['id']) ? intval($data['id']) : 0));
        $fid = ((isset($data['fid']) ? intval($data['fid']) : 0));
        $fullname = ((isset($data['fullname']) ? $data['fullname'] : ''));
        $pinyin = ((isset($data['pinyin']) ? $data['pinyin'] : ''));
        $district = $districtDB->get_one(array('id' => $fid));
        if (empty($fid) || empty($district)) {
            $this->dexit(array('errcode' => 1, 'errmsg' => '商圈只能属于一个区域'));
        }


        if (empty($fullname)) {
            $this->dexit(array('errcode' => 1, 'errmsg' => '商圈名称不能为空'));
        }


        if (empty($pinyin)) {
            $this->dexit(array('errcode' => 1, 'errmsg' => '商圈的拼音不能为空'));
        }


        $district = $districtDB->get_one(array('fid' => $fid, 'fullname' => $fullname));
        if ($district && ($district['id'] != $id)) {
            $this->dexit(array('errcode' => 1, 'errmsg' => '商圈名称已存在'));
        }


        $district = $districtDB->get_one(array('fid' => $fid, 'id' => $id));

        if ($district) {
            $districtDB->update(array('fullname' => $fullname, 'pinyin' => $pinyin, 'fid' => $fid, 'level' => 4), array('fid' => $fid, 'id' => $id));
            $this->dexit(array('errcode' => 0, 'errmsg' => '商圈更新成功'));
        }
        else {
            $districtDB->insert(array('fullname' => $fullname, 'pinyin' => $pinyin, 'fid' => $fid, 'level' => 4));
            $this->dexit(array('errcode' => 0, 'errmsg' => '商圈新增成功'));
        }
    }

    public function cancelcircle()
    {
        $id = ((isset($_POST['id']) ? intval($_POST['id']) : 0));

        if (empty($id)) {
            $this->dexit(array('errcode' => 1, 'errmsg' => '参数错误'));
        }


        M('cashier_district')->delete(array('id' => $id, 'level' => 4));
        $this->dexit(array('errcode' => 0, 'errmsg' => '删除成功'));
    }

    public function uploadIcon()
    {
        $id = ((isset($_GET['id']) ? intval($_GET['id']) : 0));
        $categoryDB = M('cashier_category');
        $category = $categoryDB->get_one(array('id' => $id));

        if (empty($category)) {
            $this->dexit(array('error' => 1, 'msg' => '不存在的分类'));
        }


        if (!empty($_FILES)) {
            $return = $this->oldUploadFile('system_caregroy', $this->mid);

            if (isset($return['data']) && !empty($return['data'])) {
                $imgpath = $return['data'][0]['savepath'] . $return['data'][0]['savename'];
                $categoryDB->update(array('icon' => $imgpath), array('id' => $id));
                $this->dexit(array('error' => 0, 'icon' => $imgpath, 'id' => $id));
            }

        }


        $this->dexit(array('error' => 1, 'msg' => '上传出错了'));
    }

    public function uploadImg()
    {
        if (!empty($_FILES)) {
            $return = $this->oldUploadFile('system_image', $this->mid);

            if (isset($return['data']) && !empty($return['data'])) {
                $imgpath = $return['data'][0]['savepath'] . $return['data'][0]['savename'];
                $this->dexit(array('error' => 0, 'image_url' => $imgpath));
            }

        }


        $this->dexit(array('error' => 1, 'msg' => '上传出错了'));
    }

    // 导出Excel文件
    public function data2Excel() {

        $mchs = M('cashier_merchants')->get_all('mid,username,company,regTime,isopenwxpay,isopenalipay,sid','','','mid desc');
        $data = array();
        foreach ($mchs as $k => $v) {
            $data[$k]['username'] = $v['username'];
            $data[$k]['company'] = $v['company'];
            $data[$k]['regTime'] = date("Y-m-d H:i:s",$v['regTime']);
            $data[$k]['comefrom'] = $this->getSalerFields($v['sid'],'username');

            $data[$k]['payConfig'] .= $v['isopenwxpay'] ?'【微信已配置】':'';
            $data[$k]['payConfig'] .= $v['isopenalipay'] ?'【支付宝已配置】':'';
            $data[$k]['payConfig'] = !empty($data[$k]['payConfig']) ?$data[$k]['payConfig'] : '未配置';
        }
        $title = array('登录账户','商户名称','注册时间','商户来源','支付配置');
        $filename = '商户列表'.date('Y-m-d',time()).'.xls';
        $this->ExportTable($data,$title,$filename);

    }

    //获取业务员名称
    public function getSalerFields($id,$fields){

        if ( $name = M('cashier_salesmans')->get_var(array('id'=>$id),$fields) ){
            return $name;
        }else{
            return false;
        }

    }


    public function banner()
    {
        $banners = M('cashier_banner')->select('', '*', '', 'sort DESC');
        $this->assign('banners', $banners);
        $this->display();
    }

    public function addbanner()
    {
        $id = ((isset($_GET['id']) ? intval($_GET['id']) : 0));
        $banner = M('cashier_banner')->get_one(array('id' => $id));
        $banner['url'] = htmlspecialchars_decode($banner['url']);
        $this->assign('banner', $banner);
        $this->display();
    }

    public function savebanner()
    {
        $data = $this->clear_html($_POST);
        $id = ((isset($data['id']) ? $data['id'] : 0));
        $title = ((isset($data['title']) ? $data['title'] : ''));
        $pic = ((isset($data['pic']) ? $data['pic'] : ''));
        $url = ((isset($data['url']) ? $data['url'] : ''));
        $sort = ((isset($data['sort']) ? $data['sort'] : 0));

        if (empty($pic)) {
            $this->dexit(array('errcode' => 1, 'errmsg' => '首页幻灯片图标不能为空'));
        }


        $saveData = array('title' => $title, 'pic' => $pic, 'url' => $url, 'sort' => $sort, 'dateline' => time());
        $bannerDB = M('cashier_banner');

        if ($banner = $bannerDB->get_one(array('id' => $id))) {
            $bannerDB->update($saveData, array('id' => $id));
            $this->dexit(array('errcode' => 0, 'errmsg' => '首页幻灯片修改成功'));
        }
        else {
            $bannerDB->insert($saveData);
            $this->dexit(array('errcode' => 0, 'errmsg' => '首页幻灯片新增成功'));
        }
    }

    public function delbanner()
    {
        $id = ((isset($_GET['id']) ? intval($_GET['id']) : 0));

        if (empty($id)) {
            $this->dexit(array('errcode' => 1, 'errmsg' => '参数错误'));
        }


        M('cashier_banner')->delete(array('id' => $id));
        $this->dexit(array('errcode' => 0, 'errmsg' => '删除成功'));
    }

    public function crowdfunding()
    {
        $where = '';
        $db = M('crowdfunding');
        $_count = $db->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $lists = $db->select($where, '*', $p->firstRow . ',' . $p->listRows);
        $result = array();
        $ids = $pre = '';

        foreach ($lists as $l ) {
            $temp = array();
            $temp['title'] = $l['name'];
            $temp['pic'] = $l['pic'];
            $temp['price'] = $l['fund'];
            $temp['endtime'] = date('Y-m-d H:i:s', $l['start'] + ($l['day'] * 86400));
            $temp['id'] = $l['id'];
            $ids .= $pre . $l['id'];
            $pre = ',';
            $result[] = $temp;
        }

        $this->formatData($ids, $result, 'crowdfunding');
        $this->assign('title', '微众筹');
        $this->assign('table_name', 'crowdfunding');
        $this->assign('pagebar', $pagebar);
        $this->assign('lists', $lists);
        $this->display('activity');
    }

    public function seckill()
    {
        $where = '';
        $db = M('seckill_action');
        $_count = $db->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $lists = $db->select($where, '*', $p->firstRow . ',' . $p->listRows);
        $result = array();
        $ids = $pre = '';

        foreach ($lists as $l ) {
            $temp = array();
            $temp['title'] = $l['action_name'];
            $temp['pic'] = $l['action_header_img'];
            $temp['price'] = 0;
            $temp['endtime'] = date('Y-m-d H:i:s', $l['action_edate']);
            $temp['id'] = $l['action_id'];
            $ids .= $pre . $l['action_id'];
            $pre = ',';
            $result[] = $temp;
        }

        $this->formatData($ids, $result, 'seckill_action');
        $this->assign('title', '微秒杀');
        $this->assign('table_name', 'seckill_action');
        $this->assign('pagebar', $pagebar);
        $this->assign('lists', $result);
        $this->display('activity');
    }

    public function unitary()
    {
        $where = '';
        $db = M('unitary');
        $_count = $db->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $lists = $db->select($where, '*', $p->firstRow . ',' . $p->listRows);
        $result = array();
        $ids = $pre = '';

        foreach ($lists as $l ) {
            $temp = array();
            $temp['title'] = $l['name'];
            $temp['pic'] = $l['logopic'];
            $temp['price'] = $l['price'];
            $temp['endtime'] = (($l['endtime'] ? date('Y-m-d H:i:s', $l['endtime']) : ''));
            $temp['id'] = $l['id'];
            $ids .= $pre . $l['id'];
            $pre = ',';
            $result[] = $temp;
        }

        $this->formatData($ids, $result, 'unitary');
        $this->assign('title', '一元夺宝');
        $this->assign('table_name', 'unitary');
        $this->assign('pagebar', $pagebar);
        $this->assign('lists', $result);
        $this->display('activity');
    }

    public function bargain()
    {
        $where = '';
        $db = M('bargain');
        $_count = $db->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $lists = $db->select($where, '*', $p->firstRow . ',' . $p->listRows);
        $result = array();
        $ids = $pre = '';

        foreach ($lists as $l ) {
            $temp = array();
            $temp['title'] = $l['name'];
            $temp['pic'] = $l['logoimg1'];
            $temp['price'] = $l['original'];
            $temp['endtime'] = '';
            $temp['id'] = $l['pigcms_id'];
            $ids .= $pre . $l['pigcms_id'];
            $pre = ',';
            $result[] = $temp;
        }

        $this->formatData($ids, $result, 'bargain');
        $this->assign('title', '微砍价');
        $this->assign('table_name', 'bargain');
        $this->assign('pagebar', $pagebar);
        $this->assign('lists', $result);
        $this->display('activity');
    }

    public function cutprice()
    {
        $where = '';
        $db = M('cutprice');
        $_count = $db->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $lists = $db->select($where, '*', $p->firstRow . ',' . $p->listRows);
        $result = array();
        $ids = $pre = '';

        foreach ($lists as $l ) {
            $temp = array();
            $temp['title'] = $l['name'];
            $temp['pic'] = $l['logoimg1'];
            $temp['price'] = $l['original'];
            $temp['endtime'] = '';
            $temp['id'] = $l['pigcms_id'];
            $ids .= $pre . $l['pigcms_id'];
            $pre = ',';
            $result[] = $temp;
        }

        $this->formatData($ids, $result, 'cutprice');
        $this->assign('title', '降价拍');
        $this->assign('table_name', 'cutprice');
        $this->assign('pagebar', $pagebar);
        $this->assign('lists', $result);
        $this->display('activity');
    }

    public function auction()
    {
        $now = time();
        $where = ' start<\'' . $now . '\' AND end>=\'' . $now . '\' AND is_del=0 AND state=3';
        $db = M('auction');
        $_count = $db->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $lists = $db->select($where, '*', $p->firstRow . ',' . $p->listRows);
        $result = array();
        $ids = $pre = '';

        foreach ($lists as $l ) {
            $temp = array();
            $temp['title'] = $l['name'];
            $temp['pic'] = $l['logo'];
            $temp['price'] = $l['startprice'];
            $temp['endtime'] = date('Y-m-d H:i:s', $l['end']);
            $temp['id'] = $l['id'];
            $ids .= $pre . $l['id'];
            $pre = ',';
            $result[] = $temp;
        }

        $this->formatData($ids, $result, 'auction');
        $this->assign('title', '微拍卖');
        $this->assign('table_name', 'auction');
        $this->assign('pagebar', $pagebar);
        $this->assign('lists', $result);
        $this->display('activity');
    }

    private function formatData($ids, &$data, $table_name)
    {
        if ($ids) {
            $tlist = M('cashier_activity')->select('activity_id IN (' . $ids . ') AND table_name=\'' . $table_name . '\'');
            $list = array();

            foreach ($tlist as $row ) {
                $list[$row['activity_id']] = $row;
            }

            foreach ($data as &$d ) {
                $d['selected'] = ((isset($list[$d['id']]) ? 1 : 0));
            }
        }

    }

    public function addActivity()
    {
        $activity_id = ((isset($_POST['actid']) ? intval($_POST['actid']) : 0));
        $selected = ((isset($_POST['selected']) ? intval($_POST['selected']) : 1));
        $table_name = ((isset($_POST['table_name']) ? htmlspecialchars($_POST['table_name']) : ''));
        $actDB = M('cashier_activity');
        $where = array('activity_id' => $activity_id, 'table_name' => $table_name);

        $activity = $actDB->get_one($where);

        if (empty($activity)) {
            $data = array();

            switch ($table_name) {
                case 'crowdfunding':
                    if ($l = M('crowdfunding')->get_one(array('id' => $activity_id))) {
                        $data['title'] = $l['name'];
                        $data['pic'] = $l['pic'];
                        $data['price'] = $l['fund'];
                        $data['endtime'] = $l['start'] + ($l['day'] * 86400);
                    }


                    break;

                case 'seckill_action':
                    if ($l = M('crowdfunding')->get_one(array('action_id' => $activity_id))) {
                        $data['title'] = $l['action_name'];
                        $data['pic'] = $l['action_header_img'];
                        $data['price'] = 0;
                        $data['endtime'] = $l['action_edate'];
                    }


                    break;

                case 'unitary':
                    if ($l = M('unitary')->get_one(array('id' => $activity_id))) {
                        $data['title'] = $l['name'];
                        $data['pic'] = $l['logopic'];
                        $data['price'] = $l['price'];
                        $data['endtime'] = $l['endtime'];
                    }


                    break;

                case 'bargain':
                    if ($l = M('bargain')->get_one(array('pigcms_id' => $activity_id))) {
                        $data['title'] = $l['name'];
                        $data['pic'] = $l['logoimg1'];
                        $data['price'] = $l['original'];
                        $data['endtime'] = 0;
                    }


                    break;

                case 'cutprice':
                    if ($l = M('cutprice')->get_one(array('pigcms_id' => $activity_id))) {
                        $data['title'] = $l['name'];
                        $data['pic'] = $l['logoimg1'];
                        $data['price'] = $l['original'];
                        $data['endtime'] = 0;
                    }


                    break;

                case 'auction':
                    if ($l = M('auction')->get_one(array('id' => $activity_id))) {
                        $data['title'] = $l['name'];
                        $data['pic'] = $l['logo'];
                        $data['price'] = $l['startprice'];
                        $data['endtime'] = $l['end'];
                    }


                    break;
                    if ($data) {
                        $data['table_name'] = $table_name;
                        $data['activity_id'] = $activity_id;
                        $actDB->insert($data);
                    }

            }
        }
        else {
        }
    }


    /**
     * 进件查看
     */
    public function seepieces(){
        if(IS_POST){
            $data = $this->clear_html($_POST);
            unset($data['m']);
            unset($data['c']);
            unset($data['a']);
            $regist = M('cashier_regist')->get_one(array('id'=>$data['id']));
            if($data){
                //20170601新增微信进件及支付宝进件
                if(($regist['wechat'] || $regist['alipay']) && $data['status'] == "1"){
                    if($regist['wechat']){
                        $applyCont = $regist['wechat'];
                    }
                    else{
                        $applyCont = $regist['alipay'];
                    }
                    $arrHashCode = array(
                        "transId" => "17",
                        "applyCont" => $applyCont
                    );
                    require_once("./MinShengBank.class.php");
                    $bank = new MinShengBank();
                    $str = $bank -> jinjian($arrHashCode);
                    if ($str['respCode'] == 'P000') {
                        $this->successTip('进件成功', '?m=System&c=merchant&a=seepieces&id=' . $data['id']);
                    } else {
                        $code = $str['respDesc'];
                        $this->errorTip($code);
                    }
                }

                $re = M('cashier_regist')->update($data,'id='.$data['id']);
                //查询进件商家
                $merchants = M('cashier_merchants')->get_one(array('mid'=>$regist['mid']));
                //查询业务员
                $salesmans = M('cashier_salesmans')->get_one(array('id'=>$merchants['sid']));
                //查询代理商
                $agent =  M('cashier_agent')->get_one(array('aid'=>$merchants['aid']));

                $address_merchants = $merchants['username'];//商户需要发送的邮箱地址
                $address_salesmans = $salesmans['account'];//业务员需要发送的邮箱地址
                $address_agent = $agent['account'];//代理商需要发送的邮箱地址

                $merchants_name = $merchants['company'];
                $merchants_url = $this->SiteUrl.'/index.php';//商户登录连接
                $salesmans_url = $this->SiteUrl.'/salesmans.php';//业务员登录连接
                $agent_url = $this->SiteUrl.'/agent.php';//代理商登录连
                $subject = "重庆云极付有限公司进件通知";//设置邮箱标题
                //实例化email类
                bpBase::loadOrg('Email');
                $email = new Email();
                if($re){

                    switch($data['status']){
                        case '1'; //提交中
                            //商户
                            $content = <<<ETC
                        <div style="width: 80%; background: #FFFFFF;">
                			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
                			<p style="padding-left:30px;">您在本平台提供的进件资料已经提交申请请耐心等待 <a href=" $merchants_url " style="text-decoration: none;">登录查看</a></p>
                		</div>
ETC;
                            $res = $email->send_email($address_merchants,$subject,$content);
                            //业务员
                            $content1 = <<<ETC
                        <div style="width: 80%; background: #FFFFFF;">
                			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
                			<p style="padding-left:30px;">商户：$merchants_name ,在本平台提供的进件资料已经提交申请请耐心等待 <a href=" $salesmans_url " style="text-decoration: none;">登录查看</a></p>
                		</div>
ETC;
                            $res = $email->send_email($address_salesmans,$subject,$content1);
                            //代理商
                            $content2 = <<<ETC
                        <div style="width: 80%; background: #FFFFFF;">
                			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
                			<p style="padding-left:30px;">商户：$merchants_name ,在本平台提供的进件资料已经提交申请请耐心等待 <a href=" $agent_url " style="text-decoration: none;">登录查看</a></p>
                		</div>
ETC;
                            $res = $email->send_email($address_agent,$subject,$content2);
                            break;



                        case '2';
                            //商户
                            $content = <<<ETC
                        <div style="width: 80%; background: #FFFFFF;">
                			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
                			<p style="padding-left:30px;">您在本平台提供的进件资料已经审核成功 <a href=" $merchants_url " style="text-decoration: none;">登录查看</a></p>
                		</div>
ETC;
                            $res = $email->send_email($address_merchants,$subject,$content);
                            //业务员
                            $content1 = <<<ETC
                        <div style="width: 80%; background: #FFFFFF;">
                			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
                			<p style="padding-left:30px;">商户：$merchants_name ,在本平台提供的进件资料已经审核成功 <a href=" $salesmans_url " style="text-decoration: none;">登录查看</a></p>
                		</div>
ETC;
                            $res = $email->send_email($address_salesmans,$subject,$content1);
                            //代理商
                            $content2 = <<<ETC
                        <div style="width: 80%; background: #FFFFFF;">
                			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
                			<p style="padding-left:30px;">商户：$merchants_name ,在本平台提供的进件资料已经审核成功 <a href=" $agent_url " style="text-decoration: none;">登录查看</a></p>
                		</div>
ETC;
                            $res = $email->send_email($address_agent,$subject,$content2);
                            break;




                        case '3';
                            $fail_contents = $data['comments'];
                            //商户
                            $content = <<<ETC
                        <div style="width: 80%; background: #FFFFFF;">
                			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
                			<p style="padding-left:30px;">您在本平台提供的进件资料审核失败 <a href=" $merchants_url " style="text-decoration: none;">登录查看</a></p>
                			<h2 style="font-size:14px; font-weight:normal;padding-left:30px;">失败原因：</h2>
			                <p style="padding-left:30px;"> $fail_contents </p>
                		</div>
ETC;
                            $res = $email->send_email($address_merchants,$subject,$content);
                            //业务员
                            $content1 = <<<ETC
                        <div style="width: 80%; background: #FFFFFF;">
                			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
                			<p style="padding-left:30px;">商户：$merchants_name ,在本平台提供的进件资料审核失败 <a href=" $salesmans_url " style="text-decoration: none;">登录查看</a></p>
                			<h2 style="font-size:14px; font-weight:normal;padding-left:30px;">失败原因：</h2>
			                <p style="padding-left:30px;"> $fail_contents </p>
                		</div>
ETC;
                            $res = $email->send_email($address_salesmans,$subject,$content1);
                            //代理商
                            $content2 = <<<ETC
                        <div style="width: 80%; background: #FFFFFF;">
                			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
                			<p style="padding-left:30px;">商户：$merchants_name ,在本平台提供的进件资料审核失败 <a href=" $agent_url " style="text-decoration: none;">登录查看</a></p>
                			<h2 style="font-size:14px; font-weight:normal;padding-left:30px;">失败原因：</h2>
			                <p style="padding-left:30px;"> $fail_contents </p>
                		</div>
ETC;
                            $res = $email->send_email($address_agent,$subject,$content2);
                            break;
                        case '4';
                            $fail_contents = $data['comments'];
                            //商户
                            $content = <<<ETC
                        <div style="width: 80%; background: #FFFFFF;">
                			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
                			<p style="padding-left:30px;">您在本平台提供的进件资料初审失败 <a href=" $merchants_url " style="text-decoration: none;">登录查看</a></p>
                			<h2 style="font-size:14px; font-weight:normal;padding-left:30px;">失败原因：</h2>
			                <p style="padding-left:30px;"> $fail_contents </p>
                		</div>
ETC;
                            $res = $email->send_email($address_merchants,$subject,$content);
                            //业务员
                            $content1 = <<<ETC
                        <div style="width: 80%; background: #FFFFFF;">
                			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
                			<p style="padding-left:30px;">商户：$merchants_name ,在本平台提供的进件资料初审失败 <a href=" $salesmans_url " style="text-decoration: none;">登录查看</a></p>
                			<h2 style="font-size:14px; font-weight:normal;padding-left:30px;">失败原因：</h2>
			                <p style="padding-left:30px;"> $fail_contents </p>
                		</div>
ETC;
                            $res = $email->send_email($address_salesmans,$subject,$content1);
                            //代理商
                            $content2 = <<<ETC
                        <div style="width: 80%; background: #FFFFFF;">
                			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
                			<p style="padding-left:30px;">商户：$merchants_name ,在本平台提供的进件资料初审失败 <a href=" $agent_url " style="text-decoration: none;">登录查看</a></p>
                			<h2 style="font-size:14px; font-weight:normal;padding-left:30px;">失败原因：</h2>
			                <p style="padding-left:30px;"> $fail_contents </p>
                		</div>
ETC;
                            $res = $email->send_email($address_agent,$subject,$content2);
                        default:


                    }
//                    $this->dexit(array('code'=>1,'msg'=>'提交成功!'));
                    $this->successTip('提交成功', '?m=System&c=merchant&a=seepieces&id=' . $data['id']);
                }else{
//                    $this->dexit(array('code'=>0,'msg'=>'提交失败!'));
                    $this->errorTip('提交失败', '?m=System&c=merchant&a=seepieces&id=' . $data['id']);
                }
            }
        }else{
            //查询数据
            $datas = $this->clear_html($_GET);
            $regist = M('cashier_regist')->get_one(array('id'=>$datas['id']));
            $regist['licencephotoList'] = json_decode($regist['licencephotoList'],true);
            $regist['idphotoAList'] = json_decode($regist['idphotoAList'],true);
            $regist['annexs'] = json_decode($regist['annexs'],true);
            $regist['special'] = json_decode($regist['special'],true);
            $regist['occodephotoList'] = json_decode($regist['occodephotoList'],true);
            $regist['idphotoBList'] = json_decode($regist['idphotoBList'],true);
            $regist['merchants_company'] = M('cashier_merchants')->get_var(array('mid'=>$regist['mid']),'company');
            $regist['wechat'] = json_decode($regist['wechat'],true);
            if($regist['wechat']){
                $categoryId = $regist['wechat']['categoryId'];//微信类目
                $category = M("cashier_wechat_category") -> get_one("id = '$categoryId'","name");
                $regist['wechat']['categoryId'] = $category['name'];
                $chnlType = $regist['wechat']['chnlType'];//渠道类型
                if($chnlType == "WEIXIN"){
                    $regist['wechat']['chnlType'] = "微信支付（普通）";
                }
                elseif($chnlType == "WEIXINAPP"){
                    $regist['wechat']['chnlType'] = "微信支付（APP、H5）";
                }
                else{
                    $regist['wechat']['chnlType'] = "微信支付（公共事业）";
                }
            }
            $regist['alipay'] = json_decode($regist['alipay'],true);
            if($regist['alipay']){
                $provinceCode = $regist['alipay']['provinceCode'];//省份
                $provinceName = M("cashier_area") -> get_one("areaCode = '$provinceCode'","areaName");
                $regist['alipay']['provinceCode'] = $provinceName['areaName'];
                $cityCode = $regist['alipay']['cityCode'];//城市
                $cityName = M("cashier_area") -> get_one("areaCode = '$cityCode'","areaName");
                $regist['alipay']['cityCode'] = $cityName['areaName'];
                $districtCode = $regist['alipay']['districtCode'];//区域
                $districtName = M("cashier_area") -> get_one("areaCode = '$districtCode'","areaName");
                $regist['alipay']['districtCode'] = $districtName['areaName'];
                $categoryId = $regist['alipay']['categoryId'];//支付宝类目
                $category = M("cashier_alipay_category") -> get_one("code = '$categoryId'","name");
                $regist['alipay']['categoryId'] = $category['name'];
            }
            $this->assign('regist',$regist);
            $this->assign('data',$datas);
            $this->display();
        }
    }
    //修改进件信息
    public function editInfo(){
        $id = $_GET['id'];
        $regist = M("cashier_regist") -> get_one("id = '$id'","id,mid,wechat,alipay");
        $wechat = json_decode($regist['wechat'],true);
        $alipay = json_decode($regist['alipay'],true);
        $this -> assign("regist",$regist);
        $this -> assign("wechat",$wechat);
        $this -> assign("alipay",$alipay);
        $this->display();
    }
    public function sign($data)
    {
        //读取私钥文件
        //注意所放文件路径
        $priKey = file_get_contents('./Cashier/pay/pem/850500053991403_prv.pem');

        //转换为openssl密钥，必须是没有经过pkcs8转换的私钥
        $res = openssl_get_privatekey($priKey);

        //调用openssl内置签名方法，生成签名$sign
        openssl_sign($data, $sign, $res);

        //释放资源
        openssl_free_key($res);

        return base64_encode($sign);
    }
    public function SinParamsToString($params)
    {
        $sign_str = '';
        // 排序
        ksort($params);
        foreach ($params as $key => $val) {
            if ($key == 'signature') {
                continue;
            }
            $sign_str .= sprintf("%s=%s&", $key, $val);
        }
        return substr($sign_str, 0, strlen($sign_str) - 1);
    }
    public function arrayToString($params)
    {
        $sign_str = '';
        // 排序
        ksort($params);
        foreach ($params as $key => $val) {

            $sign_str .= sprintf("%s=%s&", $key, $val);
        }
        return substr($sign_str, 0, strlen($sign_str) - 1);

    }
    public function curlRequest($url, $data = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        //curl_setopt($ch,CURLOPT_SSLVERSION,CURL_SSLVERSION_TLSv1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $outPut = curl_exec($ch);
        $aStatus = curl_getinfo($ch);
        curl_close($ch);
        if (intval($aStatus['http_code']) == 200) {
            return $outPut;
        } else {
            return false;
        }

    }
    /**
     * 进件下载
     */

    public function PiecesDownload(){
        $data = $this->clear_html($_POST);
        //查询下载数据
        $regist = M('cashier_regist')->get_one(array('id'=>$data['id']));

        $regist['licencephotoList'] = json_decode($regist['licencephotoList'],true);
        $regist['idphotoAList'] = json_decode($regist['idphotoAList'],true);
        $regist['annexs'] = json_decode($regist['annexs'],true);
        $regist['special'] = json_decode($regist['special'],true);
        $regist['occodephotoList'] = json_decode($regist['occodephotoList'],true);
        $regist['idphotoBList'] = json_decode($regist['idphotoBList'],true);

        if(!$regist['special']){
            $regist['special'] = array();
        }

        if(!$regist['idphotoAList']){
            $regist['idphotoAList'] = array();
        }
        if(!$regist['annexs']){
            $regist['annexs'] = array();
        }
        if(!$regist['licencephotoList']){
            $regist['licencephotoList'] = array();
        }
        if(!$regist['occodephotoList']){
            $regist['occodephotoList'] = array();
        }
        if(!$regist['idphotoBList']){
            $regist['idphotoBList'] = array();
        }



        //数组合并
        $regist_arr = array_merge($regist['licencephotoList'],$regist['idphotoAList'],$regist['special'],$regist['occodephotoList'],$regist['idphotoBList'],$regist['annexs']);
        //拼装Excel格式数据
        $regist_data[0]['contactor'] = $regist['contactor'];//联系人
        $regist_data[0]['tel'] = $regist['tel'];//手机号码
        $regist_data[0]['email'] = $regist['email'];//常用邮箱
        $regist_data[0]['shortname'] = $regist['shortname'];//商户简称
        $regist_data[0]['level'] = $regist['level1'].'->'.$regist['level2'].'->'.$regist['level3'];//经营项目
        $regist_data[0]['phone'] = $regist['phone'];//客服电话
        $regist_data[0]['website'] = $regist['website'];//公司网站
        $regist_data[0]['company'] = $regist['company'];//商户名称
        $regist_data[0]['address'] = $regist['address'];//注册地址
        $regist_data[0]['icence'] = $regist['icence'];//营业执照注册号
        $regist_data[0]['mcarea'] = $regist['mcarea'];//经营范围
        //$regist_data[0]['starttime'] = date('Y-m-d',$regist['starttime']).'月至'.date('Y-m-d',$regist['endtime']).'月';//营业期限
        $regist_data[0]['starttime'] = $regist['starttime'] .' 至 ' .$regist['endtime'];
        $regist_data[0]['occode'] = $regist['occode'];//机构代码
        //$regist_data[0]['validatestart'] = date('Y-m-d',$regist['validatestart']).'月至'.date('Y-m-d',$regist['validateend']).'月';//组织机构有效期
        $regist_data[0]['validatestart'] = $regist['validatestart'] .' 至 '.$regist['validateend'];
        $regist_data[0]['idtype'] = $regist['idtype'];//证件持有人类型
        $regist_data[0]['idname'] = $regist['idname'];//证件持有人姓名
        $regist_data[0]['idcard'] = $regist['idcard'];//证件类型
        //$regist_data[0]['idstart'] = date('Y-m-d',$regist['idstart']).'月至'.date('Y-m-d',$regist['idend']).'月';//证件有效期
        $regist_data[0]['idstart'] = $regist['idstart'].' 至 '. $regist['idend'];
        $regist_data[0]['idnum'] = $regist['idnum'];//证件号码
        $regist_data[0]['accountType'] = $regist['accountType'];//账户类型
        $regist_data[0]['account'] = $regist['account'];//开户名称
        $regist_data[0]['bank'] = $regist['bank'];//开户银行
        $regist_data[0]['bankaddress'] = $regist['bankaddress'];//开户银行城市
        $regist_data[0]['bank_branch'] = $regist['bank_branch'];//开户支行
        $regist_data[0]['accountid'] = $regist['accountid'];//银行账户
        $regist_name = M('cashier_merchants')->get_var(array('mid'=>$regist['mid']),'company');
        $title = array('联系人','手机号码','常用邮箱','商户简称','经营项目','客服电话','公司网站','商户名称','注册地址','营业执照注册号','经营范围','营业期限','机构代码','组织机构有效期','证件持有人类型',
            '证件持有人姓名','证件类型','证件有效期','证件号码','账户类型','开户名称','开户银行','开户银行城市','开户支行','银行账户');

        $filenames = time().'.xls';
        $filename = './Cashier/upload/excel/'.time().'.xls';
        $this->ExportTable1($regist_data,$title,$filename);
        //下载压缩包
        $pic_path = $this->SiteUrl;
        $filename_zip = './QrCodeDownload.zip';//下载.zip文件名
        $zip = new ZipArchive();
        $zip->open($filename_zip, ZipArchive::OVERWRITE);
        $zip->addEmptyDir('pieces'); //增加一个目录的原因是，如果zip包没东西会一直下载，永不停止
        $fileData = file_get_contents($pic_path . '/Cashier/upload/excel/'  . $filenames);//读取excel格式的用户进件信息
        $zip->addFromString('pieces/' . $filenames, $fileData);//添加进压缩文件
        //组装所有图片路径
        foreach ($regist_arr as $value) {
            $fileDatas = file_get_contents($pic_path . $value);
            $path = basename($value);
            if ($fileDatas) {
                $zip->addFromString('pieces/' . $path, $fileDatas);
            }
        }
        $zip->close();
        //打开文件
        $file = fopen($filename_zip, "r");
        //返回的文件类型
        Header("Content-type: application/octet-stream");
        //按照字节大小返回
        Header("Accept-Ranges: bytes");
        //返回文件的大小
        Header("Accept-Length: " . filesize($filename_zip));
        //这里对客户端的弹出对话框，对应的文件名
        Header("Content-Disposition: attachment; filename=QrCodeDownload.zip");
        Header('Content-type: application/force-download');
        //@readfile($filename);
        //一次只传输1024个字节的数据给客户端
        //向客户端回送数据
        $buffer = 1024; //
        //判断文件是否读完
        while (!feof($file)) {
            //将文件读入内存
            $file_data = fread($file, $buffer);
            //每次向客户端回送1024个字节的数据
            echo $file_data;
        }

        fclose($file);

        unlink($filename); //删除文件
    }


    /*
     * 导出数据
     * @param array $data   数据总条数
     *
     * @param array $str   表格头
     */
    public function ExportTable1($data,$title,$filename = ''){
        $result = $data;

        //组装xls文本
        $str="";
        foreach ($title as &$value) {
            $str .= $value;
            $str .="\t";
        }
        $str .="\n";

        $str = iconv('utf-8', 'gb2312', $str);

        foreach ($result as  $k=>$row) {
            $str1 ="";
            foreach($row as $key=>$v){
                $key = iconv('utf-8', 'gb2312', $v);
                $str1 .= $key."\t";
            }
            $str .= $str1 ."\n";

        }

        if(!$filename){
            $filename = date('YmdHis') . '.xls';
        }

        $this->exportExcelData1($filename, $str);

    }

    /**
     * 导出excel表格
     * @param unknown $filename
     * @param unknown $content
     *
     */

    private function exportExcelData1($filename, $content)
    {
        file_put_contents($filename,$content);
    }





}


?>