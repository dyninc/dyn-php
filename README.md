Dyn PHP SDK
===========

NOTE: This is a developer preview - we welcome your feedback! Please reach out via pull request, GitHub issue, or via. our [Community forum](http://www.dyncommunity.com/)

## Requirements

This SDK requires PHP 5.3.23 or above. The cURL extension is recommended (and will be used if present), although not required.

## Installation

The best way to install the module is with Composer (http://getcomposer.org). Add this to your `composer.json`:

    "require": {
        "dyninc/dyn-php": "0.1.0"
    }

then run `composer install` to install the SDK and its dependencies.

## Quickstart

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
$record->setFqdn('test.example.com')
       ->setAddress('127.0.0.1');

// create the new record
$zone->createRecord($record);

// publish zone changes
$zone->publish();

// logout
$tm->deleteSession();
```

More detailed examples can be found in the `examples` folder.

# API Endpoints Supported

* Traffic Management - Session API: create/destroy/refresh
* Traffic Management - Record API: AAAA A CERT CNAME DHCID DNSKEY DS IPSECKEY KEY LOC MX NAPTR NS NSAP PTR PX RP SOA SPF SRV SSHFP TXT
* Traffic Management - Zone API: list/get/publish/freeze/thaw/getChanges/discardChanges
