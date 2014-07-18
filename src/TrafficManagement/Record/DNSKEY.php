<?php

namespace Dyn\TrafficManagement\Record;

class DNSKEY extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'DNSKEY';

    /**
     * @var string
     */
    protected $algorithm;

    /**
     * @var string
     */
    protected $flags;

    /**
     * @var string
     */
    protected $protocol;

    /**
     * @var string
     */
    protected $publicKey;


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
     * Setter for flags
     *
     * @param string $flags
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * Getter for flags
     *
     * @return string
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Setter for algorithm
     *
     * @param string $algorithm
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * Getter for protocol
     *
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * Setter for algorithm
     *
     * @param string $algorithm
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * Getter for public key
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
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
            'flags' => $this->getFlags(),
            'protocol' => $this->getProtocol(),
            'public_key' => $this->getPublicKey()
        );
    }
}
