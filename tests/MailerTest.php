<?php

namespace thedavidinyang\SimpleMail;

use PHPUnit\Framework\TestCase;


final class MailerTest extends TestCase
{

  

    public function testClassConstructor()
{
    $e = new Mailer;

    $this->assertNotEmpty($e->mail);


} 



public function testinit()
{
    $e = new Mailer;

   $setup =  $e->init(['host' => '', 'username'=>'', 'password'=>'', 'authentication'=>'', 'port'=>''  ]);



    $this->assertNotEmpty($setup);

}
   
}