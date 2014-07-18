<?php

namespace Dyn\TrafficManagement\Record;

class CERT extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'CERT';

    /**
     * Numeric value for the certificate type
     *
     * @var integer
     */
    protected $format;

    /**
     * Numeric value for the public key certificate
     *
     * @var integer
     */
    protected $tag;

    /**
     * Public key algorithm number used to generate the certificate.
     *
     * @var string
     */
    protected $algorithm;

    /**
     * The public key certificate
     *
     * @var string
     */
    protected $certificate;


    /**
     * Setter for format
     *
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Getter for format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Setter for tag
     *
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Getter for tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

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
     * Setter for certificate
     *
     * @param string $certificate
     */
    public function setCertificate($certificate)
    {
        $this->certificate = $certificate;

        return $this;
    }

    /**
     * Getter for certificate
     *
     * @return string
     */
    public function getCertificate()
    {
        return $this->certificate;
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
            'format' => $this->getFormat(),
            'tag' => $this->getTag(),
            'algorithm' => $this->getAlgorithm(),
            'certificate' => $this->getCertificate()
        );
    }
}
