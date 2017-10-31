<?php

bpBase::loadAppClass('common', 'Salesman', 0);

class pay_controller extends common_controller {

    private $payConfigDb;
    public $sid;

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

        $this->sid = $_SESSION['my_Cashier_Salesman']['sid'];
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

            /*             * ********处理星************ */
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

    public function bankConfig() {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $updatas = array('phone' => $data['phone'], 'banktruename' => $data['banktruename'],
                'bankname' => $data['bankname'], 'identitycode' => $data['identitycode'], 'bankcardnum' => $data['bankcardnum']
            );
            $cashier_bankDb = M('cashier_bank');
            $bankArr = $cashier_bankDb->get_one(array('mid' => $this->mid), '*');
            if (empty($bankArr)) {
                $updatas['mid'] = $this->mid;
                if ($cashier_bankDb->insert($updatas, true)) {
                    $this->dexit(array('error' => 0));
                } else {
                    $this->dexit(array('error' => 1, 'msg' => '保存失败了！'));
                }
            } else {
                if ($cashier_bankDb->update($updatas, array('id' => $bankArr['id'], 'mid' => $this->mid))) {
                    $this->dexit(array('error' => 0));
                } else {
                    $this->dexit(array('error' => 1, 'msg' => '保存失败！'));
                }
            }
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
    
    //修改密码
    public function ModifyPwd()
	{
		$phone = '';

		if ($this->merchant['phone']) {
			$phone = str_replace(substr($this->merchant['phone'], 3, 4), '****', $this->merchant['phone']);
		}


		$sms_config = loadConfig('sms');
                
		include $this->showTpl();
	}
	
	/**
	 * 业务员帐号设置
	 */
	public function SetAccount(){

       
        $saler = M('cashier_salesmans')->get_one(array('id'=>$this->sid),'id,account,salt,commission,phone,username');
	    include $this->showTpl();
	}
	

    public function setMyself () {
        $saler = M('cashier_salesmans')->get_one(array('id'=>$this->sid),'*');

        if  (IS_POST) {
           $postdata =  $this->clear_html($_POST);

           if(!isEmail($postdata['account']) ){
                $this->errorTip('不是有效的邮箱账号');

           }

           if(!isMobile($postdata['phone']) ){
                $this->errorTip('不是有效的手机号');

           }
           $result = M('cashier_salesmans')->update($postdata,array('id'=>$this->sid));

           if ($result) {
            $this->successTip('修改成功');
           }


        }
 
        include $this->showTpl();
    }
	

}

?>