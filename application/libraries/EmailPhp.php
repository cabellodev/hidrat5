<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailPhp
{
    private $CI;

	public function __construct() {
		$this->CI =& get_instance();
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
        $mail->Username = 'juanpmartinezromero@gmail.com';
        $mail->Password = 'lolowerty21';
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587;
        
        $mail->setFrom('juanpmartinezromero@gmail.com', 'MRM Ingieneria SPA');
        $mail->addReplyTo('juanpmartinezromero@gmail.com', 'MRM Ingieneria SPA');
        
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
            return false;
        }else{
            return true;
        }
    }

    public function sendCotizacion($email_to,$title,$body, $pdf){

        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';

        $mail = new PHPMailer;
        
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'juanpmartinezromero@gmail.com';
        $mail->Password = 'lolowerty21';
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587;
        
        $mail->setFrom('juanpmartinezromero@gmail.com', 'MRM Ingieneria SPA');
        $mail->addReplyTo('juanpmartinezromero@gmail.com', 'MRM Ingieneria SPA');
        
        // Add a recipient
        $mail->addAddress($email_to);

        // Email subject
        $mail->Subject =$title;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mail->Body = $body;
        $mail->AddAttachment($pdf);
        
        // Send email
        if(!$mail->send()){
            return false;
        }else{
            return true;
        }
    }
}