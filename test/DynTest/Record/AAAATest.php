<?php

namespace DynTest\Record;

use PHPUnit\Framework\TestCase;
use Dyn\TrafficManagement\Record\AAAA;

class AAAATest extends TestCase
{
    public function testRData()
    {
        $a = new AAAA();
        $a->setAddress('0:0:0:0:0:ffff:8600:4c33');

        $expected = array(
            'address' => '0:0:0:0:0:ffff:8600:4c33'
        );

        $this->assertEquals($expected, $a->getRData());
    }

    public function testRDataParsing()
    {
        $rdata = array(
            'address' => '0:0:0:0:0:ffff:8600:4c33'
        );

        $a = new AAAA();
        $a->setRData($rdata);

        $this->assertEquals('0:0:0:0:0:ffff:8600:4c33', $a->getAddress());
    }

    public function testAddressValidation()
    {
        $this->expectException('InvalidArgumentException');

        $a = new AAAA();
        $a->setAddress('134.0.76.51');
    }
}
