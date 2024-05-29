PHP SimpleMail 
======
## A full-featured simple php fluent interface for sending html or plaintext emails via smtp



```php
<?php
$e = new Mailer;

$setup = ['host' => '', 'username'=>'', 'password'=>'', 'authentication'=>'', 'port'=>''  ]

$e->init($setup)
->subject('Welcome')
->to(['name' => 'David Inyang', 'email'=>'samplemail@gmail.com'])
->from(['name' => 'David Inyang', 'email'=>'samplemail@gmail.com'])
->body('Hi, welcome to the team')
->sendmail();
```


This is a simple mail interface that makes sending smtp emails extremely easy.

You can send plaintext or html email, and also include attatchements easily from a fluent interface.

It provides all the basic pieces need to craft almost any kind of email.

## Configuration

- host = smtp host url
- username = smtp username
- password = smtp password
- authentication = SSL or TLS
- port = smtp port

## Easy Installation

### Install with composer

To install with [Composer](https://getcomposer.org/), simply require the
latest version of this package.

```bash
composer require thedavidinyang/phpsimplemail
```

Make sure that the autoload file from Composer is loaded.

```php
// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';

```


### Download and install

Download a packaged archive and extract it into the directory where the package will reside

 * You can download stable copies of dompdf from
   https://github.com/thedavidinyang/phpsimplemail/releases


## Quick Start

Just pass your email configuration into PHPSimplemail:

```php
// reference the SimpleMail namespace
use thedavidinyang\SimpleMail\Mailer;

// Setup SMTP Configurations
$setup = ['host' => '', 'username'=>'', 'password'=>'', 'authentication'=>'', 'port'=>''  ]

// initialize and use the SimpleMail class
$e = new Mailer;

$e->init($setup)

// Set mail parameters

// Subject
->subject('Welcome')

// Recipient
->to(['name' => 'David Inyang', 'email'=>'samplemail@gmail.com'])

// Sender
->from(['name' => 'David Inyang', 'email'=>'samplemail@gmail.com'])

// Content
->body('Hi, welcome to the team')

// Send mail
->sendmail();

```