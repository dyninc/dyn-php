<?php

namespace Dyn\TrafficManagement\Record;

class DS extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'DS';

    /**
     * @var string
     */
    protected $algorithm;

    /**
     * @var string
     */
    protected $digest;

    /**
     * @var string
     */
    protected $digtype;

    /**
     * @var string
     */
    protected $keytag;

    /**
     * Setter for algorithm
     *
     * @param string $algorithm
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    /**
     * Getter for algorithm
     *
     * @return string
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

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
     * Setter for digtype
     *
     * @param string $digtype
     */
    public function setDigtype($digtype)
    {
        $this->digtype = $digtype;

        return $this;
    }

    /**
     * Getter for digtype
     *
     * @return string
     */
    public function getDigtype()
    {
        return $this->digtype;
    }

    /**
     * Setter for keytag
     *
     * @param string $keytag
     */
    public function setKeytag($keytag)
    {
        $this->keytag = $keytag;

        return $this;
    }

    /**
     * Getter for keytag
     *
     * @return string
     */
    public function getKeytag()
    {
        return $this->keytag;
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
            'algorithm' => $this->getAlgorithm(),
            'digest' => $this->getDigest(),
            'digtype' => $this->getDigtype(),
            'keytag' => $this->getKeytag()
        );
    }
}
