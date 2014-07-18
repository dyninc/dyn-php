<?php

namespace Dyn\TrafficManagement\Record;

class DHCID extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'DHCID';

    /**
     * @var string
     */
    protected $digest;


    /**
     * Setter for digest
     *
     * @param string $digest
     */
    public function setDigest($digest)
    {
        $this->digest = $digest;

        return $this;
    }

    /**
     * Getter for digest
     *
     * @return string
     */
    public function getDigest()
    {
        return $this->digest;
    }

    /**
     * Setter for RDATA. Parses values into the correct properties
     *
     * @param array $rdata
     */
    public function setRData(array $rdata)
    {
        // TODO

        return $this;
    }

    /**
     * Getter for RDATA
     *
     * @return array
     */
    public function getRData()
    {
        return array(
            'digest' => $this->getDigest()
        );
    }
}
