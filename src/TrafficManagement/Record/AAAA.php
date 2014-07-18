<?php

namespace Dyn\TrafficManagement\Record;

class AAAA extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'AAAA';

    /**
     * The IP address
     *
     * @var string
     */
    protected $address;


    /**
     * Setter for IP address
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $address = filter_var($address, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV6));
        if ($address === false) {
            throw new \InvalidArgumentException('Invalid IP address supplied for AAAA record');
        }

        $this->address = $address;

        return $this;
    }

    /**
     * Getter for IP address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Setter for RDATA. Parses values into the correct properties
     *
     * @param array $rdata
     */
    public function setRData(array $rdata)
    {
        if (isset($rdata['address'])) {
            $this->setAddress($rdata['address']);
        }

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
            'address' => $this->getAddress()
        );
    }
}
