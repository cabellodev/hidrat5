<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailer_Lib
{
    private $CI;

	public function __construct() {
		$this->CI =& get_instance();
        $this->CI->load->helper('email');
        log_message('Debug', 'PHPMailer class is loaded.');
	}

    public function load(){
        // Include PHPMailer library files
        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';
        
        $mail = new PHPMailer;
        return $mail;
    }

    public function send($email_to,$title,$body){

        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';

        $mail = new PHPMailer;
        
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'picamaderomuebles@gmail.com';
        $mail->Password = 'Zkb?Wx8.ihxi';
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587;
        
        $mail->setFrom('picamaderomuebles@gmail.com', 'Picamadero');
        $mail->addReplyTo('picamaderomuebles@gmail.com', 'Picamadero');
        
        // Add a recipient
        $mail->addAddress($email_to);

        // Email subject
        $mail->Subject =$title;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mail->Body = $body;
        
        // Send email
        if(!$mail->send()){
            return $mail->ErrorInfo;
        }else{
            return true;
        }
    }

    public function send_recovery($email_to,$name,$codigo){

        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';

        $template = file_get_contents("application/views/admin/recovery_email.php", true);
        $template = str_replace("{{name}}", $name, $template);
        $template = str_replace("{{action_url_2}}", '<b>'.base_url() .'login/recovery/'.$codigo.'</b>', $template);
        $template = str_replace("{{action_url_1}}", base_url() .'login/recovery/'.$codigo, $template);
        $template = str_replace("{{year}}", date('Y'), $template);
        $template = str_replace("{{operating_system}}", get_os(), $template);
        $template = str_replace("{{browser_name}}", get_brow(), $template);
        
    
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";
        
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.googlemail.com';  //gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'servicio@hidratec.cl';   //username
        $mail->Password = 'Ht687364';   //password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465; 
        
        
        $mail->setFrom('servicio@hidratec.cl', 'Sistema recuperación de contraseña Hidratec');
        //$mail->addReplyTo('picamaderomuebles@gmail.com', 'Picamadero');
        
        // Add a recipient
        $mail->addAddress($email_to);

        // Email subject
        $mail->Subject ="Recuperación de contraseña - HIDRATEC";
        
        // Set email format to HTML
        $mail->isHTML();
        
        // Email body content
        $mail->Body = $template;
        $env = 'no';
        $noenv = 'so';
        // Send email
        if(!$mail->send()){
/*             var_dump('error'); */
            return $mail->ErrorInfo;
        }else{
            /* var_dump('si llego'); */
            return true;
        }
    }


    public function send_approve($email_info, $pdf, $emails){
        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';

        $name = $_SESSION['full_name'];
        $email = $_SESSION['email'];

        $template = file_get_contents("application/views/client/approve_email.php", true);
        $template = str_replace("{{ot}}", $email_info[0]['number_ot'], $template);
        $template = str_replace("{{client}}", $name, $template);
        $template = str_replace("{{enterprise}}", $email_info[0]['enterprise'], $template);
        $template = str_replace("{{year}}", date('Y'), $template);
        $template = str_replace("{{operating_system}}", get_os(), $template);
        $template = str_replace("{{browser_name}}", get_brow(), $template);
        
        $mail = new PHPMailer(True);
        $mail->CharSet = "UTF-8";
        
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.googlemail.com';  //gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'servicio@hidratec.cl';   //username
        $mail->Password = 'Ht687364';   //password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465; 
        
        $mail->setFrom('servicio@hidratec.cl', 'Sistema de notificación Hidratec');
        
        // Add a recipient
        for($i=0; $i< count($emails); $i++){
            $mail->addAddress($emails[$i]['email']);
        }
      
        // Email subject
        $mail->Subject ="Aprobación OT ".$email_info[0]['number_ot'];
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        //Email attachment
        $url = 'assets/upload/purshaseOrder/'.$pdf;
        $mail->addAttachment($url,'OrdenCompra'.$email_info[0]['number_ot'].'.pdf');

        // Email body content
        $mail->Body = $template;
        $env = 'no';
        $noenv = 'so';
        // Send email
        if(!$mail->send()){
            return $mail->ErrorInfo;
        }else{
            return true;
        }
    }
}