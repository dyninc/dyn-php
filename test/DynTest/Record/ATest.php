<?php

namespace DynTest\Record;

use PHPUnit_Framework_TestCase;
use Dyn\TrafficManagement\Record\A;

class ATest extends PHPUnit_Framework_TestCase
{
    public function testRData()
    {
        $a = new A();
        $a->setAddress('134.0.76.51');

        $expected = array(
            'address' => '134.0.76.51'
        );

        $this->assertEquals($expected, $a->getRData());
    }

    public function testRDataParsing()
    {
        $rdata = array(
            'address' => '134.0.76.51'
        );

        $a = new A();
        $a->setRData($rdata);

        $this->assertEquals('134.0.76.51', $a->getAddress());
    }

    public function testAddressValidation()
    {
        $this->setExpectedException('InvalidArgumentException');

        $a = new A();
        $a->setAddress('0:0:0:0:0:ffff:8600:4c33');
    }
}
