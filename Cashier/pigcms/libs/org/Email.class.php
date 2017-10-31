<?php
/**
 * 
 * @author 发送邮箱
 *
 */
class Email{
    public $email_data;
    public function __construct()
    {
        $data = M('cashier_key_values')->get_var(array('name'=>'email'),'value');
        $this->email_data = json_decode($data,true);
    }
    
    
    /**
     * 发送邮件
     * @param  string $address 需要发送的邮箱地址 发送给多个地址需要写成数组形式
     * @param  string $subject 标题
     * @param  string $content 内容
     * @return boolean       是否成功
     */
    public function send_email($address,$subject,$content){
        $email_smtp = $this->email_data['email_smtp']; // QQ企业邮箱SMTP服务器地址
        $email_username = $this->email_data['email_username'];//SMTP用户名  注意：普通邮件认证不需要加 @域名，我这里是QQ企业邮箱必须使用全部用户名
        $email_password = $this->email_data['email_password'];//SMTP 密码
        $email_from_name = $this->email_data['email_from_name'];// 发件人
        if(empty($email_smtp) || empty($email_username) || empty($email_password) || empty($email_from_name)){
            return array("error"=>1,"message"=>'邮箱配置不完整');
        }
         
         
       /*  $address = '294287076@qq.com';
        $subject = '测试邮箱';
        $content = '<h1>今天天气真好哈哈哈哈哈！！！</h1>';
          */
         
         
        bpBase::loadOrg('phpmailer/PHPMailer');
        bpBase::loadOrg('phpmailer/SMTP');
        $phpmailer=new PHPMailer();
        // 设置PHPMailer使用SMTP服务器发送Email
        $phpmailer->IsSMTP();
        // 设置为html格式
        $phpmailer->IsHTML(true);
        // 设置邮件的字符编码'
        $phpmailer->CharSet='UTF-8';
        // 设置SMTP服务器。
        $phpmailer->Host=$email_smtp;
        // 设置为"需要验证"
        $phpmailer->SMTPAuth=true;
        // 设置用户名
        $phpmailer->Username=$email_username;
        // 设置密码
        $phpmailer->Password=$email_password;
        // 设置邮件头的From字段。
        $phpmailer->From=$email_username;
        // 设置发件人名字
        $phpmailer->FromName=$email_from_name;
        // 添加收件人地址，可以多次使用来添加多个收件人
        if(is_array($address)){
            foreach($address as $addressv){
                $phpmailer->AddAddress($addressv);
            }
        }else{
            $phpmailer->AddAddress($address);
        }
        // 设置邮件标题
        $phpmailer->Subject=$subject;
        // 设置邮件正文
        $phpmailer->Body=$content;
        // 发送邮件。
        if(!$phpmailer->Send()) {
            $phpmailererror=$phpmailer->ErrorInfo;
            return array("error"=>1,"message"=>$phpmailererror);
        }else{
            return array("error"=>0);
        }
    }
}