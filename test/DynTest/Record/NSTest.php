<?php

namespace DynTest\Record;

use PHPUnit\Framework\TestCase;
use Dyn\TrafficManagement\Record\NS;

class NSTest extends TestCase
{
    public function testRData()
    {
        $ns = new NS();
        $ns->setNsdname('ns1.pxx.dynect.net');

        $expected = array(
            'nsdname' => 'ns1.pxx.dynect.net'
        );

        $this->assertEquals($expected, $ns->getRData());
    }

    public function testRDataParsing()
    {
        $rdata = array(
            'nsdname' => 'ns1.pxx.dynect.net'
        );

        $ns = new NS();
        $ns->setRData($rdata);

        $this->assertEquals('ns1.pxx.dynect.net', $ns->getNsdname());
    }
}
