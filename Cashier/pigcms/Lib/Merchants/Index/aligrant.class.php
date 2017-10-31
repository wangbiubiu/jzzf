<?php
bpBase::loadAppClass('base', '', 0);
class aligrant_controller extends base_controller
{
    public function __construct()
    {
        parent::__construct();
        bpBase::loadOrg('Alipay/AopClient');
        
		$this->aliPayConfig = array('private_key_path' => CMSBASEDIR . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . 'Alipay' . DIRECTORY_SEPARATOR . 'rsa_private_key.pem', 'merchant_rsa_public_key' => CMSBASEDIR . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . 'Alipay' . DIRECTORY_SEPARATOR . 'rsa_public_key.pem', 'input_charset' => 'utf-8', 'ali_public_key_path' => CMSBASEDIR . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . 'Alipay' . DIRECTORY_SEPARATOR . 'alipay_public_key.pem', 'gatewayUrl' => 'https://openapi.alipay.com/gateway.do', 'app_id' => $aliPayConfig['appid'], 'key' => $aliPayConfig['key'], 'name' => $aliPayConfig['name'], 'pid' => $aliPayConfig['pid'], 'sign_type' => 'RSA', 'transport' => 'http', 'cacert' => CMSBASEDIR . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . 'Alipay' . DIRECTORY_SEPARATOR . 'cacert.pem');
    }
    
    /**
     * 支付宝用户第三方授权回调
     */
    public function grant(){
        $getdata = $this->clear_html($_GET);
        //查询商户是否绑定避免重复调用接口
        $alitoken = M('cashier_alitoken')->get_one(array('mid'=>$getdata['mid']),'*');
        if(empty($alitoken)){
            $aop = new AopClient ();
            $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
            $aop->appId = '2016091901928812';
            $aop->rsaPrivateKeyFilePath = $this->aliPayConfig['private_key_path'];
            $aop->alipayPublicKey=$this->aliPayConfig['merchant_rsa_public_key'];
            $aop->apiVersion = '1.0';
            $aop->postCharset='UTF-8';
            $aop->format='json';
            bpBase::loadOrg('Alipay/AlipayOpenAuthTokenAppRequest');
            $request = new AlipayOpenAuthTokenAppRequest();
            $data['grant_type'] = 'authorization_code';
            $data['code'] = $getdata['app_auth_code'];
            $request->setBizContent(json_encode($data));
            $result = $aop->execute ( $request);

            //调用接口成功入库
            if($result['alipay_open_auth_token_app_response']['code'] == '10000' && $result['alipay_open_auth_token_app_response']['msg'] == 'Success'){
                $addalitoken['mid'] = $getdata['mid'];
                $addalitoken['token'] = $result['alipay_open_auth_token_app_response']['app_auth_token'];
                $addalitoken['auth_app_id'] = $result['alipay_open_auth_token_app_response']['auth_app_id'];
                $addalitoken['app_refresh_token'] = $result['alipay_open_auth_token_app_response']['app_refresh_token'];
                $addalitoken['user_id'] = $result['alipay_open_auth_token_app_response']['user_id'];
                $addalitoken['add_time'] = time();
                $add = M('cashier_alitoken')->insert($addalitoken,'id');
                if($add){
                    include $this->showTpl();
                }else{
                    echo "<script>alert('绑定失败')</script>";
                }
            }else{
                echo "<script>alert(".$result['alipay_open_auth_token_app_response']['msg'].")</script>";
            }
        }else{
            echo "<script>alert('该商户已经绑定授权')</script>";
        }
        
    }
    
    
    /**
     * 支付宝验证用户授权信息是否正确
     */
    
    public function serious(){
        if(IS_POST){
            $getdata = $this->clear_html($_POST);
            //查询是否已经入库
            $alitoken = M('cashier_alitoken')->get_one(array('mid'=>$getdata['mid']),'*');
            if(empty($alitoken)){
                $data['app_auth_token'] = $getdata['token'];
                $aop = new AopClient ();
                $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
                $aop->appId = '2016091901928812';
                $aop->rsaPrivateKeyFilePath = $this->aliPayConfig['private_key_path'];;
                $aop->alipayPublicKey=$this->aliPayConfig['merchant_rsa_public_key'];
                $aop->apiVersion = '1.0';
                $aop->postCharset='UTF-8';
                $aop->format='json';
                bpBase::loadOrg('Alipay/AlipayOpenAuthTokenAppQueryRequest');
                $request = new AlipayOpenAuthTokenAppQueryRequest ();
                $request->setBizContent(json_encode($data));
                $result = $aop->execute ( $request);
                if($result['alipay_open_auth_token_app_query_response']['code'] == '10000' && $result['alipay_open_auth_token_app_query_response']['msg'] == 'Success'){
                    //入库
                    $addalitoken['mid'] = $getdata['mid'];
                    $addalitoken['token'] = $getdata['token'];
                    $addalitoken['auth_app_id'] = $result['alipay_open_auth_token_app_query_response']['auth_app_id'];
                    $addalitoken['user_id'] = $result['alipay_open_auth_token_app_query_response']['user_id'];
                    $addalitoken['add_time'] = time();
                    $add = M('cashier_alitoken')->insert($addalitoken,'id');
                    if($add){
                        $msg = array('status'=>1);
                    }else{
                        $msg = array('status'=>2,'msg'=>'授权失败');
                    }
                }else{
                    $msg = array('status'=>2,'msg'=>$result['alipay_open_auth_token_app_query_response']['sub_msg']);
                }
            }else{
                $msg = array('status'=>1);
            }
            exit(json_encode($msg));
        }
    }
    
    
    
    
    
}