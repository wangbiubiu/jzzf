<?php
bpBase::loadAppClass('common', 'Agent', 0);
bpBase::loadOrg('common_page');

class alipieces_controller extends common_controller{
    public function __construct()
    {
        parent::__construct();
    }
    
    
    
    /**
     * 支付宝进件授权
     */
    public function grant(){
        $getdata = $this->clear_html($_GET);
//        var_dump($getdata);die;
        //查询当前商户是否授权，没有显示二维码授权页面

        $merchant = M( 'cashier_merchants')->get_one(array('mid'=>$getdata['mid']), '*');
//        var_dump($merchant);die;


        if($merchant['mtype'] != 1 ){
//            echo  "银行直连或加盟";
            $area = M("cashier_area") -> select("areaParentId = '1'");
            $mid = $_GET['mid'];//商户ID
            $regist = M("cashier_regist") -> get_one("mid = '$mid' AND alipay<> ''","alipay");
            $vo=M("cashier_regist") -> get_one("mid = '$mid' AND alipay<> ''","*");
            $alipay = json_decode($regist['alipay'],true);
            $areaCity = array();//城市
            $districtCode = array();//省份
            if(!empty($regist)){
                $provinceCode = $alipay['provinceCode'];
                $areaCity = M("cashier_area") -> select("areaParentId = '$provinceCode'");
                $registercityCode = $alipay['cityCode'];
                $districtCode = M("cashier_area") -> select("areaParentId = '$registercityCode'");
            }
            $category = M("cashier_alipay_category") -> select("id>0");
            include $this->showTpl('cmbc_alipay');
            die;
        } else {
            $alitoken = M('cashier_alitoken')->get_one(array('mid'=>$getdata['mid']),'*');
            if($alitoken){
                $tpl = 'mandate';
            }else{
                $tpl = 'grant';
                $filename = PIGCMS_TPL_PATH_IMAGE . 'aligrant.png';
                bpBase::loadOrg('phpqrcode');
                new QRimage(400, 400);
                $redirect_url = urlencode($this->SiteUrl . '/merchants.php?m=Index&c=aligrant&a=grant&mid='.$getdata['mid']);//urlencode 编码
                $url = 'http://openauth.alipay.com/oauth2/appToAppAuth.htm?app_id=2016091901928812&redirect_uri='.$redirect_url;//生成专属授权二维码
                $errorCorrectionLevel = 'L';
                $matrixPointSize = 6;
                QRcode::png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
            }
            include $this->showTpl($tpl);
        }
    }
    public function getAreaTreeInfo(){
        $id = $_POST['id']?:$_GET['id'];
        $area = M("cashier_area") -> select("areaParentId = '$id'");
        $this->dexit($area);
    }
}