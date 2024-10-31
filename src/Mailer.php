<?php

/**
 * SimpleMail PHP SMTP email sending interface.
 * PHP Version >= 5.6
 * @see https://github.com/thedavidinyang/simplemail/ The SimpleMail GitHub project
 * @author    David Inyang (@thedavidinyang) <davidinyang01@gmail.com>
 */

namespace thedavidinyang\SimpleMail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\PHPMailerSendGrid;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{
    public $mail;
    private $settings;

    private $type;

    const VERSION = '1.5';

    public function __construct($type)
    {

        $this->type = $type;

        switch ($type) {

            case 'smtp':
                $this->mail = new PHPMailer(true);

                break;
            case 'sendgrid':

                $this->mail = new PHPMailerSendGrid(true);

                break;
        }

    }


    private function smtp_setup(array $v)
    {

        $this->settings = $v;

        /*

        Setup parameters

        $setup ['host', 'username', 'password', 'authentication', 'port'  ]

        host = smtp host url
        username = smtp username
        password = smtp password
        authentication = SSL or TLS
        port = smtp port

         */

       

        $this->mail->isSMTP(); //Send using SMTP
            $this->mail->Host = $this->settings['host']; //Set the SMTP server to send through
            $this->mail->SMTPAuth = true; //Enable SMTP authentication
            $this->mail->Username = $this->settings['username'];
            $this->mail->Password = $this->settings['password'];
            $this->mail->SMTPSecure = $this->settings['authentication'];
            // $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
            $this->mail->Port = $this->settings['port']; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        return $this;
    }


    private function sendGridSetup(String $apiKey){

        $this->mail->isSendGrid();

        $this->mail->SendGridApiKey = $apiKey;

    }

    // intialize the mail setup

    public function init(Array $setup)
    {

        //Server settings

        if ($this->type == 'smtp') {
             $this->smtp_setup($setup);
        }

        if ($this->type == 'sendgrid') {

            $this->sendGridSetup($setup['apiKey']);

        }

        return $this;
    }

    /*
    set mail format to

    true = html
    false = plain

     */

    public function format(bool $v)
    {

        if ($v) {

            $this->mail->isHTML(true); //Set email format to HTML

        } else {
            $this->mail->isHTML(false); //Set email format to HTML

        }

        return $this;

    }

    // enable or diable debuging

    public function debug(bool $v)
    {

        if ($v) {
            //Enable verbose debug output
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;

        } else {
            //Disable verbose debug output
            $this->mail->SMTPDebug = SMTP::DEBUG_OFF; //Enable verbose debug output

        }

        return $this;

    }

    /// add attatchment

    public function addAttachment(string $file)
    {
        $this->mail->addAttachment($file);

        return $this;

    }

    /// set sender
    public function from(array $v)
    {

        // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'name'  => 'David Inyang'
        // ];

        $this->mail->setFrom($v['email'], $v['name']);

        return $this;
    }

    /// set recipient
    public function to(array $v)
    {

        // //Recipients

        // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'name'  => 'David Inyang'
        // ];

        $this->mail->addAddress($v['email'], $v['name']);

        return $this;

    }

    /// set many recipient
    public function to_many(array $v)
    {

        // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'email'  => 'davidinyang01@gmail.com'
        // ];

        foreach ($v as $e) {

            $this->mail->addAddress($v['email']);

        }

        return $this;

    }

    /// set recipient
    public function reply_to(array $v)
    {

        // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'name'  => 'David Inyang'
        // ];

        $this->mail->addReplyTo($v['email'], $v['name']);

        return $this;

    }

    // add bcc

    public function bcc(array $v)
    {

        // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'email'  => 'davidinyang01@gmail.com'
        // ];

        foreach ($v as $e) {

            $this->mail->addBCC($v['email']);

        }

        return $this;

    }

    // add cc

    public function cc(array $v)
    {

        // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'email'  => 'davidinyang01@gmail.com'
        // ];

        foreach ($v as $e) {

            $this->mail->addCC($v['email']);

        }

        return $this;

    }

    // set subject
    public function subject(string $v)
    {

        $this->mail->Subject = $v;

        return $this;

    }

// set   mail content
    public function body(string $v)
    {

        //Content
        $this->mail->Body = $v;

        return $this;

    }

    //set alternate content This is the body in plain text for non-HTML mail clients

    public function alt_body(string $v)
    {

        //Content
        $this->mail->AltBody = $v;

        return $this;

    }

    /// send email

    public function sendmail(bool $response = false)
    {

        try {

            $this->mail->send();

            if ($response) {
                return true;
            }
        } catch (Exception $e) {

            if ($response) {
                return ("Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
            }
        }
    }
}
