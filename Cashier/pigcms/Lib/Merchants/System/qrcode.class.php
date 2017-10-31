<?php

//总后台二维码管理
bpBase::loadAppClass('common', 'System', 0);

class qrcode_controller extends common_controller {

    public function __construct() {
        parent::__construct();
        $this->model = M('cashier_qrcode');
    }
    //二维码生成
    public function index() {
        if (IS_POST) {
            bpBase::loadOrg('phpqrcode');
            new QRimage(400, 400);


            $data = $this->clear_html($_POST);

            $num = intval($data['num']);
            $da = array();
            for ($i = 0; $i < $num; $i++) {
                // $da['qrcode_id'] = date('YmdHis') . substr(SYS_TIME, 2) . mt_rand(11111111, 99999999);
                $da['qrcode_id'] = strtoupper(dechex(date('m'))).date('d').substr(time(), - 1).substr(microtime(), 2, 5).sprintf('%02d',rand(0, 99));

                $data = $this->SiteUrl . '/merchants.php?m=Index&c=pay&a=qrinfo&ewmid=' . $da['qrcode_id'];
                // 生成的文件名
                $filename = './Cashier/upload/qrcode/' . $da['qrcode_id'] . '_shoukuan.png';
                // 纠错级别：L、M、Q、H
                $errorCorrectionLevel = 'L';
                // 点的大小：1到10
                //$matrixPointSize = 6;
                $matrixPointSize = 18;
                Header('Content-type: image/jpeg');
                QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
                $tzpath = './Cashier/upload/qrcode/' . $da['qrcode_id'] . '_tongzhi.png';
                $url = $this->SiteUrl . '/merchants.php?m=Index&c=pay&a=notice&ewmid=' . $da['qrcode_id'];
                // $matrixPointSize = 2;
                $matrixPointSize = 6;
                QRcode::png($url, $tzpath, $errorCorrectionLevel, $matrixPointSize, 2);
                //支付二维码模版url
                $pay_img_url = M('cashier_key_values')->get_one(array('name'=>'Paytwodimensionalcode'),'value');
                //通知二维码模版url
                $notice_img_url = M('cashier_key_values')->get_one(array('name'=>'Notificationtwodimensionalcode'),'value');

                //支付二维码模版
                $bigImgPath = $this->SiteUrl .$pay_img_url['value'];
                //$filename = $this->WatermarkImg($bigImgPath,$filename,90,135);
                $filename = $this->WatermarkImg($bigImgPath,$filename,270,405);
                //添加水印
                $filenames = $this->WatermarkImgs($filename,'台卡编号:'.$da['qrcode_id'],0,50);
                $da['payment_qrcode'] = $filename;


                //通知二维码
                $bigImgPath_notice = $this->SiteUrl .$notice_img_url['value'];
                //$tzpath = $this->WatermarkImg($bigImgPath_notice,$tzpath,100,28);
                $tzpath = $this->WatermarkImg($bigImgPath_notice,$tzpath,335,238);
                $filenames = $this->WatermarkImgs2($tzpath,'台卡编号:'.$da['qrcode_id'],0,50);
                $da['payment_qrcode'] = $filename;
                $da['notice_qrcode'] = $tzpath;
                $re = $this->model->insert($da, 1);
            }
            if ($re) {
                $this->dexit(array('errcode' => 1, '生成二维码成功!'));
            } else {
                $this->dexit(array('errcode' => 0, '生成二维码失败!'));
            }
        } else {
            $getdata = $this->clear_html($_GET);
            if ($getdata['ewmid']) {
                $where = " qrcode_id='" . $getdata['ewmid'] . "'";
            } else {
                if ($getdata['start']) {
                    $where = ' id>=' . $getdata['start'];
                    if ($getdata['end']) {
                        $where.=' AND id<=' . $getdata['end'];
                    }
                } else {
                    if ($getdata['end']) {
                        $where.=' id<=' . $getdata['end'];
                    }
                }
            }

            bpBase::loadOrg('common_page');

            $_count = $this->model->count($where);

            $p = new Page($_count, 15);
            $pagebar = $p->show(2);
            $m_model = M('cashier_merchants');
            $rows = $this->model->select($where, '*',"$p->firstRow,$p->listRows",'id desc');
            foreach ($rows as &$v) {
                if ($v['mid'] != 0) {
                    $v['username'] = $m_model->get_one('mid=' . $v['mid'], 'company');
                }
                $v['sk_name'] = substr($v['payment_qrcode'], strrpos($v['payment_qrcode'], '/') + 1);
                $v['tz_name'] = substr($v['notice_qrcode'], strrpos($v['notice_qrcode'], '/') + 1);
            }

            $this->assign('rows', $rows);
            $this->assign('pagebar', $pagebar);
            $this->display();
        }
    }

    public function Unbundling() {
        $id = $this->clear_html($_POST);
        $eid = $this->model->get_one('id=' . $id['id'], 'eid');

        $re = $this->model->update(array('mid' => 0, 'eid' => 0, 'storesid' => 0, 'status' => 0), 'id=' . $id['id']);
        $result = M('cashier_employee')->update(array('openid' => ''), 'eid=' . $eid['eid']);

        if ($re && $result) {
            $this->dexit(array('code' => 1, 'msg' => '解绑成功'));
        } else {
            $this->dexit(array('code' => 0, 'msg' => '解绑失败'));
        }
    }
    public function onedown(){
        $data = $_GET;
        $sk = $data['sk'];
        $tz = $data['tz'];
        $pic_path = $this->SiteUrl.'/Cashier/upload/qrcode';

        $filename = './QrCodeDownload.zip';
        $zip = new \ZipArchive();
        $zip->open($filename, ZipArchive::OVERWRITE);
        $zip->addEmptyDir('shoukuan'); //增加一个目录的原因是，如果zip包没东西会一直下载，永不停止
        $zip->addEmptyDir('tongzhi');
        $fileData = file_get_contents($pic_path . '/'  . $sk);
        if ($fileData) {
            $zip->addFromString('shoukuan/' . $sk, $fileData);
        }
        $fileData1 = file_get_contents($pic_path . '/'  . $tz);
        if ($fileData1) {
            $zip->addFromString('tongzhi/' . $tz, $fileData1);
        }
        $zip->close();
        //打开文件
        $file = fopen($filename, "r");
        //返回的文件类型
        Header("Content-type: application/octet-stream");
        //按照字节大小返回
        Header("Accept-Ranges: bytes");
        //返回文件的大小
        Header("Accept-Length: " . filesize($filename));
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
    public function qrcodeDow() {

        $data = $_POST;
        $shoukuan = explode(',',$data['sk']);
        $tongzhi = explode(',',$data['tz']);

        $pic_path = $this->SiteUrl.'/Cashier/upload/qrcode';

        $filename = './QrCodeDownload.zip';
        $zip = new ZipArchive();
        $zip->open($filename, ZipArchive::OVERWRITE);
        $zip->addEmptyDir('shoukuan'); //增加一个目录的原因是，如果zip包没东西会一直下载，永不停止
        $zip->addEmptyDir('tongzhi');
        foreach ($shoukuan as $value) {
            $fileData = file_get_contents($pic_path . '/'  . $value);
            if ($fileData) {
                $zip->addFromString('shoukuan/' . $value, $fileData);
            }
        }
        foreach ($tongzhi as $value) {
            $fileData1 = file_get_contents($pic_path . '/'  . $value);
            if ($fileData1) {
                $zip->addFromString('tongzhi/' . $value, $fileData1);
            }
        }
        $zip->close();
        //打开文件
        $file = fopen($filename, "r");
        //返回的文件类型
        Header("Content-type: application/octet-stream");
        //按照字节大小返回
        Header("Accept-Ranges: bytes");
        //返回文件的大小
        Header("Accept-Length: " . filesize($filename));
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



    /**
     * 图片添加水印二维码
     * $bigImgPath 原图路径
     * $qCodePath 二维码图路径
     */
    public function WatermarkImg($bigImgPath,$qCodePath,$x,$y){

        $bigImg = imagecreatefromstring(file_get_contents($bigImgPath));
        chmod($qCodePath,0755);
        $qCodeImg = imagecreatefromstring(file_get_contents($qCodePath));
        list($qCodeWidth, $qCodeHight, $qCodeType) = getimagesize($qCodePath);
        //imagecopymerge() 函数用于拷贝并合并图像的一部分，成功返回 TRUE ，否则返回 FALSE 。
        if(imagecopymerge($bigImg, $qCodeImg, $x, $y, 0, 0, $qCodeWidth, $qCodeHight, 100)){
            list($bigWidth, $bigHight, $bigType) = getimagesize($bigImgPath);

            //保存文件
            switch ($bigType) {
                case 1: //gif
                    header('Content-Type:image/gif');
                    imagegif($bigImg,$qCodePath);
                    break;
                case 2: //jpg
                    header('Content-Type:image/jpg');
                    imagejpeg($bigImg,$qCodePath);
                    break;
                case 3: //jpg
                    header('Content-Type:image/png');
                    imagepng($bigImg,$qCodePath);
                    break;
                default:

                    break;
            }
            return $qCodePath;
        }else{
            return false;
        }

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








    /**
     *
     * @param string $dst_path 水印图片路劲
     * @param string $contents 水印内容
     * 添加水印
     */
    public function WatermarkImgs2($dst_path,$contents){

        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        //打上文字
//        $font =dirname(__FILE__).'/simsun.ttc';//字体
        $font =dirname(__FILE__).'/msyh.ttf';//字体
        $black = imagecolorallocate($dst,255,255,255);//字体颜色
        //输出图片
        // if(imagefttext($dst, 13, 0, 121, 380, $black, $font, $contents)){
        if(imagefttext($dst, 16, 0, 942, 560, $black, $font, $contents)){
            list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
            switch ($dst_type) {
                case 1://GIF
                    header('Content-Type: image/gif');
                    imagegif($dst,$dst_path);
                    break;
                case 2://JPG
                    header('Content-Type: image/jpeg');
                    imagejpeg($dst,$dst_path);
                    break;
                case 3://PNG
                    header('Content-Type: image/png');
                    imagepng($dst,$dst_path);
                    break;
                default:
                    break;
            }
            return $dst_path;
        }else{
            return false;
        }


    }


    /**
     *
     * @param string $dst_path 水印图片路劲
     * @param string $contents 水印内容
     * 添加水印
     */
    public function WatermarkImgs($dst_path,$contents){

        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        //打上文字
        $font =dirname(__FILE__).'/simsun.ttc';//字体
//        $font =dirname(__FILE__).'/msyh.ttf';//字体 微软雅黑
        $black = imagecolorallocate($dst, 0x00, 0x00, 0x00);//字体颜色
        //输出图片
        // if(imagefttext($dst, 13, 0, 121, 380, $black, $font, $contents)){
        if(imagefttext($dst, 39, 0, 345, 1140, $black, $font, $contents)){
            list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
            switch ($dst_type) {
                case 1://GIF
                    header('Content-Type: image/gif');
                    imagegif($dst,$dst_path);
                    break;
                case 2://JPG
                    header('Content-Type: image/jpeg');
                    imagejpeg($dst,$dst_path);
                    break;
                case 3://PNG
                    header('Content-Type: image/png');
                    imagepng($dst,$dst_path);
                    break;
                default:
                    break;
            }
            return $dst_path;
        }else{
            return false;
        }


    }




}

?>
