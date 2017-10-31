<?php
 
bpBase::loadAppClass('common', 'User', 0);

class pay_controller extends common_controller {

    private $payConfigDb;

    public function __construct() {
        parent::__construct();
        bpBase::loadOrg('checkFunc');
        $checkFunc = new checkFunc();
        if (!function_exists('dsbig3joishdgfhg798rqw4fqnkhffq')) {
            exit('error-4');
        }
        $checkFunc->cfdwdgfds3skgfds3szsd3idsj();
        if (($this->eid > 0) && (ROUTE_ACTION!='poskey')) {
            $this->errorTip('员工账号没有权限访问！');
        }
        //$this->authorityControl(array('pem_upload,config,printset,printScfg'));
        $this->payConfigDb = M('cashier_payconfig');
    }


	public function index(){
		include $this->showTpl();
	}

    public function config() {
        
        $payConfig = $this->payConfigDb->get_one(array('mid' => $this->mid), '*');
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
            
            if ($payConfig) {
                $dataType = array_keys($data);
                
                $dataType = $dataType[0];
                
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
                
                $vo = $this->_save($this->payConfigDb, $payConfig);
            } else {
                $payConfig = array('mid' => $this->mid, 'isOpen' => 1, 'configData' => serialize($data));
                $vo = $this->_add($this->payConfigDb, $payConfig);
            }
            if ($vo) {
                $return['status'] = 1;
                $return['msg'] = '支付配置修改成功';
            } else {
                $return['status'] = 0;
                $return['msg'] = '支付配置修改失败';
            }
            delCacheByMid($this->mid);
            echo json_encode($return);
            exit;
        } else {
            
            $rsapublickey = file_get_contents(CMSBASEDIR . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "org" . DIRECTORY_SEPARATOR . "Alipay" . DIRECTORY_SEPARATOR . "rsa_public_key.pem");
            $rsapublickey = str_replace(array('-----BEGIN PUBLIC KEY-----', '-----END PUBLIC KEY-----', PHP_EOL), '', $rsapublickey);
            $rsapublickey = trim($rsapublickey);
            $adminUserInfo = $this->getAdminuserInfo();
            
            $iswxhave = false;
            $isalihave = false;
            if (!empty($adminUserInfo)) {
                
                $configData = $adminUserInfo['configData'];
                
                if (isset($configData['weixin']) && !empty($configData['weixin']['appid']) && !empty($configData['weixin']['appSecret']) && !empty($configData['weixin']['mchid']) && !empty($configData['weixin']['key'])) {
                    $iswxhave = true;
                } else {
                    $this->cleanIspfPay('wx');
                }
                if (isset($configData['alipay']) && !empty($configData['alipay']['appid']) && !empty($configData['alipay']['pid'])) {
                    $isalihave = true;
                } else {
                    $this->cleanIspfPay('ali');
                }
            }

            /**********处理星************ */
            if (!empty($payConfig['configData']['weixin'])) {
                foreach ($payConfig['configData']['weixin'] as $kk => $vv) {
                    if (!empty($vv)) {
                        $vvlen = strlen($vv);
                        if ($vvlen > 4) {
                            $xingStrLen = $vvlen - 4;
                            $xingStr = '';
                            for ($i = 0; $i < $xingStrLen; $i++) {
                                $xingStr.='*';
                            }
                            $payConfig['configData']['weixin'][$kk . 'm'] = substr_replace($vv, $xingStr, 2, $xingStrLen);
                        } else {
                            $xingStr = '';
                            for ($j = 0; $j < $vvlen; $j++) {
                                $xingStr.='*';
                            }
                            $payConfig['configData']['weixin'][$kk . 'm'] = substr_replace($vv, $xingStr, 0, $vvlen);
                        }
                    } else {
                        $payConfig['configData']['weixin'][$kk . 'm'] = '';
                    }
                }
            }

            if (!empty($payConfig['configData']['alipay'])) {
                foreach ($payConfig['configData']['alipay'] as $kk => $vv) {
                    if (!empty($vv)) {
                        $vvlen = strlen($vv);
                        if ($vvlen > 4) {
                            $xingStrLen = $vvlen - 4;
                            $xingStr = '';
                            for ($i = 0; $i < $xingStrLen; $i++) {
                                $xingStr.='*';
                            }
                            $payConfig['configData']['alipay'][$kk . 'm'] = substr_replace($vv, $xingStr, 2, $xingStrLen);
                        } else {
                            $xingStr = '';
                            for ($j = 0; $j < $vvlen; $j++) {
                                $xingStr.='*';
                            }
                            $payConfig['configData']['alipay'][$kk . 'm'] = substr_replace($vv, $xingStr, 0, $vvlen);
                        }
                    } else {
                        $payConfig['configData']['alipay'][$kk . 'm'] = '';
                    }
                }
            }
            
            $bankConfig = M('cashier_bank')->get_one(array('mid' => $this->mid), '*');
            $bankConfig = !empty($bankConfig) ? $bankConfig : array();
            if (!empty($bankConfig)) {
                foreach ($bankConfig as $kk => $vv) {
                    if (!empty($vv)) {
                        $vvlen = strlen($vv);
                        if ($vvlen > 4) {
                            $xingStrLen = $vvlen - 4;
                            $xingStr = '';
                            for ($i = 0; $i < $xingStrLen; $i++) {
                                $xingStr.='*';
                            }
                            $bankConfig[$kk . 'm'] = substr_replace($vv, $xingStr, 2, $xingStrLen);
                        } else {
                            $xingStr = '';
                            for ($j = 0; $j < $vvlen; $j++) {
                                $xingStr.='*';
                            }
                            $bankConfig[$kk . 'm'] = substr_replace($vv, $xingStr, 0, $vvlen);
                        }
                    } else {
                        $bankConfig[$kk . 'm'] = '';
                    }
                }
            }
        }
        
        include $this->showTpl();
    }

    /*     * ****银行卡配置******* */

    public function bank() {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            
            $data['bank_img'] = serialize($data['bank_img']);
            
            $cashier_bankDb = M('cashier_bank');
            $bankArr = $cashier_bankDb->get_one(array('mid' => $this->mid), '*');
            if (empty($bankArr)) {
                $data['mid'] = $this->mid;
                if ($cashier_bankDb->insert($data, true)) {
                    $this->dexit(array('code' => 1));
                } else {
                    $this->dexit(array('code' => 0, 'msg' => '保存失败了！'));
                }
            } else {
                if ($cashier_bankDb->update($data, array('id' => $bankArr['id'], 'mid' => $this->mid))) {
                    $this->dexit(array('code' => 1));
                } else {
                    $this->dexit(array('code' => 0, 'msg' => '保存失败！'));
                }
            }
        }else{
            $bank = M('cashier_bank')->get_one(array('mid'=>$this->mid));
            $bank['bank_img'] = unserialize($bank['bank_img']);
            
            include $this->showTpl();
        }
    }

    /*     * ****打印配置****** */

    public function printset() {
        $printcfgDb = M('cashier_printcfg');
        $printcfgArr = $printcfgDb->select(array('mid' => $this->mid), '*', '', 'id  DESC');
        $StoreInfo = $this->getStoreInfo(false);
        if (!empty($StoreInfo)) {
            $tmpStore = array();
            foreach ($StoreInfo as $svv) {
                $tmpStore[$svv['id']] = $svv;
            }
            $StoreInfo = $tmpStore;
            unset($tmpStore);
        }
        include $this->showTpl();
    }

    /*     * ****获取一个打印机配置****** */

    public function getPrintCfg() {
        $cfgid = intval($_POST['cfgid']);
        if ($cfgid > 0) {
            $printcfgDb = M('cashier_printcfg');
            $printcfg = $printcfgDb->get_one(array('id' => $cfgid, 'mid' => $this->mid), '*');
            if (!empty($printcfg)) {

                foreach ($printcfg as $kk => $vv) {
                    if (in_array($kk, array('terminalnum', 'mkey', 'cellphone'))) {
                        if (!empty($vv)) {
                            $vvlen = strlen($vv);
                            if ($vvlen > 4) {
                                $xingStrLen = $vvlen - 4;
                                $xingStr = '';
                                for ($i = 0; $i < $xingStrLen; $i++) {
                                    $xingStr.='*';
                                }
                                $printcfg[$kk . 'm'] = substr_replace($vv, $xingStr, 2, $xingStrLen);
                            } else {
                                $xingStr = '';
                                for ($j = 0; $j < $vvlen; $j++) {
                                    $xingStr.='*';
                                }
                                $printcfg[$kk . 'm'] = substr_replace($vv, $xingStr, 0, $vvlen);
                            }
                        } else {
                            $printcfg[$kk . 'm'] = '';
                        }
                    }
                }
                $this->dexit(array('error' => 0, 'msg' => 'Ok', 'data' => $printcfg));
            }
        }
        $this->dexit(array('error' => 1, 'msg' => '信息获取失败！', 'data' => ''));
    }

    /*     * ****修改打印配置**** */

    public function printScfg() {
        $ptdata = $this->clear_html($_POST);
        $id = intval($ptdata['cfgid']);
        unset($ptdata['cfgid']);
        $printcfgDb = M('cashier_printcfg');
        $printcfg = $printcfgDb->get_one(array('id' => $id, 'mid' => $this->mid), '*');
        if (!empty($printcfg)) {
            if ($printcfgDb->update($ptdata, array('id' => $printcfg['id'], 'mid' => $this->mid))) {
                $this->dexit(array('error' => 0));
            }
        }
        $this->dexit(array('error' => 1, 'msg' => '修改失败了！'));
    }

    /*     * ****添加新打印机**** */

    public function addPrintCfg() {
        $ptdata = $this->clear_html($_POST);
        $printcfgDb = M('cashier_printcfg');
        $ptdata['mid'] = $this->mid;
        $ptdata['isopen'] = 1;
        if ($printcfgDb->insert($ptdata, true)) {
            $this->dexit(array('error' => 0));
        }
        $this->dexit(array('error' => 1, 'msg' => '添加失败了！'));
    }

    /*     * ****pos机对接Key****** */

    public function poskey() {
		$mdStr = md5('app5#' . $this->mid . '#86hd76f');
		$miwen =array('mid'=>$this->mid,'whologin' => 1,'storeid'=>$this->storeid,'eid'=>$this->eid,'mdStr'=>$mdStr);
		if($this->eid >0){
		 $miwen['whologin'] =2;
		}
		 $keycode = json_encode($miwen);
         $keycode = Encryptioncode($keycode, 'ENCODE');
		 $keycode=str_replace('+','_',$keycode);
		 $keycode=str_replace('/','-',$keycode);
         /***$keycode = base64_encode($keycode);****/
        include $this->showTpl();
    }

    /*     * **更新字段值*** */

    public function SetFieldV() {
        $data = $this->clear_html($_POST);
        $adminUserInfo = $this->getAdminuserInfo();
        if (isset($data['ispfpay'])) {
            $ispfpay = intval($data['ispfpay']);
            unset($data['ispfpay']);
            $data['pfpaymid'] = $ispfpay > 0 ? $adminUserInfo['mid'] : 0;
        } elseif (isset($data['isalipfpay'])) {
            $isalipfpay = intval($data['isalipfpay']);
            unset($data['isalipfpay']);
            $data['pfalipaymid'] = $isalipfpay > 0 ? $adminUserInfo['mid'] : 0;
        }
        delCacheByMid($this->mid);
        if ($this->payConfigDb->update($data, array('mid' => $this->mid))) {
            $this->dexit(array('error' => 0));
        }
        $this->dexit(array('error' => 1));
    }

    /*     * **更新字段值*** */

    public function SetPrintCfgV() {
        $isopen = isset($_POST['isopen']) ? intval($_POST['isopen']) : 0;
        $cfgid = isset($_POST['cfgid']) ? intval($_POST['cfgid']) : 0;

        $printcfgDb = M('cashier_printcfg');
        if ($printcfgDb->update(array('isopen' => $isopen), array('id' => $cfgid, 'mid' => $this->mid))) {
            $this->dexit(array('error' => 0));
        }
        $this->dexit(array('error' => 1));
    }

    public function getApiData() {
        $datas = array('wxtoken' => $this->merchant['wxtoken'], 'aeskey' => $this->merchant['aeskey'], 'encodetype' => $this->merchant['encodetype'], 'mid' => $this->mid);
        if (empty($datas['wxtoken']) || empty($datas['aeskey'])) {
            $datas['wxtoken'] = randStr(30, true);
            $datas['aeskey'] = randStr(43, true);
            M('cashier_merchants')->update(array('wxtoken' => $datas['wxtoken'], 'aeskey' => $datas['aeskey']), array('mid' => $this->mid));
        }
        $this->dexit($datas);
    }

    public function pem_upload() {
        if (IS_POST) {
            if (!empty($_FILES)) {
                //$return = $this->_uplode('pem',1024);
                $return = $this->oldUploadFile('pem', $this->mid);
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
    //上传银行卡
     public function uploadImg() {
		
        if (!empty($_FILES)) {
            $pathname = 'bank';
            $return = $this->oldUploadFile($pathname, $this->mid);
            //dump($return);exit;
            if (isset($return['data']) && !empty($return['data'])) {
                $imgpath = $return['data']['0']['savepath'] . $return['data']['0']['savename'];
                
                $this->dexit(array('error' => 0, 'localimg' => $imgpath));
            }
        }
        $this->dexit(array('error' => 1, 'msg' => ''));
    }
    public function field() {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            if ($payConfig = $this->payConfigDb->get_one(array('mid' => $this->mid), 'id')) {
                $data['id'] = $payConfig['id'];
            } else {
                $data['mid'] = $this->mid;
            }
            $return = $this->_setField($this->payConfigDb, $data);
            delCacheByMid($this->mid);
            echo json_encode($return);
            exit;
        }
    }
    
    
    
    
    /**
     * 用户修改密码
     * 
     */
    
    public function doModifyPwd()
    {
        $password = trim($_POST['password']);
        $repassword = trim($_POST['repassword']);
  
        if (empty($password)) {
            $this->errorTip('新密码不能为空！');
            exit();
        }
    
    
        if ($password != $repassword) {
            $this->errorTip('两次输入的密码不一致！');
            exit();
        }
    
        $newpwdstr = $this->toPassword($password, $this->merchant['salt']);
        $updatedata = array('password' => $newpwdstr, 'mfypwd' => 1);
    
    
        $flage = M('cashier_merchants')->update($updatedata, array('mid' => $this->merchant['mid']));
    
        if ($flage) {
            $this->successTip('修改成功，请重新登录！', '/merchants.php?m=User&c=index&a=logout');
            exit();
        }
        else {
            $this->errorTip('密码修改失败！');
            exit();
        }
    }
    
    
    
    
    
    /**
     * 账户设置
     */
    public function ModifyPwd()
	{
            if(IS_POST){
                $data = $this->clear_html($_POST);
                if($data['company']==""){
                    $this->errorTip('商户名不能为空',$_SERVER['HTTP_REFERER']);
                }
                if($data['realname']==""){
                    $this->errorTip('联系人不能为空',$_SERVER['HTTP_REFERER']);
                }
                if($data['phone']==""){
                    $this->errorTip('电话不能为空',$_SERVER['HTTP_REFERER']);
                }
                if($data['address']==""){
                    $this->errorTip('地址不能为空',$_SERVER['HTTP_REFERER']);
                }
                $password = trim($data['password']);

                if (empty($password)) {
                    unset($data['password']);
                }
                else{
                    $newpwdstr = $this->toPassword($password, $this->merchant['salt']);
                    $data['password'] = $newpwdstr;
                }
                $result = M('cashier_merchants')->update($data,'mid='.$this->mid);
                if($result){
                    $this->dexit(array('code'=>1));
                }else{
                    $this->dexit(array('code'=>0));
                }
                
            }else{
                 //查询数据
                $merchants = M('cashier_merchants')->get_one(array('mid'=>$this->merchant['mid']));
                if($this -> isMobile()){
                    include $this->showTpl("ModifyPwdwap");
                }
                else{
                    include $this->showTpl();
                }
            }
	   
	}
        
        public function payconfig() {
        
        $payConfig = $this->payConfigDb->get_one(array('mid' => $this->mid), '*');
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
        $regist = M('cashier_regist')->get_one(array('mid'=>$this->mid),'status');
        if (IS_POST) {
            $data = $this->clear_html($_POST['data']);
            
            $dataType = array_keys($data);
            $dataType = $dataType[0];
            if ($payConfig) {
                
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
                if($data['weixin']['mchid']){
                   $payConfig['wxsubmchid'] = $data['weixin']['mchid'];
                   $payConfig['proxymid'] =1;
                }
                $payConfig['configData'] = serialize($payConfig['configData']);
                $vo = $this->_save($this->payConfigDb, $payConfig);
                 if($dataType=='weixin'){
                     M('cashier_merchants')->update(array('isopenwxpay'=>1),'mid='.$this->mid);
                }elseif($dataType=='alipay'){
                    M('cashier_merchants')->update(array('isopenalipay'=>1),'mid='.$this->mid);
                }
            } else {
                $payConfig = array('mid' => $this->mid, 'isOpen' => 1, 'configData' => serialize($data),'wxsubmchid'=>$data['weixin']['mchid'],'proxymid'=>1);
                $vo = $this->_add($this->payConfigDb, $payConfig);
                if($dataType=='weixin'){
                     M('cashier_merchants')->update(array('isopenwxpay'=>1),'mid='.$this->mid);
                }elseif($dataType=='alipay'){
                    M('cashier_merchants')->update(array('isopenalipay'=>1),'mid='.$this->mid);
                }
            }
            if ($vo) {
                $return['status'] = 1;
                $return['msg'] = '支付配置修改成功';
            } else {
                $return['status'] = 0;
                $return['msg'] = '支付配置修改失败';
            }
            delCacheByMid($this->mid);
            echo json_encode($return);
            exit;
        } else {
           
        }
        
        include $this->showTpl();
    }
    
    
      //商户进件
    public function go2Regeist () {
    if (IS_POST) {
        $postdata = $this->clear_html($_POST);
        
        if (!$postdata['mid']) {
            $this->errorTip('不存在的商户');
        }
        $saveData['mid'] = $postdata['mid'];

        if (trim($postdata['contactor'])==''){

            $this->errorTip('联系人不能为空');
        }
        $saveData['contactor'] = $postdata['contactor'];

        if (!preg_match("/^1[345678]\d{9}$/", $postdata['tel'] )){

            $this->errorTip('不是有效的手机号');
        }
        $saveData['tel'] = $postdata['tel'];

        if (!preg_match('/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/',$postdata['email'])) {
            $this->errorTip('邮箱格式不对');
        }
        $saveData['email']= $postdata['email'];

        if ($postdata['shortname']==''){

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

        if(!empty($postdata['website'])) {
            $saveData['website'] = $postdata['website'];  
        }
        

        if(!empty($postdata['phone'])) {
            $saveData['phone'] = $postdata['phone'];  
        }

        

        //《建设用地规划许可证》
        if ($postdata['constructLeanIDList']) {

            $saveData['constructLeanID'] = json_encode($postdata['constructLeanIDList']);
        }
        // 《建设工程规划许可证》
        if($postdata['constructLeanList']) {
            $saveData['constructLean'] = json_encode($postdata['constructLeanList']);
        }

        // 《建筑工程开工许可证》
        if($postdata['cunstructIDList']) {
            $saveData['cunstructID'] = json_encode($postdata['cunstructIDList']);
        }

        // 《国有土地使用证》
        if($postdata['landUseIdList']) {
            $saveData['landUseId'] = json_encode($postdata['landUseIdList']);
        }

        // 《商品房预售许可证》
        if($postdata['allowIDList']) {
            $saveData['allowID'] = json_encode($postdata['allowIDList']);
        }

        // 《法人登记证书》
        if($postdata['contactList']) {

            $saveData['contact'] = json_encode($postdata['contactList']);
        }


        // 《组织机构代码证》
        if ($postdata['groupIDList']){
             $saveData['groupID'] = json_encode($postdata['groupIDList']);
        }

        // 特殊资质
        if ($postdata['specialList']){
             $saveData['special'] = json_encode($postdata['specialList']);
        }


                // 商品售卖简述
        if ($postdata['dealdesc']){
             $saveData['dealdesc'] = $postdata['dealdesc'];
        }

        // 补充材料
        if ($postdata['annuxesList']) {
             $saveData['annexs'] = json_encode($postdata['annuxesList']);
        }
        // 判断是不是提交过
        $check =  M('cashier_regist')->get_one(array('mid'=>$postdata['mid']),'*');
        if ($check) {//修改
            $result  = M('cashier_regist')->update($saveData,array('mid'=>$this->mid));
            //修改成功跳转
            if($result){

                $res = M('cashier_regist')->get_one(array('mid'=>$saveData['mid']),'*');
               
               if ( empty($res['company']) || empty($res['bank']) ){
                
                    header('location:?m=User&c=pay&a=regMerchantInfo&mid='.$saveData['mid']);
               }else{

                    header('location:?m=User&c=pay&a=showReg&mid='.$saveData['mid']);exit();
               }
                //header('location:?m=User&c=pay&a=showReg&mid='.$saveData['mid']);exit();
            }
            
            
        }else{//添加
            $result  = M('cashier_regist')->insert($saveData,true);
        }
        if ($result) {
           header('location:?m=User&c=pay&a=regMerchantInfo&mid='.$saveData['mid']);
        }
        $this->successTip('数据保存成功');
    }else{
        
        $getdata['mid'] = $this->mid;
        
        $list =  M('cashier_pieces')->get_all('name,id','',array('fid'=>0));
        
        $status =  M('cashier_regist')->get_var(array('mid'=>$getdata['mid']),'status');
        if($status){
            $status = isset($status) ? $status : 0;
        }
        
        //判断是否为修改
        if(isset($_GET['type'])){
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
                header('location:?m=User&c=pay&a=showReg&mid='.$getdata['mid']);exit;
            }
        }
            include $this->showTpl();
        }  
    }
    
    
     public function getRegData ($id) {
       
        $arr = M('cashier_pieces')->get_one(array('id'=>$id),'*');
        return $arr;

    }
    
    
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
                $this->errorTip('请上传营业执照照片');
            }
            $saveData['licencephotoList'] = json_encode($postdata['licencephotoList']);


            if (empty($postdata['occode'])) {
                $this->errorTip('请填写组织机构代码');
            }
            $saveData['occode'] = $postdata['occode'];


            if (empty($postdata['validatestart'])) {
                $this->errorTip('请填写开始时间');
            }
            $saveData['validatestart'] =  $postdata['validatestart'];

           

            if (empty($postdata['validate'])) {
                if (empty($postdata['validateend'])) {
                    $this->errorTip('请填写结束时间');
                }
                $saveData['validateend'] = $postdata['validateend'];
            }else{
                $saveData['validateend'] = '长期';
            }
         

            if (empty($postdata['occodephotoList'])) {
                $this->errorTip('请上传组织机构代码证照片');
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


            $result  = M('cashier_regist')->update($saveData,array('mid'=>$postdata['mid']));

            if ($result) {
                if($postdata['type']){
                    header('location:?m=User&c=pay&a=showReg&mid='.$saveData['mid']);exit();
                }else{
                    header('location:?m=User&c=pay&a=examine&mid='.$saveData['mid']);
                }
            }


        }else if (!empty($_GET['mid'])){
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


    public function examine () {

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
            $saveData['status'] = 0;
            $result  = M('cashier_regist')->update($saveData,array('mid'=>$postdata['mid']));
            if ($result){
                if($postdata['type']){
                    header('location:?m=User&c=pay&a=showReg&mid='.$saveData['mid']);exit();
                }else{
                    header('location:?m=User&c=pay&a=showReg&mid='.$saveData['mid']);exit();
                }
            }
        }
        if (!empty($_GET['mid'])) {

            $getdata = $this->clear_html($_GET);
            $rinfo = M('cashier_regist')->get_one(array('mid'=>$_GET['mid']),'mclevel1,company,contactor');
            $accountType = $rinfo['mclevel1']==2 ? '个人账户':'1对公账户';
            $account = $rinfo['mclevel1']== 2 ? $rinfo['contactor'] : $rinfo['company'];
            if($_GET['type']){
                $reg = M('cashier_regist')->get_one(array('mid'=>$getdata['mid']),'*');
            }
            $this->check($getdata['mid']);
        }


        include $this->showTpl();

    }


    public function back2reg () {

        if (!empty($_GET['mid'])) {
            $getdata = $this->clear_html($_GET);

            $this->check($getdata['mid']);

            $merchant = M('cashier_merchants')->get_var(array('mid'=>$getdata['mid']),'company');

            $reg = M('cashier_regist')->get_one(array('mid'=>$getdata['mid']));
            $type = M('cashier_pieces')->get_var(array('id'=>$reg['mclevel3']),'type');

            $lvl['zero'] =  M('cashier_pieces')->get_var(array('id'=>$reg['mclevel1']),'name');
            $lvl['fir'] =  M('cashier_pieces')->get_var(array('id'=>$reg['mclevel1']),'name');
            $lvl['sec'] =  M('cashier_pieces')->get_var(array('id'=>$reg['mclevel2']),'name');
            $lvl['thr'] =  M('cashier_pieces')->get_var(array('id'=>$reg['mclevel3']),'name');
        }
        include $this->showTpl();
    }

    public function showReg () {
        if (!empty($_GET['mid'])) {
            $getdata = $this->clear_html($_GET);
            
            //$this->check($getdata['mid']);
            $merchant = M('cashier_merchants')->get_var(array('mid'=>$getdata['mid']),'company');
            $reg = M('cashier_regist')->get_one(array('mid'=>$getdata['mid']));
            $type = M('cashier_pieces')->get_var(array('id'=>$reg['mclevel3']),'type');
            $lvl['fir'] =  M('cashier_pieces')->get_var(array('id'=>$reg['mclevel1']),'name');
            $lvl['sec'] =  M('cashier_pieces')->get_var(array('id'=>$reg['mclevel2']),'name');
            $lvl['thr'] =  M('cashier_pieces')->get_var(array('id'=>$reg['mclevel3']),'name');
        }
        include $this->showTpl();
    }

    
    public function uploadcertImg () {

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
     // 获取第二级
    public function getSecondLevel () {
        $postdata = $this->clear_html($_POST);
        $list =  M('cashier_pieces')
        ->select(array('fid'=>$postdata['id']),'name,id'); 
        exit(json_encode(array('data'=>$list)));
    }
    // 获取第三级
    public function getThirdLevel() {
        $postdata = $this->clear_html($_POST);
        $list =  M('cashier_pieces')->select(array('fid'=>$postdata['id']),'name,id');
        exit(json_encode(array('data'=>$list)));
    }

    public function getFourthlevel() {
        if (!IS_POST)  return false;
        $postdata = $this->clear_html($_POST);
        $list =  M('cashier_pieces')->select(array('id'=>$postdata['id']),'type,rate,settlement');
        $this->dexit($list);exit;
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
    
    
    public function check ($mid) {
    
        $exist = M('cashier_regist')->get_one(array('mid'=>$mid));
    
        if  (!$exist) {
            $this->errorTip('','?m=User&c=pay&a=go2Regeist&mid='.$mid);
        }
    
    }

    //判断是否为手机
    function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
    }
    
}

?>