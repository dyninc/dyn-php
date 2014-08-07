<?php

namespace DynTest\MessageManagement;

use PHPUnit_Framework_TestCase;
use Dyn\MessageManagement\Mail;

class MailTest extends PHPUnit_Framework_TestCase
{
    public function testBasicApiParams()
    {
        $mail = new Mail();
        $mail->setFrom('user@example.com', 'Joe Bloggs')
             ->setTo('janedoe@example.com')
             ->setSubject('Email sent via. Dyn SDK')
             ->setBody('The text of the email');

        $params = $mail->toApiParams();

        $this->assertInternalType('array', $params);
        $this->assertArrayHasKey('from', $params);
        $this->assertArrayHasKey('to', $params);
        $this->assertArrayHasKey('subject', $params);
        $this->assertArrayHasKey('bodytext', $params);
    }

    public function testHTMLEmailApiParams()
    {
        $mail = new Mail();
        $mail->setFrom('user@example.com', 'Joe Bloggs')
             ->setTo('janedoe@example.com')
             ->setSubject('Email sent via. Dyn SDK')
             ->setTextBody('The text of the email')
             ->setHTMLBody('<html><head><title>Email</title></head><body>The text of the HTML email</body></html>');

        $params = $mail->toApiParams();

        $this->assertInternalType('array', $params);
        $this->assertArrayHasKey('from', $params);
        $this->assertArrayHasKey('to', $params);
        $this->assertArrayHasKey('subject', $params);
        $this->assertArrayHasKey('bodytext', $params);
        $this->assertArrayHasKey('bodyhtml', $params);
    }
}
