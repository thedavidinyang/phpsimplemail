<?php

namespace SimpleMail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer 
{
    public $mail;
    private $settings;

    public function __construct()
    {

        $this->mail = new PHPMailer(true);

        $this->settings = Settings::select('option', 'value')->where('option', 'like', 'mail_%')->get();

        $this->settings = $this->reoganise_settings($this->settings);

        // dd($this->settings);

    }

    private function reoganise_settings($v)
    {
        $resultDict = [];

        foreach ($v as $row) {
            $option = $row['option'];
            $value = $row['value'];

            $resultDict[$option] = $value;
        }

        return $resultDict;
    }

    public function init()
    {

        //Server settings
        // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF ;  //Enable verbose debug output
        $this->mail->isSMTP(); //Send using SMTP
        $this->mail->Host = $this->settings['mail_smtp_host']; //Set the SMTP server to send through
        $this->mail->SMTPAuth = true; //Enable SMTP authentication
        $this->mail->Username = $this->settings['mail_smtp_username']; //SMTP username
        $this->mail->Password = $this->settings['mail_smpt_password']; //SMTP password
        $this->mail->SMTPSecure = $this->settings['mail_smtp_auth'];
        // $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $this->mail->Port = $this->settings['mail_smtp_port']; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $this->mail->isHTML(true); //Set email format to HTML
        $this->mail->setFrom($this->settings['mail_from_email'], $this->settings['mail_from_name']);

      

        return $this;

    }

    public function addAttachment($file)
    {
        $this->mail->addAttachment($file);

        return $this;

    }

    public function from(array $v)
    {

        // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'name'  => 'David Inyang'
        // ];

        $this->mail->setFrom($v['email'], $v['name']);

        return $this;
    }

    public function to(array $v)
    {

        // //Recipients
        // $this->mail->addAddress('joe@example.net', 'Joe User'); //Add a recipient
        // $this->mail->addAddress('ellen@example.com'); //Name is optional
        // $this->mail->addReplyTo('info@example.com', 'Information');
        // $this->mail->addCC('cc@example.com');
        // $this->mail->addBCC('bcc@example.com');

        // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'name'  => 'David Inyang'
        // ];

        $this->mail->addAddress($v['email'], $v['name']);

        return $this;

    }

    public function subject($v)
    {

        $this->mail->Subject = $v;

        return $this;

    }

    public function body($v)
    {

        //Content
        $this->mail->Body = $v;
//  $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        return $this;

    }

    public function sendmail()
    {

        // dd($this);

        try {

            $this->mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}
