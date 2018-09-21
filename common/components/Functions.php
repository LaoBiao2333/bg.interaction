<?php
/**
 * 邮件发送函数
 * @param  string $to      邮件接收者
 * @param  string $from    邮件发送者
 * @param  string $content 邮件内容
 * @return 无
 */
function sendMail($to, $from, $content,$title){
    /*
     * sina 邮箱测试：smtp.sina.com
     * username: gogery@sina.com
     * password: php1234
    */

    /*
     * sohu 邮箱测试：smtp.sohu.com
     * username: gogery@sohu.com
     * password: php1234
    */

    header("Content-type:text/html;charset=utf-8");
    //引入邮件类
    require_once 'PHPMailer/class.phpmailer.php';

    $mail = new PHPMailer();

    /*服务器相关信息*/
    $mail->IsSMTP();    //设置使用SMTP服务器发送
    $mail->SMTPAuth   = true;     //开启SMTP认证
    $mail->Host       = 'smtp.sina.com';    //设置 SMTP 服务器,自己注册邮箱服务器地址
    $mail->Username   = 'gogery@sina.com';  //发信人的邮箱用户名
    $mail->Password   = 'php1234';  //发信人的邮箱密码

    /*内容信息*/
    $mail->IsHTML(true); 	//指定邮件内容格式为：html
    $mail->CharSet    ="UTF-8";	//编码
    $mail->From       = 'gogery@sina.com';	 //发件人完整的邮箱名称
    $mail->FromName   = $from;	//发信人署名
    $mail->Subject    = $title;  	 //信的标题
    $mail->MsgHTML( $content );  	//发信主体内容
//		$mail->AddAttachment("./img/linux.png"); //附件

    //发送邮件
    $mail->AddAddress( $to );  //收件人地址

    //使用send函数进行发送
    if( $mail->Send() ) {

        // echo '1';
        // return true;
    } else {
        //如果发送失败，则返回错误提示
        echo $mail->ErrorInfo;
//                return $mail->ErrorInfo;
    }

}
// $content = "恭喜您注册成功，点击该链接跳转即可完成激活<a href='http://www.12.com'>激活</a>";

//sendMail('2298535141@qq.com','asion', $content);
?>