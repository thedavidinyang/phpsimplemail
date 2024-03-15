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
use PHPMailer\PHPMailer\SMTP;

class Mailer 
{
    public static  $mail;
    private static  $settings;

    private static $setup;

    const VERSION = '1.0';


    public function __construct()
    {

        // $this->mail = new PHPMailer(true);
        static::$mail = new PHPMailer(true);

    }

    private static function smtp_setup(array $v) 
    {
        // $setup = [];
       static::$setup = $v;

        /*

        Setup parameters

        $setup ['host', 'username', 'password', 'authentication', 'port'  ]

        host = smtp host url
        username = smtp username
        password = smtp password
        authentication = SSL or TLS
        port = smtp port




        */

        // foreach ($v as $row) {
        //     $option = $row['option'];
        //     $value = $row['value'];

        //     $setup[$option] = $value;
        // }

        return new static;
    }

    // intialize the mail setup

    public static function init($setup)
    {


        //Server settings
        static::$settings = static::smtp_setup($setup);


        static::$mail->isSMTP(); //Send using SMTP
        static::$mail->Host = static::$settings['host']; //Set the SMTP server to send through
        static::$mail->SMTPAuth = true; //Enable SMTP authentication
        static::$mail->Username = static::$settings['username']; 
        static::$mail->Password = static::$settings['password']; 
        static::$mail->SMTPSecure = static::$settings['authentication'];
        // $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
    static::$mail->Port = static::$settings['port']; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      

        return new static;

    }


    /* 
    set mail format to 
    
    true = html
    false = plain

    */
    
    public static function format(bool $v){

        if($v){

            static::$mail->isHTML(true); //Set email format to HTML

        } else {
            static::$mail->isHTML(true); //Set email format to HTML


        }

        return new static;

    }

    // enable or diable debuging 

    public static function debug(bool $v){

        if($v){
            //Enable verbose debug output
            static::$mail->SMTPDebug = SMTP::DEBUG_SERVER; 

        } else{
            //Disable verbose debug output
            static::$mail->SMTPDebug = SMTP::DEBUG_OFF ;  //Enable verbose debug output

        }

        return new static;


    }

    /// add attatchment

    public static function addAttachment(string $file)
    {
        static::$mail->addAttachment($file);

        return new static;

    }


    /// set sender
    public static function from(array $v)
    {

        // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'name'  => 'David Inyang'
        // ];

        static::$mail->setFrom($v['email'], $v['name']);

        return new static;
    }



    /// set recipient
    public static function to(array $v)
    {

        // //Recipients

        // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'name'  => 'David Inyang'
        // ];

        static::$mail->addAddress($v['email'], $v['name']);

        return new static;

    }


    /// set many recipient
    public static function to_many(array $v)
    {

      

        // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'email'  => 'davidinyang01@gmail.com'
        // ];

        foreach ($v as $e){

            static::$mail->addAddress($v['email']);

        }

        return new static;

    }


    /// set recipient
    public static function reply_to(array $v)
    {

        // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'name'  => 'David Inyang'
        // ];

        static::$mail->addReplyTo($v['email'], $v['name']);

        return new static;

    }

    // add bcc

    public static function bcc(array $v){

          // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'email'  => 'davidinyang01@gmail.com'
        // ];

        foreach ($v as $e){

            static::$mail->addBCC($v['email']);

        }

        return new static;

    }


    // add cc

    public static function cc(array $v){

          // $v = [
        //     'email' => 'davidinyang01@gmail.com',
        //     'email'  => 'davidinyang01@gmail.com'
        // ];

        foreach ($v as $e){

            static::$mail->addCC($v['email']);

        }

        return new static;

    }


    // set subject
    public static function subject(string $v)
    {

        static::$mail->Subject = $v;

        return new static;

    }


// set   mail content
    public static function body(string $v)
    {

        //Content
        static::$mail->Body = $v;


        return new static;

    }


    //set alternate content This is the body in plain text for non-HTML mail clients

    public static function alt_body(string $v){

         //Content
         static::$mail->AltBody = $v;

        return new static;

    }


    /// send email

    public static function sendmail(bool $response = false)
    {


        try {

            static::$mail->send();

            if ($response){
                return true;
            }
        } catch (Exception $e) {

            if ($response){
                return ("Message could not be sent. Mailer Error: ".static::$mail->ErrorInfo);
            }
        }
    }
}
