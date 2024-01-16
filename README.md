# SimpleMail 
======
## A full-featured simple php fluent interface for sending html or plaintext emails via smtp



```php
<?php
$e = new Mailer;

 $setup = ['host' => '', 'username'=>'', 'password'=>'', 'authentication'=>'', 'port'=>''  ]

$e->init($setup)->subject('Welcome')
->to(['name' => 'David Inyang', 'email'=>'davidinyang01@gmail.com'])
->from(['name' => 'David Inyang', 'email'=>'davidinyang01@gmail.com'])
->body('Hi, welcome to the team')
->sendmail()
```


This is a simple mail interface that makes sending smtp emails extremely easy usisng PHPMailer in the background.

You can send plaintext or html email, and also include attatchements easily from a fluent interface.

It provides all the basic pieces need to craft almost any kind of email.

## Configuration

- host = smtp host url
- username = smtp username
- password = smtp password
- authentication = SSL or TLS
- port = smtp port