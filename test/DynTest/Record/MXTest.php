<?php

namespace DynTest\Record;

use PHPUnit_Framework_TestCase;
use Dyn\TrafficManagement\Record\MX;

class MXTest extends PHPUnit_Framework_TestCase
{
    public function testRData()
    {
        $mx = new MX();
        $mx->setExchange('mail.example.com');
        $mx->setPreference(10);

        $expected = array(
            'exchange' => 'mail.example.com',
            'preference' => 10
        );

        $this->assertEquals($expected, $mx->getRData());
    }

    public function testRDataParsing()
    {
        $rdata = array(
            'exchange' => 'mail.example.com',
            'preference' => 10
        );

        $mx = new MX();
        $mx->setRData($rdata);

        $this->assertEquals('mail.example.com', $mx->getExchange());
        $this->assertEquals(10, $mx->getPreference());
    }
}
