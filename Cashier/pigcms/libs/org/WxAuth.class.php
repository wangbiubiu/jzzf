<?php
/**
 * 
 * @author 微信模版消息类
 *
 */
class WxAuth{
    
    public $appId;
    
    public $appSecret;
    
    
    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }
    
    /**
     * 发送模板消息
     * @param string $openid 接受者openid
     * @param string $template_id 消息模板id
     * @param array $data 参数
     * @param string $url 点击模板消息，跳转页面
     * @param string $topcolor 模板消息背景颜色
     * @return boolean
     */
    public function sendTemplateMessage($openid,$template_id,$data,$url='',$topcolor='#FF0000'){
        $params=array(
            'touser'=>$openid,
            'template_id'=>$template_id,
            'url'=>$url,
            'topcolor'=>$topcolor,
            'data'=>$data
        );
        $accessToken=$this->getAccessToken();
        $json_str=json_encode($params);
        $result=$this->http_post('https://api.weixin.qq.com/cgi-bin/message/template/send?'.'access_token='.$accessToken,$json_str);
        $message=json_decode($result,true);
        return $message;
        if($message['errcode']==0){
            return true;
        }
        return false;
    }
    
    
    /**
     * 获取AccessToken
     *
     * @return boolean|unknown
     */
    public function getAccessToken()
    {
        $AccessToken_value = M('cashier_key_values')->get_one(array('name'=>'AccessTokenExpiredTime'));
    
        if ($AccessToken_value['time'] < time()) {
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $this->appId . '&secret=' .$this->appSecret;
            $result = $this->http_get($url);
            // 判断是否获取access_token
            if ($result) {
                $json = json_decode($result, true);
                $AccessToken = $json['access_token'];
                if ($AccessToken) {
                    $data['value'] = $AccessToken;
                    // $data['time'] = date('Y-m-d H:i:s',time()+ 30 * 60);
                    M('cashier_key_values')->update(array('time'=>time() + 30*60,'value'=>$data['value']),array('name'=>'AccessTokenExpiredTime'));
                    return $AccessToken;
                } else {
                    return false;
                }
            }
        } else {
            return $AccessToken_value['value'];
        }
    }
    
    /**
     * GET 请求
     *
     * @param string $url
     */
    private function http_get($url)
    {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }
    /**
     * POST 请求
     *
     * @param string $url
     * @param array $param
     * @param boolean $post_file
     *        	是否文件上传
     * @return string content
     */
    private function http_post($url, $param, $post_file = false) {
        $oCurl = curl_init ();
        if (stripos ( $url, "https://" ) !== FALSE) {
            curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYPEER, FALSE );
            curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYHOST, false );
            curl_setopt ( $oCurl, CURLOPT_SSLVERSION, 1 ); // CURL_SSLVERSION_TLSv1
        }
        if (is_string ( $param ) || $post_file) {
            $strPOST = $param;
        } else {
            $aPOST = array ();
            foreach ( $param as $key => $val ) {
                $aPOST [] = $key . "=" . urlencode ( $val );
            }
            $strPOST = join ( "&", $aPOST );
        }
        curl_setopt ( $oCurl, CURLOPT_URL, $url );
        curl_setopt ( $oCurl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $oCurl, CURLOPT_POST, true );
        curl_setopt ( $oCurl, CURLOPT_POSTFIELDS, $strPOST );
        $sContent = curl_exec ( $oCurl );
        $aStatus = curl_getinfo ( $oCurl );
        curl_close ( $oCurl );
        if (intval ( $aStatus ["http_code"] ) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }
    
    
    
    
}