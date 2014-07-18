<?php

namespace Dyn\TrafficManagement\Record;

class NSAP extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'NSAP';

    /**
     * Hex-encoded NSAP identifier
     *
     * @var string
     */
    protected $nsap;


    /**
     * Setter for nsap
     *
     * @param string $nsap
     */
    public function setNsap($nsap)
    {
        $this->nsap = $nsap;

        return $this;
    }

    /**
     * Getter for nsap
     *
     * @return string
     */
    public function getNsap()
    {
        return $this->nsap;
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
            'nsap' => $this->getNsap()
        );
    }
}
