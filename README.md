Dyn PHP SDK
===========

This SDK allows PHP developers to interact with Dyn's product APIs from within their PHP applications. Feedback is welcome - please reach out via pull request, GitHub issue, or via. our [Community forum](http://www.dyncommunity.com/).

## Requirements

Requires PHP **7.4** or above. The cURL extension is recommended (although not required), and will be used if present.

## Installation

The best way to install this SDK is with [Composer](http://getcomposer.org). With Composer installed, run:

    composer require dyninc/dyn-php

from the command line.

## Quickstart - DNS

```php
use Dyn\TrafficManagement;
use Dyn\TrafficManagement\Record\A;

$tm = new TrafficManagement('customerName', 'username', 'password');

// login
$tm->createSession();

// retrieve zone
$zone = $tm->getZone('example.com');

// configure a new record
$record = new A();
$record->setAddress('127.0.0.1');

// create the new record
$zone->createRecord($record, 'test.example.com');

// publish zone changes
$zone->publish();

// logout
$tm->deleteSession();
```

## Quickstart - Email

```php
use Dyn\MessageManagement;
use Dyn\MessageManagement\Mail;

$mm = new MessageManagement('YOUR API KEY');

// setup the message
$mail = new Mail();
$mail->setFrom('user@example.com', 'Joe Bloggs')
     ->setTo('janedoe@example.com')
     ->setSubject('Email sent via. Dyn SDK')
     ->setBody('The text of the email');

// send it
$mm->send($mail);
```

More detailed examples can be found in the [examples](examples) folder.

# API Endpoints Supported

* Traffic Management - Session API: create/destroy/refresh
* Traffic Management - Record API: AAAA A CERT CNAME DHCID DNSKEY DS IPSECKEY KEY LOC MX NAPTR NS NSAP PTR PX RP SOA SPF SRV SSHFP TXT
* Traffic Management - Zone API: list/get/publish/freeze/thaw/getChanges/discardChanges
* Traffic Management - HTTP Redirect service: create/update/list/destroy
* Traffic Management - Dynamic DNS service: create/update/list/destroy
* Message Management - All endpoints supported

# Testing

With the Composer packages installed, unit tests can be run from this folder using the command:

```
./vendor/bin/phpunit --configuration test/phpunit.xml
```