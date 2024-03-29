<?php

namespace DynTest\Record;

use PHPUnit\Framework\TestCase;
use Dyn\TrafficManagement\Record\CNAME;

class CNAMETest extends TestCase
{
    public function testRData()
    {
        $cname = new CNAME();
        $cname->setCname('foo.example.com');

        $expected = array(
            'cname' => 'foo.example.com'
        );

        $this->assertEquals($expected, $cname->getRData());
    }

    public function testRDataParsing()
    {
        $rdata = array(
            'cname' => 'bar.example.com'
        );

        $cname = new CNAME();
        $cname->setRData($rdata);

        $this->assertEquals('bar.example.com', $cname->getCname());
    }
}
