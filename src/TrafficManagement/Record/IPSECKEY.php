<?php

namespace Dyn\TrafficManagement\Record;

class IPSECKEY extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'IPSECKEY';

    /**
     * Indicates priority among multiple IPSECKEYS. Lower numbers are higher priority
     *
     * @var integer
     */
    protected $precedence;

    /**
     * Gateway type. Must be one of 0, 1, 2, or 3
     *
     * @var integer
     */
    protected $gatetype;

    /**
     * Public key's cryptographic algorithm and format. Must be one of 0, 1, or 2
     *
     * @var integer
     */
    protected $algorithm;

    /**
     * Gateway used to create IPsec tunnel. Based on Gateway type
     *
     * @var string
     */
    protected $gateway;

    /**
     * Base64 encoding of the public key. Whitespace is allowed
     *
     * @var string
     */
    protected $publicKey;


    /**
     * Setter for precedence
     *
     * @param integer $precedence
     */
    public function setPrecedence($precedence)
    {
        $this->precedence = $precedence;

        return $this;
    }

    /**
     * Getter for precedence
     *
     * @return integer
     */
    public function getPrecedence()
    {
        return $this->precedence;
    }

    /**
     * Setter for gate type
     *
     * @param string $gateType
     */
    public function setGateType($gateType)
    {
        $this->gateType = $gateType;

        return $this;
    }

    /**
     * Getter for precedence
     *
     * @return string
     */
    public function getGateType()
    {
        return $this->gateType;
    }

    /**
     * Setter for algorithm
     *
     * @param string $algorithm
     */
    public function setAlgorithm($algorithm)
    {
        $this->precedence = $precedence;

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
     * Setter for gateway
     *
     * @param string $gateway
     */
    public function setGateway($gateway)
    {
        $this->gateway = $gateway;

        return $this;
    }

    /**
     * Getter for gateway
     *
     * @return string
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * Setter for public key
     *
     * @param string $publicKey
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
            'precedence' => $this->getPrecendece(),
            'gatetype' => $this->getGateType(),
            'algorithm' => $this->getAlgorithm(),
            'gateway' => $this->getGateway(),
            'public_key' => $this->getPublicKey()
        );
    }
}
