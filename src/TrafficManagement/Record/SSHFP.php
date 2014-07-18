<?php

namespace Dyn\TrafficManagement\Record;

class SSHFP extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'SSHFP';

    /**
     * The number associated with the algorithm being used, valid values:
     *   1 - RSA
     *   2 - DSS
     *
     * @var integer
     */
    protected $algorithm;

    /**
     * The number associated with the fingerprint type being used, valid values:
     *   1 - SHA-1
     *
     * @var integer
     */
    protected $fptype;

    /**
     * SSH key footprint
     *
     * @var string
     */
    protected $fingerprint;


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
            'fptype' => $this->getFptype(),
            'fingerprint' => $this->getFingerprint()
        );
    }
}
